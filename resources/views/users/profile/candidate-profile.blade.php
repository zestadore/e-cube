@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .profile-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #fff;
        padding: 40px;
        border-radius: 15px;
        margin-bottom: 30px;
        position: relative;
    }
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid #fff;
        object-fit: cover;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .profile-name {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .profile-title {
        font-size: 16px;
        opacity: 0.9;
    }
    .edit-profile-btn {
        position: absolute;
        top: 20px;
        right: 20px;
    }
    .section-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        overflow: hidden;
    }
    .section-header {
        background: #f8f9fc;
        padding: 20px 25px;
        border-bottom: 2px solid #e3e6f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #4e73df;
        margin: 0;
    }
    .section-body {
        padding: 25px;
    }
    .info-row {
        display: flex;
        margin-bottom: 15px;
    }
    .info-label {
        width: 150px;
        font-weight: 600;
        color: #5a5c69;
    }
    .info-value {
        flex: 1;
        color: #858796;
    }
    .timeline-item {
        position: relative;
        padding-left: 30px;
        padding-bottom: 25px;
        border-left: 3px solid #e3e6f0;
    }
    .timeline-item:last-child {
        border-left: 3px solid transparent;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -9px;
        top: 0;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background: #4e73df;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px #e3e6f0;
    }
    .timeline-title {
        font-weight: 600;
        color: #4e73df;
        margin-bottom: 5px;
    }
    .timeline-subtitle {
        color: #858796;
        font-size: 14px;
        margin-bottom: 10px;
    }
    .skill-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #2e7d32;
        padding: 8px 15px;
        border-radius: 20px;
        margin: 5px;
        font-size: 14px;
    }
    .signature-image {
        max-width: 300px;
        border: 1px solid #ddd;
        padding: 10px;
        background: #fff;
    }
    .completion-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: #1cc88a;
        color: #fff;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    .action-buttons {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
    }
    .action-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        margin-top: 10px;
        transition: all 0.3s ease;
    }
    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="completion-badge">
            <i class="fas fa-check-circle me-2"></i>Profile Complete
        </div>
        
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <img src="{{ Auth::user()->image ? asset('uploads/profiles/'.Auth::user()->image) : asset('assets/img/default-user.png') }}" 
                     alt="Profile" class="profile-avatar">
            </div>
            <div class="col-md-7">
                <h1 class="profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                <p class="profile-title">
                    <i class="fas fa-briefcase me-2"></i>{{ $basics->profession ?? 'Not specified' }}
                    <span class="mx-2">|</span>
                    <i class="fas fa-map-marker-alt me-2"></i>{{ $presentAddress->city ?? 'Not specified' }}, {{ $presentAddress->state ?? '' }}
                </p>
                <p class="mb-0">
                    <span class="badge bg-light text-dark me-2">
                        <i class="fas fa-envelope me-1"></i>{{ Auth::user()->email }}
                    </span>
                    <span class="badge bg-light text-dark me-2">
                        <i class="fas fa-phone me-1"></i>{{ Auth::user()->mobile }}
                    </span>
                    @if($basics->experience ?? false)
                    <span class="badge bg-success">
                        {{ $basics->experience }} Professional
                    </span>
                    @endif
                </p>
            </div>
            <div class="col-md-3 text-end">
                <div class="btn-group-vertical">
                    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-light mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                    <a href="{{ route('employee.dashboard') }}" class="btn btn-outline-light">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-4">
            <!-- Basic Information -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title"><i class="fas fa-user me-2"></i>Basic Information</h3>
                    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
                <div class="section-body">
                    <div class="info-row">
                        <span class="info-label">Date of Birth:</span>
                        <span class="info-value">{{ $basics->dob ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Gender:</span>
                        <span class="info-value">{{ $basics->gender ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Aadhar:</span>
                        <span class="info-value">{{ $basics->aadhar_number ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">PAN:</span>
                        <span class="info-value">{{ $basics->pan_number ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Job Type:</span>
                        <span class="info-value">{{ $basics->job_type ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Experience:</span>
                        <span class="info-value">{{ $basics->experience ?? 'Not specified' }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title"><i class="fas fa-address-book me-2"></i>Contact Details</h3>
                    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
                <div class="section-body">
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mobile:</span>
                        <span class="info-value">{{ Auth::user()->mobile }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alt. Mobile:</span>
                        <span class="info-value">{{ $basics->alternate_mobile_number ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">WhatsApp:</span>
                        <span class="info-value">{{ $basics->whatsapp_number ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alt. Email:</span>
                        <span class="info-value">{{ $basics->alternate_email_id ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title"><i class="fas fa-map-marker-alt me-2"></i>Address</h3>
                    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
                <div class="section-body">
                    <h6 class="text-primary mb-3">Present Address</h6>
                    <p class="text-muted">
                        {{ $presentAddress->address_1 ?? '' }} {{ $presentAddress->address_2 ?? '' }}<br>
                        {{ $presentAddress->city ?? '' }}, {{ $presentAddress->state ?? '' }} - {{ $presentAddress->zip ?? '' }}<br>
                        {{ $presentAddress->country ?? '' }}
                    </p>
                    
                    <hr class="my-3">
                    
                    <h6 class="text-primary mb-3">Permanent Address</h6>
                    <p class="text-muted">
                        {{ $permanentAddress->address_1 ?? '' }} {{ $permanentAddress->address_2 ?? '' }}<br>
                        {{ $permanentAddress->city ?? '' }}, {{ $permanentAddress->state ?? '' }} - {{ $permanentAddress->zip ?? '' }}<br>
                        {{ $permanentAddress->country ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-8">
            <!-- Education -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title"><i class="fas fa-graduation-cap me-2"></i>Education</h3>
                    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
                <div class="section-body">
                    @if(count($candidateQualifications) > 0)
                        @foreach($candidateQualifications as $qualification)
                        <div class="timeline-item">
                            <div class="timeline-title">{{ $qualification->qualification->degree ?? 'Unknown' }}</div>
                            <div class="timeline-subtitle">
                                {{ $qualification->university }} | {{ $qualification->from_year }} - {{ $qualification->to_year }}
                            </div>
                            <p class="text-muted mb-1"><strong>Institution:</strong> {{ $qualification->institution ?? 'N/A' }}</p>
                            @if($qualification->percentage)
                            <span class="badge bg-success">{{ $qualification->percentage }}%</span>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-3">No education details added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Work Experience -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title"><i class="fas fa-briefcase me-2"></i>Work Experience</h3>
                    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
                <div class="section-body">
                    @if(count($candidateExperiences) > 0)
                        @foreach($candidateExperiences as $experience)
                        <div class="timeline-item">
                            <div class="timeline-title">{{ $experience->company }}</div>
                            <div class="timeline-subtitle">
                                {{ $experience->industry->industry_name ?? 'Unknown Industry' }} | 
                                {{ $experience->from_year }} - {{ $experience->to_year ?? 'Present' }}
                                @if($experience->duration)
                                <span class="badge bg-info ms-2">{{ $experience->duration }}</span>
                                @endif
                                @if($experience->is_current)
                                <span class="badge bg-success ms-2">Current Job</span>
                                @endif
                            </div>
                            
                            @if($experience->responsibilities)
                            <div class="mt-2">
                                <strong>Responsibilities:</strong>
                                <div class="text-muted">{!! $experience->responsibilities !!}</div>
                            </div>
                            @endif
                            
                            @if($experience->achievements)
                            <div class="mt-2">
                                <strong>Achievements:</strong>
                                <div class="text-muted">{!! $experience->achievements !!}</div>
                            </div>
                            @endif

                            @if($experience->present_salary || $experience->expected_salary)
                            <div class="mt-2">
                                @if($experience->present_salary)
                                <span class="badge bg-warning text-dark me-2">Present: ₹{{ number_format($experience->present_salary) }}</span>
                                @endif
                                @if($experience->expected_salary)
                                <span class="badge bg-primary">Expected: ₹{{ number_format($experience->expected_salary) }}</span>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-3">No work experience added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Skills -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title"><i class="fas fa-tools me-2"></i>Skills</h3>
                    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
                <div class="section-body">
                    @if(count($candidateSkills) > 0)
                        @foreach($candidateSkills as $skill)
                        <span class="skill-badge">
                            {{ $skill->skill->skill ?? 'Unknown' }}
                            @if($skill->proficiency)
                            <small class="ms-1">({{ $skill->proficiency }})</small>
                            @endif
                        </span>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-3">No skills added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Hobbies -->
            @if($hobbies ?? false)
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title"><i class="fas fa-heart me-2"></i>Hobbies & Interests</h3>
                    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
                <div class="section-body">
                    @if($hobbies->description)
                    <div class="mb-3">
                        {!! $hobbies->description !!}
                    </div>
                    @endif
                    @if($hobbies->interests)
                    <div>
                        <strong>Areas of Interest:</strong>
                        <p class="text-muted">{{ $hobbies->interests }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Digital Signature -->
            @if(Auth::user()->signature_image)
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title"><i class="fas fa-signature me-2"></i>Digital Signature</h3>
                </div>
                <div class="section-body text-center">
                    <img src="{{ Auth::user()->signature_image }}" alt="Signature" class="signature-image">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Floating Action Buttons -->
<div class="action-buttons">
    <a href="{{ route('register-as-job-seeker') }}" class="btn btn-primary action-btn" title="Edit Profile">
        <i class="fas fa-edit fa-lg"></i>
    </a>
    <a href="{{ route('employee.dashboard') }}" class="btn btn-success action-btn" title="Dashboard">
        <i class="fas fa-home fa-lg"></i>
    </a>
</div>
@endsection

@section('scripts')
<script>
    // Print functionality
    function printProfile() {
        window.print();
    }
    
    // Download PDF (placeholder - would need backend implementation)
    function downloadPDF() {
        alert('PDF download feature coming soon!');
    }
</script>
@endsection