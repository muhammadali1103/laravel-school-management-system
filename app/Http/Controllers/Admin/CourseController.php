<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('classes', 'teachers')->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.courses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|unique:courses,code',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:0',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $course = Course::create($validated);

        if (!empty($validated['teacher_ids'])) {
            $course->teachers()->sync($validated['teacher_ids']);
        }

        Cache::forget('all_courses');

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load('classes');
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $teachers = Teacher::with('user')->get();
        $course->load('teachers');
        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|unique:courses,code,' . $course->id,
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:0',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $course->update($validated);

        if (isset($validated['teacher_ids'])) {
            $course->teachers()->sync($validated['teacher_ids']);
        } else {
            $course->teachers()->sync($validated['teacher_ids'] ?? []);
        }

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        Cache::forget('all_courses');
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
