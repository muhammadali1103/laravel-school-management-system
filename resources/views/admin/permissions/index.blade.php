@extends('admin.layouts.app')

@section('page-title', 'Manage Permissions')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 fw-bold text-dark">Permissions List</h5>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Add New Permission
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Group</th>
                                    <th>Name (Internal)</th>
                                    <th>Display Name</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                    <tr>
                                        <td class="ps-4"><span
                                                class="badge bg-light text-dark border">{{ $permission->group }}</span></td>
                                        <td class="fw-bold small">{{ $permission->name }}</td>
                                        <td>{{ $permission->display_name }}</td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group gap-2">
                                                <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                                    class="btn btn-sm btn-warning text-white" title="Edit Permission">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                    method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        title="Delete Permission">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No permissions found.</td>
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