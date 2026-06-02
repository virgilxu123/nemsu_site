<?php

use App\Models\News;
use App\Models\User;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

function newsAdminUser(): User
{
    return User::factory()->create([
        'account_type' => 'admin',
    ]);
}

function newsPayload(array $overrides = []): array
{
    return [
        'title' => 'Campus Research Breakthrough',
        'slug' => 'Campus Research Breakthrough',
        'short_description' => 'A concise summary for the newsroom.',
        'content' => '<p onclick="bad()">Research <strong>milestone</strong>.</p><script>alert("bad")</script>',
        'photo' => 'research.jpg',
        'author' => 'Office of Public Affairs',
        'office_id' => null,
        'type' => 'news',
        'is_published' => '1',
        'featured' => '1',
        'date' => '2026-05-30T08:30',
        ...$overrides,
    ];
}

test('guests are redirected to login from admin news', function () {
    $this->get(route('admin.news.index'))
        ->assertRedirect(route('login'));
});

test('non admin users cannot manage news', function () {
    $user = User::factory()->create([
        'account_type' => 'contributor',
    ]);

    $this->actingAs($user)
        ->get(route('admin.news.index'))
        ->assertForbidden();
});

test('admins can view news management pages', function () {
    $admin = newsAdminUser();
    $news = News::factory()->create([
        'title' => 'Campus Research Breakthrough',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.news.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/news/Index')
            ->has('news.data', 1)
            ->where('news.data.0.id', $news->id)
        );

    $this->actingAs($admin)
        ->get(route('admin.news.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('admin/news/Create'));

    $this->actingAs($admin)
        ->get(route('admin.news.edit', $news))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/news/Edit')
            ->where('newsItem.id', $news->id)
        );
});

test('admins can store news with normalized data', function () {
    $admin = newsAdminUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.news.store'), newsPayload());

    $news = News::query()->firstOrFail();

    $response->assertRedirect(route('admin.news.edit', $news));

    expect($news->id)->toBeString()
        ->and(Str::isUuid($news->id))->toBeTrue()
        ->and($news->slug)->toBe('campus-research-breakthrough')
        ->and($news->is_published)->toBeTrue()
        ->and($news->featured)->toBeTrue()
        ->and($news->date?->format('Y-m-d H:i'))->toBe('2026-05-30 08:30')
        ->and($news->content)->toContain('<strong>milestone</strong>')
        ->and($news->content)->not->toContain('<script')
        ->and($news->content)->not->toContain('onclick');
});

test('admins can update news while keeping the current slug valid', function () {
    $admin = newsAdminUser();
    $news = News::factory()->create([
        'slug' => 'campus-research-breakthrough',
    ]);
    $otherNews = News::factory()->create([
        'slug' => 'alumni-homecoming',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.news.update', $news), newsPayload([
            'title' => 'Updated Research Story',
            'slug' => 'campus-research-breakthrough',
            'is_published' => '0',
            'featured' => '0',
        ]))
        ->assertRedirect(route('admin.news.edit', $news));

    expect($news->refresh()->title)->toBe('Updated Research Story')
        ->and($news->is_published)->toBeFalse()
        ->and($news->featured)->toBeFalse();

    $this->actingAs($admin)
        ->from(route('admin.news.edit', $news))
        ->patch(route('admin.news.update', $news), newsPayload([
            'slug' => $otherNews->slug,
        ]))
        ->assertRedirect(route('admin.news.edit', $news))
        ->assertSessionHasErrors('slug');
});

test('admins can delete news', function () {
    $admin = newsAdminUser();
    $news = News::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.news.destroy', $news))
        ->assertRedirect(route('admin.news.index'));

    $this->assertModelMissing($news);
});

test('admin news index searches filters and sorts records', function () {
    $admin = newsAdminUser();
    $published = News::factory()->published()->featured()->create([
        'title' => 'Admissions Story',
        'slug' => 'admissions-story',
        'short_description' => 'Admissions update',
        'type' => 'news',
        'date' => now()->subDay(),
    ]);
    News::factory()->draft()->create([
        'title' => 'Maintenance Notice',
        'slug' => 'maintenance-notice',
        'type' => 'announcement',
        'date' => now(),
    ]);

    $this->actingAs($admin)
        ->get(route('admin.news.index', [
            'search' => 'admissions',
            'status' => 'published',
            'type' => 'news',
            'featured' => 'featured',
            'sort_by' => 'date',
            'sort_direction' => 'desc',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('news.data', 1)
            ->where('news.data.0.id', $published->id)
            ->where('filters.status', 'published')
            ->where('filters.type', 'news')
            ->where('filters.featured', 'featured')
        );
});
