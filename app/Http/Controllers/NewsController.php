<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\News;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    use FormatsNewsForPublicDisplay;

    public function show(News $news): Response
    {
        abort_unless($news->is_published && $news->type === 'news', 404);

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
}
