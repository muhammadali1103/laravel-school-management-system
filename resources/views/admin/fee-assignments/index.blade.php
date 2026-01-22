@extends('admin.layouts.app')

@section('title', 'Fee Assignments')
@section('page-title', 'Fee Assignments')

@section('content')
    <div class="card mb-3">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-funnel"></i> Filter Assignments</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.fee-assignments.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-select" id="class_id" name="class_id">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} {{ $class->section }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="fee_structure_id" class="form-label">Fee Structure</label>
                        <select class="form-select" id="fee_structure_id" name="fee_structure_id">
                            <option value="">All Fee Structures</option>
                            @foreach($feeStructures as $structure)
                                <option value="{{ $structure->id }}" {{ request('fee_structure_id') == $structure->id ? 'selected' : '' }}>
                                    {{ $structure->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.fee-assignments.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Fee Assignments</h5>
            <a href="{{ route('admin.fee-assignments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Assign Fees
            </a>
        </div>
        <div class="card-body">
            @if($assignments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Roll No.</th>
                                <th>Fee Structure</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Net Amount</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->student->user->name }}</td>
                                    <td><strong>{{ $assignment->student->roll_number }}</strong></td>
                                    <td>
                                        @if($assignment->feeStructure)
                                            {{ $assignment->feeStructure->name }}
                                        @else
                                            <span class="text-muted">{{ $assignment->fee_type }}</span>
                                        @endif
                                    </td>
                                    <td>Rs. {{ number_format($assignment->amount, 2) }}</td>
                                    <td>
                                        @if($assignment->discount > 0)
                                            <span class="text-success">-Rs. {{ number_format($assignment->discount, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><strong>Rs. {{ number_format($assignment->amount - $assignment->discount, 2) }}</strong>
                                    </td>
                                    <td>{{ $assignment->due_date->format('M d, Y') }}</td>
                                    <td>
                                        @if($assignment->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($assignment->status == 'partial')
                                            <span class="badge bg-info">Partial</span>
                                        @elseif($assignment->status == 'overdue')
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $assignments->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-check text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No fee assignments found.</p>
                    <a href="{{ route('admin.fee-assignments.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Assign Fees
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection