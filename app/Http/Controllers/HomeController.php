<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\BacMatter;
use App\Models\Banner;
use App\Models\JobOpportunity;
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
                ->select(['id', 'photo', 'link', 'title', 'content', 'sequence', 'created_at'])
                ->where('is_published', true)
                ->orderBy('sequence')
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
                ->limit(4)
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
            'sdgArticles' => $this->sdgArticles(),
            'jobOpportunities' => $this->jobOpportunities(),
            'bacDocuments' => $this->bacDocuments(),
        ]);
    }

    /**
     * @return list<array{id: string, title: string, slug: string, date: string|null, category: string, photoUrl: string|null}>
     */
    private function sdgArticles(): array
    {
        return News::query()
            ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date', 'office_id'])
            ->where('is_published', true)
            ->whereHas('office', fn ($query) => $query->where('code', 'SDG'))
            ->latest('date')
            ->limit(4)
            ->get()
            ->map(fn (News $news): array => [
                'id' => $news->id,
                'title' => $this->normalizeDisplayText($news->title) ?? '',
                'slug' => $news->slug,
                'date' => $news->date?->format('M j, Y'),
                'category' => 'SDG Initiative',
                'photoUrl' => $this->newsPhotoUrl($news->photo),
            ])
            ->all();
    }

    /**
     * @return list<array{id: string, position: string, details: string|null, postedAt: string|null, isHiring: bool}>
     */
    private function jobOpportunities(): array
    {
        return JobOpportunity::query()
            ->select(['id', 'name', 'content', 'date', 'is_hiring'])
            ->where('is_published', true)
            ->where('is_hiring', true)
            ->latest('date')
            ->orderByDesc('id')
            ->limit(6)
            ->get()
            ->map(function (JobOpportunity $jobOpportunity): array {
                $details = Str::limit(
                    $this->normalizeDisplayText($jobOpportunity->content) ?? '',
                    240,
                );

                return [
                    'id' => $jobOpportunity->id,
                    'position' => $this->normalizeDisplayText($jobOpportunity->name) ?? '',
                    'details' => $details !== '' ? $details : null,
                    'postedAt' => $jobOpportunity->date?->format('M j, Y'),
                    'isHiring' => (bool) $jobOpportunity->is_hiring,
                ];
            })
            ->all();
    }

    /**
     * @return list<array{id: int, title: string, type: string, postedAt: string|null, destinationUrl: string|null}>
     */
    private function bacDocuments(): array
    {
        return BacMatter::query()
            ->select(['id', 'name', 'file', 'link', 'type', 'date'])
            ->where('is_published', true)
            ->latest('date')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (BacMatter $bacMatter): array => [
                'id' => $bacMatter->id,
                'title' => $this->normalizeDisplayText($bacMatter->name) ?? '',
                'type' => $this->bacTypeLabel($bacMatter->type),
                'postedAt' => $bacMatter->date?->format('M j, Y'),
                'destinationUrl' => $this->bacDestinationUrl($bacMatter),
            ])
            ->all();
    }

    private function bacTypeLabel(?string $type): string
    {
        return match ($type) {
            'RFQ' => 'Request for Quotation',
            'ITB' => 'Invitation to Bid',
            'NOA' => 'Notice of Award',
            'NTP' => 'Notice to Proceed',
            'Bid Bulletin', 'Bid Bulletin 2' => 'Bid Bulletin',
            default => 'BAC Notice',
        };
    }

    private function bacDestinationUrl(BacMatter $bacMatter): ?string
    {
        if (filled($bacMatter->file)) {
            if (Str::of($bacMatter->file)->startsWith('bac-matters/')) {
                return Storage::disk('public')->url($bacMatter->file);
            }

            return $this->bacLegacyUrl($bacMatter->file);
        }

        return $this->bacLegacyUrl($bacMatter->link);
    }

    private function bacLegacyUrl(?string $url): ?string
    {
        if (! filled($url)) {
            return null;
        }

        $url = Str::of(html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            ->stripTags()
            ->squish()
            ->toString();

        if ($url === '') {
            return null;
        }

        if (Str::of($url)->startsWith(['http://', 'https://'])) {
            return $url;
        }

        if (Str::of($url)->startsWith('/')) {
            return 'https://nemsu.edu.ph'.$url;
        }

        return 'https://nemsu.edu.ph/files/BAC/'.rawurlencode($url);
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
