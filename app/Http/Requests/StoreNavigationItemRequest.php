<?php

namespace App\Http\Requests;

use App\Models\ContentPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreNavigationItemRequest extends FormRequest
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
        $location = (string) $this->input('location', 'main');

        return [
            'location' => ['required', 'string', Rule::in(['main', 'footer'])],
            'label' => ['required', 'string', 'max:255'],
            'parent_id' => [
                'nullable',
                'string',
                Rule::exists('navigation_items', 'id')->where('location', $location),
            ],
            'url' => ['nullable', 'string', 'max:255'],
            'route_name' => ['nullable', 'string', 'max:255'],
            'target_type' => ['nullable', 'string', Rule::in(['content_page'])],
            'target_id' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $targetType = $this->string('target_type')->toString();
                $targetId = $this->string('target_id')->toString();

                if ($targetType === '' && $targetId !== '') {
                    $validator->errors()->add('target_type', 'Select a target type.');
                }

                if ($targetType !== '' && $targetId === '') {
                    $validator->errors()->add('target_id', 'Select a target page.');
                }

                if ($targetType === 'content_page' && $targetId !== '' && ! ContentPage::query()->whereKey($targetId)->exists()) {
                    $validator->errors()->add('target_id', 'The selected content page is invalid.');
                }
            },
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'location' => (string) $this->input('location', 'main'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
