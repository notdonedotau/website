<header class="mx-auto flex w-full max-w-6xl items-center justify-between gap-6 px-6 py-6">
    <a class="inline-flex h-10 items-center" href="{{ url('/') }}" aria-label="Not Done home">
        <img class="h-8 w-auto" src="{{ asset('images/logo-dm.svg') }}" alt="Not Done">
    </a>

    <nav class="flex items-center gap-5 text-sm font-semibold text-slate-600" aria-label="Primary">
        <a class="transition hover:text-[#ec2024]" href="{{ route('brands') }}">Brands</a>
        <a class="transition hover:text-[#ec2024]" href="{{ route('contact') }}">Contact</a>
    </nav>
</header>
