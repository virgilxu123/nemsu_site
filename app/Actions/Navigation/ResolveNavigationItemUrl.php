<?php

namespace App\Actions\Navigation;

use App\Models\ContentPage;
use App\Models\NavigationItem;
use Illuminate\Support\Facades\Route;

class ResolveNavigationItemUrl
{
    public function handle(NavigationItem $navigationItem): string
    {
        if (filled($navigationItem->url)) {
            return (string) $navigationItem->url;
        }

        if (filled($navigationItem->route_name) && Route::has((string) $navigationItem->route_name)) {
            return route((string) $navigationItem->route_name, absolute: false);
        }

        if ($navigationItem->target_type === 'content_page' && filled($navigationItem->target_id)) {
            $contentPage = ContentPage::query()
                ->select(['id', 'slug'])
                ->whereKey($navigationItem->target_id)
                ->first();

            if ($contentPage instanceof ContentPage) {
                return route('content-pages.show', $contentPage->slug, absolute: false);
            }
        }

        return '#';
    }
}
