<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        $totalAttendance = Attendance::where('student_id', $student->id)->count();
        $presentCount = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();

        $attendancePercentage = $totalAttendance > 0
            ? round(($presentCount / $totalAttendance) * 100, 2)
            : 0;

        $enrolledClasses = $student->classes()->withCount('students')->get();
        $enrolledCourses = $student->classes->flatMap->courses->unique('id');

        return view('student.dashboard', compact(
            'attendancePercentage',
            'totalAttendance',
            'presentCount',
            'enrolledClasses',
            'enrolledCourses'
        ));
    }
}
