@extends('admin.layouts.app')

@section('title', 'Assign Fees')
@section('page-title', 'Assign Fees to Students')

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Assign Fees</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.fee-assignments.store') }}" method="POST" id="assignmentForm">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label class="form-label">Assignment Type <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="assignment_type" id="type_class"
                                        value="class" {{ old('assignment_type', 'class') == 'class' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_class">
                                        <strong>Assign to Entire Class</strong>
                                        <small class="d-block text-muted">Assign fees to all students in a class</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="assignment_type" id="type_individual"
                                        value="individual" {{ old('assignment_type') == 'individual' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_individual">
                                        <strong>Assign to Individual Student</strong>
                                        <small class="d-block text-muted">Assign fees to a specific student</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fee_structure_id" class="form-label">Fee Structure <span class="text-danger">*</span></label>
                            <select class="form-select @error('fee_structure_id') is-invalid @enderror" id="fee_structure_id"
                                name="fee_structure_id" required>
                                <option value="">Select Fee Structure</option>
                                @foreach($feeStructures as $structure)
                                    <option value="{{ $structure->id }}" data-amount="{{ $structure->amount }}"
                                        {{ old('fee_structure_id') == $structure->id ? 'selected' : '' }}>
                                        {{ $structure->name }} - PKR {{ number_format($structure->amount, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fee_structure_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6" id="class_field">
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                            <select class="form-select @error('class_id') is-invalid @enderror" id="class_id"
                                name="class_id">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }} {{ $class->section }} ({{ $class->students->count() }} students)
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6" id="student_field" style="display: none;">
                        <div class="mb-3">
                            <label for="student_search" class="form-label">Search Student (Roll No) <span class="text-danger">*</span></label>
                            <input class="form-control" list="student_options" id="student_search" placeholder="Type Roll Number or Name to search...">
                            <datalist id="student_options">
                                @foreach($students as $student)
                                    <option data-value="{{ $student->id }}" value="{{ $student->roll_number }} - {{ $student->user->name }}">
                                @endforeach
                            </datalist>
                            <input type="hidden" name="student_id" id="student_id">
                            @error('student_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount_percentage" class="form-label">Discount Percentage (Optional)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="100"
                                    class="form-control @error('discount_percentage') is-invalid @enderror"
                                    id="discount_percentage" name="discount_percentage"
                                    value="{{ old('discount_percentage', 0) }}" placeholder="0">
                                <span class="input-group-text">%</span>
                            </div>
                            @error('discount_percentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter 0 for no discount</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date"
                                name="due_date" value="{{ old('due_date') }}" required>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Preview:</strong>
                            <span id="preview_text">Select assignment type and fee structure to see preview</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Assign Fees
                    </button>
                    <a href="{{ route('admin.fee-assignments.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeClass = document.getElementById('type_class');
    const typeIndividual = document.getElementById('type_individual');
    const classField = document.getElementById('class_field');
    const studentField = document.getElementById('student_field');
    const feeStructureSelect = document.getElementById('fee_structure_id');
    const discountInput = document.getElementById('discount_percentage');
    const previewText = document.getElementById('preview_text');
    
    // Student Search Logic
    const studentSearchInput = document.getElementById('student_search');
    const studentHiddenInput = document.getElementById('student_id');
    const studentOptions = document.getElementById('student_options');

    studentSearchInput.addEventListener('input', function() {
        const val = this.value;
        const opts = studentOptions.childNodes;
        for (let i = 0; i < opts.length; i++) {
            if (opts[i].value === val) {
                studentHiddenInput.value = opts[i].getAttribute('data-value');
                break;
            } else {
                studentHiddenInput.value = ''; // Reset if no match
            }
        }
    });

    function toggleFields() {
        if (typeClass.checked) {
            classField.style.display = 'block';
            studentField.style.display = 'none';
            document.getElementById('class_id').required = true;
            studentSearchInput.required = false;
        } else {
            classField.style.display = 'none';
            studentField.style.display = 'block';
            document.getElementById('class_id').required = false;
            studentSearchInput.required = true;
        }
        updatePreview();
    }

    function updatePreview() {
        const selectedOption = feeStructureSelect.options[feeStructureSelect.selectedIndex];
        const amount = selectedOption.dataset.amount || 0;
        const discount = parseFloat(discountInput.value) || 0;
        const netAmount = amount - (amount * discount / 100);

        if (feeStructureSelect.value) {
            let text = `Fee Structure: ${selectedOption.text}`;
            if (discount > 0) {
                text += ` | Discount: ${discount}% | Net Amount: Rs. ${netAmount.toFixed(2)}`;
            } else {
                text += ` | Net Amount: Rs. ${netAmount.toFixed(2)}`; // Always show amount
            }
            previewText.textContent = text;
        } else {
            previewText.textContent = 'Select assignment type and fee structure to see preview';
        }
    }

    typeClass.addEventListener('change', toggleFields);
    typeIndividual.addEventListener('change', toggleFields);
    feeStructureSelect.addEventListener('change', updatePreview);
    discountInput.addEventListener('input', updatePreview);

    toggleFields();
    updatePreview();
});
</script>
@endsection
