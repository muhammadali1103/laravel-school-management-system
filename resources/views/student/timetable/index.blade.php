@extends('student.layouts.app')

@section('title', 'My Timetable')
@section('page-title', 'Class Timetable')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($class)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 text-center">
                        <h4 class="mb-1 text-primary fw-bold">{{ $class->name }}</h4>
                        <p class="text-muted mb-0">Section {{ $class->section }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 card-title">
                            <i class="bi bi-table text-primary me-2"></i> Weekly Schedule
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 15%;">Day</th>
                                        <th>Schedule</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                    @endphp
                                    @foreach($days as $day)
                                        <tr>
                                            <td class="align-middle text-center bg-light fw-bold text-muted">{{ $day }}</td>
                                            <td class="p-3">
                                                @if(isset($timetable[$day]))
                                                    <div class="row g-3">
                                                        @foreach($timetable[$day] as $slot)
                                                            <div class="col-md-4 col-lg-3">
                                                                <div class="p-3 border rounded shadow-sm h-100 position-relative border-start border-4 border-start-primary"
                                                                    style="background: #f8fafc; border-left-color: #0d6efd !important;">
                                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                                        <span
                                                                            class="badge bg-primary-subtle text-primary rounded-pill">{{ $slot->start_time->format('h:i A') }}
                                                                            - {{ $slot->end_time->format('h:i A') }}</span>
                                                                    </div>
                                                                    <h6 class="fw-bold text-dark mb-1">{{ $slot->course->name }}</h6>
                                                                    <small class="text-muted d-block mb-1">
                                                                        <i class="bi bi-person me-1"></i>
                                                                        {{ $slot->teacher->user->name ?? 'N/A' }}
                                                                    </small>
                                                                    <small class="text-muted">
                                                                        <i class="bi bi-geo-alt me-1"></i> {{ $slot->room ?? 'N/A' }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="text-muted text-center py-2 small">
                                                        <i class="bi bi-dash-circle me-1"></i> No classes scheduled
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-exclamation-circle text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-muted">No Class Assigned</h5>
                    <p class="text-muted small">You are not currently assigned to any class. Please contact the administrator.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection