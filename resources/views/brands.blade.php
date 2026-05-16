@extends('layouts.site', [
    'title' => 'Brands | '.config('app.name'),
    'description' => 'Brands by Not Done Pty Ltd.',
])

@section('content')
    <section class="content-page content-page--narrow !mx-0 !px-0">
        <p class="eyebrow">Brands</p>
        <h1>Brands we are building.</h1>
        <p class="page-intro">
            Not Done Pty Ltd builds practical products that keep improving after launch.
        </p>

        <div class="home-card-grid">
            <article class="home-info-card">
                <h3>StackedPay</h3>
                <p>A simpler way for Australians to lay-by gift cards with no hidden fees.</p>
                <p>
                    <a href="https://stackedpay.com.au">Visit stackedpay.com.au</a>
                </p>
            </article>
        </div>
    </section>
@endsection
