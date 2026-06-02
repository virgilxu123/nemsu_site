<?php

namespace App\Actions\News;

use App\Actions\ContentPages\SanitizeHtml;
use App\Models\News;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SaveNews
{
    public function __construct(private SanitizeHtml $sanitizeHtml) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(News $news, array $attributes): News
    {
        $data = Arr::only($attributes, [
            'title',
            'slug',
            'short_description',
            'content',
            'photo',
            'author',
            'office_id',
            'type',
            'is_published',
            'featured',
            'date',
        ]);

        foreach (['short_description', 'content', 'photo', 'author', 'date'] as $key) {
            $value = $data[$key] ?? null;
            $data[$key] = is_string($value) && trim($value) !== '' ? trim($value) : null;
        }

        $data['slug'] = Str::slug((string) ($data['slug'] ?? $data['title']));
        $data['content'] = $this->sanitizeHtml->handle((string) ($data['content'] ?? ''));
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['featured'] = (bool) ($data['featured'] ?? false);
        $data['type'] = (string) ($data['type'] ?? 'news');

        $news->fill($data);
        $news->save();

        return $news;
    }
}
