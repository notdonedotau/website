<?php

namespace App\Models;

use Database\Factories\BlogArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['blog_category_id', 'title', 'slug', 'excerpt', 'og_image', 'body', 'is_published', 'published_at'])]
class BlogArticle extends Model
{
    /** @use HasFactory<BlogArticleFactory> */
    use HasFactory;

    private const GENERATED_OG_IMAGE_VERSION = 2;

    /**
     * @return BelongsTo<BlogCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function ogImageUrl(): string
    {
        if (filled($this->og_image)) {
            return Storage::disk('public')->url($this->og_image);
        }

        return route('blog.og-image', [
            'slug' => $this->slug,
            'v' => self::GENERATED_OG_IMAGE_VERSION,
        ]);
    }

    /**
     * @param  Builder<BlogArticle>  $query
     * @return Builder<BlogArticle>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->where(function (Builder $query): void {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
