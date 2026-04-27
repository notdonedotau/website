@extends('layouts.site', [
    'title' => 'Pricing | notdone.au',
    'description' => 'Simple pricing for Not Done status pages.',
])

@section('content')
    <section class="content-page pricing-page">
        <p class="eyebrow">Pricing</p>
        <h1>Plans for keeping customers in the loop.</h1>
        <p class="page-intro">
            Start with a clear status page, then add custom domains, branding
            control, and team features as your service grows.
        </p>
        <div class="pricing-notes" aria-label="Pricing offers">
            <p>Free for 30 days.</p>
            <p>Annual plans include 2 months free.</p>
        </div>

        <div class="pricing-grid">
            <article class="pricing-card pricing-card--starter">
                <div class="pricing-card__badge pricing-card__badge--empty" aria-hidden="true">Core plan</div>
                <div class="pricing-card__header">
                    <p class="pricing-card__label">Starter</p>
                    <p class="pricing-card__price">$9<span>/mo</span></p>
                </div>
                <p class="pricing-card__summary">
                    For indie developers and small businesses launching a simple public hub.
                </p>
                <ul class="pricing-card__features">
                    <li>1 workspace</li>
                    <li>1-2 projects</li>
                    <li>Basic status page</li>
                    <li>Core components</li>
                    <li>"Powered by Not Done" branding</li>
                </ul>
                <a class="pricing-card__order" href="https://account.notdone.au?plan=starter">
                    Get Started
                </a>
            </article>

            <article class="pricing-card pricing-card--growth pricing-card--featured">
                <div class="pricing-card__badge">Core plan</div>
                <div class="pricing-card__header">
                    <p class="pricing-card__label">Growth</p>
                    <p class="pricing-card__price">$29<span>/mo</span></p>
                </div>
                <p class="pricing-card__summary">
                    For growing products that need a branded status page and clearer customer communication.
                </p>
                <ul class="pricing-card__features">
                    <li>1 workspace</li>
                    <li>Multiple projects</li>
                    <li>Status pages and components</li>
                    <li>Custom domain</li>
                    <li>Remove branding</li>
                    <li>Basic integrations</li>
                </ul>
                <a class="pricing-card__order" href="https://account.notdone.au?plan=growth">
                    Get Started
                </a>
            </article>

            <article class="pricing-card pricing-card--business">
                <div class="pricing-card__badge pricing-card__badge--empty" aria-hidden="true">Core plan</div>
                <div class="pricing-card__header">
                    <p class="pricing-card__label">Business</p>
                    <p class="pricing-card__price">$79<span>/mo</span></p>
                </div>
                <p class="pricing-card__summary">
                    For teams that need more seats, more control, and priority support.
                </p>
                <ul class="pricing-card__features">
                    <li>More admin users</li>
                    <li>More components and projects</li>
                    <li>Priority support</li>
                    <li>Advanced permissions</li>
                    <li>SLA and uptime features later</li>
                </ul>
                <a class="pricing-card__order" href="https://account.notdone.au?plan=business">
                    Get Started
                </a>
            </article>
        </div>

        <a class="contact-link" href="{{ route('contact') }}">
            Talk to us
        </a>

        <section class="pricing-comparison" aria-labelledby="pricing-comparison-heading">
            <div class="section-heading">
                <p class="eyebrow">Compare Plans</p>
                <h2 id="pricing-comparison-heading">Features by plan.</h2>
            </div>

            <div class="pricing-table-wrap">
                <table class="pricing-table">
                    <thead>
                        <tr>
                            <th scope="col">Feature</th>
                            <th scope="col">Starter</th>
                            <th scope="col">Growth</th>
                            <th scope="col">Business</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Price</th>
                            <td>$9/mo</td>
                            <td>$29/mo</td>
                            <td>$79/mo</td>
                        </tr>
                        <tr>
                            <th scope="row">Free trial</th>
                            <td>30 days</td>
                            <td>30 days</td>
                            <td>30 days</td>
                        </tr>
                        <tr>
                            <th scope="row">Annual discount</th>
                            <td>2 months free</td>
                            <td>2 months free</td>
                            <td>2 months free</td>
                        </tr>
                        <tr>
                            <th scope="row">Workspaces</th>
                            <td>1</td>
                            <td>1</td>
                            <td>1+</td>
                        </tr>
                        <tr>
                            <th scope="row">Projects</th>
                            <td>1-2</td>
                            <td>Multiple</td>
                            <td>More projects</td>
                        </tr>
                        <tr>
                            <th scope="row">Status page</th>
                            <td>Basic</td>
                            <td>Included</td>
                            <td>Included</td>
                        </tr>
                        <tr>
                            <th scope="row">Components</th>
                            <td>Core components</td>
                            <td>Multiple components</td>
                            <td>More components</td>
                        </tr>
                        <tr>
                            <th scope="row">Custom domain</th>
                            <td>Not included</td>
                            <td>Included</td>
                            <td>Included</td>
                        </tr>
                        <tr>
                            <th scope="row">Branding</th>
                            <td>Powered by Not Done</td>
                            <td>Remove branding</td>
                            <td>Remove branding</td>
                        </tr>
                        <tr>
                            <th scope="row">Admin users</th>
                            <td>Standard</td>
                            <td>Standard</td>
                            <td>More admin users</td>
                        </tr>
                        <tr>
                            <th scope="row">Permissions</th>
                            <td>Standard</td>
                            <td>Standard</td>
                            <td>Advanced</td>
                        </tr>
                        <tr>
                            <th scope="row">Support</th>
                            <td>Standard</td>
                            <td>Standard</td>
                            <td>Priority</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
@endsection
