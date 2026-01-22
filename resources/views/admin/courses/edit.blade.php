@extends('admin.layouts.app')

@section('title', 'Edit Course')
@section('page-title', 'Edit Course')

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Edit Course: {{ $course->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.courses.update', $course) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Course Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $course->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="code" class="form-label">Course Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                name="code" value="{{ old('code', $course->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="credits" class="form-label">Credits <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('credits') is-invalid @enderror" id="credits"
                                name="credits" value="{{ old('credits', $course->credits) }}" min="0" required>
                            @error('credits')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-bold">Assign Teachers</label>
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                @if($teachers->count() > 0)
                                    <div class="row g-3">
                                        @foreach($teachers as $teacher)
                                            <div class="col-md-4 col-lg-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="teacher_ids[]" 
                                                        value="{{ $teacher->id }}" id="teacher_{{ $teacher->id }}"
                                                        {{ (in_array($teacher->id, old('teacher_ids', $course->teachers->pluck('id')->toArray()))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="teacher_{{ $teacher->id }}">
                                                        {{ $teacher->user->name }}
                                                        <div class="text-muted small" style="font-size: 0.75rem;">{{ $teacher->qualification }}</div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">No teachers available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-info">
                        <i class="bi bi-save"></i> Update Course
                    </button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection