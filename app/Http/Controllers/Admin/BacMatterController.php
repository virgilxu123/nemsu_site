<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBacMatterRequest;
use App\Http\Requests\UpdateBacMatterRequest;
use App\Models\BacMatter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BacMatterController extends Controller
{
    public const TYPES = ['ITB', 'RFQ', 'NOA', 'NTP', 'Bid Bulletin', 'Bid Bulletin 2'];

    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));
        $type = (string) $request->query('type', 'all');
        $status = (string) $request->query('status', 'all');
        $sortFields = [
            'name' => 'name',
            'type' => 'type',
            'date' => 'date',
            'is_published' => 'is_published',
            'updated_at' => 'updated_at',
        ];
        $sortBy = (string) $request->query('sort_by', 'date');
        $sortDirection = (string) $request->query('sort_direction', 'desc');

        if (! array_key_exists($sortBy, $sortFields)) {
            $sortBy = 'date';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        return Inertia::render('admin/bac-matters/Index', [
            'filters' => [
                'search' => $search,
                'type' => in_array($type, self::TYPES, true) ? $type : 'all',
                'status' => in_array($status, ['all', 'published', 'draft'], true) ? $status : 'all',
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'types' => self::TYPES,
            'matters' => BacMatter::query()
                ->select(['id', 'name', 'file', 'link', 'type', 'date', 'is_published', 'updated_at'])
                ->search($search, ['name', 'file', 'link', 'type'])
                ->when(in_array($type, self::TYPES, true), fn ($query) => $query->where('type', $type))
                ->when($status === 'published', fn ($query) => $query->where('is_published', true))
                ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
                ->sort($sortBy, $sortDirection, $sortFields, 'date', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (BacMatter $bacMatter): array => $this->matterListData($bacMatter)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/bac-matters/Create', [
            'types' => self::TYPES,
        ]);
    }

    public function store(StoreBacMatterRequest $request): RedirectResponse
    {
        $data = $this->normalizedData($request->validated());

        if ($request->hasFile('file_upload')) {
            $data['file'] = $request->file('file_upload')->store('bac-matters', 'public');
        }

        $bacMatter = BacMatter::query()->create($data);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'BAC matter created.',
        ]);

        return to_route('admin.bac-matters.edit', $bacMatter);
    }

    public function edit(BacMatter $bacMatter): Response
    {
        return Inertia::render('admin/bac-matters/Edit', [
            'matter' => $this->matterFormData($bacMatter),
            'types' => self::TYPES,
        ]);
    }

    public function update(UpdateBacMatterRequest $request, BacMatter $bacMatter): RedirectResponse
    {
        $data = $this->normalizedData($request->validated());
        $oldFile = $bacMatter->file;

        if ($request->boolean('remove_file')) {
            $data['file'] = null;
        }

        if ($request->hasFile('file_upload')) {
            $data['file'] = $request->file('file_upload')->store('bac-matters', 'public');
        }

        $bacMatter->update($data);

        if (array_key_exists('file', $data) && $data['file'] !== $oldFile) {
            $this->deleteUploadedFile($oldFile);
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'BAC matter updated.',
        ]);

        return to_route('admin.bac-matters.edit', $bacMatter);
    }

    public function destroy(BacMatter $bacMatter): RedirectResponse
    {
        $file = $bacMatter->file;

        $bacMatter->delete();
        $this->deleteUploadedFile($file);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'BAC matter deleted.',
        ]);

        return to_route('admin.bac-matters.index');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizedData(array $data): array
    {
        $data = Arr::only($data, [
            'name',
            'link',
            'type',
            'date',
            'is_published',
        ]);

        foreach (['name', 'link', 'type', 'date'] as $key) {
            $value = $data[$key] ?? null;
            $data[$key] = is_string($value) && trim($value) !== '' ? trim($value) : null;
        }

        $data['is_published'] = (bool) ($data['is_published'] ?? false);

        return $data;
    }

    /**
     * @return array{id: int, name: string, type: string|null, destinationUrl: string|null, destinationLabel: string, isPublished: bool, date: string|null, updatedAt: string|null}
     */
    private function matterListData(BacMatter $bacMatter): array
    {
        return [
            'id' => $bacMatter->id,
            'name' => $bacMatter->name,
            'type' => $bacMatter->type,
            'destinationUrl' => $this->destinationUrl($bacMatter),
            'destinationLabel' => filled($bacMatter->file) ? 'File' : (filled($bacMatter->link) ? 'Link' : 'None'),
            'isPublished' => (bool) $bacMatter->is_published,
            'date' => $bacMatter->date?->format('Y-m-d H:i'),
            'updatedAt' => $bacMatter->updated_at?->diffForHumans(),
        ];
    }

    /**
     * @return array{id: int, name: string, file: string|null, fileUrl: string|null, link: string|null, type: string|null, date: string|null, is_published: bool}
     */
    private function matterFormData(BacMatter $bacMatter): array
    {
        return [
            'id' => $bacMatter->id,
            'name' => $bacMatter->name,
            'file' => $bacMatter->file,
            'fileUrl' => $this->fileUrl($bacMatter->file),
            'link' => $bacMatter->link,
            'type' => $bacMatter->type,
            'date' => $bacMatter->date?->format('Y-m-d\TH:i'),
            'is_published' => (bool) $bacMatter->is_published,
        ];
    }

    private function destinationUrl(BacMatter $bacMatter): ?string
    {
        return $this->fileUrl($bacMatter->file) ?? $this->absoluteLegacyUrl($bacMatter->link);
    }

    private function fileUrl(?string $file): ?string
    {
        if (! filled($file)) {
            return null;
        }

        if (Str::of($file)->startsWith('bac-matters/')) {
            return Storage::disk('public')->url($file);
        }

        return $this->absoluteLegacyUrl($file);
    }

    private function absoluteLegacyUrl(?string $url): ?string
    {
        if (! filled($url)) {
            return null;
        }

        $url = Str::of(html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            ->stripTags()
            ->squish()
            ->toString();

        if ($url === '') {
            return null;
        }

        if (Str::of($url)->startsWith(['http://', 'https://'])) {
            return $url;
        }

        if (Str::of($url)->startsWith('/')) {
            return 'https://nemsu.edu.ph'.$url;
        }

        return 'https://nemsu.edu.ph/files/BAC/'.rawurlencode($url);
    }

    private function deleteUploadedFile(?string $file): void
    {
        if ($file !== null && Str::of($file)->startsWith('bac-matters/')) {
            Storage::disk('public')->delete($file);
        }
    }
}
