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

        <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
        <link rel="mask-icon" href="{{ asset('images/logo.svg') }}" color="#e4572e">
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
    <body>
        <div class="page-shell">
            <header class="site-header">
                <div class="site-header__inner">
                    <a class="site-mark" href="{{ url('/') }}" aria-label="NOTDONE home">
                        <img class="site-logo site-logo--light" src="{{ asset('images/logo-dm.svg') }}" alt="NOTDONE">
                        <img class="site-logo site-logo--dark" src="{{ asset('images/logo.svg') }}" alt="NOTDONE">
                    </a>

                    <div class="site-header__actions">
                        <nav class="site-nav" aria-label="Primary">
                            <a href="{{ url('/') }}">Home</a>
                            <a href="{{ route('about') }}">About</a>
                            <a href="{{ route('features') }}">Features</a>
                            <a href="{{ route('pricing') }}">Pricing</a>
                            <a href="{{ url('/contact') }}">Contact</a>
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
                            <a class="site-nav__button site-nav__button--primary" href="{{ route('get-started') }}">Get Started</a>
                        </nav>
                    </div>
                </div>
            </header>

            <main>
                @yield('content')
            </main>

            <footer class="site-footer">
                <div class="site-footer__inner">
                    <div class="site-footer__brand">
                        <a class="site-footer__mark" href="{{ url('/') }}" aria-label="NOTDONE home">
                            <img class="site-logo site-logo--light" src="{{ asset('images/logo-dm.svg') }}" alt="NOTDONE">
                            <img class="site-logo site-logo--dark" src="{{ asset('images/logo.svg') }}" alt="NOTDONE">
                        </a>
                        <p>Simple hosted status pages for teams that need clear incident communication.</p>
                    </div>

                    <nav class="site-footer__group" aria-label="Product">
                        <h2>Product</h2>
                        <a href="{{ route('features') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M4 6h16M4 12h16M4 18h10" />
                            </svg>
                            <span>Features</span>
                        </a>
                        <a href="{{ route('pricing') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M12 2v20m5-17H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                            <span>Pricing</span>
                        </a>
                        <a href="{{ route('get-started') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M5 12h14m-6-6 6 6-6 6" />
                            </svg>
                            <span>Get Started</span>
                        </a>
                        <a href="https://not-done.status.notdone.cloud" target="_blank" rel="noreferrer">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M7 17 17 7m0 0H9m8 0v8" />
                            </svg>
                            <span>Status</span>
                        </a>
                    </nav>

                    <nav class="site-footer__group" aria-label="Company">
                        <h2>Company</h2>
                        <a href="{{ route('about') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M12 17v-5m0-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>About</span>
                        </a>
                        <a href="{{ route('blog.index') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15Z" />
                            </svg>
                            <span>Blog</span>
                        </a>
                        <a href="https://account.notdone.cloud">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M20 21a8 8 0 0 0-16 0m12-13a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
                            </svg>
                            <span>Account Login</span>
                        </a>
                    </nav>

                    <address class="site-footer__group site-footer__contact">
                        <h2>Contact</h2>
                        <span>
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z" />
                                <path d="M12 10h.01" />
                            </svg>
                            <span>Perth, Western Australia</span>
                        </span>
                        <a href="{{ route('contact') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" />
                            </svg>
                            <span>Contact us</span>
                        </a>
                        <a href="https://abr.business.gov.au/ABN/View?abn=43697288583" target="_blank" rel="noreferrer">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M14 3h7v7" />
                                <path d="M10 14 21 3" />
                                <path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5" />
                            </svg>
                            <span>ABN 43 697 288 583</span>
                        </a>
                    </address>
                </div>

                <div class="site-footer__bottom">
                    <span>&copy; {{ now()->year }} NOT DONE PTY LTD. All rights reserved.</span>
                    <nav class="site-footer__legal" aria-label="Legal">
                        <a href="{{ url('/terms-of-service') }}">Terms of Service</a>
                        <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                        <a href="{{ url('/website-disclaimer') }}">Website Disclaimer</a>
                    </nav>
                </div>
            </footer>
        </div>
        <!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<script>(function(D){function f(){function n(n,e){e=D.createElement("script");e.src="https://image.providesupport.com/"+n,D.body.appendChild(e)}n("js/0u8tves5jzg801nvpob360sdyy/safe-standard-sync.js?ps_h=rchx&ps_t="+Date.now()),n("sjs/static.js")}D.readyState=="complete"?f():window.addEventListener("load",f)})(document)</script><noscript><div style="display:inline"><a href="https://vm.providesupport.com/0u8tves5jzg801nvpob360sdyy">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code -->
    </body>
</html>
