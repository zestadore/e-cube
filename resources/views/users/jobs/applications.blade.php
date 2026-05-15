@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .application-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .application-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        .candidate-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .candidate-avatar-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending { background: #fff3e0; color: #f57c00; }
        .status-shortlisted { background: #e3f2fd; color: #1976d2; }
        .status-hired { background: #e8f5e9; color: #388e3c; }
        .status-rejected { background: #ffebee; color: #c62828; }
        .stat-card {
            border-radius: 12px;
            padding: 20px;
            color: white;
            text-align: center;
        }
        .stat-card.total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card.pending { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-card.shortlisted { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stat-card.hired { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stat-card.rejected { background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); }
    </style>
@endsection

@section('content')
<div class="container-fluid content-inner mt-n5 py-0">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">
                            <i class="fas fa-users text-primary me-2"></i>Job Applications
                        </h3>
                        <p class="text-muted mt-2 mb-0">Manage candidates who applied to your job posts</p>
                    </div>
                    <a href="{{ route('employer.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card total">
                <i class="fas fa-users fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ $stats['total'] }}</h4>
                <small>Total</small>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card pending">
                <i class="fas fa-clock fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ $stats['pending'] }}</h4>
                <small>Pending</small>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card shortlisted">
                <i class="fas fa-star fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ $stats['shortlisted'] }}</h4>
                <small>Shortlisted</small>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card hired">
                <i class="fas fa-check-circle fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ $stats['hired'] }}</h4>
                <small>Hired</small>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card rejected">
                <i class="fas fa-times-circle fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ $stats['rejected'] }}</h4>
                <small>Rejected</small>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('employer.applications') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Filter by Job</label>
                            <select name="job_id" class="form-select">
                                <option value="">All Jobs</option>
                                @foreach($jobs as $job)
                                    <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                        {{ Str::limit($job->description, 50) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Search Candidate</label>
                            <input type="text" name="search" class="form-control" placeholder="Name or email..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                                <a href="{{ route('employer.applications') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-undo me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications List -->
    <div class="row">
        <div class="col-lg-12">
            @if($applications->count() > 0)
                <div class="row">
                    @foreach($applications as $application)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card application-card h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start mb-3">
                                    <!-- Candidate Avatar -->
                                    @if($application->user && $application->user->image_path)
                                        <img src="{{ $application->user->image_path }}" 
                                             alt="Candidate" 
                                             class="candidate-avatar me-3"
                                             onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">
                                    @else
                                        <div class="candidate-avatar-placeholder me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h5 class="card-title fw-bold mb-1">{{ $application->user->full_name ?? 'Unknown' }}</h5>
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-envelope me-1"></i>{{ $application->user->email ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Job Info -->
                                <div class="mb-3">
                                    <small class="text-muted">Applied for:</small>
                                    <p class="mb-1 fw-semibold">{{ Str::limit($application->jobPost->description, 60) }}</p>
                                    <span class="badge bg-info text-dark">
                                        <i class="fas fa-industry me-1"></i>{{ $application->jobPost->industry->industry_name ?? 'N/A' }}
                                    </span>
                                </div>

                                <!-- Qualifications -->
                                @if($application->user && $application->user->candidateQualifications->count() > 0)
                                    <div class="mb-3">
                                        <small class="text-muted">Qualifications:</small>
                                        <div>
                                            @foreach($application->user->candidateQualifications->take(2) as $qual)
                                                <span class="badge bg-secondary me-1">{{ $qual->qualification->degree ?? 'N/A' }}</span>
                                            @endforeach
                                            @if($application->user->candidateQualifications->count() > 2)
                                                <span class="badge bg-light text-dark">+{{ $application->user->candidateQualifications->count() - 2 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Cover Letter Preview -->
                                @if($application->cover_letter)
                                    <div class="mb-3">
                                        <small class="text-muted">Cover Letter:</small>
                                        <p class="small text-muted mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $application->cover_letter }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Status & Date -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="status-badge status-{{ $application->status }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $application->applied_at->diffForHumans() }}
                                    </small>
                                </div>

                                <!-- Actions -->
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-sm" onclick="viewApplication({{ $application->id }})">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </button>
                                    <button class="btn btn-outline-success btn-sm" onclick="updateStatus({{ $application->id }}, 'shortlisted')">
                                        <i class="fas fa-star me-1"></i>Shortlist
                                    </button>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-danger btn-sm" onclick="updateStatus({{ $application->id }}, 'rejected')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button class="btn btn-outline-success btn-sm" onclick="updateStatus({{ $application->id }}, 'hired')">
                                            <i class="fas fa-check"></i> Hire
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $applications->appends(request()->except('page'))->links() }}
                </div>
            @else
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Applications Found</h4>
                        <p class="text-muted">You haven't received any applications yet, or no applications match your filters.</p>
                        <a href="{{ route('employer.applications') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-undo me-2"></i>Reset Filters
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Application Details Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title text-white" id="applicationModalLabel">
                    <i class="fas fa-user me-2"></i>Candidate Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="applicationModalBody">
                <!-- Content loaded via AJAX -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading application details...</p>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" id="statusModalHeader">
                <h5 class="modal-title" id="statusModalLabel">
                    <i class="fas fa-edit me-2"></i>Update Application Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="status" id="newStatus">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="alert alert-info" id="statusAlert">
                            You are about to change the application status.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">Notes (Optional)</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Add any notes about this candidate..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="statusSubmitBtn">
                        <i class="fas fa-save me-2"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function viewApplication(applicationId) {
        var modal = new bootstrap.Modal(document.getElementById('applicationModal'));
        modal.show();
        
        // Reset modal body
        document.getElementById('applicationModalBody').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading application details...</p>
            </div>
        `;
        
        // Fetch application details
        fetch(`/employer/application/${applicationId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                renderApplicationDetails(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('applicationModalBody').innerHTML = `
                    <div class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <h5>Failed to load application details</h5>
                        <p class="text-muted">Please try again later</p>
                    </div>
                `;
            });
    }

    function renderApplicationDetails(data) {
        const app = data.application;
        const candidate = app.user;
        const job = app.job_post;
        const basics = app.basic_details || {};
        const presentAddress = app.present_address || null;
        const permanentAddress = app.permanent_address || null;
        const hobbies = app.hobbies || null;
        
        // Status class
        const statusClass = `status-${app.status}`;
        
        let html = `
            <div class="row">
                <!-- Profile Header -->
                <div class="col-12 text-center mb-4">
                    ${candidate.image_path ? 
                        `<img src="${candidate.image_path}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid #4e73df;" onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">` :
                        `<div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 40px;">
                            <i class="fas fa-user"></i>
                        </div>`
                    }
                    <h4 class="fw-bold mb-1">${candidate.full_name || 'Unknown'}</h4>
                    <p class="text-muted mb-2"><i class="fas fa-envelope me-1"></i>${candidate.email || 'N/A'}</p>
                    <p class="text-muted mb-2"><i class="fas fa-phone me-1"></i>${candidate.mobile || 'N/A'}</p>
                    ${basics?.profession ? `<span class="badge bg-success">${basics.profession}</span>` : ''}
                </div>
                
                <!-- Applied Position -->
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-primary mb-2"><i class="fas fa-briefcase me-2"></i>Applied Position</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Position:</strong> ${job.industry?.industry_name || 'N/A'}</p>
                                    <p class="small text-muted mb-0">${job.description || ''}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="status-badge ${statusClass}">${app.status.charAt(0).toUpperCase() + app.status.slice(1)}</span>
                                    <p class="small text-muted mt-2 mb-0">Applied: ${app.applied_at ? new Date(app.applied_at).toLocaleDateString() : 'N/A'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Basic Information -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user me-2"></i>Basic Information</h6>
                            <div class="mb-2"><strong>Date of Birth:</strong> ${basics?.dob || 'Not provided'}</div>
                            <div class="mb-2"><strong>Gender:</strong> ${basics?.gender || 'Not provided'}</div>
                            <div class="mb-2"><strong>Aadhar:</strong> ${basics?.aadhar_number || 'Not provided'}</div>
                            <div class="mb-2"><strong>PAN:</strong> ${basics?.pan_number || 'Not provided'}</div>
                            <div class="mb-2"><strong>Passport:</strong> ${basics?.passport_number || 'Not provided'}</div>
                            <div class="mb-2"><strong>Job Type:</strong> ${basics?.Job_type || basics?.job_type || 'Not specified'}</div>
                            <div class="mb-0"><strong>Experience:</strong> ${basics?.experience || 'Not specified'}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Details -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-info mb-3"><i class="fas fa-address-book me-2"></i>Contact Details</h6>
                            <div class="mb-2"><strong>Email:</strong> ${candidate.email || 'N/A'}</div>
                            <div class="mb-2"><strong>Mobile:</strong> ${candidate.mobile || 'N/A'}</div>
                            <div class="mb-2"><strong>Alt. Mobile:</strong> ${basics?.alternate_mobile_number || 'Not provided'}</div>
                            <div class="mb-2"><strong>WhatsApp:</strong> ${basics?.whatsapp_number || 'Not provided'}</div>
                            <div class="mb-0"><strong>Alt. Email:</strong> ${basics?.alternate_email_id || 'Not provided'}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Present Address -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-success mb-3"><i class="fas fa-map-marker-alt me-2"></i>Present Address</h6>
                            ${presentAddress ? `
                                <p class="mb-1">${presentAddress.address_1 || ''} ${presentAddress.address_2 || ''}</p>
                                <p class="mb-1">${presentAddress.city || ''}, ${presentAddress.state || ''} - ${presentAddress.zip || ''}</p>
                                <p class="mb-1">${presentAddress.country || ''}</p>
                                <p class="mb-0"><strong>Police Station:</strong> ${presentAddress.police_station || 'N/A'}</p>
                            ` : '<p class="text-muted">No address added</p>'}
                        </div>
                    </div>
                </div>
                
                <!-- Permanent Address -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-warning mb-3"><i class="fas fa-home me-2"></i>Permanent Address</h6>
                            ${permanentAddress ? `
                                <p class="mb-1">${permanentAddress.address_1 || ''} ${permanentAddress.address_2 || ''}</p>
                                <p class="mb-1">${permanentAddress.city || ''}, ${permanentAddress.state || ''} - ${permanentAddress.zip || ''}</p>
                                <p class="mb-1">${permanentAddress.country || ''}</p>
                                <p class="mb-0"><strong>Police Station:</strong> ${permanentAddress.police_station || 'N/A'}</p>
                            ` : '<p class="text-muted">No address added</p>'}
                        </div>
                    </div>
                </div>
                
                <!-- Education & Qualifications -->
                ${app.candidate_qualifications?.length > 0 ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-success mb-3"><i class="fas fa-graduation-cap me-2"></i>Education & Qualifications</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        ${app.candidate_qualifications.map(q => {
                                            const qualParts = [];
                                            if(q.level1_qualification?.degree) qualParts.push(q.level1_qualification.degree);
                                            if(q.level2_qualification?.degree) qualParts.push(q.level2_qualification.degree);
                                            if(q.level3_qualification?.degree) qualParts.push(q.level3_qualification.degree);
                                            if(q.qualification?.degree) qualParts.push(q.qualification.degree);
                                            const qualDisplay = qualParts.length > 0 ? qualParts.join(' -> ') : 'N/A';
                                            return `
                                            <tr>
                                                <td><strong>${qualDisplay}</strong></td>
                                                <td>${q.university || '-'}</td>
                                                <td>${q.institution || '-'}</td>
                                                <td>${q.from_year} - ${q.to_year}</td>
                                                <td>${q.percentage ? q.percentage + '%' : '-'}</td>
                                            </tr>
                                            `;
                                        }).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                ` : ''}
                
                <!-- Work Experience -->
                ${app.candidate_experiences?.length > 0 ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-info mb-3"><i class="fas fa-briefcase me-2"></i>Work Experience</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        ${app.candidate_experiences.map(exp => {
                                            const industryParts = [];
                                            if(exp.industry?.industry_name) industryParts.push(exp.industry.industry_name);
                                            if(exp.industry_level_2?.industry_name) industryParts.push(exp.industry_level_2.industry_name);
                                            if(exp.industry_level_3?.industry_name) industryParts.push(exp.industry_level_3.industry_name);
                                            const industryDisplay = industryParts.length > 0 ? industryParts.join(' -> ') : 'Unknown Industry';
                                            return `
                                            <tr>
                                                <td><strong>${exp.company || 'N/A'}</strong><br><small class="text-muted">${industryDisplay}</small></td>
                                                <td>${exp.from_year} - ${exp.to_year || 'Present'}</td>
                                                <td>${exp.duration || '-'}</td>
                                                <td>${exp.present_salary ? '₹' + Number(exp.present_salary).toLocaleString() : '-'}</td>
                                            </tr>
                                            `;
                                        }).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                ` : ''}
                
                <!-- Skills & Expertise - Grouped by Job Role -->
                ${app.candidate_skills?.length > 0 ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3"><i class="fas fa-tools me-2"></i>Skills & Expertise</h6>
                            ${(() => {
                                // Group skills by industry_id (job role)
                                const groupedSkills = app.candidate_skills.reduce((acc, skill) => {
                                    const roleId = skill.skill?.industry_id || 'unknown';
                                    if (!acc[roleId]) {
                                        acc[roleId] = [];
                                    }
                                    acc[roleId].push(skill);
                                    return acc;
                                }, {});
                                
                                return Object.entries(groupedSkills).map(([roleId, roleSkills], index, arr) => {
                                    const roleName = roleSkills[0]?.skill?.industry?.industry_name || 'Unknown Role';
                                    const proficiency = roleSkills[0]?.proficiency || '';
                                    const isLast = index === arr.length - 1;
                                    
                                    return `
                                    <div class="${!isLast ? 'mb-3 pb-3 border-bottom' : ''}">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 fw-bold text-primary" style="font-size: 14px;">
                                                <i class="fas fa-briefcase me-2"></i>${roleName}
                                            </h6>
                                            ${proficiency ? `<span class="badge bg-primary" style="font-size: 11px;">${proficiency}</span>` : ''}
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            ${roleSkills.map(s => `
                                                <span class="badge bg-success" style="font-size: 12px; padding: 6px 12px;">
                                                    ${s.skill?.skill || 'Unknown'}
                                                </span>
                                            `).join('')}
                                        </div>
                                    </div>
                                    `;
                                }).join('');
                            })()}
                        </div>
                    </div>
                </div>
                ` : ''}
                
                <!-- Hobbies & Interests -->
                ${hobbies ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-danger mb-3"><i class="fas fa-heart me-2"></i>Hobbies & Interests</h6>
                            ${hobbies.description ? `<div class="mb-2">${hobbies.description}</div>` : ''}
                            ${hobbies.interests ? `
                                <div class="d-flex flex-wrap gap-2">
                                    ${hobbies.interests.split(',').map(i => `
                                        <span class="badge bg-danger" style="font-size: 12px;">${i.trim()}</span>
                                    `).join('')}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
                ` : ''}
                
                <!-- Cover Letter -->
                ${app.cover_letter ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-file-alt me-2"></i>Cover Letter</h6>
                            <p class="mb-0">${app.cover_letter}</p>
                        </div>
                    </div>
                </div>
                ` : ''}
                
                <!-- Digital Signature -->
                ${candidate.signature_image ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-signature me-2"></i>Digital Signature</h6>
                            <img src="${candidate.signature_image}" alt="Signature" style="max-width: 300px; border: 1px solid #ddd; padding: 10px; background: #fff;">
                        </div>
                    </div>
                </div>
                ` : ''}
                
                <!-- Employer Notes -->
                ${app.employer_notes ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-warning mb-2"><i class="fas fa-sticky-note me-2"></i>Your Notes</h6>
                            <p class="mb-0">${app.employer_notes}</p>
                        </div>
                    </div>
                </div>
                ` : ''}
            </div>
        `;
        
        document.getElementById('applicationModalBody').innerHTML = html;
    }

    function updateStatus(applicationId, status) {
        const statusForm = document.getElementById('statusForm');
        const newStatusInput = document.getElementById('newStatus');
        const statusAlert = document.getElementById('statusAlert');
        const statusSubmitBtn = document.getElementById('statusSubmitBtn');
        const statusModalHeader = document.getElementById('statusModalHeader');
        
        // Set form action and status
        statusForm.action = `/employer/application/${applicationId}/status`;
        newStatusInput.value = status;
        
        // Update UI based on status
        let statusText = '';
        let btnClass = '';
        let headerClass = '';
        
        switch(status) {
            case 'shortlisted':
                statusText = 'Shortlist';
                btnClass = 'btn-info';
                headerClass = 'bg-info text-white';
                break;
            case 'hired':
                statusText = 'Hire';
                btnClass = 'btn-success';
                headerClass = 'bg-success text-white';
                break;
            case 'rejected':
                statusText = 'Reject';
                btnClass = 'btn-danger';
                headerClass = 'bg-danger text-white';
                break;
        }
        
        statusAlert.innerHTML = `You are about to <strong>${statusText}</strong> this candidate.`;
        statusSubmitBtn.className = `btn ${btnClass}`;
        statusSubmitBtn.innerHTML = `<i class="fas fa-save me-2"></i>${statusText}`;
        statusModalHeader.className = `modal-header ${headerClass}`;
        
        var modal = new bootstrap.Modal(document.getElementById('statusModal'));
        modal.show();
    }

    // Handle modal close - clean up backdrops
    ['applicationModal', 'statusModal'].forEach(modalId => {
        document.getElementById(modalId).addEventListener('hidden.bs.modal', function () {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        });
    });
</script>
@endsection