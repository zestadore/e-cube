@extends('layouts.app')

@section('content')
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">            
            <div class="col-md-6">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                            <div class="card-body" style="font-style: italic;">
                                <h3 class="mb-2 text-center">Looking for a Job?</h3>
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="jobseeker" class="btn btn-primary">Create your stunning profile!</button>
                                </div>
                            </div>
                            <div class="card-body" style="font-style: italic;">
                                <h3 class="mb-2 text-center" >Planning to hire a talent?</h3>
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="recruiter" class="btn btn-primary">Create your page & start posting jobs!</button>
                                </div>
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
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#jobseeker').click(function(){
                window.location.href = "{{ route('jobseeker.register') }}";
            });
            $('#recruiter').click(function(){
                window.location.href = "{{ route('recruiter.register') }}";
            });
        });
    </script>
@endsection