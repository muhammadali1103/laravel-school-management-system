<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', Admin\StudentController::class);
    Route::resource('teachers', Admin\TeacherController::class);
    Route::resource('courses', Admin\CourseController::class);
    Route::resource('classes', Admin\ClassController::class);

    // Fee Management Routes
    Route::resource('fees', Admin\FeeController::class);
    Route::post('/fees/{fee}/payment', [Admin\FeeController::class, 'recordPayment'])->name('fees.record-payment');

    // Fee Structure Routes
    Route::resource('fee-structures', Admin\FeeStructureController::class);

    // Fee Assignment Routes
    Route::resource('fee-assignments', Admin\FeeAssignmentController::class);

    Route::resource('timetables', Admin\TimetableController::class);
    Route::resource('notifications', Admin\NotificationController::class);

    Route::get('/attendance', [Admin\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/mark', [Admin\AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/mark', [Admin\AttendanceController::class, 'store'])->name('attendance.store');

    // Profile Routes
    Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');

    // Role & Permission Routes
    Route::resource('roles', Admin\RoleController::class);
    Route::get('roles/{role}/permissions', [Admin\RoleController::class, 'editPermissions'])->name('roles.permissions');
    Route::put('roles/{role}/permissions', [Admin\RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    Route::resource('permissions', Admin\PermissionController::class);
    Route::resource('users', Admin\UserController::class);
});

// Teacher Routes
Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'teacher'])->group(function () {
    Route::get('/dashboard', [Teacher\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/classes', [Teacher\ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{class}', [Teacher\ClassController::class, 'show'])->name('classes.show');

    // Student Routes
    Route::get('/students', [Teacher\StudentController::class, 'index'])->name('students.index');

    Route::get('/attendance', [Teacher\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/mark', [Teacher\AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/mark', [Teacher\AttendanceController::class, 'store'])->name('attendance.store');

    Route::get('/timetable', [Teacher\TimetableController::class, 'index'])->name('timetable.index');

    // Profile Routes
    Route::get('/profile', [Teacher\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Teacher\ProfileController::class, 'update'])->name('profile.update');

    // Notification Routes
    Route::resource('notifications', Teacher\NotificationController::class)->only(['index', 'create', 'store']);
});

// Student Routes
Route::prefix('student')->name('student.')->middleware(['auth', 'student'])->group(function () {
    Route::get('/dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/fees', [Student\FeeController::class, 'index'])->name('fees.index');
    Route::get('/attendance', [Student\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/courses', [Student\CourseController::class, 'index'])->name('courses.index');
    Route::get('/timetable', [Student\TimetableController::class, 'index'])->name('timetable.index');

    // Profile Routes
    Route::get('/profile', [Student\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Student\ProfileController::class, 'update'])->name('profile.update');

    // Notification Routes
    Route::get('/notifications', [Student\NotificationController::class, 'index'])->name('notifications.index');
});
