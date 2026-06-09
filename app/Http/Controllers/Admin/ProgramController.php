<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Campus;
use App\Models\College;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProgramController extends Controller
{
    public const DEGREE_PROGRAMS = ['graduate studies', 'baccalaureate', 'associate'];

    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));
        $campusId = (string) $request->query('campus_id', 'all');
        $collegeId = (string) $request->query('college_id', 'all');
        $degreeProgram = (string) $request->query('degree_program', 'all');
        $archiveStatus = (string) $request->query('archive_status', 'active');
        $sortFields = [
            'name' => 'name',
            'code' => 'code',
            'degree_program' => 'degree_program',
            'is_archived' => 'is_archived',
            'updated_at' => 'updated_at',
        ];
        $sortBy = (string) $request->query('sort_by', 'name');
        $sortDirection = (string) $request->query('sort_direction', 'asc');

        if (! array_key_exists($sortBy, $sortFields)) {
            $sortBy = 'name';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'asc';
        }

        $campuses = $this->campusOptions();
        $colleges = $this->collegeOptions();
        $validCampusIds = $campuses->pluck('id')->all();
        $validCollegeIds = $colleges->pluck('id')->all();

        return Inertia::render('admin/programs/Index', [
            'filters' => [
                'search' => $search,
                'campus_id' => in_array($campusId, $validCampusIds, true) ? $campusId : 'all',
                'college_id' => in_array($collegeId, $validCollegeIds, true) ? $collegeId : 'all',
                'degree_program' => in_array($degreeProgram, self::DEGREE_PROGRAMS, true) ? $degreeProgram : 'all',
                'archive_status' => in_array($archiveStatus, ['all', 'active', 'archived'], true) ? $archiveStatus : 'active',
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'degreePrograms' => self::DEGREE_PROGRAMS,
            'campuses' => $campuses,
            'colleges' => $colleges,
            'programs' => Program::query()
                ->select(['id', 'code', 'name', 'loa', 'prospectus', 'college_id', 'campus_id', 'degree_program', 'is_archived', 'updated_at'])
                ->with(['campus:id,name', 'college:id,code,name'])
                ->search($search, ['code', 'name', 'loa', 'prospectus', 'description', 'degree_program'])
                ->when(in_array($campusId, $validCampusIds, true), fn ($query) => $query->where('campus_id', $campusId))
                ->when(in_array($collegeId, $validCollegeIds, true), fn ($query) => $query->where('college_id', $collegeId))
                ->when(in_array($degreeProgram, self::DEGREE_PROGRAMS, true), fn ($query) => $query->where('degree_program', $degreeProgram))
                ->when($archiveStatus === 'active', fn ($query) => $query->where('is_archived', false))
                ->when($archiveStatus === 'archived', fn ($query) => $query->where('is_archived', true))
                ->sort($sortBy, $sortDirection, $sortFields, 'name', 'asc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (Program $program): array => $this->programListData($program)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/programs/Create', [
            'degreePrograms' => self::DEGREE_PROGRAMS,
            'campuses' => $this->campusOptions(),
            'colleges' => $this->collegeOptions(),
        ]);
    }

    public function store(StoreProgramRequest $request): RedirectResponse
    {
        $data = $this->normalizedData($request->validated());

        if ($request->hasFile('loa_upload')) {
            $data['loa'] = $request->file('loa_upload')->store('programs/loa', 'public');
        }

        if ($request->hasFile('prospectus_upload')) {
            $data['prospectus'] = $request->file('prospectus_upload')->store('programs/prospectus', 'public');
        }

        $program = Program::query()->create($data);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Program created.',
        ]);

        return to_route('admin.programs.edit', $program);
    }

    public function edit(Program $program): Response
    {
        return Inertia::render('admin/programs/Edit', [
            'program' => $this->programFormData($program),
            'degreePrograms' => self::DEGREE_PROGRAMS,
            'campuses' => $this->campusOptions(),
            'colleges' => $this->collegeOptions(),
        ]);
    }

    public function update(UpdateProgramRequest $request, Program $program): RedirectResponse
    {
        $data = $this->normalizedData($request->validated());
        $oldLoa = $program->loa;
        $oldProspectus = $program->prospectus;

        if ($request->boolean('remove_loa')) {
            $data['loa'] = null;
        }

        if ($request->hasFile('loa_upload')) {
            $data['loa'] = $request->file('loa_upload')->store('programs/loa', 'public');
        }

        if ($request->boolean('remove_prospectus')) {
            $data['prospectus'] = null;
        }

        if ($request->hasFile('prospectus_upload')) {
            $data['prospectus'] = $request->file('prospectus_upload')->store('programs/prospectus', 'public');
        }

        $program->update($data);

        if (array_key_exists('loa', $data) && $data['loa'] !== $oldLoa) {
            $this->deleteUploadedFile($oldLoa);
        }

        if (array_key_exists('prospectus', $data) && $data['prospectus'] !== $oldProspectus) {
            $this->deleteUploadedFile($oldProspectus);
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Program updated.',
        ]);

        return to_route('admin.programs.edit', $program);
    }

    public function destroy(Program $program): RedirectResponse
    {
        $loa = $program->loa;
        $prospectus = $program->prospectus;

        $program->delete();
        $this->deleteUploadedFile($loa);
        $this->deleteUploadedFile($prospectus);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Program deleted.',
        ]);

        return to_route('admin.programs.index');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizedData(array $data): array
    {
        $data = Arr::only($data, [
            'code',
            'name',
            'loa',
            'prospectus',
            'description',
            'college_id',
            'campus_id',
            'degree_program',
            'is_archived',
        ]);

        foreach (['code', 'name', 'loa', 'prospectus', 'description', 'college_id', 'campus_id', 'degree_program'] as $key) {
            $value = $data[$key] ?? null;
            $data[$key] = is_string($value) && trim($value) !== '' ? trim($value) : null;
        }

        $data['is_archived'] = (bool) ($data['is_archived'] ?? false);

        return $data;
    }

    /**
     * @return array{id: int, code: string|null, name: string, campus: string|null, college: string|null, degreeProgram: string, degreeLabel: string, loaUrl: string|null, prospectusUrl: string|null, isArchived: bool, updatedAt: string|null}
     */
    private function programListData(Program $program): array
    {
        return [
            'id' => $program->id,
            'code' => $program->code,
            'name' => $program->name,
            'campus' => $program->campus?->name,
            'college' => $program->college?->code ?? $program->college?->name,
            'degreeProgram' => $program->degree_program,
            'degreeLabel' => Str::of($program->degree_program)->title()->toString(),
            'loaUrl' => $this->documentUrl($program->loa),
            'prospectusUrl' => $this->documentUrl($program->prospectus),
            'isArchived' => (bool) $program->is_archived,
            'updatedAt' => $program->updated_at?->diffForHumans(),
        ];
    }

    /**
     * @return array{id: int, code: string|null, name: string, loa: string|null, loaUrl: string|null, prospectus: string|null, prospectusUrl: string|null, description: string|null, college_id: string|null, campus_id: string|null, degree_program: string, is_archived: bool}
     */
    private function programFormData(Program $program): array
    {
        return [
            'id' => $program->id,
            'code' => $program->code,
            'name' => $program->name,
            'loa' => $program->loa,
            'loaUrl' => $this->documentUrl($program->loa),
            'prospectus' => $program->prospectus,
            'prospectusUrl' => $this->documentUrl($program->prospectus),
            'description' => $program->description,
            'college_id' => $program->college_id,
            'campus_id' => $program->campus_id,
            'degree_program' => $program->degree_program,
            'is_archived' => (bool) $program->is_archived,
        ];
    }

    private function documentUrl(?string $document): ?string
    {
        if (! filled($document)) {
            return null;
        }

        if (Str::of($document)->startsWith('programs/')) {
            return Storage::disk('public')->url($document);
        }

        $document = Str::of(html_entity_decode($document, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            ->stripTags()
            ->squish()
            ->toString();

        if ($document === '') {
            return null;
        }

        return $document;
    }

    private function deleteUploadedFile(?string $file): void
    {
        if ($file !== null && Str::of($file)->startsWith('programs/')) {
            Storage::disk('public')->delete($file);
        }
    }

    /**
     * @return Collection<int, array{id: string, name: string}>
     */
    private function campusOptions(): Collection
    {
        return Campus::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get()
            ->map(fn (Campus $campus): array => [
                'id' => $campus->id,
                'name' => $campus->name,
            ]);
    }

    /**
     * @return Collection<int, array{id: string, code: string, name: string, label: string}>
     */
    private function collegeOptions(): Collection
    {
        return College::query()
            ->select(['id', 'code', 'name'])
            ->orderBy('name')
            ->get()
            ->map(fn (College $college): array => [
                'id' => $college->id,
                'code' => $college->code,
                'name' => $college->name,
                'label' => filled($college->code) ? "{$college->code} - {$college->name}" : $college->name,
            ]);
    }
}
