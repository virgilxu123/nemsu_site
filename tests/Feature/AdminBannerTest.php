<?php

use App\Models\Banner;
use App\Models\User;
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
});

test('non admin users cannot manage banners', function () {
    $user = User::factory()->create([
        'account_type' => 'contributor',
    ]);

    $this->actingAs($user)
        ->get(route('admin.banners.index'))
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
            ->where('banners.data.0.id', $banner->id)
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

    $response = $this->actingAs($admin)
        ->post(route('admin.banners.store'), bannerPayload([
            'photo' => ' campus banner.jpg ',
            'title' => ' Enrollment Now Open ',
            'link' => ' https://nemsu.edu.ph/admissions ',
        ]));

    $banner = Banner::query()->firstOrFail();

    $response->assertRedirect(route('admin.banners.edit', $banner));

    expect($banner->photo)->toBe('campus banner.jpg')
        ->and($banner->title)->toBe('Enrollment Now Open')
        ->and($banner->link)->toBe('https://nemsu.edu.ph/admissions')
        ->and($banner->is_published)->toBeTrue();
});

test('admins can update and delete banners', function () {
    $admin = bannerAdminUser();
    $banner = Banner::factory()->create([
        'title' => 'Old Banner',
        'is_published' => true,
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.banners.update', $banner), bannerPayload([
            'title' => 'Updated Banner',
            'is_published' => '0',
        ]))
        ->assertRedirect(route('admin.banners.edit', $banner));

    expect($banner->refresh()->title)->toBe('Updated Banner')
        ->and($banner->is_published)->toBeFalse();

    $this->actingAs($admin)
        ->delete(route('admin.banners.destroy', $banner))
        ->assertRedirect(route('admin.banners.index'));

    $this->assertModelMissing($banner);
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
            ->where('banners.data.0.id', $published->id)
            ->where('filters.search', 'admissions')
            ->where('filters.status', 'published')
        );
});

test('published banners continue to feed the homepage carousel', function () {
    Banner::factory()->published()->create([
        'photo' => 'homepage banner.jpg',
        'title' => 'Homepage Banner',
        'content' => '<p>Featured campus update.</p>',
        'link' => 'https://nemsu.edu.ph',
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
            ->has('banners', 1)
            ->where('banners.0.title', 'Homepage Banner')
            ->where('banners.0.summary', 'Featured campus update.')
            ->where('banners.0.imageUrl', 'https://nemsu.edu.ph/files/Banner/homepage%20banner.jpg')
            ->where('banners.0.link', 'https://nemsu.edu.ph')
        );
});
