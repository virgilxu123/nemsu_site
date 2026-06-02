<?php

use App\Models\ContentPage;
use App\Models\User;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

function contentPageAdminUser(): User
{
    return User::factory()->create([
        'account_type' => 'admin',
    ]);
}

function contentPagePayload(array $overrides = []): array
{
    return [
        'title' => 'Vision and Mission',
        'slug' => 'Vision and Mission',
        'section' => 'about',
        'body' => '<h2>Vision</h2><p onclick="bad()">Static <strong>content</strong>.</p><script>alert("bad")</script>',
        'excerpt' => 'Institutional statement.',
        'status' => 'draft',
        'is_published' => '1',
        'published_at' => '',
        'office_id' => null,
        'campus_id' => null,
        'sort_order' => 10,
        ...$overrides,
    ];
}

test('guests are redirected to login from admin content pages', function () {
    $this->get(route('admin.content-pages.index'))
        ->assertRedirect(route('login'));
});

test('non admin users cannot manage content pages', function () {
    $user = User::factory()->create([
        'account_type' => 'contributor',
    ]);

    $this->actingAs($user)
        ->get(route('admin.content-pages.index'))
        ->assertForbidden();
});

test('admins can view content page management pages', function () {
    $admin = contentPageAdminUser();
    $contentPage = ContentPage::factory()->create([
        'title' => 'Campus History',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.content-pages.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/content-pages/Index')
            ->has('pages.data', 1)
            ->where('pages.data.0.id', $contentPage->id)
        );

    $this->actingAs($admin)
        ->get(route('admin.content-pages.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('admin/content-pages/Create'));

    $this->actingAs($admin)
        ->get(route('admin.content-pages.edit', $contentPage))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/content-pages/Edit')
            ->where('page.id', $contentPage->id)
        );
});

test('admins can store content pages with normalized data', function () {
    $admin = contentPageAdminUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.content-pages.store'), contentPagePayload());

    $contentPage = ContentPage::query()->firstOrFail();

    $response->assertRedirect(route('admin.content-pages.edit', $contentPage));

    expect($contentPage->id)->toBeString()
        ->and(Str::isUuid($contentPage->id))->toBeTrue()
        ->and($contentPage->slug)->toBe('vision-and-mission')
        ->and($contentPage->status)->toBe('published')
        ->and($contentPage->is_published)->toBeTrue()
        ->and($contentPage->published_at)->not->toBeNull()
        ->and($contentPage->body)->toContain('<strong>content</strong>')
        ->and($contentPage->body)->not->toContain('<script')
        ->and($contentPage->body)->not->toContain('onclick');
});

test('admins can update content pages while keeping the current slug valid', function () {
    $admin = contentPageAdminUser();
    $contentPage = ContentPage::factory()->create([
        'slug' => 'vision-and-mission',
    ]);
    $otherPage = ContentPage::factory()->create([
        'slug' => 'campus-history',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.content-pages.update', $contentPage), contentPagePayload([
            'title' => 'Updated Vision',
            'slug' => 'vision-and-mission',
            'is_published' => '0',
        ]))
        ->assertRedirect(route('admin.content-pages.edit', $contentPage));

    expect($contentPage->refresh()->title)->toBe('Updated Vision')
        ->and($contentPage->is_published)->toBeFalse()
        ->and($contentPage->status)->toBe('draft');

    $this->actingAs($admin)
        ->from(route('admin.content-pages.edit', $contentPage))
        ->patch(route('admin.content-pages.update', $contentPage), contentPagePayload([
            'slug' => $otherPage->slug,
        ]))
        ->assertRedirect(route('admin.content-pages.edit', $contentPage))
        ->assertSessionHasErrors('slug');
});

test('admins can delete content pages', function () {
    $admin = contentPageAdminUser();
    $contentPage = ContentPage::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.content-pages.destroy', $contentPage))
        ->assertRedirect(route('admin.content-pages.index'));

    $this->assertModelMissing($contentPage);
});

test('admin content page index searches filters and sorts records', function () {
    $admin = contentPageAdminUser();
    $published = ContentPage::factory()->published()->create([
        'title' => 'Admissions Guide',
        'slug' => 'admissions-guide',
        'section' => 'admissions',
        'sort_order' => 2,
    ]);
    ContentPage::factory()->draft()->create([
        'title' => 'Research Agenda',
        'slug' => 'research-agenda',
        'section' => 'research',
        'sort_order' => 1,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.content-pages.index', [
            'search' => 'admissions',
            'status' => 'published',
            'section' => 'admissions',
            'sort_by' => 'sort_order',
            'sort_direction' => 'asc',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('pages.data', 1)
            ->where('pages.data.0.id', $published->id)
            ->where('filters.status', 'published')
            ->where('filters.section', 'admissions')
        );
});
