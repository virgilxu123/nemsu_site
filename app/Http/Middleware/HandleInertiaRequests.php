<?php

namespace App\Http\Middleware;

use App\Actions\Navigation\ResolveNavigationItemUrl;
use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\NavigationItem;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    use FormatsNewsForPublicDisplay;

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
                'can' => [
                    'manageCms' => $request->user()?->can('manage-cms') ?? false,
                ],
            ],
            'navigation' => fn (): array => [
                'main' => $this->navigationTree('main'),
                'footer' => $this->navigationTree('footer'),
            ],
            'publicNewsTicker' => fn (): array => $this->publicNewsTicker(),
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }

    /**
     * @return list<array{id: string, type: string, title: string, slug: string, date: string|null}>
     */
    private function publicNewsTicker(): array
    {
        return News::query()
            ->select(['id', 'title', 'slug', 'type', 'is_published', 'date'])
            ->where('is_published', true)
            ->whereIn('type', ['announcement', 'news'])
            ->orderByDesc('date')
            ->limit(5)
            ->get()
            ->map(fn (News $news): array => [
                'id' => $news->id,
                'type' => $news->type === 'announcement' ? 'Announcement' : 'Press Release',
                'title' => $this->normalizeDisplayText($news->title) ?? '',
                'slug' => $news->slug,
                'date' => $news->date?->format('M j, Y'),
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array{id: string, label: string, url: string, children: list<array{id: string, label: string, url: string, children: array}>}>
     */
    private function navigationTree(string $location): array
    {
        $items = NavigationItem::query()
            ->select(['id', 'parent_id', 'location', 'label', 'url', 'route_name', 'target_type', 'target_id', 'sort_order'])
            ->where('location', $location)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();

        $groupedItems = $items->groupBy(fn (NavigationItem $item): string => $item->parent_id ?? 'root');
        $resolver = app(ResolveNavigationItemUrl::class);

        $build = function (string $parentId) use (&$build, $groupedItems, $resolver): array {
            /** @var Collection<int, NavigationItem> $children */
            $children = $groupedItems->get($parentId, collect());

            return $children
                ->map(fn (NavigationItem $item): array => [
                    'id' => $item->id,
                    'label' => $item->label,
                    'url' => $resolver->handle($item),
                    'children' => $build($item->id),
                ])
                ->values()
                ->all();
        };

        return $build('root');
    }
}
