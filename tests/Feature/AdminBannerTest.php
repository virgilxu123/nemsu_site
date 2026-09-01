<?php

use App\Models\Banner;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

function bannerAdminUser(): User
{
    return User::factory()->create([
        'account_type' => 'admin',
    ]);
}

function bannerPayload(array $overrides = []): array
{
    return [
        'photo' => 'campus banner.jpg',
        'link' => 'https://nemsu.edu.ph/admissions',
        'title' => 'Enrollment Now Open',
        'content' => '<p>Applications for the coming term are now open.</p>',
        'office_id' => null,
        'is_published' => '1',
        ...$overrides,
    ];
}

test('guests are redirected to login from admin banners', function () {
    $this->get(route('admin.banners.index'))
        ->assertRedirect(route('login'));

    $this->patch(route('admin.banners.reorder'), ['banner_ids' => [1]])
        ->assertRedirect(route('login'));
});

test('non admin users cannot manage banners', function () {
    $user = User::factory()->create([
        'account_type' => 'contributor',
    ]);

    $this->actingAs($user)
        ->get(route('admin.banners.index'))
        ->assertForbidden();

    $this->actingAs($user)
        ->patch(route('admin.banners.reorder'), ['banner_ids' => [1]])
        ->assertForbidden();
});

test('admins can view banner management pages', function () {
    $admin = bannerAdminUser();
    $banner = Banner::factory()->create([
        'title' => 'Enrollment Now Open',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.banners.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/banners/Index')
            ->has('banners.data', 1)
            ->has('bannerOrder', 1)
            ->where('banners.data.0.id', $banner->id)
            ->where('bannerOrder.0', $banner->id)
            ->where('filters.sort_by', 'sequence')
            ->where('filters.sort_direction', 'asc')
        );

    $this->actingAs($admin)
        ->get(route('admin.banners.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('admin/banners/Create'));

    $this->actingAs($admin)
        ->get(route('admin.banners.edit', $banner))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/banners/Edit')
            ->where('banner.id', $banner->id)
        );
});

test('admins can store banners with normalized data', function () {
    $admin = bannerAdminUser();
    Banner::factory()->create(['sequence' => 4]);

    $response = $this->actingAs($admin)
        ->post(route('admin.banners.store'), bannerPayload([
            'photo' => ' campus banner.jpg ',
            'title' => ' Enrollment Now Open ',
            'link' => ' https://nemsu.edu.ph/admissions ',
        ]));

    $banner = Banner::query()->where('title', 'Enrollment Now Open')->firstOrFail();

    $response->assertRedirect(route('admin.banners.edit', $banner));

    expect($banner->photo)->toBe('campus banner.jpg')
        ->and($banner->title)->toBe('Enrollment Now Open')
        ->and($banner->link)->toBe('https://nemsu.edu.ph/admissions')
        ->and($banner->is_published)->toBeTrue()
        ->and($banner->sequence)->toBe(5);
});

test('admins can update and delete banners', function () {
    $admin = bannerAdminUser();
    $banner = Banner::factory()->create([
        'title' => 'Old Banner',
        'is_published' => true,
        'sequence' => 7,
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.banners.update', $banner), bannerPayload([
            'title' => 'Updated Banner',
            'is_published' => '0',
            'sequence' => 99,
        ]))
        ->assertRedirect(route('admin.banners.edit', $banner));

    expect($banner->refresh()->title)->toBe('Updated Banner')
        ->and($banner->is_published)->toBeFalse()
        ->and($banner->sequence)->toBe(7);

    $this->actingAs($admin)
        ->delete(route('admin.banners.destroy', $banner))
        ->assertRedirect(route('admin.banners.index'));

    $this->assertModelMissing($banner);
});

test('admins can reorder published and draft banners without changing their status', function () {
    $admin = bannerAdminUser();
    $firstBanner = Banner::factory()->published()->create(['sequence' => 0]);
    $draftBanner = Banner::factory()->create(['sequence' => 1]);
    $lastBanner = Banner::factory()->published()->create(['sequence' => 2]);

    $this->actingAs($admin)
        ->from(route('admin.banners.index'))
        ->patch(route('admin.banners.reorder'), [
            'banner_ids' => [$lastBanner->id, $firstBanner->id, $draftBanner->id],
        ])
        ->assertRedirect(route('admin.banners.index'))
        ->assertSessionHasNoErrors();

    expect($lastBanner->refresh()->sequence)->toBe(0)
        ->and($lastBanner->is_published)->toBeTrue()
        ->and($firstBanner->refresh()->sequence)->toBe(1)
        ->and($firstBanner->is_published)->toBeTrue()
        ->and($draftBanner->refresh()->sequence)->toBe(2)
        ->and($draftBanner->is_published)->toBeFalse();

    $this->actingAs($admin)
        ->patch(route('admin.banners.update', $draftBanner), bannerPayload([
            'is_published' => '1',
            'sequence' => 50,
        ]))
        ->assertRedirect(route('admin.banners.edit', $draftBanner));

    expect($draftBanner->refresh()->is_published)->toBeTrue()
        ->and($draftBanner->sequence)->toBe(2);
});

test('banner reorder rejects duplicate or incomplete banner lists', function () {
    $admin = bannerAdminUser();
    $firstBanner = Banner::factory()->create(['sequence' => 0]);
    $secondBanner = Banner::factory()->published()->create(['sequence' => 1]);

    $this->actingAs($admin)
        ->from(route('admin.banners.index'))
        ->patch(route('admin.banners.reorder'), [
            'banner_ids' => [$firstBanner->id, $firstBanner->id],
        ])
        ->assertRedirect(route('admin.banners.index'))
        ->assertSessionHasErrors('banner_ids.1');

    $this->actingAs($admin)
        ->from(route('admin.banners.index'))
        ->patch(route('admin.banners.reorder'), [
            'banner_ids' => [$secondBanner->id],
        ])
        ->assertRedirect(route('admin.banners.index'))
        ->assertSessionHasErrors('banner_ids');

    expect($firstBanner->refresh()->sequence)->toBe(0)
        ->and($secondBanner->refresh()->sequence)->toBe(1);
});

test('admin banner index searches filters and sorts records', function () {
    $admin = bannerAdminUser();
    $published = Banner::factory()->published()->create([
        'title' => 'Admissions Banner',
        'photo' => 'admissions.jpg',
    ]);
    Banner::factory()->create([
        'title' => 'Hidden Banner',
        'photo' => 'hidden.jpg',
        'is_published' => false,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.banners.index', [
            'search' => 'admissions',
            'status' => 'published',
            'sort_by' => 'title',
            'sort_direction' => 'asc',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('banners.data', 1)
            ->has('bannerOrder', 2)
            ->where('banners.data.0.id', $published->id)
            ->where('filters.search', 'admissions')
            ->where('filters.status', 'published')
        );
});

test('admin banner table defaults to the global sequence order', function () {
    $admin = bannerAdminUser();
    $lastBanner = Banner::factory()->published()->create(['sequence' => 2]);
    $firstBanner = Banner::factory()->create(['sequence' => 0]);
    $middleBanner = Banner::factory()->published()->create(['sequence' => 1]);

    $this->actingAs($admin)
        ->get(route('admin.banners.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('banners.data.0.id', $firstBanner->id)
            ->where('banners.data.1.id', $middleBanner->id)
            ->where('banners.data.2.id', $lastBanner->id)
            ->where('bannerOrder', [$firstBanner->id, $middleBanner->id, $lastBanner->id])
        );
});

test('published banners continue to feed the homepage carousel', function () {
    Storage::fake('public');
    Storage::disk('public')->put('images/banners/home/homepage banner.jpg', 'banner');
    Storage::disk('public')->put('images/banners/home/priority banner.jpg', 'banner');

    Banner::factory()->published()->create([
        'photo' => 'homepage banner.jpg',
        'title' => 'Homepage Banner',
        'content' => '<p>Featured campus update.</p>',
        'link' => 'https://nemsu.edu.ph',
        'sequence' => 2,
        'created_at' => now()->subMinute(),
    ]);
    Banner::factory()->published()->create([
        'photo' => 'priority banner.jpg',
        'title' => 'Priority Banner',
        'content' => '<p>Shown before the other banner.</p>',
        'sequence' => 1,
        'created_at' => now()->subMinutes(2),
    ]);
    Banner::factory()->published()->create([
        'photo' => 'missing banner.jpg',
        'title' => 'Missing Banner',
        'content' => '<p>This banner has no local file.</p>',
        'sequence' => 0,
        'created_at' => now(),
    ]);
    Banner::factory()->create([
        'photo' => 'draft.jpg',
        'title' => 'Draft Banner',
        'is_published' => false,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('banners', 2)
            ->where('banners.0.title', 'Priority Banner')
            ->where('banners.1.title', 'Homepage Banner')
            ->where('banners.1.summary', 'Featured campus update.')
            ->where('banners.1.imageUrl', '/storage/images/banners/home/homepage%20banner.jpg')
            ->where('banners.1.link', 'https://nemsu.edu.ph')
        );
});
