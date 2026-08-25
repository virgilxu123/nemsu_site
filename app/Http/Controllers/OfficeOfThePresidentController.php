<?php

namespace App\Http\Controllers;

use App\Concerns\FormatsNewsForPublicDisplay;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;
use Inertia\Response;

class OfficeOfThePresidentController extends Controller
{
    use FormatsNewsForPublicDisplay;

    private const int PRESIDENT_OFFICE_ID = 17;

    private const string PRESIDENT_OFFICE_NAME = 'President Office';

    public function __invoke(): Response
    {
        return Inertia::render('about/OfficeOfThePresident', [
            'pressReleases' => News::query()
                ->select(['id', 'title', 'slug', 'short_description', 'photo', 'author', 'type', 'date'])
                ->where('is_published', true)
                ->where('type', 'news')
                ->where(fn (Builder $query): Builder => $query
                    ->where('office_id', self::PRESIDENT_OFFICE_ID)
                    ->orWhereHas(
                        'office',
                        fn (Builder $officeQuery): Builder => $officeQuery->where('name', self::PRESIDENT_OFFICE_NAME),
                    ))
                ->latest('date')
                ->limit(3)
                ->get()
                ->map(fn (News $news): array => $this->newsListData($news)),
        ]);
    }
}
