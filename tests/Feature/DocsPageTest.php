<?php

use App\Models\DocArticle;
use App\Models\DocCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

test('the docs index loads published global documentation without login', function () {
    $category = DocCategory::factory()->create([
        'name' => 'Getting Started',
        'slug' => 'getting-started',
        'sort_order' => 1,
    ]);

    $article = DocArticle::factory()->for($category, 'category')->create([
        'title' => 'Getting Started',
        'slug' => 'getting-started',
        'excerpt' => 'Set up your first status page.',
        'content' => '## Start here',
        'sort_order' => 1,
    ]);

    $hiddenCategory = DocCategory::factory()->hidden()->create([
        'name' => 'Hidden Category',
        'slug' => 'hidden-category',
    ]);

    DocArticle::factory()->for($hiddenCategory, 'category')->create([
        'title' => 'Hidden category article',
        'slug' => 'hidden-category-article',
    ]);

    $this->get('/docs')
        ->assertSuccessful()
        ->assertSee('Not Done Docs')
        ->assertSee('Getting Started')
        ->assertSee($article->excerpt)
        ->assertSee(route('docs.show', $article->slug), false)
        ->assertDontSee('Hidden Category');
});

test('published docs show publicly without login', function () {
    $category = DocCategory::factory()->create([
        'name' => 'Status Pages',
    ]);

    $article = DocArticle::factory()->for($category, 'category')->create([
        'title' => 'Status Pages',
        'slug' => 'status-pages',
        'excerpt' => 'Learn the page model.',
        'content' => "## Overview\n\nStatus page URLs use `your-status-page.status.notdone.cloud`.",
        'meta_title' => 'Status page docs',
        'meta_description' => 'Status page documentation.',
        'last_reviewed_at' => now()->subDay(),
    ]);

    $this->get("/docs/{$article->slug}")
        ->assertSuccessful()
        ->assertSee('<title>Status page docs | '.config('app.name').'</title>', false)
        ->assertSee('name="description"', false)
        ->assertSee('Status page documentation.', false)
        ->assertSee('<link rel="canonical" href="'.route('docs.show', $article->slug).'">', false)
        ->assertSee('Status Pages')
        ->assertSee('your-status-page.status.notdone.cloud')
        ->assertSee('Need help getting set up?')
        ->assertSee('Contact Not Done.');
});

test('unpublished docs return not found publicly', function () {
    $article = DocArticle::factory()->unpublished()->create([
        'slug' => 'private-doc',
    ]);

    $this->get("/docs/{$article->slug}")
        ->assertNotFound();
});

test('unknown docs slug returns not found', function () {
    $this->get('/docs/unknown-doc')
        ->assertNotFound();
});

test('docs index can search published visible documentation', function () {
    $category = DocCategory::factory()->create([
        'name' => 'Status Pages',
    ]);

    $matchingArticle = DocArticle::factory()->for($category, 'category')->create([
        'title' => 'Custom Domains',
        'slug' => 'custom-domains',
        'excerpt' => 'Use status.example.com for your status page.',
        'content' => 'Growth plan customers can use custom domains.',
    ]);

    DocArticle::factory()->for($category, 'category')->create([
        'title' => 'Incidents',
        'slug' => 'incidents',
        'excerpt' => 'Communicate service interruptions.',
        'content' => 'Incident updates keep subscribers informed.',
    ]);

    DocArticle::factory()->unpublished()->for($category, 'category')->create([
        'title' => 'Private Domains',
        'slug' => 'private-domains',
        'content' => 'domains',
    ]);

    $hiddenCategory = DocCategory::factory()->hidden()->create();

    DocArticle::factory()->for($hiddenCategory, 'category')->create([
        'title' => 'Hidden Domains',
        'slug' => 'hidden-domains',
        'content' => 'domains',
    ]);

    $this->get('/docs?q=domains')
        ->assertSuccessful()
        ->assertSee('Results for')
        ->assertSee('value="domains"', false)
        ->assertSee($matchingArticle->title)
        ->assertSee(route('docs.show', $matchingArticle->slug), false)
        ->assertDontSee('Private Domains')
        ->assertDontSee('Hidden Domains')
        ->assertDontSee('Communicate service interruptions.');
});

test('docs search shows an empty state when there are no matches', function () {
    DocArticle::factory()->create([
        'title' => 'Getting Started',
        'content' => 'Create your first status page.',
    ]);

    $this->get('/docs?q=webhooks')
        ->assertSuccessful()
        ->assertSee('No docs matched your search')
        ->assertSee('value="webhooks"', false);
});

test('docs are global and not workspace scoped', function () {
    $article = DocArticle::factory()->create([
        'slug' => 'global-doc',
    ]);

    expect(Schema::hasColumn('doc_categories', 'workspace_id'))->toBeFalse()
        ->and(Schema::hasColumn('doc_articles', 'workspace_id'))->toBeFalse();

    $this->get("/docs/{$article->slug}")
        ->assertSuccessful();
});

test('docs routes are registered before any status page wildcard route', function () {
    $routes = collect(app('router')->getRoutes()->getRoutes())
        ->map(fn ($route) => $route->uri())
        ->values();

    expect($routes->search('docs'))->not->toBeFalse()
        ->and($routes->search('docs/{slug}'))->not->toBeFalse();
});
