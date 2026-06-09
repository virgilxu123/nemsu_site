<?php

namespace App\Http\Requests;

use App\Models\BacMatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

class UpdateBacMatterRequest extends FormRequest
{
    /**
     * @var list<string>
     */
    private array $types = ['ITB', 'RFQ', 'NOA', 'NTP', 'Bid Bulletin', 'Bid Bulletin 2'];

    public function authorize(): bool
    {
        return $this->user()?->can('manage-cms') ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', Rule::in($this->types)],
            'date' => ['nullable', 'date'],
            'file_upload' => [
                'nullable',
                File::types(['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv'])
                    ->max('10mb'),
            ],
            'remove_file' => ['sometimes', 'boolean'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $bacMatter = $this->route('bac_matter') ?? $this->route('bacMatter');
                $hasCurrentFile = $bacMatter instanceof BacMatter && filled($bacMatter->file);

                if ($this->boolean('remove_file')) {
                    $hasCurrentFile = false;
                }

                if (! $this->hasFile('file_upload') && ! $hasCurrentFile && ! filled($this->input('link'))) {
                    $validator->errors()->add('file_upload', 'Upload a file or provide a link.');
                }
            },
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'remove_file' => $this->boolean('remove_file'),
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
