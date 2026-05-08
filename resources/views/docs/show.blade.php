@php
    use Illuminate\Support\Str;

    $title = ($article->meta_title ?: $article->title).' | '.config('app.name');
    $description = $article->meta_description ?: ($article->excerpt ?: 'Read the Not Done documentation.');
    $displayDate = $article->last_reviewed_at ?? $article->updated_at;
@endphp

@extends('layouts.site', [
    'title' => $title,
    'description' => $description,
])

@push('head')
    <link rel="canonical" href="{{ route('docs.show', $article->slug) }}">
@endpush

@section('content')
    <article class="content-page docs-page">
        <div class="docs-layout">
            <aside class="docs-sidebar" aria-label="Docs navigation">
                <a class="docs-back-link" href="{{ route('docs.index') }}">All docs</a>
                @include('docs.partials.search', [
                    'inputId' => 'docs-search-sidebar',
                    'searchQuery' => request('q'),
                ])
                @foreach ($categories as $category)
                    @if ($category->articles->isNotEmpty())
                        <nav class="docs-sidebar__group" aria-label="{{ $category->name }}">
                            <h3>{{ $category->name }}</h3>
                            @foreach ($category->articles as $sidebarArticle)
                                <a
                                    href="{{ route('docs.show', $sidebarArticle->slug) }}"
                                    @class(['is-active' => $sidebarArticle->is($article)])
                                >
                                    {{ $sidebarArticle->title }}
                                </a>
                            @endforeach
                        </nav>
                    @endif
                @endforeach
            </aside>

            <div class="docs-article">
                <header class="docs-article__header">
                    @if ($article->category)
                        <p class="eyebrow">{{ $article->category->name }}</p>
                    @endif
                    <h1>{{ $article->title }}</h1>
                    @if (filled($article->excerpt))
                        <p class="page-intro">{{ $article->excerpt }}</p>
                    @endif
                    <time datetime="{{ $displayDate->toDateString() }}">
                        {{ $article->last_reviewed_at ? 'Last reviewed' : 'Last updated' }}
                        {{ $displayDate->format('j M Y') }}
                    </time>
                </header>

                <div class="docs-article__content">
                    {!! Str::markdown($article->content, ['html_input' => 'strip']) !!}
                </div>

                @if ($relatedArticles->isNotEmpty())
                    <section class="docs-related">
                        <h2>Related docs</h2>
                        <div class="docs-related__links">
                            @foreach ($relatedArticles as $relatedArticle)
                                <a href="{{ route('docs.show', $relatedArticle->slug) }}">{{ $relatedArticle->title }}</a>
                            @endforeach
                        </div>
                    </section>
                @endif

                <section class="docs-cta">
                    <p>Need help getting set up?</p>
                    <a href="{{ route('contact') }}">Contact Not Done.</a>
                </section>
            </div>
        </div>
    </article>
@endsection
