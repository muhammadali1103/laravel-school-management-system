<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $query = Timetable::with('class', 'course', 'teacher.user');

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by teacher
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        // Filter by day
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        $timetables = $query->orderBy('day')->orderBy('start_time')->paginate(20)->appends($request->query());
        $classes = ClassModel::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();

        return view('admin.timetables.index', compact('timetables', 'classes', 'teachers'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $courses = Course::all();
        $teachers = Teacher::with('user')->get();

        return view('admin.timetables.create', compact('classes', 'courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'nullable|string',
        ]);

        Timetable::create($validated);

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable entry created successfully.');
    }

    public function edit(Timetable $timetable)
    {
        $classes = ClassModel::all();
        $courses = Course::all();
        $teachers = Teacher::with('user')->get();

        return view('admin.timetables.edit', compact('timetable', 'classes', 'courses', 'teachers'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'nullable|string',
        ]);

        $timetable->update($validated);

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable entry updated successfully.');
    }

    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return redirect()->route('admin.timetables.index')->with('success', 'Timetable entry deleted successfully.');
    }
}
