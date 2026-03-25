@extends('layouts.app')

@section('content')
    <section class="login-content container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Select Industry</h4>
                <p class="text-muted">Please select the industry that best describes your company</p>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employer.save_industry') }}" method="POST" id="industryForm">
                    @csrf
                    <input type="hidden" name="industry_id" id="selected_industry_id" value="{{ $selectedIndustryId }}">
                    
                    <div class="industry-list">
                        @foreach($parentIndustries as $industry)
                            @php
                                $isSelected = $selectedIndustryId == $industry->id;
                                $candidateCount = $candidateCounts[$industry->id] ?? 0;
                            @endphp
                            <div class="industry-item {{ $isSelected ? 'selected' : '' }}" data-industry-id="{{ $industry->id }}">
                                <div class="d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="industry-name fw-medium">{{ $industry->industry_name }}</span>
                                        @if($candidateCount > 0)
                                            <span class="badge bg-info text-dark ms-2 d-inline-flex align-items-center" title="{{ $candidateCount }} candidate(s) registered">
                                                <i class="fas fa-users me-1" style="font-size: 10px;"></i>
                                                {{ $candidateCount }}
                                            </span>
                                        @endif
                                    </div>
                                    <button type="button" 
                                            class="select-industry-btn btn {{ $isSelected ? 'btn-success' : 'btn-outline-primary' }} btn-sm" 
                                            data-industry-id="{{ $industry->id }}" 
                                            data-industry-name="{{ $industry->industry_name }}">
                                        {{ $isSelected ? 'Selected' : 'Select' }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($parentIndustries->isEmpty())
                        <div class="alert alert-info">
                            No industries available. Please contact the administrator.
                        </div>
                    @endif

                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('employer.company_profile') }}" class="btn btn-secondary">Back to Profile</a>
                        <button type="submit" class="btn btn-primary" id="saveBtn" {{ $selectedIndustryId ? '' : 'disabled' }}>
                            Save Industry
                        </button>
                    </div>
                </form>

                <div class="mt-3">
                    <p class="text-muted">
                        Selected Industry: <span id="selectedIndustryName" class="fw-bold text-primary">
                            {{ $selectedIndustryId ? \App\Models\Industry::find($selectedIndustryId)->industry_name ?? 'None' : 'None' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .industry-list {
            max-height: 500px;
            overflow-y: auto;
        }

        .industry-item {
            transition: all 0.2s ease;
        }

        .industry-item:hover {
            background-color: #f8f9fa;
        }

        .industry-item.selected {
            background-color: #d1e7dd;
            border-color: #198754 !important;
        }

        .industry-item.selected .industry-name {
            color: #0f5132;
            font-weight: 600;
        }

        .industry-item .border {
            border-color: #e9ecef !important;
        }

        .industry-item.selected .border {
            border-color: #198754 !important;
            background-color: #d1e7dd;
        }

        /* Candidate count badge styling */
        .industry-item .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
            font-weight: 600;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle select button clicks
            $(document).on('click', '.select-industry-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var industryId = $(this).data('industry-id');
                var industryName = $(this).data('industry-name');
                
                selectIndustry(industryId, industryName);
                
                // Update all buttons and items
                $('.select-industry-btn').removeClass('btn-success').addClass('btn-outline-primary').text('Select');
                $('.industry-item').removeClass('selected');
                
                // Add selected class to this button and its parent item
                $(this).removeClass('btn-outline-primary').addClass('btn-success').text('Selected');
                $(this).closest('.industry-item').addClass('selected');
            });

            // Form submission validation
            $('#industryForm').on('submit', function(e) {
                var selectedId = $('#selected_industry_id').val();
                if (!selectedId) {
                    e.preventDefault();
                    alert('Please select an industry before saving.');
                    return false;
                }
            });
        });

        // Helper function to select an industry
        function selectIndustry(industryId, industryName) {
            // Update hidden input
            $('#selected_industry_id').val(industryId);
            
            // Update displayed name
            $('#selectedIndustryName').text(industryName);
            
            // Enable save button
            $('#saveBtn').prop('disabled', false);
        }
    </script>
@endsection
