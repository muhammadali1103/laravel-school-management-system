@extends('admin.layouts.app')

@section('title', 'Course Details')
@section('page-title', 'Course Details')

@section('content')
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $course->name }}</h5>
            <div>
                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">Course Code</label>
                    <h5>{{ $course->code }}</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">Credits</label>
                    <h5><span class="badge bg-primary fs-6">{{ $course->credits }} Credits</span></h5>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="text-muted small">Description</label>
                    <p>{{ $course->description ?? 'No description available' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-white">
            <h5 class="mb-0">Classes Teaching This Course</h5>
        </div>
        <div class="card-body">
            @if($course->classes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Teacher</th>
                                <th>Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course->classes as $class)
                                <tr>
                                    <td><strong>{{ $class->name }}</strong></td>
                                    <td><span class="badge bg-info">{{ $class->section }}</span></td>
                                    <td>{{ $class->teacher ? $class->teacher->user->name : 'Not assigned' }}</td>
                                    <td>{{ $class->students->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">This course is not assigned to any classes yet.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Courses
        </a>
    </div>
@endsection