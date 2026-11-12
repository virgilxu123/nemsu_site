<?php

namespace App\Console\Commands;

use App\Actions\News\ManageNewsImages;
use App\Models\Banner;
use App\Models\ContentPage;
use App\Models\News;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

#[Signature('news:prune-orphaned-images {--hours=24 : Minimum age in hours before an unreferenced image is deleted} {--dry-run : List orphaned files without deleting them}')]
#[Description('Prune uploaded news images that are not attached to any news article')]
class PruneOrphanedNewsImages extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(ManageNewsImages $manageNewsImages): int
    {
        $hours = max(0, (int) $this->option('hours'));
        $isDryRun = (bool) $this->option('dry-run');
        $cutoff = now()->subHours($hours)->getTimestamp();

        $storage = Storage::disk('public');

        if (! $storage->exists('news')) {
            $this->info('No news storage directory found. Nothing to prune.');

            return self::SUCCESS;
        }

        // Active news featured photos
        $activePhotos = News::query()
            ->whereNotNull('photo')
            ->pluck('photo')
            ->filter()
            ->flip();

        // Active news article content images
        $activeContentPaths = News::query()
            ->whereNotNull('content')
            ->pluck('content')
            ->flatMap(fn (string $content): array => $manageNewsImages->contentPaths($content))
            ->flip();

        // Cross-reference checks for other sections (e.g. content pages or banners)
        $contentPageBodies = ContentPage::query()
            ->whereNotNull('body')
            ->pluck('body');

        $bannerPhotos = Banner::query()
            ->whereNotNull('photo')
            ->pluck('photo')
            ->flip();

        $prunedCount = 0;
        $prunedBytes = 0;

        $contentFiles = $storage->files('news/content');
        foreach ($contentFiles as $file) {
            $lastModified = $this->fileLastModified($storage, $file);

            if ($lastModified > $cutoff) {
                continue;
            }

            if (! isset($activeContentPaths[$file]) && ! $this->isReferencedElsewhere($file, $contentPageBodies, $bannerPhotos)) {
                $size = $this->fileSize($storage, $file);
                $prunedBytes += $size;
                $prunedCount++;

                if ($isDryRun) {
                    $this->line("Would delete orphaned content image: {$file} (".number_format($size / 1024, 1).' KB)');
                } else {
                    $storage->delete($file);
                    $this->line("Deleted orphaned content image: {$file}");
                }
            }
        }

        $photoFiles = $storage->files('news/photos');
        foreach ($photoFiles as $file) {
            $lastModified = $this->fileLastModified($storage, $file);

            if ($lastModified > $cutoff) {
                continue;
            }

            if (! isset($activePhotos[$file]) && ! $this->isReferencedElsewhere($file, $contentPageBodies, $bannerPhotos)) {
                $size = $this->fileSize($storage, $file);
                $prunedBytes += $size;
                $prunedCount++;

                if ($isDryRun) {
                    $this->line("Would delete orphaned photo: {$file} (".number_format($size / 1024, 1).' KB)');
                } else {
                    $storage->delete($file);
                    $this->line("Deleted orphaned photo: {$file}");
                }
            }
        }

        $formattedBytes = number_format($prunedBytes / (1024 * 1024), 2).' MB';

        if ($isDryRun) {
            $this->info("Dry run complete: {$prunedCount} orphaned image(s) found ({$formattedBytes} would be reclaimed).");
        } else {
            $this->info("Pruning complete: {$prunedCount} orphaned image(s) deleted ({$formattedBytes} reclaimed).");
        }

        return self::SUCCESS;
    }

    /**
     * @param  Collection<int, string>  $contentPageBodies
     * @param  Collection<string, int>  $bannerPhotos
     */
    private function isReferencedElsewhere(string $file, Collection $contentPageBodies, Collection $bannerPhotos): bool
    {
        if (isset($bannerPhotos[$file])) {
            return true;
        }

        $basename = basename($file);

        foreach ($contentPageBodies as $body) {
            if (str_contains($body, $file) || str_contains($body, $basename)) {
                return true;
            }
        }

        return false;
    }

    private function fileLastModified(mixed $storage, string $file): int
    {
        try {
            return (int) $storage->lastModified($file);
        } catch (\Throwable) {
            return 0;
        }
    }

    private function fileSize(mixed $storage, string $file): int
    {
        try {
            return (int) $storage->size($file);
        } catch (\Throwable) {
            return 0;
        }
    }
}
