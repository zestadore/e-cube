@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                                <img src="{{Auth::user()->image_path}}" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                            </div>
                            <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                <h4 class="me-2 h4">{{Auth::user()->full_name}}</h4>
                                <span> - {{Auth::user()->mobile}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <p> </p>
        <p> </p>
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between" style="float:right;">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1" >
                            <img src="{{Auth::user()->companyProfile->image_path}}" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                        </div>
                    </div>
                </div>
                <div class="header-title">
                    <h4 class="card-title">Company Profile</h4>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-inline m-0 p-0">
                    <li class="d-flex mb-2">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">
                            {{Auth::user()->companyProfile->company_name}}
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Address : {{Auth::user()->companyProfile->company_address}}</p>
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Website : {{Auth::user()->companyProfile->company_website}}</p>
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Email : {{Auth::user()->companyProfile->company_email}}</p>
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Phone : {{Auth::user()->companyProfile->company_phone}}</p>
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Description : {{Auth::user()->companyProfile->company_description}}</p>
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Date of Establishment : {{Auth::user()->companyProfile->date_of_establishment}}</p>
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">GST : {{Auth::user()->companyProfile->gst_number}}</p>
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Pan : {{Auth::user()->companyProfile->pan_number}}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-title">
                    <h4 class="card-title">Chairman</h4>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-inline m-0 p-0">
                    <li class="d-flex mb-2">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">
                            {{Auth::user()->companyProfile->chairman_name}}
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Phone : {{Auth::user()->companyProfile->chairman_contact}}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-title">
                    <h4 class="card-title">HR</h4>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-inline m-0 p-0">
                    <li class="d-flex mb-2">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">
                            {{Auth::user()->companyProfile->hr_name}}
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Phone : {{Auth::user()->companyProfile->hr_contact}}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-title">
                    <h4 class="card-title">Other Details</h4>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-inline m-0 p-0">
                    <li class="d-flex mb-2">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">
                            {{ucfirst(Auth::user()->companyProfile->registration_type)}}
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">No of employees : {{Auth::user()->companyProfile->no_of_employees}}</p>
                    </li>
                    <li class="d-flex">
                        <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                        </div>
                        <p class="news-detail mb-0">Industry : {{Auth::user()->companyProfile->industry->industry_name}}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-bottom share-offcanvas" tabindex="-1" id="share-btn" aria-labelledby="shareBottomLabel">
        <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="shareBottomLabel">Share</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small">
        <div class="d-flex flex-wrap align-items-center">
            <div class="text-center me-3 mb-3">
                <img src="../../assets/images/brands/08.png" class="img-fluid rounded mb-2" alt="">
                <h6>Facebook</h6>
            </div>
            <div class="text-center me-3 mb-3">
                <img src="../../assets/images/brands/09.png" class="img-fluid rounded mb-2" alt="">
                <h6>Twitter</h6>
            </div>
            <div class="text-center me-3 mb-3">
                <img src="../../assets/images/brands/10.png" class="img-fluid rounded mb-2" alt="">
                <h6>Instagram</h6>
            </div>
            <div class="text-center me-3 mb-3">
                <img src="../../assets/images/brands/11.png" class="img-fluid rounded mb-2" alt="">
                <h6>Google Plus</h6>
            </div>
            <div class="text-center me-3 mb-3">
                <img src="../../assets/images/brands/13.png" class="img-fluid rounded mb-2" alt="">
                <h6>In</h6>
            </div>
            <div class="text-center me-3 mb-3">
                <img src="../../assets/images/brands/12.png" class="img-fluid rounded mb-2" alt="">
                <h6>YouTube</h6>
            </div>
        </div>
        </div>
    </div>      </div>
    <div class="btn-download">
        <a class="btn btn-success px-3 py-2" href="https://iqonic.design/product/admin-templates/hope-ui-admin-free-open-source-bootstrap-admin-template/" target="_blank" >
            <svg class="icon-24"  width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4" d="M17.554 7.29614C20.005 7.29614 22 9.35594 22 11.8876V16.9199C22 19.4453 20.01 21.5 17.564 21.5L6.448 21.5C3.996 21.5 2 19.4412 2 16.9096V11.8773C2 9.35181 3.991 7.29614 6.438 7.29614H7.378L17.554 7.29614Z" fill="currentColor"></path>
                <path d="M12.5464 16.0374L15.4554 13.0695C15.7554 12.7627 15.7554 12.2691 15.4534 11.9634C15.1514 11.6587 14.6644 11.6597 14.3644 11.9654L12.7714 13.5905L12.7714 3.2821C12.7714 2.85042 12.4264 2.5 12.0004 2.5C11.5754 2.5 11.2314 2.85042 11.2314 3.2821L11.2314 13.5905L9.63742 11.9654C9.33742 11.6597 8.85043 11.6587 8.54843 11.9634C8.39743 12.1168 8.32142 12.3168 8.32142 12.518C8.32142 12.717 8.39743 12.9171 8.54643 13.0695L11.4554 16.0374C11.6004 16.1847 11.7964 16.268 12.0004 16.268C12.2054 16.268 12.4014 16.1847 12.5464 16.0374Z" fill="currentColor"></path>
            </svg>
        </a>
    </div>
</div>
@endsection