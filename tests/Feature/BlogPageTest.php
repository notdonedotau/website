<?php

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the blog index lists published articles', function () {
    $category = BlogCategory::factory()->create([
        'name' => 'Product Updates',
        'slug' => 'product-updates',
    ]);

    $publishedArticle = BlogArticle::factory()->for($category, 'category')->create([
        'title' => 'Building clearer status pages',
        'slug' => 'building-clearer-status-pages',
        'excerpt' => 'A practical update about service communication.',
        'og_image' => 'blog/og-images/status-pages.jpg',
        'body' => 'Published body.',
        'published_at' => now()->subDay(),
    ]);

    BlogArticle::factory()->draft()->create([
        'title' => 'Draft article',
        'slug' => 'draft-article',
    ]);

    BlogArticle::factory()->create([
        'title' => 'Scheduled article',
        'slug' => 'scheduled-article',
        'is_published' => true,
        'published_at' => now()->addDay(),
    ]);

    $this->get('/blog')
        ->assertSuccessful()
        ->assertSee('Updates, notes, and product thinking.')
        ->assertSee('Product Updates')
        ->assertSee($publishedArticle->title)
        ->assertSee($publishedArticle->excerpt)
        ->assertSee('storage/blog/og-images/status-pages.jpg', false)
        ->assertSee(route('blog.show', $publishedArticle->slug), false)
        ->assertDontSee('Draft article')
        ->assertDontSee('Scheduled article');
});

test('published articles without a published date are immediately public', function () {
    $article = BlogArticle::factory()->create([
        'title' => 'Immediate article',
        'slug' => 'immediate-article',
        'is_published' => true,
        'published_at' => null,
    ]);

    $this->get('/blog')
        ->assertSuccessful()
        ->assertSee($article->title);

    $this->get("/blog/{$article->slug}")
        ->assertSuccessful()
        ->assertSee($article->title);
});

test('articles without an uploaded image use a generated og image', function () {
    $article = BlogArticle::factory()->create([
        'title' => 'Operational updates without surprises',
        'slug' => 'operational-updates-without-surprises',
        'excerpt' => 'A short update about communicating work in progress.',
        'og_image' => null,
        'published_at' => now()->subDay(),
    ]);

    $generatedImageUrl = $article->ogImageUrl();

    $this->get('/blog')
        ->assertSuccessful()
        ->assertSee($generatedImageUrl, false);

    $this->get("/blog/{$article->slug}")
        ->assertSuccessful()
        ->assertSee('<meta property="og:image" content="'.$generatedImageUrl.'">', false)
        ->assertDontSee('<img src="'.$generatedImageUrl.'" alt="">', false)
        ->assertDontSee('class="blog-article-image"', false)
        ->assertSee('?v=2', false);
});

test('the blog article page shows published article content', function () {
    $article = BlogArticle::factory()->create([
        'title' => 'Incident communication that helps',
        'slug' => 'incident-communication-that-helps',
        'excerpt' => 'How to keep customers informed.',
        'og_image' => 'blog/og-images/incidents.jpg',
        'body' => "## Keep updates clear\n\nCustomers need **context**, timing, and next steps.\n\n<script>alert('xss')</script>",
        'published_at' => now()->subDay(),
    ]);

    $this->get("/blog/{$article->slug}")
        ->assertSuccessful()
        ->assertSee('<title>Incident communication that helps | '.config('app.name').'</title>', false)
        ->assertSee('How to keep customers informed.')
        ->assertSee('storage/blog/og-images/incidents.jpg', false)
        ->assertSee('Keep updates clear')
        ->assertSee('<strong>context</strong>', false)
        ->assertSee('Customers need')
        ->assertDontSee("<script>alert('xss')</script>", false);
});

test('unpublished blog articles are not public', function () {
    $article = BlogArticle::factory()->draft()->create([
        'slug' => 'private-draft',
    ]);

    $this->get("/blog/{$article->slug}")
        ->assertNotFound();
});

test('the generated og image endpoint returns an svg for published articles', function () {
    $category = BlogCategory::factory()->create([
        'name' => 'Product Updates',
    ]);

    $article = BlogArticle::factory()->for($category, 'category')->create([
        'title' => 'Generated images keep previews consistent',
        'slug' => 'generated-images-keep-previews-consistent',
        'published_at' => now()->subDay(),
    ]);

    $this->get(route('blog.og-image', $article->slug))
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'image/svg+xml')
        ->assertHeaderContains('Cache-Control', 'no-cache')
        ->assertSee('<svg', false)
        ->assertSee('<rect width="1200" height="630" fill="#fff7f2"/>', false)
        ->assertDontSee('<rect width="1200" height="630" fill="#0b0b0b"/>', false)
        ->assertSee('Generated images keep previews consistent')
        ->assertSee('Product Updates');
});

test('the generated og image endpoint hides unpublished articles', function () {
    $article = BlogArticle::factory()->draft()->create([
        'slug' => 'private-generated-image',
    ]);

    $this->get(route('blog.og-image', $article->slug))
        ->assertNotFound();
});
