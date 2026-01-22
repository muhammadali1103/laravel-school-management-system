@extends('admin.layouts.app')

@section('page-title', 'User Management')

@section('styles')
<style>
    .btn-premium {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border: none;
        color: white;
        font-weight: 500;
        transition: all 0.2s ease;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
    }
    
    .btn-premium:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2), 0 4px 6px -2px rgba(79, 70, 229, 0.1);
        color: white;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-12 col-md-auto">
                            <h5 class="mb-0 fw-bold text-dark">Users</h5>
                        </div>
                        <div class="col-12 col-md-auto">
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <form action="{{ route('admin.users.index') }}" method="GET"
                                    class="d-flex gap-2 flex-grow-1 flex-md-grow-0">
                                    <select name="role" class="form-select form-select-sm" style="width: 140px;"
                                        onchange="this.form.submit()">
                                        <option value="">All Roles</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                                {{ $role->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group input-group-sm" style="width: 200px;">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Search..." value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit"><i
                                                class="bi bi-search"></i></button>
                                    </div>
                                </form>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-premium btn-sm rounded-pill px-4 py-2">
                                    <i class="bi bi-plus-lg me-1"></i>Add New User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">User</th>
                                    <th>Email</th>
                                    <th>Current Role</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td class="ps-4 fw-bold">
                                            {{ $user->name }}
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role->name === 'super_admin')
                                                <span class="badge bg-primary text-white">Super Admin</span>
                                            @else
                                                <span class="badge bg-light text-dark border">{{ $user->role->display_name ?? 'No Role' }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group gap-2">
                                                @can('user.edit')
                                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                       class="btn btn-sm btn-warning text-white" 
                                                       title="Edit User">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endcan
                                                @can('user.delete')
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete User">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection