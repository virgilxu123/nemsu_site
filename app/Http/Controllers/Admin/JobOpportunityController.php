<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobOpportunityRequest;
use App\Http\Requests\UpdateJobOpportunityRequest;
use App\Models\JobOpportunity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

class JobOpportunityController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));
        $hiringStatus = (string) $request->query('hiring_status', 'all');
        $publicationStatus = (string) $request->query('publication_status', 'all');
        $sortFields = [
            'name' => 'name',
            'date' => 'date',
            'is_hiring' => 'is_hiring',
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

        return Inertia::render('admin/job-opportunities/Index', [
            'filters' => [
                'search' => $search,
                'hiring_status' => in_array($hiringStatus, ['all', 'hiring', 'closed'], true) ? $hiringStatus : 'all',
                'publication_status' => in_array($publicationStatus, ['all', 'published', 'draft'], true) ? $publicationStatus : 'all',
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'opportunities' => JobOpportunity::query()
                ->select(['id', 'name', 'slug', 'date', 'is_hiring', 'is_published', 'updated_at'])
                ->search($search, ['name', 'slug', 'content'])
                ->when($hiringStatus === 'hiring', fn ($query) => $query->where('is_hiring', true))
                ->when($hiringStatus === 'closed', fn ($query) => $query->where('is_hiring', false))
                ->when($publicationStatus === 'published', fn ($query) => $query->where('is_published', true))
                ->when($publicationStatus === 'draft', fn ($query) => $query->where('is_published', false))
                ->sort($sortBy, $sortDirection, $sortFields, 'date', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (JobOpportunity $jobOpportunity): array => $this->opportunityListData($jobOpportunity)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/job-opportunities/Create');
    }

    public function store(StoreJobOpportunityRequest $request): RedirectResponse
    {
        $jobOpportunity = JobOpportunity::query()->create($this->normalizedData($request->validated()));

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Job opportunity created.',
        ]);

        return to_route('admin.job-opportunities.edit', $jobOpportunity);
    }

    public function edit(JobOpportunity $jobOpportunity): Response
    {
        return Inertia::render('admin/job-opportunities/Edit', [
            'opportunity' => $this->opportunityFormData($jobOpportunity),
        ]);
    }

    public function update(UpdateJobOpportunityRequest $request, JobOpportunity $jobOpportunity): RedirectResponse
    {
        $jobOpportunity->update($this->normalizedData($request->validated()));

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Job opportunity updated.',
        ]);

        return to_route('admin.job-opportunities.edit', $jobOpportunity);
    }

    public function destroy(JobOpportunity $jobOpportunity): RedirectResponse
    {
        $jobOpportunity->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Job opportunity deleted.',
        ]);

        return to_route('admin.job-opportunities.index');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizedData(array $data): array
    {
        $data = Arr::only($data, ['name', 'slug', 'content', 'date', 'is_hiring', 'is_published']);

        foreach (['name', 'slug', 'content', 'date'] as $key) {
            $value = $data[$key] ?? null;
            $data[$key] = is_string($value) ? trim($value) : $value;
        }

        $data['is_hiring'] = (bool) ($data['is_hiring'] ?? false);
        $data['is_published'] = (bool) ($data['is_published'] ?? false);

        return $data;
    }

    /**
     * @return array{id: string, name: string, slug: string, date: string, isHiring: bool, isPublished: bool, updatedAt: string|null}
     */
    private function opportunityListData(JobOpportunity $jobOpportunity): array
    {
        return [
            'id' => $jobOpportunity->id,
            'name' => $jobOpportunity->name,
            'slug' => $jobOpportunity->slug,
            'date' => $jobOpportunity->date->format('Y-m-d H:i'),
            'isHiring' => (bool) $jobOpportunity->is_hiring,
            'isPublished' => (bool) $jobOpportunity->is_published,
            'updatedAt' => $jobOpportunity->updated_at?->diffForHumans(),
        ];
    }

    /**
     * @return array{id: string, name: string, slug: string, content: string, date: string, is_hiring: bool, is_published: bool}
     */
    private function opportunityFormData(JobOpportunity $jobOpportunity): array
    {
        return [
            'id' => $jobOpportunity->id,
            'name' => $jobOpportunity->name,
            'slug' => $jobOpportunity->slug,
            'content' => $jobOpportunity->content,
            'date' => $jobOpportunity->date->format('Y-m-d\TH:i'),
            'is_hiring' => (bool) $jobOpportunity->is_hiring,
            'is_published' => (bool) $jobOpportunity->is_published,
        ];
    }
}
