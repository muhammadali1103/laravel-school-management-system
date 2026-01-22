@extends('admin.layouts.app')

@section('title', 'Mark Attendance')
@section('page-title', 'Mark Attendance')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Mark Attendance</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.attendance.store') }}" method="POST" id="attendance-form">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Select Class <span class="text-danger">*</span></label>
                        <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id" required>
                            <option value="">Choose a class...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" data-students='@json($class->students)'>
                                    {{ $class->name }} - Section {{ $class->section }} ({{ $class->students->count() }} students)
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                               id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="students-list" class="border rounded p-3 mb-3">
                <p class="text-muted text-center mb-0">Please select a class to mark attendance</p>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                    <i class="bi bi-save"></i> Save Attendance
                </button>
                <button type="button" class="btn btn-success" id="mark-all-present" style="display:none;">
                    <i class="bi bi-check-circle"></i> Mark All Present
                </button>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
document.getElementById('class_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const studentsList = document.getElementById('students-list');
    const submitBtn = document.getElementById('submit-btn');
    const markAllBtn = document.getElementById('mark-all-present');
    
    if (!this.value) {
        studentsList.innerHTML = '<p class="text-muted text-center mb-0">Please select a class to mark attendance</p>';
        submitBtn.disabled = true;
        markAllBtn.style.display = 'none';
        return;
    }
    
    const students = JSON.parse(selectedOption.dataset.students || '[]');
    
    if (students.length === 0) {
        studentsList.innerHTML = '<p class="text-muted text-center mb-0">No students in this class</p>';
        submitBtn.disabled = true;
        markAllBtn.style.display = 'none';
        return;
    }
    
    let html = '<h6 class="mb-3">Mark Attendance for Students</h6>';
    html += '<div class="table-responsive">';
    html += '<table class="table table-sm table-hover">';
    html += '<thead><tr><th>Roll No.</th><th>Name</th><th>Present</th><th>Absent</th><th>Late</th></tr></thead>';
    html += '<tbody>';
    
    students.forEach(student => {
        html += `<tr>
            <td><strong>${student.roll_number}</strong></td>
            <td>${student.user.name}</td>
            <td><input type="radio" class="form-check-input" name="attendance[${student.id}]" value="present" checked required></td>
            <td><input type="radio" class="form-check-input" name="attendance[${student.id}]" value="absent"></td>
            <td><input type="radio" class="form-check-input" name="attendance[${student.id}]" value="late"></td>
        </tr>`;
    });
    
    html += '</tbody></table></div>';
    studentsList.innerHTML = html;
    submitBtn.disabled = false;
    markAllBtn.style.display = 'inline-block';
});

document.getElementById('mark-all-present').addEventListener('click', function() {
    document.querySelectorAll('input[type="radio"][value="present"]').forEach(radio => {
        radio.checked = true;
    });
});
</script>
@endsection
@endsection
