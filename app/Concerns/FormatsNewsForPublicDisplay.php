<?php

namespace App\Concerns;

use App\Models\News;
use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Normalizer;

trait FormatsNewsForPublicDisplay
{
    /**
     * @return array{id: string, type: string, title: string, slug: string, excerpt: string|null, date: string|null, office: string, photoUrl: string|null}
     */
    protected function newsListData(News $news): array
    {
        return [
            'id' => $news->id,
            'type' => $news->type === 'announcement' ? 'Announcement' : 'Press Release',
            'title' => $this->normalizeDisplayText($news->title) ?? '',
            'slug' => $news->slug,
            'excerpt' => $this->normalizeDisplayText($news->short_description),
            'date' => $news->date?->format('M j, Y'),
            'office' => $this->normalizeDisplayText($news->author) ?: 'Public Information Office',
            'photoUrl' => $this->newsPhotoUrl($news->photo),
        ];
    }

    /**
     * @return array{id: string, type: string, title: string, slug: string, excerpt: string|null, contentHtml: string, galleryImages: list<array{url: string, alt: string}>, date: string|null, office: string, photoUrl: string|null}
     */
    protected function newsArticleData(News $news): array
    {
        return [
            ...$this->newsListData($news),
            'contentHtml' => $this->cleanArticleHtml($news->content),
            'galleryImages' => [],
        ];
    }

    protected function normalizeDisplayText(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $normalized = class_exists(Normalizer::class)
            ? Normalizer::normalize($decoded, Normalizer::FORM_KC)
            : $decoded;

        return Str::of($normalized === false ? $decoded : $normalized)
            ->stripTags()
            ->squish()
            ->toString();
    }

    protected function newsPhotoUrl(?string $photo): ?string
    {
        if ($photo === null) {
            return null;
        }

        $photo = Str::of(html_entity_decode($photo, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            ->stripTags()
            ->squish()
            ->toString();

        if ($photo === '') {
            return null;
        }

        if (Str::of($photo)->startsWith('news/')) {
            return Storage::disk('public')->url($photo);
        }

        if (Str::of($photo)->startsWith(['http://', 'https://', '/'])) {
            return $this->absoluteLegacyUrl($photo);
        }

        return 'https://nemsu.edu.ph/files/News/'.rawurlencode($photo);
    }

    protected function cleanArticleHtml(string $html): string
    {
        [$document, $main] = $this->articleDocument($html);

        if (! $main instanceof DOMElement) {
            return '';
        }

        $this->sanitizeNode($main);

        return collect(iterator_to_array($main->childNodes))
            ->map(fn (DOMNode $node): string => $document->saveHTML($node) ?: '')
            ->implode('');
    }

    /**
     * @return array{0: DOMDocument, 1: DOMElement|null}
     */
    private function articleDocument(string $html): array
    {
        $document = new DOMDocument;
        $decoded = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $previous = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<!DOCTYPE html><html><body><main>'.$decoded.'</main></body></html>',
            LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $main = $document->getElementsByTagName('main')->item(0);

        return [$document, $main instanceof DOMElement ? $main : null];
    }

    private function sanitizeNode(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if (! $child instanceof DOMElement) {
                continue;
            }

            if (in_array($child->tagName, ['script', 'style', 'iframe', 'object', 'embed'], true)) {
                $child->parentNode?->removeChild($child);

                continue;
            }

            $this->sanitizeAttributes($child);
            $this->sanitizeNode($child);
        }
    }

    private function sanitizeAttributes(DOMElement $element): void
    {
        $allowed = match ($element->tagName) {
            'a' => ['href', 'title', 'target', 'rel'],
            'img' => ['src', 'alt', 'title'],
            default => [],
        };

        foreach (iterator_to_array($element->attributes) as $attribute) {
            if (! in_array($attribute->name, $allowed, true)) {
                $element->removeAttribute($attribute->name);
            }
        }

        if ($element->tagName === 'a' && $element->hasAttribute('href')) {
            $href = $this->absoluteLegacyUrl($element->getAttribute('href'));

            if (Str::of($href)->lower()->startsWith('javascript:')) {
                $element->removeAttribute('href');
            } else {
                $element->setAttribute('href', $href);
                $element->setAttribute('rel', 'noopener');
            }
        }

        if ($element->tagName === 'img' && $element->hasAttribute('src')) {
            $src = $this->absoluteLegacyUrl($element->getAttribute('src'));

            if (Str::of($src)->lower()->startsWith('javascript:')) {
                $element->removeAttribute('src');
            } else {
                $element->setAttribute('src', $src);
            }
        }
    }

    private function absoluteLegacyUrl(string $url): string
    {
        $url = trim($url);

        if (Str::of($url)->startsWith(['http://', 'https://', '#', 'mailto:', 'tel:'])) {
            return $url;
        }

        if (Str::of($url)->startsWith('/storage/')) {
            return $url;
        }

        if (Str::of($url)->startsWith('/')) {
            return 'https://nemsu.edu.ph'.$url;
        }

        return $url;
    }
}
