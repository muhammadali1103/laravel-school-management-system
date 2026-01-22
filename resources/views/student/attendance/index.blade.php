@extends('student.layouts.app')

@section('title', 'My Attendance')
@section('page-title', 'Attendance History')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 card-title">
                        <i class="bi bi-calendar-check text-primary me-2"></i> Attendance Records
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Status</th>
                                    <th>Class</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('d M, Y') }}</td>
                                        <td>{{ $attendance->date->format('l') }}</td>
                                        <td>
                                            @if($attendance->status == 'present')
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Present</span>
                                            @elseif($attendance->status == 'absent')
                                                <span
                                                    class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Absent</span>
                                            @elseif($attendance->status == 'late')
                                                <span
                                                    class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">Late</span>
                                            @elseif($attendance->status == 'excused')
                                                <span
                                                    class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">Excused</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($attendance->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $attendance->class->name ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="mb-3">
                                                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                            <h5 class="text-muted">No Attendance Records Found</h5>
                                            <p class="text-muted small">Your attendance history will appear here once marked.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 px-4 d-flex justify-content-center">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection