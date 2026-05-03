@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.site', [
    'title' => $article->title.' | '.config('app.name'),
    'description' => $article->excerpt ?: 'Read the latest from Not Done.',
])

@push('head')
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->excerpt ?: 'Read the latest from Not Done.' }}">
    <meta property="og:image" content="{{ $article->ogImageUrl() }}">
    <meta name="twitter:card" content="summary_large_image">
@endpush

@section('content')
    <article class="content-page blog-article-page">
        <a class="blog-back-link" href="{{ route('blog.index') }}">Back to blog</a>

        <header class="blog-article-header">
            <div class="blog-card__meta">
                @if ($article->category)
                    <span>{{ $article->category->name }}</span>
                @endif
                <time datetime="{{ ($article->published_at ?? $article->created_at)->toDateString() }}">
                    {{ ($article->published_at ?? $article->created_at)->format('j M Y') }}
                </time>
            </div>
            <h1>{{ $article->title }}</h1>
            @if (filled($article->excerpt))
                <p class="page-intro">{{ $article->excerpt }}</p>
            @endif
        </header>

        <div class="blog-article-content">
            {!! Str::markdown($article->body, ['html_input' => 'strip']) !!}
        </div>
    </article>
@endsection
