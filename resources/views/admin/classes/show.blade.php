@extends('admin.layouts.app')

@section('title', 'Class Details')
@section('page-title', 'Class Details')

@section('content')
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $class->name }} - Section {{ $class->section }}</h5>
            <div>
                <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">Class Teacher</label>
                    <h5>{{ $class->teacher ? $class->teacher->user->name : 'Not assigned' }}</h5>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="text-muted small">Capacity</label>
                    <h5>{{ $class->capacity }}</h5>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="text-muted small">Enrolled Students</label>
                    <h5>{{ $class->students->count() }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-white">
            <h5 class="mb-0">Enrolled Students</h5>
        </div>
        <div class="card-body">
            @if($class->students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $student)
                                <tr>
                                    <td><strong>{{ $student->roll_number }}</strong></td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->user->email }}</td>
                                    <td>{{ $student->phone ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No students enrolled yet.</p>
            @endif
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-white">
            <h5 class="mb-0">Assigned Courses</h5>
        </div>
        <div class="card-body">
            @if($class->courses->count() > 0)
                <div class="row">
                    @foreach($class->courses as $course)
                        <div class="col-md-6 mb-2">
                            <div class="border p-3 rounded">
                                <h6>{{ $course->name }} ({{ $course->code }})</h6>
                                <p class="text-muted small mb-0">{{ $course->credits }} Credits</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No courses assigned yet.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Classes
        </a>
    </div>
@endsection