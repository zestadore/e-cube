@extends('layouts.app')

@section('title', 'Payment History')

@section('content')
<div class="container-fluid content-inner mt-n5 py-0">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">
                            <i class="fas fa-credit-card text-primary me-2"></i>Payment History
                        </h3>
                        <p class="text-muted mt-2 mb-0">View all payments and transactions across the platform</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Revenue</h6>
                            <h3 class="mb-0">₹{{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                        <div class="icon-shape bg-white text-primary rounded-circle p-3">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Subscription Revenue</h6>
                            <h3 class="mb-0">₹{{ number_format($subscriptionRevenue, 2) }}</h3>
                        </div>
                        <div class="icon-shape bg-white text-success rounded-circle p-3">
                            <i class="fas fa-crown fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Candidate View Revenue</h6>
                            <h3 class="mb-0">₹{{ number_format($candidateViewRevenue, 2) }}</h3>
                        </div>
                        <div class="icon-shape bg-white text-info rounded-circle p-3">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2">Unique Users</h6>
                            <h3 class="mb-0">{{ $uniqueSubscribers + $uniqueEmployers }}</h3>
                        </div>
                        <div class="icon-shape bg-white text-warning rounded-circle p-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>All Transactions</h5>
                    <span class="badge bg-primary">Total: {{ $allPayments->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Order ID</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allPayments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payment['date']->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white me-2" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                                {{ substr($payment['user'], 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $payment['user'] }}</div>
                                                <small class="text-muted">{{ $payment['user_email'] }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($payment['type'] == 'Subscription')
                                            <span class="badge bg-success"><i class="fas fa-crown me-1"></i>Subscription</span>
                                        @else
                                            <span class="badge bg-info"><i class="fas fa-user me-1"></i>Candidate View</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment['description'] }}</td>
                                    <td><small class="text-muted">{{ $payment['order_id'] }}</small></td>
                                    <td class="text-end fw-bold">₹{{ number_format($payment['amount'], 2) }}</td>
                                    <td class="text-center">
                                        @if($payment['status'] == 'completed' || $payment['status'] == 'success')
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Success</span>
                                        @elseif($payment['status'] == 'pending')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>
                                        @elseif($payment['status'] == 'failed')
                                            <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Failed</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($payment['status']) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-receipt fa-3x mb-3"></i>
                                            <h5>No Payments Found</h5>
                                            <p>No payments have been made yet.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection