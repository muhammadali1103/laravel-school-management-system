@extends('admin.layouts.app')

@section('title', 'Manage Teachers')
@section('page-title', 'Teachers Management')

@section('content')
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Teachers</h5>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Teacher
            </a>
        </div>
        <div class="card-body">
            @if($teachers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Specialization</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td><strong>{{ $teacher->employee_id }}</strong></td>
                                    <td>{{ $teacher->user->name }}</td>
                                    <td>{{ $teacher->user->email }}</td>
                                    <td>{{ $teacher->subject_specialization ?? 'N/A' }}</td>
                                    <td>{{ $teacher->phone ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this teacher?');">
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
                    {{ $teachers->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-person-badge text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No teachers found. Add your first teacher!</p>
                    <a href="{{ route('admin.teachers.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add Teacher
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection