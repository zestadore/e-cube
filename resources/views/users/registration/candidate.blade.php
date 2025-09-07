@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
    <div>
        <div class="row container justify-content-center" style="width: 100% !important;">                
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Create Your Stunning Profile</h4>
                    </div>
                    </div>
                    <div class="card-body">
                    <form id="form-wizard1" class="mt-3 text-center" enctype="multipart/form-data">
                        <ul id="top-tab-list" class="p-0 row list-inline">
                            <li class="mb-2 col-lg-3 col-md-6 text-start active" id="account">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg"  width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>                                        
                                    </div>
                                    <span class="dark-wizard">Basic Details</span>
                                </a>
                            </li>
                            <li id="personal" class="mb-2 col-lg-3 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg"  width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Address</span>
                                </a>
                            </li>
                            <li id="payment" class="mb-2 col-lg-3 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg"  width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Skills</span>
                                </a>
                            </li>
                            <li id="confirm" class="mb-2 col-lg-3 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg"  width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Experience</span>
                                </a>
                            </li>
                        </ul>
                        <!-- fieldsets -->
                        <fieldset>
                            <div class="form-card text-start">
                                <div class="row">
                                <div class="col-7">
                                    <h3 class="mb-4">Let us know something about you:</h3>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 1 - 4</h2>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('dob') ? ' is-invalid' : '' }}" title="Date of birth" name="dob" id="dob" type="date" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Gender: <span style="color:red;"> *</span></label>
                                            <select name="gender" id="gender" class="form-control form-select {{ $errors->has('gender') ? ' is-invalid' : '' }}" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('alternate_mobile_number') ? ' is-invalid' : '' }}" title="Alternate mobile number" name="alternate_mobile_number" id="alternate_mobile_number" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('whatsapp_number') ? ' is-invalid' : '' }}" title="WhatsApp number" name="whatsapp_number" id="whatsapp_number" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('alternate_email_id') ? ' is-invalid' : '' }}" title="Alternate email" name="alternate_email_id" id="alternate_email_id" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('aadhar_number') ? ' is-invalid' : '' }}" title="Aadhar number" name="aadhar_number" id="aadhar_number" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('pan_number') ? ' is-invalid' : '' }}" title="PAN number" name="pan_number" id="pan_number" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('passport_number') ? ' is-invalid' : '' }}" title="Passport number" name="passport_number" id="passport_number" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('profession') ? ' is-invalid' : '' }}" title="Profession" name="profession" id="profession" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Experience: <span style="color:red;"> *</span></label>
                                        <select name="experience" id="experience" class="form-control form-select {{ $errors->has('experience') ? ' is-invalid' : '' }}" required>
                                            <option value="Fresher">Fresher</option>
                                            <option value="Experienced">Experienced</option>
                                        </select>
                                        @error('experience')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Job type: <span style="color:red;"> *</span></label>
                                        <select name="Job_type" id="Job_type" class="form-control form-select {{ $errors->has('Job_type') ? ' is-invalid' : '' }}" required>
                                            <option value="Part Time">Part Time</option>
                                            <option value="Permanent">Permanent</option>
                                        </select>
                                        @error('Job_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Differently abled?: <span style="color:red;"> *</span></label>
                                        <select name="differently_abled" id="differently_abled" class="form-control form-select {{ $errors->has('differently_abled') ? ' is-invalid' : '' }}" required>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        @error('Job_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                
                            </div>
                            <p> </p>
                            <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Next" >Next</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card text-start">
                                <div class="row">
                                <div class="col-7">
                                    <h3 class="mb-4">Address Information:</h3>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 2 - 4</h2>
                                </div>
                                </div>
                                
                                <!-- Permanent Address Section -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="mb-3">Permanent Address</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_address_1') ? ' is-invalid' : '' }}" title="Address Line 1" name="permanent_address_1" id="permanent_address_1" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_address_2') ? ' is-invalid' : '' }}" title="Address Line 2" name="permanent_address_2" id="permanent_address_2" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_landmark') ? ' is-invalid' : '' }}" title="Landmark" name="permanent_landmark" id="permanent_landmark" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_city') ? ' is-invalid' : '' }}" title="City" name="permanent_city" id="permanent_city" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_state') ? ' is-invalid' : '' }}" title="State" name="permanent_state" id="permanent_state" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_zip') ? ' is-invalid' : '' }}" title="Pincode" name="permanent_zip" id="permanent_zip" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_country') ? ' is-invalid' : '' }}" title="Country" name="permanent_country" id="permanent_country" type="text" required="True" value="India"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_police_station') ? ' is-invalid' : '' }}" title="Police Station" name="permanent_police_station" id="permanent_police_station" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('permanent_panchayat_municipality') ? ' is-invalid' : '' }}" title="Panchayat/Municipality" name="permanent_panchayat_municipality" id="permanent_panchayat_municipality" type="text" required="True"/>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="same_as_permanent" name="same_as_permanent">
                                            <label class="form-check-label" for="same_as_permanent">
                                                Present address same as permanent address
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Present Address Section -->
                                <div class="row" id="present_address_section">
                                    <div class="col-12">
                                        <h4 class="mb-3">Present Address</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_address_1') ? ' is-invalid' : '' }}" title="Address Line 1" name="present_address_1" id="present_address_1" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_address_2') ? ' is-invalid' : '' }}" title="Address Line 2" name="present_address_2" id="present_address_2" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_landmark') ? ' is-invalid' : '' }}" title="Landmark" name="present_landmark" id="present_landmark" type="text" required="False"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_city') ? ' is-invalid' : '' }}" title="City" name="present_city" id="present_city" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_state') ? ' is-invalid' : '' }}" title="State" name="present_state" id="present_state" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_zip') ? ' is-invalid' : '' }}" title="Pincode" name="present_zip" id="present_zip" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_country') ? ' is-invalid' : '' }}" title="Country" name="present_country" id="present_country" type="text" required="True" value="India"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_police_station') ? ' is-invalid' : '' }}" title="Police Station" name="present_police_station" id="present_police_station" type="text" required="True"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-InputBox class="form-control {{ $errors->has('present_panchayat_municipality') ? ' is-invalid' : '' }}" title="Panchayat/Municipality" name="present_panchayat_municipality" id="present_panchayat_municipality" type="text" required="True"/>
                                    </div>
                                </div>
                            </div>
                            <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Next" >Next</button>
                            <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-1" value="Previous" >Previous</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card text-start">
                                <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4">Qualifications:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 3 - 4</h2>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="qualification_table">
                                                <thead>
                                                    <tr>
                                                        <th>Qualification</th>
                                                        <th>University/School</th>
                                                        <th>From Year</th>
                                                        <th>To Year</th>
                                                        <th>Percentage of Marks</th>
                                                        <th>Upload Certificate</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select name="qualifications[0][qualification]" class="form-control form-select qualification" required>
                                                                <option value="">Select Qualification</option>
                                                                @foreach($qualifications as $qualification)
                                                                    <option value="{{ $qualification->id }}">{{ $qualification->degree }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="qualifications[0][university]" class="form-control" placeholder="University/School" required>
                                                        </td>
                                                        <td>
                                                            <select name="qualifications[0][from_year]" class="form-control form-select" required>
                                                                <option value="">Select Year</option>
                                                                @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="qualifications[0][to_year]" class="form-control form-select" required>
                                                                <option value="">Select Year</option>
                                                                @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="qualifications[0][percentage]" class="form-control" placeholder="Percentage" min="0" max="100" step="0.01" required>
                                                        </td>
                                                        <td>
                                            <input type="file" name="qualifications[0][certificate]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm add-qualification-row">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm remove-qualification-row" style="display: none;">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-7">
                                    <h3 class="mb-4">Skills:</h3>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="skills_table">
                                            <thead>
                                                <tr>
                                                    <th>Skill</th>
                                                    <th>University/School</th>
                                                    <th>From Year</th>
                                                    <th>To Year</th>
                                                    <th>Percentage of Marks</th>
                                                    <th>Upload Certificate</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="skill-row">
                                                    <td>
                                                        <select name="skills[0][skill]" class="form-control form-select skill" required>
                                                            <option value="">Select Skill</option>
                                                            @foreach($skills as $skill)
                                                                <option value="{{ $skill->id }}">{{ $skill->skill }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="skills[0][university]" class="form-control" placeholder="University/School" required>
                                                    </td>
                                                    <td>
                                                        <select name="skills[0][from_year]" class="form-control form-select" required>
                                                            <option value="">Select Year</option>
                                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="skills[0][to_year]" class="form-control form-select" required>
                                                            <option value="">Select Year</option>
                                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="skills[0][percentage]" class="form-control" placeholder="Percentage" min="0" max="100" step="0.01" required>
                                                    </td>
                                                    <td>
                                                        <input type="file" name="skills[0][certificate]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm add-skill-row">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm remove-skill-row" style="display: none;">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Submit" >Submit</button>
                            <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-1" value="Previous" >Previous</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4 text-left">Experience:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 4 - 4</h2>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="experiences_table">
                                                <thead>
                                                    <tr>
                                                        <th>Industry/Area of Work</th>
                                                        <th>Roles</th>
                                                        <th>Name of Company/Institution</th>
                                                        <th>From Year</th>
                                                        <th>To Year</th>
                                                        <th>Duration</th>
                                                        <th>Upload Experience Certificate</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="experience-row">
                                                        <td>
                                                            <select name="experiences[0][industry]" class="form-control form-select industry" required>
                                                                <option value="">Select Industry</option>
                                                                @foreach($industries as $industry)
                                                                    <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td style="width: 100px;">
                                                            <select name="experiences[0][roles][]" class="form-control form-select roles" multiple required>
                                                                @foreach($industries as $industry)
                                                                    <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="experiences[0][company]" class="form-control" placeholder="Company/Institution Name" required>
                                                        </td>
                                                        <td>
                                                            <select name="experiences[0][from_year]" class="form-control form-select" required>
                                                                <option value="">Select Year</option>
                                                                @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="experiences[0][to_year]" class="form-control form-select" required>
                                                                <option value="">Select Year</option>
                                                                @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="experiences[0][duration]" class="form-control" placeholder="Duration" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="file" name="experiences[0][certificate]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm add-experience-row">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm remove-experience-row" style="display: none;">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
    <script>
        (function () 
        {
            "use strict";
            /*---------------------------------------------------------------------
                Fieldset
            -----------------------------------------------------------------------*/
            
            let currentTab =0;
            const ActiveTab=(n)=>{
                if(n==0){
                    document.getElementById("account").classList.add("active");
                    document.getElementById("account").classList.remove("done");
                    document.getElementById("personal").classList.remove("done");
                    document.getElementById("personal").classList.remove("active");
                }
                if(n==1){
                    saveBasicDetails();
                    document.getElementById("account").classList.add("done");
                    document.getElementById("personal").classList.add("active");
                    document.getElementById("personal").classList.remove("done");
                    document.getElementById("payment").classList.remove("active");
                    document.getElementById("payment").classList.remove("done");
                    document.getElementById("confirm").classList.remove("done");
                    document.getElementById("confirm").classList.remove("active");

                }
                if(n==2){
                    saveAddressDetails();
                    document.getElementById("account").classList.add("done");
                    document.getElementById("personal").classList.add("done");
                    document.getElementById("payment").classList.add("active");
                    document.getElementById("payment").classList.remove("done");
                    document.getElementById("confirm").classList.remove("done");
                    document.getElementById("confirm").classList.remove("active");
                }
                if(n==3){
                    document.getElementById("account").classList.add("done");
                    document.getElementById("personal").classList.add("done");
                    document.getElementById("payment").classList.add("done");
                    document.getElementById("confirm").classList.add("active");
                    document.getElementById("confirm").classList.remove("done");
                }
            } 
            const showTab=(n)=>{
                var x = document.getElementsByTagName("fieldset");
                x[n].style.display = "block";
                console.log(n);
                ActiveTab(n);
            
            }
            const nextBtnFunction= (n) => {
                var x = document.getElementsByTagName("fieldset");
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
                showTab(currentTab);
            }
        
            const nextbtn= document.querySelectorAll('.next')
            Array.from(nextbtn, (nbtn) => {
                nbtn.addEventListener('click',function()
                {
                    // Check which step we're on and call appropriate save function
                    if (currentTab === 0) {
                        // Basic details step
                        saveBasicDetails();
                        nextBtnFunction(1);
                    } else if (currentTab === 1) {
                        // Address step
                        saveAddressDetails();
                        nextBtnFunction(1);
                    } else if (currentTab === 2) {
                        // Qualification step
                        if (saveQualificationDetails()) {
                            nextBtnFunction(1);
                        }
                    } else {
                        nextBtnFunction(1);
                    }
                })
            });

            // previousbutton

            const prebtn= document.querySelectorAll('.previous')
                Array.from(prebtn, (pbtn) => {
                pbtn.addEventListener('click',function()
                {
                    nextBtnFunction(-1);
                })
            });
            
            // Handle same as permanent address checkbox
            const sameAsPermanentCheckbox = document.getElementById('same_as_permanent');
            if (sameAsPermanentCheckbox) {
                sameAsPermanentCheckbox.addEventListener('change', function() {
                    const presentAddressSection = document.getElementById('present_address_section');
                    
                    if (this.checked) {
                        // Copy values from permanent address to present address
                        $('#present_address_1').val($('#permanent_address_1').val());
                        $('#present_address_2').val($('#permanent_address_2').val());
                        $('#present_landmark').val($('#permanent_landmark').val());
                        $('#present_city').val($('#permanent_city').val());
                        $('#present_state').val($('#permanent_state').val());
                        $('#present_zip').val($('#permanent_zip').val());
                        $('#present_country').val($('#permanent_country').val());
                        $('#present_police_station').val($('#permanent_police_station').val());
                        $('#present_panchayat_municipality').val($('#permanent_panchayat_municipality').val());
                        
                        // Hide present address section
                        presentAddressSection.style.display = 'none';
                    } else {
                        // Show present address section
                        presentAddressSection.style.display = 'flex';
                        
                        // Clear present address fields
                        $('#present_address_1').val('');
                        $('#present_address_2').val('');
                        $('#present_landmark').val('');
                        $('#present_city').val('');
                        $('#present_state').val('');
                        $('#present_zip').val('');
                        $('#present_country').val('India');
                        $('#present_police_station').val('');
                        $('#present_panchayat_municipality').val('');
                    }
                });
            }
        })()

        function saveBasicDetails(){
            let data = $('#addForm').serialize();
            // Add your AJAX code here to save basic details
        }
        
        function saveAddressDetails(){
            // Add your AJAX code here to save address details
            // This function will be called when moving from address step to next step
        }
        
        function saveQualificationDetails(){
            // Validate qualification fields
            let isValid = true;
            $('.qualification-row').each(function(index) {
                const rowNum = index + 1;
                const qualification = $(this).find('[name^="qualifications"][name$="[qualification]"]').val();
                const university = $(this).find('[name^="qualifications"][name$="[university]"]').val();
                const fromYear = $(this).find('[name^="qualifications"][name$="[from_year]"]').val();
                const toYear = $(this).find('[name^="qualifications"][name$="[to_year]"]').val();
                const percentage = $(this).find('[name^="qualifications"][name$="[percentage]"]').val();
                const certificate = $(this).find('[name^="qualifications"][name$="[certificate]"]')[0];
                
                if (!qualification) {
                    alert('Please enter Qualification for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (!university) {
                    alert('Please enter University/School for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (!fromYear) {
                    alert('Please select From Year for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (!toYear) {
                    alert('Please select To Year for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (parseInt(fromYear) > parseInt(toYear)) {
                    alert('From Year cannot be greater than To Year in row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (!percentage) {
                    alert('Please enter Percentage of Marks for row ' + rowNum);
                    isValid = false;
                    return false;
                } else if (isNaN(percentage) || parseFloat(percentage) < 0 || parseFloat(percentage) > 100) {
                    alert('Percentage of Marks must be a number between 0 and 100 for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                
                // Check if file is selected and validate file type
                if (certificate && certificate.files && certificate.files.length > 0) {
                    const file = certificate.files[0];
                    const validTypes = ['.pdf', '.jpg', '.jpeg', '.png', '.doc', '.docx'];
                    const fileExt = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
                    
                    if (!validTypes.includes(fileExt)) {
                        alert('Invalid file type for certificate in row ' + rowNum + '. Allowed types: PDF, JPG, JPEG, PNG, DOC, DOCX');
                        isValid = false;
                        return false;
                    }
                    
                    // Check file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Certificate file size exceeds 5MB limit in row ' + rowNum);
                        isValid = false;
                        return false;
                    }
                }
            });
            
            // Validate skills fields
            $('.skill-row').each(function(index) {
                const rowNum = index + 1;
                const skill = $(this).find('[name^="skills"][name$="[skill]"]').val();
                const university = $(this).find('[name^="skills"][name$="[university]"]').val();
                const fromYear = $(this).find('[name^="skills"][name$="[from_year]"]').val();
                const toYear = $(this).find('[name^="skills"][name$="[to_year]"]').val();
                const percentage = $(this).find('[name^="skills"][name$="[percentage]"]').val();
                const certificate = $(this).find('[name^="skills"][name$="[certificate]"]')[0];
                
                if (!skill) {
                    alert('Please select Skill for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (!university) {
                    alert('Please enter University/School for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (!fromYear) {
                    alert('Please select From Year for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (!toYear) {
                    alert('Please select To Year for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (parseInt(fromYear) > parseInt(toYear)) {
                    alert('From Year cannot be greater than To Year in row ' + rowNum);
                    isValid = false;
                    return false;
                }
                if (!percentage) {
                    alert('Please enter Percentage of Marks for row ' + rowNum);
                    isValid = false;
                    return false;
                } else if (isNaN(percentage) || parseFloat(percentage) < 0 || parseFloat(percentage) > 100) {
                    alert('Percentage of Marks must be a number between 0 and 100 for row ' + rowNum);
                    isValid = false;
                    return false;
                }
                
                // Check if file is selected and validate file type
                if (certificate && certificate.files && certificate.files.length > 0) {
                    const file = certificate.files[0];
                    const validTypes = ['.pdf', '.jpg', '.jpeg', '.png', '.doc', '.docx'];
                    const fileExt = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
                    
                    if (!validTypes.includes(fileExt)) {
                        alert('Invalid file type for certificate in row ' + rowNum + '. Allowed types: PDF, JPG, JPEG, PNG, DOC, DOCX');
                        isValid = false;
                        return false;
                    }
                    
                    // Check file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Certificate file size exceeds 5MB limit in row ' + rowNum);
                        isValid = false;
                        return false;
                    }
                }
            });
            
            if (isValid) {
                // Add your AJAX code here to save qualification details
                var formData = new FormData($('#form-wizard1')[0]);
                // Add AJAX submission code here
                return true;
            }
            return false;
        }
        
        // Qualification Add More Functionality
        $(document).ready(function() {
            // Add new qualification row
            $(document).on('click', '.add-qualification-row', function() {
                var rowCount = $('#qualification_table tbody tr').length;
                var newRow = `
                    <tr class="qualification-row">
                        <td>
                            <select name="qualifications[${rowCount}][qualification]" class="form-control form-select qualification" required>
                                <option value="">Select Qualification</option>
                                @foreach($qualifications as $qualification)
                                    <option value="{{ $qualification->id }}">{{ $qualification->degree }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="qualifications[${rowCount}][university]" class="form-control" placeholder="University/School" required>
                        </td>
                        <td>
                            <select name="qualifications[${rowCount}][from_year]" class="form-control form-select" required>
                                <option value="">Select Year</option>
                                ${generateYearOptions()}
                            </select>
                        </td>
                        <td>
                            <select name="qualifications[${rowCount}][to_year]" class="form-control form-select" required>
                                <option value="">Select Year</option>
                                ${generateYearOptions()}
                            </select>
                        </td>
                        <td>
                            <input type="number" name="qualifications[${rowCount}][percentage]" class="form-control" placeholder="Percentage" min="0" max="100" step="0.01" required>
                        </td>
                        <td>
                            <input type="file" name="qualifications[${rowCount}][certificate]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm add-qualification-row">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-qualification-row">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#qualification_table tbody').append(newRow);
                updateDeleteButtonVisibility();
            });
            
            // Remove qualification row
            $(document).on('click', '.remove-qualification-row', function() {
                $(this).closest('tr').remove();
                reindexQualificationRows();
                updateDeleteButtonVisibility();
            });
            
            // Function to generate year options
            function generateYearOptions() {
                var currentYear = new Date().getFullYear();
                var options = '';
                for (var i = currentYear; i >= currentYear - 50; i--) {
                    options += `<option value="${i}">${i}</option>`;
                }
                return options;
            }
            
            // Function to reindex qualification rows after deletion
            function reindexQualificationRows() {
                $('#qualification_table tbody tr').each(function(index) {
                    $(this).find('select, input').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            var newName = name.replace(/qualifications\[(\d+)\]/, `qualifications[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
            
            // Function to update delete button visibility
            function updateDeleteButtonVisibility() {
                var rows = $('#qualification_table tbody tr');
                if (rows.length === 1) {
                    // If only one row, hide the delete button
                    rows.find('.remove-qualification-row').hide();
                } else {
                    // If multiple rows, show all delete buttons
                    rows.find('.remove-qualification-row').show();
                }
            }
            
            // Skills Add More Functionality
            // Add new skill row
            $(document).on('click', '.add-skill-row', function() {
                var rowCount = $('#skills_table tbody tr').length;
                var newRow = `
                    <tr class="skill-row">
                        <td>
                            <select name="skills[${rowCount}][skill]" class="form-control form-select skill" required>
                                <option value="">Select Skill</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}">{{ $skill->skill }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="skills[${rowCount}][university]" class="form-control" placeholder="University/School" required>
                        </td>
                        <td>
                            <select name="skills[${rowCount}][from_year]" class="form-control form-select" required>
                                <option value="">Select Year</option>
                                ${generateYearOptions()}
                            </select>
                        </td>
                        <td>
                            <select name="skills[${rowCount}][to_year]" class="form-control form-select" required>
                                <option value="">Select Year</option>
                                ${generateYearOptions()}
                            </select>
                        </td>
                        <td>
                            <input type="number" name="skills[${rowCount}][percentage]" class="form-control" placeholder="Percentage" min="0" max="100" step="0.01" required>
                        </td>
                        <td>
                            <input type="file" name="skills[${rowCount}][certificate]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm add-skill-row">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-skill-row">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#skills_table tbody').append(newRow);
                reindexSkillRows();
                updateSkillDeleteButtonVisibility();
            });
            
            // Remove skill row
            $(document).on('click', '.remove-skill-row', function() {
                $(this).closest('tr').remove();
                reindexSkillRows();
                updateSkillDeleteButtonVisibility();
            });
            
            // Function to reindex skill rows after deletion
            function reindexSkillRows() {
                $('#skills_table tbody tr').each(function(index) {
                    $(this).find('select, input').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            var newName = name.replace(/skills\[(\d+)\]/, `skills[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
            
            // Function to update skill delete button visibility
            function updateSkillDeleteButtonVisibility() {
                var rows = $('#skills_table tbody tr');
                if (rows.length === 1) {
                    // If only one row, hide the delete button
                    rows.find('.remove-skill-row').hide();
                } else {
                    // If multiple rows, show all delete buttons
                    rows.find('.remove-skill-row').show();
                }
            }

            // Experience Add More Functionality
            // Add new experience row
            $(document).on('click', '.add-experience-row', function() {
                var rowCount = $('#experiences_table tbody tr').length;
                var newRow = `
                    <tr class="experience-row">
                        <td>
                            <select name="experiences[${rowCount}][industry]" class="form-control form-select industry" required>
                                <option value="">Select Industry</option>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="experiences[${rowCount}][roles][]" class="form-control form-select roles" multiple required>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="experiences[${rowCount}][company]" class="form-control" placeholder="Company/Institution Name" required>
                        </td>
                        <td>
                            <select name="experiences[${rowCount}][from_year]" class="form-control form-select from-year" required>
                                <option value="">Select Year</option>
                                ${generateYearOptions()}
                            </select>
                        </td>
                        <td>
                            <select name="experiences[${rowCount}][to_year]" class="form-control form-select to-year" required>
                                <option value="">Select Year</option>
                                ${generateYearOptions()}
                            </select>
                        </td>
                        <td>
                            <input type="text" name="experiences[${rowCount}][duration]" class="form-control duration" placeholder="Duration" readonly>
                        </td>
                        <td>
                            <input type="file" name="experiences[${rowCount}][certificate]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm add-experience-row">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-experience-row">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#experiences_table tbody').append(newRow);
                reindexExperienceRows();
                updateExperienceDeleteButtonVisibility();
            });
            
            // Remove experience row
            $(document).on('click', '.remove-experience-row', function() {
                $(this).closest('tr').remove();
                reindexExperienceRows();
                updateExperienceDeleteButtonVisibility();
            });
            
            // Calculate duration when from_year or to_year changes
            $(document).on('change', '.experience-row .from-year, .experience-row .to-year', function() {
                var row = $(this).closest('tr');
                var fromYear = parseInt(row.find('.from-year').val());
                var toYear = parseInt(row.find('.to-year').val());
                
                if (!isNaN(fromYear) && !isNaN(toYear)) {
                    if (toYear >= fromYear) {
                        var duration = (toYear - fromYear) + 1;
                        row.find('.duration').val(duration + ' year(s)');
                    } else {
                        row.find('.duration').val('');
                        alert('To Year must be greater than or equal to From Year');
                    }
                }
            });
            
            // Function to reindex experience rows after deletion
            function reindexExperienceRows() {
                $('#experiences_table tbody tr').each(function(index) {
                    $(this).find('select, input').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            var newName = name.replace(/experiences\[(\d+)\]/, `experiences[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
            
            // Function to update experience delete button visibility
            function updateExperienceDeleteButtonVisibility() {
                var rows = $('#experiences_table tbody tr');
                if (rows.length === 1) {
                    // If only one row, hide the delete button
                    rows.find('.remove-experience-row').hide();
                } else {
                    // If multiple rows, show all delete buttons
                    rows.find('.remove-experience-row').show();
                }
            }
            
            // Initialize delete buttons visibility
            updateDeleteButtonVisibility();
            updateSkillDeleteButtonVisibility();
            updateExperienceDeleteButtonVisibility();
        });
    </script>
@endsection