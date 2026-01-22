@extends('teacher.layouts.app')

@section('title', 'Mark Attendance')
@section('page-title', 'Mark Attendance')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 card-title">
                        <i class="bi bi-calendar-check text-primary me-2"></i> Mark Daily Attendance
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Step 1: Select Class -->
                    <form action="{{ route('teacher.attendance.create') }}" method="GET" class="mb-4">
                        <div class="row align-items-center g-3">
                            <div class="col-md-8">
                                <label for="class_id" class="form-label visually-hidden">Select Class</label>
                                <select name="class_id" id="class_id" class="form-select form-select-lg"
                                    onchange="this.form.submit()">
                                    <option value="" selected disabled>-- Select Class to Mark Attendance --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ (isset($selectedClass) && $selectedClass->id == $class->id) ? 'selected' : '' }}>
                                            {{ $class->name }} (Section {{ $class->section }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 text-muted small">
                                Select a class to load the student list.
                            </div>
                        </div>
                    </form>

                    @if(isset($selectedClass))
                        <hr>

                        @if($alreadyMarked)
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2 fs-4"></i>
                                <div>
                                    <strong>Attendance Already Marked!</strong>
                                    <p class="mb-0">You have already submitted attendance for
                                        <strong>{{ $selectedClass->name }}</strong> for today ({{ now()->format('d M Y') }}). You
                                        cannot modify it.</p>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('teacher.attendance.index') }}" class="btn btn-primary">View Attendance
                                    History</a>
                            </div>
                        @else
                            <!-- Step 2: Mark Students -->
                            <form action="{{ route('teacher.attendance.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Date: <span class="fw-bold text-dark">{{ now()->format('l, d F Y') }}</span>
                                    </h6>
                                    <span class="badge bg-primary">{{ $students->count() }} Students</span>
                                </div>

                                <div class="table-responsive mb-4">
                                    <table class="table table-hover align-middle border">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Roll No</th>
                                                <th>Student Name</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $student)
                                                <tr>
                                                    <td><span class="fw-bold">#{{ $student->roll_number }}</span></td>
                                                    <td>
                                                        <div class="fw-bold">{{ $student->user->name }}</div>
                                                        <small class="text-muted">{{ $student->user->email }}</small>
                                                    </td>
                                                    <td class="text-center" style="width: 300px;">
                                                        <div class="btn-group" role="group" aria-label="Attendance Status">
                                                            <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]"
                                                                id="present_{{ $student->id }}" value="present" checked>
                                                            <label class="btn btn-outline-success"
                                                                for="present_{{ $student->id }}">Present</label>

                                                            <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]"
                                                                id="absent_{{ $student->id }}" value="absent">
                                                            <label class="btn btn-outline-danger"
                                                                for="absent_{{ $student->id }}">Absent</label>

                                                            <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]"
                                                                id="late_{{ $student->id }}" value="late">
                                                            <label class="btn btn-outline-warning"
                                                                for="late_{{ $student->id }}">Late</label>

                                                            <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]"
                                                                id="excused_{{ $student->id }}" value="excused">
                                                            <label class="btn btn-outline-info"
                                                                for="excused_{{ $student->id }}">Excused</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-light me-md-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-check-circle-fill me-2"></i> Submit Attendance
                                    </button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection