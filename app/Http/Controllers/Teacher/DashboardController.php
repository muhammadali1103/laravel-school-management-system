<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(403, 'Teacher profile not found');
        }

        // Stats
        $assignedClassesCount = $teacher->classes()->count();
        $assignedSubjectsCount = $teacher->courses()->count();

        // Today's Timetable
        $today = now()->format('l'); // e.g., Monday
        $todaysTimetable = $teacher->timetables()
            ->where('day', $today)
            ->with(['class', 'course'])
            ->orderBy('start_time')
            ->get();

        // Attendance Status (for classes where they are the Class Teacher)
        $myClassesIds = $teacher->classes()->pluck('id');
        $attendanceMarkedCount = Attendance::whereIn('class_id', $myClassesIds)
            ->whereDate('date', today())
            ->distinct('class_id')
            ->count('class_id');

        $pendingAttendanceCount = $myClassesIds->count() - $attendanceMarkedCount;

        return view('teacher.dashboard', compact(
            'assignedClassesCount',
            'assignedSubjectsCount',
            'todaysTimetable',
            'pendingAttendanceCount'
        ));
    }
}
