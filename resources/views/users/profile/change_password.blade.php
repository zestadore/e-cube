@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change Password</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissable" role="alert">
                                <p class="mb-0">{{ session('error') }}</p>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissable" role="alert">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        <form action="{{route('update.password')}}" method="POST">@csrf
                            <x-InputBox class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" title="Password" name="password" id="password" type="password" required="True"/>
                            <x-InputBox class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" title="Retype Password" name="password_confirmation" id="password-confirm" type="password" required="True"/>
                            <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection