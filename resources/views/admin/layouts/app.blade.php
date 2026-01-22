<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - School Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Global Modern Styles */
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --sidebar-gradient: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            /* Premium Dark Slate */
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --active-gradient: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
        }

        body {
            min-height: 100vh;
            background-color: #f8fafc;
            /* Lighter background for contrast */
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* Modern Sidebar */
        .sidebar {
            min-height: 100vh;
            height: 100vh;
            width: 270px;
            /* Slightly wider for elegance */
            background: var(--sidebar-gradient);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-brand {
            padding: 15px 24px;
            /* Significantly reduced padding */
            color: #fff;
            font-size: 1.25rem;
            /* Slightly smaller font */
            font-weight: 800;
            letter-spacing: -0.5px;
            background: transparent;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            /* Reduced margin */
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            /* Added subtle separator */
        }

        .sidebar-brand i {
            background: var(--active-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
            /* Smaller icon */
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 5px 12px;
            /* Reduced padding */
        }

        /* Visible Scrollbar */
        .sidebar-content::-webkit-scrollbar {
            width: 6px;
        }

        /* Slightly wider */
        .sidebar-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.4);
            /* Much more visible */
            border-radius: 10px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: #94a3b8;
            padding: 8px 12px;
            /* Reduced from 10px 16px */
            margin: 2px 0;
            /* Minimal margin */
            border-radius: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            display: flex;
            align-items: center;
            border: none;
            /* Border removed */
            font-size: 0.85rem;
            /* Reduced from 0.9rem */
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #f1f5f9;
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: var(--active-gradient);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            font-size: 1.05rem;
            transition: transform 0.3s ease;
            text-align: center;
            opacity: 0.8;
        }

        .sidebar .nav-link:hover i {
            opacity: 1;
            transform: scale(1.1);
        }

        .sidebar .nav-link.active i {
            opacity: 1;
        }

        /* Improved Submenu */
        .sidebar .collapse {
            margin-left: 10px;
            padding-left: 10px;
            border-left: 1px solid rgba(255, 255, 255, 0.08);
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .sidebar .collapse .nav-link {
            padding: 6px 14px;
            /* Ultra compact submenu */
            font-size: 0.85rem;
            background: transparent;
            opacity: 0.7;
            margin: 1px 0;
            color: #cbd5e1;
        }

        .sidebar .collapse .nav-link:hover {
            background: transparent;
            color: #fff;
            opacity: 1;
            transform: translateX(4px);
        }

        .sidebar .collapse .nav-link.active {
            background: rgba(255, 255, 255, 0.08);
            opacity: 1;
            font-weight: 600;
            color: #fff;
            box-shadow: none;
            border-radius: 8px;
        }

        /* Chevron Toggle Animation */
        .sidebar .nav-link[data-bs-toggle="collapse"] {
            justify-content: space-between;
        }

        .sidebar .nav-link .bi-chevron-down {
            margin-right: 0;
            font-size: 0.8rem;
            transition: transform 0.3s ease;
            opacity: 0.5;
        }

        .sidebar .nav-link:hover .bi-chevron-down {
            opacity: 0.8;
        }

        .sidebar .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
            opacity: 1;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 270px;
            padding: 30px;
            min-height: 100vh;
            background: #f8fafc;
        }

        /* Global Card Styling */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            background: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        /* Only apply hover effect to non-layout cards (optional, or applied via specific class if needed)
    But user wants "beautiful pages", so subtle lift on cards is nice. */
        .card:hover {
            box-shadow: var(--hover-shadow);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 20px 24px;
            font-weight: 600;
            font-size: 1.1rem;
            color: #1e293b;
        }

        /* Global Table Styling */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 12px 12px;
            /* Reduced padding */
            border-bottom: 2px solid #e2e8f0;
        }

        .table tbody td {
            padding: 12px 12px;
            /* Reduced padding */
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Fix for actions column width */
        .table th:last-child,
        .table td:last-child {
            white-space: nowrap;
            width: 1%;
            text-align: right;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Buttons styling */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.25);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(102, 126, 234, 0.3);
            background: linear-gradient(135deg, #5a67d8 0%, #6e4391 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            box-shadow: 0 4px 6px rgba(56, 239, 125, 0.25);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(56, 239, 125, 0.3);
            background: linear-gradient(135deg, #0e8a7f 0%, #2fdb70 100%);
        }

        .btn-info {
            background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
            border: none;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 180, 219, 0.25);
            transition: all 0.3s ease;
        }

        .btn-info:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(0, 180, 219, 0.3);
            color: #fff;
            background: linear-gradient(135deg, #009ebf 0%, #007299 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #fce38a 0%, #f38181 100%);
            border: none;
            color: #fff;
            box-shadow: 0 4px 6px rgba(243, 129, 129, 0.25);
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(243, 129, 129, 0.3);
            color: #fff;
            background: linear-gradient(135deg, #e8cf78 0%, #de7070 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            border: none;
            box-shadow: 0 4px 6px rgba(255, 75, 43, 0.25);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(255, 75, 43, 0.3);
            background: linear-gradient(135deg, #e6365d 0%, #e64124 100%);
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 16px;
            border-color: #e2e8f0;
            box-shadow: none;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Modern Beautiful Pagination Styling */
        nav[role="navigation"] {
            margin: 20px 0;
        }

        nav[role="navigation"] .pagination {
            margin: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 8px !important;
            flex-wrap: wrap !important;
        }

        nav[role="navigation"] .pagination .page-item {
            margin: 0 !important;
        }

        nav[role="navigation"] .pagination .page-link {
            padding: 10px 16px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            border: 1px solid #e0e7ff !important;
            background: #ffffff !important;
            color: #4f46e5 !important;
            min-width: 42px !important;
            height: 42px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
            text-decoration: none !important;
        }

        /* Hover effect */
        nav[role="navigation"] .pagination .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: #ffffff !important;
            border-color: #667eea !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4) !important;
        }

        /* Active page */
        nav[role="navigation"] .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4) !important;
            font-weight: 600 !important;
        }

        /* Disabled state */
        nav[role="navigation"] .pagination .page-item.disabled .page-link {
            background: #f3f4f6 !important;
            border-color: #e5e7eb !important;
            color: #9ca3af !important;
            cursor: not-allowed !important;
            box-shadow: none !important;
        }

        nav[role="navigation"] .pagination .page-item.disabled .page-link:hover {
            transform: none !important;
            background: #f3f4f6 !important;
        }

        /* Arrow icons - Small and clean */
        nav[role="navigation"] .pagination svg,
        .pagination svg,
        nav svg {
            width: 12px !important;
            height: 12px !important;
            max-width: 12px !important;
            max-height: 12px !important;
            vertical-align: middle !important;
            fill: currentColor !important;
        }

        /* Previous/Next buttons - Special styling */
        nav[role="navigation"] .pagination .page-item:first-child .page-link,
        nav[role="navigation"] .pagination .page-item:last-child .page-link {
            padding: 10px 18px !important;
            font-weight: 600 !important;
        }

        /* Dots styling */
        nav[role="navigation"] .pagination .page-item .page-link[aria-label*="..."] {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-mortarboard-fill"></i>
            {{ auth()->user()->role->name === 'super_admin' ? 'Super Admin' : Illuminate\Support\Str::headline(auth()->user()->role->name) . ' Portal' }}
        </div>
        <div class="sidebar-content">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                @can('student.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"
                            href="{{ route('admin.students.index') }}">
                            <i class="bi bi-people"></i> Students
                        </a>
                    </li>
                @endcan

                @can('teacher.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}"
                            href="{{ route('admin.teachers.index') }}">
                            <i class="bi bi-person-badge"></i> Teachers
                        </a>
                    </li>
                @endcan

                {{-- Courses doesn't have a specific permission module in seeder yet, mapped to 'classes' or 'subjects'?
                Seeder had 'subjects'. Let's assume 'subjects.view'. If 'courses' is different, I might need to add it.
                Checking seeder... 'subjects' is there. 'courses' was in sidebar.
                Let's check routes... admin.courses.index.
                If I missed 'courses' module, I should add it.
                Existing code had 'admin.courses.*'.
                I will add 'courses' to seeder or just map it to 'subjects' if they are same.
                Actually, usually Course = Subject in some systems.
                Let's assume Use 'classes.view' for Classes and 'subjects.view' for Courses.
                --}}
                @can('subject.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}"
                            href="{{ route('admin.courses.index') }}">
                            <i class="bi bi-book"></i> Courses
                        </a>
                    </li>
                @endcan

                @can('class.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}"
                            href="{{ route('admin.classes.index') }}">
                            <i class="bi bi-door-open"></i> Classes
                        </a>
                    </li>
                @endcan

                @can('attendance.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}"
                            href="{{ route('admin.attendance.index') }}">
                            <i class="bi bi-calendar-check"></i> Attendance
                        </a>
                    </li>
                @endcan

                <!-- Fee Management Dropdown -->
                @can('fee.view')
                    <div class="nav-item">
                        <a href="#feeSubmenu" class="nav-link collapsed" data-bs-toggle="collapse" aria-expanded="false">
                            <i class="bi bi-cash-stack"></i> Fee Management
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.fees.*') || request()->routeIs('admin.fee-structures.*') || request()->routeIs('admin.fee-assignments.*') ? 'show' : '' }}"
                            id="feeSubmenu">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a href="{{ route('admin.fees.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.fees.*') ? 'active' : '' }}">
                                        <i class="bi bi-receipt"></i> Fees
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.fee-structures.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.fee-structures.*') ? 'active' : '' }}">
                                        <i class="bi bi-list-check"></i> Fee Structures
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.fee-assignments.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.fee-assignments.*') ? 'active' : '' }}">
                                        <i class="bi bi-clipboard-check"></i> Fee Assignments
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endcan

                @can('timetable.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.timetables.*') ? 'active' : '' }}"
                            href="{{ route('admin.timetables.index') }}">
                            <i class="bi bi-table"></i> Timetable
                        </a>
                    </li>
                @endcan

                @can('role.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}">
                            <i class="bi bi-person-badge"></i> Roles
                        </a>
                    </li>
                @endcan

                @can('user.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people-fill"></i> Users
                        </a>
                    </li>
                @endcan

            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="d-flex justify-content-between align-items-center mb-4 py-3 px-4 bg-white shadow-sm rounded-4">
            <div>
                <h4 class="mb-0 fw-bold text-dark">@yield('page-title', 'Dashboard')</h4>
                <p class="text-muted small mb-0">{{ \Carbon\Carbon::now()->format('l, d M Y') }}</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Notifications (Placeholder) -->
                <a href="{{ route('admin.notifications.index') }}" class="text-secondary p-2 rounded-circle bg-light">
                    <i class="bi bi-bell fs-5"></i>
                </a>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button
                        class="d-flex align-items-center gap-2 btn btn-light rounded-pill px-3 py-2 border shadow-sm"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: white;">

                        <!-- Avatar -->
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                            style="width: 35px; height: 35px; background: linear-gradient(135deg, #6366f1, #8b5cf6); font-weight: bold; font-size: 1.1rem;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>

                        <!-- Name -->
                        <div class="d-none d-md-block text-start lh-1">
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ auth()->user()->name }}</div>
                        </div>
                        <i class="bi bi-chevron-down text-muted ms-1" style="font-size: 0.8rem;"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2 mt-2"
                        style="min-width: 220px;">
                        <li>
                            <div class="px-3 py-2 border-bottom mb-2">
                                <h6 class="mb-0 text-dark fw-bold">{{ auth()->user()->name }}</h6>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 mb-1" href="{{ route('admin.profile.edit') }}">
                                <i class="bi bi-person-gear me-2 text-primary"></i> Profile Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarContent = document.querySelector('.sidebar-content');

            // Restore scroll position
            const scrollPos = localStorage.getItem('sidebarScrollPos');
            if (scrollPos) {
                sidebarContent.scrollTop = scrollPos;
            }

            // Save scroll position on scroll
            sidebarContent.addEventListener('scroll', function () {
                localStorage.setItem('sidebarScrollPos', this.scrollTop);
            });
        });
    </script>
    @yield('scripts')
</body>

</html>