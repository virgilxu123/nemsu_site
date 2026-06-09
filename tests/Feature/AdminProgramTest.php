<?php

use App\Models\Campus;
use App\Models\College;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

function programAdminUser(): User
{
    return User::factory()->create([
        'account_type' => 'admin',
    ]);
}

function programPayload(array $overrides = []): array
{
    $campus = Campus::factory()->create();
    $college = College::factory()->create();

    return [
        'code' => 'BSIT',
        'name' => 'Bachelor of Science in Information Technology',
        'loa' => null,
        'loa_upload' => UploadedFile::fake()->create('loa.pdf', 256, 'application/pdf'),
        'prospectus' => null,
        'prospectus_upload' => UploadedFile::fake()->create('prospectus.pdf', 256, 'application/pdf'),
        'description' => 'A technology-centered undergraduate program.',
        'college_id' => $college->id,
        'campus_id' => $campus->id,
        'degree_program' => 'baccalaureate',
        'is_archived' => '0',
        ...$overrides,
    ];
}

test('guests are redirected to login from admin programs', function () {
    $this->get(route('admin.programs.index'))
        ->assertRedirect(route('login'));
});

test('non admin users cannot manage programs', function () {
    $user = User::factory()->create([
        'account_type' => 'contributor',
    ]);

    $this->actingAs($user)
        ->get(route('admin.programs.index'))
        ->assertForbidden();
});

test('admins can view program management pages', function () {
    $admin = programAdminUser();
    $program = Program::factory()->create([
        'name' => 'Bachelor of Science in Fisheries',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.programs.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/programs/Index')
            ->has('programs.data', 1)
            ->where('programs.data.0.id', $program->id)
            ->has('campuses')
            ->has('colleges')
            ->has('degreePrograms')
        );

    $this->actingAs($admin)
        ->get(route('admin.programs.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/programs/Create')
            ->has('campuses')
            ->has('colleges')
            ->has('degreePrograms')
        );

    $this->actingAs($admin)
        ->get(route('admin.programs.edit', $program))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/programs/Edit')
            ->where('program.id', $program->id)
        );
});

test('admins can store programs with uploaded loa and prospectus files', function () {
    Storage::fake('public');

    $admin = programAdminUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.programs.store'), programPayload([
            'code' => ' BSCS ',
            'name' => ' Bachelor of Science in Computer Science ',
            'description' => ' Program description ',
            'is_archived' => '1',
        ]));

    $program = Program::query()->firstOrFail();

    $response->assertRedirect(route('admin.programs.edit', $program));

    Storage::disk('public')->assertExists($program->loa);
    Storage::disk('public')->assertExists($program->prospectus);

    expect(Str::of($program->loa)->startsWith('programs/loa/'))->toBeTrue()
        ->and(Str::of($program->prospectus)->startsWith('programs/prospectus/'))->toBeTrue()
        ->and($program->code)->toBe('BSCS')
        ->and($program->name)->toBe('Bachelor of Science in Computer Science')
        ->and($program->description)->toBe('Program description')
        ->and($program->degree_program)->toBe('baccalaureate')
        ->and($program->is_archived)->toBeTrue();
});

test('admins can store programs with legacy or external document values', function () {
    $admin = programAdminUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.programs.store'), programPayload([
            'loa' => ' https://nemsu.edu.ph/programs/bsit-loa.pdf ',
            'loa_upload' => null,
            'prospectus' => 'legacy-prospectus.pdf',
            'prospectus_upload' => null,
            'degree_program' => 'associate',
        ]));

    $program = Program::query()->firstOrFail();

    $response->assertRedirect(route('admin.programs.edit', $program));

    expect($program->loa)->toBe('https://nemsu.edu.ph/programs/bsit-loa.pdf')
        ->and($program->prospectus)->toBe('legacy-prospectus.pdf')
        ->and($program->degree_program)->toBe('associate');
});

test('program validation rejects missing required fields and invalid degree values', function () {
    $admin = programAdminUser();

    $this->actingAs($admin)
        ->from(route('admin.programs.create'))
        ->post(route('admin.programs.store'), programPayload([
            'name' => '',
            'campus_id' => '',
            'degree_program' => 'certificate',
        ]))
        ->assertRedirect(route('admin.programs.create'))
        ->assertSessionHasErrors(['name', 'campus_id', 'degree_program']);
});

test('admins can update programs while keeping replacing and removing local documents', function () {
    Storage::fake('public');
    Storage::disk('public')->put('programs/loa/original-loa.pdf', 'original loa');
    Storage::disk('public')->put('programs/prospectus/original-prospectus.pdf', 'original prospectus');

    $admin = programAdminUser();
    $program = Program::factory()->create([
        'loa' => 'programs/loa/original-loa.pdf',
        'prospectus' => 'programs/prospectus/original-prospectus.pdf',
        'name' => 'Old Program',
        'is_archived' => true,
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.programs.update', $program), programPayload([
            'name' => 'Updated Program',
            'loa' => $program->loa,
            'loa_upload' => null,
            'prospectus' => $program->prospectus,
            'prospectus_upload' => null,
            'is_archived' => '0',
        ]))
        ->assertRedirect(route('admin.programs.edit', $program));

    expect($program->refresh()->name)->toBe('Updated Program')
        ->and($program->loa)->toBe('programs/loa/original-loa.pdf')
        ->and($program->prospectus)->toBe('programs/prospectus/original-prospectus.pdf')
        ->and($program->is_archived)->toBeFalse();

    Storage::disk('public')->assertExists('programs/loa/original-loa.pdf');
    Storage::disk('public')->assertExists('programs/prospectus/original-prospectus.pdf');

    $this->actingAs($admin)
        ->patch(route('admin.programs.update', $program), programPayload([
            'loa' => $program->loa,
            'loa_upload' => UploadedFile::fake()->create('replacement-loa.pdf', 128, 'application/pdf'),
            'prospectus' => $program->prospectus,
            'prospectus_upload' => UploadedFile::fake()->create('replacement-prospectus.pdf', 128, 'application/pdf'),
        ]))
        ->assertRedirect(route('admin.programs.edit', $program));

    $replacementLoa = $program->refresh()->loa;
    $replacementProspectus = $program->prospectus;

    expect($replacementLoa)->not->toBe('programs/loa/original-loa.pdf')
        ->and($replacementProspectus)->not->toBe('programs/prospectus/original-prospectus.pdf');
    Storage::disk('public')->assertMissing('programs/loa/original-loa.pdf');
    Storage::disk('public')->assertMissing('programs/prospectus/original-prospectus.pdf');
    Storage::disk('public')->assertExists($replacementLoa);
    Storage::disk('public')->assertExists($replacementProspectus);

    $this->actingAs($admin)
        ->patch(route('admin.programs.update', $program), programPayload([
            'loa' => $program->loa,
            'loa_upload' => null,
            'remove_loa' => '1',
            'prospectus' => $program->prospectus,
            'prospectus_upload' => null,
            'remove_prospectus' => '1',
        ]))
        ->assertRedirect(route('admin.programs.edit', $program));

    expect($program->refresh()->loa)->toBeNull()
        ->and($program->prospectus)->toBeNull();
    Storage::disk('public')->assertMissing($replacementLoa);
    Storage::disk('public')->assertMissing($replacementProspectus);
});

test('deleting programs removes local uploads and preserves unrelated legacy paths', function () {
    Storage::fake('public');
    Storage::disk('public')->put('programs/loa/delete-loa.pdf', 'delete loa');
    Storage::disk('public')->put('legacy-prospectus.pdf', 'legacy');

    $admin = programAdminUser();
    $program = Program::factory()->create([
        'loa' => 'programs/loa/delete-loa.pdf',
        'prospectus' => 'legacy-prospectus.pdf',
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.programs.destroy', $program))
        ->assertRedirect(route('admin.programs.index'));

    $this->assertModelMissing($program);
    Storage::disk('public')->assertMissing('programs/loa/delete-loa.pdf');
    Storage::disk('public')->assertExists('legacy-prospectus.pdf');
});

test('admin program index searches filters and sorts records', function () {
    $admin = programAdminUser();
    $campus = Campus::factory()->create(['name' => 'Main Campus']);
    $college = College::factory()->create(['code' => 'CIT', 'name' => 'College of Information Technology']);
    $matchingProgram = Program::factory()->create([
        'name' => 'Software Engineering Program',
        'code' => 'BSSE',
        'campus_id' => $campus->id,
        'college_id' => $college->id,
        'degree_program' => 'baccalaureate',
        'is_archived' => false,
    ]);
    Program::factory()->archived()->create([
        'name' => 'Hidden Graduate Program',
        'code' => 'HGP',
        'degree_program' => 'graduate studies',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.programs.index', [
            'search' => 'software',
            'campus_id' => $campus->id,
            'college_id' => $college->id,
            'degree_program' => 'baccalaureate',
            'archive_status' => 'active',
            'sort_by' => 'name',
            'sort_direction' => 'asc',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('programs.data', 1)
            ->where('programs.data.0.id', $matchingProgram->id)
            ->where('filters.search', 'software')
            ->where('filters.campus_id', $campus->id)
            ->where('filters.college_id', $college->id)
            ->where('filters.degree_program', 'baccalaureate')
            ->where('filters.archive_status', 'active')
        );
});
