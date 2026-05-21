@extends('layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">User Profile Details</h4>
                        </div>
                        <div>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 12L11 10L11.5 9.5M9 12L11 14L11.5 14.5M9 12H15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Full Name:</strong></td>
                                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>
                                                    {{ $user->email }}
                                                    @if($user->email_verified_at)
                                                        <span class="badge bg-success">Verified</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mobile:</strong></td>
                                                <td>
                                                    {{ $user->mobile }}
                                                    @if($user->mobile_verified_at)
                                                        <span class="badge bg-success">Verified</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Role:</strong></td>
                                                <td><span class="badge bg-info">{{ ucfirst($user->role) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    @if($user->status == 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Registered On:</strong></td>
                                                <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                            @if($user->validity)
                                            <tr>
                                                <td><strong>Subscription Validity:</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($user->validity)->format('d M Y') }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Image -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Profile Image</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        @if($user->image_path)
                                            <img src="{{ $user->image_path }}" alt="Profile" class="img-fluid rounded-circle" style="max-width: 200px; max-height: 200px;">
                                        @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px;">
                                                <svg class="icon-100" width="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-muted">No profile image uploaded</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Specific Information -->
                        @if($user->role == 'employee')
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Employee Details</h5>
                                        </div>
                                        <div class="card-body">
                                            @if($user->basicDetails)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Basic Details</h6>
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td width="40%"><strong>Date of Birth:</strong></td>
                                                                <td>{{ $user->basicDetails->dob ? \Carbon\Carbon::parse($user->basicDetails->dob)->format('d M Y') : 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Gender:</strong></td>
                                                                <td>{{ $user->basicDetails->gender ? ucfirst($user->basicDetails->gender) : 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Marital Status:</strong></td>
                                                                <td>{{ $user->basicDetails->marital_status ? ucfirst($user->basicDetails->marital_status) : 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Nationality:</strong></td>
                                                                <td>{{ $user->basicDetails->nationality ?? 'N/A' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Professional Information</h6>
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td width="40%"><strong>Experience:</strong></td>
                                                                <td>{{ $user->basicDetails->experience ? $user->basicDetails->experience . ' Years' : 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Current Salary:</strong></td>
                                                                <td>{{ $user->basicDetails->current_salary ? '₹' . number_format($user->basicDetails->current_salary) : 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Expected Salary:</strong></td>
                                                                <td>{{ $user->basicDetails->expected_salary ? '₹' . number_format($user->basicDetails->expected_salary) : 'N/A' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Qualifications Timeline -->
                                                @if($user->candidateQualifications->count() > 0)
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <h6 class="mb-3"><i class="fas fa-graduation-cap text-primary me-2"></i>Education & Qualifications</h6>
                                                        <div class="timeline">
                                                            @foreach($user->candidateQualifications as $qualification)
                                                            <div class="timeline-item pb-3 mb-3 border-start border-2 ps-3 position-relative">
                                                                <div class="position-absolute" style="left: -7px; top: 0; width: 12px; height: 12px; background: #4e73df; border-radius: 50%;"></div>
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <h6 class="mb-1 text-primary">
                                                                            @php
                                                                                $qualParts = [];
                                                                                if($qualification->level1Qualification) $qualParts[] = $qualification->level1Qualification->degree;
                                                                                if($qualification->level2Qualification) $qualParts[] = $qualification->level2Qualification->degree;
                                                                                if($qualification->level3Qualification) $qualParts[] = $qualification->level3Qualification->degree;
                                                                                if($qualification->qualification) $qualParts[] = $qualification->qualification->degree;
                                                                                $qualDisplay = !empty($qualParts) ? implode(' → ', $qualParts) : 'Unknown';
                                                                            @endphp
                                                                            {{ $qualDisplay }}
                                                                        </h6>
                                                                        <p class="mb-1 text-muted">
                                                                            <i class="fas fa-university me-1"></i>{{ $qualification->university ?? 'N/A' }}
                                                                            <span class="mx-2">|</span>
                                                                            <i class="fas fa-calendar me-1"></i>{{ $qualification->from_year }} - {{ $qualification->to_year }}
                                                                        </p>
                                                                    </div>
                                                                    <span class="badge bg-success">{{ $qualification->percentage }}%</span>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Skills -->
                                                @if($user->candidateSkills->count() > 0)
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <h6 class="mb-3"><i class="fas fa-tools text-primary me-2"></i>Skills & Expertise</h6>
                                                        @php
                                                            // Group skills by industry_id (job role)
                                                            $groupedSkills = $user->candidateSkills->groupBy(function($item) {
                                                                return $item->skill->industry_id ?? 'unknown';
                                                            });
                                                        @endphp
                                                        
                                                        @foreach($groupedSkills as $roleId => $skills)
                                                            @php
                                                                $roleName = $skills->first()->skill->industry->industry_name ?? 'Unknown Role';
                                                                $proficiency = $skills->first()->proficiency;
                                                            @endphp
                                                            <div class="card mb-3">
                                                                <div class="card-header bg-light">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <h6 class="mb-0 fw-bold">
                                                                            <i class="fas fa-briefcase me-2 text-primary"></i>{{ $roleName }}
                                                                        </h6>
                                                                        <span class="badge bg-primary">{{ $proficiency }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="d-flex flex-wrap gap-2">
                                                                        @foreach($skills as $skill)
                                                                            <span class="badge bg-light text-dark border">{{ $skill->skill->skill ?? 'Unknown' }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Experience -->
                                                @if($user->candidateExperiences->count() > 0)
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <h6 class="mb-3"><i class="fas fa-briefcase text-primary me-2"></i>Work Experience</h6>
                                                        <div class="timeline">
                                                            @foreach($user->candidateExperiences as $experience)
                                                            <div class="timeline-item pb-3 mb-3 border-start border-2 ps-3 position-relative">
                                                                <div class="position-absolute" style="left: -7px; top: 0; width: 12px; height: 12px; background: #1cc88a; border-radius: 50%;"></div>
                                                                <div class="card bg-light">
                                                                    <div class="card-body">
                                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                                            <h6 class="mb-0 text-success">{{ $experience->company ?? 'N/A' }}</h6>
                                                                            <div>
                                                                                @if($experience->is_current)
                                                                                    <span class="badge bg-warning">Current Job</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <p class="mb-2 text-muted">
                                                                            @php
                                                                                $industryParts = [];
                                                                                if($experience->industry) $industryParts[] = $experience->industry->industry_name;
                                                                                if($experience->industryLevel2) $industryParts[] = $experience->industryLevel2->industry_name;
                                                                                if($experience->industryLevel3) $industryParts[] = $experience->industryLevel3->industry_name;
                                                                                $industryDisplay = !empty($industryParts) ? implode(' → ', $industryParts) : 'Unknown';
                                                                            @endphp
                                                                            <i class="fas fa-industry me-1"></i>{{ $industryDisplay }}
                                                                        </p>
                                                                        <p class="mb-2 text-muted">
                                                                            <i class="fas fa-calendar me-1"></i>
                                                                            {{ $experience->from_year }} - {{ $experience->to_year ?? 'Present' }}
                                                                            @if($experience->duration)
                                                                                <span class="badge bg-info ms-2">{{ $experience->duration }}</span>
                                                                            @endif
                                                                        </p>
                                                                        @if($experience->jobRole)
                                                                            <p class="mb-0">
                                                                                <span class="badge bg-secondary">
                                                                                    <i class="fas fa-user-tag me-1"></i>{{ $experience->jobRole->industry_name ?? 'N/A' }}
                                                                                </span>
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @else
                                                <p class="text-muted">No additional details provided</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Employer Specific Information -->
                        @if($user->role == 'employer')
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Company Details</h5>
                                        </div>
                                        <div class="card-body">
                                            @if($user->companyProfile)
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="20%"><strong>Company Name:</strong></td>
                                                        <td>{{ $user->companyProfile->company_name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Industry:</strong></td>
                                                        <td>{{ $user->companyProfile->industry->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Website:</strong></td>
                                                        <td>{{ $user->companyProfile->website ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Company Size:</strong></td>
                                                        <td>{{ $user->companyProfile->company_size ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>About Company:</strong></td>
                                                        <td>{{ $user->companyProfile->about ?? 'N/A' }}</td>
                                                    </tr>
                                                </table>
                                            @else
                                                <p class="text-muted">No company profile created</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection