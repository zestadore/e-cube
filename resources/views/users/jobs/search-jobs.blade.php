@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .job-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #e3e6f0;
        }
        .company-logo-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }
        .filter-sidebar {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
        }
        .job-detail-item {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-active {
            background: #e8f5e9;
            color: #388e3c;
        }
        .status-inactive {
            background: #ffebee;
            color: #c62828;
        }
        .modal-company-logo {
            width: 100px;
            height: 100px;
            border-radius: 15px;
            object-fit: cover;
            border: 3px solid #e3e6f0;
        }
        .industry-badge {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
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
                            <i class="fas fa-briefcase text-primary me-2"></i>Find Jobs
                        </h3>
                        <p class="text-muted mt-2 mb-0">Discover job opportunities matching your industry</p>
                    </div>
                    <a href="{{ route('employee.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card p-3 text-center">
                <i class="fas fa-briefcase fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ $jobPosts->total() }}</h4>
                <small class="opacity-75">Total Jobs</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 text-center" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border-radius: 12px;">
                <i class="fas fa-industry fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ count($availableIndustries) }}</h4>
                <small class="opacity-75">Industries</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 text-center" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 12px;">
                <i class="fas fa-graduation-cap fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ count($qualifications) }}</h4>
                <small class="opacity-75">Qualifications</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 text-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 12px;">
                <i class="fas fa-check-circle fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ $activeJobs }}</h4>
                <small class="opacity-75">Active Jobs</small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar shadow-sm">
                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-filter text-primary me-2"></i>Filters
                </h5>
                <form method="GET" action="{{ route('employee.find-jobs') }}">
                    <!-- Industry Filter -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Industry</label>
                        <select name="industry_id" class="form-select">
                            <option value="">All Industries</option>
                            @foreach($availableIndustries as $industry)
                                <option value="{{ $industry['id'] }}" {{ request('industry_id') == $industry['id'] ? 'selected' : '' }}>
                                    {{ $industry['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Qualification Filter -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Qualification</label>
                        <select name="qualification_id" class="form-select">
                            <option value="">All Qualifications</option>
                            @foreach($qualifications as $qualification)
                                <option value="{{ $qualification->id }}" {{ request('qualification_id') == $qualification->id ? 'selected' : '' }}>
                                    {{ $qualification->degree }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ request('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="" {{ request('status') === '' ? 'selected' : '' }}>All</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search jobs..." value="{{ request('search') }}">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Apply Filters
                        </button>
                        <a href="{{ route('employee.find-jobs') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Jobs Grid -->
        <div class="col-lg-9">
            @if($jobPosts->count() > 0)
                <div class="row">
                    @foreach($jobPosts as $job)
                    <div class="col-md-6 mb-4">
                        <div class="card job-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start mb-3">
                                    <!-- Company Logo -->
                                    @if($job->user && $job->user->companyProfile && $job->user->companyProfile->image_path)
                                        <img src="{{ $job->user->companyProfile->image_path }}" 
                                             alt="Company Logo" 
                                             class="company-logo me-3">
                                    @else
                                        <div class="company-logo-placeholder me-3">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h5 class="card-title fw-bold mb-1">
                                            {{ $job->user && $job->user->companyProfile ? $job->user->companyProfile->company_name : 'Unknown Company' }}
                                        </h5>
                                        <span class="industry-badge">
                                            <i class="fas fa-industry me-1"></i>{{ $job->industry->industry_name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Job Description -->
                                <p class="text-muted mb-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ Str::limit($job->description, 150) }}
                                </p>

                                <!-- Qualifications -->
                                <div class="mb-3">
                                    @if($job->parentQualification)
                                        <span class="badge bg-info text-dark me-1">{{ $job->parentQualification->degree }}</span>
                                    @endif
                                    @if($job->qualification)
                                        <span class="badge bg-secondary">{{ $job->qualification->degree }}</span>
                                    @endif
                                </div>

                                <!-- Application Dates -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Apply: {{ $job->application_start_date->format('d M Y') }} - {{ $job->application_end_date->format('d M Y') }}
                                    </small>
                                </div>

                                <!-- Status & Action -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="status-badge status-{{ $job->status }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                    <button class="btn btn-primary btn-sm" onclick="viewJob({{ $job->id }})">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-0 py-2">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>Posted {{ $job->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $jobPosts->appends(request()->except('page'))->links() }}
                </div>
            @else
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Jobs Found</h4>
                        <p class="text-muted">Try adjusting your filters or check back later</p>
                        <a href="{{ route('employee.find-jobs') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-undo me-2"></i>Reset Filters
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Job Details Modal -->
<div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title text-white" id="jobModalLabel">
                    <i class="fas fa-briefcase me-2"></i>Job Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="jobModalBody">
                <!-- Content loaded via AJAX -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading job details...</p>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4" id="jobModalFooter">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Apply Job Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <h5 class="modal-title text-white" id="applyModalLabel">
                    <i class="fas fa-paper-plane me-2"></i>Apply for Job
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="applyForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" id="applyJobId" name="job_id">
                    <div class="mb-3">
                        <label for="coverLetter" class="form-label fw-semibold">Cover Letter (Optional)</label>
                        <textarea class="form-control" id="coverLetter" name="cover_letter" rows="5" placeholder="Write a brief cover letter to introduce yourself..."></textarea>
                        <div class="form-text">Maximum 2000 characters</div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Your profile information will be shared with the employer.
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="applySubmitBtn">
                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function viewJob(jobId) {
        var modal = new bootstrap.Modal(document.getElementById('jobModal'));
        modal.show();
        
        // Reset modal body
        document.getElementById('jobModalBody').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading job details...</p>
            </div>
        `;
        
        // Fetch job details
        fetch(`/employee/job/${jobId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                renderJobDetails(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('jobModalBody').innerHTML = `
                    <div class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <h5>Failed to load job details</h5>
                        <p class="text-muted">Please try again later</p>
                    </div>
                `;
            });
    }

    let currentJobId = null;
    let hasApplied = false;

    function renderJobDetails(data) {
        const job = data.job;
        const company = job.user?.company_profile;
        currentJobId = job.id;
        hasApplied = data.has_applied;
        
        // Format dates
        const appStart = new Date(job.application_start_date).toLocaleDateString('en-IN', {
            day: '2-digit', month: 'long', year: 'numeric'
        });
        const appEnd = new Date(job.application_end_date).toLocaleDateString('en-IN', {
            day: '2-digit', month: 'long', year: 'numeric'
        });
        const expiryDate = new Date(job.expiry_date).toLocaleDateString('en-IN', {
            day: '2-digit', month: 'long', year: 'numeric'
        });
        
        // Company logo HTML
        let logoHtml = '';
        if (company && company.image_path) {
            logoHtml = `<img src="${company.image_path}" alt="Company Logo" class="modal-company-logo shadow-sm">`;
        } else {
            logoHtml = `
                <div class="modal-company-logo shadow-sm d-flex align-items-center justify-content-center" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 40px;">
                    <i class="fas fa-building"></i>
                </div>
            `;
        }
        
        // Status badge
        const statusClass = job.status === 'active' ? 'status-active' : 'status-inactive';
        
        // Update footer based on application status
        const footerHtml = hasApplied ? 
            `<button type="button" class="btn btn-success" disabled style="border-radius: 8px;">
                <i class="fas fa-check me-2"></i>Already Applied
            </button>` :
            `<button type="button" class="btn btn-success" onclick="openApplyModal()" style="border-radius: 8px;">
                <i class="fas fa-paper-plane me-2"></i>Apply Now
            </button>`;
        
        document.getElementById('jobModalFooter').innerHTML = `
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                <i class="fas fa-times me-2"></i>Close
            </button>
            ${footerHtml}
        `;
        
        const modalHtml = `
            <div class="row">
                <!-- Left Column - Company Info -->
                <div class="col-md-4 text-center mb-4">
                    ${logoHtml}
                    <h4 class="fw-bold mt-3 mb-1">${company?.company_name || 'Unknown Company'}</h4>
                    <span class="industry-badge">
                        <i class="fas fa-industry me-1"></i>${job.industry?.industry_name || 'N/A'}
                    </span>
                    <div class="mt-3">
                        ${company?.company_email ? `
                            <a href="mailto:${company.company_email}" class="btn btn-sm btn-outline-primary w-100 mb-2">
                                <i class="fas fa-envelope me-2"></i>Email Company
                            </a>
                        ` : ''}
                        ${company?.company_phone ? `
                            <a href="tel:${company.company_phone}" class="btn btn-sm btn-outline-success w-100">
                                <i class="fas fa-phone me-2"></i>Call Now
                            </a>
                        ` : ''}
                    </div>
                </div>
                
                <!-- Right Column - Job Details -->
                <div class="col-md-8">
                    <!-- Job Status -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="status-badge ${statusClass}">
                            ${job.status.charAt(0).toUpperCase() + job.status.slice(1)}
                        </span>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>Posted on ${new Date(job.created_at).toLocaleDateString('en-IN')}
                        </small>
                    </div>
                    
                    <!-- Description -->
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-primary mb-2"><i class="fas fa-align-left me-2"></i>Job Description</h6>
                            <p class="mb-0">${job.description}</p>
                        </div>
                    </div>
                    
                    <!-- Qualifications -->
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-success mb-2"><i class="fas fa-graduation-cap me-2"></i>Required Qualifications</h6>
                            <div>
                                ${job.parent_qualification ? `
                                    <span class="badge bg-info text-dark me-2">${job.parent_qualification.degree}</span>
                                ` : ''}
                                ${job.qualification ? `
                                    <span class="badge bg-secondary">${job.qualification.degree}</span>
                                ` : '<span class="text-muted">No specific qualification required</span>'}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Important Dates -->
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-info mb-2"><i class="fas fa-calendar-alt me-2"></i>Important Dates</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Application Start</small>
                                    <p class="mb-0 fw-semibold">${appStart}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Application End</small>
                                    <p class="mb-0 fw-semibold">${appEnd}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Job Expiry</small>
                                    <p class="mb-0 fw-semibold">${expiryDate}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Company Details -->
                    ${company ? `
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-building me-2"></i>Company Details</h6>
                            <div class="row">
                                ${company.company_address ? `
                                    <div class="col-12 mb-2">
                                        <small class="text-muted">Address</small>
                                        <p class="mb-0">${company.company_address}</p>
                                    </div>
                                ` : ''}
                                ${company.company_phone ? `
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Phone</small>
                                        <p class="mb-0 fw-semibold">${company.company_phone}</p>
                                    </div>
                                ` : ''}
                                ${company.company_email ? `
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Email</small>
                                        <p class="mb-0 fw-semibold">${company.company_email}</p>
                                    </div>
                                ` : ''}
                                ${company.website ? `
                                    <div class="col-12">
                                        <small class="text-muted">Website</small>
                                        <p class="mb-0">
                                            <a href="${company.website}" target="_blank" class="text-primary">
                                                ${company.website} <i class="fas fa-external-link-alt small"></i>
                                            </a>
                                        </p>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
        
        document.getElementById('jobModalBody').innerHTML = modalHtml;
    }

    function openApplyModal() {
        // Hide job modal
        bootstrap.Modal.getInstance(document.getElementById('jobModal')).hide();
        
        // Set job ID in apply form
        document.getElementById('applyJobId').value = currentJobId;
        document.getElementById('coverLetter').value = '';
        
        // Show apply modal
        var applyModal = new bootstrap.Modal(document.getElementById('applyModal'));
        applyModal.show();
    }

    // Handle apply form submission
    document.getElementById('applyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const coverLetter = document.getElementById('coverLetter').value;
        const submitBtn = document.getElementById('applySubmitBtn');
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
        
        fetch(`/employee/job/${currentJobId}/apply`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cover_letter: coverLetter })
        })
        .then(response => response.json())
        .then(data => {
            // Hide apply modal
            bootstrap.Modal.getInstance(document.getElementById('applyModal')).hide();
            
            if (data.success) {
                // Show success message
                alert(data.message);
                // Refresh job view to show "Already Applied"
                viewJob(currentJobId);
            } else {
                alert(data.message || 'Failed to submit application. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to submit application. Please try again.');
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Application';
        });
    });

    // Handle job modal close - clean up backdrops
    document.getElementById('jobModal').addEventListener('hidden.bs.modal', function () {
        // Remove any lingering modal backdrops
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    });

    // Handle apply modal close - clean up backdrops
    document.getElementById('applyModal').addEventListener('hidden.bs.modal', function () {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    });
</script>
@endsection