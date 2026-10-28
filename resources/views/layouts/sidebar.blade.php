@php
    $role = auth()->user()->role;
    $dashboardRoute = match ($role) {
        'admin' => 'admin.dashboard',
        'it_support' => 'it.dashboard',
        default => 'user.dashboard',
    };
@endphp

<div class="sidebar-inner">
    <a href="{{ route($dashboardRoute) }}" class="sidebar-brand">
        <span class="brand-mark" aria-hidden="true">H</span>
        <span>
            <strong>Helpdesk</strong>
            <small>IT Service Portal</small>
        </span>
    </a>

    <div class="sidebar-section-label">MENU</div>
    <nav class="sidebar-nav" aria-label="Navigasi utama">
        <a href="{{ route($dashboardRoute) }}"
           class="sidebar-link {{ request()->routeIs('dashboard', 'admin.dashboard', 'it.dashboard', 'user.dashboard') ? 'active' : '' }}">
            <span class="sidebar-icon" aria-hidden="true">⌂</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('tickets.index') }}"
           class="sidebar-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
            <span class="sidebar-icon" aria-hidden="true">▤</span>
            <span>Tickets</span>
        </a>
        @if($role === 'admin')
            <a href="{{ route('categories.index') }}"
               class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <span class="sidebar-icon" aria-hidden="true">◇</span>
                <span>Kategori</span>
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="sidebar-icon" aria-hidden="true">◎</span>
                <span>Pengguna</span>
            </a>
        @endif
        <a href="{{ route('notifications.index') }}"
           class="sidebar-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
            <span class="sidebar-icon" aria-hidden="true">♧</span>
            <span>Notifikasi</span>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <span class="user-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
            <span class="sidebar-user-info">
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ str($role)->replace('_', ' ')->title() }}</small>
            </span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout">
                <span aria-hidden="true">↪</span> Keluar
            </button>
        </form>
    </div>
</div>
