<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        // Fetch attendance records marked by this teacher, grouped by date and class
        $attendanceHistory = \App\Models\Attendance::where('marked_by', auth()->id())
            ->with(['class'])
            ->selectRaw('date, class_id, count(*) as total, sum(case when status = "present" then 1 else 0 end) as present, sum(case when status = "absent" then 1 else 0 end) as absent')
            ->groupBy('date', 'class_id')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('teacher.attendance.index', compact('attendanceHistory'));
    }

    public function create(Request $request)
    {
        $teacher = auth()->user()->teacher;
        $classes = $teacher->classes;

        $selectedClass = null;
        $students = [];
        $alreadyMarked = false;

        if ($request->has('class_id')) {
            $classId = $request->get('class_id');
            // Verify ownership
            $selectedClass = $classes->firstWhere('id', $classId);

            if ($selectedClass) {
                // Check if already marked for today
                $exists = \App\Models\Attendance::where('class_id', $classId)
                    ->where('date', today())
                    ->exists();

                if ($exists) {
                    $alreadyMarked = true;
                } else {
                    $students = $selectedClass->students()->with('user')->get();
                }
            }
        }

        return view('teacher.attendance.create', compact('classes', 'selectedClass', 'students', 'alreadyMarked'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late,excused',
        ]);

        $teacher = auth()->user()->teacher;
        $class = $teacher->classes()->findOrFail($request->class_id);

        // Double check if already marked
        if (\App\Models\Attendance::where('class_id', $class->id)->where('date', today())->exists()) {
            return back()->with('error', 'Attendance for this class has already been marked for today.');
        }

        foreach ($request->attendance as $studentId => $status) {
            \App\Models\Attendance::create([
                'student_id' => $studentId,
                'class_id' => $class->id,
                'date' => today(),
                'status' => $status,
                'marked_by' => auth()->id(),
            ]);
        }

        return redirect()->route('teacher.dashboard')->with('success', 'Attendance marked successfully.');
    }
}
