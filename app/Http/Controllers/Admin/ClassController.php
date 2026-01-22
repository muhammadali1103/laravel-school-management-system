<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::with('teacher.user')->withCount('students')->paginate(15);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Cache::remember('all_teachers_with_user', 60 * 60, function () {
            return Teacher::with('user')->get();
        });

        $courses = Cache::remember('all_courses', 60 * 60, function () {
            return Course::all();
        });

        return view('admin.classes.create', compact('teachers', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:10',
            'teacher_id' => 'nullable|exists:teachers,id',
            'capacity' => 'required|integer|min:1',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $class = ClassModel::create($validated);

        if (!empty($validated['course_ids'])) {
            $class->courses()->sync($validated['course_ids']);
        }

        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    public function show(ClassModel $class)
    {
        $class->load('teacher.user', 'students.user', 'courses');
        return view('admin.classes.show', compact('class'));
    }

    public function edit(ClassModel $class)
    {
        $teachers = Cache::remember('all_teachers_with_user', 60 * 60, function () {
            return Teacher::with('user')->get();
        });

        $courses = Cache::remember('all_courses', 60 * 60, function () {
            return Course::all();
        });

        $class->load('teacher', 'courses');
        return view('admin.classes.edit', compact('class', 'teachers', 'courses'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:10',
            'teacher_id' => 'nullable|exists:teachers,id',
            'capacity' => 'required|integer|min:1',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $class->update($validated);

        if (isset($validated['course_ids'])) {
            $class->courses()->sync($validated['course_ids']);
        } else {
            // If course_ids is not present in request (e.g. all unchecked), detach all
            // Note: HTML forms don't send anything for empty checkboxes usually, 
            // but we validate 'nullable|array', so we should check if we need to clear.
            // If the field is missing entirely from specific forms, we might need hidden input.
            // But standard sync without check usually wants array.
            $class->courses()->sync($validated['course_ids'] ?? []);
        }

        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }
}
