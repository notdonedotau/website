<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can access blog management resources', function (string $path, string $heading) {
    $user = User::factory()->create([
        'email' => 'editor@notdone.cloud',
    ]);

    $this->actingAs($user)
        ->get($path)
        ->assertSuccessful()
        ->assertSee($heading);
})->with([
    'articles' => ['/manage/blog-articles', 'Blog Articles'],
    'categories' => ['/manage/blog-categories', 'Blog Categories'],
]);

test('the article form uses a markdown editor for blog posts', function () {
    $user = User::factory()->create([
        'email' => 'editor@notdone.cloud',
    ]);

    $this->actingAs($user)
        ->get('/manage/blog-articles/create')
        ->assertSuccessful()
        ->assertSee('Markdown')
        ->assertSee('OG image')
        ->assertSee('Write blog posts in Markdown.');
});

test('verified notdone users can access their filament profile page', function () {
    $user = User::factory()->create([
        'email' => 'editor@notdone.cloud',
    ]);

    $this->actingAs($user)
        ->get('/manage/profile')
        ->assertSuccessful()
        ->assertSee('Profile');
});

test('authenticated admin users can access docs management resources', function (string $path, string $heading) {
    $user = User::factory()->create([
        'email' => 'docs-admin@notdone.cloud',
    ]);

    $this->actingAs($user)
        ->get($path)
        ->assertSuccessful()
        ->assertSee($heading);
})->with([
    'doc articles' => ['/manage/doc-articles', 'Doc Articles'],
    'doc categories' => ['/manage/doc-categories', 'Doc Categories'],
]);

test('the docs article form uses markdown content and seo fields', function () {
    $user = User::factory()->create([
        'email' => 'docs-editor@notdone.cloud',
    ]);

    $this->actingAs($user)
        ->get('/manage/doc-articles/create')
        ->assertSuccessful()
        ->assertSee('content')
        ->assertSee('Write documentation in Markdown.')
        ->assertSee('meta_title')
        ->assertSee('last_reviewed_at');
});

test('guests are redirected away from blog management resources', function () {
    $this->get('/manage/blog-articles')
        ->assertRedirect();
});

test('filament access requires a verified notdone cloud email address', function () {
    $externalUser = User::factory()->create([
        'email' => 'editor@example.com',
    ]);

    expect($externalUser->canAccessPanel(filament()->getPanel('manage')))->toBeFalse();

    $unverifiedUser = User::factory()->unverified()->create([
        'email' => 'editor@notdone.cloud',
    ]);

    expect($unverifiedUser->canAccessPanel(filament()->getPanel('manage')))->toBeFalse();

    $verifiedUser = User::factory()->create([
        'email' => 'verified@notdone.cloud',
    ]);

    expect($verifiedUser->canAccessPanel(filament()->getPanel('manage')))->toBeTrue();
});
