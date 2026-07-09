<?php

namespace App\Http\Requests;

use App\Models\News;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-cms') ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $news = $this->route('news') ?? $this->route('announcement');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('news', 'slug')->ignore($news instanceof News ? $news->getKey() : null),
            ],
            'short_description' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'photo_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_photo' => ['sometimes', 'boolean'],
            'content_images' => ['sometimes', 'array'],
            'content_images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'author' => ['nullable', 'string', 'max:255'],
            'office_id' => ['nullable', 'integer', Rule::exists('offices', 'id')],
            'type' => ['required', 'string', Rule::in(['news', 'announcement'])],
            'is_published' => ['sometimes', 'boolean'],
            'featured' => ['sometimes', 'boolean'],
            'date' => ['required', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $title = (string) $this->input('title');
        $slug = (string) $this->input('slug');

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $title),
            'is_published' => $this->boolean('is_published'),
            'featured' => $this->boolean('featured'),
            'remove_photo' => $this->boolean('remove_photo'),
        ]);
    }
}
