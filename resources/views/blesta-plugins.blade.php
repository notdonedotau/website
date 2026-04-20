@extends('layouts.site')

@section('content')
    <section class="content-page">
        <p class="eyebrow">Blesta Modules</p>
        <h1>Plugins and modules available.</h1>
        <p class="page-intro">
            Commercial Blesta integrations.
        </p>

        <div class="content-grid">
            <article class="content-block">
                <h2>Synergy Wholesale Domains</h2>
                <p>Domain provisioning and management for Blesta.</p>
            </article>

            <article class="content-block">
                <h2>Synergy Wholesale Emails &amp; Hosting</h2>
                <p>Email and hosting integration for Blesta.</p>
            </article>
        </div>

        <p class="page-intro">
            Monthly license available from $10/mo.
        </p>

        <p class="page-intro">
            <a href="{{ url('/software-development') }}">Need something custom? See software development.</a>
        </p>

        <a class="contact-link" href="mailto:hello@notdone.au">
            Request plugin pricing
        </a>
    </section>
@endsection
