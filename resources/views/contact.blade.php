@extends('layouts.site')

@section('content')
    <section class="content-page content-page--narrow">
        <p class="eyebrow">Contact</p>
        <h1>Get in touch.</h1>
        <p class="page-intro">
            Reach out by email, or message me on Discord.
        </p>

        <div class="content-grid content-grid--single">
            <section class="content-block contact-block">
                <h2>Email</h2>
                <p>joshua@notdone.au</p>
            </section>

            <section class="content-block contact-block">
                <h2>Discord</h2>
                <p class="contact-inline">
                    <span class="discord-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" role="img" focusable="false">
                            <path
                                fill="currentColor"
                                d="M20.3 4.37A16.8 16.8 0 0 0 16.17 3a11.5 11.5 0 0 0-.53 1.1 15.5 15.5 0 0 0-4.67 0A11.5 11.5 0 0 0 10.44 3a16.7 16.7 0 0 0-4.13 1.37C3.7 8.32 2.98 12.16 3.34 15.95a16.9 16.9 0 0 0 5.06 2.55 12.4 12.4 0 0 0 1.08-1.77 10.9 10.9 0 0 1-1.7-.82c.14-.1.27-.2.4-.31a12 12 0 0 0 10.1 0c.13.11.26.21.4.31-.54.32-1.11.59-1.71.82.31.63.67 1.22 1.08 1.77a16.8 16.8 0 0 0 5.07-2.55c.42-4.39-.72-8.2-2.82-11.58ZM9.84 13.63c-.99 0-1.81-.9-1.81-2s.8-2 1.8-2c1.02 0 1.83.9 1.82 2 0 1.1-.8 2-1.8 2Zm4.32 0c-1 0-1.8-.9-1.8-2s.8-2 1.8-2c1.02 0 1.83.9 1.82 2 0 1.1-.8 2-1.82 2Z"
                            />
                        </svg>
                    </span>
                    <span>notdone.au</span>
                </p>
            </section>
        </div>
    </section>
@endsection
