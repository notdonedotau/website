<?php

namespace Database\Factories;

use App\Models\DocArticle;
use App\Models\DocCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<DocArticle>
 */
class DocArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'doc_category_id' => DocCategory::factory(),
            'title' => Str::headline($title),
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(),
            'content' => "## Overview\n\n".fake()->paragraph()."\n\nThis feature may still be rolling out. If it is important to your setup, contact Not Done before relying on it.",
            'sort_order' => fake()->numberBetween(0, 50),
            'is_published' => true,
            'published_at' => now()->subDay(),
            'meta_title' => null,
            'meta_description' => null,
            'last_reviewed_at' => now()->subDay(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => now()->addDay(),
        ]);
    }
}
