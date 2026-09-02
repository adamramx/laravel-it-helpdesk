<nav class="navbar navbar-light bg-white shadow-sm px-4">

    {{-- BRAND --}}
    <div>
        <a
            href="{{ route('dashboard') }}"
            class="text-decoration-none text-dark"
        >
            <h5 class="mb-0">
                IT Helpdesk
            </h5>
        </a>
    </div>


    {{-- MENU --}}
    <div class="d-flex align-items-center gap-3">

        {{-- DASHBOARD --}}
        @if(auth()->user()->role === 'admin')

            <a
                href="{{ route('admin.dashboard') }}"
                class="text-decoration-none text-dark"
            >
                Dashboard
            </a>

        @elseif(auth()->user()->role === 'it_support')

            <a
                href="{{ route('it.dashboard') }}"
                class="text-decoration-none text-dark"
            >
                Dashboard
            </a>

        @elseif(auth()->user()->role === 'user')

            <a
                href="{{ route('user.dashboard') }}"
                class="text-decoration-none text-dark"
            >
                Dashboard
            </a>

        @endif


        {{-- TICKETS --}}
        <a
            href="{{ route('tickets.index') }}"
            class="text-decoration-none text-dark"
        >
            Tickets
        </a>


        {{-- CREATE TICKET KHUSUS USER --}}
        @if(auth()->user()->role === 'user')

            <a
                href="{{ route('tickets.create') }}"
                class="text-decoration-none text-dark"
            >
                + Buat Ticket
            </a>

        @endif


        {{-- CATEGORY KHUSUS ADMIN --}}
        @if(auth()->user()->role === 'admin')

            <a
                href="{{ route('categories.index') }}"
                class="text-decoration-none text-dark"
            >
                Categories
            </a>

        @endif


        {{-- NOTIFICATION --}}
        @php
            $unreadNotifications = auth()->user()
                ->notifications()
                ->where('is_read', false)
                ->count();
        @endphp

        <a
            href="{{ route('notifications.index') }}"
            class="btn btn-light position-relative"
        >

            🔔

            @if($unreadNotifications > 0)

                <span
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                >
                    {{ $unreadNotifications }}
                </span>

            @endif

        </a>


        {{-- USER NAME --}}
        <span>
            {{ auth()->user()->name }}
        </span>


        {{-- ROLE --}}
        <span class="badge bg-primary">
            {{ strtoupper(auth()->user()->role) }}
        </span>


        {{-- LOGOUT --}}
        <form
            action="{{ route('logout') }}"
            method="POST"
            class="d-inline"
        >
            @csrf

            <button
                type="submit"
                class="btn btn-outline-danger btn-sm"
            >
                Logout
            </button>

        </form>

    </div>

</nav>
