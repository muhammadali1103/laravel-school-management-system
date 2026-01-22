@extends('admin.layouts.app')

@section('page-title', isset($permission) ? 'Edit Permission' : 'Create Permission')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">{{ isset($permission) ? 'Edit Permission' : 'Add New Permission' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($permission) ? route('admin.permissions.update', $permission->id) : route('admin.permissions.store') }}"
                        method="POST">
                        @csrf
                        @if(isset($permission))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="group" class="form-label">Permission Group <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('group') is-invalid @enderror" id="group"
                                name="group" value="{{ old('group', $permission->group ?? '') }}" required
                                placeholder="e.g. Student, Teacher, Library">
                            <div class="form-text">Used to group permissions in the assignment view.</div>
                            @error('group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name (Internal Identifier) <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $permission->name ?? '') }}" required
                                placeholder="e.g. student_view_marks">
                            <div class="form-text">Must be unique, lowercase, no spaces (use underscores).</div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="display_name" class="form-label">Display Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('display_name') is-invalid @enderror"
                                id="display_name" name="display_name"
                                value="{{ old('display_name', $permission->display_name ?? '') }}" required
                                placeholder="e.g. View Student Marks">
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($permission) ? 'Update Permission' : 'Create Permission' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection