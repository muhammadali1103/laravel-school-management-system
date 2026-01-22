@extends('admin.layouts.app')

@section('page-title', 'Roles & Permissions')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 fw-bold text-dark">Manage Roles</h5>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Add New Role
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Role Name</th>
                                    <th>Description</th>

                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        <td class="ps-4 fw-bold">
                                            @if($role->name === 'super_admin')
                                                Super Admin
                                            @else
                                                {{ $role->display_name }}
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($role->description, 50) }}</td>

                                        <td class="text-end pe-4">
                                            @if($role->name !== 'super_admin')
                                                <div class="btn-group gap-2">
                                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                        class="btn btn-sm btn-warning text-white" title="Edit Role & Permissions">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Role">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center gap-2 justify-content-end">
                                                    <a href="{{ route('admin.roles.permissions', $role->id) }}"
                                                        class="btn btn-sm btn-info text-white" title="View Permissions">
                                                        <i class="bi bi-eye"></i> View
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No roles found.</td>
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