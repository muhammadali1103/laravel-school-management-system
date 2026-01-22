<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        $attendances = Attendance::where('student_id', $student->id)
            ->with('class')
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('student.attendance.index', compact('attendances'));
    }
}
