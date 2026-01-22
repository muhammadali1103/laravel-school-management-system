@extends('admin.layouts.app')

@section('title', 'Attendance Records')
@section('page-title', 'Attendance Management')

@section('content')
    <div class="card mb-3">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-funnel"></i> Filter Attendance</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="roll_number" class="form-label">Roll Number</label>
                        <input type="text" class="form-control" id="roll_number" name="roll_number"
                            value="{{ request('roll_number') }}" placeholder="Search Roll No">
                    </div>
                    <div class="col-md-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-select" id="class_id" name="class_id">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} - {{ $class->section }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($stats)
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body py-3">
                        <h6 class="card-title mb-0">Total Records</h6>
                        <h3 class="mb-0">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body py-3">
                        <h6 class="card-title mb-0">Present</h6>
                        <h3 class="mb-0">{{ $stats['present'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger">
                    <div class="card-body py-3">
                        <h6 class="card-title mb-0">Absent</h6>
                        <h3 class="mb-0">{{ $stats['absent'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body py-3">
                        <h6 class="card-title mb-0">Late</h6>
                        <h3 class="mb-0">{{ $stats['late'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Attendance Records</h5>
            <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
                <i class="bi bi-calendar-check"></i> Mark Attendance
            </a>
        </div>
        <div class="card-body">
            @if($attendances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Roll No.</th>
                                <th>Class</th>
                                <th>Status</th>
                                <th>Marked By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->date->format('M d, Y') }}</td>
                                    <td>{{ $attendance->student->user->name }}</td>
                                    <td><strong>{{ $attendance->student->roll_number }}</strong></td>
                                    <td>{{ $attendance->class->name }} - {{ $attendance->class->section }}</td>
                                    <td>
                                        @if($attendance->status == 'present')
                                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Present</span>
                                        @elseif($attendance->status == 'absent')
                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Absent</span>
                                        @else
                                            <span class="badge bg-warning"><i class="bi bi-clock"></i> Late</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance->markedBy ? $attendance->markedBy->name : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $attendances->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-check text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">
                        @if(request()->hasAny(['date', 'class_id', 'student_id', 'status']))
                            No attendance records found matching your filters.
                        @else
                            No attendance records found. Start marking attendance!
                        @endif
                    </p>
                    <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
                        <i class="bi bi-calendar-check"></i> Mark Attendance
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection