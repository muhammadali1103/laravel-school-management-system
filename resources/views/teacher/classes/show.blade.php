@extends('teacher.layouts.app')

@section('title', $class->name . ' - Details')
@section('page-title', 'Class Details')

@section('content')
    <div class="row g-4">
        <!-- Class Info Card -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-light-primary text-primary d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 64px; height: 64px;">
                        <i class="bi bi-mortarboard fs-2"></i>
                    </div>
                    <h4>{{ $class->name }}</h4>
                    <p class="text-muted mb-4">Section {{ $class->section }}</p>

                    <div class="row g-3 text-start">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h3 class="mb-0 text-primary">{{ $class->students->count() }}</h3>
                                <small class="text-muted">Students</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h3 class="mb-0 text-success">{{ $class->capacity ?? '-' }}</h3>
                                <small class="text-muted">Capacity</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="text-start">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Quick Actions</h6>
                        <!-- Mark Attendance Button (Only for Class Teacher) -->
                        @if($class->teacher_id === auth()->user()->teacher->id)
                            <a href="{{ route('teacher.attendance.create', ['class_id' => $class->id]) }}"
                                class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-calendar-check me-2"></i> Mark Attendance
                            </a>
                        @else
                            <div class="alert alert-light border text-center mb-2 p-2 small text-muted">
                                <i class="bi bi-info-circle me-1"></i> View Only Access
                            </div>
                        @endif
                        <a href="{{ route('teacher.classes.index') }}" class="btn btn-light w-100">
                            <i class="bi bi-arrow-left me-2"></i> Back to Classes
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="col-md-8">
            <div class="card h-100 border-0 shadow-sm">
                <div
                    class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center py-3 border-0">
                    <h5 class="mb-2 mb-md-0 fw-bold text-dark display-6 fs-5">Student List</h5>
                    <div class="input-group input-group-sm w-auto shadow-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Search student...">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase small text-muted">
                                <tr>
                                    <th class="ps-4" style="font-weight: 600;">Student</th>
                                    <th class="d-none d-md-table-cell" style="font-weight: 600;">Roll No</th>
                                    <th class="d-none d-lg-table-cell" style="font-weight: 600;">Parent Info</th>
                                    <th class="text-end pe-4" style="font-weight: 600;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($class->students as $student)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="position-relative">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white me-3 shadow-sm"
                                                        style="width: 45px; height: 45px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); font-weight: bold; font-size: 1.1rem;">
                                                        {{ substr($student->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $student->user->name }}</div>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 150px;">
                                                        {{ $student->user->email }}
                                                    </small>
                                                    <!-- Mobile only stats -->
                                                    <div class="d-md-none mt-1">
                                                        <span
                                                            class="badge bg-light text-dark border">#{{ $student->roll_number }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span
                                                class="badge bg-light text-dark border rounded-pill px-3">{{ $student->roll_number ?? 'N/A' }}</span>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            @if($student->parent_name)
                                                <div class="d-flex flex-column">
                                                    <span class="fw-medium text-dark">{{ $student->parent_name }}</span>
                                                    <span class="small text-muted"><i
                                                            class="bi bi-telephone me-1"></i>{{ $student->parent_phone }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                <i class="bi bi-check-circle-fill me-1"></i> Active
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="mb-3">
                                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-secondary"
                                                    style="width: 64px; height: 64px;">
                                                    <i class="bi bi-people display-6"></i>
                                                </div>
                                            </div>
                                            <h6 class="fw-bold">No students found</h6>
                                            <p class="small mb-0">This class currently has no students assigned.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection