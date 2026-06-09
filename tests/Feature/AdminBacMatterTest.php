<?php

use App\Models\BacMatter;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

function bacMatterAdminUser(): User
{
    return User::factory()->create([
        'account_type' => 'admin',
    ]);
}

function bacMatterPayload(array $overrides = []): array
{
    return [
        'name' => 'Invitation to Bid for Laboratory Equipment',
        'link' => 'https://nemsu.edu.ph/bac/laboratory-equipment.pdf',
        'type' => 'ITB',
        'date' => '2026-06-03T09:30',
        'file_upload' => UploadedFile::fake()->create('laboratory-equipment.pdf', 256, 'application/pdf'),
        'is_published' => '1',
        ...$overrides,
    ];
}

test('guests are redirected to login from admin bac matters', function () {
    $this->get(route('admin.bac-matters.index'))
        ->assertRedirect(route('login'));
});

test('non admin users cannot manage bac matters', function () {
    $user = User::factory()->create([
        'account_type' => 'contributor',
    ]);

    $this->actingAs($user)
        ->get(route('admin.bac-matters.index'))
        ->assertForbidden();
});

test('admins can view bac matter management pages', function () {
    $admin = bacMatterAdminUser();
    $matter = BacMatter::factory()->create([
        'name' => 'Invitation to Bid',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.bac-matters.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/bac-matters/Index')
            ->has('matters.data', 1)
            ->where('matters.data.0.id', $matter->id)
        );

    $this->actingAs($admin)
        ->get(route('admin.bac-matters.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/bac-matters/Create')
            ->has('types')
        );

    $this->actingAs($admin)
        ->get(route('admin.bac-matters.edit', $matter))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/bac-matters/Edit')
            ->where('matter.id', $matter->id)
        );
});

test('admins can store bac matters with uploaded files', function () {
    Storage::fake('public');

    $admin = bacMatterAdminUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.bac-matters.store'), bacMatterPayload([
            'name' => ' Invitation to Bid for Laboratory Equipment ',
            'link' => null,
        ]));

    $matter = BacMatter::query()->firstOrFail();

    $response->assertRedirect(route('admin.bac-matters.edit', $matter));

    Storage::disk('public')->assertExists($matter->file);

    expect(Str::of($matter->file)->startsWith('bac-matters/'))->toBeTrue()
        ->and($matter->name)->toBe('Invitation to Bid for Laboratory Equipment')
        ->and($matter->link)->toBeNull()
        ->and($matter->type)->toBe('ITB')
        ->and($matter->date?->format('Y-m-d H:i'))->toBe('2026-06-03 09:30')
        ->and($matter->is_published)->toBeTrue();
});

test('admins can store bac matters with links only', function () {
    $admin = bacMatterAdminUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.bac-matters.store'), bacMatterPayload([
            'file_upload' => null,
            'link' => ' https://nemsu.edu.ph/bac/rfq.pdf ',
            'type' => 'RFQ',
            'is_published' => '0',
        ]));

    $matter = BacMatter::query()->firstOrFail();

    $response->assertRedirect(route('admin.bac-matters.edit', $matter));

    expect($matter->file)->toBeNull()
        ->and($matter->link)->toBe('https://nemsu.edu.ph/bac/rfq.pdf')
        ->and($matter->type)->toBe('RFQ')
        ->and($matter->is_published)->toBeFalse();
});

test('bac matters require a file or link', function () {
    $admin = bacMatterAdminUser();

    $this->actingAs($admin)
        ->from(route('admin.bac-matters.create'))
        ->post(route('admin.bac-matters.store'), bacMatterPayload([
            'file_upload' => null,
            'link' => null,
        ]))
        ->assertRedirect(route('admin.bac-matters.create'))
        ->assertSessionHasErrors('file_upload');
});

test('admins can update bac matters while keeping replacing removing and deleting files', function () {
    Storage::fake('public');
    Storage::disk('public')->put('bac-matters/original.pdf', 'original');

    $admin = bacMatterAdminUser();
    $matter = BacMatter::factory()->create([
        'file' => 'bac-matters/original.pdf',
        'link' => null,
        'name' => 'Old BAC Matter',
        'is_published' => true,
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.bac-matters.update', $matter), bacMatterPayload([
            'name' => 'Updated BAC Matter',
            'file_upload' => null,
            'link' => null,
            'is_published' => '0',
        ]))
        ->assertRedirect(route('admin.bac-matters.edit', $matter));

    expect($matter->refresh()->name)->toBe('Updated BAC Matter')
        ->and($matter->file)->toBe('bac-matters/original.pdf')
        ->and($matter->is_published)->toBeFalse();

    Storage::disk('public')->assertExists('bac-matters/original.pdf');

    $this->actingAs($admin)
        ->patch(route('admin.bac-matters.update', $matter), bacMatterPayload([
            'file_upload' => UploadedFile::fake()->create('replacement.pdf', 128, 'application/pdf'),
            'link' => null,
        ]))
        ->assertRedirect(route('admin.bac-matters.edit', $matter));

    $replacementFile = $matter->refresh()->file;

    expect($replacementFile)->not->toBe('bac-matters/original.pdf');
    Storage::disk('public')->assertMissing('bac-matters/original.pdf');
    Storage::disk('public')->assertExists($replacementFile);

    $this->actingAs($admin)
        ->patch(route('admin.bac-matters.update', $matter), bacMatterPayload([
            'file_upload' => null,
            'remove_file' => '1',
            'link' => 'https://nemsu.edu.ph/bac/replacement.pdf',
        ]))
        ->assertRedirect(route('admin.bac-matters.edit', $matter));

    expect($matter->refresh()->file)->toBeNull()
        ->and($matter->link)->toBe('https://nemsu.edu.ph/bac/replacement.pdf');
    Storage::disk('public')->assertMissing($replacementFile);

    Storage::disk('public')->put('bac-matters/delete-me.pdf', 'delete');
    $matter->update([
        'file' => 'bac-matters/delete-me.pdf',
        'link' => null,
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.bac-matters.destroy', $matter))
        ->assertRedirect(route('admin.bac-matters.index'));

    $this->assertModelMissing($matter);
    Storage::disk('public')->assertMissing('bac-matters/delete-me.pdf');
});

test('removing the current bac file requires a link or replacement upload', function () {
    Storage::fake('public');
    Storage::disk('public')->put('bac-matters/original.pdf', 'original');

    $admin = bacMatterAdminUser();
    $matter = BacMatter::factory()->create([
        'file' => 'bac-matters/original.pdf',
        'link' => null,
    ]);

    $this->actingAs($admin)
        ->from(route('admin.bac-matters.edit', $matter))
        ->patch(route('admin.bac-matters.update', $matter), bacMatterPayload([
            'file_upload' => null,
            'remove_file' => '1',
            'link' => null,
        ]))
        ->assertRedirect(route('admin.bac-matters.edit', $matter))
        ->assertSessionHasErrors('file_upload');
});

test('admin bac matter index searches filters and sorts records', function () {
    $admin = bacMatterAdminUser();
    $published = BacMatter::factory()->published()->create([
        'name' => 'Laboratory Equipment RFQ',
        'type' => 'RFQ',
        'date' => '2026-06-01 08:00:00',
    ]);
    BacMatter::factory()->create([
        'name' => 'Hidden Notice',
        'type' => 'ITB',
        'is_published' => false,
        'date' => '2026-05-01 08:00:00',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.bac-matters.index', [
            'search' => 'laboratory',
            'type' => 'RFQ',
            'status' => 'published',
            'sort_by' => 'date',
            'sort_direction' => 'desc',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('matters.data', 1)
            ->where('matters.data.0.id', $published->id)
            ->where('filters.search', 'laboratory')
            ->where('filters.type', 'RFQ')
            ->where('filters.status', 'published')
        );
});
