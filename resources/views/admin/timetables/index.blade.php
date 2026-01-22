@extends('admin.layouts.app')

@section('title', 'Timetable Management')
@section('page-title', 'Timetable Management')

@section('content')
    <div class="card mb-3">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-funnel"></i> Filter Timetable</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.timetables.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-select" id="class_id" name="class_id">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} - {{ $class->section }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="teacher_id" class="form-label">Teacher</label>
                        <select class="form-select" id="teacher_id" name="teacher_id">
                            <option value="">All Teachers</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="day" class="form-label">Day</label>
                        <select class="form-select" id="day" name="day">
                            <option value="">All Days</option>
                            <option value="Monday" {{ request('day') == 'Monday' ? 'selected' : '' }}>Monday</option>
                            <option value="Tuesday" {{ request('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="Wednesday" {{ request('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="Thursday" {{ request('day') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="Friday" {{ request('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                            <option value="Saturday" {{ request('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="Sunday" {{ request('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.timetables.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Class Schedules</h5>
            <a href="{{ route('admin.timetables.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Schedule
            </a>
        </div>
        <div class="card-body">
            @if($timetables->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Class</th>
                                <th>Course</th>
                                <th>Teacher</th>
                                <th>Room</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($timetables as $timetable)
                                <tr>
                                    <td><strong>{{ $timetable->day }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($timetable->start_time)->format('g:i A') }} -
                                        {{ \Carbon\Carbon::parse($timetable->end_time)->format('g:i A') }}
                                    </td>
                                    <td>{{ $timetable->class->name }} - {{ $timetable->class->section }}</td>
                                    <td>{{ $timetable->course->name }}</td>
                                    <td>{{ $timetable->teacher->user->name }}</td>
                                    <td>{{ $timetable->room ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.timetables.edit', $timetable) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.timetables.destroy', $timetable) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this schedule?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $timetables->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar3 text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No timetable entries found.</p>
                    <a href="{{ route('admin.timetables.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add Schedule
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection