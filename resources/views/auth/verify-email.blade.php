@extends('layouts.app')

@section('content')
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">            
            <div class="col-md-6">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                        <div class="card-body">
                            {{-- <a href="#" class="navbar-brand d-flex align-items-center mb-3">
                                <img src="{{ asset('admin_assets/images/logo/logo.png') }}" alt="e-cube creers logo" style="height: 100px;width: 100px">
                            </a> --}}
                            <h2 class="mb-2 text-center">Verification Required</h2>
                            <p class="text-center">Email Verification Required.</p>
                            @if (session('message'))
                                <div style="color:green;">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <p>Please verify your email id before continuing.</p>
                            <form method="POST" action="{{ route('verification.send') }}">@csrf
                                <button type="submit" class="btn btn-primary mt-3">Resend Verification Email</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="sign-bg">
                    <img src="{{ asset('admin_assets/images/logo/logo.png') }}" alt="" width="280" height="230" style="opacity: 0.10;">
                </div>
            </div>
            <div class="col-md-6 d-md-block d-none p-0 mt-n1 vh-100 overflow-hidden">
                <img src="{{ asset('admin_assets/images/recr.jpg') }}" style="padding: 20px;" class="img-fluid gradient-main animated-scaleX" alt="images">
            </div>
        </div>
    </section>
@endsection
