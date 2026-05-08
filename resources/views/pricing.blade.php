@extends('layouts.site', [
    'title' => 'Pricing | '.config('app.name'),
    'description' => 'Simple pricing for Not Done status pages.',
])

@section('content')
    <section class="content-page pricing-page">
        <p class="eyebrow">Status Page Pricing</p>
        <h1>Plans for keeping customers in the loop.</h1>
        <p class="page-intro">
            Start with a clear status page, then add custom domains, branding
            control, and team features as your service grows.
        </p>

        @include('partials.product-notice')

        <div class="pricing-notes" aria-label="Pricing offers">
            <p class="trial-note">
                <svg class="trial-note__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M3.5 7.5A2.5 2.5 0 0 1 6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9Z" />
                    <path d="M3.5 9h17M7 15h3" />
                </svg>
                <span>No credit card required. 1-month free trial.</span>
            </p>
            <p>Annual plans include two months off.</p>
        </div>
        <div class="pricing-period-toggle" role="group" aria-label="Choose billing period">
            <button class="pricing-period-toggle__button is-active" type="button" data-pricing-period="monthly" aria-pressed="true">
                Monthly
            </button>
            <button class="pricing-period-toggle__button" type="button" data-pricing-period="annual" aria-pressed="false">
                Annual
            </button>
        </div>

        <div class="pricing-grid">
            <article class="pricing-card pricing-card--starter">
                <div class="pricing-card__header">
                    <p class="pricing-card__label">Starter</p>
                    <p class="pricing-card__price" data-monthly-price="$9" data-annual-price="$90" data-monthly-suffix="/mo" data-annual-suffix="/yr">
                        <span data-pricing-price>$9</span><span data-pricing-suffix>/mo</span>
                    </p>
                </div>
                <p class="pricing-card__summary">
                    For indie developers and small businesses launching a simple public hub.
                </p>
                <ul class="pricing-card__features">
                    <li>10 Components</li>
                    <li>1 Admin User</li>
                    <li>250 Subscribers</li>
                    <li>Public/private components</li>
                    <li>Email, Slack, and Microsoft Teams notifications</li>
                    <li>Basic customisation</li>
                </ul>
                <a
                    class="pricing-card__order"
                    href="{{ route('get-started', ['plan' => 'starter']) }}"
                    data-monthly-url="{{ route('get-started', ['plan' => 'starter']) }}"
                    data-annual-url="{{ route('get-started', ['plan' => 'starter']) }}"
                >
                    Get Started
                </a>
            </article>

            <article class="pricing-card pricing-card--growth pricing-card--featured">
                <div class="pricing-card__badge pricing-card__badge--recommended">Recommended</div>
                <div class="pricing-card__header">
                    <p class="pricing-card__label">Growth</p>
                    <p class="pricing-card__price" data-monthly-price="$29" data-annual-price="$290" data-monthly-suffix="/mo" data-annual-suffix="/yr">
                        <span data-pricing-price>$29</span><span data-pricing-suffix>/mo</span>
                    </p>
                </div>
                <p class="pricing-card__summary">
                    For growing products that need a branded status page and clearer customer communication.
                </p>
                <ul class="pricing-card__features">
                    <li>100 Components</li>
                    <li>3 Admin Users</li>
                    <li>1000 Subscribers</li>
                    <li>SMS notifications</li>
                    <li>Web hooks</li>
                    <li>Custom domain</li>
                    <li>Custom CSS</li>
                </ul>
                <a
                    class="pricing-card__order"
                    href="{{ route('get-started') }}"
                    data-monthly-url="{{ route('get-started') }}"
                    data-annual-url="{{ route('get-started') }}"
                >
                    Get Started
                </a>
            </article>

            <article class="pricing-card pricing-card--business">
                <div class="pricing-card__header">
                    <p class="pricing-card__label">Business</p>
                    <p class="pricing-card__price" data-monthly-price="$79" data-annual-price="$790" data-monthly-suffix="/mo" data-annual-suffix="/yr">
                        <span data-pricing-price>$79</span><span data-pricing-suffix>/mo</span>
                    </p>
                </div>
                <p class="pricing-card__summary">
                    For teams that need more seats, more control, and priority support.
                </p>
                <ul class="pricing-card__features">
                    <li>250 Components</li>
                    <li>10 Admin Users</li>
                    <li>2000 Subscribers</li>
                    <li>SMS notifications</li>
                    <li>Web hooks</li>
                    <li>Custom CSS/HTML/JS</li>
                    <li>Custom roles</li>
                    <li>Audit logs</li>
                </ul>
                <a
                    class="pricing-card__order"
                    href="{{ route('get-started', ['plan' => 'business']) }}"
                    data-monthly-url="{{ route('get-started', ['plan' => 'business']) }}"
                    data-annual-url="{{ route('get-started', ['plan' => 'business']) }}"
                >
                    Get Started
                </a>
            </article>
        </div>

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
                        <tr class="pricing-table__section">
                            <th colspan="4">Billing</th>
                        </tr>
                        <tr>
                            <th scope="row">Price</th>
                            <td>$9/mo</td>
                            <td>$29/mo</td>
                            <td>$79/mo</td>
                        </tr>
                        <tr>
                            <th scope="row">Monthly trial</th>
                            <td>30 days</td>
                            <td>30 days</td>
                            <td>30 days</td>
                        </tr>
                        <tr>
                            <th scope="row">Annual discount</th>
                            <td>Two months off</td>
                            <td>Two months off</td>
                            <td>Two months off</td>
                        </tr>

                        <tr class="pricing-table__section">
                            <th colspan="4">Usage</th>
                        </tr>
                        <tr>
                            <th scope="row">
                                <span class="pricing-table__label">
                                    Components
                                    <span class="pricing-tooltip" tabindex="0" aria-label="Components: Services, APIs, regions, or systems you show on your status page.">
                                        <span class="pricing-tooltip__trigger" aria-hidden="true">?</span>
                                        <span class="pricing-tooltip__content" role="tooltip">Services, APIs, regions, or systems you show on your status page.</span>
                                    </span>
                                </span>
                            </th>
                            <td>10</td>
                            <td>100</td>
                            <td>250</td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <span class="pricing-table__label">
                                    Admin users
                                    <span class="pricing-tooltip" tabindex="0" aria-label="Admin users: People who can sign in to manage status pages, components, incidents, and settings.">
                                        <span class="pricing-tooltip__trigger" aria-hidden="true">?</span>
                                        <span class="pricing-tooltip__content" role="tooltip">People who can sign in to manage status pages, components, incidents, and settings.</span>
                                    </span>
                                </span>
                            </th>
                            <td>1</td>
                            <td>3</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <span class="pricing-table__label">
                                    Subscribers
                                    <span class="pricing-tooltip" tabindex="0" aria-label="Subscribers: People who subscribe to receive updates about incidents, maintenance, or component changes.">
                                        <span class="pricing-tooltip__trigger" aria-hidden="true">?</span>
                                        <span class="pricing-tooltip__content" role="tooltip">People who subscribe to receive updates about incidents, maintenance, or component changes.</span>
                                    </span>
                                </span>
                            </th>
                            <td>250</td>
                            <td>1000</td>
                            <td>2000</td>
                        </tr>

                        <tr class="pricing-table__section">
                            <th colspan="4">Components</th>
                        </tr>
                        <tr>
                            <th scope="row">
                                <span class="pricing-table__label">
                                    Public/private components
                                    <span class="pricing-tooltip" tabindex="0" aria-label="Public and private components: Control whether a component is visible publicly or only to selected signed-in users.">
                                        <span class="pricing-tooltip__trigger" aria-hidden="true">?</span>
                                        <span class="pricing-tooltip__content" role="tooltip">Control whether a component is visible publicly or only to selected signed-in users.</span>
                                    </span>
                                </span>
                            </th>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <span class="pricing-table__label">
                                    Individual role/user components
                                    <span class="pricing-tooltip" tabindex="0" aria-label="Individual role and user components: Assign component access to specific users or roles for more precise visibility.">
                                        <span class="pricing-tooltip__trigger" aria-hidden="true">?</span>
                                        <span class="pricing-tooltip__content" role="tooltip">Assign component access to specific users or roles for more precise visibility.</span>
                                    </span>
                                </span>
                            </th>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>

                        <tr class="pricing-table__section">
                            <th colspan="4">Notifications</th>
                        </tr>
                        <tr>
                            <th scope="row">Email notifications</th>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Slack notifications</th>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Microsoft Teams notifications</th>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">SMS notifications <span class="pricing-table__asterisk" aria-hidden="true">*</span></th>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Web hooks</th>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr class="pricing-table__note">
                            <td colspan="4"><span aria-hidden="true">*</span> Additional charges apply.</td>
                        </tr>

                        <tr class="pricing-table__section">
                            <th colspan="4">Customisation</th>
                        </tr>
                        <tr>
                            <th scope="row">Basic customisation</th>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Custom domain</th>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Custom CSS</th>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Custom HTML/JS</th>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr class="pricing-table__section">
                            <th colspan="4">Security &amp; Administration</th>
                        </tr>
                        <tr>
                            <th scope="row">Custom roles</th>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Audit logs</th>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--no" role="img" aria-label="Not included"></span></td>
                            <td><span class="pricing-table__icon pricing-table__icon--yes" role="img" aria-label="Included"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <section class="pricing-addons" aria-labelledby="pricing-addons-heading">
                <div class="section-heading">
                    <p class="eyebrow">Business Add-ons</p>
                    <h3 id="pricing-addons-heading">Scale beyond the included limits.</h3>
                </div>

                <div class="pricing-addons__grid">
                    <article class="pricing-addon">
                        <h4>Additional components</h4>
                        <p>Available for Business plans that need more than 250 components.</p>
                    </article>
                    <article class="pricing-addon">
                        <h4>Additional subscribers</h4>
                        <p>Available for Business plans that need more than 2000 subscribers.</p>
                    </article>
                    <article class="pricing-addon">
                        <h4>Additional admin users</h4>
                        <p>Available for Business plans that need more than 10 admin users.</p>
                    </article>
                </div>
            </section>
        </section>
    </section>
@endsection
