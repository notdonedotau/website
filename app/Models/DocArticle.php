<?php

namespace App\Models;

use Database\Factories\DocArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['doc_category_id', 'title', 'slug', 'excerpt', 'content', 'sort_order', 'is_published', 'published_at', 'meta_title', 'meta_description', 'last_reviewed_at'])]
class DocArticle extends Model
{
    /** @use HasFactory<DocArticleFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<DocCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(DocCategory::class, 'doc_category_id');
    }

    /**
     * @param  Builder<DocArticle>  $query
     * @return Builder<DocArticle>
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

    public function isPublic(): bool
    {
        return $this->is_published && ($this->published_at === null || $this->published_at->isPast());
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'last_reviewed_at' => 'datetime',
        ];
    }
}
