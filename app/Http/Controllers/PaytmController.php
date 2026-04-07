<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use paytm\paytmchecksum\PaytmChecksum;

class PaytmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Initiate Paytm Payment
     */
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:subscription_packages,id',
        ]);

        $package = SubscriptionPackage::findOrFail($request->package_id);
        $user = Auth::user();
        
        // Generate unique order ID
        $orderId = 'ORDER_' . time() . '_' . $user->id;
        $amount = $package->price;
        
        // Check if test mode is enabled
        if (config('services.paytm.test_mode', false)) {
            // Save test payment record
            PaymentHistory::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'order_id' => $orderId,
                'amount' => $amount,
                'payment_method' => 'paytm',
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'test_mode' => true,
                'order_id' => $orderId,
                'amount' => $amount,
                'callback_url' => route('paytm.callback'),
            ]);
        }
        
        // Save initial payment record
        PaymentHistory::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'order_id' => $orderId,
            'amount' => $amount,
            'payment_method' => 'paytm',
            'status' => 'pending',
        ]);

        // Paytm configuration
        $paytmParams = [
            'MID' => config('services.paytm.merchant_id'),
            'WEBSITE' => config('services.paytm.website'),
            'CHANNEL_ID' => 'WEB',
            'INDUSTRY_TYPE_ID' => config('services.paytm.industry_type'),
            'ORDER_ID' => $orderId,
            'CUST_ID' => 'CUST_' . $user->id,
            'MOBILE_NO' => $user->mobile ?? '9999999999',
            'EMAIL' => $user->email ?? 'test@example.com',
            'TXN_AMOUNT' => $amount,
            'CALLBACK_URL' => route('paytm.callback'),
        ];

        // Generate checksum
        $checksum = PaytmChecksum::generateSignature($paytmParams, config('services.paytm.merchant_key'));

        // Use correct Paytm endpoints based on environment
        $environment = config('services.paytm.environment', 'production');
        
        if ($environment === 'staging') {
            $paytm_url = 'https://securegw-stage.paytm.in/order/process';
            $txn_status_url = 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
        } else {
            $paytm_url = 'https://secure.paytmpayments.com/order/process';
            $txn_status_url = 'https://secure.paytmpayments.com/merchant-status/getTxnStatus';
        }

        return response()->json([
            'success' => true,
            'paytmParams' => $paytmParams,
            'checksum' => $checksum,
            'paytm_url' => $paytm_url,
        ]);
    }

    /**
     * Test Payment - Simulate a successful payment (for development)
     */
    public function testPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|in:success,failure',
        ]);

        $payment = PaymentHistory::where('order_id', $request->order_id)
                                ->where('user_id', Auth::id())
                                ->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        if ($request->status === 'success') {
            // Simulate successful payment
            $payment->update([
                'transaction_id' => 'TEST_TXN_' . time(),
                'status' => 'completed',
                'response_data' => json_encode(['STATUS' => 'TXN_SUCCESS', 'TEST' => true]),
            ]);

            // Update user subscription validity
            $user = $payment->user;
            $currentValidity = $user->validity ? \Carbon\Carbon::parse($user->validity) : now();
            $newValidity = $currentValidity->addMonths($payment->package->duration);
            $user->update(['validity' => $newValidity]);

            return response()->json([
                'success' => true,
                'message' => 'Test payment completed successfully',
                'redirect' => $payment->user->role === 'employee' ? route('employee.dashboard') : route('employer.dashboard'),
            ]);
        } else {
            // Simulate failed payment
            $payment->update([
                'transaction_id' => 'TEST_TXN_' . time(),
                'status' => 'failed',
                'response_data' => json_encode(['STATUS' => 'TXN_FAILURE', 'TEST' => true]),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Test payment failed',
            ]);
        }
    }

    /**
     * Handle Paytm Callback
     */
    public function handleCallback(Request $request)
    {
        $paytmChecksum = $request->get('CHECKSUMHASH');
        $paytmParams = $request->except(['CHECKSUMHASH']);
        
        // Handle test mode callback
        if (isset($paytmParams['TEST']) && $paytmParams['TEST'] === true) {
            return $this->handleTestCallback($paytmParams);
        }
        
        // Verify checksum
        $isVerifySignature = PaytmChecksum::verifySignature($paytmParams, config('services.paytm.merchant_key'), $paytmChecksum);
        
        if (!$isVerifySignature) {
            Log::error('Paytm checksum verification failed', ['params' => $paytmParams]);
            return redirect()->route('subscription.packages')->with('error', 'Payment verification failed. Please contact support.');
        }

        return $this->processPaymentResponse($paytmParams);
    }

    /**
     * Handle test callback
     */
    private function handleTestCallback($params)
    {
        $orderId = $params['ORDERID'];
        $payment = PaymentHistory::where('order_id', $orderId)->first();

        if (!$payment) {
            return redirect()->route('subscription.packages')->with('error', 'Payment record not found.');
        }

        if ($params['STATUS'] === 'TXN_SUCCESS') {
            $payment->update([
                'transaction_id' => $params['TXNID'] ?? 'TEST_TXN',
                'status' => 'completed',
                'response_data' => json_encode($params),
            ]);

            // Update user subscription validity
            $user = $payment->user;
            $currentValidity = $user->validity ? \Carbon\Carbon::parse($user->validity) : now();
            $newValidity = $currentValidity->addMonths($payment->package->duration);
            $user->update(['validity' => $newValidity]);

            $dashboardRoute = $payment->user->role === 'employee' ? 'employee.dashboard' : 'employer.dashboard';
            return redirect()->route($dashboardRoute)->with('success', 'Payment successful! Your subscription has been activated.');
        }

            return redirect()->back()->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Process payment response
     */
    private function processPaymentResponse($paytmParams)
    {
        $orderId = $paytmParams['ORDERID'];
        $payment = PaymentHistory::where('order_id', $orderId)->first();

        if (!$payment) {
            Log::error('Payment record not found', ['order_id' => $orderId]);
            return redirect()->route('subscription.packages')->with('error', 'Payment record not found.');
        }

        // Check transaction status
        $status = $paytmParams['STATUS'] ?? '';
        $txnId = $paytmParams['TXNID'] ?? null;
        $respMsg = $paytmParams['RESPMSG'] ?? '';

        if ($status === 'TXN_SUCCESS') {
            // Payment successful
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'completed',
                'response_data' => json_encode($paytmParams),
            ]);

            // Update user subscription validity
            $user = $payment->user;
            $currentValidity = $user->validity ? \Carbon\Carbon::parse($user->validity) : now();
            $newValidity = $currentValidity->addMonths($payment->package->duration);
            $user->update(['validity' => $newValidity]);

            $dashboardRoute = $payment->user->role === 'employee' ? 'employee.dashboard' : 'employer.dashboard';
            return redirect()->route($dashboardRoute)->with('success', 'Payment successful! Your subscription has been activated.');
        } elseif ($status === 'PENDING') {
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'pending',
                'response_data' => json_encode($paytmParams),
            ]);

            return redirect()->back()->with('warning', 'Payment is pending. Please wait for confirmation.');
        } else {
            // Payment failed
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'failed',
                'response_data' => json_encode($paytmParams),
            ]);

            return redirect()->back()->with('error', 'Payment failed: ' . $respMsg);
        }
    }

    /**
     * Check transaction status (for pending payments)
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $payment = PaymentHistory::where('order_id', $request->order_id)
                                ->where('user_id', Auth::id())
                                ->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Return status for test mode payments
        if (config('services.paytm.test_mode', false)) {
            return response()->json([
                'ORDERID' => $payment->order_id,
                'STATUS' => $payment->status === 'completed' ? 'TXN_SUCCESS' : 'PENDING',
                'TXNID' => $payment->transaction_id,
            ]);
        }

        // Prepare status check parameters
        $statusParams = [
            'MID' => config('services.paytm.merchant_id'),
            'ORDERID' => $request->order_id,
        ];

        $checksum = PaytmChecksum::generateSignature($statusParams, config('services.paytm.merchant_key'));
        $statusParams['CHECKSUMHASH'] = $checksum;

        $environment = config('services.paytm.environment', 'production');
        $url = $environment === 'staging' 
            ? 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus' 
            : 'https://secure.paytmpayments.com/merchant-status/getTxnStatus';

        $response = $this->makeCurlRequest($url, $statusParams);
        
        if ($response) {
            $responseData = json_decode($response, true);
            
            if ($responseData['STATUS'] === 'TXN_SUCCESS' && $payment->status !== 'completed') {
                $payment->update([
                    'transaction_id' => $responseData['TXNID'],
                    'status' => 'completed',
                    'response_data' => json_encode($responseData),
                ]);

                // Update user subscription
                $user = $payment->user;
                $currentValidity = $user->validity ? \Carbon\Carbon::parse($user->validity) : now();
                $newValidity = $currentValidity->addMonths($payment->package->duration);
                $user->update(['validity' => $newValidity]);
            }

            return response()->json($responseData);
        }

        return response()->json(['error' => 'Unable to check status'], 500);
    }

    /**
     * Make cURL request
     */
    private function makeCurlRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "JsonData=" . json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            Log::error('Paytm cURL Error: ' . $err);
            return false;
        }

        return $response;
    }
}