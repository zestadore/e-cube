@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="container-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-crown text-warning me-2"></i>Choose Your Subscription Plan
                    </h3>
                    <p class="text-muted mt-2 mb-0">Select the best plan that suits your hiring needs</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($packages as $package)
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <h4 class="text-white mb-0 fw-bold">{{ $package->package_name }}</h4>
                    <div class="mt-2">
                        <span class="badge bg-white text-primary px-3 py-2" style="font-size: 14px;">
                            <i class="fas fa-clock me-1"></i>{{ $package->validity }} Days
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <h2 class="mb-0 fw-bold text-primary">₹{{ number_format($package->price) }}</h2>
                        <small class="text-muted">{{ $package->duration }} Month{{ $package->duration > 1 ? 's' : '' }}</small>
                    </div>
                    
                    @if($package->description)
                    <div class="package-description mb-3">
                        <p class="text-muted small mb-0" style="line-height: 1.5;">{{ $package->description }}</p>
                    </div>
                    @endif
                    
                    <div class="features-list text-start mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2" style="font-size: 14px;"></i>
                            <small>Full access to candidate database</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2" style="font-size: 14px;"></i>
                            <small>Post unlimited job listings</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2" style="font-size: 14px;"></i>
                            <small>Direct candidate contact</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2" style="font-size: 14px;"></i>
                            <small>Priority support</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2" style="font-size: 14px;"></i>
                            <small>Valid for {{ $package->validity }} days</small>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 fw-bold py-3 pay-btn" 
                            data-package-id="{{ $package->id }}"
                            data-package-name="{{ $package->package_name }}"
                            data-price="{{ $package->price }}"
                            style="border-radius: 10px; font-size: 16px;">
                        <i class="fas fa-credit-card me-2"></i>Pay Now
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(count($packages) == 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No packages available at the moment</h4>
                    <p class="text-muted">Please check back later for new subscription plans.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Hidden form for Paytm redirect -->
<form id="paytmForm" method="POST" action="" style="display: none;">
    <input type="hidden" name="MID" id="paytm_mid">
    <input type="hidden" name="WEBSITE" id="paytm_website">
    <input type="hidden" name="CHANNEL_ID" id="paytm_channel">
    <input type="hidden" name="INDUSTRY_TYPE_ID" id="paytm_industry">
    <input type="hidden" name="ORDER_ID" id="paytm_order_id">
    <input type="hidden" name="CUST_ID" id="paytm_cust_id">
    <input type="hidden" name="MOBILE_NO" id="paytm_mobile">
    <input type="hidden" name="EMAIL" id="paytm_email">
    <input type="hidden" name="TXN_AMOUNT" id="paytm_amount">
    <input type="hidden" name="CALLBACK_URL" id="paytm_callback">
    <input type="hidden" name="CHECKSUMHASH" id="paytm_checksum">
</form>

<!-- Test Payment Modal -->
<div class="modal fade" id="testPaymentModal" tabindex="-1" aria-labelledby="testPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="testPaymentModalLabel">
                    <i class="fas fa-flask me-2"></i>Test Payment Mode
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="fas fa-vial fa-3x text-warning mb-3"></i>
                <h5>Test Payment</h5>
                <p class="text-muted">This is a test environment. No real transaction will occur.</p>
                <div class="alert alert-info">
                    <strong>Order ID:</strong> <span id="test_order_id"></span><br>
                    <strong>Amount:</strong> ₹<span id="test_amount"></span>
                </div>
                <p>Choose the payment result:</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-success" onclick="processTestPayment('success')">
                        <i class="fas fa-check me-2"></i>Simulate Success
                    </button>
                    <button class="btn btn-danger" onclick="processTestPayment('failure')">
                        <i class="fas fa-times me-2"></i>Simulate Failure
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="testCallbackForm" method="POST" action="" style="display: none;">
    @csrf
    <input type="hidden" name="ORDERID" id="test_callback_order_id">
    <input type="hidden" name="TXNID" id="test_callback_txn_id">
    <input type="hidden" name="STATUS" id="test_callback_status">
    <input type="hidden" name="TXNAMOUNT" id="test_callback_amount">
    <input type="hidden" name="TEST" value="true">
</form>
@endsection

@section('scripts')
    <script>
        // Global variables for test payment
        var currentTestOrderId = '';
        var currentTestAmount = '';
        var currentTestCallbackUrl = '';
        var currentBtn = null;

        $(document).ready(function() {
            $('.pay-btn').click(function(){
                var packageId = $(this).data('package-id');
                var packageName = $(this).data('package-name');
                var price = $(this).data('price');
                var btn = $(this);
                
                // Disable button and show loading
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...');
                
                fetch("{{ route('paytm.initiate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ package_id: packageId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Check if test mode
                        if (data.test_mode) {
                            // Show test payment modal
                            showTestPaymentModal(data.order_id, data.amount, data.callback_url, btn);
                            return;
                        }
                        
                        // Fill the hidden form with Paytm parameters
                        $('#paytm_mid').val(data.paytmParams.MID);
                        $('#paytm_website').val(data.paytmParams.WEBSITE);
                        $('#paytm_channel').val(data.paytmParams.CHANNEL_ID);
                        $('#paytm_industry').val(data.paytmParams.INDUSTRY_TYPE_ID);
                        $('#paytm_order_id').val(data.paytmParams.ORDER_ID);
                        $('#paytm_cust_id').val(data.paytmParams.CUST_ID);
                        $('#paytm_mobile').val(data.paytmParams.MOBILE_NO);
                        $('#paytm_email').val(data.paytmParams.EMAIL);
                        $('#paytm_amount').val(data.paytmParams.TXN_AMOUNT);
                        $('#paytm_callback').val(data.paytmParams.CALLBACK_URL);
                        $('#paytm_checksum').val(data.checksum);
                        
                        // Set form action and submit
                        $('#paytmForm').attr('action', data.paytm_url);
                        $('#paytmForm').submit();
                    } else {
                        alert('Failed to initiate payment. Please try again.');
                        btn.prop('disabled', false).html('<i class="fas fa-credit-card me-2"></i>Pay Now');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Paytm service is temporarily unavailable. Please try again later or use production credentials.');
                    btn.prop('disabled', false).html('<i class="fas fa-credit-card me-2"></i>Pay Now');
                });
            });
        });

        // Show Test Payment Modal
        function showTestPaymentModal(orderId, amount, callbackUrl, btn) {
            currentTestOrderId = orderId;
            currentTestAmount = amount;
            currentTestCallbackUrl = callbackUrl;
            currentBtn = btn;
            
            $('#test_order_id').text(orderId);
            $('#test_amount').text(amount);
            
            var testModal = new bootstrap.Modal(document.getElementById('testPaymentModal'));
            testModal.show();
            
            // Re-enable the button
            btn.prop('disabled', false).html('<i class="fas fa-credit-card me-2"></i>Pay Now');
        }

        // Process Test Payment
        function processTestPayment(status) {
            // Close the modal
            var testModal = bootstrap.Modal.getInstance(document.getElementById('testPaymentModal'));
            testModal.hide();
            
            // Show loading
            if (currentBtn) {
                currentBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...');
            }
            
            // Submit to test payment endpoint
            fetch("{{ route('paytm.test') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    order_id: currentTestOrderId,
                    status: status
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Redirect to employer dashboard on success
                    window.location.href = data.redirect;
                } else {
                    // Show error message on same page
                    alert(data.message);
                    if (currentBtn) {
                        currentBtn.prop('disabled', false).html('<i class="fas fa-credit-card me-2"></i>Pay Now');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during test payment processing.');
                if (currentBtn) {
                    currentBtn.prop('disabled', false).html('<i class="fas fa-credit-card me-2"></i>Pay Now');
                }
            });
        }
    </script>
@endsection
