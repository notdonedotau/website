<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name') }}</title>
        <meta
            name="description"
            content="{{ $description ?? config('app.name') }}"
        >
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" media="(prefers-color-scheme: light)">
        <link rel="icon" type="image/png" href="{{ asset('favicon-dm.png') }}" media="(prefers-color-scheme: dark)">
        <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
        <link rel="mask-icon" href="{{ asset('images/logo.svg') }}" color="#ec2024">
        <meta name="msapplication-TileImage" content="{{ asset('favicon.png') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#0b0b0b" media="(prefers-color-scheme: dark)">

        <script>
            (() => {
                const storedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = storedTheme ?? (prefersDark ? 'dark' : 'light');

                document.documentElement.dataset.theme = theme;
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="bg-white font-sans text-slate-950 antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,#fde7e8_0%,#ffffff_42%,#f9fafb_100%)]">
            @include('partials.site-header')

            <main class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
                @yield('content')
            </main>

            @include('partials.site-footer')
        </div>
        <!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<script>(function(D){function f(){function n(n,e){e=D.createElement("script");e.src="https://image.providesupport.com/"+n,D.body.appendChild(e)}n("js/0u8tves5jzg801nvpob360sdyy/safe-standard-sync.js?ps_h=rchx&ps_t="+Date.now()),n("sjs/static.js")}D.readyState=="complete"?f():window.addEventListener("load",f)})(document)</script><noscript><div style="display:inline"><a href="https://vm.providesupport.com/0u8tves5jzg801nvpob360sdyy">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code -->
    </body>
</html>
