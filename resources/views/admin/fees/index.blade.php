@extends('admin.layouts.app')

@section('title', 'Fee Management')
@section('page-title', 'Fee Management')

@section('content')
    <div class="card mb-3">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-funnel"></i> Filter Fees</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.fees.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="roll_number" class="form-label">Roll Number</label>
                        <input type="text" class="form-control" id="roll_number" name="roll_number"
                            value="{{ request('roll_number') }}" placeholder="Search Roll No">
                    </div>
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="fee_type" class="form-label">Fee Type</label>
                        <input type="text" class="form-control" id="fee_type" name="fee_type"
                            value="{{ request('fee_type') }}" placeholder="e.g., Tuition">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Fee Records</h5>
            <a href="{{ route('admin.fees.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Fee Record
            </a>
        </div>
        <div class="card-body">
            @if($fees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Roll No.</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                                <tr>
                                    <td>{{ $fee->student->user->name }}</td>
                                    <td><strong>{{ $fee->student->roll_number }}</strong></td>
                                    <td>{{ $fee->fee_type }}</td>
                                    <td>Rs. {{ number_format($fee->amount, 2) }}</td>
                                    <td>Rs. {{ number_format($fee->paid_amount, 2) }}</td>
                                    <td>{{ $fee->due_date->format('M d, Y') }}</td>
                                    <td>
                                        @if($fee->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($fee->status == 'overdue')
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.fees.show', $fee) }}" class="btn btn-sm btn-info text-white"
                                                title="Preview">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.fees.edit', $fee) }}" class="btn btn-sm btn-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.fees.destroy', $fee) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this fee record?');">
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
                    {{ $fees->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-currency-dollar text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No fee records found.</p>
                    <a href="{{ route('admin.fees.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Fee Record
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection