@extends('admin.layouts.app')

@section('title', 'Edit Teacher')
@section('page-title', 'Edit Teacher')

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Edit Teacher: {{ $teacher->user->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $teacher->user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $teacher->user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('employee_id') is-invalid @enderror"
                                id="employee_id" name="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}"
                                required>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone', $teacher->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="qualification" class="form-label">Qualification</label>
                            <input type="text" class="form-control @error('qualification') is-invalid @enderror"
                                id="qualification" name="qualification"
                                value="{{ old('qualification', $teacher->qualification) }}">
                            @error('qualification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="subject_specialization" class="form-label">Subject Specialization</label>
                            <input type="text" class="form-control @error('subject_specialization') is-invalid @enderror"
                                id="subject_specialization" name="subject_specialization"
                                value="{{ old('subject_specialization', $teacher->subject_specialization) }}">
                            @error('subject_specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="joining_date" class="form-label">Joining Date</label>
                            <input type="date" class="form-control @error('joining_date') is-invalid @enderror"
                                id="joining_date" name="joining_date"
                                value="{{ old('joining_date', $teacher->joining_date ? $teacher->joining_date->format('Y-m-d') : '') }}">
                            @error('joining_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" rows="2">{{ old('address', $teacher->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

        </div>

        <!-- Security Settings & Actions -->
        <div class="row mt-2">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="card-title fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span class="p-1 rounded bg-success bg-opacity-10 text-success"><i
                                    class="bi bi-shield-check"></i></span>
                            Security & Actions
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold text-secondary small text-uppercase">New
                                    Password</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="bi bi-key"></i></span>
                                    <input type="password"
                                        class="form-control border-start-0 ps-0 bg-light @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Leave blank to keep current">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation"
                                    class="form-label fw-bold text-secondary small text-uppercase">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="bi bi-check-all"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-0 bg-light"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirm new password">
                                </div>
                            </div>

                            <div class="col-12 border-top pt-4 d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.teachers.index') }}"
                                    class="btn btn-light border px-4 fw-bold rounded-pill">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="btn btn-primary px-5 fw-bold rounded-pill shadow-sm gradient-btn">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    </div>
@endsection

@section('styles')
    <style>
        .transition-all {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .gradient-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .gradient-btn:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-1px);
        }

        .class-checkbox:checked+.class-card-content {
            border: 2px solid #667eea !important;
            background-color: #f8f9ff;
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.15) !important;
        }

        .class-selector-card:hover .class-card-content {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05) !important;
        }

        .class-checkbox:checked+.class-card-content .check-icon {
            display: block !important;
            animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endsection