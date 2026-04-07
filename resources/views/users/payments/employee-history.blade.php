@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .payment-card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 25px;
        }
        .payment-card .card-header {
            background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
            border-bottom: 2px solid #e3e6f0;
            border-radius: 15px 15px 0 0;
            padding: 20px 25px;
        }
        .stat-box {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid;
        }
        .stat-box.primary { border-left-color: #4e73df; }
        .stat-box.success { border-left-color: #1cc88a; }
        .stat-box.info { border-left-color: #36b9cc; }
        .stat-box.warning { border-left-color: #f6c23e; }
        
        .stat-box .stat-icon {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .stat-box.primary .stat-icon { color: #4e73df; }
        .stat-box.success .stat-icon { color: #1cc88a; }
        .stat-box.info .stat-icon { color: #36b9cc; }
        .stat-box.warning .stat-icon { color: #f6c23e; }
        
        .stat-box .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #5a5c69;
        }
        .stat-box .stat-label {
            font-size: 13px;
            color: #858796;
            margin-top: 5px;
        }
        .payment-table th {
            background: #f8f9fc;
            font-weight: 600;
            color: #5a5c69;
            border-bottom: 2px solid #e3e6f0;
        }
        .payment-table td {
            vertical-align: middle;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-completed { background: #e8f5e9; color: #2e7d32; }
        .status-pending { background: #fff3e0; color: #f57c00; }
        .status-failed { background: #fce4ec; color: #c2185b; }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #858796;
        }
        .empty-state i {
            font-size: 60px;
            margin-bottom: 20px;
            color: #e3e6f0;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1"><i class="fas fa-history text-primary me-2"></i>Payment History</h3>
                    <p class="text-muted mb-0">View all your subscription payments</p>
                </div>
                <a href="{{ route('employee.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-box primary">
                <i class="fas fa-wallet stat-icon"></i>
                <div class="stat-value">₹{{ number_format($totalSpent) }}</div>
                <div class="stat-label">Total Spent</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-box info">
                <i class="fas fa-credit-card stat-icon"></i>
                <div class="stat-value">{{ $totalTransactions }}</div>
                <div class="stat-label">Total Transactions</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-box success">
                <i class="fas fa-check-circle stat-icon"></i>
                <div class="stat-value">{{ $completedTransactions }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-box warning">
                <i class="fas fa-crown stat-icon"></i>
                <div class="stat-value">{{ Auth::user()?->validity ? \Carbon\Carbon::parse(Auth::user()->validity)->format('d M Y') : 'No Active Plan' }}</div>
                <div class="stat-label">Plan Valid Until</div>
            </div>
        </div>
    </div>

    <!-- Payment History Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card payment-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Transaction History</h5>
                </div>
                <div class="card-body p-0">
                    @if($subscriptionPayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover payment-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Transaction ID</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptionPayments as $payment)
                                    <tr>
                                        <td>
                                            <i class="far fa-calendar-alt text-muted me-2"></i>
                                            {{ \Carbon\Carbon::parse($payment['date'])->format('d M Y, h:i A') }}
                                        </td>
                                        <td>
                                            <code class="bg-light px-2 py-1 rounded">{{ $payment['order_id'] }}</code>
                                        </td>
                                        <td>
                                            <i class="fas fa-crown text-warning me-2"></i>
                                            {{ $payment['description'] }}
                                        </td>
                                        <td>
                                            <strong class="text-primary">₹{{ number_format($payment['amount']) }}</strong>
                                        </td>
                                        <td>
                                            @if($payment['transaction_id'])
                                                <small class="text-muted">{{ $payment['transaction_id'] }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match($payment['status']) {
                                                    'completed' => 'status-completed',
                                                    'pending' => 'status-pending',
                                                    'failed' => 'status-failed',
                                                    default => 'status-pending'
                                                };
                                                $statusIcon = match($payment['status']) {
                                                    'completed' => 'fa-check',
                                                    'pending' => 'fa-clock',
                                                    'failed' => 'fa-times',
                                                    default => 'fa-clock'
                                                };
                                            @endphp
                                            <span class="status-badge {{ $statusClass }}">
                                                <i class="fas {{ $statusIcon }} me-1"></i>
                                                {{ ucfirst($payment['status']) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-receipt"></i>
                            <h4>No Payments Found</h4>
                            <p>You haven't made any subscription payments yet.</p>
                            <a href="{{ route('subscription.packages') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-crown me-2"></i>View Subscription Plans
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection