@php
    $hasChildren = $industry->children && $industry->children->count() > 0;
    $isSelected = $selectedIndustryId == $industry->id;
    $accordionId = 'industry-' . $industry->id;
    $collapseId = 'collapse-' . $industry->id;
    $levelClass = 'level-' . $level;
    $candidateCount = $candidateCounts[$industry->id] ?? 0;
@endphp

<div class="accordion-item {{ $levelClass }}">
    @if($hasChildren)
        <div class="accordion-header" id="{{ $accordionId }}">
            <button class="accordion-button collapsed {{ $isSelected ? 'selected' : '' }}" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#{{ $collapseId }}" 
                    aria-expanded="false" 
                    aria-controls="{{ $collapseId }}">
                <span class="accordion-header-content w-100 d-flex align-items-center">
                    <span class="industry-content">
                        <span class="toggle-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </span>
                        <span class="industry-name">{{ $industry->industry_name }}</span>
                        @if($candidateCount > 0)
                            <span class="badge bg-info text-dark ms-2 d-inline-flex align-items-center" title="{{ $candidateCount }} candidate(s) registered">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                                {{ $candidateCount }}
                            </span>
                        @endif
                    </span>
                    <span class="select-btn select-industry-btn btn {{ $isSelected ? 'btn-success selected' : 'btn-outline-primary' }} ms-3" 
                          data-industry-id="{{ $industry->id }}" 
                          data-industry-name="{{ $industry->industry_name }}">
                        {{ $isSelected ? 'Selected' : 'Select' }}
                    </span>
                </span>
            </button>
        </div>
        <div id="{{ $collapseId }}" 
             class="accordion-collapse collapse" 
             aria-labelledby="{{ $accordionId }}">
            <div class="accordion-body">
                <div class="nested-industries">
                    @foreach($industry->children as $childIndustry)
                        @include('users.registration.partials.industry-item', [
                            'industry' => $childIndustry,
                            'level' => $level + 1,
                            'selectedIndustryId' => $selectedIndustryId,
                            'candidateCounts' => $candidateCounts
                        ])
                    @endforeach
                </div>
            </div>
        </div>
    @else
        {{-- Industry without children - simple selectable item --}}
        <div class="no-children {{ $isSelected ? 'selected' : '' }}">
            <span class="industry-name">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot text-muted me-2" viewBox="0 0 16 16">
                    <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                </svg>
                {{ $industry->industry_name }}
                @if($candidateCount > 0)
                    <span class="badge bg-info text-dark ms-2 d-inline-flex align-items-center" title="{{ $candidateCount }} candidate(s) registered">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                        </svg>
                        {{ $candidateCount }}
                    </span>
                @endif
            </span>
            <button type="button" 
                    class="select-industry-btn btn {{ $isSelected ? 'btn-success selected' : 'btn-outline-primary' }} btn-sm" 
                    data-industry-id="{{ $industry->id }}" 
                    data-industry-name="{{ $industry->industry_name }}">
                {{ $isSelected ? 'Selected' : 'Select' }}
            </button>
        </div>
    @endif
</div>