@extends('layouts.app')

@section('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
        --success-color: #1cc88a;
        --info-color: #36b9cc;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --light-color: #f8f9fc;
        --dark-color: #5a5c69;
    }

    .registration-wizard {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Progress Bar */
    .wizard-progress {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        position: relative;
    }

    .wizard-progress::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 4px;
        background: #e3e6f0;
        z-index: 0;
    }

    .wizard-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .step-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #e3e6f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #858796;
        transition: all 0.3s ease;
    }

    .wizard-step.active .step-circle {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.4);
    }

    .wizard-step.completed .step-circle {
        background: var(--success-color);
        border-color: var(--success-color);
        color: #fff;
    }

    .step-label {
        margin-top: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #858796;
        text-align: center;
    }

    .wizard-step.active .step-label {
        color: var(--primary-color);
    }

    .wizard-step.completed .step-label {
        color: var(--success-color);
    }

    /* Wizard Content */
    .wizard-content {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .wizard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
        color: #fff;
        padding: 30px;
        text-align: center;
    }

    .wizard-header h3 {
        margin: 0;
        font-weight: 600;
    }

    .wizard-header p {
        margin: 10px 0 0;
        opacity: 0.9;
    }

    .wizard-body {
        padding: 40px;
    }

    /* Form Cards */
    .form-section-card {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        border-left: 4px solid var(--primary-color);
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .form-section-title i {
        margin-right: 10px;
        font-size: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        border-radius: 8px;
        border: 2px solid #e3e6f0;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .form-select {
        border-radius: 8px;
        border: 2px solid #e3e6f0;
        padding: 12px 15px;
        font-size: 14px;
        height: auto;
    }

    /* Address Cards */
    .address-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .address-card:hover {
        border-color: var(--primary-color);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .address-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e3e6f0;
    }

    .address-card-header i {
        font-size: 24px;
        color: var(--primary-color);
        margin-right: 12px;
    }

    .address-card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #5a5c69;
    }

    .same-address-toggle {
        background: #e8f5e9;
        border: 2px solid #4caf50;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .same-address-toggle input {
        width: 20px;
        height: 20px;
        margin-right: 12px;
    }

    .same-address-toggle label {
        margin: 0;
        font-weight: 600;
        color: #2e7d32;
        cursor: pointer;
    }

    /* Buttons */
    .wizard-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 2px solid #e3e6f0;
    }

    .btn-wizard {
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .btn-wizard-prev {
        background: #fff;
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
    }

    .btn-wizard-prev:hover {
        background: var(--secondary-color);
        color: #fff;
    }

    .btn-wizard-next {
        background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
        border: none;
        color: #fff;
    }

    .btn-wizard-next:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        color: #fff;
    }

    .btn-wizard-submit {
        background: linear-gradient(135deg, var(--success-color) 0%, #13855c 100%);
        border: none;
        color: #fff;
    }

    .btn-wizard-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(28, 200, 138, 0.4);
        color: #fff;
    }

    /* Fieldset Animation */
    fieldset {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    fieldset.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Input Icons */
    .input-icon-group {
        position: relative;
    }

    .input-icon-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--secondary-color);
    }

    .input-icon-group .form-control {
        padding-left: 45px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .wizard-step .step-label {
            display: none;
        }
        
        .wizard-body {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="registration-wizard">
    <!-- Progress Bar -->
    <div class="wizard-progress">
        <div class="wizard-step active" data-step="1">
            <div class="step-circle"><i class="fas fa-user"></i></div>
            <span class="step-label">Basic Details</span>
        </div>
        <div class="wizard-step" data-step="2">
            <div class="step-circle"><i class="fas fa-map-marker-alt"></i></div>
            <span class="step-label">Address</span>
        </div>
        <div class="wizard-step" data-step="3">
            <div class="step-circle"><i class="fas fa-graduation-cap"></i></div>
            <span class="step-label">Education</span>
        </div>
        <div class="wizard-step" data-step="4">
            <div class="step-circle"><i class="fas fa-briefcase"></i></div>
            <span class="step-label">Experience</span>
        </div>
        <div class="wizard-step" data-step="5">
            <div class="step-circle"><i class="fas fa-tools"></i></div>
            <span class="step-label">Skills</span>
        </div>
        <div class="wizard-step" data-step="6">
            <div class="step-circle"><i class="fas fa-signature"></i></div>
            <span class="step-label">Review</span>
        </div>
    </div>

    <!-- Wizard Content -->
    <div class="wizard-content">
        <div class="wizard-header">
            <h3 id="wizard-title">Create Your Stunning Profile</h3>
            <p id="wizard-subtitle">Step 1 of 6 - Let's start with your basic information</p>
        </div>

        <div class="wizard-body">
            <form id="registration-form" enctype="multipart/form-data">
                @csrf
                
                <!-- Step 1: Basic Details -->
                <fieldset id="step-1" class="active">
                    <div class="form-section-card">
                        <div class="form-section-title">
                            <i class="fas fa-user-circle"></i>
                            Personal Information
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" name="gender" id="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-card">
                        <div class="form-section-title">
                            <i class="fas fa-id-card"></i>
                            Identification Details
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Aadhar Number <span class="text-danger">*</span></label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-fingerprint"></i>
                                        <input type="text" class="form-control" name="aadhar_number" id="aadhar_number" placeholder="Enter 12-digit Aadhar number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">PAN Number</label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-id-badge"></i>
                                        <input type="text" class="form-control" name="pan_number" id="pan_number" placeholder="Enter PAN number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Passport Number</label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-passport"></i>
                                        <input type="text" class="form-control" name="passport_number" id="passport_number" placeholder="Enter Passport number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-card">
                        <div class="form-section-title">
                            <i class="fas fa-address-book"></i>
                            Contact Information
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Alternate Mobile Number</label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-phone"></i>
                                        <input type="text" class="form-control" name="alternate_mobile_number" id="alternate_mobile_number" placeholder="Alternate contact number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">WhatsApp Number</label>
                                    <div class="input-icon-group">
                                        <i class="fab fa-whatsapp"></i>
                                        <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" placeholder="WhatsApp number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Alternate Email</label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" class="form-control" name="alternate_email_id" id="alternate_email_id" placeholder="Alternate email address">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-card">
                        <div class="form-section-title">
                            <i class="fas fa-briefcase"></i>
                            Professional Preferences
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Profession</label>
                                    <input type="text" class="form-control" name="profession" id="profession" placeholder="Your profession">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Experience <span class="text-danger">*</span></label>
                                    <select class="form-select" name="experience_level" id="experience_level" required>
                                        <option value="Fresher">Fresher</option>
                                        <option value="Experienced">Experienced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Job Type <span class="text-danger">*</span></label>
                                    <select class="form-select" name="Job_type" id="Job_type" required>
                                        <option value="Part Time">Part Time</option>
                                        <option value="Permanent">Permanent</option>
                                        <option value="Contract">Contract</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Differently Abled? <span class="text-danger">*</span></label>
                                    <select class="form-select" name="differently_abled" id="differently_abled" required>
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <!-- Step 2: Address -->
                <fieldset id="step-2">
                    <div class="row">
                        <!-- Permanent Address -->
                        <div class="col-md-6 mb-4">
                            <div class="address-card">
                                <div class="address-card-header">
                                    <i class="fas fa-home"></i>
                                    <h5>Permanent Address</h5>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_address_1" id="permanent_address_1" placeholder="House/Street number" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" name="permanent_address_2" id="permanent_address_2" placeholder="Area/Locality">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Landmark</label>
                                    <input type="text" class="form-control" name="permanent_landmark" id="permanent_landmark" placeholder="Nearby landmark">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="permanent_city" id="permanent_city" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">State <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="permanent_state" id="permanent_state" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="permanent_zip" id="permanent_zip" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="permanent_country" id="permanent_country" value="India" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Police Station <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_police_station" id="permanent_police_station" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Panchayat/Municipality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_panchayat_municipality" id="permanent_panchayat_municipality" required>
                                </div>
                            </div>
                        </div>

                        <!-- Present Address -->
                        <div class="col-md-6 mb-4">
                            <div class="same-address-toggle" onclick="toggleSameAddress()">
                                <input type="checkbox" id="same_as_permanent" name="same_as_permanent">
                                <label for="same_as_permanent">Present address same as permanent address</label>
                            </div>
                            
                            <div class="address-card" id="present_address_card">
                                <div class="address-card-header">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h5>Present Address</h5>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_address_1" id="present_address_1" placeholder="House/Street number" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" name="present_address_2" id="present_address_2" placeholder="Area/Locality">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Landmark</label>
                                    <input type="text" class="form-control" name="present_landmark" id="present_landmark" placeholder="Nearby landmark">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="present_city" id="present_city" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">State <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="present_state" id="present_state" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="present_zip" id="present_zip" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="present_country" id="present_country" value="India" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Police Station <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_police_station" id="present_police_station" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Panchayat/Municipality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_panchayat_municipality" id="present_panchayat_municipality" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <!-- Step 3: Education -->
                <fieldset id="step-3">
                    <div id="education-container">
                        <!-- Education entries will be added here dynamically -->
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-outline-primary btn-lg" onclick="addEducationEntry()">
                            <i class="fas fa-plus-circle me-2"></i>Add Education
                        </button>
                    </div>

                    <!-- Education Entry Template -->
                    <template id="education-template">
                        <div class="education-entry form-section-card" data-index="{index}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-section-title mb-0">
                                    <i class="fas fa-graduation-cap"></i>
                                    Education #<span class="edu-number">{number}</span>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeEducationEntry(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <div class="row">
                                <!-- Level 1: Education Level (Parent) -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Education Level <span class="text-danger">*</span></label>
                                        <select class="form-select edu-level-1" name="education[{index}][level_1]" required onchange="loadLevel2(this)">
                                            <option value="">Select Education Level</option>
                                            @foreach($qualifications->where('parents', '[]') as $mainQual)
                                                <option value="{{ $mainQual->id }}">{{ $mainQual->degree }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Level 2: Intermediate Qualification -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Intermediate Qualification <span class="text-danger">*</span></label>
                                        <select class="form-select edu-level-2" name="education[{index}][level_2]" required disabled onchange="loadLevel3(this)">
                                            <option value="">Select Level 1 First</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Level 3: Specific Qualification -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Specific Qualification <span class="text-danger">*</span></label>
                                        <select class="form-select edu-level-3" name="education[{index}][level_3]" required disabled onchange="loadLevel4(this)">
                                            <option value="">Select Level 2 First</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Level 4: Stream (Final Qualification) -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Stream <span class="text-danger">*</span></label>
                                        <select class="form-select edu-level-4" name="education[{index}][qualification_id]" required disabled>
                                            <option value="">Select Level 3 First</option>
                                        </select>
                                        <small class="text-muted">This will be saved as your qualification</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">University/Board <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="education[{index}][university]" placeholder="Enter university or board name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Institution Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="education[{index}][institution]" placeholder="Enter institution name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Institution Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="education[{index}][institution]" placeholder="Enter institution name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">College (if applicable)</label>
                                        <input type="text" class="form-control" name="education[{index}][college]" placeholder="Enter college name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">From Year <span class="text-danger">*</span></label>
                                        <select class="form-select" name="education[{index}][from_year]" required>
                                            <option value="">Select</option>
                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">To Year <span class="text-danger">*</span></label>
                                        <select class="form-select" name="education[{index}][to_year]" required>
                                            <option value="">Select</option>
                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Percentage/CGPA</label>
                                        <input type="number" class="form-control" name="education[{index}][percentage]" placeholder="e.g., 85" min="0" max="100" step="0.01" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Certificate</label>
                                        <input type="file" class="form-control" name="education[{index}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </fieldset>

                <!-- Step 4: Experience -->
                <fieldset id="step-4">
                    <div id="experience-container">
                        <!-- Experience entries will be added here dynamically -->
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-outline-success btn-lg" onclick="addExperienceEntry()">
                            <i class="fas fa-plus-circle me-2"></i>Add Experience
                        </button>
                    </div>

                    <!-- Experience Entry Template -->
                    <template id="experience-template">
                        <div class="experience-entry form-section-card" data-index="{index}" style="border-left-color: #1cc88a;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-section-title mb-0" style="color: #1cc88a;">
                                    <i class="fas fa-briefcase"></i>
                                    Experience #<span class="exp-number">{number}</span>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeExperienceEntry(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Industry Category <span class="text-danger">*</span></label>
                                        <select class="form-select exp-industry-1" name="experience[{index}][industry_level_1]" required onchange="loadIndustryLevel2(this)">
                                            <option value="">Select Category</option>
                                            @foreach($industries->filter(fn($i) => $i->parents->isEmpty()) as $industry)
                                                <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Industry Sector <span class="text-danger">*</span></label>
                                    <select class="form-select exp-industry-2" name="experience[{index}][industry_level_2]" required disabled onchange="loadIndustryLevel3(this)">
                                        <option value="">Select Category First</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Industry Type <span class="text-danger">*</span></label>
                                    <select class="form-select exp-industry-3" name="experience[{index}][industry_level_3]" required disabled onchange="loadIndustryLevel4(this)">
                                        <option value="">Select Sector First</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Area of Work <span class="text-danger">*</span></label>
                                        <select class="form-select exp-industry-4" name="experience[{index}][industry_id]" required disabled onchange="loadJobRoles(this)">
                                            <option value="">Select Type First</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Job Role <span class="text-danger">*</span></label>
                                        <select class="form-select exp-job-role" name="experience[{index}][job_role_id]" required disabled>
                                            <option value="">Select Area of Work First</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Company/Institution Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="experience[{index}][company]" placeholder="Enter company name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="experience[{index}][location]" placeholder="City, Country">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">From Year <span class="text-danger">*</span></label>
                                        <select class="form-select exp-from-year" name="experience[{index}][from_year]" required onchange="calculateDuration(this)">
                                            <option value="">Select</option>
                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">To Year <span class="text-danger">*</span></label>
                                        <select class="form-select exp-to-year" name="experience[{index}][to_year]" required onchange="calculateDuration(this)">
                                            <option value="">Select</option>
                                            @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                            <option value="current">Present</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Duration</label>
                                        <input type="text" class="form-control exp-duration" name="experience[{index}][duration]" readonly placeholder="Auto-calculated">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Experience Certificate</label>
                                        <input type="file" class="form-control" name="experience[{index}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>

                            <!-- Key Responsibilities (Summernote) -->
                            <div class="form-group">
                                <label class="form-label">Key Responsibilities <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote-responsibilities" name="experience[{index}][responsibilities]" rows="4"></textarea>
                            </div>

                            <!-- Achievements (Summernote) -->
                            <div class="form-group">
                                <label class="form-label">Achievements (if any)</label>
                                <textarea class="form-control summernote-achievements" name="experience[{index}][achievements]" rows="3"></textarea>
                            </div>

                            <!-- Salary Fields -->
                            <div class="row salary-fields">
                                <div class="col-md-6 present-salary-field" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label">Present Salary (Annual)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" class="form-control" name="experience[{index}][present_salary]" placeholder="e.g., 500000" min="0" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 expected-salary-field" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label">Expected Salary (Annual)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" class="form-control" name="experience[{index}][expected_salary]" placeholder="e.g., 700000" min="0" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </fieldset>

                <!-- Step 5: Skills & Hobbies -->
                <fieldset id="step-5">
                    <!-- Technical Skills -->
                    <div class="form-section-card" style="border-left-color: #36b9cc;">
                        <div class="form-section-title" style="color: #36b9cc;">
                            <i class="fas fa-laptop-code"></i>
                            Technical Skills
                        </div>
                        <div id="skills-container">
                            <!-- Skill entries will be added here -->
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-info" onclick="addSkillEntry()" id="add-skill-btn">
                                <i class="fas fa-plus me-2"></i>Add Skill
                            </button>
                        </div>
                    </div>

                    <!-- Skill Template -->
                    <template id="skill-template">
                        <div class="skill-entry form-section-card mb-3" data-index="{index}" style="border-left-color: #36b9cc;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Skill #{number}</h6>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeSkillEntry(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="form-label">Job Role <span class="text-danger">*</span></label>
                                        <select class="form-select skill-role-select" name="skills[{index}][role_id]" required onchange="loadSkillsForEntry(this)">
                                            <option value="">Select Job Role</option>
                                            <!-- Options will be populated from experience section -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="form-label">Skill <span class="text-danger">*</span></label>
                                        <select class="form-select skill-select" name="skills[{index}][skill_id]" required disabled>
                                            <option value="">Select Job Role First</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label class="form-label">Proficiency <span class="text-danger">*</span></label>
                                        <select class="form-select" name="skills[{index}][proficiency]" required>
                                            <option value="">Select</option>
                                            <option value="Beginner">Beginner</option>
                                            <option value="Intermediate">Intermediate</option>
                                            <option value="Advanced">Advanced</option>
                                            <option value="Expert">Expert</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="form-label">Certificate (Optional)</label>
                                        <input type="file" class="form-control" name="skills[{index}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Hobbies -->
                    <div class="form-section-card" style="border-left-color: #f6c23e;">
                        <div class="form-section-title" style="color: #f6c23e;">
                            <i class="fas fa-heart"></i>
                            Hobbies & Interests
                        </div>
                        <div class="form-group">
                            <label class="form-label">Describe your hobbies and interests</label>
                            <textarea class="form-control summernote-hobbies" name="hobbies[description]" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Areas of Interest (comma separated)</label>
                            <input type="text" class="form-control" name="hobbies[interests]" placeholder="e.g., Reading, Traveling, Photography, Sports">
                        </div>
                    </div>
                </fieldset>

                <!-- Step 6: Review & Signature -->
                <fieldset id="step-6">
                    <!-- Profile Summary -->
                    <div class="form-section-card">
                        <div class="form-section-title">
                            <i class="fas fa-eye"></i>
                            Profile Summary
                        </div>
                        <div id="profile-summary" class="bg-light p-4 rounded">
                            <p class="text-muted text-center">Please review your information before submitting</p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Basic Details:</strong>
                                    <div id="summary-basic" class="small text-muted">-</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Education:</strong>
                                    <div id="summary-education" class="small text-muted">-</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Experience:</strong>
                                    <div id="summary-experience" class="small text-muted">-</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Skills:</strong>
                                    <div id="summary-skills" class="small text-muted">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Digital Signature -->
                    <div class="form-section-card" style="border-left-color: #e74a3b;">
                        <div class="form-section-title" style="color: #e74a3b;">
                            <i class="fas fa-signature"></i>
                            Digital Signature
                        </div>
                        
                        <!-- Signature Options -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="signature_type" id="sig_draw" value="draw" checked onchange="toggleSignatureType()">
                                    <label class="form-check-label" for="sig_draw">
                                        <i class="fas fa-pen me-2"></i>Draw Signature
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="signature_type" id="sig_upload" value="upload" onchange="toggleSignatureType()">
                                    <label class="form-check-label" for="sig_upload">
                                        <i class="fas fa-upload me-2"></i>Upload Image
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="signature_type" id="sig_type" value="type" onchange="toggleSignatureType()">
                                    <label class="form-check-label" for="sig_type">
                                        <i class="fas fa-keyboard me-2"></i>Type Signature
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Draw Signature -->
                        <div id="signature-draw-container" class="signature-container">
                            <canvas id="signature-pad" class="border rounded" style="width: 100%; height: 200px; background: #fff;"></canvas>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-secondary" onclick="clearSignature()">
                                    <i class="fas fa-eraser me-2"></i>Clear
                                </button>
                            </div>
                        </div>

                        <!-- Upload Signature -->
                        <div id="signature-upload-container" class="signature-container" style="display: none;">
                            <input type="file" class="form-control" name="signature_upload" id="signature-upload" accept=".jpg,.jpeg,.png" onchange="previewSignatureUpload(this)">
                            <div id="signature-upload-preview" class="mt-3 text-center"></div>
                        </div>

                        <!-- Type Signature -->
                        <div id="signature-type-container" class="signature-container" style="display: none;">
                            <input type="text" class="form-control form-control-lg text-center" name="signature_text" id="signature-text" placeholder="Type your full name" style="font-family: 'Brush Script MT', cursive; font-size: 32px;" oninput="updateTypedSignature(this.value)">
                            <div id="signature-type-preview" class="mt-3 p-3 border rounded bg-light text-center" style="min-height: 100px;">
                                <span class="text-muted">Your signature will appear here</span>
                            </div>
                        </div>

                        <!-- Hidden input to store signature data -->
                        <input type="hidden" name="signature_data" id="signature-data">
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="form-check mb-4 p-3 bg-light rounded">
                        <input class="form-check-input" type="checkbox" id="terms_agree" name="terms_agree" required style="transform: scale(1.3); margin-right: 10px;">
                        <label class="form-check-label" for="terms_agree">
                            I confirm that all the information provided is true and accurate to the best of my knowledge. I understand that providing false information may result in rejection of my application or removal of my profile.
                        </label>
                    </div>
                </fieldset>

                <!-- Navigation Buttons -->
                <div class="wizard-buttons">
                    <button type="button" class="btn btn-wizard btn-wizard-prev" id="btn-prev" style="display: none;">
                        <i class="fas fa-arrow-left me-2"></i>Previous
                    </button>
                    <button type="button" class="btn btn-wizard btn-wizard-next" id="btn-next">
                        Next<i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <button type="button" class="btn btn-wizard btn-wizard-submit" id="btn-submit" style="display: none;">
                        <i class="fas fa-check-circle me-2"></i>Complete Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    // Wizard Navigation
    let currentStep = 1;
    const totalSteps = 6;
    
    const stepTitles = {
        1: { title: 'Create Your Stunning Profile', subtitle: 'Step 1 of 6 - Let\'s start with your basic information' },
        2: { title: 'Address Information', subtitle: 'Step 2 of 6 - Where can employers reach you?' },
        3: { title: 'Educational Qualifications', subtitle: 'Step 3 of 6 - Tell us about your education' },
        4: { title: 'Work Experience', subtitle: 'Step 4 of 6 - Share your professional journey' },
        5: { title: 'Skills & Hobbies', subtitle: 'Step 5 of 6 - What are you good at?' },
        6: { title: 'Review & Submit', subtitle: 'Step 6 of 6 - Final review and digital signature' }
    };

    function updateWizard() {
        // Update progress bar
        document.querySelectorAll('.wizard-step').forEach((step, index) => {
            const stepNum = index + 1;
            step.classList.remove('active', 'completed');
            if (stepNum < currentStep) {
                step.classList.add('completed');
            } else if (stepNum === currentStep) {
                step.classList.add('active');
            }
        });

        // Show/hide fieldsets
        document.querySelectorAll('fieldset').forEach((fieldset, index) => {
            fieldset.classList.remove('active');
            if (index + 1 === currentStep) {
                fieldset.classList.add('active');
            }
        });

        // Update header
        document.getElementById('wizard-title').textContent = stepTitles[currentStep].title;
        document.getElementById('wizard-subtitle').textContent = stepTitles[currentStep].subtitle;

        // Update buttons
        document.getElementById('btn-prev').style.display = currentStep > 1 ? 'block' : 'none';
        document.getElementById('btn-next').style.display = currentStep < totalSteps ? 'block' : 'none';
        document.getElementById('btn-submit').style.display = currentStep === totalSteps ? 'block' : 'none';
    }

    document.getElementById('btn-next').addEventListener('click', function() {
        if (validateCurrentStep()) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateWizard();
            }
        }
    });

    document.getElementById('btn-prev').addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateWizard();
        }
    });

    function validateCurrentStep() {
        const currentFieldset = document.getElementById(`step-${currentStep}`);
        const requiredFields = currentFieldset.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            alert('Please fill in all required fields marked with *');
        }

        return isValid;
    }

    // Same Address Toggle
    function toggleSameAddress() {
        const checkbox = document.getElementById('same_as_permanent');
        const presentCard = document.getElementById('present_address_card');
        
        if (checkbox.checked) {
            // Copy values from permanent to present
            document.getElementById('present_address_1').value = document.getElementById('permanent_address_1').value;
            document.getElementById('present_address_2').value = document.getElementById('permanent_address_2').value;
            document.getElementById('present_landmark').value = document.getElementById('permanent_landmark').value;
            document.getElementById('present_city').value = document.getElementById('permanent_city').value;
            document.getElementById('present_state').value = document.getElementById('permanent_state').value;
            document.getElementById('present_zip').value = document.getElementById('permanent_zip').value;
            document.getElementById('present_country').value = document.getElementById('permanent_country').value;
            document.getElementById('present_police_station').value = document.getElementById('permanent_police_station').value;
            document.getElementById('present_panchayat_municipality').value = document.getElementById('permanent_panchayat_municipality').value;
            
            presentCard.style.opacity = '0.5';
            presentCard.style.pointerEvents = 'none';
        } else {
            presentCard.style.opacity = '1';
            presentCard.style.pointerEvents = 'auto';
        }
    }

    // Remove invalid class on input
    document.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });

    // ==================== EDUCATION FUNCTIONS ====================
    let educationCount = 0;

    function addEducationEntry() {
        educationCount++;
        const template = document.getElementById('education-template').innerHTML;
        const html = template.replace(/{index}/g, educationCount).replace(/{number}/g, educationCount);
        const container = document.getElementById('education-container');
        const div = document.createElement('div');
        div.innerHTML = html;
        container.appendChild(div.firstElementChild);
        
        // Scroll to new entry
        div.firstElementChild.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function removeEducationEntry(btn) {
        if (document.querySelectorAll('.education-entry').length > 1) {
            btn.closest('.education-entry').remove();
            reindexEducationEntries();
        } else {
            alert('You must have at least one education entry');
        }
    }

    function reindexEducationEntries() {
        document.querySelectorAll('.education-entry').forEach((entry, index) => {
            const num = index + 1;
            entry.querySelector('.edu-number').textContent = num;
            entry.setAttribute('data-index', num);
        });
    }

    function loadLevel2(select) {
        const parentId = select.value;
        const entry = select.closest('.education-entry');
        const level2Select = entry.querySelector('.edu-level-2');
        const level3Select = entry.querySelector('.edu-level-3');
        const level4Select = entry.querySelector('.edu-level-4');
        
        // Reset level 2, 3 and 4
        level2Select.innerHTML = '<option value="">Select Level 1 First</option>';
        level3Select.innerHTML = '<option value="">Select Level 2 First</option>';
        level4Select.innerHTML = '<option value="">Select Level 3 First</option>';
        level2Select.disabled = true;
        level3Select.disabled = true;
        level4Select.disabled = true;
        
        if (!parentId) {
            return;
        }

        // Show loading
        level2Select.innerHTML = '<option value="">Loading...</option>';

        // AJAX call to get direct children only
        fetch(`/api/qualifications/${parentId}/children`)
            .then(res => res.json())
            .then(data => {
                level2Select.innerHTML = '<option value="">Select Intermediate Qualification</option>';
                
                if (data.length > 0) {
                    data.forEach(item => {
                        level2Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                    level2Select.disabled = false;
                } else {
                    // If no children at level 2, use level 1 itself as the final qualification
                    // This handles cases where there might be only 1 level
                    level2Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                    level2Select.disabled = false;
                    // Also enable level 3 and 4 with the same value
                    level3Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                    level3Select.disabled = false;
                    level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                    level4Select.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error loading level 2 qualifications:', error);
                level2Select.innerHTML = '<option value="">Error loading options</option>';
            });
    }

    function loadLevel3(select) {
        const parentId = select.value;
        const entry = select.closest('.education-entry');
        const level3Select = entry.querySelector('.edu-level-3');
        const level4Select = entry.querySelector('.edu-level-4');
        
        // Reset level 3 and 4
        level3Select.innerHTML = '<option value="">Select Level 2 First</option>';
        level4Select.innerHTML = '<option value="">Select Level 3 First</option>';
        level3Select.disabled = true;
        level4Select.disabled = true;
        
        if (!parentId) {
            return;
        }

        // Show loading
        level3Select.innerHTML = '<option value="">Loading...</option>';

        // AJAX call to get direct children only
        fetch(`/api/qualifications/${parentId}/children`)
            .then(res => res.json())
            .then(data => {
                level3Select.innerHTML = '<option value="">Select Specific Qualification</option>';
                
                if (data.length > 0) {
                    data.forEach(item => {
                        level3Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                    level3Select.disabled = false;
                } else {
                    // If no children at level 3, use level 2 itself as the final qualification
                    level3Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                    level3Select.disabled = false;
                    // Also enable level 4 with the same value
                    level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                    level4Select.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error loading level 3 qualifications:', error);
                level3Select.innerHTML = '<option value="">Error loading options</option>';
            });
    }

    function loadLevel4(select) {
        const parentId = select.value;
        const entry = select.closest('.education-entry');
        const level4Select = entry.querySelector('.edu-level-4');
        
        // Reset level 4
        level4Select.innerHTML = '<option value="">Select Level 3 First</option>';
        level4Select.disabled = true;
        
        if (!parentId) {
            return;
        }

        // Show loading
        level4Select.innerHTML = '<option value="">Loading...</option>';

        // AJAX call to get direct children only
        fetch(`/api/qualifications/${parentId}/children`)
            .then(res => res.json())
            .then(data => {
                level4Select.innerHTML = '<option value="">Select Stream</option>';
                
                if (data.length > 0) {
                    data.forEach(item => {
                        level4Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                    level4Select.disabled = false;
                } else {
                    // If no children at level 4, use level 3 itself as the final qualification
                    level4Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                    level4Select.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error loading level 4 qualifications:', error);
                level4Select.innerHTML = '<option value="">Error loading options</option>';
            });
    }

    // ==================== EXPERIENCE FUNCTIONS ====================
    let experienceCount = 0;

    function updateSalaryFieldsVisibility() {
        const allEntries = document.querySelectorAll('.experience-entry');
        
        // Find the entry with "current" as to_year (present job)
        let currentJobIndex = -1;
        allEntries.forEach((entry, index) => {
            const toYearSelect = entry.querySelector('.exp-to-year');
            if (toYearSelect && toYearSelect.value === 'current') {
                currentJobIndex = index;
            }
        });
        
        // If no current job found, use the last entry
        if (currentJobIndex === -1 && allEntries.length > 0) {
            currentJobIndex = allEntries.length - 1;
        }
        
        allEntries.forEach((entry, index) => {
            const presentSalaryField = entry.querySelector('.present-salary-field');
            const expectedSalaryField = entry.querySelector('.expected-salary-field');
            
            // Show Present Salary for ALL entries
            if (presentSalaryField) {
                presentSalaryField.style.display = 'block';
            }
            
            // Show Expected Salary only for the current job (where to_year is "Present")
            if (expectedSalaryField) {
                expectedSalaryField.style.display = index === currentJobIndex ? 'block' : 'none';
            }
        });
    }

    function addExperienceEntry() {
        experienceCount++;
        const template = document.getElementById('experience-template').innerHTML;
        const html = template.replace(/{index}/g, experienceCount).replace(/{number}/g, experienceCount);
        const container = document.getElementById('experience-container');
        const div = document.createElement('div');
        div.innerHTML = html;
        const entry = div.firstElementChild;
        container.appendChild(entry);
        
        // Initialize Summernote for this entry
        $(entry).find('.summernote-responsibilities').summernote({
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ],
            placeholder: 'Describe your key responsibilities in this role...'
        });
        
        $(entry).find('.summernote-achievements').summernote({
            height: 120,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
                ['view', ['fullscreen']]
            ],
            placeholder: 'List your achievements and accomplishments...'
        });

        // Update salary fields visibility for all entries
        updateSalaryFieldsVisibility();
        
        entry.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function removeExperienceEntry(btn) {
        const entries = document.querySelectorAll('.experience-entry');
        if (entries.length > 1) {
            btn.closest('.experience-entry').remove();
            reindexExperienceEntries();
            // Update salary fields visibility after removal
            updateSalaryFieldsVisibility();
        } else {
            alert('You must have at least one experience entry');
        }
    }

    function reindexExperienceEntries() {
        document.querySelectorAll('.experience-entry').forEach((entry, index) => {
            const num = index + 1;
            entry.querySelector('.exp-number').textContent = num;
            entry.setAttribute('data-index', num);
        });
    }

    function loadJobRoles(select) {
        const industryId = select.value;
        const entry = select.closest('.experience-entry');
        const rolesSelect = entry.querySelector('.exp-job-role');
        
        // Reset job role dropdown
        rolesSelect.innerHTML = '<option value="">Loading...</option>';
        rolesSelect.disabled = true;
        
        if (!industryId) {
            rolesSelect.innerHTML = '<option value="">Select Area of Work First</option>';
            return;
        }

        // Use the same API endpoint as other industry children
        fetch(`/api/industries/${industryId}/children`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    rolesSelect.innerHTML = '<option value="">Select Job Role</option>';
                    data.forEach(role => {
                        rolesSelect.innerHTML += `<option value="${role.id}">${role.name}</option>`;
                    });
                    rolesSelect.disabled = false;
                } else {
                    // If no children, use the area of work itself as the job role
                    rolesSelect.innerHTML = `<option value="${industryId}">${select.options[select.selectedIndex].text}</option>`;
                    rolesSelect.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error loading job roles:', error);
                rolesSelect.innerHTML = '<option value="">Error loading options</option>';
            });
    }

    function calculateDuration(element) {
        const entry = element.closest('.experience-entry');
        const fromYear = entry.querySelector('.exp-from-year').value;
        const toYearSelect = entry.querySelector('.exp-to-year');
        const toYear = toYearSelect.value;
        const durationField = entry.querySelector('.exp-duration');
        
        if (fromYear && toYear && fromYear !== 'current') {
            let endYear = toYear === 'current' ? new Date().getFullYear() : parseInt(toYear);
            let startYear = parseInt(fromYear);
            
            if (endYear >= startYear) {
                let years = endYear - startYear;
                let months = 0; // Simplified calculation
                durationField.value = years + (years === 1 ? ' year' : ' years');
            } else {
                durationField.value = '';
            }
        }
        
        // Update salary fields visibility when To Year changes
        updateSalaryFieldsVisibility();
    }

    // ==================== 4-LEVEL CASCADING INDUSTRY DROPDOWNS ====================
    function loadIndustryLevel2(select) {
        const parentId = select.value;
        const entry = select.closest('.experience-entry');
        const level2Select = entry.querySelector('.exp-industry-2');
        const level3Select = entry.querySelector('.exp-industry-3');
        const level4Select = entry.querySelector('.exp-industry-4');
        const jobRoleSelect = entry.querySelector('.exp-job-role');
        
        // Reset level 2, 3, 4 and job role
        level2Select.innerHTML = '<option value="">Select Category First</option>';
        level3Select.innerHTML = '<option value="">Select Sector First</option>';
        level4Select.innerHTML = '<option value="">Select Type First</option>';
        if (jobRoleSelect) {
            jobRoleSelect.innerHTML = '<option value="">Select Area of Work First</option>';
            jobRoleSelect.disabled = true;
        }
        level2Select.disabled = true;
        level3Select.disabled = true;
        level4Select.disabled = true;
        
        if (!parentId) {
            return;
        }

        // Show loading
        level2Select.innerHTML = '<option value="">Loading...</option>';

        // AJAX call to get direct children only
        fetch(`/api/industries/${parentId}/children`)
            .then(res => res.json())
            .then(data => {
                level2Select.innerHTML = '<option value="">Select Industry Sector</option>';
                
                if (data.length > 0) {
                    data.forEach(item => {
                        level2Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                    level2Select.disabled = false;
                } else {
                    // If no children at level 2, use level 1 itself as the final selection
                    level2Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                    level2Select.disabled = false;
                    // Also enable level 3 and 4 with the same value
                    level3Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                    level3Select.disabled = false;
                    level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                    level4Select.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error loading industry level 2:', error);
                level2Select.innerHTML = '<option value="">Error loading options</option>';
            });
    }

    function loadIndustryLevel3(select) {
        const parentId = select.value;
        const entry = select.closest('.experience-entry');
        const level3Select = entry.querySelector('.exp-industry-3');
        const level4Select = entry.querySelector('.exp-industry-4');
        const jobRoleSelect = entry.querySelector('.exp-job-role');
        
        // Reset level 3, 4 and job role
        level3Select.innerHTML = '<option value="">Select Sector First</option>';
        level4Select.innerHTML = '<option value="">Select Type First</option>';
        if (jobRoleSelect) {
            jobRoleSelect.innerHTML = '<option value="">Select Area of Work First</option>';
            jobRoleSelect.disabled = true;
        }
        level3Select.disabled = true;
        level4Select.disabled = true;
        
        if (!parentId) {
            return;
        }

        // Show loading
        level3Select.innerHTML = '<option value="">Loading...</option>';

        // AJAX call to get direct children only
        fetch(`/api/industries/${parentId}/children`)
            .then(res => res.json())
            .then(data => {
                level3Select.innerHTML = '<option value="">Select Industry Type</option>';
                
                if (data.length > 0) {
                    data.forEach(item => {
                        level3Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                    level3Select.disabled = false;
                } else {
                    // If no children at level 3, use level 2 itself as the final selection
                    level3Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                    level3Select.disabled = false;
                    // Also enable level 4 with the same value
                    level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                    level4Select.disabled = false;
                    // Also prefill job role with the same value
                    if (jobRoleSelect) {
                        jobRoleSelect.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                        jobRoleSelect.disabled = false;
                    }
                }
            })
            .catch(error => {
                console.error('Error loading industry level 3:', error);
                level3Select.innerHTML = '<option value="">Error loading options</option>';
            });
    }

    function loadIndustryLevel4(select) {
        const parentId = select.value;
        const entry = select.closest('.experience-entry');
        const level4Select = entry.querySelector('.exp-industry-4');
        const jobRoleSelect = entry.querySelector('.exp-job-role');
        
        // Reset level 4 and job role
        level4Select.innerHTML = '<option value="">Select Type First</option>';
        if (jobRoleSelect) {
            jobRoleSelect.innerHTML = '<option value="">Select Area of Work First</option>';
            jobRoleSelect.disabled = true;
        }
        level4Select.disabled = true;
        
        if (!parentId) {
            return;
        }

        // Show loading
        level4Select.innerHTML = '<option value="">Loading...</option>';

        // AJAX call to get direct children only
        fetch(`/api/industries/${parentId}/children`)
            .then(res => res.json())
            .then(data => {
                level4Select.innerHTML = '<option value="">Select Area of Work</option>';
                
                if (data.length > 0) {
                    data.forEach(item => {
                        level4Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                    level4Select.disabled = false;
                } else {
                    // If no children at level 4, use level 3 itself as the final selection
                    level4Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                    level4Select.disabled = false;
                    // Also prefill job role with the same value
                    if (jobRoleSelect) {
                        jobRoleSelect.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                        jobRoleSelect.disabled = false;
                    }
                }
            })
            .catch(error => {
                console.error('Error loading industry level 4:', error);
                level4Select.innerHTML = '<option value="">Error loading options</option>';
            });
    }

    // ==================== SKILLS FUNCTIONS ====================
    let skillCount = 0;

    function getJobRolesFromExperience() {
        const roles = [];
        const experienceEntries = document.querySelectorAll('.experience-entry');
        
        experienceEntries.forEach(entry => {
            // Look for job role dropdown (exp-job-role)
            const jobRoleSelect = entry.querySelector('.exp-job-role');
            if (jobRoleSelect) {
                const selectedOption = jobRoleSelect.options[jobRoleSelect.selectedIndex];
                if (selectedOption && selectedOption.value && selectedOption.value !== '') {
                    // Check if already added (avoid duplicates)
                    if (!roles.some(r => r.id === selectedOption.value)) {
                        roles.push({
                            id: selectedOption.value,
                            name: selectedOption.text
                        });
                    }
                }
            }
        });
        
        return roles;
    }

    function populateJobRolesForEntry(roleSelect) {
        const roles = getJobRolesFromExperience();
        
        roleSelect.innerHTML = '<option value="">Select Job Role</option>';
        
        if (roles.length > 0) {
            roles.forEach(role => {
                roleSelect.innerHTML += `<option value="${role.id}">${role.name}</option>`;
            });
        } else {
            roleSelect.innerHTML = '<option value="">No job roles found. Please add experience first.</option>';
        }
    }

    function loadSkillsForEntry(roleSelect) {
        const roleId = roleSelect.value;
        const entry = roleSelect.closest('.skill-entry');
        const skillSelect = entry.querySelector('.skill-select');
        
        if (!roleId) {
            skillSelect.innerHTML = '<option value="">Select Job Role First</option>';
            skillSelect.disabled = true;
            return;
        }

        // Show loading
        skillSelect.innerHTML = '<option value="">Loading...</option>';
        skillSelect.disabled = true;

        // Fetch skills for this role
        fetch(`/api/industries/${roleId}/skills`)
            .then(res => res.json())
            .then(data => {
                skillSelect.innerHTML = '<option value="">Select Skill</option>';
                
                if (data.length > 0) {
                    data.forEach(skill => {
                        skillSelect.innerHTML += `<option value="${skill.id}">${skill.name}</option>`;
                    });
                    skillSelect.disabled = false;
                } else {
                    skillSelect.innerHTML = '<option value="">No skills available for this role</option>';
                    skillSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error loading skills:', error);
                skillSelect.innerHTML = '<option value="">Error loading skills</option>';
                skillSelect.disabled = true;
            });
    }

    function addSkillEntry() {
        skillCount++;
        const template = document.getElementById('skill-template').innerHTML;
        const html = template.replace(/{index}/g, skillCount).replace(/{number}/g, skillCount);
        const container = document.getElementById('skills-container');
        const div = document.createElement('div');
        div.innerHTML = html;
        const entry = div.firstElementChild;
        container.appendChild(entry);
        
        // Populate job roles for this entry
        const roleSelect = entry.querySelector('.skill-role-select');
        populateJobRolesForEntry(roleSelect);
    }

    function removeSkillEntry(btn) {
        btn.closest('.skill-entry').remove();
    }

    // ==================== SIGNATURE FUNCTIONS ====================
    let signaturePad = null;

    function initSignaturePad() {
        const canvas = document.getElementById('signature-pad');
        if (canvas && !signaturePad) {
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)'
            });
        }
    }

    function clearSignature() {
        if (signaturePad) {
            signaturePad.clear();
        }
    }

    function toggleSignatureType() {
        const type = document.querySelector('input[name="signature_type"]:checked').value;
        
        document.getElementById('signature-draw-container').style.display = type === 'draw' ? 'block' : 'none';
        document.getElementById('signature-upload-container').style.display = type === 'upload' ? 'block' : 'none';
        document.getElementById('signature-type-container').style.display = type === 'type' ? 'block' : 'none';
        
        if (type === 'draw') {
            setTimeout(initSignaturePad, 100);
        }
    }

    function previewSignatureUpload(input) {
        const preview = document.getElementById('signature-upload-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" style="max-height: 150px; border: 1px solid #ddd; padding: 5px;">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateTypedSignature(value) {
        const preview = document.getElementById('signature-type-preview');
        if (value.trim()) {
            preview.innerHTML = `<span style="font-family: 'Brush Script MT', cursive; font-size: 48px; color: #000;">${value}</span>`;
        } else {
            preview.innerHTML = '<span class="text-muted">Your signature will appear here</span>';
        }
    }

    // ==================== REVIEW & SUBMIT ====================
    function generateProfileSummary() {
        // Basic Details
        const dob = document.getElementById('dob')?.value || '-';
        const gender = document.getElementById('gender')?.value || '-';
        const experience = document.getElementById('experience_level')?.value || '-';
        const profession = document.getElementById('profession')?.value || '-';
        const aadhar = document.getElementById('aadhar_number')?.value || '-';
        
        const basic = `
            <strong>DOB:</strong> ${dob}<br>
            <strong>Gender:</strong> ${gender}<br>
            <strong>Experience Level:</strong> ${experience}<br>
            ${profession !== '-' ? `<strong>Profession:</strong> ${profession}<br>` : ''}
            <strong>Aadhar:</strong> ${aadhar.replace(/(\d{4})(?=\d)/g, '$1 ')}
        `;
        document.getElementById('summary-basic').innerHTML = basic;

        // Education Details
        const educationEntries = document.querySelectorAll('.education-entry');
        let educationHTML = '';
        if (educationEntries.length > 0) {
            educationEntries.forEach((entry, index) => {
                const qualSelect = entry.querySelector('.edu-qualification');
                const qualification = qualSelect?.options[qualSelect.selectedIndex]?.text || 'Not selected';
                const university = entry.querySelector('input[name*="[university]"]')?.value || '-';
                const institution = entry.querySelector('input[name*="[institution]"]')?.value || '-';
                const fromYear = entry.querySelector('select[name*="[from_year]"]')?.value || '-';
                const toYear = entry.querySelector('select[name*="[to_year]"]')?.value || '-';
                const percentage = entry.querySelector('input[name*="[percentage]"]')?.value || '-';
                
                educationHTML += `
                    <div class="mb-2 pb-2 ${index < educationEntries.length - 1 ? 'border-bottom' : ''}">
                        <strong>${index + 1}. ${qualification}</strong><br>
                        <small class="text-muted">
                            ${institution !== '-' ? institution + ' | ' : ''}${university}<br>
                            ${fromYear} - ${toYear}${percentage !== '-' ? ' | ' + percentage + '%' : ''}
                        </small>
                    </div>
                `;
            });
        } else {
            educationHTML = '<span class="text-muted">No education added</span>';
        }
        document.getElementById('summary-education').innerHTML = educationHTML || '<span class="text-muted">No education added</span>';

        // Experience Details
        const experienceEntries = document.querySelectorAll('.experience-entry');
        let experienceHTML = '';
        if (experienceEntries.length > 0) {
            experienceEntries.forEach((entry, index) => {
                const company = entry.querySelector('input[name*="[company]"]')?.value || '-';
                const industrySelect = entry.querySelector('.exp-industry');
                const industry = industrySelect?.options[industrySelect.selectedIndex]?.text || 'Not selected';
                const location = entry.querySelector('input[name*="[location]"]')?.value || '-';
                const fromYear = entry.querySelector('.exp-from-year')?.value || '-';
                const toYearSelect = entry.querySelector('.exp-to-year');
                const toYear = toYearSelect?.value === 'current' ? 'Present' : (toYearSelect?.value || '-');
                const duration = entry.querySelector('.exp-duration')?.value || '-';
                const presentSalary = entry.querySelector('input[name*="[present_salary]"]')?.value || '-';
                const expectedSalary = entry.querySelector('input[name*="[expected_salary]"]')?.value || '-';
                
                let salaryInfo = '';
                if (presentSalary !== '-') {
                    salaryInfo += `<br><small class="text-muted">Present: ₹${parseInt(presentSalary).toLocaleString('en-IN')}</small>`;
                }
                if (expectedSalary !== '-') {
                    salaryInfo += `<br><small class="text-muted">Expected: ₹${parseInt(expectedSalary).toLocaleString('en-IN')}</small>`;
                }
                
                experienceHTML += `
                    <div class="mb-2 pb-2 ${index < experienceEntries.length - 1 ? 'border-bottom' : ''}">
                        <strong>${index + 1}. ${company}</strong> ${toYear === 'Present' ? '<span class="badge bg-success ms-1">Current</span>' : ''}<br>
                        <small class="text-muted">
                            ${industry}${location !== '-' ? ' | ' + location : ''}<br>
                            ${fromYear} - ${toYear}${duration !== '-' ? ' | ' + duration : ''}
                            ${salaryInfo}
                        </small>
                    </div>
                `;
            });
        } else {
            experienceHTML = '<span class="text-muted">No experience added</span>';
        }
        document.getElementById('summary-experience').innerHTML = experienceHTML || '<span class="text-muted">No experience added</span>';

        // Skills Details
        const skillEntries = document.querySelectorAll('.skill-entry');
        let skillsHTML = '';
        if (skillEntries.length > 0) {
            skillEntries.forEach((entry, index) => {
                const skillSelect = entry.querySelector('select[name*="[skill_id]"]');
                const skill = skillSelect?.options[skillSelect.selectedIndex]?.text || 'Not selected';
                const proficiencySelect = entry.querySelector('select[name*="[proficiency]"]');
                const proficiency = proficiencySelect?.options[proficiencySelect.selectedIndex]?.text || '-';
                
                const badgeColor = {
                    'Beginner': 'bg-secondary',
                    'Intermediate': 'bg-info',
                    'Advanced': 'bg-primary',
                    'Expert': 'bg-success'
                }[proficiency] || 'bg-secondary';
                
                skillsHTML += `
                    <span class="badge ${badgeColor} me-2 mb-2" style="font-size: 12px;">
                        ${skill} ${proficiency !== '-' ? '(' + proficiency + ')' : ''}
                    </span>
                `;
            });
        } else {
            skillsHTML = '<span class="text-muted">No skills added</span>';
        }
        document.getElementById('summary-skills').innerHTML = skillsHTML || '<span class="text-muted">No skills added</span>';
    }

    // Update summary when reaching step 6
    document.getElementById('btn-next').addEventListener('click', function() {
        if (currentStep === 5) {
            generateProfileSummary();
            setTimeout(initSignaturePad, 500);
        }
    });

    // Form submission
    document.getElementById('btn-submit').addEventListener('click', function() {
        // Get signature data based on type
        const sigType = document.querySelector('input[name="signature_type"]:checked').value;
        let signatureData = '';
        
        if (sigType === 'draw' && signaturePad) {
            if (signaturePad.isEmpty()) {
                alert('Please draw your signature');
                return;
            }
            signatureData = signaturePad.toDataURL();
        } else if (sigType === 'type') {
            signatureData = document.getElementById('signature-text').value;
            if (!signatureData.trim()) {
                alert('Please type your signature');
                return;
            }
        }
        
        document.getElementById('signature-data').value = signatureData;
        
        // Submit form
        const form = document.getElementById('registration-form');
        const formData = new FormData(form);
        
        // AJAX submission
        fetch('{{ route("save-candidate-profile") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Profile completed successfully!');
                window.location.href = '{{ route("employee.dashboard") }}';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving your profile');
        });
    });

    // Initialize
    updateWizard();
    
    // Add initial empty entries
    if (document.getElementById('education-container').children.length === 0) {
        addEducationEntry();
    }
    if (document.getElementById('experience-container').children.length === 0) {
        addExperienceEntry();
    }
    if (document.getElementById('skills-container').children.length === 0) {
        addSkillEntry();
    }

    // Initialize Summernote for Hobbies
    $(document).ready(function() {
        $('.summernote-hobbies').summernote({
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
                ['view', ['fullscreen']]
            ],
            placeholder: 'Describe your hobbies, interests, and activities you enjoy...'
        });
    });
</script>

<!-- Signature Pad Library -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
@endsection
