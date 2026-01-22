@extends('admin.layouts.app')

@section('title', 'Fee Details')
@section('page-title', 'Fee Preview')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-receipt"></i> Fee Invoice #{{ $fee->id }}
                    </h5>
                    <div>
                        @if($fee->status == 'paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif($fee->status == 'partial')
                            <span class="badge bg-info">Partial Payment</span>
                        @elseif($fee->status == 'overdue')
                            <span class="badge bg-danger">Overdue</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-uppercase text-muted fw-bold">Student Details</small>
                                <h5 class="mt-2 mb-1">{{ $fee->student->user->name }}</h5>
                                <p class="mb-0 text-muted">Roll No: <strong>{{ $fee->student->roll_number }}</strong></p>
                                @if($fee->student->classes->count() > 0)
                                    <p class="mb-0 text-muted">Class: {{ $fee->student->classes->first()->name }} -
                                        {{ $fee->student->classes->first()->section }}</p>
                                @endif
                            </div>
                            <div class="col-md-6 text-md-end">
                                <small class="text-uppercase text-muted fw-bold">Invoice Details</small>
                                <div class="mt-2">Due Date: <span
                                        class="fw-bold {{ \Carbon\Carbon::parse($fee->due_date)->isPast() && $fee->status != 'paid' ? 'text-danger' : '' }}">{{ \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') }}</span>
                                </div>
                                <div>Fee Type: {{ $fee->fee_type }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $fee->fee_type }}</td>
                                    <td class="text-end">Rs. {{ number_format($fee->amount, 2) }}</td>
                                </tr>
                                @if($fee->discount > 0)
                                    <tr class="text-success">
                                        <td>Discount</td>
                                        <td class="text-end">- Rs. {{ number_format($fee->discount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="fw-bold bg-light">
                                    <td>Net Payable Amount</td>
                                    <td class="text-end">Rs. {{ number_format($fee->amount - $fee->discount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @if($fee->remarks)
                                <div class="mb-3">
                                    <label class="fw-bold small text-uppercase text-muted">Remarks</label>
                                    <p class="mb-0">{{ $fee->remarks }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="card-title">Payment Summary</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Paid Amount:</span>
                                        <span class="fw-bold text-success">Rs.
                                            {{ number_format($fee->paid_amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Outstanding:</span>
                                        @php
                                            $outstanding = ($fee->amount - $fee->discount) - $fee->paid_amount;
                                        @endphp
                                        <span class="fw-bold {{ $outstanding > 0 ? 'text-danger' : 'text-success' }}">Rs.
                                            {{ number_format($outstanding, 2) }}</span>
                                    </div>
                                    @if($fee->paid_date)
                                        <hr class="my-2">
                                        <small class="text-muted d-block">Last Payment:
                                            {{ \Carbon\Carbon::parse($fee->paid_date)->format('M d, Y') }} via
                                            {{ ucfirst($fee->payment_method) }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                        <div>
                            <a href="{{ route('admin.fees.edit', $fee) }}" class="btn btn-warning text-white me-2">
                                <i class="bi bi-pencil"></i> Edit / Record Payment
                            </a>
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="bi bi-printer"></i> Print Invoice
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection