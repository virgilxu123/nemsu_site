<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Navigation\ResolveNavigationItemUrl;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNavigationItemRequest;
use App\Http\Requests\UpdateNavigationItemRequest;
use App\Models\ContentPage;
use App\Models\NavigationItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

class NavigationItemController extends Controller
{
    public function __construct(private ResolveNavigationItemUrl $resolveNavigationItemUrl) {}

    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));
        $location = (string) $request->query('location', 'main');
        $active = (string) $request->query('active', 'all');
        $sortFields = [
            'label' => 'label',
            'location' => 'location',
            'sort_order' => 'sort_order',
            'is_active' => 'is_active',
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

        return Inertia::render('admin/navigation/Index', [
            'filters' => [
                'search' => $search,
                'location' => in_array($location, ['main', 'footer'], true) ? $location : 'main',
                'active' => in_array($active, ['all', 'active', 'inactive'], true) ? $active : 'all',
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'items' => NavigationItem::query()
                ->with('parent:id,label')
                ->select(['id', 'parent_id', 'location', 'label', 'url', 'route_name', 'target_type', 'target_id', 'sort_order', 'is_active', 'updated_at'])
                ->search($search, ['label', 'url', 'route_name'])
                ->when(in_array($location, ['main', 'footer'], true), fn ($query) => $query->where('location', $location))
                ->when($active === 'active', fn ($query) => $query->where('is_active', true))
                ->when($active === 'inactive', fn ($query) => $query->where('is_active', false))
                ->sort($sortBy, $sortDirection, $sortFields, 'sort_order', 'asc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (NavigationItem $navigationItem): array => $this->navigationItemListData($navigationItem)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/navigation/Create', [
            ...$this->formOptions(),
        ]);
    }

    public function store(StoreNavigationItemRequest $request): RedirectResponse
    {
        $navigationItem = NavigationItem::query()->create($this->normalizedData($request->validated()));

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Navigation item created.',
        ]);

        return to_route('admin.navigation.edit', $navigationItem);
    }

    public function edit(NavigationItem $navigationItem): Response
    {
        return Inertia::render('admin/navigation/Edit', [
            'item' => $this->navigationItemFormData($navigationItem),
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdateNavigationItemRequest $request, NavigationItem $navigationItem): RedirectResponse
    {
        $navigationItem->update($this->normalizedData($request->validated()));

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Navigation item updated.',
        ]);

        return to_route('admin.navigation.edit', $navigationItem);
    }

    public function destroy(NavigationItem $navigationItem): RedirectResponse
    {
        $navigationItem->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Navigation item deleted.',
        ]);

        return to_route('admin.navigation.index');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizedData(array $data): array
    {
        $data = Arr::only($data, [
            'parent_id',
            'location',
            'label',
            'url',
            'route_name',
            'target_type',
            'target_id',
            'sort_order',
            'is_active',
        ]);

        foreach (['parent_id', 'url', 'route_name', 'target_type', 'target_id'] as $key) {
            $value = $data[$key] ?? null;
            $data[$key] = is_string($value) && trim($value) !== '' ? trim($value) : null;
        }

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        return $data;
    }

    /**
     * @return array{id: string, label: string, location: string, parent: string|null, url: string, destination: string, isActive: bool, sortOrder: int, updatedAt: string|null}
     */
    private function navigationItemListData(NavigationItem $navigationItem): array
    {
        return [
            'id' => $navigationItem->id,
            'label' => $navigationItem->label,
            'location' => $navigationItem->location,
            'parent' => $navigationItem->parent?->label,
            'url' => $this->resolveNavigationItemUrl->handle($navigationItem),
            'destination' => $this->destinationLabel($navigationItem),
            'isActive' => (bool) $navigationItem->is_active,
            'sortOrder' => (int) $navigationItem->sort_order,
            'updatedAt' => $navigationItem->updated_at?->diffForHumans(),
        ];
    }

    /**
     * @return array{id: string, parent_id: string|null, location: string, label: string, url: string|null, route_name: string|null, target_type: string|null, target_id: string|null, sort_order: int, is_active: bool}
     */
    private function navigationItemFormData(NavigationItem $navigationItem): array
    {
        return [
            'id' => $navigationItem->id,
            'parent_id' => $navigationItem->parent_id,
            'location' => $navigationItem->location,
            'label' => $navigationItem->label,
            'url' => $navigationItem->url,
            'route_name' => $navigationItem->route_name,
            'target_type' => $navigationItem->target_type,
            'target_id' => $navigationItem->target_id,
            'sort_order' => (int) $navigationItem->sort_order,
            'is_active' => (bool) $navigationItem->is_active,
        ];
    }

    /**
     * @return array{parentOptions: list<array{id: string, label: string, location: string}>, contentPages: list<array{id: string, title: string, slug: string}>}
     */
    private function formOptions(): array
    {
        return [
            'parentOptions' => NavigationItem::query()
                ->select(['id', 'label', 'location'])
                ->orderBy('location')
                ->orderBy('sort_order')
                ->orderBy('label')
                ->get()
                ->map(fn (NavigationItem $navigationItem): array => [
                    'id' => $navigationItem->id,
                    'label' => $navigationItem->label,
                    'location' => $navigationItem->location,
                ])
                ->all(),
            'contentPages' => ContentPage::query()
                ->select(['id', 'title', 'slug'])
                ->orderBy('title')
                ->get()
                ->map(fn (ContentPage $contentPage): array => [
                    'id' => $contentPage->id,
                    'title' => $contentPage->title,
                    'slug' => $contentPage->slug,
                ])
                ->all(),
        ];
    }

    private function destinationLabel(NavigationItem $navigationItem): string
    {
        if (filled($navigationItem->url)) {
            return 'URL';
        }

        if (filled($navigationItem->route_name)) {
            return 'Route';
        }

        if ($navigationItem->target_type === 'content_page') {
            return 'Content page';
        }

        return 'No destination';
    }
}
