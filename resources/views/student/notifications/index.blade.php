@extends('student.layouts.app')

@section('title', 'Notifications')
@section('page-title', 'My Notifications')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @forelse($notifications as $notification)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1 text-primary fw-bold">{{ $notification->title }}</h5>
                                <p class="text-muted mb-2 small">
                                    <i class="bi bi-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-person me-1"></i> From: {{ $notification->sender->name ?? 'Admin' }}
                                </p>
                            </div>
                            <span
                                class="badge {{ $notification->receiver_role === 'all' ? 'bg-info' : 'bg-primary' }} rounded-pill">
                                {{ ucfirst($notification->receiver_role) }}
                            </span>
                        </div>
                        <p class="mb-0 text-dark">{{ $notification->message }}</p>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-muted">No Notifications</h5>
                        <p class="text-muted small">You're all caught up! Check back later for updates.</p>
                    </div>
                </div>
            @endforelse

            <div class="mt-4 px-2 d-flex justify-content-center">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection