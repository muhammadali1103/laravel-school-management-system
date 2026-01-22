@extends('admin.layouts.app')

@section('title', 'Edit Class')
@section('page-title', 'Edit Class')

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Edit Class: {{ $class->name }} - {{ $class->section }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.classes.update', $class) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Class Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $class->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="section" class="form-label">Section <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('section') is-invalid @enderror" id="section"
                                name="section" value="{{ old('section', $class->section) }}" required>
                            @error('section')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="teacher_id" class="form-label">Class Teacher</label>
                            <select class="form-select @error('teacher_id') is-invalid @enderror" id="teacher_id"
                                name="teacher_id">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $class->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name }} ({{ $teacher->employee_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity"
                                name="capacity" value="{{ old('capacity', $class->capacity) }}" min="1" required>
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-bold">Assign Courses</label>
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                @if($courses->count() > 0)
                                    <div class="row g-3">
                                        @foreach($courses as $course)
                                            <div class="col-md-4 col-lg-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="course_ids[]" 
                                                        value="{{ $course->id }}" id="course_{{ $course->id }}"
                                                        {{ (in_array($course->id, old('course_ids', $class->courses->pluck('id')->toArray()))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="course_{{ $course->id }}">
                                                        {{ $course->name }} <span class="text-muted small">({{ $course->code }})</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">No courses available. Please create courses first.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Update Class
                    </button>
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection