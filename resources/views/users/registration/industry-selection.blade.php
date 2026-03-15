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
                    
                    <div class="industry-accordion" id="industryAccordion">
                        @foreach($parentIndustries as $parentIndustry)
                            @include('users.registration.partials.industry-item', [
                                'industry' => $parentIndustry,
                                'level' => 0,
                                'selectedIndustryId' => $selectedIndustryId,
                                'candidateCounts' => $candidateCounts
                            ])
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
        .industry-accordion .accordion-item {
            border: 1px solid #e9ecef;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
            overflow: hidden;
        }

        .industry-accordion .accordion-header {
            padding: 0;
            background-color: #f8f9fa;
        }

        .industry-accordion .accordion-button {
            width: 100%;
            text-align: left;
            padding: 1rem;
            background-color: transparent;
            border: none;
            font-weight: 500;
            color: #212529;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .industry-accordion .accordion-button:hover {
            background-color: #e9ecef;
        }

        .industry-accordion .accordion-button:focus {
            outline: none;
            box-shadow: none;
        }

        .industry-accordion .accordion-button .industry-content {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .industry-accordion .accordion-button .industry-name {
            flex: 1;
        }

        .industry-accordion .accordion-button .toggle-icon {
            transition: transform 0.2s ease;
            margin-left: 0.5rem;
        }

        .industry-accordion .accordion-button.collapsed .toggle-icon {
            transform: rotate(-90deg);
        }

        .industry-accordion .accordion-button .select-btn {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }

        .industry-accordion .accordion-collapse {
            background-color: #ffffff;
        }

        .industry-accordion .accordion-body {
            padding: 0.5rem 1rem 1rem;
        }

        .industry-accordion .nested-industries {
            margin-left: 1.5rem;
        }

        .industry-accordion .nested-industries .accordion-item {
            border-left: 3px solid #0d6efd;
        }

        .industry-accordion .level-1 .accordion-item {
            border-left-color: #0d6efd;
        }

        .industry-accordion .level-2 .accordion-item {
            border-left-color: #6610f2;
        }

        .industry-accordion .level-3 .accordion-item {
            border-left-color: #20c997;
        }

        .industry-accordion .accordion-button.selected {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .industry-accordion .accordion-button.selected .industry-name {
            font-weight: 600;
        }

        .industry-accordion .select-btn.selected {
            background-color: #198754;
            border-color: #198754;
        }

        /* No children indicator */
        .industry-accordion .no-children {
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .industry-accordion .no-children:hover {
            background-color: #e9ecef;
        }

        /* Candidate count badge styling */
        .industry-accordion .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
            font-weight: 600;
        }

        .industry-accordion .badge svg {
            margin-right: 0.25rem;
        }

        .industry-accordion .accordion-button .badge {
            flex-shrink: 0;
        }

        .industry-accordion .no-children .badge {
            margin-left: 0.5rem;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle select button clicks (both accordion headers and leaf industries)
            $(document).on('click', '.select-industry-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var industryId = $(this).data('industry-id');
                var industryName = $(this).data('industry-name');
                
                selectIndustry(industryId, industryName);
                
                // Add selected class to this button
                $(this).removeClass('btn-outline-primary').addClass('btn-success selected').text('Selected');
                
                // Add selected class to parent container (accordion-button or no-children)
                $(this).closest('.accordion-button').addClass('selected');
                $(this).closest('.no-children').addClass('selected');
            });

            // Toggle accordion on header click (except when clicking select button)
            $(document).on('click', '.accordion-button', function(e) {
                // Don't toggle if clicking the select button
                if ($(e.target).closest('.select-industry-btn').length) {
                    return;
                }
                
                var target = $(this).data('bs-target');
                
                if (target) {
                    // Toggle the collapsed class manually
                    $(this).toggleClass('collapsed');
                    
                    // Toggle the collapse element
                    $(target).collapse('toggle');
                }
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

            // Auto-expand to show selected industry on page load
            @if($selectedIndustryId)
                (function() {
                    var selectedButton = $('.select-industry-btn[data-industry-id="{{ $selectedIndustryId }}"]');
                    if (selectedButton.length) {
                        // Expand all parent accordions
                        selectedButton.closest('.accordion-collapse').each(function() {
                            var $collapse = $(this);
                            $collapse.collapse('show');
                            $collapse.siblings('.accordion-header').find('.accordion-button').removeClass('collapsed');
                        });
                    }
                })();
            @endif
        });

        // Helper function to select an industry
        function selectIndustry(industryId, industryName) {
            // Update hidden input
            $('#selected_industry_id').val(industryId);
            
            // Update displayed name
            $('#selectedIndustryName').text(industryName);
            
            // Enable save button
            $('#saveBtn').prop('disabled', false);
            
            // Remove selected class from all buttons and containers
            $('.accordion-button').removeClass('selected');
            $('.select-industry-btn').removeClass('selected btn-success').addClass('btn-outline-primary').text('Select');
            $('.no-children').removeClass('selected');
        }
    </script>
@endsection
