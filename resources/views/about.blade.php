@extends('layouts.site', [
    'title' => 'About Us | notdone.au',
    'description' => 'About Not Done Pty Ltd.',
])

@section('content')
    <section class="content-page content-page--narrow about-page">
        <p class="eyebrow">About Us</p>
        <h1>Not Done Pty Ltd</h1>

        <div class="prose-content">
            <p>
                Not Done was built on a simple belief: the best products are
                never finished.
            </p>

            <p>
                We build tools that help businesses stay transparent with their
                customers - starting with status pages that evolve as fast as
                the products behind them.
            </p>

            <p>
                Our approach is straightforward. We do not ship and disappear.
                We release, learn, and improve - continuously. Because
                businesses do not stand still, and neither should the tools they
                rely on.
            </p>

            <p>We focus on:</p>

            <ul>
                <li>Building products that are simple to use, but powerful where it matters</li>
                <li>Giving teams clear visibility into what is happening and what is next</li>
                <li>Continuously improving everything we deliver</li>
            </ul>

            <p>
                Not Done is not just a name. It is how we build.
            </p>
        </div>
    </section>
@endsection
