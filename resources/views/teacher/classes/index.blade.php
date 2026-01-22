@extends('teacher.layouts.app')

@section('title', 'My Classes')
@section('page-title', 'My Classes')

@section('content')
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Assigned Classes</h5>
        </div>
        <div class="card-body">
            @if($classes->count() > 0)
                <div class="row g-4">
                    @foreach($classes as $class)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title mb-1">{{ $class->name }}</h5>
                                            <span class="badge bg-light text-dark border">Section {{ $class->section }}</span>
                                        </div>
                                        <div class="rounded-circle p-2 bg-light-primary text-primary">
                                            <i class="bi bi-people-fill fs-5"></i>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between text-muted small mb-1">
                                            <span>Students</span>
                                            <span>{{ $class->students->count() }}</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <a href="{{ route('teacher.classes.show', $class->id) }}" class="btn btn-outline-primary">
                                            View Class Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-muted">No classes assigned yet</h5>
                    <p class="text-muted small">Contact the administrator if you believe this is an error.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 card-title">
                <i class="bi bi-book text-primary me-2"></i> Assigned Subjects
            </h5>
        </div>
        <div class="card-body">
            @if($courses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Subject Name</th>
                                <th>Code</th>
                                <th>Credits</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $course->name }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $course->code }}</span></td>
                                    <td>{{ $course->credits }}</td>
                                    <td class="text-muted small">{{ Str::limit($course->description, 50) ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <h6 class="text-muted">No subjects assigned directly.</h6>
                    <p class="small text-muted mb-0">Subjects are assigned via classes.</p>
                </div>
            @endif
        </div>
    </div>
@endsection