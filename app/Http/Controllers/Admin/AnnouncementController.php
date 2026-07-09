<?php

namespace App\Http\Controllers\Admin;

use App\Actions\News\ManageNewsImages;
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

class AnnouncementController extends Controller
{
    public function __construct(private ManageNewsImages $manageNewsImages) {}

    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');
        $featured = (string) $request->query('featured', 'all');
        $sortFields = [
            'title' => 'title',
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
            'contentKind' => 'announcement',
            'filters' => [
                'search' => $search,
                'status' => in_array($status, ['all', 'published', 'draft'], true) ? $status : 'all',
                'type' => 'announcement',
                'featured' => in_array($featured, ['all', 'featured', 'standard'], true) ? $featured : 'all',
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'news' => News::query()
                ->with('office:id,name')
                ->select(['id', 'title', 'slug', 'short_description', 'author', 'office_id', 'type', 'is_published', 'featured', 'date', 'updated_at'])
                ->where('type', 'announcement')
                ->search($search, ['title', 'slug', 'short_description', 'author'])
                ->when($status === 'published', fn ($query) => $query->where('is_published', true))
                ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
                ->when($featured === 'featured', fn ($query) => $query->where('featured', true))
                ->when($featured === 'standard', fn ($query) => $query->where('featured', false))
                ->sort($sortBy, $sortDirection, $sortFields, 'date', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (News $announcement): array => $this->announcementListData($announcement)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/news/Create', [
            'contentKind' => 'announcement',
            ...$this->formOptions(),
        ]);
    }

    public function store(StoreNewsRequest $request, SaveNews $saveNews): RedirectResponse
    {
        $announcement = $saveNews->handle(new News, [
            ...$request->validated(),
            'type' => 'announcement',
        ]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Announcement created.',
        ]);

        return to_route('admin.announcements.edit', $announcement);
    }

    public function edit(News $announcement): Response
    {
        $this->ensureAnnouncement($announcement);

        return Inertia::render('admin/news/Edit', [
            'contentKind' => 'announcement',
            'newsItem' => $this->announcementFormData($announcement),
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdateNewsRequest $request, News $announcement, SaveNews $saveNews): RedirectResponse
    {
        $this->ensureAnnouncement($announcement);

        $saveNews->handle($announcement, [
            ...$request->validated(),
            'type' => 'announcement',
        ]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Announcement updated.',
        ]);

        return to_route('admin.announcements.edit', $announcement);
    }

    public function destroy(News $announcement, SaveNews $saveNews): RedirectResponse
    {
        $this->ensureAnnouncement($announcement);

        $saveNews->deleteUploads($announcement);
        $announcement->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Announcement deleted.',
        ]);

        return to_route('admin.announcements.index');
    }

    /**
     * @return array{id: string, title: string, slug: string, excerpt: string|null, author: string|null, office: string|null, type: string, isPublished: bool, featured: bool, date: string|null, updatedAt: string|null}
     */
    private function announcementListData(News $announcement): array
    {
        return [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'slug' => $announcement->slug,
            'excerpt' => $announcement->short_description,
            'author' => $announcement->author,
            'office' => $announcement->office?->name,
            'type' => $announcement->type,
            'isPublished' => (bool) $announcement->is_published,
            'featured' => (bool) $announcement->featured,
            'date' => $announcement->date?->format('Y-m-d H:i'),
            'updatedAt' => $announcement->updated_at?->diffForHumans(),
        ];
    }

    /**
     * @return array{id: string, title: string, slug: string, short_description: string|null, content: string|null, photo: string|null, photo_url: string|null, author: string|null, office_id: int|null, type: string, is_published: bool, featured: bool, date: string|null}
     */
    private function announcementFormData(News $announcement): array
    {
        return [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'slug' => $announcement->slug,
            'short_description' => $announcement->short_description,
            'content' => $announcement->content,
            'photo' => $announcement->photo,
            'photo_url' => $this->manageNewsImages->photoUrl($announcement->photo),
            'author' => $announcement->author,
            'office_id' => $announcement->office_id,
            'type' => 'announcement',
            'is_published' => (bool) $announcement->is_published,
            'featured' => (bool) $announcement->featured,
            'date' => $announcement->date?->format('Y-m-d\TH:i'),
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

    private function ensureAnnouncement(News $announcement): void
    {
        abort_unless($announcement->type === 'announcement', 404);
    }
}
