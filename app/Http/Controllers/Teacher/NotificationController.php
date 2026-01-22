<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:notification.view')->only(['index']);
        $this->middleware('can:notification.send')->only(['create', 'store']);
    }

    public function index()
    {
        // Mark all notifications as seen by updating the user's last check timestamp
        $user = auth()->user();
        $user->update(['last_notification_check' => now()]);

        $notifications = \App\Models\Notification::whereIn('receiver_role', ['all', 'teacher'])
            ->with('sender')
            ->latest()
            ->paginate(10);

        return view('teacher.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('teacher.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_audience' => 'required|in:all,student,teacher',
        ]);

        \App\Models\Notification::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'sender_id' => auth()->id(),
            'receiver_role' => $validated['target_audience'],
            'is_read' => false,
        ]);

        return redirect()->route('teacher.notifications.index')->with('success', 'Notification sent successfully.');
    }
}
