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
                <a class="site-mark" href="{{ url('/') }}"> NOT DONE PTY LTD</a>

                <div class="site-header__actions">
                    <nav class="site-nav" aria-label="Primary">
                        <a href="{{ url('/') }}">Home</a>
                        <a href="{{ url('/brands') }}">Our Brands</a>
                        <a href="{{ url('/software-development') }}">Web Development</a>
                        <a href="{{ url('/contact') }}">Contact</a>
                    </nav>

                    <button
                        class="theme-toggle"
                        type="button"
                        data-theme-toggle
                        aria-label="Toggle color theme"
                        aria-pressed="false"
                    >
                        <span class="theme-toggle__icon" aria-hidden="true">
                            <svg class="theme-icon theme-icon--sun" viewBox="0 0 24 24" focusable="false">
                                <path d="M12 4V2m0 20v-2m8-8h2M2 12H4m12.95 4.95 1.41 1.41M5.64 5.64l1.41 1.41m9.9-1.41 1.41-1.41M5.64 18.36l1.41-1.41M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Z" />
                            </svg>
                            <svg class="theme-icon theme-icon--moon" viewBox="0 0 24 24" focusable="false">
                                <path d="M21 12.79A9 9 0 0 1 11.21 3c0 .34-.03.67-.08 1A9 9 0 1 0 20 12.87c.33-.05.66-.08 1-.08Z" />
                            </svg>
                        </span>
                    </button>
                </div>
            </header>

            <main>
                @yield('content')
            </main>

            <footer class="site-footer">
                <nav class="footer-nav" aria-label="Footer">
                    <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                    <a href="{{ url('/terms-of-service') }}">Terms of Service</a>
                    <a href="{{ url('/website-disclaimer') }}">Website Disclaimer</a>
                </nav>
                <span>&copy; NOT DONE PTY LTD {{ now()->year }}</span>
            </footer>
        </div>
    </body>
</html>
