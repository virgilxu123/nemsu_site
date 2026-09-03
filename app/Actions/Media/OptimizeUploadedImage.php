<?php

namespace App\Actions\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class OptimizeUploadedImage
{
    public function store(
        UploadedFile $image,
        string $directory,
        int $maxWidth,
        int $maxHeight,
        int $quality = 82,
    ): string {
        if (! function_exists('imagewebp')) {
            $path = $image->store(trim($directory, '/'), 'public');

            if (! is_string($path)) {
                throw new RuntimeException('The uploaded image could not be stored.');
            }

            return $path;
        }

        $contents = file_get_contents($image->getPathname());
        $source = is_string($contents) ? imagecreatefromstring($contents) : false;

        if ($source === false) {
            throw new RuntimeException('The uploaded image could not be processed.');
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $scale = min(1, $maxWidth / $sourceWidth, $maxHeight / $sourceHeight);
        $targetWidth = max(1, (int) round($sourceWidth * $scale));
        $targetHeight = max(1, (int) round($sourceHeight * $scale));
        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        if ($target === false) {
            imagedestroy($source);

            throw new RuntimeException('The optimized image canvas could not be created.');
        }

        imagealphablending($target, false);
        imagesavealpha($target, true);
        $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
        imagefill($target, 0, 0, $transparent);
        imagecopyresampled(
            $target,
            $source,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight,
        );

        ob_start();

        try {
            if (! imagewebp($target, null, $quality)) {
                throw new RuntimeException('The uploaded image could not be encoded as WebP.');
            }

            $optimizedContents = ob_get_contents();
        } finally {
            ob_end_clean();
            imagedestroy($source);
            imagedestroy($target);
        }

        if (! is_string($optimizedContents)) {
            throw new RuntimeException('The optimized image could not be read.');
        }

        $path = trim($directory, '/').'/'.Str::uuid().'.webp';

        if (! Storage::disk('public')->put($path, $optimizedContents, 'public')) {
            throw new RuntimeException('The optimized image could not be stored.');
        }

        return $path;
    }
}
