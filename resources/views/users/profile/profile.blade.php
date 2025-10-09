@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Profile</div>

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
                        <form action="{{route('profile.update')}}" method="post" id="addNewForm" enctype='multipart/form-data'>@csrf
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-md-12 col-xs-12">
                                    <x-InputBox class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" title="First name" name="first_name" id="first_name" type="text" required="True"/>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-12 col-xs-12">
                                    <x-InputBox class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" title="Last name" name="last_name" id="last_name" type="text" required="False"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-4 col-md-12 col-xs-12">
                                    <x-InputBox class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="True"/>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-md-12 col-xs-12">
                                    <x-InputBox class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" title="Mobile" name="mobile" id="mobile" type="number" required="True"/>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-md-12 col-xs-12">
                                    <x-InputBox class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" title="Image" name="image" id="image" type="file" required="False"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info" style="float:right;">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
        <!-- jquery-validation -->
        <script src="{{asset('assets/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
        <script>
             $(function () {
                $('#addNewForm').validate({
                    rules: {
                        first_name: {
                            required: true
                        },
                        email: {
                            required: true
                        },
                        mobile: {
                            required: true
                        },
                    },
                    messages: {
                        first_name: {
                            required: "Please enter the first name."
                        },
                        email: {
                            required: "Please enter your email id."
                        },
                        mobile: {
                            required: "Please enter your mobile number."
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    }
                });
            });

            function prefillForm(){
                $('#first_name').val('{{Auth::user()->first_name}}');
                $('#last_name').val('{{Auth::user()->last_name}}');
                $('#email').val('{{Auth::user()->email}}');
                $('#mobile').val('{{Auth::user()->mobile}}');
            }
            prefillForm();
            $("#email").prop("readonly", true);
        </script>
    @endsection