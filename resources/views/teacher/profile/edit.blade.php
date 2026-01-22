@extends('teacher.layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 card-title">
                        <i class="bi bi-person-gear text-primary me-2"></i> Update Profile
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('teacher.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Read-Only Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">Basic Information (Read Only)</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Full Name</label>
                                <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Email Address</label>
                                <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Employee ID</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $teacher->employee_id ?? 'N/A' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Joining Date</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $teacher->joining_date ? $teacher->joining_date->format('d M Y') : 'N/A' }}"
                                    readonly>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Editable Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary text-uppercase small fw-bold mb-3">Contact Information</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $teacher->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" id="address" rows="2"
                                    class="form-control @error('address') is-invalid @enderror">{{ old('address', $teacher->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Password Change -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-danger text-uppercase small fw-bold mb-3">Change Password (Optional)</h6>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Required only if you are changing your password.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" name="new_password" id="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection