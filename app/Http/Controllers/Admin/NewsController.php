<?php

namespace App\Http\Controllers\Admin;

use App\Actions\News\SaveNews;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');
        $type = (string) $request->query('type', 'all');
        $featured = (string) $request->query('featured', 'all');
        $sortFields = [
            'title' => 'title',
            'type' => 'type',
            'is_published' => 'is_published',
            'featured' => 'featured',
            'date' => 'date',
            'updated_at' => 'updated_at',
        ];
        $sortBy = (string) $request->query('sort_by', 'date');
        $sortDirection = (string) $request->query('sort_direction', 'desc');

        if (! array_key_exists($sortBy, $sortFields)) {
            $sortBy = 'date';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        return Inertia::render('admin/news/Index', [
            'filters' => [
                'search' => $search,
                'status' => in_array($status, ['all', 'published', 'draft'], true) ? $status : 'all',
                'type' => in_array($type, ['all', 'news', 'announcement'], true) ? $type : 'all',
                'featured' => in_array($featured, ['all', 'featured', 'standard'], true) ? $featured : 'all',
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'news' => News::query()
                ->with('office:id,name')
                ->select(['id', 'title', 'slug', 'short_description', 'author', 'office_id', 'type', 'is_published', 'featured', 'date', 'updated_at'])
                ->search($search, ['title', 'slug', 'short_description', 'author'])
                ->when($status === 'published', fn ($query) => $query->where('is_published', true))
                ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
                ->when(in_array($type, ['news', 'announcement'], true), fn ($query) => $query->where('type', $type))
                ->when($featured === 'featured', fn ($query) => $query->where('featured', true))
                ->when($featured === 'standard', fn ($query) => $query->where('featured', false))
                ->sort($sortBy, $sortDirection, $sortFields, 'date', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (News $news): array => $this->newsListData($news)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/news/Create', [
            ...$this->formOptions(),
        ]);
    }

    public function store(StoreNewsRequest $request, SaveNews $saveNews): RedirectResponse
    {
        $news = $saveNews->handle(new News, $request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'News item created.',
        ]);

        return to_route('admin.news.edit', $news);
    }

    public function edit(News $news): Response
    {
        return Inertia::render('admin/news/Edit', [
            'newsItem' => $this->newsFormData($news),
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdateNewsRequest $request, News $news, SaveNews $saveNews): RedirectResponse
    {
        $saveNews->handle($news, $request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'News item updated.',
        ]);

        return to_route('admin.news.edit', $news);
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'News item deleted.',
        ]);

        return to_route('admin.news.index');
    }

    /**
     * @return array{id: string, title: string, slug: string, excerpt: string|null, author: string|null, office: string|null, type: string, isPublished: bool, featured: bool, date: string|null, updatedAt: string|null}
     */
    private function newsListData(News $news): array
    {
        return [
            'id' => $news->id,
            'title' => $news->title,
            'slug' => $news->slug,
            'excerpt' => $news->short_description,
            'author' => $news->author,
            'office' => $news->office?->name,
            'type' => $news->type,
            'isPublished' => (bool) $news->is_published,
            'featured' => (bool) $news->featured,
            'date' => $news->date?->format('Y-m-d H:i'),
            'updatedAt' => $news->updated_at?->diffForHumans(),
        ];
    }

    /**
     * @return array{id: string, title: string, slug: string, short_description: string|null, content: string|null, photo: string|null, author: string|null, office_id: int|null, type: string, is_published: bool, featured: bool, date: string|null}
     */
    private function newsFormData(News $news): array
    {
        return [
            'id' => $news->id,
            'title' => $news->title,
            'slug' => $news->slug,
            'short_description' => $news->short_description,
            'content' => $news->content,
            'photo' => $news->photo,
            'author' => $news->author,
            'office_id' => $news->office_id,
            'type' => $news->type,
            'is_published' => (bool) $news->is_published,
            'featured' => (bool) $news->featured,
            'date' => $news->date?->format('Y-m-d\TH:i'),
        ];
    }

    /**
     * @return array{offices: list<array{id: int, name: string}>}
     */
    private function formOptions(): array
    {
        return [
            'offices' => Office::query()
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get()
                ->map(fn (Office $office): array => [
                    'id' => $office->id,
                    'name' => $office->name,
                ])
                ->all(),
        ];
    }
}
