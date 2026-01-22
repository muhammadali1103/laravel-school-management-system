@extends('admin.layouts.app')

@section('title', 'Student Details')
@section('page-title', 'Student Profile')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle text-primary" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">{{ $student->user->name }}</h4>
                    <p class="text-muted">{{ $student->user->email }}</p>
                    <span class="badge bg-primary">{{ $student->roll_number }}</span>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning w-100 mb-2">
                        <i class="bi bi-pencil"></i> Edit Student
                    </a>
                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Delete Student
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Phone</label>
                            <p class="mb-0">{{ $student->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Date of Birth</label>
                            <p class="mb-0">
                                {{ $student->date_of_birth ? $student->date_of_birth->format('F d, Y') : 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Gender</label>
                            <p class="mb-0">{{ $student->gender ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Address</label>
                            <p class="mb-0">{{ $student->address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Parent/Guardian Name</label>
                            <p class="mb-0">{{ $student->parent_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Parent/Guardian Phone</label>
                            <p class="mb-0">{{ $student->parent_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Enrolled Classes</h5>
                </div>
                <div class="card-body">
                    @if($student->classes->count() > 0)
                        <div class="row">
                            @foreach($student->classes as $class)
                                <div class="col-md-6 mb-2">
                                    <div class="border p-3 rounded">
                                        <h6>{{ $class->name }} - Section {{ $class->section }}</h6>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-person"></i>
                                            {{ $class->teacher ? $class->teacher->user->name : 'No teacher assigned' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Not enrolled in any classes.</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Attendance Summary</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalAttendance = $student->attendances->count();
                        $presentCount = $student->attendances->where('status', 'present')->count();
                        $percentage = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 2) : 0;
                    @endphp
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h3 class="text-primary">{{ $totalAttendance }}</h3>
                            <p class="text-muted small">Total Days</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="text-success">{{ $presentCount }}</h3>
                            <p class="text-muted small">Present</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="text-info">{{ $percentage }}%</h3>
                            <p class="text-muted small">Attendance</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Fee Summary</h5>
                </div>
                <div class="card-body">
                    @if($student->fees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Fee Type</th>
                                        <th>Amount</th>
                                        <th>Paid</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($student->fees as $fee)
                                        <tr>
                                            <td>{{ $fee->fee_type }}</td>
                                            <td>PKR {{ number_format($fee->amount, 2) }}</td>
                                            <td>PKR {{ number_format($fee->paid_amount, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $fee->status == 'paid' ? 'success' : ($fee->status == 'overdue' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($fee->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $fee->due_date->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No fee records.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Students
        </a>
    </div>
@endsection