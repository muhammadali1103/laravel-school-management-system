<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Panel') - School Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Global Modern Styles */
        :root {
            /* Purple Gradient for Students */
            --primary-gradient: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            --sidebar-gradient: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            /* Premium Dark Slate/Indigo */
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --active-gradient: linear-gradient(90deg, #7c3aed 0%, #a855f7 100%);
        }

        body {
            min-height: 100vh;
            background-color: #f8fafc;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* Modern Sidebar */
        .sidebar {
            min-height: 100vh;
            height: 100vh;
            width: 270px;
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
            color: #fff;
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: transparent;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-brand i {
            background: var(--active-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 5px 12px;
        }

        .sidebar-content::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 10px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 8px 12px;
            /* Reduced padding */
            margin: 1px 0;
            border-radius: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            display: flex;
            align-items: center;
            border: none;
            font-size: 0.85rem;
            /* Reduced font size */
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
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
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
            border-bottom: 2px solid #e2e8f0;
        }

        .table tbody td {
            padding: 12px 12px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Buttons styling */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 6px rgba(124, 58, 237, 0.25);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(124, 58, 237, 0.3);
            background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
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
                @can('dashboard.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
                            href="{{ route('student.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                @endcan

                @can('attendance.view.self')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('student.attendance.*') ? 'active' : '' }}"
                            href="{{ route('student.attendance.index') }}">
                            <i class="bi bi-calendar-check"></i> My Attendance
                        </a>
                    </li>
                @endcan

                @can('timetable.view.self')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('student.timetable.*') ? 'active' : '' }}"
                            href="{{ route('student.timetable.index') }}">
                            <i class="bi bi-calendar3"></i> Timetable
                        </a>
                    </li>
                @endcan

                @can('fee.view.self')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('student.fees.*') ? 'active' : '' }}"
                            href="{{ route('student.fees.index') }}">
                            <i class="bi bi-wallet2"></i> My Fees
                        </a>
                    </li>
                @endcan

                @can('notification.view')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('student.notifications.*') ? 'active' : '' }}"
                            href="{{ route('student.notifications.index') }}">
                            <i class="bi bi-bell"></i> Notifications
                            @if(isset($studentNotificationCount) && $studentNotificationCount > 0)
                                <span class="badge bg-danger ms-2">{{ $studentNotificationCount }}</span>
                            @endif
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
                <!-- Notifications -->
                <a href="{{ route('student.notifications.index') }}"
                    class="text-secondary p-2 rounded-circle bg-light position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    @if(isset($studentNotificationCount) && $studentNotificationCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6rem;">
                            {{ $studentNotificationCount }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    @endif
                </a>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button
                        class="d-flex align-items-center gap-2 btn btn-light rounded-pill px-3 py-2 border shadow-sm"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: white;">

                        <!-- Avatar -->
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                            style="width: 35px; height: 35px; background: var(--primary-gradient); font-weight: bold; font-size: 1.1rem;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>

                        <!-- Name -->
                        <div class="d-none d-md-block text-start lh-1">
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ auth()->user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Student</div>
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
                            <a class="dropdown-item rounded-2 py-2 mb-1" href="{{ route('student.profile.edit') }}">
                                <i class="bi bi-person-gear me-2 text-primary"></i> Edit Profile
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
            const scrollPos = localStorage.getItem('sidebarScrollPos_student');
            if (scrollPos) {
                sidebarContent.scrollTop = scrollPos;
            }

            // Save scroll position on scroll
            sidebarContent.addEventListener('scroll', function () {
                localStorage.setItem('sidebarScrollPos_student', this.scrollTop);
            });
        });
    </script>
    @yield('scripts')
</body>

</html>