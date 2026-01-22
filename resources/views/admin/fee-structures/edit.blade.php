@extends('admin.layouts.app')

@section('title', 'Edit Fee Structure')
@section('page-title', 'Edit Fee Structure')

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Edit Fee Structure</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.fee-structures.update', $feeStructure) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $feeStructure->name) }}" placeholder="e.g., Grade 9 Annual Tuition Fee" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fee_type" class="form-label">Fee Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('fee_type') is-invalid @enderror" id="fee_type"
                                name="fee_type" required>
                                <option value="">Select Fee Type</option>
                                <option value="Tuition Fee" {{ old('fee_type', $feeStructure->fee_type) == 'Tuition Fee' ? 'selected' : '' }}>Tuition Fee</option>
                                <option value="Admission Fee" {{ old('fee_type', $feeStructure->fee_type) == 'Admission Fee' ? 'selected' : '' }}>Admission Fee</option>
                                <option value="Transport Fee" {{ old('fee_type', $feeStructure->fee_type) == 'Transport Fee' ? 'selected' : '' }}>Transport Fee</option>
                                <option value="Laboratory Fee" {{ old('fee_type', $feeStructure->fee_type) == 'Laboratory Fee' ? 'selected' : '' }}>Laboratory Fee</option>
                                <option value="Library Fee" {{ old('fee_type', $feeStructure->fee_type) == 'Library Fee' ? 'selected' : '' }}>Library Fee</option>
                                <option value="Sports Fee" {{ old('fee_type', $feeStructure->fee_type) == 'Sports Fee' ? 'selected' : '' }}>Sports Fee</option>
                                <option value="Examination Fee" {{ old('fee_type', $feeStructure->fee_type) == 'Examination Fee' ? 'selected' : '' }}>Examination Fee</option>
                                <option value="Annual Fee" {{ old('fee_type', $feeStructure->fee_type) == 'Annual Fee' ? 'selected' : '' }}>Annual Fee</option>
                                <option value="Other" {{ old('fee_type', $feeStructure->fee_type) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('fee_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                id="amount" name="amount" value="{{ old('amount', $feeStructure->amount) }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Assign to Class (Optional)</label>
                            <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $feeStructure->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }} {{ $class->section }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave blank to make this available for all classes</small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3">{{ old('description', $feeStructure->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $feeStructure->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            <small class="text-muted">Only active fee structures can be assigned to students</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Fee Structure
                    </button>
                    <a href="{{ route('admin.fee-structures.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
