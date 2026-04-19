@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .candidate-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }
        .candidate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
        .candidate-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            filter: blur(5px);
            transition: filter 0.3s ease;
        }
        .candidate-photo:hover {
            filter: blur(3px);
        }
        .blurred-text {
            filter: blur(4px);
            user-select: none;
            transition: filter 0.3s ease;
        }
        .blurred-text:hover {
            filter: blur(2px);
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
        .candidate-detail-item {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .modal-candidate-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            filter: blur(8px);
        }
        .modal-candidate-photo-unlocked {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            filter: none;
        }
        
        /* PDF Page Break Styles */
        @media print {
            .card {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }
            .card-header {
                break-after: avoid !important;
                page-break-after: avoid !important;
            }
            .card-body {
                break-before: avoid !important;
                page-break-before: avoid !important;
            }
            .table {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }
            tr {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }
            .row {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }
            h4, h5, h6 {
                break-after: avoid !important;
                page-break-after: avoid !important;
            }
        }
        
        /* PDF-specific class for better page breaks */
        .pdf-section {
            break-inside: avoid;
            page-break-inside: avoid;
            margin-bottom: 20px;
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
                            <i class="fas fa-search text-primary me-2"></i>Find Talent
                        </h3>
                        <p class="text-muted mt-2 mb-0">Discover candidates matching your industry</p>
                    </div>
                    <a href="{{ route('employer.dashboard') }}" class="btn btn-outline-secondary">
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
                <i class="fas fa-users fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">{{ $candidates->total() }}</h4>
                <small class="opacity-75">Total Candidates</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 text-center" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border-radius: 12px;">
                <i class="fas fa-briefcase fa-2x mb-2 opacity-75"></i>
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
                <i class="fas fa-star fa-2x mb-2 opacity-75"></i>
                <h4 class="mb-0">Verified</h4>
                <small class="opacity-75">Candidates</small>
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
                <form method="GET" action="{{ route('employer.find-talent') }}">
                    <!-- Industry Filter - Read Only (Employer's Registered Industry) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Industry Category</label>
                        @if($userIndustryName)
                            <div class="form-control bg-light d-flex align-items-center justify-content-between" style="cursor: not-allowed;">
                                <span><i class="fas fa-building text-primary me-2"></i>{{ $userIndustryName }}</span>
                                <span class="badge bg-success">Registered</span>
                            </div>
                            <small class="text-muted">Your registered industry category</small>
                            <input type="hidden" name="industry_id" value="{{ $userIndustryId }}">
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>No industry selected. Please update your company profile.
                            </div>
                        @endif
                    </div>
                    
                    <!-- Sub-Industry Filter (Optional) -->
                    @if(count($availableIndustries) > 1)
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sub-Industry <small class="text-muted">(Optional)</small></label>
                        <select name="sub_industry_id" class="form-select">
                            <option value="">All Sub-Industries</option>
                            @foreach($availableIndustries as $industry)
                                @if($industry['id'] != $userIndustryId)
                                    <option value="{{ $industry['id'] }}" {{ request('sub_industry_id') == $industry['id'] ? 'selected' : '' }}>
                                        {{ $industry['name'] }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <small class="text-muted">Filter by specific sub-industry</small>
                    </div>
                    @endif

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

                    <!-- Experience Filter -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Experience (Years)</label>
                        <select name="experience_years" class="form-select">
                            <option value="">Any Experience</option>
                            <option value="0" {{ request('experience_years') == '0' ? 'selected' : '' }}>Fresher (0 years)</option>
                            <option value="1" {{ request('experience_years') == '1' ? 'selected' : '' }}>1+ Years</option>
                            <option value="3" {{ request('experience_years') == '3' ? 'selected' : '' }}>3+ Years</option>
                            <option value="5" {{ request('experience_years') == '5' ? 'selected' : '' }}>5+ Years</option>
                            <option value="10" {{ request('experience_years') == '10' ? 'selected' : '' }}>10+ Years</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Name or email..." value="{{ request('search') }}">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Apply Filters
                        </button>
                        <a href="{{ route('employer.find-talent') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Candidates Grid -->
        <div class="col-lg-9">
            @if($candidates->count() > 0)
                <div class="row">
                    @foreach($candidates as $candidate)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card candidate-card shadow-sm h-100 border-0">
                            <div class="card-body text-center p-4">
                                <!-- Blurred Photo -->
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="{{ $candidate->image_path ?? asset('assets/images/default-avatar.png') }}" 
                                         alt="Candidate" 
                                         class="candidate-photo shadow-sm"
                                         onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <i class="fas fa-lock text-white fa-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></i>
                                    </div>
                                </div>

                                <!-- Name -->
                                <h5 class="card-title fw-bold mb-2">{{ $candidate->full_name }}</h5>
                                
                                <!-- Blurred Email -->
                                <p class="text-muted mb-1 blurred-text small">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ substr($candidate->email, 0, 3) . '****' . substr($candidate->email, strpos($candidate->email, '@')) }}
                                </p>

                                <!-- Blurred Phone -->
                                <p class="text-muted mb-3 blurred-text small">
                                    <i class="fas fa-phone me-1"></i>
                                    {{ substr($candidate->mobile, 0, 3) . '****' . substr($candidate->mobile, -2) }}
                                </p>

                                <!-- Qualifications -->
                                @if($candidate->candidateQualifications->count() > 0)
                                    <div class="mb-2">
                                        @foreach($candidate->candidateQualifications->take(2) as $qual)
                                            <span class="badge bg-info text-dark me-1">{{ $qual->qualification->degree ?? 'N/A' }}</span>
                                        @endforeach
                                        @if($candidate->candidateQualifications->count() > 2)
                                            <span class="badge bg-secondary">+{{ $candidate->candidateQualifications->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Industries -->
                                @if($candidate->candidateExperiences->count() > 0)
                                    <div class="mb-3">
                                        @foreach($candidate->candidateExperiences->take(1) as $exp)
                                            <span class="badge bg-primary">
                                                <i class="fas fa-industry me-1"></i>{{ $exp->industry->industry_name ?? 'N/A' }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Blurred Address -->
                                <p class="text-muted small blurred-text mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i>Location Hidden
                                </p>

                                <button class="btn btn-primary w-100" onclick="viewCandidate({{ $candidate->id }})">
                                    <i class="fas fa-eye me-2"></i>View Profile
                                </button>
                            </div>
                            <div class="card-footer bg-light border-0 text-center py-2">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>Joined {{ $candidate->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $candidates->appends(request()->except('page'))->links() }}
                </div>
            @else
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Candidates Found</h4>
                        <p class="text-muted">Try adjusting your filters or check back later</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Candidate Profile Modal -->
<div class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title text-white" id="candidateModalLabel">
                    <i class="fas fa-user-circle me-2"></i>Candidate Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="candidateModalBody">
                <!-- Content loaded via AJAX -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading candidate profile...</p>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4" id="candidateModalFooter">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <h5 class="modal-title text-white" id="paymentModalLabel">
                    <i class="fas fa-lock-open me-2"></i>Unlock Candidate Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="" id="paymentCandidatePhoto" alt="Candidate" class="rounded-circle shadow" style="width: 80px; height: 80px; object-fit: cover; filter: blur(5px);">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-lock text-white fa-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></i>
                        </div>
                    </div>
                    <h5 id="paymentCandidateName" class="fw-bold">Candidate Name</h5>
                    <p class="text-muted small">View complete contact details</p>
                </div>
                
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Profile Unlock Fee</span>
                            <span class="fw-bold">₹10.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>GST (18%)</span>
                            <span>₹0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Amount</span>
                            <span class="fw-bold text-success fs-5">₹10.00</span>
                        </div>
                    </div>
                </div>
                
                <div id="paymentOptions">
                    <p class="text-muted small mb-3">Click below to proceed with payment:</p>
                    
                    <!-- Payment Button - Automatically handles test/production mode -->
                    <button type="button" id="payNowBtn" class="btn btn-success w-100 mb-2 d-flex align-items-center justify-content-center" onclick="processPayment()">
                        <i class="fas fa-lock-open me-2"></i>Pay Now - ₹10.00
                    </button>
                    
                    <p class="text-muted small text-center mb-0">
                        <i class="fas fa-shield-alt me-1"></i>Secure payment powered by Paytm
                    </p>
                </div>
                
                <!-- Test Payment Options (Only shown in test mode) -->
                <div id="testPaymentOptions" style="display: none;">
                    <div class="alert alert-info">
                        <i class="fas fa-vial me-2"></i>Test Mode - Select payment result:
                    </div>
                    <button type="button" class="btn btn-success w-100 mb-2" onclick="processTestPaymentDirect('success')">
                        <i class="fas fa-check me-2"></i>Simulate Successful Payment
                    </button>
                    <button type="button" class="btn btn-danger w-100 mb-2" onclick="processTestPaymentDirect('failure')">
                        <i class="fas fa-times me-2"></i>Simulate Failed Payment
                    </button>
                </div>
                
                <!-- Loading State -->
                <div id="paymentProcessing" style="display: none;">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                        <p class="text-muted">Processing your payment...</p>
                        <p class="small text-muted">Please do not close this window</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form for Paytm Submission -->
<form id="paytmForm" method="POST" action="" style="display: none;">
    <!-- Will be populated dynamically -->
</form>
@endsection

@section('scripts')
<script>
    let currentCandidateId = null;
    let currentCandidateData = null;
    let currentOrderId = null;

    function viewCandidate(candidateId) {
        currentCandidateId = candidateId;
        var modal = new bootstrap.Modal(document.getElementById('candidateModal'));
        modal.show();
        
        // Reset modal body and footer
        document.getElementById('candidateModalBody').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading candidate profile...</p>
            </div>
        `;
        document.getElementById('candidateModalFooter').innerHTML = `
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                <i class="fas fa-times me-2"></i>Close
            </button>
        `;
        
        // Fetch candidate details
        fetch(`/employer/candidate/${candidateId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                currentCandidateData = data;
                renderCandidateProfile(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('candidateModalBody').innerHTML = `
                    <div class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <h5>Failed to load candidate profile</h5>
                        <p class="text-muted">Please try again later</p>
                    </div>
                `;
            });
    }

    function renderCandidateProfile(data) {
        const candidate = data.candidate;
        const hasPaid = data.has_paid;
        const viewPrice = data.view_price;
        const basicDetails = candidate.basic_details || {};
        const qualifications = candidate.candidate_qualifications || [];
        const experiences = candidate.candidate_experiences || [];
        const skills = candidate.candidate_skills || [];
        const addresses = candidate.addresses || [];
        const bgAnswers = candidate.background_question_answers || [];
        const backgroundQuestions = data.background_questions || {};
        
        // Determine what to show based on payment status
        let photoClass = hasPaid ? 'modal-candidate-photo-unlocked' : 'modal-candidate-photo';
        let photoOverlay = hasPaid ? '' : `
            <div class="position-absolute top-50 start-50 translate-middle">
                <i class="fas fa-lock text-white fa-2x" style="text-shadow: 0 2px 8px rgba(0,0,0,0.7);"></i>
            </div>
        `;
        
        // Helper function to mask or show data
        const getValue = (value, mask = '****') => hasPaid ? (value || 'N/A') : mask;
        
        // Format date of birth
        const dob = basicDetails.dob ? new Date(basicDetails.dob).toLocaleDateString('en-IN', {
            day: '2-digit', month: 'long', year: 'numeric'
        }) : null;
        
        // Gender display
        const gender = basicDetails.gender ? basicDetails.gender.charAt(0).toUpperCase() + basicDetails.gender.slice(1) : null;
        
        // Marital status
        // const maritalStatus = basicDetails.marital_status ? 
        //     basicDetails.marital_status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : null;
        
        // Build addresses sections (Present and Permanent)
        let presentAddressHtml = '';
        let permanentAddressHtml = '';
        
        const presentAddr = addresses.find(a => a.type === 'present_address') || {};
        const permanentAddr = addresses.find(a => a.type === 'permenant_address') || {};
        
        // Present Address
        if (hasPaid && (presentAddr.address_1 || presentAddr.city)) {
            presentAddressHtml = `
                <div class="card border-0 bg-light mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-home me-2"></i>Present Address</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-map-marker-alt text-muted me-2"></i>
                                ${presentAddr.address_1 || ''}${presentAddr.address_2 ? ', ' + presentAddr.address_2 : ''}, 
                                ${presentAddr.city || ''}, ${presentAddr.state || ''}, 
                                ${presentAddr.country || ''} - ${presentAddr.zip || ''}
                            </li>
                            ${presentAddr.police_station ? `<li class="mb-2"><i class="fas fa-shield-alt text-muted me-2"></i>Police Station: ${presentAddr.police_station}</li>` : ''}
                            ${presentAddr.panchayat_municipality ? `<li class="mb-2"><i class="fas fa-building text-muted me-2"></i>Panchayat/Municipality: ${presentAddr.panchayat_municipality}</li>` : ''}
                        </ul>
                    </div>
                </div>
            `;
        } else {
            presentAddressHtml = hasPaid ? '<p class="text-muted">No present address available</p>' : 
                `<div class="card border-0 bg-light mb-3 blurred-text">
                    <div class="card-body">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-lock me-2"></i>Present Address</h6>
                        <p class="mb-0">****</p>
                    </div>
                </div>`;
        }
        
        // Permanent Address
        if (hasPaid && (permanentAddr.address_1 || permanentAddr.city)) {
            permanentAddressHtml = `
                <div class="card border-0 bg-light mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold text-info mb-3"><i class="fas fa-home me-2"></i>Permanent Address</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-map-marker-alt text-muted me-2"></i>
                                ${permanentAddr.address_1 || ''}${permanentAddr.address_2 ? ', ' + permanentAddr.address_2 : ''}, 
                                ${permanentAddr.city || ''}, ${permanentAddr.state || ''}, 
                                ${permanentAddr.country || ''} - ${permanentAddr.zip || ''}
                            </li>
                            ${permanentAddr.police_station ? `<li class="mb-2"><i class="fas fa-shield-alt text-muted me-2"></i>Police Station: ${permanentAddr.police_station}</li>` : ''}
                            ${permanentAddr.panchayat_municipality ? `<li class="mb-2"><i class="fas fa-building text-muted me-2"></i>Panchayat/Municipality: ${permanentAddr.panchayat_municipality}</li>` : ''}
                        </ul>
                    </div>
                </div>
            `;
        } else {
            permanentAddressHtml = hasPaid ? '<p class="text-muted">No permanent address available</p>' : 
                `<div class="card border-0 bg-light mb-3 blurred-text">
                    <div class="card-body">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-lock me-2"></i>Permanent Address</h6>
                        <p class="mb-0">****</p>
                    </div>
                </div>`;
        }
        
        // Build qualifications table
        let qualificationsHtml = '';
        if (qualifications.length > 0) {
            const qualRows = qualifications.map(q => `
                <tr>
                    <td>${q.qualification?.degree || 'N/A'}</td>
                    <td>${hasPaid ? (q.university || '-') : '****'}</td>
                    <td>${hasPaid ? (q.from_year || '-') : '****'} - ${hasPaid ? (q.to_year || '-') : '****'}</td>
                    <td>${hasPaid ? (q.percentage ? q.percentage + '%' : '-') : '****'}</td>
                </tr>
            `).join('');
            
            qualificationsHtml = `
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Qualification</th>
                                <th>University</th>
                                <th>Duration</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${qualRows}
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            qualificationsHtml = '<p class="text-muted">No qualifications listed</p>';
        }
        
        // Build experience table
        let experiencesHtml = '';
        if (experiences.length > 0) {
            const expRows = experiences.map(e => {
                // Parse role_ids JSON if it's a string
                let roles = [];
                if (e.role_ids) {
                    try {
                        roles = typeof e.role_ids === 'string' ? JSON.parse(e.role_ids) : e.role_ids;
                    } catch (err) {
                        roles = [];
                    }
                }
                
                // Format roles display
                const rolesDisplay = Array.isArray(roles) && roles.length > 0 
                    ? roles.join(', ') 
                    : '-';
                
                return `
                <tr>
                    <td>${e.industry?.industry_name || 'N/A'}</td>
                    <td>${hasPaid ? rolesDisplay : '****'}</td>
                    <td>${hasPaid ? (e.company || '-') : '****'}</td>
                    <td>${hasPaid ? (e.from_year || '-') : '****'} - ${hasPaid ? (e.to_year || '-') : '****'}</td>
                    <td>${hasPaid ? (e.duration || '-') : '****'}</td>
                </tr>
                `;
            }).join('');
            
            experiencesHtml = `
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Industry</th>
                                <th>Roles</th>
                                <th>Company</th>
                                <th>Duration (Years)</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${expRows}
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            experiencesHtml = '<p class="text-muted">No experience listed</p>';
        }
        
        // Skills table display
        let skillsHtml = '';
        if (skills.length > 0) {
            const skillRows = skills.map(s => `
                <tr>
                    <td>${s.skill?.skill || 'N/A'}</td>
                    <td>${hasPaid ? (s.university || '-') : '****'}</td>
                    <td>${hasPaid ? (s.from_year || '-') : '****'} - ${hasPaid ? (s.to_year || '-') : '****'}</td>
                    <td>${hasPaid ? (s.percentage ? s.percentage + '%' : '-') : '****'}</td>
                </tr>
            `).join('');
            
            skillsHtml = `
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Skill</th>
                                <th>University/Institution</th>
                                <th>Duration</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${skillRows}
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            skillsHtml = '<p class="text-muted">No skills listed</p>';
        }
        
        // Background questions table
        let bgAnswersHtml = '';
        if (bgAnswers.length > 0) {
            // Parse answers JSON if it's a string
            let answers = {};
            if (bgAnswers[0].answers) {
                try {
                    answers = typeof bgAnswers[0].answers === 'string' ? JSON.parse(bgAnswers[0].answers) : bgAnswers[0].answers;
                } catch (err) {
                    answers = {};
                }
            }
            
            // The answers object has question IDs (numeric) as keys
            // backgroundQuestions contains the mapping of question ID to question text
            const bgRows = Object.entries(answers).map(([questionId, answer]) => {
                // Get the actual question text from backgroundQuestions, fallback to "Question #{id}" if not found
                const questionText = backgroundQuestions[questionId] || `Question #${questionId}`;
                
                return `
                <tr>
                    <td class="fw-semibold" style="width: 40%">${questionText}</td>
                    <td>${hasPaid ? (answer || '-') : '****'}</td>
                </tr>
                `;
            }).join('');
            
            if (bgRows) {
                bgAnswersHtml = `
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tbody>
                                ${bgRows}
                            </tbody>
                        </table>
                    </div>
                `;
            }
        }
        
        // Extract all basic details
        const altMobile = basicDetails.alternate_mobile_number;
        const whatsappNumber = basicDetails.whatsapp_number;
        const altEmail = basicDetails.alternate_email_id;
        const aadhar = basicDetails.aadhar_number;
        const pan = basicDetails.pan_number;
        const passport = basicDetails.passport_number;
        const profession = basicDetails.profession;
        const experience = basicDetails.experience;
        const jobType = basicDetails.Job_type;
        const differentlyAbled = basicDetails.differently_abled;
        
        // Contact Information Section
        const contactInfo = hasPaid ? `
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-address-card me-2"></i>Contact Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-envelope me-2"></i>Email</small>
                            <p class="mb-0 fw-semibold">${candidate.email}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-phone me-2"></i>Phone</small>
                            <p class="mb-0 fw-semibold">${candidate.mobile}</p>
                        </div>
                        ${altEmail ? `
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-envelope-open me-2"></i>Alternate Email</small>
                            <p class="mb-0 fw-semibold">${altEmail}</p>
                        </div>` : ''}
                        ${altMobile ? `
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-mobile-alt me-2"></i>Alternate Mobile</small>
                            <p class="mb-0 fw-semibold">${altMobile}</p>
                        </div>` : ''}
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fab fa-whatsapp me-2"></i>WhatsApp</small>
                            <p class="mb-0 fw-semibold">
                                <a href="https://wa.me/${(whatsappNumber || candidate.mobile)?.replace(/\D/g, '')}" target="_blank" class="text-success">
                                    ${whatsappNumber || candidate.mobile} <i class="fas fa-external-link-alt small"></i>
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Date of Birth</small>
                            <p class="mb-0 fw-semibold">${dob || 'Not provided'}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-venus-mars me-2"></i>Gender</small>
                            <p class="mb-0 fw-semibold">${gender || 'Not provided'}</p>
                        </div>
                        ${profession ? `
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-briefcase me-2"></i>Profession</small>
                            <p class="mb-0 fw-semibold">${profession}</p>
                        </div>` : ''}
                    </div>
                </div>
            </div>
            
            <!-- Additional Personal Details -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-id-card me-2"></i>Personal & Professional Details
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-user-graduate me-2"></i>Experience Level</small>
                            <p class="mb-0 fw-semibold">${experience || 'Not specified'}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-clock me-2"></i>Job Type</small>
                            <p class="mb-0 fw-semibold">${jobType || 'Not specified'}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-wheelchair me-2"></i>Differently Abled</small>
                            <p class="mb-0 fw-semibold">${differentlyAbled || 'No'}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Identity Documents -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-passport me-2"></i>Identity Documents
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-id-badge me-2"></i>Aadhar Number</small>
                            <p class="mb-0 fw-semibold">${aadhar || 'Not provided'}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-credit-card me-2"></i>PAN Number</small>
                            <p class="mb-0 fw-semibold">${pan || 'Not provided'}</p>
                        </div>
                        ${passport ? `
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-plane me-2"></i>Passport Number</small>
                            <p class="mb-0 fw-semibold">${passport}</p>
                        </div>` : ''}
                    </div>
                </div>
            </div>
        ` : `
            <div class="card border-0 shadow-sm mb-3 blurred-text">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-lock me-2"></i>Contact Information (Locked)
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-envelope me-2"></i>Email</small>
                            <p class="mb-0 fw-semibold">****@****.com</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-phone me-2"></i>Phone</small>
                            <p class="mb-0 fw-semibold">+91 **** **** **</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fab fa-whatsapp me-2"></i>WhatsApp</small>
                            <p class="mb-0 fw-semibold">+91 **** **** **</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Date of Birth</small>
                            <p class="mb-0 fw-semibold">****</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-venus-mars me-2"></i>Gender</small>
                            <p class="mb-0 fw-semibold">****</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted"><i class="fas fa-id-badge me-2"></i>Aadhar Number</small>
                            <p class="mb-0 fw-semibold">****</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Update footer based on payment status
        if (hasPaid) {
            document.getElementById('candidateModalFooter').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-info" style="border-radius: 8px;" onclick="printCandidateProfile()">
                    <i class="fas fa-print me-2"></i>Print Profile
                </button>
                <a href="https://wa.me/${candidate.mobile?.replace(/\D/g, '')}" target="_blank" class="btn btn-success" style="border-radius: 8px;">
                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                </a>
                <a href="mailto:${candidate.email}" class="btn btn-primary" style="border-radius: 8px;">
                    <i class="fas fa-envelope me-2"></i>Send Email
                </a>
            `;
        } else {
            document.getElementById('candidateModalFooter').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-success" style="border-radius: 8px;" onclick="openPaymentModal()">
                    <i class="fas fa-unlock me-2"></i>Unlock for ₹${viewPrice}
                </button>
            `;
        }
        
        // Build the modal HTML (original full layout for display)
        const modalHtml = `
            <div class="row">
                <!-- Left Column - Profile Photo & Quick Info -->
                <div class="col-md-3 text-center mb-4">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="${candidate.image_path || '/assets/images/default-avatar.png'}" 
                             alt="Candidate" 
                             class="${photoClass} shadow"
                             onerror="this.src='/assets/images/default-avatar.png'; this.onerror=null;">
                        ${photoOverlay}
                    </div>
                    <h4 class="fw-bold mb-2">${candidate.full_name}</h4>
                    <span class="badge bg-success mb-2"><i class="fas fa-check-circle me-1"></i>Verified</span>
                    ${hasPaid ? `
                    <div class="mt-3">
                        <a href="tel:${candidate.mobile}" class="btn btn-sm btn-outline-primary w-100 mb-2">
                            <i class="fas fa-phone me-2"></i>Call Now
                        </a>
                        <a href="https://wa.me/${candidate.mobile?.replace(/\D/g, '')}" target="_blank" class="btn btn-sm btn-outline-success w-100">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                    ` : ''}
                </div>
                
                <!-- Right Column - Detailed Information -->
                <div class="col-md-9">
                    <!-- About Section -->
                    ${basicDetails.about ? `
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-user me-2"></i>About
                        </div>
                        <div class="card-body">
                            <p class="mb-0">${basicDetails.about}</p>
                        </div>
                    </div>
                    ` : ''}
                    
                    <!-- Contact Information -->
                    ${contactInfo}
                    
                    <!-- Addresses -->
                    <div class="row">
                        <div class="col-md-6">
                            ${presentAddressHtml}
                        </div>
                        <div class="col-md-6">
                            ${permanentAddressHtml}
                        </div>
                    </div>
                    
                    <!-- Qualifications -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-success text-white">
                            <i class="fas fa-graduation-cap me-2"></i>Educational Qualifications
                        </div>
                        <div class="card-body p-0">
                            ${qualificationsHtml}
                        </div>
                    </div>
                    
                    <!-- Experience -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-primary text-white">
                            <i class="fas fa-briefcase me-2"></i>Work Experience
                        </div>
                        <div class="card-body p-0">
                            ${experiencesHtml}
                        </div>
                    </div>
                    
                    <!-- Skills -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-secondary text-white">
                            <i class="fas fa-tools me-2"></i>Skills
                        </div>
                        <div class="card-body">
                            ${skillsHtml}
                        </div>
                    </div>
                    
                    <!-- Background Information -->
                    ${bgAnswersHtml ? `
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-dark text-white">
                            <i class="fas fa-question-circle me-2"></i>Background Information
                        </div>
                        <div class="card-body p-0">
                            ${bgAnswersHtml}
                        </div>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
        
        // Set the modal content to the full layout
        document.getElementById('candidateModalBody').innerHTML = modalHtml;
    }

    function openPaymentModal() {
        if (!currentCandidateData) return;
        
        const candidate = currentCandidateData.candidate;
        
        // Set candidate info in payment modal
        document.getElementById('paymentCandidateName').textContent = candidate.full_name;
        document.getElementById('paymentCandidatePhoto').src = candidate.image_path || '/assets/images/default-avatar.png';
        
        // Reset payment modal state
        showPaymentOptions();
        
        // Hide candidate modal and show payment modal
        bootstrap.Modal.getInstance(document.getElementById('candidateModal')).hide();
        var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
        paymentModal.show();
    }

    function showPaymentOptions() {
        document.getElementById('paymentOptions').style.display = 'block';
        document.getElementById('testPaymentOptions').style.display = 'none';
        document.getElementById('paymentProcessing').style.display = 'none';
    }

    function showTestPaymentOptions() {
        document.getElementById('paymentOptions').style.display = 'none';
        document.getElementById('testPaymentOptions').style.display = 'block';
        document.getElementById('paymentProcessing').style.display = 'none';
    }

    function showProcessingState() {
        document.getElementById('paymentOptions').style.display = 'none';
        document.getElementById('testPaymentOptions').style.display = 'none';
        document.getElementById('paymentProcessing').style.display = 'block';
    }

    function processPayment() {
        if (!currentCandidateId) {
            alert('Candidate ID not found. Please try again.');
            return;
        }
        
        showProcessingState();
        
        // Send payment initiation request
        fetch('/employer/candidate/initiate-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ candidate_id: currentCandidateId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.already_paid) {
                // Already paid, close payment modal and refresh candidate view
                bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                viewCandidate(currentCandidateId);
                return;
            }
            
            if (data.test_mode) {
                // In test mode, show test options (success/failure buttons)
                currentOrderId = data.order_id;
                showTestPaymentOptions();
            } else if (data.success && data.paytmParams) {
                // Production mode - redirect to Paytm
                const form = document.getElementById('paytmForm');
                form.innerHTML = ''; // Clear previous inputs
                form.action = data.paytm_url;
                
                // Add all paytm params
                for (const key in data.paytmParams) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = data.paytmParams[key];
                    form.appendChild(input);
                }
                
                // Add checksum
                const checksumInput = document.createElement('input');
                checksumInput.type = 'hidden';
                checksumInput.name = 'CHECKSUMHASH';
                checksumInput.value = data.checksum;
                form.appendChild(checksumInput);
                
                // Submit form to Paytm
                form.submit();
            } else {
                alert('Failed to initiate payment. Please try again.');
                showPaymentOptions();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to initiate payment. Please try again.');
            showPaymentOptions();
        });
    }

    // Keep the old function name as an alias for backward compatibility
    function processPaytmPayment() {
        if (!currentCandidateId) {
            alert('Candidate ID not found. Please try again.');
            return;
        }
        
        showProcessingState();
        
        // Send payment initiation request
        fetch('/employer/candidate/initiate-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ candidate_id: currentCandidateId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.already_paid) {
                // Already paid, close payment modal and refresh candidate view
                bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                viewCandidate(currentCandidateId);
                return;
            }
            
            if (data.test_mode) {
                // In test mode, show test options
                currentOrderId = data.order_id;
                showTestPaymentOptions();
            } else if (data.success && data.paytmParams) {
                // Create and submit Paytm form
                const form = document.getElementById('paytmForm');
                form.innerHTML = ''; // Clear previous inputs
                form.action = data.paytm_url;
                
                // Add all paytm params
                for (const key in data.paytmParams) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = data.paytmParams[key];
                    form.appendChild(input);
                }
                
                // Add checksum
                const checksumInput = document.createElement('input');
                checksumInput.type = 'hidden';
                checksumInput.name = 'CHECKSUMHASH';
                checksumInput.value = data.checksum;
                form.appendChild(checksumInput);
                
                // Submit form
                form.submit();
            } else {
                alert('Failed to initiate payment. Please try again.');
                showPaymentOptions();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to initiate payment. Please try again.');
            showPaymentOptions();
        });
    }

    function processTestPaymentDirect(status) {
        if (!currentCandidateId) {
            alert('Candidate ID not found. Please try again.');
            return;
        }
        
        showProcessingState();
        
        // First initiate payment to get order ID
        fetch('/employer/candidate/initiate-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ candidate_id: currentCandidateId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.already_paid) {
                bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                viewCandidate(currentCandidateId);
                return;
            }
            
            if (!data.order_id) {
                throw new Error('No order ID received');
            }
            
            currentOrderId = data.order_id;
            
            // Process test payment
            return fetch('/employer/candidate/test-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order_id: currentOrderId, status: status })
            });
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Payment successful
                bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                viewCandidate(currentCandidateId);
            } else {
                alert('Payment failed: ' + (data.message || 'Unknown error'));
                showPaymentOptions();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Payment processing failed. Please try again.');
            showPaymentOptions();
        });
    }

    // Handle payment modal close - refresh candidate view
    document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
        // Remove any lingering modal backdrops
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
        
        if (currentCandidateId) {
            viewCandidate(currentCandidateId);
        }
    });
    
    // Handle candidate modal close - clean up backdrops
    document.getElementById('candidateModal').addEventListener('hidden.bs.modal', function () {
        // Remove any lingering modal backdrops
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    });

    // Print candidate profile
    function printCandidateProfile() {
        // Get modal elements
        const modal = document.getElementById('candidateModal');
        const modalDialog = modal.querySelector('.modal-dialog');
        const modalBody = document.getElementById('candidateModalBody');
        const modalFooter = document.getElementById('candidateModalFooter');
        
        // Store original styles
        const originalDialogClass = modalDialog.className;
        const originalBodyOverflow = modalBody.style.overflow;
        const originalBodyMaxHeight = modalBody.style.maxHeight;
        const originalFooterDisplay = modalFooter.style.display;
        
        // Expand modal to show all content (remove scrollable restrictions)
        modalDialog.classList.remove('modal-dialog-scrollable');
        modalBody.style.overflow = 'visible';
        modalBody.style.maxHeight = 'none';
        modalFooter.style.display = 'none';
        
        // Add print-specific styles
        const printStyles = document.createElement('style');
        printStyles.id = 'print-styles';
        printStyles.textContent = `
            @media print {
                body * {
                    visibility: hidden;
                }
                #candidateModal, #candidateModal * {
                    visibility: visible;
                }
                #candidateModal {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: auto;
                }
                .modal-dialog {
                    max-width: 100% !important;
                    margin: 0 !important;
                }
                .modal-content {
                    border: none !important;
                    box-shadow: none !important;
                }
                .modal-header, .modal-footer {
                    display: none !important;
                }
                .modal-body {
                    padding: 20px !important;
                    overflow: visible !important;
                    max-height: none !important;
                }
                .card {
                    break-inside: avoid;
                    page-break-inside: avoid;
                    margin-bottom: 15px;
                    border: 1px solid #dee2e6 !important;
                    box-shadow: none !important;
                }
                .card-header {
                    background-color: #f8f9fa !important;
                    color: #333 !important;
                    border-bottom: 1px solid #dee2e6 !important;
                }
                .table {
                    break-inside: avoid;
                    page-break-inside: avoid;
                    width: 100% !important;
                    table-layout: fixed !important;
                }
                .table td, .table th {
                    word-wrap: break-word !important;
                    white-space: normal !important;
                    overflow: visible !important;
                    vertical-align: top !important;
                }
                /* Background questions table specific styles */
                .table tbody tr td:first-child {
                    width: 40% !important;
                    max-width: 40% !important;
                }
                .table tbody tr td:last-child {
                    width: 60% !important;
                    max-width: 60% !important;
                }
                .table-responsive {
                    overflow: visible !important;
                }
                .blurred-text {
                    filter: none !important;
                }
                .btn, .badge {
                    display: none !important;
                }
                .row {
                    display: flex;
                    flex-wrap: wrap;
                }
                .col-md-3, .col-md-6, .col-md-9 {
                    flex: 0 0 auto;
                }
                .col-md-3 { width: 25%; }
                .col-md-6 { width: 50%; }
                .col-md-9 { width: 75%; }
            }
        `;
        document.head.appendChild(printStyles);
        
        // Wait a moment for layout to adjust then print
        setTimeout(() => {
            window.print();
            
            // Restore original styles after print
            setTimeout(() => {
                modalDialog.className = originalDialogClass;
                modalBody.style.overflow = originalBodyOverflow;
                modalBody.style.maxHeight = originalBodyMaxHeight;
                modalFooter.style.display = originalFooterDisplay;
                document.getElementById('print-styles').remove();
            }, 100);
        }, 100);
    }
</script>
@endsection
