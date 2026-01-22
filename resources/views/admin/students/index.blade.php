@extends('admin.layouts.app')

@section('title', 'Manage Students')
@section('page-title', 'Students Management')

@section('content')
    <div class="card">
        <div class="card-header bg-white py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3 w-100 w-md-auto">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Student Directory</h5>
                        <p class="text-muted small mb-0">Manage and track all students</p>
                    </div>
                </div>
                
                <div class="d-flex flex-column flex-sm-row gap-3 w-100 w-md-auto align-items-center">
                    <form action="{{ route('admin.students.index') }}" method="GET" class="position-relative w-100 flex-grow-1" style="min-width: 250px;">
                        <input type="text" name="search" class="form-control rounded-pill ps-5 bg-light border-0 py-2" 
                               placeholder="Search Name/Roll..." value="{{ request('search') }}">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        @if(request('search'))
                            <a href="{{ route('admin.students.index') }}" class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted">
                                <i class="bi bi-x-circle-fill"></i>
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('admin.students.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2 text-nowrap w-100 w-sm-auto justify-content-center">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Add Student</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Classes</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td><strong>{{ $student->roll_number }}</strong></td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->user->email }}</td>
                                    <td>
                                        @foreach($student->classes as $class)
                                            <span class="badge bg-info">{{ $class->name }} - {{ $class->section }}</span>
                                        @endforeach
                                        @if($student->classes->count() == 0)
                                            <span class="text-muted">No classes</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->phone ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this student?');">
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

                <div class="mt-3 d-flex justify-content-center">
                    {{ $students->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No students found. Add your first student!</p>
                    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Student
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection