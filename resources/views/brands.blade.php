@extends('layouts.site')

@section('content')
    <section class="content-page">
        <p class="eyebrow">Brands</p>
        <h1>Brands</h1>
        <p class="page-intro">
            
        </p>

        <div class="brands-grid">
            <article class="brand-card">
                <img
                    class="brand-logo brand-logo--light"
                    src="{{ asset('images/jmco-logo.svg') }}"
                    alt="JMCO.cx"
                >
                <img
                    class="brand-logo brand-logo--dark"
                    src="{{ asset('images/jmco-logo-dark.svg') }}"
                    alt="JMCO.cx"
                >

                <p class="brand-copy">
                    JMCO.cx is a customer experience platform focused on
                    roadmaps, status pages, and feedback to help teams share
                    updates clearly and keep customers in the loop.
                </p>

                <a
                    class="brand-link"
                    href="https://jmco.cx"
                    target="_blank"
                    rel="noreferrer"
                >
                    Visit Website
                </a>
            </article>
        </div>
    </section>
@endsection
