<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use Inertia\Inertia;
use Inertia\Response;

class ContentPageController extends Controller
{
    public function show(ContentPage $contentPage): Response
    {
        abort_unless($contentPage->isPubliclyVisible(), 404);

        return Inertia::render('content/Show', [
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
