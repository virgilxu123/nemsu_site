<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\Banner;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'banners' => Banner::query()
                ->select(['id', 'photo', 'link', 'title', 'content', 'created_at'])
                ->where('is_published', true)
                ->latest()
                ->get()
                ->filter(fn (Banner $banner): bool => $this->bannerPhotoExists($banner->photo))
                ->take(8)
                ->values()
                ->map(fn (Banner $banner): array => $this->bannerData($banner)),
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
            'announcements' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->where('type', 'announcement')
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

    /**
     * @return array{id: int, title: string|null, summary: string|null, imageUrl: string, link: string|null}
     */
    private function bannerData(Banner $banner): array
    {
        return [
            'id' => $banner->id,
            'title' => $this->normalizeDisplayText($banner->title),
            'summary' => Str::limit($this->normalizeDisplayText($banner->content) ?? '', 160) ?: null,
            'imageUrl' => $this->bannerPhotoUrl($banner->photo),
            'link' => $banner->link === '' ? null : $banner->link,
        ];
    }

    private function bannerPhotoUrl(string $photo): string
    {
        $photo = $this->normalizeBannerPhoto($photo);

        return '/storage/images/banners/home/'.rawurlencode($photo);
    }

    private function bannerPhotoExists(string $photo): bool
    {
        $photo = $this->normalizeBannerPhoto($photo);

        if ($photo === '' || Str::of($photo)->startsWith(['http://', 'https://', '/'])) {
            return false;
        }

        return Storage::disk('public')->exists('images/banners/home/'.$photo);
    }

    private function normalizeBannerPhoto(string $photo): string
    {
        return Str::of(html_entity_decode($photo, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            ->stripTags()
            ->squish()
            ->toString();
    }
}
