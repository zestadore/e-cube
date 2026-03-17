@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="container-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">
                            <i class="fas fa-briefcase text-primary me-2"></i>My Job Listings
                        </h3>
                        <p class="text-muted mt-2 mb-0">Manage all your job postings from here</p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addJobModal">
                        <i class="fas fa-plus me-2"></i>New Job Listing
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px;">
                <div class="card-body text-center py-3">
                    <i class="fas fa-briefcase fa-2x text-white mb-2"></i>
                    <h4 class="text-white mb-0">{{ $jobPosts->count() }}</h4>
                    <small class="text-white-50">Total Jobs</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 12px;">
                <div class="card-body text-center py-3">
                    <i class="fas fa-check-circle fa-2x text-white mb-2"></i>
                    <h4 class="text-white mb-0">{{ $jobPosts->where('status', 'active')->count() }}</h4>
                    <small class="text-white-50">Active Jobs</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px;">
                <div class="card-body text-center py-3">
                    <i class="fas fa-clock fa-2x text-white mb-2"></i>
                    <h4 class="text-white mb-0">{{ $jobPosts->where('status', 'inactive')->count() }}</h4>
                    <small class="text-white-50">Inactive Jobs</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px;">
                <div class="card-body text-center py-3">
                    <i class="fas fa-calendar-times fa-2x text-white mb-2"></i>
                    <h4 class="text-white mb-0">{{ $jobPosts->where('status', 'expired')->count() }}</h4>
                    <small class="text-white-50">Expired Jobs</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="row">
        @forelse($jobPosts as $job)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-{{ $job->status == 'active' ? 'success' : ($job->status == 'inactive' ? 'warning' : 'danger') }}">
                            {{ ucfirst($job->status) }}
                        </span>
                        <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">{{ $job->job_title }}</h5>
                    
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-graduation-cap text-primary me-2" style="width: 20px;"></i>
                            <small class="text-muted">{{ $job->qualification->degree ?? 'N/A' }}</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-check text-success me-2" style="width: 20px;"></i>
                            <small class="text-muted">Apply: {{ $job->application_start_date->format('d M Y') }} - {{ $job->application_end_date->format('d M Y') }}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hourglass-end text-danger me-2" style="width: 20px;"></i>
                            <small class="text-muted">Expires: {{ $job->expiry_date->format('d M Y') }}</small>
                        </div>
                    </div>
                    
                    <p class="card-text text-muted small" style="line-height: 1.6;">{{ Str::limit($job->description, 100) }}</p>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm flex-grow-1" onclick="viewJob({{ $job->id }})">
                            <i class="fas fa-eye me-1"></i>View
                        </button>
                        <button class="btn btn-outline-secondary btn-sm flex-grow-1" onclick="editJob({{ $job->id }})">
                            <i class="fas fa-edit me-1"></i>Edit
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $job->id }}, '{{ addslashes($job->job_title) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Job Listings Yet</h4>
                    <p class="text-muted">Start by creating your first job posting!</p>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addJobModal">
                        <i class="fas fa-plus me-2"></i>Create Job Listing
                    </button>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Job Modal -->
