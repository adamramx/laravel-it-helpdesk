<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IT Helpdesk') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="guest-body">
        <div class="guest-shell">
            <aside class="guest-aside">
                <a href="/" class="guest-brand">
                    <span class="brand-mark" aria-hidden="true">H</span>
                    <span>
                        <strong>Helpdesk</strong>
                        <small>IT Service Portal</small>
                    </span>
                </a>

                <div class="guest-promo">
                    <span class="guest-promo-label">PUSAT BANTUAN IT</span>
                    <h1>Solusi IT, lebih mudah.</h1>
                    <p>Sampaikan kendala, pantau progres, dan tetap terhubung dengan tim support dalam satu tempat.</p>
                </div>

                <p class="guest-footer mb-0">Bantuan yang tepat, di saat yang tepat.</p>
            </aside>

            <main class="guest-main">
                <div class="guest-card">
                    <h2>Selamat datang</h2>
                    <p>Masuk untuk mengakses portal bantuan IT Anda.</p>
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
