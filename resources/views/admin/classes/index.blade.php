@extends('admin.layouts.app')

@section('title', 'Manage Classes')
@section('page-title', 'Classes Management')

@section('content')
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Classes</h5>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-warning">
                <i class="bi bi-plus-circle"></i> Add New Class
            </a>
        </div>
        <div class="card-body">
            @if($classes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Class Name</th>
                                <th>Section</th>
                                <th>Class Teacher</th>
                                <th>Students</th>
                                <th>Capacity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                                <tr>
                                    <td><strong>{{ $class->name }}</strong></td>
                                    <td><span class="badge bg-info">{{ $class->section }}</span></td>
                                    <td>{{ $class->teacher ? $class->teacher->user->name : 'Not assigned' }}</td>
                                    <td>{{ $class->students_count }}</td>
                                    <td>{{ $class->capacity }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this class?');">
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
                    {{ $classes->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-door-open text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No classes found. Add your first class!</p>
                    <a href="{{ route('admin.classes.create') }}" class="btn btn-warning">
                        <i class="bi bi-plus-circle"></i> Add Class
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection