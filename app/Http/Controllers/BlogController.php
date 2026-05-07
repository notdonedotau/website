<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(): View
    {
        $articles = BlogArticle::query()
            ->published()
            ->with('category')
            ->orderByRaw('coalesce(published_at, created_at) desc')
            ->paginate(9);

        return view('blog.index', [
            'articles' => $articles,
        ]);
    }

    public function show(string $slug): View
    {
        $article = BlogArticle::query()
            ->published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', [
            'article' => $article,
        ]);
    }

    public function ogImage(string $slug): Response
    {
        $article = BlogArticle::query()
            ->published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $titleLines = $this->wrapSvgText($article->title, 46, 2);
        $category = $article->category?->name ?? 'Not Done';
        $date = ($article->published_at ?? $article->created_at)->format('j M Y');
        $escapedCategory = e($category);
        $escapedDate = e($date);
        $escapedTitle = e($article->title);
        $logoSvg = $this->logoSvg();

        $titleSvg = collect($titleLines)
            ->map(fn (string $line, int $index): string => sprintf(
                '<tspan x="88" y="%d">%s</tspan>',
                364 + ($index * 68),
                e($line),
            ))
            ->implode('');

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="630" viewBox="0 0 1200 630" role="img" aria-label="{$escapedTitle}">
    <rect width="1200" height="630" fill="#fff7f2"/>
    <rect width="1200" height="630" fill="#fde6d8" opacity="0.34"/>
    <circle cx="1020" cy="150" r="118" fill="#e4572e" opacity="0.13"/>
    <circle cx="1100" cy="515" r="168" fill="#e4572e" opacity="0.09"/>
    {$logoSvg}
    <text x="88" y="238" fill="#6b7280" font-family="Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif" font-size="24" font-weight="800" letter-spacing="4" text-transform="uppercase">{$escapedCategory} / {$escapedDate}</text>
    <text fill="#0b0b0b" font-family="Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif" font-size="58" font-weight="800" letter-spacing="-0.6">{$titleSvg}</text>
    <rect x="88" y="520" width="180" height="8" rx="4" fill="#e4572e"/>
</svg>
SVG;

        return response($svg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'no-cache, max-age=0, must-revalidate');
    }

    /**
     * @return array<int, string>
     */
    private function wrapSvgText(string $text, int $lineLength, int $maxLines): array
    {
        $lines = explode("\n", wordwrap($text, $lineLength, "\n", false));

        if (count($lines) <= $maxLines) {
            return $lines;
        }

        $lines = array_slice($lines, 0, $maxLines);
        $lines[$maxLines - 1] = Str::of($lines[$maxLines - 1])->limit($lineLength - 1)->toString();

        return $lines;
    }

    private function logoSvg(): string
    {
        $path = public_path('images/logo-dm.svg');

        if (! is_file($path)) {
            return '<text x="88" y="142" fill="#0b0b0b" font-family="Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', sans-serif" font-size="42" font-weight="800" letter-spacing="1.5">NOT<tspan fill="#e4572e">DONE</tspan></text>';
        }

        $dataUri = 'data:image/svg+xml;base64,'.base64_encode((string) file_get_contents($path));

        return <<<SVG
<image href="{$dataUri}" x="88" y="94" width="330" height="70" preserveAspectRatio="xMinYMid meet"/>
SVG;
    }
}
