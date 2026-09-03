<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Support\SeoMetadata;
use Inertia\Inertia;
use Inertia\Response;

class ContentPageController extends Controller
{
    public function show(ContentPage $contentPage, SeoMetadata $seoMetadata): Response
    {
        abort_unless($contentPage->isPubliclyVisible(), 404);

        return Inertia::render('content/Show', [
            'seo' => $seoMetadata->forContentPage($contentPage),
            'page' => [
                'id' => $contentPage->id,
                'title' => $contentPage->title,
                'slug' => $contentPage->slug,
                'section' => $contentPage->section,
                'excerpt' => $contentPage->excerpt,
                'body' => $contentPage->body,
                'publishedAt' => $contentPage->published_at?->format('F j, Y'),
            ],
        ]);
    }
}
