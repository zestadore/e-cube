@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 50%, #1cc88a 100%);
            color: #fff;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(78, 115, 223, 0.3);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .welcome-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .profile-avatar-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        /* Stats Cards */
        .stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 4px solid;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: currentColor;
            opacity: 0.05;
            border-radius: 0 0 0 100%;
        }

        .stat-card.primary { border-left-color: #4e73df; color: #4e73df; }
        .stat-card.success { border-left-color: #1cc88a; color: #1cc88a; }
        .stat-card.info { border-left-color: #36b9cc; color: #36b9cc; }
        .stat-card.warning { border-left-color: #f6c23e; color: #f6c23e; }

        .stat-card .stat-title {
            color: #858796;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .stat-card .stat-value {
            color: #5a5c69;
            font-size: 28px;
            font-weight: 700;
        }

        .stat-card .stat-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 40px;
            opacity: 0.2;
        }

        /* Progress Card */
        .progress-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .progress-title {
            font-weight: 600;
            color: #5a5c69;
        }

        .progress-percentage {
            font-weight: 700;
            color: #1cc88a;
        }

        .progress {
            height: 10px;
            border-radius: 10px;
            background: #e3e6f0;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, #4e73df 0%, #1cc88a 100%);
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        /* Info Cards */
        .info-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .info-card-header {
            background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
            padding: 20px 25px;
            border-bottom: 2px solid #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .info-card-header i {
            font-size: 24px;
            margin-right: 12px;
            color: #4e73df;
        }

        .info-card-header h4 {
            margin: 0;
            font-weight: 600;
            color: #5a5c69;
            display: flex;
            align-items: center;
        }

        .info-card-body {
            padding: 25px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #e8f5e9;
            color: #1cc88a;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .info-icon.blue {
            background: #e3f2fd;
            color: #2196f3;
        }

        .info-icon.orange {
            background: #fff3e0;
            color: #f57c00;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 13px;
            color: #858796;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .info-value {
            color: #5a5c69;
            font-weight: 500;
        }

        /* Timeline Cards */
        .timeline-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .timeline-card-header {
            background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
            padding: 20px 25px;
            border-bottom: 2px solid #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .timeline-card-header h4 {
            margin: 0;
            font-weight: 600;
            color: #5a5c69;
        }

        .timeline-card-header h4 i {
            color: #4e73df;
            margin-right: 10px;
        }

        .timeline-card-body {
            padding: 25px;
        }

        .timeline-item {
            position: relative;
            padding-left: 30px;
            padding-bottom: 25px;
            border-left: 3px solid #e3e6f0;
        }

        .timeline-item:last-child {
            border-left: 3px solid transparent;
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -9px;
            top: 0;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #4e73df;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px #e3e6f0;
        }

        .timeline-title {
            font-weight: 600;
            color: #4e73df;
            margin-bottom: 5px;
        }

        .timeline-subtitle {
            color: #858796;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .timeline-content {
            color: #5a5c69;
            font-size: 14px;
        }

        .badge-custom {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-primary { background: #e3f2fd; color: #1976d2; }
        .badge-success { background: #e8f5e9; color: #388e3c; }
        .badge-warning { background: #fff3e0; color: #f57c00; }

        /* Subscription Alert */
        .subscription-alert {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border: 2px solid #f6c23e;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .subscription-alert i {
            font-size: 40px;
            color: #f57c00;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            color: #fff;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
            color: #fff;
        }

        /* Floating Action Buttons */
        .fab-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .fab-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            border: none;
            color: #fff;
            font-size: 20px;
        }

        .fab-btn:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        .fab-btn.primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
        .fab-btn.success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); }
        .fab-btn.info { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); }

        .fab-btn .tooltip {
            position: absolute;
            right: 70px;
            background: #5a5c69;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .fab-btn:hover .tooltip {
            opacity: 1;
            visibility: visible;
        }

        /* Skill Tags */
        .skill-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .skill-tag {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #858796;
        }

        .empty-state i {
            font-size: 60px;
            margin-bottom: 15px;
            color: #e3e6f0;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* Modal Styles */
        .modal-lg {
            max-width: 900px;
        }

        .dynamic-entry {
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: #f8f9fc;
        }
    </style>
@endsection

@section('content')
    @php
        $qualifications = \App\Models\Qualification::whereDoesntHave('parents')->get();
        $skillsList = \App\Models\ComputerAndOtherSkill::get();
        $industries = \App\Models\Industry::get();
        $hobbiesData = \App\Models\CandidateHobby::where('user_id', Auth::id())->first();
    @endphp

    @if (!empty(Auth::user()->mobile_verified_at))
        <div class="container-fluid py-4">
            <!-- Welcome Banner -->
            <div class="welcome-banner animate-fade-in">
                <div class="row align-items-center welcome-content">
                    <div class="col-md-8">
                        <h1 class="welcome-title">Welcome back, {{Auth::user()->first_name}}! 👋</h1>
                        <p class="welcome-subtitle">
                            <i class="fas fa-envelope me-2"></i>{{Auth::user()->email}} | 
                            <i class="fas fa-phone me-2"></i>{{Auth::user()->mobile}} | 
                            <i class="fas fa-briefcase me-2"></i>{{Auth::user()->basics->profession ?? 'Not specified'}}
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <img src="{{Auth::user()->image_path ?? asset('assets/images/default-avatar.png')}}" 
                             alt="Profile" 
                             class="profile-avatar-large"
                             onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">
                    </div>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card primary animate-fade-in" style="animation-delay: 0.1s;">
                        <div class="stat-title">Qualifications</div>
                        <div class="stat-value">{{Auth::user()->qualifications->count()}}</div>
                        <i class="fas fa-graduation-cap stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card success animate-fade-in" style="animation-delay: 0.2s;">
                        <div class="stat-title">Skills</div>
                        <div class="stat-value">{{Auth::user()->skills->count()}}</div>
                        <i class="fas fa-tools stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card info animate-fade-in" style="animation-delay: 0.3s;">
                        <div class="stat-title">Experience</div>
                        <div class="stat-value">{{Auth::user()->experiences->count()}}</div>
                        <i class="fas fa-briefcase stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card warning animate-fade-in" style="animation-delay: 0.4s;">
                        <div class="stat-title">Profile Status</div>
                        <div class="stat-value">{{Auth::user()->profile_completed_at ? 'Complete' : 'Pending'}}</div>
                        <i class="fas fa-user-check stat-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Subscription Alert -->
            @php
                $userValidity = Auth::user()?->validity;
                $validityDate = $userValidity ? \Carbon\Carbon::parse($userValidity) : null;
            @endphp
            @if ($validityDate === null || $validityDate->isPast())
                <div class="subscription-alert animate-fade-in">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-crown me-4"></i>
                        <div>
                            <h5 class="mb-1">Upgrade Your Plan</h5>
                            <p class="mb-0 text-muted">Subscribe to access premium features and get noticed by employers!</p>
                        </div>
                    </div>
                    <a href="{{route('subscription.packages')}}" class="btn btn-gradient">
                        <i class="fas fa-rocket me-2"></i>Explore Plans
                    </a>
                </div>
            @endif

            <!-- Profile Completion Progress -->
            @php
                $totalFields = 6;
                $filledFields = 0;
                if(Auth::user()->basics) $filledFields++;
                if(Auth::user()->presentAddress) $filledFields++;
                if(Auth::user()->permanentAddress) $filledFields++;
                if(Auth::user()->qualifications->isNotEmpty()) $filledFields++;
                if(Auth::user()->skills->isNotEmpty()) $filledFields++;
                if(Auth::user()->experiences->isNotEmpty()) $filledFields++;
                $progress = ($filledFields / $totalFields) * 100;
            @endphp
            <div class="progress-card animate-fade-in">
                <div class="progress-header">
                    <span class="progress-title"><i class="fas fa-chart-line me-2 text-primary"></i>Profile Completion</span>
                    <span class="progress-percentage">{{round($progress)}}%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{$progress}}%"></div>
                </div>
                <small class="text-muted mt-2 d-block">Complete your profile to increase your chances of getting hired!</small>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-3">
                    <!-- Basic Details Card -->
                    <div class="info-card animate-fade-in">
                        <div class="info-card-header" style="justify-content: space-between;">
                            <h4><i class="fas fa-user-circle"></i>Basic Information</h4>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('basic')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="info-card-body">
                            <div class="info-item">
                                <div class="info-icon blue"><i class="fas fa-envelope"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Email</div>
                                    <div class="info-value">{{Auth::user()->email}}</div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-phone"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Mobile</div>
                                    <div class="info-value">{{Auth::user()->mobile}}</div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon orange"><i class="fas fa-calendar"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Date of Birth</div>
                                    <div class="info-value">{{Auth::user()->basics ? Carbon::parse(Auth::user()->basics->dob)->format('d M Y') : 'Not provided'}}</div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon blue"><i class="fas fa-venus-mars"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Gender</div>
                                    <div class="info-value">{{Auth::user()->basics->gender ?? 'Not provided'}}</div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-id-card"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Aadhar</div>
                                    <div class="info-value">{{Auth::user()->basics->aadhar_number ?? 'Not provided'}}</div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon blue"><i class="fas fa-address-card"></i></div>
                                <div class="info-content">
                                    <div class="info-label">PAN</div>
                                    <div class="info-value">{{Auth::user()->basics->pan_number ?? 'Not provided'}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Present Address -->
                    <div class="info-card animate-fade-in" style="animation-delay: 0.1s;">
                        <div class="info-card-header" style="justify-content: space-between;">
                            <h4><i class="fas fa-map-marker-alt text-success"></i>Present Address</h4>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('address')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="info-card-body">
                            @if(Auth::user()->presentAddress)
                                <div class="info-item">
                                    <div class="info-icon blue"><i class="fas fa-home"></i></div>
                                    <div class="info-content">
                                        <div class="info-value">{{Auth::user()->presentAddress->address_1}}, {{Auth::user()->presentAddress->address_2}}</div>
                                        <div class="info-value">{{Auth::user()->presentAddress->city}}, {{Auth::user()->presentAddress->state}} - {{Auth::user()->presentAddress->zip}}</div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon"><i class="fas fa-shield-alt"></i></div>
                                    <div class="info-content">
                                        <div class="info-label">Police Station</div>
                                        <div class="info-value">{{Auth::user()->presentAddress->police_station}}</div>
                                    </div>
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p>No address added</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Permanent Address -->
                    <div class="info-card animate-fade-in" style="animation-delay: 0.2s;">
                        <div class="info-card-header" style="justify-content: space-between;">
                            <h4><i class="fas fa-home text-info"></i>Permanent Address</h4>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('address')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="info-card-body">
                            @if(Auth::user()->permanentAddress)
                                <div class="info-item">
                                    <div class="info-icon blue"><i class="fas fa-home"></i></div>
                                    <div class="info-content">
                                        <div class="info-value">{{Auth::user()->permanentAddress->address_1}}, {{Auth::user()->permanentAddress->address_2}}</div>
                                        <div class="info-value">{{Auth::user()->permanentAddress->city}}, {{Auth::user()->permanentAddress->state}} - {{Auth::user()->permanentAddress->zip}}</div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon"><i class="fas fa-shield-alt"></i></div>
                                    <div class="info-content">
                                        <div class="info-label">Police Station</div>
                                        <div class="info-value">{{Auth::user()->permanentAddress->police_station}}</div>
                                    </div>
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-home"></i>
                                    <p>No address added</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Center Column -->
                <div class="col-lg-6">
                    <!-- Qualifications Timeline -->
                    <div class="timeline-card animate-fade-in">
                        <div class="timeline-card-header">
                            <h4><i class="fas fa-graduation-cap"></i>Education & Qualifications</h4>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('education')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="timeline-card-body">
                            @if(Auth::user()->qualifications->isNotEmpty())
                                @foreach(Auth::user()->qualifications as $qualification)
                                    <div class="timeline-item">
                                        <div class="timeline-title">
                                            @php
                                                $qualParts = [];
                                                if($qualification->level1Qualification) $qualParts[] = $qualification->level1Qualification->degree;
                                                if($qualification->level2Qualification) $qualParts[] = $qualification->level2Qualification->degree;
                                                if($qualification->level3Qualification) $qualParts[] = $qualification->level3Qualification->degree;
                                                if($qualification->qualification) $qualParts[] = $qualification->qualification->degree;
                                                $qualDisplay = !empty($qualParts) ? implode(' -> ', $qualParts) : 'Unknown';
                                            @endphp
                                            {{$qualDisplay}}
                                        </div>
                                        <div class="timeline-subtitle">
                                            <i class="fas fa-university me-1"></i>{{$qualification->university}}
                                            <span class="mx-2">|</span>
                                            <i class="fas fa-calendar me-1"></i>{{$qualification->from_year}} - {{$qualification->to_year}}
                                        </div>
                                        <div class="timeline-content">
                                            <span class="badge-custom badge-success">{{$qualification->percentage}}%</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-graduation-cap"></i>
                                    <p>No qualifications added yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="timeline-card animate-fade-in" style="animation-delay: 0.1s;">
                        <div class="timeline-card-header">
                            <h4><i class="fas fa-tools"></i>Skills & Expertise</h4>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('skills')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="timeline-card-body">
                            @if(Auth::user()->skills->isNotEmpty())
                                @php
                                    // Group skills by job role (industry_id)
                                    $groupedSkills = Auth::user()->skills->groupBy(function($item) {
                                        return $item->skill->industry_id ?? 'unknown';
                                    });
                                @endphp
                                
                                @foreach($groupedSkills as $roleId => $skills)
                                    @php
                                        $roleName = $skills->first()->skill->industry->industry_name ?? 'Unknown Role';
                                        $proficiency = $skills->first()->proficiency;
                                    @endphp
                                    <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 fw-bold text-primary">
                                                <i class="fas fa-briefcase me-2"></i>{{ $roleName }}
                                            </h6>
                                            <span class="badge-custom badge-primary">{{ $proficiency }}</span>
                                        </div>
                                        <div class="skill-tags">
                                            @foreach($skills as $skill)
                                                <span class="skill-tag">{{ $skill->skill->skill ?? 'Unknown' }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-tools"></i>
                                    <p>No skills added yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Experience -->
                    <div class="timeline-card animate-fade-in" style="animation-delay: 0.2s;">
                        <div class="timeline-card-header">
                            <h4><i class="fas fa-briefcase"></i>Work Experience</h4>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('experience')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="timeline-card-body">
                            @if(Auth::user()->experiences->isNotEmpty())
                                @foreach(Auth::user()->experiences as $experience)
                                    <div class="timeline-item">
                                        <div class="timeline-title">{{$experience->company}}</div>
                                        <div class="timeline-subtitle">
                                            @php
                                                $industryParts = [];
                                                if($experience->industry) $industryParts[] = $experience->industry->industry_name;
                                                if($experience->industryLevel2) $industryParts[] = $experience->industryLevel2->industry_name;
                                                if($experience->industryLevel3) $industryParts[] = $experience->industryLevel3->industry_name;
                                                $industryDisplay = !empty($industryParts) ? implode(' -> ', $industryParts) : 'Unknown';
                                            @endphp
                                            <i class="fas fa-industry me-1"></i>{{$industryDisplay}}
                                            <span class="mx-2">|</span>
                                            <i class="fas fa-calendar me-1"></i>{{$experience->from_year}} - {{$experience->to_year ?? 'Present'}}
                                        </div>
                                        <div class="timeline-content">
                                            @if($experience->duration)
                                                <span class="badge-custom badge-primary me-2">{{$experience->duration}}</span>
                                            @endif
                                            @if($experience->is_current)
                                                <span class="badge-custom badge-warning">Current Job</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-briefcase"></i>
                                    <p>No work experience added yet</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-3">
                    <!-- Quick Actions -->
                    <div class="info-card animate-fade-in" style="animation-delay: 0.3s;">
                        <div class="info-card-header">
                            <i class="fas fa-bolt text-warning"></i>
                            <h4>Quick Actions</h4>
                        </div>
                        <div class="info-card-body">
                            <a href="{{route('employee.find-jobs')}}" class="btn btn-gradient w-100 mb-3">
                                <i class="fas fa-briefcase me-2"></i>Find Jobs
                            </a>
                            <button class="btn btn-outline-primary w-100 mb-3" onclick="openViewProfileModal()">
                                <i class="fas fa-eye me-2"></i>View Profile
                            </button>
                            <a href="{{route('subscription.packages')}}" class="btn btn-outline-success w-100 mb-3">
                                <i class="fas fa-crown me-2"></i>Subscription
                            </a>
                            <a href="{{route('employee.payment-history')}}" class="btn btn-outline-info w-100 mb-3">
                                <i class="fas fa-history me-2"></i>Payment History
                            </a>
                            <a href="{{route('change.password')}}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-lock me-2"></i>Change Password
                            </a>
                        </div>
                    </div>

                    <!-- Subscription Status -->
                    <div class="info-card animate-fade-in" style="animation-delay: 0.4s;">
                        <div class="info-card-header">
                            <i class="fas fa-crown text-warning"></i>
                            <h4>Subscription</h4>
                        </div>
                        <div class="info-card-body text-center">
                            @php
                                $subscriptionValidity = Auth::user()?->validity ? \Carbon\Carbon::parse(Auth::user()->validity) : null;
                            @endphp
                            @if($subscriptionValidity && !$subscriptionValidity->isPast())
                                <div class="mb-3">
                                    <i class="fas fa-check-circle text-success fa-3x"></i>
                                </div>
                                <h5 class="text-success">Active</h5>
                                <p class="text-muted">Valid until {{$subscriptionValidity->format('d M Y')}}</p>
                            @else
                                <div class="mb-3">
                                    <i class="fas fa-exclamation-circle text-warning fa-3x"></i>
                                </div>
                                <h5 class="text-warning">No Active Plan</h5>
                                <p class="text-muted">Subscribe to access premium features</p>
                                <a href="{{route('subscription.packages')}}" class="btn btn-sm btn-warning mt-2">Subscribe Now</a>
                            @endif
                        </div>
                    </div>

                    <!-- Hobbies -->
                    @if($hobbiesData)
                    <div class="info-card animate-fade-in" style="animation-delay: 0.5s;">
                        <div class="info-card-header" style="justify-content: space-between;">
                            <h4><i class="fas fa-heart text-danger"></i>Hobbies & Interests</h4>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('hobbies')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="info-card-body">
                            @if($hobbiesData->description)
                                <div class="mb-3">{!! $hobbiesData->description !!}</div>
                            @endif
                            @if($hobbiesData->interests)
                                <div class="skill-tags">
                                    @foreach(explode(',', $hobbiesData->interests) as $interest)
                                        <span class="skill-tag" style="background: #fce4ec; color: #c2185b;">{{trim($interest)}}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="info-card animate-fade-in" style="animation-delay: 0.5s;">
                        <div class="info-card-header" style="justify-content: space-between;">
                            <h4><i class="fas fa-heart text-danger"></i>Hobbies & Interests</h4>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('hobbies')" title="Add">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="info-card-body">
                            <div class="empty-state">
                                <i class="fas fa-heart"></i>
                                <p>No hobbies added yet</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Floating Action Buttons -->
        <div class="fab-container">
            <button class="fab-btn info" onclick="openViewProfileModal()" title="View Profile">
                <i class="fas fa-user"></i>
                <span class="tooltip">View Profile</span>
            </button>
            <a href="{{route('subscription.packages')}}" class="fab-btn success" title="Subscription">
                <i class="fas fa-crown"></i>
                <span class="tooltip">Subscription</span>
            </a>
        </div>

        <!-- View Profile Modal -->
        <div class="modal fade" id="viewProfileModal" tabindex="-1" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                        <h5 class="modal-title text-white" id="viewProfileModalLabel">
                            <i class="fas fa-user-circle me-2"></i>My Profile
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="viewProfileModalBody">
                        <!-- Content loaded via AJAX -->
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Loading profile details...</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">
                        <a href="{{route('candidate.profile')}}" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-2"></i>View Full Page
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modals -->
        @include('users.dashboard.partials.edit-modals')
    @else
        <div class="container py-5">
            <div class="alert alert-danger text-center p-5 rounded-3">
                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                <h4>Account Not Verified</h4>
                <p>Your account/mobile number is not verified. One of our representatives will contact you soon!</p>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    // Animate progress bar on load
    document.addEventListener('DOMContentLoaded', function() {
        const progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            const width = progressBar.style.width;
            progressBar.style.width = '0%';
            setTimeout(() => {
                progressBar.style.width = width;
            }, 300);
        }
    });

    // Modal Management
    function openEditModal(type) {
        const modalMap = {
            'basic': 'editBasicModal',
            'address': 'editAddressModal',
            'education': 'editEducationModal',
            'skills': 'editSkillsModal',
            'experience': 'editExperienceModal',
            'hobbies': 'editHobbiesModal'
        };
        
        const modalId = modalMap[type];
        if (modalId) {
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        }
    }

    // View Profile Modal
    function openViewProfileModal() {
        const modal = new bootstrap.Modal(document.getElementById('viewProfileModal'));
        modal.show();
        
        // Reset modal body
        document.getElementById('viewProfileModalBody').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading profile details...</p>
            </div>
        `;
        
        // Fetch profile details
        fetch('{{ route("api.candidate.profile") }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                renderProfileDetails(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('viewProfileModalBody').innerHTML = `
                    <div class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <h5>Failed to load profile details</h5>
                        <p class="text-muted">Please try again later</p>
                    </div>
                `;
            });
    }

    function renderProfileDetails(data) {
        const user = data.user;
        const basics = data.basics;
        const presentAddress = data.present_address;
        const permanentAddress = data.permanent_address;
        const qualifications = data.qualifications;
        const skills = data.skills;
        const experiences = data.experiences;
        const hobbies = data.hobbies;
        
        let html = `
            <div class="row">
                <!-- Profile Header -->
                <div class="col-12 text-center mb-4">
                    ${user.image_path ? 
                        `<img src="${user.image_path}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid #4e73df;" onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">` :
                        `<div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 40px;">
                            <i class="fas fa-user"></i>
                        </div>`
                    }
                    <h4 class="fw-bold mb-1">${user.full_name || 'Unknown'}</h4>
                    <p class="text-muted mb-2">${user.email || 'N/A'}</p>
                    <p class="text-muted mb-2"><i class="fas fa-phone me-1"></i>${user.mobile || 'N/A'}</p>
                    ${basics?.profession ? `<span class="badge bg-success">${basics.profession}</span>` : ''}
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
                            <div class="mb-2"><strong>Job Type:</strong> ${basics?.Job_type || 'Not specified'}</div>
                            <div class="mb-2"><strong>Experience:</strong> ${basics?.experience || 'Not specified'}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-info mb-3"><i class="fas fa-address-book me-2"></i>Contact Details</h6>
                            <div class="mb-2"><strong>Email:</strong> ${user.email || 'N/A'}</div>
                            <div class="mb-2"><strong>Mobile:</strong> ${user.mobile || 'N/A'}</div>
                            <div class="mb-2"><strong>Alt. Mobile:</strong> ${basics?.alternate_mobile_number || 'Not provided'}</div>
                            <div class="mb-2"><strong>WhatsApp:</strong> ${basics?.whatsapp_number || 'Not provided'}</div>
                            <div class="mb-2"><strong>Alt. Email:</strong> ${basics?.alternate_email_id || 'Not provided'}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Addresses -->
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
                
                <!-- Qualifications -->
                ${qualifications?.length > 0 ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-success mb-3"><i class="fas fa-graduation-cap me-2"></i>Education & Qualifications</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        ${qualifications.map(q => {
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
                
                <!-- Experience -->
                ${experiences?.length > 0 ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-info mb-3"><i class="fas fa-briefcase me-2"></i>Work Experience</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        ${experiences.map(exp => {
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
                
                <!-- Skills -->
                ${skills?.length > 0 ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3"><i class="fas fa-tools me-2"></i>Skills & Expertise</h6>
                            ${(() => {
                                // Group skills by industry_id
                                const groupedSkills = skills.reduce((acc, skill) => {
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
                                            <h6 class="mb-0 fw-bold text-primary">
                                                <i class="fas fa-briefcase me-2"></i>${roleName}
                                            </h6>
                                            ${proficiency ? `<span class="badge-custom badge-primary">${proficiency}</span>` : ''}
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            ${roleSkills.map(s => `
                                                <span class="badge bg-success" style="font-size: 14px; padding: 8px 15px;">
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
                
                <!-- Hobbies -->
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
                
                <!-- Digital Signature -->
                ${user.signature_image ? `
                <div class="col-12 mb-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-signature me-2"></i>Digital Signature</h6>
                            <img src="${user.signature_image}" alt="Signature" style="max-width: 300px; border: 1px solid #ddd; padding: 10px; background: #fff;">
                        </div>
                    </div>
                </div>
                ` : ''}
            </div>
        `;
        
        document.getElementById('viewProfileModalBody').innerHTML = html;
    }

    // Handle modal close - clean up backdrops
    document.getElementById('viewProfileModal').addEventListener('hidden.bs.modal', function () {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    });
</script>
@endsection
