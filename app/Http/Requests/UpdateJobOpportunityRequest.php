<?php

namespace App\Http\Requests;

use App\Models\JobOpportunity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateJobOpportunityRequest extends FormRequest
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
        $jobOpportunity = $this->route('job_opportunity') ?? $this->route('jobOpportunity');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('job_opportunities', 'slug')->ignore($jobOpportunity instanceof JobOpportunity ? $jobOpportunity->getKey() : null),
            ],
            'content' => ['required', 'string'],
            'date' => ['required', 'date'],
            'is_hiring' => ['sometimes', 'boolean'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $name = (string) $this->input('name');
        $slug = (string) $this->input('slug');

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $name),
            'is_hiring' => $this->boolean('is_hiring'),
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
