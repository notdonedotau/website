@extends('layouts.site', [
    'title' => 'Domains | notdone.au',
    'description' => 'Register top domain extensions in USD.',
])

@section('content')
    <section class="content-page services-page">
        <p class="eyebrow">Domains</p>
        <h1>Top domains in USD.</h1>
        <p class="page-intro">
            Register popular domain extensions for business websites, products,
            campaigns, and online stores. Annual registration pricing is shown
            in USD.
        </p>

        <section class="service-section" aria-labelledby="domains-heading">
            <div class="section-heading">
                <h2 id="domains-heading">Top 10 domain extensions</h2>
                <p>
                    Transfers and renewals can be quoted before purchase.
                </p>
            </div>

            <div class="domain-grid">
                @foreach ([
                    ['extension' => '.com', 'price' => '$14.99', 'note' => 'Global business standard'],
                    ['extension' => '.net', 'price' => '$16.99', 'note' => 'Networks and infrastructure'],
                    ['extension' => '.org', 'price' => '$15.99', 'note' => 'Communities and organisations'],
                    ['extension' => '.io', 'price' => '$44.99', 'note' => 'Software and startup teams'],
                    ['extension' => '.ai', 'price' => '$79.99', 'note' => 'AI products and labs'],
                    ['extension' => '.co', 'price' => '$29.99', 'note' => 'Companies and creators'],
                    ['extension' => '.dev', 'price' => '$18.99', 'note' => 'Developers and tools'],
                    ['extension' => '.app', 'price' => '$19.99', 'note' => 'Apps and platforms'],
                    ['extension' => '.online', 'price' => '$24.99', 'note' => 'Campaigns and launches'],
                    ['extension' => '.store', 'price' => '$34.99', 'note' => 'Retail and ecommerce'],
                ] as $domain)
                    <article class="domain-card">
                        <h3>{{ $domain['extension'] }}</h3>
                        <p class="service-price">{{ $domain['price'] }} <span>/ year</span></p>
                        <p>{{ $domain['note'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <a class="contact-link" href="mailto:hello@notdone.au">
            Request domain pricing
        </a>
    </section>
@endsection
