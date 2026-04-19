@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                                        <div class="timeline-title">{{$qualification->qualification->degree ?? 'Unknown'}}</div>
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
                                <div class="skill-tags">
                                    @foreach(Auth::user()->skills as $skill)
                                        <span class="skill-tag">{{$skill->skill->skill ?? 'Unknown'}} ({{$skill->proficiency}})</span>
                                    @endforeach
                                </div>
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
                                            <i class="fas fa-industry me-1"></i>{{$experience->industry->industry_name ?? 'Unknown'}}
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
                            <a href="{{route('candidate.profile')}}" class="btn btn-outline-primary w-100 mb-3">
                                <i class="fas fa-eye me-2"></i>View Profile
                            </a>
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
            <a href="{{route('candidate.profile')}}" class="fab-btn info" title="View Profile">
                <i class="fas fa-user"></i>
                <span class="tooltip">View Profile</span>
            </a>
            <a href="{{route('subscription.packages')}}" class="fab-btn success" title="Subscription">
                <i class="fas fa-crown"></i>
                <span class="tooltip">Subscription</span>
            </a>
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
</script>
@endsection