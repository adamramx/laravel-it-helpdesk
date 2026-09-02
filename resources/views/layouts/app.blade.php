<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'IT Helpdesk')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <div class="d-flex">

        @include('layouts.sidebar')

        <div class="flex-grow-1">

            @include('layouts.navbar')

            <main class="p-4">

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>