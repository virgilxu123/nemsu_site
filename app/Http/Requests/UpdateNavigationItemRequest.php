<?php

namespace App\Http\Requests;

use App\Models\ContentPage;
use App\Models\NavigationItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateNavigationItemRequest extends FormRequest
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
        $navigationItem = $this->route('navigationItem');

        return [
            'location' => ['required', 'string', Rule::in(['main', 'footer'])],
            'label' => ['required', 'string', 'max:255'],
            'parent_id' => [
                'nullable',
                'string',
                Rule::notIn([$navigationItem instanceof NavigationItem ? $navigationItem->getKey() : null]),
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
                $navigationItem = $this->route('navigationItem');
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

                if ($navigationItem instanceof NavigationItem) {
                    $this->validateParentCycle($validator, $navigationItem);
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

    private function validateParentCycle(Validator $validator, NavigationItem $navigationItem): void
    {
        $parentId = $this->string('parent_id')->toString();

        while ($parentId !== '') {
            if ($parentId === $navigationItem->getKey()) {
                $validator->errors()->add('parent_id', 'A navigation item cannot be nested under itself.');

                return;
            }

            $parentId = (string) NavigationItem::query()
                ->whereKey($parentId)
                ->value('parent_id');
        }
    }
}
