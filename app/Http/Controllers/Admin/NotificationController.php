<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = \App\Models\Notification::with('sender')->latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_audience' => 'required|in:all,student,teacher',
        ]);

        $sender_id = auth()->id();
        $receiver_role = $validated['target_audience'] == 'all' ? null : $validated['target_audience'];

        // If 'all' is selected, we might want to just set receiver_role to null (implying global) 
        // OR distinct logic. Based on schema 'receiver_role', let's use that.
        // If it's 'all', we can leave receiver_role null and handle display logic, 
        // or specifically say 'all'. 
        // Let's modify logic: If target is specific role, use it. If 'all', maybe distinct entries or special flag?
        // Schema comment says: "// To send to all of a role".
        // Let's assume receiver_role = 'all' means everyone.

        \App\Models\Notification::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'sender_id' => $sender_id,
            'receiver_role' => $validated['target_audience'],
            'is_read' => false,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification sent successfully.');
    }

    public function destroy(\App\Models\Notification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully.');
    }
}
