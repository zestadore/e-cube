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
        .company-badge {
            background: #e3f2fd;
            color: #1976d2;
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
                            <i class="fas fa-users text-primary me-2"></i>All Job Applications
                        </h3>
                        <p class="text-muted mt-2 mb-0">View and manage all job applications across the platform</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
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
                    <form method="GET" action="{{ route('admin.applications.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Filter by Job</label>
                            <select name="job_id" class="form-select">
                                <option value="">All Jobs</option>
                                @foreach($jobs as $job)
                                    <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                        {{ Str::limit($job->description, 40) }} ({{ $job->industry->industry_name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Industry</label>
                            <select name="industry_id" class="form-select">
                                <option value="">All Industries</option>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}" {{ request('industry_id') == $industry->id ? 'selected' : '' }}>
                                        {{ $industry->industry_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Candidate name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                                <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary btn-sm">
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
                                             class="candidate-avatar me-3">
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
                                    <p class="mb-1 fw-semibold">{{ Str::limit($application->jobPost->description, 50) }}</p>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-info text-dark">
                                            <i class="fas fa-industry me-1"></i>{{ $application->jobPost->industry->industry_name ?? 'N/A' }}
                                        </span>
                                        <span class="company-badge">
                                            <i class="fas fa-building me-1"></i>{{ $application->jobPost->user->companyProfile->company_name ?? 'Unknown Company' }}
                                        </span>
                                    </div>
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
                                    <form action="{{ route('admin.applications.destroy', $application->id) }}" method="POST" class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
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
                        <p class="text-muted">No applications match your filters.</p>
                        <a href="{{ route('admin.applications.index') }}" class="btn btn-primary mt-3">
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
                    <i class="fas fa-user me-2"></i>Application Details
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
        fetch(`/admin/applications/${applicationId}`)
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
        const company = job.user?.company_profile;
        
        // Status class
        const statusClass = `status-${app.status}`;
        
        let html = `
            <div class="row">
                <!-- Candidate Info -->
                <div class="col-md-4 text-center mb-4">
                    ${candidate.image_path ? 
                        `<img src="${candidate.image_path}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">` :
                        `<div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 40px;">
                            <i class="fas fa-user"></i>
                        </div>`
                    }
                    <h4 class="fw-bold mb-1">${candidate.full_name || 'Unknown'}</h4>
                    <p class="text-muted mb-2">${candidate.email || 'N/A'}</p>
                    <p class="text-muted mb-2"><i class="fas fa-phone me-1"></i>${candidate.mobile || 'N/A'}</p>
                    <span class="status-badge ${statusClass}">${app.status.charAt(0).toUpperCase() + app.status.slice(1)}</span>
                </div>
                
                <!-- Details -->
                <div class="col-md-8">
                    <!-- Company & Job Info -->
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-primary mb-2"><i class="fas fa-building me-2"></i>Employer</h6>
                            <p class="mb-1"><strong>${company?.company_name || 'Unknown Company'}</strong></p>
                            <p class="small text-muted mb-0">${company?.company_email || ''}</p>
                            <hr>
                            <h6 class="fw-bold text-info mb-2"><i class="fas fa-briefcase me-2"></i>Job Details</h6>
                            <p class="mb-1"><strong>${job.industry?.industry_name || 'N/A'}</strong></p>
                            <p class="small text-muted mb-0">${job.description}</p>
                        </div>
                    </div>
                    
                    <!-- Qualifications -->
                    ${candidate.candidate_qualifications?.length > 0 ? `
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-success mb-2"><i class="fas fa-graduation-cap me-2"></i>Qualifications</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        ${candidate.candidate_qualifications.map(q => `
                                            <tr>
                                                <td><strong>${q.qualification?.degree || 'N/A'}</strong></td>
                                                <td>${q.university || '-'}</td>
                                                <td>${q.percentage ? q.percentage + '%' : '-'}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                    
                    <!-- Experience -->
                    ${candidate.candidate_experiences?.length > 0 ? `
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-info mb-2"><i class="fas fa-briefcase me-2"></i>Experience</h6>
                            ${candidate.candidate_experiences.map(exp => `
                                <div class="mb-2">
                                    <strong>${exp.industry?.industry_name || 'N/A'}</strong>
                                    ${exp.company ? `<span class="text-muted"> at ${exp.company}</span>` : ''}
                                    <br>
                                    <small class="text-muted">${exp.from_year} - ${exp.to_year || 'Present'}</small>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    ` : ''}
                    
                    <!-- Cover Letter -->
                    ${app.cover_letter ? `
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-file-alt me-2"></i>Cover Letter</h6>
                            <p class="mb-0">${app.cover_letter}</p>
                        </div>
                    </div>
                    ` : ''}
                    
                    <!-- Employer Notes -->
                    ${app.employer_notes ? `
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-warning mb-2"><i class="fas fa-sticky-note me-2"></i>Employer Notes</h6>
                            <p class="mb-0">${app.employer_notes}</p>
                        </div>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
        
        document.getElementById('applicationModalBody').innerHTML = html;
    }

    // Handle modal close - clean up backdrops
    document.getElementById('applicationModal').addEventListener('hidden.bs.modal', function () {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    });
</script>
@endsection