<div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title text-white" id="addJobModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Create New Job Listing
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('employer.jobs.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="job_title" class="form-label fw-semibold">Job Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('job_title') is-invalid @enderror" 
                                   id="job_title" name="job_title" placeholder="e.g. Senior Software Engineer" 
                                   value="{{ old('job_title') }}" required style="border-radius: 8px;">
                            @error('job_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-semibold">Job Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Describe the job responsibilities, requirements, benefits..." 
                                      required style="border-radius: 8px;">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="qualification_id" class="form-label fw-semibold">Required Qualification <span class="text-danger">*</span></label>
                            <select class="form-select @error('qualification_id') is-invalid @enderror" 
                                    id="qualification_id" name="qualification_id" required style="border-radius: 8px;">
                                <option value="">Select Qualification</option>
                                @foreach(\App\Models\Qualification::all() as $qualification)
                                    <option value="{{ $qualification->id }}" {{ old('qualification_id') == $qualification->id ? 'selected' : '' }}>
                                        {{ $qualification->degree }}
                                    </option>
                                @endforeach
                            </select>
                            @error('qualification_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="application_start_date" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('application_start_date') is-invalid @enderror" 
                                   id="application_start_date" name="application_start_date" 
                                   value="{{ old('application_start_date', date('Y-m-d')) }}" required style="border-radius: 8px;">
                            @error('application_start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="application_end_date" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('application_end_date') is-invalid @enderror" 
                                   id="application_end_date" name="application_end_date" 
                                   value="{{ old('application_end_date') }}" required style="border-radius: 8px;">
                            @error('application_end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="expiry_date" class="form-label fw-semibold">Job Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                   id="expiry_date" name="expiry_date" 
                                   value="{{ old('expiry_date') }}" required style="border-radius: 8px;">
                            @error('expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px;">
                        <i class="fas fa-save me-2"></i>Post Job
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Job Modal -->
<div class="modal fade" id="viewJobModal" tabindex="-1" aria-labelledby="viewJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <h5 class="modal-title text-white" id="viewJobModalLabel">
                    <i class="fas fa-eye me-2"></i>Job Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h4 class="fw-bold text-primary mb-3" id="view_job_title"></h4>
                        <span class="badge" id="view_job_status"></span>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold text-muted">Description</label>
                        <p id="view_description" class="p-3 bg-light rounded" style="line-height: 1.8;"></p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Required Qualification</label>
                        <p class="fw-semibold"><i class="fas fa-graduation-cap text-primary me-2"></i><span id="view_qualification"></span></p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Job Status</label>
                        <p class="fw-semibold"><i class="fas fa-info-circle text-info me-2"></i><span id="view_status_text"></span></p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold text-muted">Application Start Date</label>
                        <p class="fw-semibold"><i class="fas fa-calendar text-success me-2"></i><span id="view_start_date"></span></p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold text-muted">Application End Date</label>
                        <p class="fw-semibold"><i class="fas fa-calendar-check text-primary me-2"></i><span id="view_end_date"></span></p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold text-muted">Job Expiry Date</label>
                        <p class="fw-semibold"><i class="fas fa-hourglass-end text-danger me-2"></i><span id="view_expiry_date"></span></p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Posted On</label>
                        <p class="fw-semibold"><i class="fas fa-clock text-secondary me-2"></i><span id="view_created_at"></span></p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Last Updated</label>
                        <p class="fw-semibold"><i class="fas fa-sync text-secondary me-2"></i><span id="view_updated_at"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h5 class="modal-title text-white" id="editJobModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Job Listing
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editJobForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_job_title" class="form-label fw-semibold">Job Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_job_title" name="job_title" required style="border-radius: 8px;">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="edit_description" class="form-label fw-semibold">Job Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_description" name="description" rows="4" required style="border-radius: 8px;"></textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="edit_qualification_id" class="form-label fw-semibold">Required Qualification <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_qualification_id" name="qualification_id" required style="border-radius: 8px;">
                                <option value="">Select Qualification</option>
                                @foreach(\App\Models\Qualification::all() as $qualification)
                                    <option value="{{ $qualification->id }}">{{ $qualification->degree }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="edit_application_start_date" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_application_start_date" name="application_start_date" required style="border-radius: 8px;">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="edit_application_end_date" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_application_end_date" name="application_end_date" required style="border-radius: 8px;">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="edit_expiry_date" class="form-label fw-semibold">Job Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_expiry_date" name="expiry_date" required style="border-radius: 8px;">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="edit_status" class="form-label fw-semibold">Job Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required style="border-radius: 8px;">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px;">
                        <i class="fas fa-save me-2"></i>Update Job
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteJobModal" tabindex="-1" aria-labelledby="deleteJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteJobModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                <h5 class="mb-3">Are you sure you want to delete this job?</h5>
                <p class="text-muted mb-0" id="delete_job_title"></p>
                <p class="text-danger small mt-2"><i class="fas fa-info-circle me-1"></i>This action cannot be undone!</p>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <form id="deleteJobForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4" style="border-radius: 8px;">
                        <i class="fas fa-trash me-2"></i>Delete Job
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Set minimum date for end date and expiry date based on start date
    document.getElementById('application_start_date').addEventListener('change', function() {
        var startDate = this.value;
        document.getElementById('application_end_date').min = startDate;
        document.getElementById('expiry_date').min = startDate;
    });
    
    // Show modal if there are validation errors
    @if($errors->any())
        var addJobModal = new bootstrap.Modal(document.getElementById('addJobModal'));
        addJobModal.show();
    @endif

    // View Job Function
    function viewJob(jobId) {
        fetch(`/employer/jobs/${jobId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('view_job_title').textContent = data.job_title;
                document.getElementById('view_description').textContent = data.description;
                document.getElementById('view_qualification').textContent = data.qualification ? data.qualification.degree : 'N/A';
                document.getElementById('view_status_text').textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                
                // Status badge styling
                const statusBadge = document.getElementById('view_job_status');
                statusBadge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                statusBadge.className = 'badge';
                if (data.status === 'active') {
                    statusBadge.classList.add('bg-success');
                } else if (data.status === 'inactive') {
                    statusBadge.classList.add('bg-warning');
                } else {
                    statusBadge.classList.add('bg-danger');
                }
                
                // Format dates
                const startDate = new Date(data.application_start_date);
                const endDate = new Date(data.application_end_date);
                const expiryDate = new Date(data.expiry_date);
                const createdAt = new Date(data.created_at);
                const updatedAt = new Date(data.updated_at);
                
                document.getElementById('view_start_date').textContent = startDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                document.getElementById('view_end_date').textContent = endDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                document.getElementById('view_expiry_date').textContent = expiryDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                document.getElementById('view_created_at').textContent = createdAt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                document.getElementById('view_updated_at').textContent = updatedAt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                
                var viewModal = new bootstrap.Modal(document.getElementById('viewJobModal'));
                viewModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load job details. Please try again.');
            });
    }

    // Edit Job Function
    function editJob(jobId) {
        fetch(`/employer/jobs/${jobId}/edit`)
            .then(response => response.json())
            .then(data => {
                const job = data.job;
                
                // Set form action
                document.getElementById('editJobForm').action = `/employer/jobs/${jobId}`;
                
                // Fill form fields
                document.getElementById('edit_job_title').value = job.job_title;
                document.getElementById('edit_description').value = job.description;
                document.getElementById('edit_qualification_id').value = job.qualification_id;
                
                // Format dates to YYYY-MM-DD for date input
                document.getElementById('edit_application_start_date').value = formatDateForInput(job.application_start_date);
                document.getElementById('edit_application_end_date').value = formatDateForInput(job.application_end_date);
                document.getElementById('edit_expiry_date').value = formatDateForInput(job.expiry_date);
                
                document.getElementById('edit_status').value = job.status;
                
                var editModal = new bootstrap.Modal(document.getElementById('editJobModal'));
                editModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load job details for editing. Please try again.');
            });
    }

    // Helper function to format date for HTML date input
    function formatDateForInput(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Delete Job Function
    function confirmDelete(jobId, jobTitle) {
        document.getElementById('delete_job_title').textContent = `"${jobTitle}"`;
        document.getElementById('deleteJobForm').action = `/employer/jobs/${jobId}`;
        
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteJobModal'));
        deleteModal.show();
    }
</script>
@endsection