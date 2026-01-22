@extends('student.layouts.app')

@section('title', 'Student Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="row g-3 mb-4">
        @can('attendance.view.self')
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h6 class="card-title">Attendance Percentage</h6>
                        <h2>{{ $attendancePercentage }}%</h2>
                        <p class="mb-0 small">{{ $presentCount }} / {{ $totalAttendance }} Days Present</p>
                    </div>
                </div>
            </div>
        @endcan

        @can('timetable.view.self')
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h6 class="card-title">Enrolled Classes</h6>
                        <h2>{{ $enrolledClasses->count() }}</h2>
                        <p class="mb-0 small">Active enrollments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h6 class="card-title">Total Courses</h6>
                        <h2>{{ $enrolledCourses->count() }}</h2>
                        <p class="mb-0 small">Currently studying</p>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    @can('timetable.view.self')
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">My Classes</h5>
                    </div>
                    <div class="card-body">
                        @if($enrolledClasses->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($enrolledClasses as $class)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <strong>{{ $class->name }}</strong> - Section {{ $class->section }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Not enrolled in any classes.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">My Courses</h5>
                    </div>
                    <div class="card-body">
                        @if($enrolledCourses->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($enrolledCourses as $course)
                                    <li class="list-group-item">
                                        <strong>{{ $course->name }}</strong> ({{ $course->code }})
                                        <span class="badge bg-info">{{ $course->credits }} Credits</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No courses enrolled.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection