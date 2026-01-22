@extends('admin.layouts.app')

@section('title', 'Manage Courses')
@section('page-title', 'Courses Management')

@section('content')
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Courses</h5>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-info">
                <i class="bi bi-plus-circle"></i> Add New Course
            </a>
        </div>
        <div class="card-body">
            @if($courses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Course Name</th>
                                <th>Credits</th>
                                <th>Classes</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td><strong>{{ $course->code }}</strong></td>
                                    <td>{{ $course->name }}</td>
                                    <td><span class="badge bg-primary">{{ $course->credits }}</span></td>
                                    <td>{{ $course->classes_count }}</td>
                                    <td>{{ Str::limit($course->description, 50) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this course?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $courses->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No courses found. Add your first course!</p>
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-info">
                        <i class="bi bi-plus-circle"></i> Add Course
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection