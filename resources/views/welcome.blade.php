@extends('layouts.site')

@section('content')
    <div class="home-page">
        <section class="hero home-hero">
            <p class="eyebrow">Keep showing up.</p>
            <h1>Even when things don’t.</h1>
            <p class="hero-copy">
                Built for agencies, hosting providers, and SaaS teams.
            </p>
            <div class="home-hero__actions" aria-label="Primary actions">
                <a class="home-hero__button home-hero__button--primary" href="https://account.notdone.au/order/config/index/subscription/?group_id=2&amp;pricing_id=6">
                    Start your status page
                </a>
                <a class="home-hero__button home-hero__button--secondary" href="{{ route('pricing') }}">
                    View pricing
                </a>
            </div>
        </section>

        <section class="home-section" aria-labelledby="home-what-you-get-heading">
            <div class="section-heading">
                <p class="eyebrow">What you get</p>
                <h2 id="home-what-you-get-heading">A clear place for every service update.</h2>
            </div>
            <div class="home-card-grid">
                <article class="home-info-card">
                    <h3>Hosted status pages</h3>
                    <p>Publish incidents, maintenance, and service health without building the plumbing yourself.</p>
                </article>
                <article class="home-info-card">
                    <h3>Flexible components</h3>
                    <p>Show public or private components for apps, APIs, regions, infrastructure, or client services.</p>
                </article>
                <article class="home-info-card">
                    <h3>Notifications</h3>
                    <p>Notify customers by email or SMS. Send alerts to your team via Slack, Teams, or webhooks.</p>
                </article>
            </div>
        </section>
    </div>
@endsection
