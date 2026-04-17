<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'notdone.au' }}</title>
        <meta
            name="description"
            content="{{ $description ?? 'notdone.au' }}"
        >

        <script>
            (() => {
                const storedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = storedTheme ?? (prefersDark ? 'dark' : 'light');

                document.documentElement.dataset.theme = theme;
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="page-shell">
            <header class="site-header">
                <a class="site-mark" href="{{ url('/') }}">notdone.au</a>

                <div class="site-header__actions">
                    <nav class="site-nav" aria-label="Primary">
                        <a href="{{ url('/') }}">Home</a>
                        <a href="{{ url('/software-development') }}">Software Development</a>
                        <a href="{{ url('/blesta-plugins') }}">Blesta Modules</a>
                        <a href="{{ url('/contact') }}">Contact</a>
                    </nav>

                    <button
                        class="theme-toggle"
                        type="button"
                        data-theme-toggle
                        aria-label="Toggle color theme"
                        aria-pressed="false"
                    >
                        <span class="theme-toggle__icon" aria-hidden="true"></span>
                        <span class="theme-toggle__label">Dark mode</span>
                    </button>
                </div>
            </header>

            <main>
                @yield('content')
            </main>

            <footer class="site-footer">
                <span>&copy; Joshua Hagan {{ now()->year }}</span>
            </footer>
        </div>
    </body>
</html>
