<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\News;
use Inertia\Inertia;
use Inertia\Response;

class OfficeOfThePresidentController extends Controller
{
    use FormatsNewsForPublicDisplay;

    public function __invoke(): Response
    {
        return Inertia::render('about/OfficeOfThePresident', [
            'pressReleases' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->where('type', 'news')
                ->latest('date')
                ->limit(3)
                ->get()
                ->map(fn (News $news): array => $this->newsListData($news)),
        ]);
    }
}
