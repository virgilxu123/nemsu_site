<?php

namespace App\Actions\News;

use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageNewsImages
{
    private const DIRECTORY = 'news';

    public function storePhoto(UploadedFile $photo): string
    {
        return $photo->store(self::DIRECTORY.'/photos', 'public');
    }

    /**
     * @param  array<string, UploadedFile>  $images
     * @return array{html: string, storedPaths: list<string>}
     */
    public function storeContentImages(string $html, array $images): array
    {
        [$document, $main] = $this->document($html);

        if (! $main instanceof DOMElement) {
            return ['html' => $html, 'storedPaths' => []];
        }

        $storedPaths = [];

        try {
            foreach (iterator_to_array($main->getElementsByTagName('img')) as $image) {
                if (! $image instanceof DOMElement || ! $image->hasAttribute('data-upload-id')) {
                    continue;
                }

                $uploadId = $image->getAttribute('data-upload-id');
                $upload = $images[$uploadId] ?? null;

                if (! $upload instanceof UploadedFile) {
                    $image->parentNode?->removeChild($image);

                    continue;
                }

                $path = $upload->store(self::DIRECTORY.'/content', 'public');
                $storedPaths[] = $path;
                $image->setAttribute('src', Storage::disk('public')->url($path));
                $image->setAttribute('alt', $image->getAttribute('alt') ?: $upload->getClientOriginalName());
                $image->removeAttribute('data-upload-id');
            }
        } catch (\Throwable $exception) {
            $this->deletePaths($storedPaths);

            throw $exception;
        }

        return [
            'html' => $this->innerHtml($document, $main),
            'storedPaths' => $storedPaths,
        ];
    }

    public function photoUrl(?string $photo): ?string
    {
        if ($photo === null || trim($photo) === '') {
            return null;
        }

        if ($this->isManagedPath($photo)) {
            return Storage::disk('public')->url($photo);
        }

        if (Str::of($photo)->startsWith(['http://', 'https://', '/'])) {
            return $photo;
        }

        return 'https://nemsu.edu.ph/files/News/'.rawurlencode($photo);
    }

    /**
     * @return list<string>
     */
    public function contentPaths(string $html): array
    {
        [, $main] = $this->document($html);

        if (! $main instanceof DOMElement) {
            return [];
        }

        return collect(iterator_to_array($main->getElementsByTagName('img')))
            ->filter(fn (DOMNode $node): bool => $node instanceof DOMElement)
            ->map(fn (DOMElement $image): ?string => $this->managedPathFromUrl($image->getAttribute('src')))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public function deletePhoto(?string $photo): void
    {
        if ($photo !== null && $this->isManagedPath($photo)) {
            Storage::disk('public')->delete($photo);
        }
    }

    /**
     * @param  iterable<string>  $paths
     */
    public function deletePaths(iterable $paths): void
    {
        $managedPaths = collect($paths)
            ->filter(fn (string $path): bool => $this->isManagedPath($path))
            ->values()
            ->all();

        if ($managedPaths !== []) {
            Storage::disk('public')->delete($managedPaths);
        }
    }

    private function isManagedPath(string $path): bool
    {
        return Str::of($path)->startsWith(self::DIRECTORY.'/');
    }

    private function managedPathFromUrl(string $url): ?string
    {
        $path = parse_url(trim($url), PHP_URL_PATH);

        if (! is_string($path)) {
            return null;
        }

        if (Str::of($path)->startsWith('/storage/'.self::DIRECTORY.'/')) {
            return Str::after($path, '/storage/');
        }

        return $this->isManagedPath($path) ? $path : null;
    }

    /**
     * @return array{0: DOMDocument, 1: DOMElement|null}
     */
    private function document(string $html): array
    {
        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<!DOCTYPE html><html><body><main>'.$html.'</main></body></html>',
            LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $main = $document->getElementsByTagName('main')->item(0);

        return [$document, $main instanceof DOMElement ? $main : null];
    }

    private function innerHtml(DOMDocument $document, DOMElement $element): string
    {
        return collect(iterator_to_array($element->childNodes))
            ->map(fn (DOMNode $node): string => $document->saveHTML($node) ?: '')
            ->implode('');
    }
}
