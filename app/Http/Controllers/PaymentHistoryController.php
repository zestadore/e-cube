<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
use App\Models\CandidateViewPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    /**
     * Display payment history for employer (own payments only)
     */
    public function employerIndex()
    {
        $user = Auth::user();
        
        // Get subscription payments
        $subscriptionPayments = PaymentHistory::with('package')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'date' => $payment->created_at,
                    'type' => 'Subscription',
                    'description' => $payment->package ? $payment->package->name : 'Subscription Package',
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                    'order_id' => $payment->order_id,
                    'transaction_id' => $payment->transaction_id,
                ];
            });
        
        // Get candidate view payments
        $candidatePayments = CandidateViewPayment::with('candidate')
            ->where('employer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'date' => $payment->created_at,
                    'type' => 'Candidate View',
                    'description' => $payment->candidate ? 'Viewed: ' . $payment->candidate->full_name : 'Candidate Profile View',
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                    'order_id' => $payment->order_id,
                    'transaction_id' => $payment->transaction_id,
                ];
            });
        
        // Merge and sort by date
        $allPayments = $subscriptionPayments->merge($candidatePayments)
            ->sortByDesc('date')
            ->values();
        
        // Calculate totals
        $totalSpent = $allPayments->where('status', 'completed')->sum('amount');
        $subscriptionTotal = $subscriptionPayments->where('status', 'completed')->sum('amount');
        $candidateViewTotal = $candidatePayments->where('status', 'completed')->sum('amount');
        
        return view('users.payments.history', compact(
            'allPayments',
            'totalSpent',
            'subscriptionTotal',
            'candidateViewTotal'
        ));
    }
    
    /**
     * Display all payment history for admin
     */
    public function adminIndex()
    {
        // Get all subscription payments
        $subscriptionPayments = PaymentHistory::with(['user', 'package'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'date' => $payment->created_at,
                    'type' => 'Subscription',
                    'user' => $payment->user ? $payment->user->full_name : 'N/A',
                    'user_email' => $payment->user ? $payment->user->email : 'N/A',
                    'description' => $payment->package ? $payment->package->name : 'Subscription Package',
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                    'order_id' => $payment->order_id,
                    'transaction_id' => $payment->transaction_id,
                ];
            });
        
        // Get all candidate view payments
        $candidatePayments = CandidateViewPayment::with(['employer', 'candidate'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'date' => $payment->created_at,
                    'type' => 'Candidate View',
                    'user' => $payment->employer ? $payment->employer->full_name : 'N/A',
                    'user_email' => $payment->employer ? $payment->employer->email : 'N/A',
                    'description' => $payment->candidate ? 'Viewed: ' . $payment->candidate->full_name : 'Candidate Profile View',
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                    'order_id' => $payment->order_id,
                    'transaction_id' => $payment->transaction_id,
                ];
            });
        
        // Merge and sort by date
        $allPayments = $subscriptionPayments->merge($candidatePayments)
            ->sortByDesc('date')
            ->values();
        
        // Calculate totals
        $totalRevenue = $allPayments->where('status', 'completed')->sum('amount');
        $subscriptionRevenue = $subscriptionPayments->where('status', 'completed')->sum('amount');
        $candidateViewRevenue = $candidatePayments->where('status', 'completed')->sum('amount');
        
        // Get unique employers count
        $uniqueEmployers = $candidatePayments->pluck('user_email')->unique()->count();
        $uniqueSubscribers = $subscriptionPayments->pluck('user_email')->unique()->count();
        
        return view('admin.payments.history', compact(
            'allPayments',
            'totalRevenue',
            'subscriptionRevenue',
            'candidateViewRevenue',
            'uniqueEmployers',
            'uniqueSubscribers'
        ));
    }
}