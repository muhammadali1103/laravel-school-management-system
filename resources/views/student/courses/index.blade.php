@extends('student.layouts.app')

@section('title', 'My Courses')
@section('page-title', 'Enrolled Courses')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 card-title">
                        <i class="bi bi-book text-primary me-2"></i> Current Semester Courses
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Code</th>
                                    <th>Credits</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrolledCourses as $course)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $course->name }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $course->code }}</span></td>
                                        <td>{{ $course->credits }}</td>
                                        <td class="text-muted small">{{ Str::limit($course->description, 60) ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="mb-3">
                                                <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                            <h5 class="text-muted">No Courses Found</h5>
                                            <p class="text-muted small">You are not enrolled in any courses for this semester.
                                            </p>
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