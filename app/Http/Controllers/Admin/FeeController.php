<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:fee.view')->only(['index', 'show']);
        $this->middleware('can:fee.create')->only(['create', 'store']);
        $this->middleware('can:fee.edit')->only(['edit', 'update', 'recordPayment']);
        $this->middleware('can:fee.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Fee::with('student.user', 'feeStructure');

        // Filter by student ID
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Filter by roll number
        if ($request->filled('roll_number')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('roll_number', 'like', '%' . $request->roll_number . '%');
            });
        }

        // Filter by class (via student's class)
        if ($request->filled('class_id')) {
            $query->whereHas('student.classes', function ($q) use ($request) {
                $q->where('classes.id', $request->class_id); // Explicit table name to avoid ambiguity
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by fee type
        if ($request->filled('fee_type')) {
            $query->where('fee_type', $request->fee_type);
        }

        $fees = $query->orderBy('due_date', 'desc')->paginate(20)->appends($request->query());
        $students = Student::with('user')->orderBy('roll_number')->get();
        $classes = \App\Models\ClassModel::orderBy('name')->get(); // Fetch classes for filter

        return view('admin.fees.index', compact('fees', 'students', 'classes'));
    }

    public function create()
    {
        $students = Student::with('user')->orderBy('roll_number')->get();
        $feeStructures = FeeStructure::where('is_active', true)->get();
        return view('admin.fees.create', compact('students', 'feeStructures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'fee_type' => 'required|string',
            'due_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $validated['paid_amount'] = 0;
        $validated['discount'] = $validated['discount'] ?? 0;
        $validated['status'] = 'pending';

        Fee::create($validated);

        return redirect()->route('admin.fees.index')->with('success', 'Fee record created successfully.');
    }

    public function edit(Fee $fee)
    {
        $students = Student::with('user')->get();
        $feeStructures = FeeStructure::where('is_active', true)->get();
        return view('admin.fees.edit', compact('fee', 'students', 'feeStructures'));
    }

    public function update(Request $request, Fee $fee)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'fee_type' => 'required|string',
            'due_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $validated['discount'] = $validated['discount'] ?? 0;

        $fee->update($validated);

        return redirect()->route('admin.fees.index')->with('success', 'Fee record updated successfully.');
    }

    public function show(Fee $fee)
    {
        return view('admin.fees.show', compact('fee'));
    }

    public function recordPayment(Request $request, Fee $fee)
    {
        $validated = $request->validate([
            'payment_amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank,online,cheque',
            'payment_date' => 'required|date',
            'payment_notes' => 'nullable|string',
        ]);

        $netAmount = $fee->amount - $fee->discount;
        $outstanding = $netAmount - $fee->paid_amount;

        // Prevent overpayment
        if ($validated['payment_amount'] > $outstanding) {
            return back()->withErrors(['payment_amount' => 'Payment amount cannot exceed outstanding balance.'])->withInput();
        }

        // Update paid amount
        $fee->paid_amount += $validated['payment_amount'];
        $fee->payment_method = $validated['payment_method'];
        $fee->paid_date = $validated['payment_date'];
        $fee->payment_notes = $validated['payment_notes'];

        // Update status based on payment
        if ($fee->paid_amount >= $netAmount) {
            $fee->status = 'paid';
        } elseif ($fee->paid_amount > 0) {
            $fee->status = 'partial';
        }

        $fee->save();

        return redirect()->route('admin.fees.edit', $fee)->with('success', 'Payment recorded successfully.');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return redirect()->route('admin.fees.index')->with('success', 'Fee record deleted successfully.');
    }
}
