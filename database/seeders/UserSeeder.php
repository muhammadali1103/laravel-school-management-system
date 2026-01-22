<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('name', 'admin')->first();
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        // Create Teacher User
        $teacherUser = User::create([
            'name' => 'John Teacher',
            'email' => 'teacher@school.com',
            'password' => Hash::make('password'),
            'role_id' => $teacherRole->id,
        ]);

        // Create Teacher Profile
        Teacher::create([
            'user_id' => $teacherUser->id,
            'employee_id' => 'TCH001',
            'phone' => '1234567890',
            'address' => '123 Teacher Street',
            'qualification' => 'M.Ed',
            'subject_specialization' => 'Mathematics',
            'joining_date' => now(),
        ]);

        // Create Additional Teachers with Pakistani names
        $teacherNames = [
            'Muhammad Ahmed Khan',
            'Fatima Noor',
            'Ali Hassan',
            'Ayesha Malik',
        ];

        foreach ($teacherNames as $i => $name) {
            $teacherUser = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@school.pk',
                'password' => Hash::make('teacher123'),
                'role_id' => $teacherRole->id,
            ]);

            Teacher::create([
                'user_id' => $teacherUser->id,
                'employee_id' => 'TCH' . str_pad($i + 2, 3, '0', STR_PAD_LEFT),
                'phone' => '+92-321-' . rand(1000000, 9999999),
                'address' => ['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi'][$i % 4] . ', Pakistan',
                'qualification' => ['B.Ed', 'M.Ed', 'M.Sc', 'M.Phil'][$i % 4],
                'subject_specialization' => ['Mathematics', 'Urdu', 'English', 'Computer Science'][$i % 4],
                'joining_date' => now()->subMonths(rand(6, 48)),
            ]);
        }
    }
}
