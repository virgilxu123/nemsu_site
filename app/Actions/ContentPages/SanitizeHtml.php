<?php

namespace App\Actions\ContentPages;

use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Support\Str;

class SanitizeHtml
{
    public function handle(string $html): string
    {
        $html = preg_replace('/<\s*(script|style|iframe|object|embed)\b[^>]*>.*?<\s*\/\s*\1\s*>/is', '', $html) ?? '';
        $html = strip_tags($html, '<p><br><strong><b><em><i><u><s><blockquote><ul><ol><li><a><h2><h3><h4>');

        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<!DOCTYPE html><html><body><main>'.$html.'</main></body></html>',
            LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $main = $document->getElementsByTagName('main')->item(0);

        if (! $main instanceof DOMElement) {
            return '';
        }

        $this->sanitizeNode($main);

        return collect(iterator_to_array($main->childNodes))
            ->map(fn (DOMNode $node): string => $document->saveHTML($node) ?: '')
            ->implode('');
    }

    private function sanitizeNode(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if (! $child instanceof DOMElement) {
                continue;
            }

            foreach (iterator_to_array($child->attributes) as $attribute) {
                if ($child->tagName !== 'a' || ! in_array($attribute->name, ['href', 'title', 'target', 'rel'], true)) {
                    $child->removeAttribute($attribute->name);
                }
            }

            if ($child->tagName === 'a' && $child->hasAttribute('href')) {
                $href = trim($child->getAttribute('href'));

                if (Str::of($href)->lower()->startsWith('javascript:')) {
                    $child->removeAttribute('href');
                } else {
                    $child->setAttribute('rel', 'noopener');
                }
            }

            $this->sanitizeNode($child);
        }
    }
}
