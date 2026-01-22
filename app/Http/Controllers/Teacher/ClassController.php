<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(403, 'Teacher profile not found');
        }

        // Fetch classes where the teacher is the assigned CLASS TEACHER
        $assignedClasses = $teacher->classes()->with(['students.user'])->get();

        // NOTE: User requested to ONLY show assigned classes (Class Teacher), not timetable classes.
        // Fetch classes where the teacher is the assigned CLASS TEACHER
        $classes = $teacher->classes()->with(['students.user'])->get();

        /*
        // NOTE: User requested to ONLY show assigned classes (Class Teacher), not timetable classes.
        // Keeping this logic commented out in case we need to revert back later.

        // Fetch classes where the teacher has TIMETABLE entries (Subject Teacher)
        $timetableClasses = \App\Models\ClassModel::whereHas('timetables', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with(['students.user'])->get();

        // Merge and remove duplicates
        $classes = $assignedClasses->merge($timetableClasses)->unique('id');
        */


        $courses = $teacher->courses;

        return view('teacher.classes.index', compact('classes', 'courses'));
    }

    public function show(ClassModel $class)
    {
        $teacher = auth()->user()->teacher;

        // Authorization: Check if teacher is assigned to this class OR teaches a subject in this class
        $isClassTeacher = $class->teacher_id === $teacher->id;
        $hasTimetable = $class->timetables()->where('teacher_id', $teacher->id)->exists();

        if (!$isClassTeacher && !$hasTimetable) {
            abort(403, 'You are not assigned to this class.');
        }

        $class->load(['students.user']);

        return view('teacher.classes.show', compact('class'));
    }
}
