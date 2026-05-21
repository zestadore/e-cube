@extends('layouts.app')

@section('styles')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .stat-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .bg-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .bg-gradient-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .bg-gradient-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .bg-gradient-dark {
            background: linear-gradient(135deg, #434343 0%, #000000 100%);
        }
        .chart-container {
            position: relative;
            height: 300px;
        }
        .activity-item {
            padding: 15px;
            border-left: 3px solid #e3e6f0;
            margin-left: 15px;
            position: relative;
        }
        .activity-item::before {
            content: '';
            position: absolute;
            left: -9px;
            top: 20px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #4e73df;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px #e3e6f0;
        }
        .activity-item.success::before { background: #1cc88a; }
        .activity-item.info::before { background: #36b9cc; }
        .activity-item.warning::before { background: #f6c23e; }
        .today-stat {
            background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }
        .today-stat h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .today-stat p {
            color: #858796;
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="mb-2">Welcome to Admin Dashboard! 👋</h2>
                                <p class="mb-0 opacity-75">Here's what's happening on your platform today.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <h4 class="mb-1">{{ now()->format('l, d M Y') }}</h4>
                                <p class="mb-0 opacity-75">Platform Overview</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="today-stat">
                    <div class="text-primary mb-2">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h3 class="text-primary">{{ $todayEmployees }}</h3>
                    <p>New Employees Today</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="today-stat">
                    <div class="text-success mb-2">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                    <h3 class="text-success">{{ $todayEmployers }}</h3>
                    <p>New Employers Today</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="today-stat">
                    <div class="text-info mb-2">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </div>
                    <h3 class="text-info">{{ $todayApplications }}</h3>
                    <p>Applications Today</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="today-stat">
                    <div class="text-warning mb-2">
                        <i class="fas fa-rupee-sign fa-2x"></i>
                    </div>
                    <h3 class="text-warning">₹{{ number_format($todayRevenue, 0) }}</h3>
                    <p>Revenue Today</p>
                </div>
            </div>
        </div>

        <!-- Main Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card stat-card bg-gradient-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Employees</h6>
                                <h3 class="mb-0">{{ number_format($totalEmployees) }}</h3>
                            </div>
                            <div class="stat-icon bg-white text-primary">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card stat-card bg-gradient-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Employers</h6>
                                <h3 class="mb-0">{{ number_format($totalEmployers) }}</h3>
                            </div>
                            <div class="stat-icon bg-white text-success">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card stat-card bg-gradient-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Job Posts</h6>
                                <h3 class="mb-0">{{ number_format($totalJobPosts) }}</h3>
                            </div>
                            <div class="stat-icon bg-white text-info">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card stat-card bg-gradient-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Applications</h6>
                                <h3 class="mb-0">{{ number_format($totalApplications) }}</h3>
                            </div>
                            <div class="stat-icon bg-white text-warning">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card stat-card bg-gradient-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Revenue</h6>
                                <h3 class="mb-0">₹{{ number_format($totalRevenue/1000, 1) }}K</h3>
                            </div>
                            <div class="stat-icon bg-white text-danger">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card stat-card bg-gradient-dark text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Total Users</h6>
                                <h3 class="mb-0">{{ number_format($totalEmployees + $totalEmployers) }}</h3>
                            </div>
                            <div class="stat-icon bg-white text-dark">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-3">
                <div class="card h-100" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="card-title mb-0">User Registration Trends</h5>
                        <small class="text-muted">Last 6 months data</small>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="userTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card h-100" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="card-title mb-0">Application Status</h5>
                        <small class="text-muted">Distribution overview</small>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="applicationStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-3">
                <div class="card h-100" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="card-title mb-0">Revenue Trend</h5>
                        <small class="text-muted">Monthly revenue analysis</small>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card h-100" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="card-title mb-0">Top Industries</h5>
                        <small class="text-muted">By job postings</small>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="industryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Stats -->
        <div class="row">
            <!-- Recent Applications -->
            <div class="col-lg-8 mb-3">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Recent Applications</h5>
                            <small class="text-muted">Latest job applications</small>
                        </div>
                        <a href="{{ route('admin.applications.index') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Candidate</th>
                                        <th>Job Title</th>
                                        <th>Applied On</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentApplications as $application)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="rounded-circle" src="{{ $application->user->image_path ?? asset('assets/images/default-avatar.png') }}" alt="profile" style="width: 40px; height: 40px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ $application->user->first_name }} {{ $application->user->last_name }}</h6>
                                                    <small class="text-muted">{{ $application->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $application->jobPost->title ?? 'N/A' }}</td>
                                        <td>{{ $application->created_at->format('d M Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($application->status) {
                                                    'pending' => 'bg-warning',
                                                    'shortlisted' => 'bg-info',
                                                    'rejected' => 'bg-danger',
                                                    'hired' => 'bg-success',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }} rounded-pill">{{ ucfirst($application->status) }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No recent applications</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users & Quick Actions -->
            <div class="col-lg-4 mb-3">
                <div class="card mb-3" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="card-title mb-0">Recent Users</h5>
                        <small class="text-muted">Newly registered users</small>
                    </div>
                    <div class="card-body">
                        @forelse($recentUsers as $user)
                        <div class="d-flex align-items-center mb-3">
                            <img class="rounded-circle" src="{{ $user->image_path ?? asset('assets/images/default-avatar.png') }}" alt="profile" style="width: 45px; height: 45px; object-fit: cover;">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                <small class="text-muted">{{ ucfirst($user->role) }}</small>
                            </div>
                            <span class="badge bg-{{ $user->role == 'employee' ? 'primary' : 'success' }} rounded-pill">{{ $user->role == 'employee' ? 'Employee' : 'Employer' }}</span>
                        </div>
                        @empty
                        <p class="text-muted text-center mb-0">No recent users</p>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.users.employees') }}" class="btn btn-outline-primary">
                                <i class="fas fa-users me-2"></i>Manage Employees
                            </a>
                            <a href="{{ route('admin.users.employers') }}" class="btn btn-outline-success">
                                <i class="fas fa-building me-2"></i>Manage Employers
                            </a>
                            <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-info">
                                <i class="fas fa-file-alt me-2"></i>View Applications
                            </a>
                            <a href="{{ route('admin.payment-history') }}" class="btn btn-outline-warning">
                                <i class="fas fa-rupee-sign me-2"></i>Payment History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // User Trend Chart
    const userTrendCtx = document.getElementById('userTrendChart').getContext('2d');
    new Chart(userTrendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Employees',
                data: {!! json_encode($employeeData) !!},
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }, {
                label: 'Employers',
                data: {!! json_encode($employerData) !!},
                borderColor: '#11998e',
                backgroundColor: 'rgba(17, 153, 142, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Application Status Chart
    const appStatusCtx = document.getElementById('applicationStatusChart').getContext('2d');
    new Chart(appStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Shortlisted', 'Rejected', 'Hired'],
            datasets: [{
                data: {!! json_encode(array_values($applicationStatusData)) !!},
                backgroundColor: [
                    '#f6c23e',
                    '#36b9cc',
                    '#e74a3b',
                    '#1cc88a'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Revenue (₹)',
                data: {!! json_encode($revenueData) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: '#4e73df',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Industry Chart
    const industryCtx = document.getElementById('industryChart').getContext('2d');
    new Chart(industryCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topIndustries->pluck('industry_name')) !!},
            datasets: [{
                label: 'Job Posts',
                data: {!! json_encode($topIndustries->pluck('total')) !!},
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(17, 153, 142, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(250, 112, 154, 0.8)',
                    'rgba(240, 147, 251, 0.8)'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endsection