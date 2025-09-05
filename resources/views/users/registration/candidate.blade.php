@extends('layouts.app')

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
                    <form id="form-wizard1" class="mt-3 text-center">
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
                                    <span class="dark-wizard">Image</span>
                                </a>
                            </li>
                            <li id="confirm" class="mb-2 col-lg-3 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg"  width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Finish</span>
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
                                    <h3 class="mb-4">Image Upload:</h3>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 3 - 4</h2>
                                </div>
                                </div>
                                <div class="form-group">
                                <label class="form-label">Upload Your Photo:</label>
                                <input type="file" class="form-control" name="pic" accept="image/*">
                                </div>
                                <div class="form-group">
                                <label class="form-label">Upload Signature Photo:</label>
                                <input type="file" class="form-control" name="pic-2" accept="image/*">
                                </div>
                            </div>
                            <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Submit" >Submit</button>
                            <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-1" value="Previous" >Previous</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                <div class="col-7">
                                    <h3 class="mb-4 text-left">Finish:</h3>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 4 - 4</h2>
                                </div>
                                </div>
                                <br><br>
                                <h2 class="text-center text-success"><strong>SUCCESS !</strong></h2>
                                <br>
                                <div class="row justify-content-center">
                                <div class="col-3"> <img src="../../assets/images/pages/img-success.png" class="img-fluid" alt="fit-image"> </div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                <div class="text-center col-7">
                                    <h5 class="text-center purple-text">You Have Successfully Signed Up</h5>
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
                    nextBtnFunction(1);
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
    </script>
@endsection