<?php

namespace App\Http\Controllers;

use App\Models\DocArticle;
use App\Models\DocCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocsController extends Controller
{
    public function index(Request $request): View
    {
        $searchQuery = Str::limit(Str::squish((string) $request->query('q')), 80, '');

        return view('docs.index', [
            'categories' => $this->sidebarCategories(),
            'searchQuery' => $searchQuery,
            'searchResults' => filled($searchQuery) ? $this->searchArticles($searchQuery) : collect(),
        ]);
    }

    public function show(string $slug): View
    {
        $article = DocArticle::query()
            ->published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedArticles = DocArticle::query()
            ->published()
            ->whereKeyNot($article->getKey())
            ->when(
                $article->doc_category_id,
                fn (Builder $query): Builder => $query->where('doc_category_id', $article->doc_category_id),
            )
            ->orderBy('sort_order')
            ->orderBy('title')
            ->limit(4)
            ->get();

        return view('docs.show', [
            'article' => $article,
            'categories' => $this->sidebarCategories(),
            'relatedArticles' => $relatedArticles,
        ]);
    }

    /**
     * @return Collection<int, DocCategory>
     */
    private function sidebarCategories(): Collection
    {
        return DocCategory::query()
            ->where('is_visible', true)
            ->with(['articles' => fn (HasMany $query): HasMany => $query
                ->published()
                ->orderBy('sort_order')
                ->orderBy('title')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * @return Collection<int, DocArticle>
     */
    private function searchArticles(string $searchQuery): Collection
    {
        $likeQuery = '%'.str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $searchQuery).'%';

        return DocArticle::query()
            ->published()
            ->with('category')
            ->where(function (Builder $query) use ($likeQuery): void {
                $query
                    ->where('title', 'like', $likeQuery)
                    ->orWhere('excerpt', 'like', $likeQuery)
                    ->orWhere('content', 'like', $likeQuery);
            })
            ->where(function (Builder $query): void {
                $query
                    ->whereHas('category', fn (Builder $categoryQuery): Builder => $categoryQuery->where('is_visible', true))
                    ->orWhereNull('doc_category_id');
            })
            ->orderBy('sort_order')
            ->orderBy('title')
            ->limit(24)
            ->get();
    }
}
