<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        \Illuminate\Support\Facades\Gate::authorize('fee.view.self');
        $student = auth()->user()->student;

        // Fetch fees assigned to this student
        // Assuming 'Fee' model has a 'student_id' or relation. 
        // Based on typical logic, I'll fetch fees where student_id matches.
        $fees = \App\Models\Fee::where('student_id', $student->id)->orderBy('due_date', 'desc')->get();

        return view('student.fees.index', compact('fees'));
    }
}
