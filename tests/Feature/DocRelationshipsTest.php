<?php

use App\Models\DocArticle;
use App\Models\DocCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('doc article belongs to a doc category', function () {
    $category = DocCategory::factory()->create();
    $article = DocArticle::factory()->for($category, 'category')->create();

    expect($article->category)->toBeInstanceOf(DocCategory::class)
        ->and($article->category->is($category))->toBeTrue();
});

test('doc category has many doc articles', function () {
    $category = DocCategory::factory()
        ->has(DocArticle::factory()->count(2), 'articles')
        ->create();

    expect($category->articles)->toHaveCount(2)
        ->and($category->articles->first())->toBeInstanceOf(DocArticle::class);
});
