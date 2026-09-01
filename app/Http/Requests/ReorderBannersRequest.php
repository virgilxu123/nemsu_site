<?php

namespace App\Http\Requests;

use App\Models\Banner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReorderBannersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-cms') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'banner_ids' => ['required', 'array', 'min:1'],
            'banner_ids.*' => ['required', 'integer', 'distinct:strict', Rule::exists(Banner::class, 'id')],
        ];
    }
}
