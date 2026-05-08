@extends('layouts.site', [
    'title' => 'Docs | '.config('app.name'),
    'description' => 'Documentation for setting up and managing Not Done status pages.',
])

@section('content')
    <section class="content-page docs-page">
        <div class="docs-hero">
            <p class="eyebrow">Docs</p>
            <h1>Not Done Docs</h1>
            <p class="page-intro">
                Guides for setting up and managing your status pages, incidents, subscribers,
                billing, and integrations.
            </p>
        </div>

        @include('docs.partials.search', [
            'class' => 'docs-search--centered',
            'inputId' => 'docs-search-main',
            'searchQuery' => $searchQuery,
        ])

        <div class="docs-layout docs-layout--index">
            <aside class="docs-sidebar" aria-label="Docs navigation">
                <h2>Browse docs</h2>
                @foreach ($categories as $category)
                    @if ($category->articles->isNotEmpty())
                        <nav class="docs-sidebar__group" aria-label="{{ $category->name }}">
                            <h3>{{ $category->name }}</h3>
                            @foreach ($category->articles as $article)
                                <a href="{{ route('docs.show', $article->slug) }}">{{ $article->title }}</a>
                            @endforeach
                        </nav>
                    @endif
                @endforeach
            </aside>

            <div class="docs-index">
                @if (filled($searchQuery))
                    <section class="docs-search-results" aria-labelledby="docs-search-results-heading">
                        <div>
                            <p class="eyebrow">Search results</p>
                            <h2 id="docs-search-results-heading">Results for “{{ $searchQuery }}”</h2>
                        </div>

                        @forelse ($searchResults as $article)
                            <a class="docs-card" href="{{ route('docs.show', $article->slug) }}">
                                <span>{{ $article->title }}</span>
                                @if ($article->category)
                                    <small>{{ $article->category->name }}</small>
                                @endif
                                @if (filled($article->excerpt))
                                    <small>{{ $article->excerpt }}</small>
                                @endif
                            </a>
                        @empty
                            <p class="docs-empty-state">
                                No docs matched your search. Try a different term or contact Not Done if you need help finding something.
                            </p>
                        @endforelse
                    </section>
                @endif

                @unless (filled($searchQuery))
                    @foreach ($categories as $category)
                        @if ($category->articles->isNotEmpty())
                            <section class="docs-category">
                                <div>
                                    <h2>{{ $category->name }}</h2>
                                    @if (filled($category->description))
                                        <p>{{ $category->description }}</p>
                                    @endif
                                </div>

                                <div class="docs-card-grid">
                                    @foreach ($category->articles as $article)
                                        <a class="docs-card" href="{{ route('docs.show', $article->slug) }}">
                                            <span>{{ $article->title }}</span>
                                            @if (filled($article->excerpt))
                                                <small>{{ $article->excerpt }}</small>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @endforeach
                @endunless
            </div>
        </div>
    </section>
@endsection
