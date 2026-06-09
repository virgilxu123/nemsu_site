<?php

namespace App\Http\Controllers;

use App\Actions\ContentPages\SanitizeHtml;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BannerController extends Controller
{
    public function show(Banner $banner, SanitizeHtml $sanitizeHtml): Response
    {
        $contentHtml = $sanitizeHtml->handle($banner->content ?? '');

        abort_unless($banner->is_published && filled(strip_tags($contentHtml)), 404);

        return Inertia::render('banners/Show', [
            'banner' => [
                'id' => $banner->id,
                'title' => $this->displayText($banner->title) ?: 'Campus Update',
                'contentHtml' => $contentHtml,
                'imageUrl' => $this->bannerPhotoUrl($banner->photo),
                'publishedAt' => $banner->created_at?->format('F j, Y'),
            ],
        ]);
    }

    private function bannerPhotoUrl(string $photo): string
    {
        $photo = Str::of(html_entity_decode($photo, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            ->stripTags()
            ->squish()
            ->toString();

        if (Str::of($photo)->startsWith('banners/')) {
            return Storage::disk('public')->url($photo);
        }

        if (Str::of($photo)->startsWith(['http://', 'https://'])) {
            return $photo;
        }

        if (Str::of($photo)->startsWith('/')) {
            return 'https://nemsu.edu.ph'.$photo;
        }

        return 'https://nemsu.edu.ph/files/Banner/'.rawurlencode($photo);
    }

    private function displayText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return Str::of(html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            ->stripTags()
            ->squish()
            ->toString();
    }
}
