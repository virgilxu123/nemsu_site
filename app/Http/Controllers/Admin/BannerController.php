<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

class BannerController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');
        $sortFields = [
            'title' => 'title',
            'is_published' => 'is_published',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
        $sortBy = (string) $request->query('sort_by', 'created_at');
        $sortDirection = (string) $request->query('sort_direction', 'desc');

        if (! array_key_exists($sortBy, $sortFields)) {
            $sortBy = 'created_at';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        return Inertia::render('admin/banners/Index', [
            'filters' => [
                'search' => $search,
                'status' => in_array($status, ['all', 'published', 'draft'], true) ? $status : 'all',
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'banners' => Banner::query()
                ->with('office:id,name')
                ->select(['id', 'photo', 'link', 'title', 'content', 'office_id', 'is_published', 'created_at', 'updated_at'])
                ->search($search, ['photo', 'link', 'title', 'content'])
                ->when($status === 'published', fn ($query) => $query->where('is_published', true))
                ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
                ->sort($sortBy, $sortDirection, $sortFields, 'created_at', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (Banner $banner): array => $this->bannerListData($banner)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/banners/Create', [
            ...$this->formOptions(),
        ]);
    }

    public function store(StoreBannerRequest $request): RedirectResponse
    {
        $banner = Banner::query()->create($this->normalizedData($request->validated()));

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Banner created.',
        ]);

        return to_route('admin.banners.edit', $banner);
    }

    public function edit(Banner $banner): Response
    {
        return Inertia::render('admin/banners/Edit', [
            'banner' => $this->bannerFormData($banner),
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdateBannerRequest $request, Banner $banner): RedirectResponse
    {
        $banner->update($this->normalizedData($request->validated()));

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Banner updated.',
        ]);

        return to_route('admin.banners.edit', $banner);
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $banner->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Banner deleted.',
        ]);

        return to_route('admin.banners.index');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizedData(array $data): array
    {
        $data = Arr::only($data, [
            'photo',
            'link',
            'title',
            'content',
            'office_id',
            'is_published',
        ]);

        foreach (['photo', 'link', 'title', 'content'] as $key) {
            $value = $data[$key] ?? null;
            $data[$key] = is_string($value) && trim($value) !== '' ? trim($value) : null;
        }

        $data['is_published'] = (bool) ($data['is_published'] ?? false);

        return $data;
    }

    /**
     * @return array{id: int, title: string|null, photo: string, link: string|null, office: string|null, isPublished: bool, createdAt: string|null, updatedAt: string|null}
     */
    private function bannerListData(Banner $banner): array
    {
        return [
            'id' => $banner->id,
            'title' => $banner->title,
            'photo' => $banner->photo,
            'link' => $banner->link,
            'office' => $banner->office?->name,
            'isPublished' => (bool) $banner->is_published,
            'createdAt' => $banner->created_at?->format('Y-m-d H:i'),
            'updatedAt' => $banner->updated_at?->diffForHumans(),
        ];
    }

    /**
     * @return array{id: int, photo: string, link: string|null, title: string|null, content: string|null, office_id: int|null, is_published: bool}
     */
    private function bannerFormData(Banner $banner): array
    {
        return [
            'id' => $banner->id,
            'photo' => $banner->photo,
            'link' => $banner->link,
            'title' => $banner->title,
            'content' => $banner->content,
            'office_id' => $banner->office_id,
            'is_published' => (bool) $banner->is_published,
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
