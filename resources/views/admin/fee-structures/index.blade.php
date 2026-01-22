@extends('admin.layouts.app')

@section('title', 'Fee Structures')
@section('page-title', 'Fee Structures')

@section('content')
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Fee Structures</h5>
            <a href="{{ route('admin.fee-structures.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create Fee Structure
            </a>
        </div>
        <div class="card-body">
            @if($feeStructures->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Class</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeStructures as $structure)
                                <tr>
                                    <td><strong>{{ $structure->name }}</strong></td>
                                    <td>{{ $structure->fee_type }}</td>
                                    <td>Rs. {{ number_format($structure->amount, 2) }}</td>
                                    <td>
                                        @if($structure->class)
                                            {{ $structure->class->name }} {{ $structure->class->section }}
                                        @else
                                            <span class="text-muted">All Classes</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($structure->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.fee-structures.edit', $structure) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.fee-structures.destroy', $structure) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this fee structure?');">
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
                    {{ $feeStructures->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No fee structures found.</p>
                    <a href="{{ route('admin.fee-structures.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Fee Structure
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection