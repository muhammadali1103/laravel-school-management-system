<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Mark all notifications as seen by updating the user's last check timestamp
        $user = auth()->user();
        $user->update(['last_notification_check' => now()]);

        $notifications = \App\Models\Notification::whereIn('receiver_role', ['all', 'student'])
            ->with('sender')
            ->latest()
            ->paginate(10);

        return view('student.notifications.index', compact('notifications'));
    }
}
