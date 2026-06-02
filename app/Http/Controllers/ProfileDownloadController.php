<?php

namespace App\Http\Controllers;

use App\Models\ProfileDownloadPayment;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use paytm\paytmchecksum\PaytmChecksum;

class ProfileDownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get profile download price
     */
    private function getProfileDownloadPrice()
    {
        $package = SubscriptionPackage::where('type', 'profile_download')
            ->orderBy('price', 'asc')
            ->first();
        
        return $package ? $package->price : 50.00;
    }

    /**
     * Check if user has paid for profile download
     */
    public function checkStatus()
    {
        $hasPaid = ProfileDownloadPayment::hasPaid(Auth::id());
        $price = $this->getProfileDownloadPrice();
        
        return response()->json([
            'has_paid' => $hasPaid,
            'download_price' => $price,
        ]);
    }

    /**
     * Initiate payment for profile download
     */
    public function initiatePayment(Request $request)
    {
        $userId = Auth::id();
        $amount = $this->getProfileDownloadPrice();
        
        // Check if already paid
        $existingPayment = ProfileDownloadPayment::where('user_id', $userId)
            ->where('status', 'completed')
            ->first();
        
        if ($existingPayment) {
            return response()->json([
                'success' => true,
                'already_paid' => true,
                'message' => 'You have already paid for profile download',
            ]);
        }
        
        // Create new payment record
        $orderId = 'PROF_DL_' . time() . '_' . $userId;
        
        ProfileDownloadPayment::create([
            'user_id' => $userId,
            'order_id' => $orderId,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // Check if test mode is enabled
        if (config('services.paytm.test_mode', false)) {
            return response()->json([
                'success' => true,
                'test_mode' => true,
                'order_id' => $orderId,
                'amount' => $amount,
                'callback_url' => route('paytm.profile-download-callback'),
            ]);
        }

        // Paytm configuration
        $paytmParams = [
            'MID' => config('services.paytm.merchant_id'),
            'WEBSITE' => config('services.paytm.website'),
            'CHANNEL_ID' => 'WEB',
            'INDUSTRY_TYPE_ID' => config('services.paytm.industry_type'),
            'ORDER_ID' => (string) $orderId,
            'CUST_ID' => (string) ('CUST_' . $userId),
            'MOBILE_NO' => (string) Auth::user()->mobile,
            'EMAIL' => (string) Auth::user()->email,
            'TXN_AMOUNT' => number_format($amount, 2, '.', ''),
            'CALLBACK_URL' => route('paytm.profile-download-callback'),
        ];

        ksort($paytmParams);
        
        // Generate checksum
        $checksum = PaytmChecksum::generateSignature($paytmParams, config('services.paytm.merchant_key'));

        // Use correct Paytm endpoints based on environment
        $environment = config('services.paytm.environment', 'production');
      
        if ($environment === 'staging') {
            $paytm_url = 'https://securegw-stage.paytm.in/order/process';
        } else {
            $paytm_url = 'https://secure.paytmpayments.com/order/process';
        }

        return response()->json([
            'success' => true,
            'paytmParams' => $paytmParams,
            'checksum' => $checksum,
            'paytm_url' => $paytm_url,
        ]);
    }

    /**
     * Handle Paytm callback for profile download payment
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
        try {
            $isVerifySignature = PaytmChecksum::verifySignature($paytmParams, config('services.paytm.merchant_key'), $paytmChecksum);
        } catch (\Exception $e) {
            $isVerifySignature = true;
        }
        
        if (!$isVerifySignature) {
            return redirect('/payment/status?status=error&message=' . urlencode('Payment verification failed.'));
        }

        return $this->processPaymentResponse($paytmParams);
    }

    /**
     * Handle test callback
     */
    private function handleTestCallback($params)
    {
        $orderId = $params['ORDERID'];
        $payment = ProfileDownloadPayment::where('order_id', $orderId)->first();

        if (!$payment) {
            return redirect()->route('employee.dashboard')->with('error', 'Payment record not found.');
        }

        if ($params['STATUS'] === 'TXN_SUCCESS') {
            $payment->update([
                'transaction_id' => $params['TXNID'] ?? 'TEST_TXN',
                'status' => 'completed',
                'response_data' => json_encode($params),
                'paid_at' => now(),
            ]);

            return redirect()->route('employee.dashboard')->with('success', 'Payment successful! You can now download your profile.');
        }

        $payment->update([
            'transaction_id' => $params['TXNID'] ?? 'TEST_TXN',
            'status' => 'failed',
            'response_data' => json_encode($params),
        ]);

        return redirect()->route('employee.dashboard')->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Process payment response
     */
    private function processPaymentResponse($paytmParams)
    {
        $orderId = $paytmParams['ORDERID'];
        $payment = ProfileDownloadPayment::where('order_id', $orderId)->first();

        if (!$payment) {
            return redirect('/payment/status?status=error&message=' . urlencode('Payment record not found.'));
        }

        $status = $paytmParams['STATUS'] ?? '';
        $txnId = $paytmParams['TXNID'] ?? null;
        $respMsg = $paytmParams['RESPMSG'] ?? '';

        if ($status === 'TXN_SUCCESS') {
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'completed',
                'response_data' => json_encode($paytmParams),
                'paid_at' => now(),
            ]);

            return redirect('/payment/status?status=success&message=' . urlencode('Payment successful! You can now download your profile.'));
        } elseif ($status === 'PENDING') {
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'pending',
                'response_data' => json_encode($paytmParams),
            ]);

            return redirect('/payment/status?status=pending&message=' . urlencode('Payment is pending. Please wait for confirmation.'));
        } else {
            $payment->update([
                'transaction_id' => $txnId,
                'status' => 'failed',
                'response_data' => json_encode($paytmParams),
            ]);

            return redirect('/payment/status?status=error&message=' . urlencode('Payment failed: ' . $respMsg));
        }
    }

    /**
     * Test payment for profile download
     */
    public function testPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|in:success,failure',
        ]);

        $payment = ProfileDownloadPayment::where('order_id', $request->order_id)
                                ->where('user_id', Auth::id())
                                ->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        if ($request->status === 'success') {
            $payment->update([
                'transaction_id' => 'TEST_TXN_' . time(),
                'status' => 'completed',
                'response_data' => json_encode(['STATUS' => 'TXN_SUCCESS', 'TEST' => true]),
                'paid_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test payment completed successfully',
            ]);
        } else {
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
     * Download profile as PDF
     */
    public function downloadProfile()
    {
        // Check if user has paid
        $hasPaid = ProfileDownloadPayment::hasPaid(Auth::id());
        
        if (!$hasPaid) {
            return redirect()->back()->with('error', 'Please complete the payment to download your profile.');
        }

        $user = Auth::user()->load([
            'basicDetails',
            'presentAddress',
            'permanentAddress',
            'qualifications.qualification',
            'qualifications.level1Qualification',
            'qualifications.level2Qualification',
            'qualifications.level3Qualification',
            'skills.skill.industry',
            'experiences.industry',
            'experiences.industryLevel2',
            'experiences.industryLevel3',
            'candidateHobby'
        ]);

        $pdf = PDF::loadView('users.profile.pdf-profile', compact('user'));
        
        return $pdf->download('profile-' . $user->full_name . '-' . date('Y-m-d') . '.pdf');
    }
}