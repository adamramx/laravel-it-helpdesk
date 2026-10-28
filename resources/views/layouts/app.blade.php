<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IT Helpdesk') · Helpdesk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-body">
    <div class="app-shell">
        <aside class="app-sidebar d-none d-lg-flex">
            @include('layouts.sidebar')
        </aside>

        <div class="app-main">
            @include('layouts.navbar')

            <main class="app-content">
                @yield('content')
            </main>
        </div>
    </div>

    <div class="offcanvas offcanvas-start app-mobile-sidebar" tabindex="-1" id="mobileSidebar"
         aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">IT Helpdesk</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Tutup menu"></button>
        </div>
        <div class="offcanvas-body p-0">
            @include('layouts.sidebar')
        </div>
    </div>
</body>
</html>
