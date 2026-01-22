<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeeStructure;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Fee::with(['student.user', 'feeStructure']);

        // Filter by class
        if ($request->filled('class_id')) {
            $query->whereHas('student.classes', function ($q) use ($request) {
                $q->where('classes.id', $request->class_id);
            });
        }

        // Filter by fee structure
        if ($request->filled('fee_structure_id')) {
            $query->where('fee_structure_id', $request->fee_structure_id);
        }

        $assignments = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());
        $classes = ClassModel::all();
        $feeStructures = FeeStructure::where('is_active', true)->get();

        return view('admin.fee-assignments.index', compact('assignments', 'classes', 'feeStructures'));
    }

    public function create()
    {
        $classes = ClassModel::with('students.user')->get();
        $students = Student::with('user')->orderBy('roll_number')->get();
        $feeStructures = FeeStructure::where('is_active', true)->get();

        return view('admin.fee-assignments.create', compact('classes', 'students', 'feeStructures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_type' => 'required|in:class,individual',
            'fee_structure_id' => 'required|exists:fee_structures,id',
            'class_id' => 'required_if:assignment_type,class|nullable|exists:classes,id',
            'student_id' => 'required_if:assignment_type,individual|nullable|exists:students,id',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'due_date' => 'required|date',
        ]);

        $feeStructure = FeeStructure::findOrFail($validated['fee_structure_id']);
        $discountPercentage = $validated['discount_percentage'] ?? 0;

        DB::beginTransaction();
        try {
            if ($validated['assignment_type'] === 'class') {
                // Assign to all students in the class
                $class = ClassModel::with('students')->findOrFail($validated['class_id']);
                $assignedCount = 0;

                foreach ($class->students as $student) {
                    $this->createFeeRecord($student, $feeStructure, $discountPercentage, $validated['due_date']);
                    $assignedCount++;
                }

                DB::commit();
                return redirect()->route('admin.fee-assignments.index')
                    ->with('success', "Fee assigned to {$assignedCount} students in {$class->name} {$class->section}.");
            } else {
                // Assign to individual student
                $student = Student::findOrFail($validated['student_id']);
                $this->createFeeRecord($student, $feeStructure, $discountPercentage, $validated['due_date']);

                DB::commit();
                return redirect()->route('admin.fee-assignments.index')
                    ->with('success', 'Fee assigned to student successfully.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to assign fees: ' . $e->getMessage()])->withInput();
        }
    }

    private function createFeeRecord(Student $student, FeeStructure $feeStructure, float $discountPercentage, string $dueDate)
    {
        $discount = ($feeStructure->amount * $discountPercentage) / 100;

        Fee::create([
            'fee_structure_id' => $feeStructure->id,
            'student_id' => $student->id,
            'amount' => $feeStructure->amount,
            'discount' => $discount,
            'paid_amount' => 0,
            'due_date' => $dueDate,
            'status' => 'pending',
            'fee_type' => $feeStructure->fee_type,
        ]);
    }
}
