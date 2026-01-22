@extends('admin.layouts.app')

@section('title', 'Teacher Details')
@section('page-title', 'Teacher Profile')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge-fill text-success" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">{{ $teacher->user->name }}</h4>
                    <p class="text-muted">{{ $teacher->user->email }}</p>
                    <span class="badge bg-success">{{ $teacher->employee_id }}</span>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-warning w-100 mb-2">
                        <i class="bi bi-pencil"></i> Edit Teacher
                    </a>
                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Delete Teacher
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Professional Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Phone</label>
                            <p class="mb-0">{{ $teacher->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Qualification</label>
                            <p class="mb-0">{{ $teacher->qualification ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Subject Specialization</label>
                            <p class="mb-0">{{ $teacher->subject_specialization ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Joining Date</label>
                            <p class="mb-0">{{ $teacher->joining_date ? $teacher->joining_date->format('F d, Y') : 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Address</label>
                            <p class="mb-0">{{ $teacher->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Assigned Classes</h5>
                </div>
                <div class="card-body">
                    @if($teacher->classes->count() > 0)
                        <div class="row">
                            @foreach($teacher->classes as $class)
                                <div class="col-md-6 mb-2">
                                    <div class="border p-3 rounded">
                                        <h6>{{ $class->name }} - Section {{ $class->section }}</h6>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-people"></i> {{ $class->students->count() }} Students
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No classes assigned yet.</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Assigned Courses</h5>
                </div>
                <div class="card-body">
                    @if($teacher->courses->count() > 0)
                        <div class="row">
                            @foreach($teacher->courses as $course)
                                <div class="col-md-6 mb-2">
                                    <div class="border p-3 rounded">
                                        <h6>{{ $course->name }}</h6>
                                        <p class="text-muted small mb-0">
                                            <span class="badge bg-secondary">{{ $course->code }}</span>
                                            <span class="ms-2"><i class="bi bi-clock"></i> {{ $course->credits }} Credits</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No courses assigned yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Teachers
        </a>
    </div>
@endsection