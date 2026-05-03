@extends('layouts.site', [
    'title' => 'Features | '.config('app.name'),
    'description' => 'Status pages for teams that keep shipping.',
])

@section('content')
    <section class="content-page features-page">
        <section class="features-hero" aria-labelledby="features-heading">
            <p class="eyebrow">Features</p>
            <h1 id="features-heading">Keep customers informed while your product keeps moving.</h1>
            <p class="page-intro">
                Not Done starts with simple, clear status pages for incidents,
                maintenance, uptime, and customer communication.
            </p>
            <a class="contact-link" href="{{ route('get-started') }}">
                Get Started
            </a>
        </section>

        @include('partials.product-notice')

        <section class="feature-section" aria-labelledby="pillars-heading">
            <div class="section-heading">
                <p class="eyebrow">Core Pillars</p>
                <h2 id="pillars-heading">Everything customers need when service health matters.</h2>
            </div>

            <div class="feature-card-grid feature-card-grid--three">
                <article class="feature-card feature-card--status">
                    <p class="feature-card__label">Incidents</p>
                    <h3>Communicate issues without creating support noise.</h3>
                    <p>
                        Publish incident updates in one place so customers know what
                        happened, what is affected, and when things are resolved.
                    </p>
                </article>

                <article class="feature-card feature-card--maintenance">
                    <p class="feature-card__label">Maintenance</p>
                    <h3>Set expectations before planned work begins.</h3>
                    <p>
                        Schedule maintenance windows and keep customers informed before,
                        during, and after planned changes.
                    </p>
                </article>

                <article class="feature-card feature-card--components">
                    <p class="feature-card__label">Components</p>
                    <h3>Break service health down into clear parts.</h3>
                    <p>
                        Show the status of apps, APIs, regions, or infrastructure so
                        customers can quickly see what is affected.
                    </p>
                </article>
            </div>
        </section>

        <section class="feature-section" aria-labelledby="workflow-heading">
            <div class="section-heading">
                <p class="eyebrow">Workflow</p>
                <h2 id="workflow-heading">A simple workflow for service communication.</h2>
            </div>

            <ol class="workflow-list">
                <li>
                    <span>1</span>
                    <div>
                        <h3>Publish the current state.</h3>
                        <p>Give customers one public status page for current service health.</p>
                    </div>
                </li>
                <li>
                    <span>2</span>
                    <div>
                        <h3>Update as work progresses.</h3>
                        <p>Post clear incident or maintenance updates as your team investigates and resolves issues.</p>
                    </div>
                </li>
                <li>
                    <span>3</span>
                    <div>
                        <h3>Resolve and keep a history.</h3>
                        <p>Close incidents with a visible record customers and teams can reference later.</p>
                    </div>
                </li>
            </ol>
        </section>

        <section class="feature-section feature-split" aria-labelledby="shipping-heading">
            <div class="section-heading">
                <p class="eyebrow">Always Shipping</p>
                <h2 id="shipping-heading">Built for teams that release, learn, and improve.</h2>
            </div>
            <div class="feature-panel">
                <p>
                    Most customer communication tools treat launches as the finish line.
                    Not Done is designed around the reality that products keep changing:
                    incidents happen, maintenance is scheduled, systems recover, and
                    teams keep shipping.
                </p>
            </div>
        </section>

        <section class="feature-section" aria-labelledby="trust-heading">
            <div class="section-heading">
                <p class="eyebrow">Trust</p>
                <h2 id="trust-heading">Make progress visible before customers have to ask.</h2>
            </div>

            <div class="trust-grid">
                <p>Reduce uncertainty with clear service health communication.</p>
                <p>Give customers one source of truth during incidents and maintenance.</p>
                <p>Build confidence by showing that your team is present and responsive.</p>
            </div>
        </section>

        <section class="features-cta" aria-labelledby="features-cta-heading">
            <p class="eyebrow">Start</p>
            <h2 id="features-cta-heading">Give customers a clearer view of your service health.</h2>
            <div class="features-cta__actions">
                <a class="contact-link" href="{{ route('get-started') }}">
                    Get Started
                </a>
                <a class="feature-secondary-link" href="{{ route('pricing') }}">
                    View pricing
                </a>
            </div>
        </section>
    </section>
@endsection
