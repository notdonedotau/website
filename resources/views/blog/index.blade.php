@extends('layouts.site', [
    'title' => 'Blog | '.config('app.name'),
    'description' => 'Updates and notes from Not Done.',
])

@section('content')
    <section class="content-page blog-page">
        <div class="blog-hero">
            <p class="eyebrow">Blog</p>
            <h1>Updates, notes, and product thinking.</h1>
            <p class="page-intro">
                Practical notes on service communication, product transparency,
                and what we are building at Not Done.
            </p>
        </div>

        @if ($articles->isNotEmpty())
            <div class="blog-grid">
                @foreach ($articles as $article)
                    <article class="blog-card">
                        <a class="blog-card__image" href="{{ route('blog.show', $article->slug) }}" aria-label="Read {{ $article->title }}">
                            <img src="{{ $article->ogImageUrl() }}" alt="">
                        </a>
                        <div class="blog-card__meta">
                            @if ($article->category)
                                <span>{{ $article->category->name }}</span>
                            @endif
                            <time datetime="{{ ($article->published_at ?? $article->created_at)->toDateString() }}">
                                {{ ($article->published_at ?? $article->created_at)->format('j M Y') }}
                            </time>
                        </div>
                        <h2>
                            <a href="{{ route('blog.show', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h2>
                        @if (filled($article->excerpt))
                            <p>{{ $article->excerpt }}</p>
                        @endif
                        <a class="blog-card__link" href="{{ route('blog.show', $article->slug) }}">
                            Read article
                        </a>
                    </article>
                @endforeach
            </div>

            <div class="blog-pagination">
                {{ $articles->links() }}
            </div>
        @else
            <div class="blog-empty">
                <h2>No articles published yet.</h2>
                <p>Check back soon for updates from Not Done.</p>
            </div>
        @endif
    </section>
@endsection
