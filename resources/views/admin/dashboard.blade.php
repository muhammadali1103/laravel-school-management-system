@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <style>
        .stat-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card .bg-icon {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 8rem;
            opacity: 0.1;
            transform: rotate(-15deg);
            transition: all 0.3s ease;
        }

        .stat-card:hover .bg-icon {
            transform: rotate(0deg) scale(1.1);
        }

        .stat-card .card-body {
            position: relative;
            z-index: 1;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            font-weight: 600;
        }

        /* Gradients */
        .bg-gradient-primary-modern {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
        }

        .bg-gradient-success-modern {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }

        .bg-gradient-info-modern {
            background: linear-gradient(135deg, #00b4db, #0083b0);
        }

        .bg-gradient-warning-modern {
            background: linear-gradient(135deg, #fce38a, #f38181);
        }

        .bg-gradient-purple-modern {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        /* Action Cards */
        .action-card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
            text-align: center;
            padding: 1.5rem;
            cursor: pointer;
            display: block;
            text-decoration: none;
            color: #4a5568;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .action-card:hover .action-icon {
            background: #667eea;
            color: #fff;
        }

        .action-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .action-desc {
            font-size: 0.8rem;
            color: #a0aec0;
        }
    </style>

    <div class="row g-4 mb-4">
        <!-- Welcome Section -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-muted mb-0">Here's what's happening in your school today.</p>
                    </div>
                    <div class="d-none d-md-block">
                        <span class="badge bg-light text-dark p-2 px-3 rounded-pill border">
                            <i class="bi bi-calendar3 me-1"></i> {{ date('l, d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="col-md-3">
            <a href="{{ route('admin.students.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-primary-modern text-white h-100">
                    <div class="card-body p-4">
                        <div class="stat-value">{{ $stats['students'] }}</div>
                        <div class="stat-label mt-1">Total Students</div>
                        <i class="bi bi-mortarboard-fill bg-icon"></i>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 ps-4">
                        <small class="text-white-50">View Details <i class="bi bi-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.teachers.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-success-modern text-white h-100">
                    <div class="card-body p-4">
                        <div class="stat-value">{{ $stats['teachers'] }}</div>
                        <div class="stat-label mt-1">Total Teachers</div>
                        <i class="bi bi-person-badge-fill bg-icon"></i>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 ps-4">
                        <small class="text-white-50">View Details <i class="bi bi-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.courses.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-info-modern text-white h-100">
                    <div class="card-body p-4">
                        <div class="stat-value">{{ $stats['courses'] }}</div>
                        <div class="stat-label mt-1">Total Courses</div>
                        <i class="bi bi-book-half bg-icon"></i>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 ps-4">
                        <small class="text-white-50">View Details <i class="bi bi-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.classes.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-warning-modern text-white h-100">
                    <div class="card-body p-4">
                        <div class="stat-value">{{ $stats['classes'] }}</div>
                        <div class="stat-label mt-1">Total Classes</div>
                        <i class="bi bi-door-open-fill bg-icon"></i>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 ps-4">
                        <small class="text-white-50">View Details <i class="bi bi-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 px-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge text-warning me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <a href="{{ route('admin.students.create') }}" class="action-card">
                                <div class="action-icon text-primary">
                                    <i class="bi bi-person-plus-fill"></i>
                                </div>
                                <div class="action-title">Add Student</div>
                                <div class="action-desc">Register new admission</div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('admin.teachers.create') }}" class="action-card">
                                <div class="action-icon text-success">
                                    <i class="bi bi-briefcase-fill"></i>
                                </div>
                                <div class="action-title">Add Teacher</div>
                                <div class="action-desc">Hire new faculty</div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('admin.courses.create') }}" class="action-card">
                                <div class="action-icon text-info">
                                    <i class="bi bi-book-fill"></i>
                                </div>
                                <div class="action-title">Add Course</div>
                                <div class="action-desc">Create new subject</div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('admin.classes.create') }}" class="action-card">
                                <div class="action-icon text-warning">
                                    <i class="bi bi-grid-fill"></i>
                                </div>
                                <div class="action-title">Create Class</div>
                                <div class="action-desc">Add new section</div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('admin.attendance.create') }}" class="action-card">
                                <div class="action-icon text-danger">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div class="action-title">Mark Attendance</div>
                                <div class="action-desc">Daily roll call</div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('admin.notifications.create') }}" class="action-card">
                                <div class="action-icon text-secondary">
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                                <div class="action-title">Notify</div>
                                <div class="action-desc">Send announcements</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Overview -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pie-chart text-primary me-2"></i>Today's Overview</h5>
                </div>
                <div class="card-body p-0 position-relative">
                    <div class="bg-gradient-purple-modern p-5 text-center text-white position-relative overflow-hidden">
                        <div class="position-relative z-1">
                            <h1 class="display-1 fw-bold mb-0">{{ $stats['attendance_today'] }}</h1>
                            <p class="lead mb-0 opacity-75">Attendance Records</p>
                            <p class="small opacity-50">Marked Today</p>
                        </div>
                        <i class="bi bi-graph-up-arrow position-absolute"
                            style="font-size: 10rem; bottom: -40px; right: -20px; opacity: 0.1; transform: rotate(-10deg);"></i>
                    </div>
                    <div class="p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.attendance.index') }}"
                                class="btn btn-outline-primary py-2 rounded-pill">
                                <i class="bi bi-eye me-2"></i>View Attendance Logs
                            </a>
                            <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary py-2 rounded-pill">
                                <i class="bi bi-plus-lg me-2"></i>Mark New Attendance
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection