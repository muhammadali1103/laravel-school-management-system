<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('user', 'classes');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('roll_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $students = $query->paginate(15)->appends($request->query());
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roll_number' => ['required', 'string', 'regex:/^STD-\d{4}$/', 'unique:students,roll_number'],
            'phone' => ['required', 'string', 'regex:/^\d+$/'],
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'parent_name' => 'required|string',
            'parent_phone' => 'required|string',
            'classes' => 'nullable|array', // Removed
            'class_id' => 'required|exists:classes,id',
        ]);

        // Create user
        $studentRole = Role::where('name', 'student')->first();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $studentRole->id,
        ]);

        // Create student profile
        $student = Student::create([
            'user_id' => $user->id,
            'roll_number' => $validated['roll_number'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'parent_name' => $validated['parent_name'] ?? null,
            'parent_phone' => $validated['parent_phone'] ?? null,
        ]);

        // Assign class (Single assignment)
        if ($request->filled('class_id')) {
            $student->classes()->attach($request->class_id);
        }

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load('user', 'classes', 'attendances', 'fees');
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = ClassModel::all();
        $student->load('user', 'classes');
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'roll_number' => 'required|unique:students,roll_number,' . $student->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'parent_name' => 'nullable|string',
            'parent_phone' => 'nullable|string',
            'classes' => 'nullable|array', // Removed, using class_id
            'class_id' => 'nullable|exists:classes,id',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update user
        $student->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update student profile
        $student->update([
            'roll_number' => $validated['roll_number'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'parent_name' => $validated['parent_name'] ?? null,
            'parent_phone' => $validated['parent_phone'] ?? null,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $student->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Sync class (Single class enforcement)
        if ($request->filled('class_id')) {
            $student->classes()->sync([$request->class_id]);
        } else {
            $student->classes()->detach();
        }

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->user->delete(); // This will cascade delete the student
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
