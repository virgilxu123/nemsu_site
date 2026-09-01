<?php

namespace App\Actions\Banners;

use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReorderBanners
{
    /**
     * @param  list<int>  $bannerIds
     */
    public function handle(array $bannerIds): void
    {
        $bannerIds = array_map(fn (mixed $bannerId): int => (int) $bannerId, $bannerIds);

        DB::transaction(function () use ($bannerIds): void {
            $banners = Banner::query()
                ->select(['id', 'sequence'])
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $lockedBannerIds = $banners->keys()
                ->map(fn (mixed $bannerId): int => (int) $bannerId)
                ->sort()
                ->values()
                ->all();
            $submittedBannerIds = $bannerIds;
            sort($submittedBannerIds);

            if ($lockedBannerIds !== $submittedBannerIds) {
                throw ValidationException::withMessages([
                    'banner_ids' => 'The banner list changed. Refresh the page and try again.',
                ]);
            }

            foreach ($bannerIds as $sequence => $bannerId) {
                $banner = $banners->get($bannerId);

                if (! $banner instanceof Banner || $banner->sequence === $sequence) {
                    continue;
                }

                $banner->timestamps = false;
                $banner->sequence = $sequence;
                $banner->saveQuietly();
            }
        }, attempts: 3);
    }
}
