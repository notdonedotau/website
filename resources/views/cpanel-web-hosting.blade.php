@extends('layouts.site', [
    'title' => 'cPanel Web Hosting | notdone.au',
    'description' => 'Choose from three cPanel web hosting packages.',
])

@section('content')
    <section class="content-page services-page">
        <p class="eyebrow">cPanel Web Hosting</p>
        <h1>cPanel hosting packages.</h1>
        <p class="page-intro">
            Simple cPanel hosting packages for websites, email, and day-to-day
            business hosting.
        </p>

        <section class="service-section" aria-labelledby="hosting-heading">
            <div class="section-heading">
                <h2 id="hosting-heading">Three packages for growing websites</h2>
                <p>
                    Each package includes cPanel access, SSL support, email
                    accounts, backups, and practical setup assistance.
                </p>
            </div>

            <div class="hosting-grid">
                @foreach ([
                    [
                        'name' => 'Starter',
                        'price' => '$9.99',
                        'summary' => 'For a single small website or landing page.',
                        'features' => ['1 website', '10 GB SSD storage', '5 email accounts'],
                    ],
                    [
                        'name' => 'Business',
                        'price' => '$19.99',
                        'summary' => 'For established sites that need more room.',
                        'features' => ['5 websites', '40 GB SSD storage', '25 email accounts'],
                    ],
                    [
                        'name' => 'Commerce',
                        'price' => '$34.99',
                        'summary' => 'For shops and busy content-heavy websites.',
                        'features' => ['10 websites', '100 GB SSD storage', 'Unlimited email accounts'],
                    ],
                ] as $package)
                    <article class="hosting-card">
                        <h3>{{ $package['name'] }}</h3>
                        <p class="service-price">{{ $package['price'] }} <span>/ month</span></p>
                        <p>{{ $package['summary'] }}</p>
                        <ul>
                            @foreach ($package['features'] as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
        </section>

        <a class="contact-link" href="mailto:hello@notdone.au">
            Request hosting pricing
        </a>
    </section>
@endsection
