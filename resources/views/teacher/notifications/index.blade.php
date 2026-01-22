@extends('teacher.layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 card-title">
                        <i class="bi bi-bell text-primary me-2"></i> Important Announcements
                    </h5>
                    @can('notification.send')
                        <a href="{{ route('teacher.notifications.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Send Notification
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    @forelse($notifications as $notification)
                        <div class="card mb-3 border bg-light">
                            <div class="card-body">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                    <h5 class="mb-1 text-primary fw-bold">{{ $notification->title }}</h5>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-2">{{ $notification->message }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-person-circle me-1"></i> Sent by:
                                        {{ $notification->sender->name ?? 'Admin' }}
                                    </small>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ ucfirst($notification->receiver_role) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-muted">No Notifications Yet</h5>
                            <p class="text-muted small">You're all caught up! Check back later for updates.</p>
                        </div>
                    @endforelse

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection