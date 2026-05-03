@extends('layouts.site', [
    'title' => 'Contact | '.config('app.name'),
    'description' => 'Contact the Not Done team.',
])

@php($turnstileSiteKey = app(\App\Services\Turnstile::class)->enabled() ? config('services.turnstile.site_key') : null)

@if (filled($turnstileSiteKey))
    @push('head')
        @once
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        @endonce
    @endpush
@endif

@section('content')
    <section class="content-page content-page--narrow">
        <p class="eyebrow">Contact</p>
        <h1>Get in touch.</h1>
        <p class="page-intro">
            Send a message and the team will get back to you. You can also
            email us directly at <a href="mailto:support@notdone.cloud">support@notdone.cloud</a>.
        </p>

        @if (session('contact_status'))
            <div class="form-alert form-alert--success">
                {{ session('contact_status') }}
            </div>
        @endif

        @if (session('contact_error'))
            <div class="form-alert form-alert--error">
                {{ session('contact_error') }}
            </div>
        @endif

        <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
            @csrf

            <div class="form-field">
                <label for="name">Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    required
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="subject">Subject</label>
                <input
                    id="subject"
                    name="subject"
                    type="text"
                    value="{{ old('subject') }}"
                    required
                >
                @error('subject')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="message">Message</label>
                <textarea
                    id="message"
                    name="message"
                    rows="6"
                    required
                >{{ old('message') }}</textarea>
                @error('message')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            @if (filled($turnstileSiteKey))
                <div class="turnstile-field">
                    <div class="cf-turnstile" data-sitekey="{{ $turnstileSiteKey }}"></div>
                </div>
            @endif
            @error('cf-turnstile-response')
                <p class="form-error">{{ $message }}</p>
            @enderror

            <button class="contact-link contact-form__submit" type="submit">
                Send message
            </button>
        </form>

    </section>
@endsection
