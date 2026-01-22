<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\ClassModel;
use App\Models\Attendance;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('admin_dashboard_stats', 60 * 10, function () {
            return [
                'students' => Student::count(),
                'teachers' => Teacher::count(),
                'courses' => Course::count(),
                'classes' => ClassModel::count(),
                'attendance_today' => Attendance::where('date', today())->count(),
            ];
        });

        return view('admin.dashboard', compact('stats'));
    }
}
