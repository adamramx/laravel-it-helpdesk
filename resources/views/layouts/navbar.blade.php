@php
    $unreadNotifications = auth()->user()->notifications()->where('is_read', false)->count();
@endphp

<header class="app-topbar">
    <div class="topbar-leading">
        <button class="mobile-menu-button d-lg-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Buka menu">
            <span aria-hidden="true">☰</span>
        </button>
        <div>
            <p class="topbar-eyebrow">IT SERVICE PORTAL</p>
            <h1 class="topbar-title">Helpdesk Workspace</h1>
        </div>
    </div>

    <div class="topbar-actions">
        <a href="{{ route('notifications.index') }}" class="notification-button"
           aria-label="Notifikasi{{ $unreadNotifications ? ', '.$unreadNotifications.' belum dibaca' : '' }}">
            <span aria-hidden="true">♧</span>
            @if($unreadNotifications > 0)
                <span class="notification-count">{{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}</span>
            @endif
        </a>
        <div class="topbar-user d-none d-sm-flex">
            <span class="user-avatar user-avatar-small">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
            <span class="topbar-user-info">
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ str(auth()->user()->role)->replace('_', ' ')->title() }}</small>
            </span>
        </div>
    </div>
</header>
