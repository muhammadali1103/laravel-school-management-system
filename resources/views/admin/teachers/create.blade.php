@extends('admin.layouts.app')

@section('title', 'Add Teacher')
@section('page-title', 'Add New Teacher')

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Add New Teacher</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.teachers.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 6 characters</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('employee_id') is-invalid @enderror"
                                id="employee_id" name="employee_id" value="{{ old('employee_id') }}" required
                                pattern="TCH\d{3}" placeholder="TCH001" title="Format: TCH001">
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone') }}" pattern="\d+"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="qualification" class="form-label">Qualification <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('qualification') is-invalid @enderror"
                                id="qualification" name="qualification" value="{{ old('qualification') }}" required>
                            @error('qualification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="subject_specialization" class="form-label">Subject Specialization <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject_specialization') is-invalid @enderror"
                                id="subject_specialization" name="subject_specialization"
                                value="{{ old('subject_specialization') }}" required>
                            @error('subject_specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="joining_date" class="form-label">Joining Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('joining_date') is-invalid @enderror"
                                id="joining_date" name="joining_date" value="{{ old('joining_date') }}" required>
                            @error('joining_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" rows="2" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
        </div>


    </div>

    <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-3">
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-light border px-4 fw-bold rounded-pill">
            Cancel
        </a>
        <button type="submit" class="btn btn-success px-5 fw-bold rounded-pill shadow-sm gradient-btn">
            <i class="bi bi-check-lg me-2"></i> Create
        </button>
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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
        }

        .gradient-btn:hover {
            background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
            transform: translateY(-1px);
        }

        .class-checkbox:checked+.class-card-content {
            border: 2px solid #56ab2f !important;
            background-color: #f0fff4;
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(86, 171, 47, 0.15) !important;
        }

        .class-selector-card:hover .class-card-content {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05) !important;
        }

        .class-checkbox:checked+.class-card-content .check-icon {
            display: block !important;
            color: #56ab2f !important;
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