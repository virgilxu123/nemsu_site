<?php

namespace App\Actions\ContentPages;

use App\Models\ContentPage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SaveContentPage
{
    public function __construct(private SanitizeHtml $sanitizeHtml) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(ContentPage $contentPage, array $attributes): ContentPage
    {
        $data = Arr::only($attributes, [
            'slug',
            'title',
            'section',
            'body',
            'excerpt',
            'status',
            'is_published',
            'published_at',
            'office_id',
            'campus_id',
            'sort_order',
        ]);

        foreach (['section', 'body', 'excerpt', 'published_at', 'campus_id'] as $key) {
            $value = $data[$key] ?? null;
            $data[$key] = is_string($value) && trim($value) !== '' ? trim($value) : null;
        }

        $data['slug'] = Str::slug((string) ($data['slug'] ?? $data['title']));
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['status'] = $data['is_published'] ? 'published' : (string) ($data['status'] ?? 'draft');
        $data['body'] = $this->sanitizeHtml->handle((string) ($data['body'] ?? ''));
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $contentPage->fill($data);
        $contentPage->save();

        return $contentPage;
    }
}
