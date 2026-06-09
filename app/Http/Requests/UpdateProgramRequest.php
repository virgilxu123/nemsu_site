<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateProgramRequest extends FormRequest
{
    /**
     * @var list<string>
     */
    private array $degreePrograms = ['graduate studies', 'baccalaureate', 'associate'];

    /**
     * Determine if the user is authorized to make this request.
     */
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
            'code' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'loa' => ['nullable', 'string', 'max:255'],
            'loa_upload' => [
                'nullable',
                File::types(['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv'])
                    ->max('10mb'),
            ],
            'remove_loa' => ['sometimes', 'boolean'],
            'prospectus' => ['nullable', 'string', 'max:255'],
            'prospectus_upload' => [
                'nullable',
                File::types(['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv'])
                    ->max('10mb'),
            ],
            'remove_prospectus' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
            'college_id' => ['nullable', 'string', 'exists:colleges,id'],
            'campus_id' => ['required', 'string', 'exists:campuses,id'],
            'degree_program' => ['required', 'string', Rule::in($this->degreePrograms)],
            'is_archived' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'remove_loa' => $this->boolean('remove_loa'),
            'remove_prospectus' => $this->boolean('remove_prospectus'),
            'is_archived' => $this->boolean('is_archived'),
        ]);
    }
}
