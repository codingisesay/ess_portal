@extends('user_view.header')
<!-- Created a new Notification blade which displays all user notifications in one place. -->

@section('content')
<div class="container py-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="mb-0">Notifications</h6>
        <!-- Minimal control: CSS-only filter for unread items -->
        <label class="d-flex align-items-center gap-2 small mb-0" for="unreadOnly">
            <input type="checkbox" id="unreadOnly" />
            Show unread only
        </label>
    </div>

    <div class="card">
        <div class="list-group list-group-flush" id="notificationList">
            @php
                // Example structure if a controller passes $notifications
                // $notifications = $notifications ?? [];
            @endphp
            @if(isset($notifications) && count($notifications))
                @foreach($notifications as $n)
                    <div class="list-group-item d-flex justify-content-between align-items-start notification-item {{ ($n['read'] ?? false) ? 'is-read' : 'is-unread' }}">
                        <div class="me-3">
                            <div class="fw-semibold">
                                {{ $n['title'] ?? 'Notification' }}
                                @if(!($n['read'] ?? false))
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle align-middle">Unread</span>
                                @endif
                            </div>
                            <div class="text-muted small">{{ $n['message'] ?? '' }}</div>
                        </div>
                        <div class="text-nowrap text-muted small">{{ $n['time'] ?? '' }}</div>
                    </div>
                @endforeach
            @else
                <div class="list-group-item">
                    <span class="text-muted">No notifications yet.</span>
                </div>
            @endif
        </div>
    </div>

    <style>
        .notification-item.is-unread { background: #f7fbff; }
        .notification-item.is-read { background: #fff; }
        #unreadOnly:checked ~ .card #notificationList .notification-item.is-read { display: none; }
    </style>
    
</div>
@endsection
