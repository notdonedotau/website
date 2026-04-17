<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>notdone.au</title>
        <meta
            name="description"
            content="notdone.au. Domain Name. Keep showing up."
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

            <main class="hero">
                <p class="eyebrow">notdone.au</p>
                <h1>Keep showing up.</h1>

                <a class="contact-link" href="mailto:joshua@notdone.au">
                    joshua@notdone.au
                </a>
            </main>

            <footer class="site-footer">
                <span>&copy; Joshua Hagan {{ now()->year }}</span>
            </footer>
        </div>
    </body>
</html>
