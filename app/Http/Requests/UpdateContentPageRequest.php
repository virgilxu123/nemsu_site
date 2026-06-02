<?php

namespace App\Http\Requests;

use App\Models\ContentPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateContentPageRequest extends FormRequest
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
        $contentPage = $this->route('content_page') ?? $this->route('contentPage');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('content_pages', 'slug')->ignore($contentPage instanceof ContentPage ? $contentPage->getKey() : null),
            ],
            'section' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['draft', 'published'])],
            'is_published' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'office_id' => ['nullable', 'integer', Rule::exists('offices', 'id')],
            'campus_id' => ['nullable', 'string', Rule::exists('campuses', 'id')],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $title = (string) $this->input('title');
        $slug = (string) $this->input('slug');
        $isPublished = $this->boolean('is_published');

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $title),
            'status' => $isPublished ? 'published' : (string) $this->input('status', 'draft'),
            'is_published' => $isPublished,
        ]);
    }
}
