<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Not Done builds brands that keep improving and keep showing up.">

        <title>{{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white font-sans text-slate-950 antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,#fde7e8_0%,#ffffff_42%,#f9fafb_100%)]">
            @include('partials.site-header')

            <main class="mx-auto grid min-h-[calc(100vh-5.5rem)] w-full max-w-6xl items-center px-6 pb-16 pt-10">
                <section class="max-w-4xl">
                    <p class="text-sm font-semibold uppercase text-[#ec2024]">Not Done Pty Ltd</p>

                    <h1 class="mt-5 text-5xl font-semibold tracking-normal text-slate-950 text-balance sm:text-7xl">
                        Always innovating. Always showing up.
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                        We build practical brands and products for businesses that need dependable systems, clear communication, and steady improvement.
                    </p>

                    <div class="mt-10 flex flex-wrap gap-3">
                        <a class="inline-flex rounded-md bg-[#ec2024] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#c91b1f]" href="{{ route('brands') }}">
                            View brands
                        </a>
                        <a class="inline-flex rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:border-[#ec2024] hover:text-[#ec2024]" href="{{ route('contact') }}">
                            Contact us
                        </a>
                    </div>
                </section>
            </main>

            @include('partials.site-footer')
        </div>
    </body>
</html>
