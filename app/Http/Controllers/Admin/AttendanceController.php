<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('student.user', 'class', 'markedBy');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by student
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Filter by roll number
        if ($request->filled('roll_number')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('roll_number', 'like', '%' . $request->roll_number . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->query());

        // Get data for filters
        $classes = ClassModel::orderBy('name')->get();
        $students = Student::with('user')->orderBy('roll_number')->get();

        // Calculate statistics if filters are applied
        $stats = null;
        if ($request->hasAny(['date', 'class_id', 'student_id'])) {
            $statsQuery = clone $query;
            $stats = [
                'total' => $statsQuery->count(),
                'present' => $statsQuery->where('status', 'present')->count(),
                'absent' => $statsQuery->where('status', 'absent')->count(),
                'late' => $statsQuery->where('status', 'late')->count(),
            ];
        }

        return view('admin.attendance.index', compact('attendances', 'classes', 'students', 'stats'));
    }

    public function create()
    {
        $classes = ClassModel::with('students.user')->get();
        return view('admin.attendance.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late',
        ]);

        $class = ClassModel::findOrFail($validated['class_id']);

        foreach ($validated['attendance'] as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $validated['class_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $status,
                    'marked_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance marked successfully for ' . $class->students->count() . ' students.');
    }
}
