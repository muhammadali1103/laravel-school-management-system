<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        // Get students from classes assigned to this teacher
        $students = $teacher->classes()->with(['students.user'])->get()->pluck('students')->flatten()->unique('id');

        return view('teacher.students.index', compact('students'));
    }
}
