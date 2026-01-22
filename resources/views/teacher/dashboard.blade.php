@extends('teacher.layouts.app')

@section('title', 'Teacher Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Statistics Row -->
    <div class="row g-3 mb-4">
        @can('class.view.assigned')
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-primary text-primary me-3">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Assigned Classes</h6>
                            <h3 class="mb-0">{{ $assignedClassesCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        @can('subject.view.assigned')
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-warning text-warning me-3">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Assigned Subjects</h6>
                            <h3 class="mb-0">{{ $assignedSubjectsCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        @can('attendance.mark')
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-danger text-danger me-3">
                            <i class="bi bi-clipboard-x fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pending Attendance</h6>
                            <h3 class="mb-0">{{ $pendingAttendanceCount }}</h3>
                            <small class="text-muted">For today</small>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    <!-- Today's Timetable -->
    @can('timetable.view.assigned')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 card-title"><i class="bi bi-calendar-day text-primary me-2"></i> Today's Timetable</h5>
                    </div>
                    <div class="card-body">
                        @if($todaysTimetable->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Time</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>Room</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($todaysTimetable as $slot)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $slot->start_time->format('h:i A') }} -
                                                        {{ $slot->end_time->format('h:i A') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong>{{ $slot->class->name }}</strong>
                                                    <span class="text-muted small">({{ $slot->class->section }})</span>
                                                </td>
                                                <td>{{ $slot->course->name }}</td>
                                                <td>{{ $slot->room ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('teacher.classes.show', $slot->class->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        View Class
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="text-muted">No classes scheduled for today!</h6>
                                <p class="text-muted small">Enjoy your free time or check your full timetable.</p>
                                <a href="#" class="btn btn-primary btn-sm mt-2">View Full Timetable</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection