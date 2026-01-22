<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;

class UserObserver
{
    /**
     * Handle the User "saved" event.
     * This runs after create and update
     */
    public function saved(User $user): void
    {
        // Only proceed if role_id has changed or this is a new user
        if ($user->wasChanged('role_id') || $user->wasRecentlyCreated) {
            $this->syncProfileWithRole($user);
        }
    }

    /**
     * Sync student/teacher profile based on role
     */
    protected function syncProfileWithRole(User $user): void
    {
        $roleName = $user->role->name ?? null;

        // Create Student Profile if role is student and profile doesn't exist
        if ($roleName === 'student' && !$user->student) {
            $this->createStudentProfile($user);
        }

        // Create Teacher Profile if role is teacher and profile doesn't exist
        if ($roleName === 'teacher' && !$user->teacher) {
            $this->createTeacherProfile($user);
        }

        // Optional: Remove old profiles if role changed away from student/teacher
        // Uncomment if you want automatic cleanup
        // if ($roleName !== 'student' && $user->student) {
        //     $user->student->delete();
        // }
        // if ($roleName !== 'teacher' && $user->teacher) {
        //     $user->teacher->delete();
        // }
    }

    /**
     * Create student profile with auto-generated roll number
     */
    protected function createStudentProfile(User $user): void
    {
        $rollNumber = $this->generateRollNumber();

        Student::create([
            'user_id' => $user->id,
            'roll_number' => $rollNumber,
            // Other fields are nullable and can be filled later
        ]);
    }

    /**
     * Create teacher profile with auto-generated employee ID
     */
    protected function createTeacherProfile(User $user): void
    {
        $employeeId = $this->generateEmployeeId();

        Teacher::create([
            'user_id' => $user->id,
            'employee_id' => $employeeId,
            // Other fields are nullable and can be filled later
        ]);
    }

    /**
     * Generate unique student roll number (STD-0001, STD-0002, etc.)
     */
    protected function generateRollNumber(): string
    {
        $lastStudent = Student::orderBy('id', 'desc')->first();
        $nextId = $lastStudent ? $lastStudent->id + 1 : 1;

        return 'STD-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate unique teacher employee ID (TCH001, TCH002, etc.)
     */
    protected function generateEmployeeId(): string
    {
        $lastTeacher = Teacher::orderBy('id', 'desc')->first();
        $nextId = $lastTeacher ? $lastTeacher->id + 1 : 1;

        return 'TCH' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    }
}
