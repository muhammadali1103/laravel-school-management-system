<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $student = auth()->user()->student;
        $user = auth()->user();
        return view('student.profile.edit', compact('student', 'user'));
    }

    public function update(Request $request)
    {
        $student = auth()->user()->student;
        $user = auth()->user();

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Update Student Profile
        $student->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Update Password if provided
        if ($request->filled('new_password')) {
            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
