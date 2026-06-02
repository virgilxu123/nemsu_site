<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\News;
use Inertia\Inertia;
use Inertia\Response;

class AnnouncementController extends Controller
{
    use FormatsNewsForPublicDisplay;

    public function index(): Response
    {
        return Inertia::render('announcements/Index', [
            'announcements' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->where('type', 'announcement')
                ->latest('date')
                ->paginate(9)
                ->withQueryString()
                ->through(fn (News $announcement): array => $this->newsListData($announcement)),
        ]);
    }
}
