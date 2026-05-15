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
                    <h5 class="card-title fw-bold mb-3">{{ $job->industry->industry_name ?? 'N/A' }}</h5>
                    
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-industry text-primary me-2" style="width: 20px;"></i>
                            <small class="text-muted">{{ $job->industry->industry_name ?? 'N/A' }}</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-graduation-cap text-info me-2" style="width: 20px;"></i>
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
                        <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $job->id }}, '{{ addslashes($job->industry->industry_name ?? 'Job') }}')">
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
                            <label for="industry_id" class="form-label fw-semibold">Job Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('industry_id') is-invalid @enderror" 
                                    id="industry_id" name="industry_id" required style="border-radius: 8px;">
                                <option value="">Select Job Role</option>
                                @foreach($jobIndustries as $industry)
                                    <option value="{{ $industry['id'] }}" {{ old('industry_id') == $industry['id'] ? 'selected' : '' }}>
                                        {{ $industry['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @if(count($jobIndustries) == 0)
                                <small class="text-muted">Please select your company industry in profile first.</small>
                            @endif
                            @error('industry_id')
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
                        
                        <div class="col-md-6 mb-3">
                            <label for="parent_qualification_id" class="form-label fw-semibold">Qualification Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('parent_qualification_id') is-invalid @enderror" 
                                    id="parent_qualification_id" name="parent_qualification_id" required style="border-radius: 8px;">
                                <option value="">Select Category</option>
                                @foreach($parentQualifications as $parentQualification)
                                    <option value="{{ $parentQualification->id }}" {{ old('parent_qualification_id') == $parentQualification->id ? 'selected' : '' }}>
                                        {{ $parentQualification->degree }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_qualification_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="qualification_id" class="form-label fw-semibold">Specific Qualification <span class="text-danger">*</span></label>
                            <select class="form-select @error('qualification_id') is-invalid @enderror" 
                                    id="qualification_id" name="qualification_id" required style="border-radius: 8px;">
                                <option value="">Select Qualification</option>
                            </select>
                            @error('qualification_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small id="qualification_help" class="text-muted">Select a category first</small>
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
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <h5 class="modal-title text-white" id="viewJobModalLabel">
                    <i class="fas fa-eye me-2"></i>Job Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Job Details Section -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h4 class="fw-bold text-primary mb-3" id="view_job_industry"></h4>
                        <span class="badge" id="view_job_status"></span>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold text-muted">Description</label>
                        <p id="view_description" class="p-3 bg-light rounded" style="line-height: 1.8;"></p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Job Role</label>
                        <p class="fw-semibold"><i class="fas fa-industry text-primary me-2"></i><span id="view_industry"></span></p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Required Qualification</label>
                        <p class="fw-semibold"><i class="fas fa-graduation-cap text-info me-2"></i><span id="view_qualification"></span></p>
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

                <hr class="my-4">

                <!-- Applications Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-primary mb-0">
                                <i class="fas fa-users me-2"></i>Applications
                            </h5>
                            <span class="badge bg-info" id="applications_count">0 Applications</span>
                        </div>
                        
                <div id="applications_table_container">
                            <!-- Applications table will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Application Details Modal (Nested inside View Job Modal) -->
<div class="modal fade" id="applicationDetailModal" tabindex="-1" aria-labelledby="applicationDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title text-white" id="applicationDetailModalLabel">
                    <i class="fas fa-user-circle me-2"></i>Candidate Application Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="applicationDetailBody">
                <!-- Content will be loaded dynamically -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading application details...</p>
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
                            <label for="edit_industry_id" class="form-label fw-semibold">Job Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_industry_id" name="industry_id" required style="border-radius: 8px;">
                                <option value="">Select Job Role</option>
                                @foreach($jobIndustries as $industry)
                                    <option value="{{ $industry['id'] }}">{{ $industry['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="edit_description" class="form-label fw-semibold">Job Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_description" name="description" rows="4" required style="border-radius: 8px;"></textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_parent_qualification_id" class="form-label fw-semibold">Qualification Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_parent_qualification_id" name="parent_qualification_id" required style="border-radius: 8px;">
                                <option value="">Select Category</option>
                                @foreach($parentQualifications as $parentQualification)
                                    <option value="{{ $parentQualification->id }}">{{ $parentQualification->degree }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_qualification_id" class="form-label fw-semibold">Specific Qualification <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_qualification_id" name="qualification_id" required style="border-radius: 8px;">
                                <option value="">Select Qualification</option>
                            </select>
                            <small id="edit_qualification_help" class="text-muted">Select a category first</small>
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
                <p class="text-muted mb-0" id="delete_job_industry"></p>
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
    // Qualifications data for cascading dropdowns
    const qualificationsData = @json($allQualifications);
    
    // Function to collect all children recursively from a qualification with depth tracking
    function collectAllChildrenWithDepth(qualificationId, visited = new Set(), depth = 0) {
        const allChildren = [];
        const qualification = qualificationsData.find(q => q.id == qualificationId);
        
        if (!qualification || !qualification.children || visited.has(qualificationId)) {
            return allChildren;
        }
        
        visited.add(qualificationId);
        
        qualification.children.forEach(child => {
            allChildren.push({
                ...child,
                depth: depth
            });
            // Recursively collect child's children with increased depth
            const grandChildren = collectAllChildrenWithDepth(child.id, visited, depth + 1);
            allChildren.push(...grandChildren);
        });
        
        return allChildren;
    }
    
    // Function to populate child qualifications dropdown
    function populateChildQualifications(parentSelectId, childSelectId, helpTextId, selectedChildId = null) {
        const parentId = document.getElementById(parentSelectId).value;
        const childSelect = document.getElementById(childSelectId);
        const helpText = document.getElementById(helpTextId);
        
        // Clear existing options
        childSelect.innerHTML = '<option value="">Select Qualification</option>';
        
        if (!parentId) {
            childSelect.disabled = true;
            helpText.textContent = 'Select a category first';
            return;
        }
        
        // Collect all children recursively with depth (including nested children)
        const allChildren = collectAllChildrenWithDepth(parentId);
        
        if (allChildren.length === 0) {
            childSelect.disabled = true;
            helpText.textContent = 'No qualifications available for this category';
        } else {
            childSelect.disabled = false;
            helpText.textContent = 'Select a specific qualification';
            
            allChildren.forEach(child => {
                const option = document.createElement('option');
                option.value = child.id;
                // Add "— " prefix based on depth for hierarchical display
                option.textContent = '— '.repeat(child.depth + 1) + child.degree;
                if (selectedChildId && child.id == selectedChildId) {
                    option.selected = true;
                }
                childSelect.appendChild(option);
            });
        }
    }
    
    // Add Job Modal - Parent Qualification Change
    document.getElementById('parent_qualification_id').addEventListener('change', function() {
        populateChildQualifications('parent_qualification_id', 'qualification_id', 'qualification_help');
    });
    
    // Edit Job Modal - Parent Qualification Change
    document.getElementById('edit_parent_qualification_id').addEventListener('change', function() {
        populateChildQualifications('edit_parent_qualification_id', 'edit_qualification_id', 'edit_qualification_help');
    });
    
    // Initialize child dropdowns as disabled
    document.getElementById('qualification_id').disabled = true;
    document.getElementById('edit_qualification_id').disabled = true;

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
        // Populate child qualifications if parent was selected
        @if(old('parent_qualification_id'))
            populateChildQualifications('parent_qualification_id', 'qualification_id', 'qualification_help', {{ old('qualification_id') }});
            document.getElementById('qualification_id').disabled = false;
        @endif
    @endif

    // View Job Function
    function viewJob(jobId) {
        fetch(`/employer/jobs/${jobId}`)
            .then(response => response.json())
            .then(data => {
                // Show industry name as title
                const industryName = data.industry ? data.industry.industry_name : 'N/A';
                document.getElementById('view_job_industry').textContent = industryName;
                document.getElementById('view_industry').textContent = industryName;
                
                document.getElementById('view_description').textContent = data.description;
                document.getElementById('view_qualification').textContent = data.qualification ? data.qualification.degree : 'N/A';
                
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
                
                // Render applications table
                renderApplicationsTable(data.applications || []);
                
                var viewModal = new bootstrap.Modal(document.getElementById('viewJobModal'));
                viewModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load job details. Please try again.');
            });
    }

    // Render applications table
    function renderApplicationsTable(applications) {
        const container = document.getElementById('applications_table_container');
        const countBadge = document.getElementById('applications_count');
        
        // Update count badge
        const count = applications.length;
        countBadge.textContent = `${count} Application${count !== 1 ? 's' : ''}`;
        
        if (count === 0) {
            container.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p class="mb-0">No applications received for this job yet.</p>
                </div>
            `;
            return;
        }
        
        // Generate table HTML
        let tableHtml = `
            <div class="table-responsive">
                <table class="table table-hover table-striped" style="border-radius: 8px; overflow: hidden;">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Candidate</th>
                            <th>Qualification</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        applications.forEach((app, index) => {
            const candidate = app.user;
            const fullName = candidate ? candidate.full_name : 'Unknown';
            const email = candidate ? candidate.email : 'N/A';
            const avatar = candidate && candidate.image_path 
                ? `<img src="${candidate.image_path}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">`
                : `<div class="rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                     <i class="fas fa-user"></i>
                   </div>`;
            
            // Get qualifications
            let qualifications = 'N/A';
            if (candidate && candidate.candidate_qualifications && candidate.candidate_qualifications.length > 0) {
                qualifications = candidate.candidate_qualifications.map(q => q.qualification?.degree || 'N/A').join(', ');
                if (qualifications.length > 30) {
                    qualifications = qualifications.substring(0, 30) + '...';
                }
            }
            
            // Format date
            const appliedDate = app.applied_at 
                ? new Date(app.applied_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })
                : 'N/A';
            
            // Status badge
            let statusBadge = '';
            switch(app.status) {
                case 'pending':
                    statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                    break;
                case 'shortlisted':
                    statusBadge = '<span class="badge bg-info">Shortlisted</span>';
                    break;
                case 'hired':
                    statusBadge = '<span class="badge bg-success">Hired</span>';
                    break;
                case 'rejected':
                    statusBadge = '<span class="badge bg-danger">Rejected</span>';
                    break;
                default:
                    statusBadge = `<span class="badge bg-secondary">${app.status}</span>`;
            }
            
            tableHtml += `
                <tr>
                    <td class="align-middle">${index + 1}</td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            ${avatar}
                            <div class="ms-3">
                                <div class="fw-semibold">${fullName}</div>
                                <small class="text-muted">${email}</small>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle text-muted">${qualifications}</td>
                    <td class="align-middle text-muted">${appliedDate}</td>
                    <td class="align-middle">${statusBadge}</td>
                    <td class="align-middle">
                        <button class="btn btn-sm btn-outline-primary" onclick="viewApplicationDetail(${app.id})">
                            <i class="fas fa-eye me-1"></i>View
                        </button>
                    </td>
                </tr>
            `;
        });
        
        tableHtml += `
                    </tbody>
                </table>
            </div>
        `;
        
        container.innerHTML = tableHtml;
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
                document.getElementById('edit_industry_id').value = job.industry_id;
                document.getElementById('edit_description').value = job.description;
                
                // Set parent qualification and populate children
                if (job.parent_qualification_id) {
                    document.getElementById('edit_parent_qualification_id').value = job.parent_qualification_id;
                    populateChildQualifications('edit_parent_qualification_id', 'edit_qualification_id', 'edit_qualification_help', job.qualification_id);
                } else {
                    document.getElementById('edit_parent_qualification_id').value = '';
                    document.getElementById('edit_qualification_id').innerHTML = '<option value="">Select Qualification</option>';
                    document.getElementById('edit_qualification_id').disabled = true;
                    document.getElementById('edit_qualification_help').textContent = 'Select a category first';
                }
                
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
    function confirmDelete(jobId, jobIndustry) {
        document.getElementById('delete_job_industry').textContent = `"${jobIndustry}"`;
        document.getElementById('deleteJobForm').action = `/employer/jobs/${jobId}`;
        
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteJobModal'));
        deleteModal.show();
    }

    // View Application Detail Function
    function viewApplicationDetail(applicationId) {
        // Show loading state
        document.getElementById('applicationDetailBody').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading application details...</p>
            </div>
        `;
        
        // Show the modal
        var appDetailModal = new bootstrap.Modal(document.getElementById('applicationDetailModal'));
        appDetailModal.show();
        
        // Fetch application details
        fetch(`/employer/application/${applicationId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load application details');
                }
                return response.json();
            })
            .then(data => {
                renderApplicationDetail(data.application);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('applicationDetailBody').innerHTML = `
                    <div class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <h5>Failed to load application details</h5>
                        <p class="text-muted">Please try again later</p>
                    </div>
                `;
            });
    }

    // Render Application Detail
    function renderApplicationDetail(app) {
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
        
        document.getElementById('applicationDetailBody').innerHTML = html;
    }
</script>
@endsection
