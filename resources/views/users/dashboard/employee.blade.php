@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .edit-btn {
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .edit-btn:hover {
            background-color: #e3e6f0;
        }
        .card-header {
            position: relative;
        }
        .card-header .edit-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        .modal-lg {
            max-width: 900px;
        }
        .dynamic-entry {
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: #f8f9fc;
        }
        .dynamic-entry .remove-btn {
            float: right;
        }
    </style>
@endsection

@section('content')
    @if (!empty(Auth::user()->mobile_verified_at))
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                                        <img src="{{Auth::user()->image_path ?? asset('assets/images/default-avatar.png')}}" 
                                             alt="User-Profile" 
                                             class="theme-color-default-img img-fluid rounded-pill avatar-100"
                                             onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">
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
                @php
                    $userValidityDate = Auth::user()?->validity ? \Carbon\Carbon::parse(Auth::user()->validity) : null;
                @endphp
                @if ($userValidityDate === null || $userValidityDate->isPast())
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                            <span class="text-danger"> Kindly subscribe to a plan to access your dashboard</span>
                                        </div>
                                    </div>
                                    <a href="{{route('subscription.packages')}}" class="btn btn-primary btn-sm ms-2" style="float:right !important;">Explore Plans</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">Present Address</h4>
                            </div>
                            <span class="edit-btn text-primary" onclick="openEditModal('address')">
                                <i class="fas fa-edit"></i> Edit
                            </span>
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
                                        {{Auth::user()->presentAddress->address_1 ?? ''}}, {{Auth::user()->presentAddress->address_2 ?? ''}}, {{Auth::user()->presentAddress->city ?? ''}}, {{Auth::user()->presentAddress->state ?? ''}}, {{Auth::user()->presentAddress->country ?? ''}}, {{Auth::user()->presentAddress->zip ?? ''}}
                                    </p>
                                </li>
                                <li class="d-flex">
                                    <div class="news-icon me-3">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                                        </svg>
                                    </div>
                                    <p class="news-detail mb-0">Police Station : {{Auth::user()->presentAddress->police_station ?? ''}}</p>
                                </li>
                                <li class="d-flex">
                                    <div class="news-icon me-3">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                                        </svg>
                                    </div>
                                    <p class="news-detail mb-0">Panchayat/Municipality : {{Auth::user()->presentAddress->panchayat_municipality ?? ''}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">Permanent Address</h4>
                            </div>
                            <span class="edit-btn text-primary" onclick="openEditModal('address')">
                                <i class="fas fa-edit"></i> Edit
                            </span>
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
                                        {{Auth::user()->permanentAddress->address_1 ?? ''}}, {{Auth::user()->permanentAddress->address_2 ?? ''}}, {{Auth::user()->permanentAddress->city ?? ''}}, {{Auth::user()->permanentAddress->state ?? ''}}, {{Auth::user()->permanentAddress->country ?? ''}}, {{Auth::user()->permanentAddress->zip ?? ''}}
                                    </p>
                                </li>
                                <li class="d-flex">
                                    <div class="news-icon me-3">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                                        </svg>
                                    </div>
                                    <p class="news-detail mb-0">Police Station : {{Auth::user()->permanentAddress->police_station ?? ''}}</p>
                                </li>
                                <li class="d-flex">
                                    <div class="news-icon me-3">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                                        </svg>
                                    </div>
                                    <p class="news-detail mb-0">Panchayat/Municipality : {{Auth::user()->permanentAddress->panchayat_municipality ?? ''}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="profile-content tab-content">
                        <div id="profile-feed" class="tab-pane fade active show">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between pb-4">
                                    <div class="header-title">
                                        <div class="d-flex flex-wrap">
                                            <div class="media-support-info mt-2">
                                                <h5 class="mb-0">Qualifications</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="edit-btn text-primary" onclick="openEditModal('education')">
                                        <i class="fas fa-edit"></i> Edit
                                    </span>                        
                                </div>
                                <div class="card-body p-0">
                                    <div class="comment-area p-3">
                                        <hr>
                                        @if(Auth::user()->qualifications->isNotEmpty())
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover table-responsive">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Qualification</th>
                                                        <th>University</th>
                                                        <th>Years</th>
                                                        <th>Percentage</th>
                                                    </tr>
                                                    @foreach(Auth::user()->qualifications as $key => $qualification)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$qualification->qualification->degree ?? ''}}</td>
                                                            <td>{{$qualification->university}}</td>
                                                            <td>{{$qualification->from_year}} - {{$qualification->to_year}}</td>
                                                            <td>{{$qualification->percentage}} %</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <p>No Qualifications to list</p>
                                            </div>
                                        @endif
                                    </div>                              
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between pb-4">
                                    <div class="header-title">
                                        <div class="d-flex flex-wrap">
                                            <div class="media-support-info mt-2">
                                                <h5 class="mb-0">Skills</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="edit-btn text-primary" onclick="openEditModal('skills')">
                                        <i class="fas fa-edit"></i> Edit
                                    </span>                        
                                </div>
                                <div class="card-body p-0">
                                    <div class="comment-area p-3">
                                        <hr>
                                        @if(Auth::user()->skills->isNotEmpty())
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover table-responsive">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Skill</th>
                                                        <th>Proficiency</th>
                                                    </tr>
                                                    @foreach(Auth::user()->skills as $key => $skill)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$skill->skill->skill ?? ''}}</td>
                                                            <td>{{$skill->proficiency ?? 'N/A'}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <p>No Skills to list</p>
                                            </div>
                                        @endif
                                    </div>                              
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between pb-4">
                                    <div class="header-title">
                                        <div class="d-flex flex-wrap">
                                            <div class="media-support-info mt-2">
                                                <h5 class="mb-0">Experience</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="edit-btn text-primary" onclick="openEditModal('experience')">
                                        <i class="fas fa-edit"></i> Edit
                                    </span>                        
                                </div>
                                <div class="card-body p-0">
                                    <div class="comment-area p-3">
                                        <hr>
                                        @if(Auth::user()->experiences->isNotEmpty())
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover table-responsive">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Industry</th>
                                                        <th>Roles</th>
                                                        <th>Company</th>
                                                        <th>Years</th>
                                                        <th>Duration</th>
                                                    </tr>
                                                    @foreach(Auth::user()->experiences as $key => $exp)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$exp->industry->industry_name ?? ''}}</td>
                                                            <td>{{$exp->roles()->pluck('industry_name')->implode(', ')}}</td>
                                                            <td>{{$exp->company}}</td>
                                                            <td>{{$exp->from_year}} - {{$exp->to_year ?? 'Present'}}</td>
                                                            <td>{{$exp->duration}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <p>No Experience to list</p>
                                            </div>
                                        @endif
                                    </div>                              
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between pb-4">
                                    <div class="header-title">
                                        <div class="d-flex flex-wrap">
                                            <div class="media-support-info mt-2">
                                                <h5 class="mb-0">Hobbies & Interests</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="edit-btn text-primary" onclick="openEditModal('hobbies')">
                                        <i class="fas fa-edit"></i> Edit
                                    </span>                        
                                </div>
                                <div class="card-body p-0">
                                    <div class="comment-area p-3">
                                        <hr>
                                        @php
                                            $hobbies = \App\Models\CandidateHobby::where('user_id', Auth::id())->first();
                                        @endphp
                                        @if($hobbies)
                                            <div class="mb-3">
                                                <strong>Description:</strong>
                                                <p>{!! $hobbies->description !!}</p>
                                            </div>
                                            @if($hobbies->interests)
                                                <div>
                                                    <strong>Areas of Interest:</strong>
                                                    <p>{{ $hobbies->interests }}</p>
                                                </div>
                                            @endif
                                        @else
                                            <div class="table-responsive">
                                                <p>No Hobbies to list</p>
                                            </div>
                                        @endif
                                    </div>                              
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">Basic Details</h4>
                            </div>
                            <span class="edit-btn text-primary" onclick="openEditModal('basic')">
                                <i class="fas fa-edit"></i> Edit
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="mb-1">Email: <a href="#" class="ms-3">{{Auth::user()->email}}</a></div>
                            <div class="mb-1">Mobile: <a href="#" class="ms-3">{{Auth::user()->mobile}}</a></div>
                            <div>DOB: <span class="ms-3"><a href="#" class="ms-3">{{Auth::user()->basics->dob ? Carbon::parse(Auth::user()->basics->dob)->format('d M Y') : 'N/A'}}</a></span></div>
                            <div class="mb-1">Gender: <a href="#" class="ms-3">{{Auth::user()->basics->gender ?? 'N/A'}}</a></div>
                            <div class="mb-1">Alt Mob No : <a href="#" class="ms-3">{{Auth::user()->basics->alternate_mobile_number ?? 'N/A'}}</a></div>
                            <div class="mb-1">Whatsapp: <a href="#" class="ms-3">{{Auth::user()->basics->whatsapp_number ?? 'N/A'}}</a></div>
                            <div class="mb-1">Alt Email: <a href="#" class="ms-3">{{Auth::user()->basics->alternate_email_id ?? 'N/A'}}</a></div>
                            <div class="mb-1">Aadhar No: <a href="#" class="ms-3">{{Auth::user()->basics->aadhar_number ?? 'N/A'}}</a></div>
                            <div class="mb-1">Pan No: <a href="#" class="ms-3">{{Auth::user()->basics->pan_number ?? 'N/A'}}</a></div>
                            <div class="mb-1">Passport No: <a href="#" class="ms-3">{{Auth::user()->basics->passport_number ?? 'N/A'}}</a></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">Profile Picture</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile">
                                <img src="{{Auth::user()->image_path ?? asset('assets/images/default-avatar.png')}}" 
                                     alt="profile-img" 
                                     class="rounded-pill avatar-130 img-fluid"
                                     onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <h4 class="text-danger">Your account/mobile number is not verified, one of our representatives will contact you soon!</h4>
        </div>
    @endif

    <!-- Edit Modals -->
    
    <!-- Basic Information Modal -->
    <div class="modal fade" id="editBasicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Basic Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBasicForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="dob" id="edit_dob" value="{{Auth::user()->basics->dob ?? ''}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select" name="gender" id="edit_gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{(Auth::user()->basics->gender ?? '') == 'Male' ? 'selected' : ''}}>Male</option>
                                    <option value="Female" {{(Auth::user()->basics->gender ?? '') == 'Female' ? 'selected' : ''}}>Female</option>
                                    <option value="Other" {{(Auth::user()->basics->gender ?? '') == 'Other' ? 'selected' : ''}}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Aadhar Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="aadhar_number" id="edit_aadhar_number" value="{{Auth::user()->basics->aadhar_number ?? ''}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">PAN Number</label>
                                <input type="text" class="form-control" name="pan_number" id="edit_pan_number" value="{{Auth::user()->basics->pan_number ?? ''}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Passport Number</label>
                                <input type="text" class="form-control" name="passport_number" id="edit_passport_number" value="{{Auth::user()->basics->passport_number ?? ''}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profession</label>
                                <input type="text" class="form-control" name="profession" id="edit_profession" value="{{Auth::user()->basics->profession ?? ''}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Experience Level <span class="text-danger">*</span></label>
                                <select class="form-select" name="experience" id="edit_experience" required>
                                    <option value="Fresher" {{(Auth::user()->basics->experience ?? '') == 'Fresher' ? 'selected' : ''}}>Fresher</option>
                                    <option value="Experienced" {{(Auth::user()->basics->experience ?? '') == 'Experienced' ? 'selected' : ''}}>Experienced</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Job Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="Job_type" id="edit_job_type" required>
                                    <option value="Part Time" {{(Auth::user()->basics->Job_type ?? '') == 'Part Time' ? 'selected' : ''}}>Part Time</option>
                                    <option value="Permanent" {{(Auth::user()->basics->Job_type ?? '') == 'Permanent' ? 'selected' : ''}}>Permanent</option>
                                    <option value="Contract" {{(Auth::user()->basics->Job_type ?? '') == 'Contract' ? 'selected' : ''}}>Contract</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Differently Abled? <span class="text-danger">*</span></label>
                                <select class="form-select" name="differently_abled" id="edit_differently_abled" required>
                                    <option value="No" {{(Auth::user()->basics->differently_abled ?? '') == 'No' ? 'selected' : ''}}>No</option>
                                    <option value="Yes" {{(Auth::user()->basics->differently_abled ?? '') == 'Yes' ? 'selected' : ''}}>Yes</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alternate Mobile Number</label>
                                <input type="text" class="form-control" name="alternate_mobile_number" id="edit_alternate_mobile_number" value="{{Auth::user()->basics->alternate_mobile_number ?? ''}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="text" class="form-control" name="whatsapp_number" id="edit_whatsapp_number" value="{{Auth::user()->basics->whatsapp_number ?? ''}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alternate Email</label>
                                <input type="email" class="form-control" name="alternate_email_id" id="edit_alternate_email_id" value="{{Auth::user()->basics->alternate_email_id ?? ''}}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveBasicInfo()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Modal -->
    <div class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Addresses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAddressForm">
                        @csrf
                        <div class="row">
                            <!-- Permanent Address -->
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class="fas fa-home me-2"></i>Permanent Address</h6>
                                <div class="mb-3">
                                    <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_address_1" id="edit_permanent_address_1" value="{{Auth::user()->permanentAddress->address_1 ?? ''}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" name="permanent_address_2" id="edit_permanent_address_2" value="{{Auth::user()->permanentAddress->address_2 ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Landmark</label>
                                    <input type="text" class="form-control" name="permanent_landmark" id="edit_permanent_landmark" value="{{Auth::user()->permanentAddress->landmark ?? ''}}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="permanent_city" id="edit_permanent_city" value="{{Auth::user()->permanentAddress->city ?? ''}}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="permanent_state" id="edit_permanent_state" value="{{Auth::user()->permanentAddress->state ?? ''}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="permanent_zip" id="edit_permanent_zip" value="{{Auth::user()->permanentAddress->zip ?? ''}}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="permanent_country" id="edit_permanent_country" value="{{Auth::user()->permanentAddress->country ?? 'India'}}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Police Station <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_police_station" id="edit_permanent_police_station" value="{{Auth::user()->permanentAddress->police_station ?? ''}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Panchayat/Municipality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_panchayat_municipality" id="edit_permanent_panchayat_municipality" value="{{Auth::user()->permanentAddress->panchayat_municipality ?? ''}}" required>
                                </div>
                            </div>

                            <!-- Present Address -->
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="same_as_permanent_edit" onchange="copyPermanentToPresent()">
                                    <label class="form-check-label" for="same_as_permanent_edit">
                                        Same as Permanent Address
                                    </label>
                                </div>
                                <h6 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Present Address</h6>
                                <div class="mb-3">
                                    <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_address_1" id="edit_present_address_1" value="{{Auth::user()->presentAddress->address_1 ?? ''}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" name="present_address_2" id="edit_present_address_2" value="{{Auth::user()->presentAddress->address_2 ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Landmark</label>
                                    <input type="text" class="form-control" name="present_landmark" id="edit_present_landmark" value="{{Auth::user()->presentAddress->landmark ?? ''}}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="present_city" id="edit_present_city" value="{{Auth::user()->presentAddress->city ?? ''}}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="present_state" id="edit_present_state" value="{{Auth::user()->presentAddress->state ?? ''}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="present_zip" id="edit_present_zip" value="{{Auth::user()->presentAddress->zip ?? ''}}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="present_country" id="edit_present_country" value="{{Auth::user()->presentAddress->country ?? 'India'}}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Police Station <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_police_station" id="edit_present_police_station" value="{{Auth::user()->presentAddress->police_station ?? ''}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Panchayat/Municipality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_panchayat_municipality" id="edit_present_panchayat_municipality" value="{{Auth::user()->presentAddress->panchayat_municipality ?? ''}}" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveAddress()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    @php
        $qualifications = \App\Models\Qualification::whereDoesntHave('parents')->get();
        $skillsList = \App\Models\ComputerAndOtherSkill::get();
        $industries = \App\Models\Industry::get();
    @endphp

    <!-- Education Modal -->
    <div class="modal fade" id="editEducationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Education & Qualifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEducationForm" enctype="multipart/form-data">
                        @csrf
                        <div id="education-container">
                            @foreach(Auth::user()->qualifications as $index => $qual)
                            <div class="dynamic-entry education-entry" data-index="{{$index}}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Education #{{$index + 1}}</h6>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeEducationEntry(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Education Level <span class="text-danger">*</span></label>
                                        <select class="form-select edu-main-parent" name="education[{{$index}}][main_parent]" required onchange="loadEducationChildren(this)">
                                            <option value="">Select Education Level</option>
                                            @foreach($qualifications as $mainQual)
                                                <option value="{{ $mainQual->id }}" {{$qual->qualification && $qual->qualification->parents->contains('id', $mainQual->id) ? 'selected' : ''}}>{{ $mainQual->degree }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Specific Qualification <span class="text-danger">*</span></label>
                                        <select class="form-select edu-qualification" name="education[{{$index}}][qualification_id]" required>
                                            <option value="{{$qual->qualification_id}}">{{$qual->qualification->degree ?? 'Select'}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">University/Board <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="education[{{$index}}][university]" value="{{$qual->university}}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Institution Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="education[{{$index}}][institution]" value="{{$qual->institution}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">College (if applicable)</label>
                                        <input type="text" class="form-control" name="education[{{$index}}][college]" value="{{$qual->college}}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">From Year <span class="text-danger">*</span></label>
                                        <select class="form-select" name="education[{{$index}}][from_year]" required>
                                            <option value="">Select</option>
                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                <option value="{{ $i }}" {{$qual->from_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">To Year <span class="text-danger">*</span></label>
                                        <select class="form-select" name="education[{{$index}}][to_year]" required>
                                            <option value="">Select</option>
                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                <option value="{{ $i }}" {{$qual->to_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Percentage</label>
                                        <input type="number" class="form-control" name="education[{{$index}}][percentage]" value="{{$qual->percentage}}" min="0" max="100" step="0.01">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-primary" onclick="addEducationEntry()">
                                <i class="fas fa-plus me-2"></i>Add Education
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveEducation()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Skills Modal -->
    <div class="modal fade" id="editSkillsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 900px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Skills & Expertise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSkillsForm" enctype="multipart/form-data">
                        @csrf
                        <div id="skills-container">
                            @foreach(Auth::user()->skills as $index => $skill)
                            <div class="dynamic-entry skill-entry" data-index="{{$index}}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Skill #{{$index + 1}}</h6>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeSkillEntry(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Skill <span class="text-danger">*</span></label>
                                        <select class="form-select" name="skills[{{$index}}][skill_id]" required>
                                            <option value="">Select Skill</option>
                                            @foreach($skillsList as $s)
                                                <option value="{{ $s->id }}" {{$skill->skill_id == $s->id ? 'selected' : ''}}>{{ $s->skill }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Proficiency <span class="text-danger">*</span></label>
                                        <select class="form-select" name="skills[{{$index}}][proficiency]" required>
                                            <option value="">Select</option>
                                            <option value="Beginner" {{$skill->proficiency == 'Beginner' ? 'selected' : ''}}>Beginner</option>
                                            <option value="Intermediate" {{$skill->proficiency == 'Intermediate' ? 'selected' : ''}}>Intermediate</option>
                                            <option value="Advanced" {{$skill->proficiency == 'Advanced' ? 'selected' : ''}}>Advanced</option>
                                            <option value="Expert" {{$skill->proficiency == 'Expert' ? 'selected' : ''}}>Expert</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Certificate (Optional)</label>
                                        <input type="file" class="form-control" name="skills[{{$index}}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($skill->certificate)
                                            <small class="text-muted">Current: <a href="{{$skill->certificate}}" target="_blank">View</a></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-primary" onclick="addSkillEntry()">
                                <i class="fas fa-plus me-2"></i>Add Skill
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveSkills()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Experience Modal -->
    <div class="modal fade" id="editExperienceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Work Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editExperienceForm" enctype="multipart/form-data">
                        @csrf
                        <div id="experience-container">
                            @foreach(Auth::user()->experiences as $index => $exp)
                            <div class="dynamic-entry experience-entry" data-index="{{$index}}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Experience #{{$index + 1}}</h6>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeExperienceEntry(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Industry/Area of Work <span class="text-danger">*</span></label>
                                        <select class="form-select exp-industry" name="experience[{{$index}}][industry_id]" required onchange="loadJobRoles(this)">
                                            <option value="">Select Industry</option>
                                            @foreach($industries as $industry)
                                                <option value="{{ $industry->id }}" {{$exp->industry_id == $industry->id ? 'selected' : ''}}>{{ $industry->industry_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Job Roles <span class="text-danger">*</span></label>
                                        <select class="form-select exp-roles" name="experience[{{$index}}][role_ids][]" multiple required>
                                            @php
                                                $roleIds = json_decode($exp->role_ids ?? '[]', true);
                                            @endphp
                                            @foreach($industries->find($exp->industry_id)?->children ?? [] as $role)
                                                <option value="{{ $role->id }}" {{in_array($role->id, $roleIds) ? 'selected' : ''}}>{{ $role->industry_name }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Hold Ctrl/Cmd to select multiple roles</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company/Institution Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="experience[{{$index}}][company]" value="{{$exp->company}}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="experience[{{$index}}][location]" value="{{$exp->location}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">From Year <span class="text-danger">*</span></label>
                                        <select class="form-select exp-from-year" name="experience[{{$index}}][from_year]" required onchange="calculateExpDuration(this)">
                                            <option value="">Select</option>
                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                <option value="{{ $i }}" {{$exp->from_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">To Year <span class="text-danger">*</span></label>
                                        <select class="form-select exp-to-year" name="experience[{{$index}}][to_year]" required onchange="calculateExpDuration(this)">
                                            <option value="">Select</option>
                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                <option value="{{ $i }}" {{$exp->to_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            @endfor
                                            <option value="current" {{$exp->to_year == null ? 'selected' : ''}}>Present</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Duration</label>
                                        <input type="text" class="form-control exp-duration" name="experience[{{$index}}][duration]" value="{{$exp->duration}}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Experience Certificate</label>
                                        <input type="file" class="form-control" name="experience[{{$index}}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($exp->certificate)
                                            <small class="text-muted">Current: <a href="{{$exp->certificate}}" target="_blank">View</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Key Responsibilities</label>
                                    <textarea class="form-control" name="experience[{{$index}}][responsibilities]" rows="3">{{$exp->responsibilities}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Achievements</label>
                                    <textarea class="form-control" name="experience[{{$index}}][achievements]" rows="2">{{$exp->achievements}}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Present Salary (Annual)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" class="form-control" name="experience[{{$index}}][present_salary]" value="{{$exp->present_salary}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Expected Salary (Annual)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" class="form-control" name="experience[{{$index}}][expected_salary]" value="{{$exp->expected_salary}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-success" onclick="addExperienceEntry()">
                                <i class="fas fa-plus me-2"></i>Add Experience
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveExperience()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    @php
        $hobbiesData = \App\Models\CandidateHobby::where('user_id', Auth::id())->first();
    @endphp

    <!-- Hobbies Modal -->
    <div class="modal fade" id="editHobbiesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hobbies & Interests</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editHobbiesForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Describe your hobbies and interests</label>
                            <textarea class="form-control" name="hobbies[description]" id="edit_hobbies_description" rows="4">{{$hobbiesData->description ?? ''}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Areas of Interest (comma separated)</label>
                            <input type="text" class="form-control" name="hobbies[interests]" id="edit_hobbies_interests" value="{{$hobbiesData->interests ?? ''}}" placeholder="e.g., Reading, Traveling, Photography, Sports">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveHobbies()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Modal Management
    function openEditModal(type) {
        const modalMap = {
            'basic': 'editBasicModal',
            'address': 'editAddressModal',
            'education': 'editEducationModal',
            'skills': 'editSkillsModal',
            'experience': 'editExperienceModal',
            'hobbies': 'editHobbiesModal'
        };
        
        const modalId = modalMap[type];
        if (modalId) {
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        }
    }

    // Copy permanent address to present address
    function copyPermanentToPresent() {
        if (document.getElementById('same_as_permanent_edit').checked) {
            document.getElementById('edit_present_address_1').value = document.getElementById('edit_permanent_address_1').value;
            document.getElementById('edit_present_address_2').value = document.getElementById('edit_permanent_address_2').value;
            document.getElementById('edit_present_landmark').value = document.getElementById('edit_permanent_landmark').value;
            document.getElementById('edit_present_city').value = document.getElementById('edit_permanent_city').value;
            document.getElementById('edit_present_state').value = document.getElementById('edit_permanent_state').value;
            document.getElementById('edit_present_zip').value = document.getElementById('edit_permanent_zip').value;
            document.getElementById('edit_present_country').value = document.getElementById('edit_permanent_country').value;
            document.getElementById('edit_present_police_station').value = document.getElementById('edit_permanent_police_station').value;
            document.getElementById('edit_present_panchayat_municipality').value = document.getElementById('edit_permanent_panchayat_municipality').value;
        }
    }

    // Save Basic Information
    function saveBasicInfo() {
        const form = document.getElementById('editBasicForm');
        const formData = new FormData(form);
        
        fetch('{{ route("employee.update-basic") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Basic information updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving');
        });
    }

    // Save Address
    function saveAddress() {
        const form = document.getElementById('editAddressForm');
        const formData = new FormData(form);
        
        fetch('{{ route("employee.update-address") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Addresses updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving');
        });
    }

    // ==================== EDUCATION FUNCTIONS ====================
    let educationCount = {{Auth::user()->qualifications->count()}};
    
    function addEducationEntry() {
        const template = `
            <div class="dynamic-entry education-entry" data-index="${educationCount}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Education #${educationCount + 1}</h6>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeEducationEntry(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Education Level <span class="text-danger">*</span></label>
                        <select class="form-select edu-main-parent" name="education[${educationCount}][main_parent]" required onchange="loadEducationChildren(this)">
                            <option value="">Select Education Level</option>
                            @foreach($qualifications as $mainQual)
                                <option value="{{ $mainQual->id }}">{{ $mainQual->degree }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Specific Qualification <span class="text-danger">*</span></label>
                        <select class="form-select edu-qualification" name="education[${educationCount}][qualification_id]" required disabled>
                            <option value="">Select Education Level First</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">University/Board <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="education[${educationCount}][university]" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Institution Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="education[${educationCount}][institution]" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">College (if applicable)</label>
                        <input type="text" class="form-control" name="education[${educationCount}][college]">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">From Year <span class="text-danger">*</span></label>
                        <select class="form-select" name="education[${educationCount}][from_year]" required>
                            <option value="">Select</option>
                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">To Year <span class="text-danger">*</span></label>
                        <select class="form-select" name="education[${educationCount}][to_year]" required>
                            <option value="">Select</option>
                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Percentage</label>
                        <input type="number" class="form-control" name="education[${educationCount}][percentage]" min="0" max="100" step="0.01">
                    </div>
                </div>
            </div>
        `;
        const container = document.getElementById('education-container');
        const div = document.createElement('div');
        div.innerHTML = template;
        container.appendChild(div.firstElementChild);
        educationCount++;
    }

    function removeEducationEntry(btn) {
        btn.closest('.education-entry').remove();
    }

    function loadEducationChildren(select) {
        const parentId = select.value;
        const entry = select.closest('.education-entry');
        const qualSelect = entry.querySelector('.edu-qualification');
        
        qualSelect.innerHTML = '<option value="">Loading...</option>';
        qualSelect.disabled = true;
        
        if (!parentId) {
            qualSelect.innerHTML = '<option value="">Select Education Level First</option>';
            return;
        }

        fetch(`/api/qualifications/${parentId}/all-children`)
            .then(res => res.json())
            .then(data => {
                qualSelect.innerHTML = '<option value="">Select Specific Qualification</option>';
                if (data.length > 0) {
                    data.forEach(item => {
                        let prefix = '';
                        for (let i = 0; i < item.level; i++) {
                            prefix += '- ';
                        }
                        qualSelect.innerHTML += `<option value="${item.id}">${prefix}${item.name}</option>`;
                    });
                    qualSelect.disabled = false;
                } else {
                    qualSelect.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                    qualSelect.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error loading qualifications:', error);
                qualSelect.innerHTML = '<option value="">Error loading options</option>';
            });
    }

    function saveEducation() {
        const form = document.getElementById('editEducationForm');
        const formData = new FormData(form);
        
        fetch('{{ route("employee.update-education") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Education updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving');
        });
    }

    // ==================== SKILLS FUNCTIONS ====================
    let skillCount = {{Auth::user()->skills->count()}};
    
    function addSkillEntry() {
        const template = `
            <div class="dynamic-entry skill-entry" data-index="${skillCount}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Skill #${skillCount + 1}</h6>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeSkillEntry(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Skill <span class="text-danger">*</span></label>
                        <select class="form-select" name="skills[${skillCount}][skill_id]" required>
                            <option value="">Select Skill</option>
                            @foreach($skillsList as $s)
                                <option value="{{ $s->id }}">{{ $s->skill }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Proficiency <span class="text-danger">*</span></label>
                        <select class="form-select" name="skills[${skillCount}][proficiency]" required>
                            <option value="">Select</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Certificate (Optional)</label>
                        <input type="file" class="form-control" name="skills[${skillCount}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
            </div>
        `;
        const container = document.getElementById('skills-container');
        const div = document.createElement('div');
        div.innerHTML = template;
        container.appendChild(div.firstElementChild);
        skillCount++;
    }

    function removeSkillEntry(btn) {
        btn.closest('.skill-entry').remove();
    }

    function saveSkills() {
        const form = document.getElementById('editSkillsForm');
        const formData = new FormData(form);
        
        fetch('{{ route("employee.update-skills") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Skills updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving');
        });
    }

    // ==================== EXPERIENCE FUNCTIONS ====================
    let experienceCount = {{Auth::user()->experiences->count()}};
    
    function addExperienceEntry() {
        const template = `
            <div class="dynamic-entry experience-entry" data-index="${experienceCount}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Experience #${experienceCount + 1}</h6>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeExperienceEntry(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Industry/Area of Work <span class="text-danger">*</span></label>
                        <select class="form-select exp-industry" name="experience[${experienceCount}][industry_id]" required onchange="loadJobRoles(this)">
                            <option value="">Select Industry</option>
                            @foreach($industries as $industry)
                                <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Job Roles <span class="text-danger">*</span></label>
                        <select class="form-select exp-roles" name="experience[${experienceCount}][role_ids][]" multiple required disabled>
                            <option value="">Select Industry First</option>
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple roles</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company/Institution Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="experience[${experienceCount}][company]" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" name="experience[${experienceCount}][location]">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">From Year <span class="text-danger">*</span></label>
                        <select class="form-select exp-from-year" name="experience[${experienceCount}][from_year]" required onchange="calculateExpDuration(this)">
                            <option value="">Select</option>
                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">To Year <span class="text-danger">*</span></label>
                        <select class="form-select exp-to-year" name="experience[${experienceCount}][to_year]" required onchange="calculateExpDuration(this)">
                            <option value="">Select</option>
                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                            <option value="current">Present</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Duration</label>
                        <input type="text" class="form-control exp-duration" name="experience[${experienceCount}][duration]" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Experience Certificate</label>
                        <input type="file" class="form-control" name="experience[${experienceCount}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Key Responsibilities</label>
                    <textarea class="form-control" name="experience[${experienceCount}][responsibilities]" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Achievements</label>
                    <textarea class="form-control" name="experience[${experienceCount}][achievements]" rows="2"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Present Salary (Annual)</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="experience[${experienceCount}][present_salary]">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expected Salary (Annual)</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="experience[${experienceCount}][expected_salary]">
                        </div>
                    </div>
                </div>
            </div>
        `;
        const container = document.getElementById('experience-container');
        const div = document.createElement('div');
        div.innerHTML = template;
        container.appendChild(div.firstElementChild);
        experienceCount++;
    }

    function removeExperienceEntry(btn) {
        btn.closest('.experience-entry').remove();
    }

    function loadJobRoles(select) {
        const industryId = select.value;
        const entry = select.closest('.experience-entry');
        const rolesSelect = entry.querySelector('.exp-roles');
        
        rolesSelect.innerHTML = '<option value="">Loading...</option>';
        rolesSelect.disabled = true;
        
        if (!industryId) {
            rolesSelect.innerHTML = '<option value="">Select Industry First</option>';
            return;
        }

        fetch(`/api/industries/${industryId}/roles`)
            .then(res => res.json())
            .then(data => {
                rolesSelect.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(role => {
                        rolesSelect.innerHTML += `<option value="${role.id}">${role.name}</option>`;
                    });
                    rolesSelect.disabled = false;
                } else {
                    rolesSelect.innerHTML = '<option value="">No roles available</option>';
                }
            })
            .catch(error => {
                console.error('Error loading roles:', error);
                rolesSelect.innerHTML = '<option value="">Error loading roles</option>';
            });
    }

    function calculateExpDuration(element) {
        const entry = element.closest('.experience-entry');
        const fromYear = entry.querySelector('.exp-from-year').value;
        const toYear = entry.querySelector('.exp-to-year').value;
        const durationField = entry.querySelector('.exp-duration');
        
        if (fromYear && toYear) {
            let endYear = toYear === 'current' ? new Date().getFullYear() : parseInt(toYear);
            let startYear = parseInt(fromYear);
            
            if (endYear >= startYear) {
                let years = endYear - startYear;
                durationField.value = years + (years === 1 ? ' year' : ' years');
            } else {
                durationField.value = '';
            }
        }
    }

    function saveExperience() {
        const form = document.getElementById('editExperienceForm');
        const formData = new FormData(form);
        
        fetch('{{ route("employee.update-experience") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Experience updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving');
        });
    }

    // ==================== HOBBIES FUNCTIONS ====================
    function saveHobbies() {
        const form = document.getElementById('editHobbiesForm');
        const formData = new FormData(form);
        
        fetch('{{ route("employee.update-hobbies") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Hobbies updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving');
        });
    }
</script>
@endsection
