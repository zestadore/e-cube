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
                            <h2 class="mb-2 text-center">Register</h2>
                            <p class="text-center">Just a step away.</p>
                            <form action="{{ route('register') }}" method="POST">@csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">First name</label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" aria-describedby="first_name" placeholder="Enter your first name" id="email" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="last_name" class="form-label">Last name</label>
                                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" aria-describedby="last_name" placeholder="Enter your last name" id="last_name" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" autofocus>
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="number" class="form-control @error('mobile') is-invalid @enderror" aria-describedby="mobile" placeholder="Enter your mobile number" id="mobile" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>
                                            @error('mobile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" aria-describedby="password" placeholder="Enter your password" name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password-confirm" class="form-label">Confirm password</label>
                                            <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password-confirm" aria-describedby="password_confirmation" placeholder="Retype your password" name="password_confirmation" required autocomplete="current-password">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                                <p class="mt-3 text-center">
                                    Already have an account? <a href="{{ route('login') }}" class="text-underline">Click here to Signin.</a>
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
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
