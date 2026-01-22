@extends('teacher.layouts.app')

@section('title', 'My Students')
@section('page-title', 'My Students')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 card-title">
                <i class="bi bi-people text-primary me-2"></i> Assigned Students
            </h5>
        </div>
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Roll Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td><span class="badge bg-light text-dark border">{{ $student->roll_number }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2 bg-primary text-white small">
                                                {{ substr($student->user->name, 0, 1) }}
                                            </div>
                                            <div>{{ $student->user->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $student->user->email }}</td>
                                    <td>{{ $student->phone ?? 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" disabled title="View Details (Coming Soon)">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="text-muted">No students assigned.</h6>
                    <p class="text-muted small">You haven't been assigned any classes with students yet.</p>
                </div>
            @endif
        </div>
    </div>
@endsection