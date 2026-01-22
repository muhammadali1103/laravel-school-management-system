<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        // Get student's class
        $class = $student->classes()->first();

        $timetableKeys = [];
        $timetable = collect();

        if ($class) {
            // Fetch timetable for the class
            $timetable = $class->timetables()
                ->with(['course', 'teacher.user'])
                ->orderBy('day')
                ->orderBy('start_time')
                ->get()
                ->groupBy('day');
        }

        return view('student.timetable.index', compact('timetable', 'class'));
    }
}
