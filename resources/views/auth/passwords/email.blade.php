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
                            <h2 class="mb-2 text-center">Reset Password</h2>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form action="{{ route('password.email') }}" method="POST">@csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" aria-describedby="email" placeholder="Enter your email id" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Send password reset link</button>
                                </div>
                                <p class="mt-3 text-center">
                                    Don’t have an account? <a href="{{ route('login') }}" class="text-underline">Click here to signin.</a>
                                </p>
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

{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
