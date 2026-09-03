<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\News;
use App\Support\SeoMetadata;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    use FormatsNewsForPublicDisplay;

    public function index(Request $request, SeoMetadata $seoMetadata): Response
    {
        $category = (string) $request->query('category', 'all');

        if (! in_array($category, ['all', 'press-releases', 'announcements'], true)) {
            $category = 'all';
        }

        $featuredNews = $category === 'announcements' ? null : $this->featuredNews();
        $categoryCounts = News::query()
            ->selectRaw('type, count(*) as aggregate')
            ->where('is_published', true)
            ->whereIn('type', ['news', 'announcement'])
            ->groupBy('type')
            ->pluck('aggregate', 'type');

        return Inertia::render('news/Index', [
            'seo' => $seoMetadata->page(
                title: 'NEMSU Newsroom',
                description: 'Read official NEMSU news, press releases, announcements, campus milestones, research updates, and public information releases.',
                canonical: route('news.index'),
            ),
            'featuredNews' => $featuredNews,
            'activeCategory' => $category,
            'categories' => [
                [
                    'value' => 'all',
                    'label' => 'All updates',
                    'count' => (int) $categoryCounts->sum(),
                ],
                [
                    'value' => 'press-releases',
                    'label' => 'Press releases',
                    'count' => (int) $categoryCounts->get('news', 0),
                ],
                [
                    'value' => 'announcements',
                    'label' => 'Announcements',
                    'count' => (int) $categoryCounts->get('announcement', 0),
                ],
            ],
            'news' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->whereIn('type', ['news', 'announcement'])
                ->when($category === 'press-releases', fn ($query) => $query->where('type', 'news'))
                ->when($category === 'announcements', fn ($query) => $query->where('type', 'announcement'))
                ->when($featuredNews !== null, fn ($query) => $query->whereKeyNot($featuredNews['id']))
                ->latest('date')
                ->paginate(9)
                ->withQueryString()
                ->through(fn (News $news): array => $this->newsListData($news)),
        ]);
    }

    public function show(News $news, SeoMetadata $seoMetadata): Response
    {
        abort_unless($news->is_published, 404);

        $article = $this->newsArticleData($news);
        $description = $article['excerpt'] ?: 'Read this official update from North Eastern Mindanao State University.';

        return Inertia::render('news/Show', [
            'seo' => $seoMetadata->forNews(
                news: $news,
                title: $article['title'],
                description: $description,
                image: $article['photoUrl'],
            ),
            'article' => $article,
            'latestNews' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->whereIn('type', ['news', 'announcement'])
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
