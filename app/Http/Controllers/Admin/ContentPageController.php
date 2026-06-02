<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ContentPages\SaveContentPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentPageRequest;
use App\Http\Requests\UpdateContentPageRequest;
use App\Models\Campus;
use App\Models\ContentPage;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContentPageController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');
        $section = trim((string) $request->query('section', ''));
        $sortFields = [
            'title' => 'title',
            'section' => 'section',
            'status' => 'status',
            'published_at' => 'published_at',
            'sort_order' => 'sort_order',
            'updated_at' => 'updated_at',
        ];
        $sortBy = (string) $request->query('sort_by', 'sort_order');
        $sortDirection = (string) $request->query('sort_direction', 'asc');

        if (! array_key_exists($sortBy, $sortFields)) {
            $sortBy = 'sort_order';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'asc';
        }

        return Inertia::render('admin/content-pages/Index', [
            'filters' => [
                'search' => $search,
                'status' => in_array($status, ['all', 'published', 'draft'], true) ? $status : 'all',
                'section' => $section,
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'sections' => $this->sectionOptions(),
            'pages' => ContentPage::query()
                ->select(['id', 'slug', 'title', 'section', 'excerpt', 'status', 'is_published', 'published_at', 'sort_order', 'updated_at'])
                ->search($search, ['title', 'slug', 'section', 'excerpt'])
                ->when($status === 'published', fn ($query) => $query->where('is_published', true))
                ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
                ->when($section !== '', fn ($query) => $query->where('section', $section))
                ->sort($sortBy, $sortDirection, $sortFields, 'sort_order', 'asc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (ContentPage $contentPage): array => $this->pageListData($contentPage)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/content-pages/Create', [
            ...$this->formOptions(),
        ]);
    }

    public function store(StoreContentPageRequest $request, SaveContentPage $saveContentPage): RedirectResponse
    {
        $contentPage = $saveContentPage->handle(new ContentPage, $request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Content page created.',
        ]);

        return to_route('admin.content-pages.edit', $contentPage);
    }

    public function edit(ContentPage $contentPage): Response
    {
        return Inertia::render('admin/content-pages/Edit', [
            'page' => $this->pageFormData($contentPage),
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdateContentPageRequest $request, ContentPage $contentPage, SaveContentPage $saveContentPage): RedirectResponse
    {
        $saveContentPage->handle($contentPage, $request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Content page updated.',
        ]);

        return to_route('admin.content-pages.edit', $contentPage);
    }

    public function destroy(ContentPage $contentPage): RedirectResponse
    {
        $contentPage->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Content page deleted.',
        ]);

        return to_route('admin.content-pages.index');
    }

    /**
     * @return array{id: string, title: string, slug: string, section: string|null, excerpt: string|null, status: string, isPublished: bool, publishedAt: string|null, sortOrder: int, updatedAt: string|null}
     */
    private function pageListData(ContentPage $contentPage): array
    {
        return [
            'id' => $contentPage->id,
            'title' => $contentPage->title,
            'slug' => $contentPage->slug,
            'section' => $contentPage->section,
            'excerpt' => $contentPage->excerpt,
            'status' => $contentPage->status,
            'isPublished' => (bool) $contentPage->is_published,
            'publishedAt' => $contentPage->published_at?->format('Y-m-d H:i'),
            'sortOrder' => (int) $contentPage->sort_order,
            'updatedAt' => $contentPage->updated_at?->diffForHumans(),
        ];
    }

    /**
     * @return array{id: string, title: string, slug: string, section: string|null, body: string|null, excerpt: string|null, status: string, is_published: bool, published_at: string|null, office_id: int|null, campus_id: string|null, sort_order: int}
     */
    private function pageFormData(ContentPage $contentPage): array
    {
        return [
            'id' => $contentPage->id,
            'title' => $contentPage->title,
            'slug' => $contentPage->slug,
            'section' => $contentPage->section,
            'body' => $contentPage->body,
            'excerpt' => $contentPage->excerpt,
            'status' => $contentPage->status,
            'is_published' => (bool) $contentPage->is_published,
            'published_at' => $contentPage->published_at?->format('Y-m-d\TH:i'),
            'office_id' => $contentPage->office_id,
            'campus_id' => $contentPage->campus_id,
            'sort_order' => (int) $contentPage->sort_order,
        ];
    }

    /**
     * @return array{offices: list<array{id: int, name: string}>, campuses: list<array{id: string, name: string}>}
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
            'campuses' => Campus::query()
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get()
                ->map(fn (Campus $campus): array => [
                    'id' => $campus->id,
                    'name' => $campus->name,
                ])
                ->all(),
        ];
    }

    /**
     * @return list<string>
     */
    private function sectionOptions(): array
    {
        return ContentPage::query()
            ->whereNotNull('section')
            ->distinct()
            ->orderBy('section')
            ->pluck('section')
            ->filter()
            ->values()
            ->all();
    }
}
