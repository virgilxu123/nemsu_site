<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\News;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    use FormatsNewsForPublicDisplay;

    /**
     * Handle the incoming request.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Welcome', [
            'featuredNews' => $this->featuredNews(),
            'pressReleases' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->where('type', 'news')
                ->where('featured', false)
                ->latest('date')
                ->limit(3)
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
