<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate Tables to remove old/duplicate permissions
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Illuminate\Support\Facades\DB::table('permission_role')->truncate();
        \Illuminate\Support\Facades\DB::table('permissions')->truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Finalized Permission Categories
        $categories = [
            'Dashboard' => [
                'dashboard.view' => 'View Dashboard',
            ],
            'Students' => [
                'student.view' => 'View All Students',
                'student.view.assigned' => 'View Assigned Students',
                'student.create' => 'Add Student',
                'student.edit' => 'Edit Student',
                'student.delete' => 'Delete Student',
            ],
            'Teachers' => [
                'teacher.view' => 'View All Teachers',
                'teacher.edit' => 'Edit Teacher',
                'teacher.delete' => 'Delete Teacher',
            ],
            'Courses' => [
                'course.view' => 'View All Courses',
                'course.create' => 'Create Course',
                'course.edit' => 'Edit Course',
            ],
            'Classes & Subjects' => [
                'class.view' => 'View All Classes',
                'class.view.assigned' => 'View Assigned Classes',
                'class.create' => 'Create Class',
                'class.edit' => 'Edit Class',
                'class.assign.subject' => 'Assign Subject',
                'class.assign.teacher' => 'Assign Teacher',
                // 'class.assign.course' removed as duplicate/confusing
                'subject.view' => 'View All Subjects',
                'subject.view.assigned' => 'View Assigned Subjects',
            ],
            'Attendance' => [
                'attendance.view' => 'View All Attendance',
                'attendance.view.assigned' => 'View Assigned Attendance',
                'attendance.view.self' => 'View Self Attendance',
                'attendance.mark' => 'Mark Attendance',
                'attendance.edit' => 'Edit Attendance',
            ],
            'Fees' => [
                'fee.view' => 'View All Fees',
                'fee.view.self' => 'View Own Fees',
                'fee.create' => 'Create Fee',
                'fee.assign' => 'Assign Fee',
                'fee.submit' => 'Submit Fee',
                'fee.discount' => 'Give Discount',
                'fee.delete' => 'Delete Fee',
                'fee.edit' => 'Edit Fee',
            ],
            'Timetable' => [
                'timetable.view' => 'View All Timetables',
                'timetable.view.assigned' => 'View Assigned Timetable',
                'timetable.view.self' => 'View Self Timetable',
                'timetable.create' => 'Create Timetable',
                'timetable.edit' => 'Edit Timetable',
                'timetable.delete' => 'Delete Timetable',
            ],
            'Notifications' => [
                'notification.send' => 'Send Notification',
                'notification.view' => 'View Notifications',
            ],
            'Users & Roles' => [
                'user.view' => 'View All Users',
                'user.role.change' => 'Change User Role',
                'user.create' => 'Create User',
                'user.edit' => 'Edit User',
                'user.delete' => 'Delete User',

                'role.view' => 'View All Roles',
                'role.create' => 'Create Role',
                'role.edit' => 'Edit Role',
                'role.delete' => 'Delete Role',
            ],
            'Profile' => [
                'profile.view' => 'View Profile',
                'profile.edit' => 'Edit Profile',
            ],
        ];

        // Create Permissions
        foreach ($categories as $group => $perms) {
            foreach ($perms as $name => $displayName) {
                Permission::updateOrCreate(
                    ['name' => $name],
                    [
                        'display_name' => $displayName,
                        'group' => $group,
                    ]
                );
            }
        }

        // --- Assign to Roles ---

        // 1. Student Role - Starts with ZERO permissions (Explicitly assigned only)
        $studentRole = Role::where('name', 'student')->first();
        if ($studentRole) {
            $studentRole->permissions()->sync([]); // Clear all permissions
        }

        // 2. Teacher Role - Starts with ZERO permissions (Explicitly assigned only)
        $teacherRole = Role::where('name', 'teacher')->first();
        if ($teacherRole) {
            $teacherRole->permissions()->sync([]); // Clear all permissions
        }

        // 3. Admin Role - Full school management (except user/role management)
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminPermissions = Permission::whereIn('group', [
                'Dashboard',
                'Students',
                'Teachers',
                'Courses',
                'Classes & Subjects',
                'Attendance',
                'Fees',
                'Timetable',
                'Notifications',
                'Profile'
            ])->pluck('id');

            $adminRole->permissions()->sync($adminPermissions);
        }

        // 4. Super Admin - Has global bypass via Gate, but we can assign all permissions for visibility
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            // Assign all permissions to Super Admin for completeness
            $superAdminRole->permissions()->sync(Permission::all()->pluck('id'));
        }
    }
}
