<?php

namespace App\Models;

use Database\Factories\DocCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'description', 'sort_order', 'is_visible'])]
class DocCategory extends Model
{
    /** @use HasFactory<DocCategoryFactory> */
    use HasFactory;

    /**
     * @return HasMany<DocArticle, $this>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(DocArticle::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }
}
