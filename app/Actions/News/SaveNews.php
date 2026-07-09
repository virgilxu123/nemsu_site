<?php

namespace App\Actions\News;

use App\Actions\ContentPages\SanitizeHtml;
use App\Models\News;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SaveNews
{
    public function __construct(
        private SanitizeHtml $sanitizeHtml,
        private ManageNewsImages $manageNewsImages,
    ) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(News $news, array $attributes): News
    {
        $oldPhoto = $news->photo;
        $oldContentPaths = $this->manageNewsImages->contentPaths((string) $news->content);
        $storedPaths = [];
        $data = Arr::only($attributes, [
            'title',
            'slug',
            'short_description',
            'content',
            'author',
            'office_id',
            'type',
            'is_published',
            'featured',
            'date',
        ]);

        foreach (['short_description', 'content', 'author', 'date'] as $key) {
            $value = $data[$key] ?? null;
            $data[$key] = is_string($value) && trim($value) !== '' ? trim($value) : null;
        }

        try {
            $photoUpload = $attributes['photo_upload'] ?? null;

            if ($photoUpload instanceof UploadedFile) {
                $data['photo'] = $this->manageNewsImages->storePhoto($photoUpload);
                $storedPaths[] = $data['photo'];
            } elseif ((bool) ($attributes['remove_photo'] ?? false)) {
                $data['photo'] = null;
            } elseif (! $news->exists) {
                $data['photo'] = null;
            }

            $contentImages = array_filter(
                (array) ($attributes['content_images'] ?? []),
                fn (mixed $image): bool => $image instanceof UploadedFile,
            );
            $processedContent = $this->manageNewsImages->storeContentImages(
                (string) ($data['content'] ?? ''),
                $contentImages,
            );
            $storedPaths = [...$storedPaths, ...$processedContent['storedPaths']];

            $data['slug'] = Str::slug((string) ($data['slug'] ?? $data['title']));
            $data['content'] = $this->sanitizeHtml->handle($processedContent['html']);
            $data['is_published'] = (bool) ($data['is_published'] ?? false);
            $data['featured'] = (bool) ($data['featured'] ?? false);
            $data['type'] = (string) ($data['type'] ?? 'news');

            $news->fill($data);
            $news->save();
        } catch (\Throwable $exception) {
            $this->manageNewsImages->deletePaths($storedPaths);

            throw $exception;
        }

        if ($oldPhoto !== $news->photo) {
            $this->manageNewsImages->deletePhoto($oldPhoto);
        }

        $newContentPaths = $this->manageNewsImages->contentPaths((string) $news->content);
        $this->manageNewsImages->deletePaths(array_diff($oldContentPaths, $newContentPaths));

        return $news;
    }

    public function deleteUploads(News $news): void
    {
        $this->manageNewsImages->deletePhoto($news->photo);
        $this->manageNewsImages->deletePaths(
            $this->manageNewsImages->contentPaths((string) $news->content),
        );
    }
}
