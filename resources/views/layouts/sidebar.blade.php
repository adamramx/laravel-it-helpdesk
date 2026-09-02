<div class="bg-dark text-white p-3"
     style="width: 250px; min-height: 100vh;">

    <h4 class="mb-4">
        🛠 IT Helpdesk
    </h4>

    <hr>

    <ul class="nav nav-pills flex-column gap-2">

        {{-- Dashboard --}}
        <li class="nav-item">

            <a href="{{ route('dashboard') }}"
               class="nav-link text-white">

                📊 Dashboard

            </a>

        </li>


        {{-- Ticket --}}
        <li class="nav-item">

            <a href="{{ route('tickets.index') }}"
                class="nav-link text-white">

                🎫 Tickets

            </a>

        </li>


        {{-- Category --}}
        @if(auth()->user()->role === 'admin')

            <li class="nav-item">

                <a href="#"
                   class="nav-link text-white">

                    📂 Categories

                </a>

            </li>

        @endif


        {{-- Users --}}
        @if(auth()->user()->role === 'admin')

            <li class="nav-item">

                <a href="#"
                   class="nav-link text-white">

                    👥 Users

                </a>

            </li>

        @endif


        {{-- Reports --}}
        @if(in_array(auth()->user()->role, ['admin', 'it_support']))

            <li class="nav-item">

                <a href="{{ route('categories.index') }}"
                     class="nav-link text-white">

                     📂 Categories

                </a>

            </li>

        @endif

    </ul>


    <hr>


    {{-- Logout --}}

    <form method="POST" action="{{ route('logout') }}">

        @csrf

        <button type="submit"
                class="btn btn-danger w-100">

            🚪 Logout

        </button>

    </form>

</div>
