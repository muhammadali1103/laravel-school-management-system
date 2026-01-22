<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $classes = \App\Models\ClassModel::orderBy('name')->get();
        return view('admin.teachers.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'employee_id' => ['required', 'string', 'regex:/^TCH\d{3}$/', 'unique:teachers,employee_id'],
            'phone' => ['required', 'string', 'regex:/^\d+$/'],
            'address' => 'required|string',
            'qualification' => 'required|string',
            'subject_specialization' => 'required|string',
            'joining_date' => 'required|date',
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:classes,id',
        ]);

        $teacherRole = Role::where('name', 'teacher')->first();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $teacherRole->id,
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'employee_id' => $validated['employee_id'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'subject_specialization' => $validated['subject_specialization'] ?? null,
            'joining_date' => $validated['joining_date'] ?? null,
        ]);

        //     \App\Models\ClassModel::whereIn('id', $validated['class_ids'])
        //         ->update(['teacher_id' => $teacher->id]);
        // }

        Cache::forget('all_teachers_with_user');

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('user', 'classes', 'courses');
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user', 'classes');
        $classes = \App\Models\ClassModel::orderBy('name')->get();
        return view('admin.teachers.edit', compact('teacher', 'classes'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'employee_id' => 'required|unique:teachers,employee_id,' . $teacher->id,
            'phone' => 'required',
            'address' => 'required',
            'qualification' => 'required',
            'subject_specialization' => 'required',
            'joining_date' => 'required|date',
            'password' => 'nullable|min:6|confirmed',
            'class_ids' => 'nullable|array',
            'class_ids.*' => 'exists:classes,id',
        ]);

        // Update teacher info
        $teacher->update([
            'employee_id' => $validated['employee_id'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'qualification' => $validated['qualification'],
            'subject_specialization' => $validated['subject_specialization'],
            'joining_date' => $validated['joining_date'],
        ]);

        // Update user info
        $teacher->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Handle Class Assignment (Class Teacher)
        // 1. Unassign classes that were assigned but not in the new list
        // \App\Models\ClassModel::where('teacher_id', $teacher->id)
        //     ->whereNotIn('id', $validated['class_ids'] ?? [])
        //     ->update(['teacher_id' => null]);

        // // 2. Assign selected classes to this teacher
        // if (!empty($validated['class_ids'])) {
        //     \App\Models\ClassModel::whereIn('id', $validated['class_ids'])
        //         ->update(['teacher_id' => $teacher->id]);
        // }

        if ($request->filled('password')) {
            $teacher->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        Cache::forget('all_teachers_with_user');

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete();
        Cache::forget('all_teachers_with_user');
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
