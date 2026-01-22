@extends('teacher.layouts.app')

@section('title', 'Attendance History')
@section('page-title', 'Attendance History')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 card-title">
                <i class="bi bi-clock-history text-primary me-2"></i> My Marked Attendance
            </h5>
            @can('attendance.mark')
                <a href="{{ route('teacher.attendance.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Mark New
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if($attendanceHistory->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Class</th>
                                <th class="text-center">Total Students</th>
                                <th class="text-center">Present</th>
                                <th class="text-center">Absent</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceHistory as $record)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</span>
                                        <small
                                            class="d-block text-muted">{{ \Carbon\Carbon::parse($record->date)->format('l') }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $record->class->name }}</span>
                                        <small class="text-muted d-block">Section {{ $record->class->section }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill px-3">{{ $record->total }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success rounded-pill px-3">{{ $record->present }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger rounded-pill px-3">{{ $record->absent }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light text-muted" disabled title="Editing disabled">
                                            <i class="bi bi-lock-fill"></i> Locked
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $attendanceHistory->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-clipboard-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="text-muted">No attendance records found.</h6>
                    <p class="text-muted small">Start by marking attendance for your classes.</p>
                    @can('attendance.mark')
                        <a href="{{ route('teacher.attendance.create') }}" class="btn btn-primary mt-2">Mark Attendance</a>
                    @endcan
                </div>
            @endif
        </div>
    </div>
@endsection