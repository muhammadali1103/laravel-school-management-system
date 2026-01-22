@extends('admin.layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Manage Notifications')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Notifications</h5>
        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Send New Notification
        </a>
    </div>
    <div class="card-body">
        @if($notifications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Target Audience</th>
                            <th>Date Sent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                            <tr>
                                <td class="fw-bold">{{ $notification->title }}</td>
                                <td>{{ Str::limit($notification->message, 50) }}</td>
                                <td>
                                    @if($notification->receiver_role == 'all')
                                        <span class="badge bg-primary">Everyone</span>
                                    @elseif($notification->receiver_role == 'student')
                                        <span class="badge bg-info">Students</span>
                                    @elseif($notification->receiver_role == 'teacher')
                                        <span class="badge bg-success">Teachers</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($notification->receiver_role ?? 'Specific User') }}</span>
                                    @endif
                                </td>
                                <td>{{ $notification->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bell text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">No notifications found.</p>
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Send First Notification
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
