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
                            data-price="{{ $package->price }}" 
                            data-id="{{ $package->id }}"
                            data-name="{{ $package->package_name }}"
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
@endsection

@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $(document).ready(function() {
            $('.pay-btn').click(function(){
                var price = $(this).data('price');
                var id = $(this).data('id');
                var name = $(this).data('name');
                
                fetch("{{ route('razorpay.order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ amount: price, id: id })
                })
                .then(res => res.json())
                .then(data => {
                    let options = {
                        key: data.key,
                        amount: data.amount,
                        currency: "INR",
                        order_id: data.order_id,
                        name: "E-Cube Careers",
                        description: name + " Subscription",
                        image: "{{ asset('assets/images/logo.png') }}",
                        handler: function (response) {
                            let form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('razorpay.verify') }}";

                            for (let key in response) {
                                let input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = response[key];
                                form.appendChild(input);
                            }

                            let csrf = document.createElement('input');
                            csrf.type = 'hidden';
                            csrf.name = '_token';
                            csrf.value = '{{ csrf_token() }}';
                            form.appendChild(csrf);

                            document.body.appendChild(form);
                            form.submit();
                        },
                        prefill: {
                            name: "{{ Auth::user()->full_name }}",
                            email: "{{ Auth::user()->email }}",
                            contact: "{{ Auth::user()->mobile }}"
                        },
                        theme: {
                            color: "#667eea"
                        }
                    };

                    new Razorpay(options).open();
                });
            });
        });
    </script>
@endsection