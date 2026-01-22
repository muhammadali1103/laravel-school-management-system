@extends('student.layouts.app')

@section('title', 'My Fees')
@section('page-title', 'My Fees')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 card-title">
                <i class="bi bi-wallet2 text-success me-2"></i> Fee History
            </h5>
        </div>
        <div class="card-body">
            @if($fees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Due Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                                <tr>
                                    <td>{{ $fee->due_date ? $fee->due_date->format('d M, Y') : 'N/A' }}</td>
                                    <td>{{ ucfirst($fee->fee_type) }}</td>
                                    <td>Rs. {{ number_format($fee->net_amount, 2) }}</td>
                                    <td>Rs. {{ number_format($fee->paid_amount, 2) }}</td>
                                    <td>
                                        <span class="{{ $fee->outstanding_balance > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                            Rs. {{ number_format($fee->outstanding_balance, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($fee->status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($fee->status === 'partial')
                                            <span class="badge bg-warning text-dark">Partial</span>
                                        @else
                                            <span class="badge bg-danger">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-wallet2 text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="text-muted">No fee records found.</h6>
                    <p class="text-muted small">You don't have any invoices generated yet.</p>
                </div>
            @endif
        </div>
    </div>
@endsection