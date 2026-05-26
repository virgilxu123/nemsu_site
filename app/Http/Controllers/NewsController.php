<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\News;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    use FormatsNewsForPublicDisplay;

    public function index(): Response
    {
        $featuredNews = $this->featuredNews();

        return Inertia::render('news/Index', [
            'featuredNews' => $featuredNews,
            'news' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->where('type', 'news')
                ->when($featuredNews !== null, fn ($query) => $query->whereKeyNot($featuredNews['id']))
                ->latest('date')
                ->paginate(9)
                ->withQueryString()
                ->through(fn (News $news): array => $this->newsListData($news)),
        ]);
    }

    public function show(News $news): Response
    {
        abort_unless($news->is_published, 404);

        return Inertia::render('news/Show', [
            'article' => $this->newsArticleData($news),
            'latestNews' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->where('type', 'news')
                ->whereKeyNot($news->getKey())
                ->latest('date')
                ->limit(4)
                ->get()
                ->map(fn (News $news): array => $this->newsListData($news)),
        ]);
    }

    /**
     * @return array{id: string, type: string, title: string, slug: string, excerpt: string|null, date: string|null, office: string, photoUrl: string|null}|null
     */
    private function featuredNews(): ?array
    {
        $news = News::query()
            ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
            ->where('is_published', true)
            ->where('type', 'news')
            ->where('featured', true)
            ->latest('date')
            ->first();

        return $news instanceof News ? $this->newsListData($news) : null;
    }
}
