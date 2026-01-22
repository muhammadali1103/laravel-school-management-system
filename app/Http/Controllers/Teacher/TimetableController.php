<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(403, 'Teacher profile not found');
        }

        $timetableKeys = $teacher->timetables()
            ->with(['class', 'course'])
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('teacher.timetable.index', compact('timetableKeys', 'days'));
    }
}
