@extends('admin.layouts.app')

@section('title', 'Edit Fee Record')
@section('page-title', 'Edit Fee Record')

@section('content')
    <div class="row">
        {{-- Fee Information Card --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Edit Fee Record: {{ $fee->student->user->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.fees.update', $fee) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                                    <select class="form-select @error('student_id') is-invalid @enderror" id="student_id"
                                        name="student_id" required>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ $fee->student_id == $student->id ? 'selected' : '' }}>
                                                {{ $student->roll_number }} - {{ $student->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fee_type" class="form-label">Fee Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('fee_type') is-invalid @enderror" id="fee_type"
                                        name="fee_type" value="{{ old('fee_type', $fee->fee_type) }}" required>
                                    @error('fee_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Total Amount <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                        id="amount" name="amount" value="{{ old('amount', $fee->amount) }}" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Discount</label>
                                    <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror"
                                        id="discount" name="discount" value="{{ old('discount', $fee->discount) }}">
                                    @error('discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date"
                                        name="due_date" value="{{ old('due_date', $fee->due_date->format('Y-m-d')) }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks"
                                        name="remarks" rows="2">{{ old('remarks', $fee->remarks) }}</textarea>
                                    @error('remarks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Fee Record
                            </button>
                            <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Payment Recording Card --}}
        <div class="col-md-5">
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Payment Summary</h5>
                </div>
                <div class="card-body">
                    @php
                        $netAmount = $fee->amount - $fee->discount;
                        $outstanding = $netAmount - $fee->paid_amount;
                    @endphp

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Amount:</span>
                            <strong>Rs. {{ number_format($fee->amount, 2) }}</strong>
                        </div>
                        @if($fee->discount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount:</span>
                                <strong>-Rs. {{ number_format($fee->discount, 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Net Amount:</span>
                                <strong>Rs. {{ number_format($netAmount, 2) }}</strong>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-2 text-primary">
                            <span>Paid Amount:</span>
                            <strong>Rs. {{ number_format($fee->paid_amount, 2) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Outstanding Balance:</span>
                            <strong class="{{ $outstanding > 0 ? 'text-danger' : 'text-success' }}">
                                Rs. {{ number_format($outstanding, 2) }}
                            </strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status:</label>
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

                    @if($fee->payment_method)
                        <div class="mb-2">
                            <small class="text-muted">Last Payment Method:</small>
                            <div><strong>{{ ucfirst($fee->payment_method) }}</strong></div>
                        </div>
                    @endif

                    @if($fee->paid_date)
                        <div class="mb-2">
                            <small class="text-muted">Last Payment Date:</small>
                            <div>{{ $fee->paid_date->format('M d, Y') }}</div>
                        </div>
                    @endif
                </div>
            </div>

            @if($outstanding > 0)
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Record Payment</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.fees.record-payment', $fee) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="payment_amount" class="form-label">Payment Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rs.</span>
                                    <input type="number" step="0.01" max="{{ $outstanding }}"
                                        class="form-control @error('payment_amount') is-invalid @enderror"
                                        id="payment_amount" name="payment_amount"
                                        value="{{ old('payment_amount', $outstanding) }}" required>
                                </div>
                                @error('payment_amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Max: Rs. {{ number_format($outstanding, 2) }}</small>
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_method') is-invalid @enderror"
                                    id="payment_method" name="payment_method" required>
                                    <option value="">Select Method</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                                    <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('payment_date') is-invalid @enderror"
                                    id="payment_date" name="payment_date"
                                    value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="payment_notes" class="form-label">Notes (Optional)</label>
                                <textarea class="form-control @error('payment_notes') is-invalid @enderror"
                                    id="payment_notes" name="payment_notes" rows="2">{{ old('payment_notes') }}</textarea>
                                @error('payment_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-cash-coin"></i> Record Payment
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
