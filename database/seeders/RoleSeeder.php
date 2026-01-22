<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(
            ['name' => 'super_admin'],
            [
                'display_name' => 'Super Admin',
                'description' => 'Administrator with full access to the system',
            ]
        );

        $roles = [
            [
                'name' => 'teacher',
                'display_name' => 'Teacher',
                'description' => 'Can manage classes, attendance, and view students',
            ],
            [
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'Can view own attendance, courses, and timetable',
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Administrator with limited access (cannot manage system settings or roles)',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
