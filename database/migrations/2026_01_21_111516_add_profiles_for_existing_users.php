<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create student profiles for existing users with student role
        $studentRole = \App\Models\Role::where('name', 'student')->first();
        if ($studentRole) {
            $studentUsers = User::where('role_id', $studentRole->id)
                ->whereDoesntHave('student')
                ->get();

            foreach ($studentUsers as $user) {
                $rollNumber = $this->generateRollNumber();
                Student::create([
                    'user_id' => $user->id,
                    'roll_number' => $rollNumber,
                ]);
            }
        }

        // Create teacher profiles for existing users with teacher role
        $teacherRole = \App\Models\Role::where('name', 'teacher')->first();
        if ($teacherRole) {
            $teacherUsers = User::where('role_id', $teacherRole->id)
                ->whereDoesntHave('teacher')
                ->get();

            foreach ($teacherUsers as $user) {
                $employeeId = $this->generateEmployeeId();
                Teacher::create([
                    'user_id' => $user->id,
                    'employee_id' => $employeeId,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is for data creation only, no need to reverse
    }

    /**
     * Generate unique student roll number
     */
    protected function generateRollNumber(): string
    {
        $lastStudent = Student::orderBy('id', 'desc')->first();
        $nextId = $lastStudent ? $lastStudent->id + 1 : 1;

        return 'STD-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate unique teacher employee ID
     */
    protected function generateEmployeeId(): string
    {
        $lastTeacher = Teacher::orderBy('id', 'desc')->first();
        $nextId = $lastTeacher ? $lastTeacher->id + 1 : 1;

        return 'TCH' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    }
};
