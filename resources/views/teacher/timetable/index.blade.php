@extends('teacher.layouts.app')

@section('title', 'My Timetable')
@section('page-title', 'Weekly Timetable')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 card-title">
                <i class="bi bi-calendar-week text-primary me-2"></i> Weekly Schedule
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 150px;">Day</th>
                            <th>Schedule</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($days as $day)
                            <tr>
                                <td class="fw-bold bg-light">{{ $day }}</td>
                                <td>
                                    @if(isset($timetableKeys[$day]) && $timetableKeys[$day]->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($timetableKeys[$day] as $slot)
                                                <div class="p-2 border rounded bg-white shadow-sm" style="min-width: 200px;">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                            {{ $slot->start_time->format('h:i A') }} -
                                                            {{ $slot->end_time->format('h:i A') }}
                                                        </span>
                                                        <small class="text-muted fw-bold">{{ $slot->room ?? 'Room N/A' }}</small>
                                                    </div>
                                                    <div class="fw-bold text-dark">{{ $slot->course->name }}</div>
                                                    <div class="text-muted small">
                                                        {{ $slot->class->name }} ({{ $slot->class->section }})
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic small">No classes scheduled</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection