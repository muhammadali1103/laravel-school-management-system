@extends('teacher.layouts.app')

@section('title', 'Send Notification')
@section('page-title', 'Send New Notification')

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Compose Notification</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('teacher.notifications.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title') }}" required placeholder="e.g., Assignment Update">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="target_audience" class="form-label">Target Audience <span
                            class="text-danger">*</span></label>
                    <select class="form-select @error('target_audience') is-invalid @enderror" id="target_audience"
                        name="target_audience" required>
                        <option value="">Select Audience</option>
                        <option value="student" {{ old('target_audience') == 'student' ? 'selected' : '' }}>All Students
                        </option>
                        {{-- Teachers might not need to send to other Teachers, but keeping logic consistent with Admin for
                        now --}}
                        <option value="teacher" {{ old('target_audience') == 'teacher' ? 'selected' : '' }}>All Teachers
                        </option>
                    </select>
                    @error('target_audience')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                        rows="5" required placeholder="Type your message here...">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Send Notification
                    </button>
                    <a href="{{ route('teacher.notifications.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection