<?php

use App\Models\News;
use App\Models\User;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

function announcementAdminUser(): User
{
    return User::factory()->create([
        'account_type' => 'admin',
    ]);
}

function announcementPayload(array $overrides = []): array
{
    return [
        'title' => 'Enrollment Schedule Advisory',
        'slug' => 'Enrollment Schedule Advisory',
        'short_description' => 'Important enrollment dates for students.',
        'content' => '<p>Please follow the published enrollment window.</p>',
        'photo' => null,
        'author' => 'Registrar Office',
        'office_id' => null,
        'type' => 'news',
        'is_published' => '1',
        'featured' => '0',
        'date' => '2026-06-15T09:00',
        ...$overrides,
    ];
}

test('guests are redirected to login from admin announcements', function () {
    $this->get(route('admin.announcements.index'))
        ->assertRedirect(route('login'));
});

test('admins can view announcement management pages', function () {
    $admin = announcementAdminUser();
    $announcement = News::factory()->create([
        'title' => 'Enrollment Schedule Advisory',
        'type' => 'announcement',
    ]);
    News::factory()->create([
        'title' => 'Regular News Story',
        'type' => 'news',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.announcements.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/news/Index')
            ->where('contentKind', 'announcement')
            ->has('news.data', 1)
            ->where('news.data.0.id', $announcement->id)
        );

    $this->actingAs($admin)
        ->get(route('admin.announcements.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/news/Create')
            ->where('contentKind', 'announcement')
        );

    $this->actingAs($admin)
        ->get(route('admin.announcements.edit', $announcement))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/news/Edit')
            ->where('contentKind', 'announcement')
            ->where('newsItem.id', $announcement->id)
            ->where('newsItem.type', 'announcement')
        );
});

test('admins can store announcements with announcement type enforced', function () {
    $admin = announcementAdminUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.announcements.store'), announcementPayload());

    $announcement = News::query()->firstOrFail();

    $response->assertRedirect(route('admin.announcements.edit', $announcement));

    expect($announcement->id)->toBeString()
        ->and(Str::isUuid($announcement->id))->toBeTrue()
        ->and($announcement->slug)->toBe('enrollment-schedule-advisory')
        ->and($announcement->type)->toBe('announcement')
        ->and($announcement->is_published)->toBeTrue()
        ->and($announcement->date?->format('Y-m-d H:i'))->toBe('2026-06-15 09:00');
});

test('admins can update announcements without changing them to news', function () {
    $admin = announcementAdminUser();
    $announcement = News::factory()->create([
        'slug' => 'enrollment-schedule-advisory',
        'type' => 'announcement',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.announcements.update', $announcement), announcementPayload([
            'title' => 'Updated Enrollment Advisory',
            'slug' => 'enrollment-schedule-advisory',
            'type' => 'news',
            'is_published' => '0',
        ]))
        ->assertRedirect(route('admin.announcements.edit', $announcement));

    expect($announcement->refresh()->title)->toBe('Updated Enrollment Advisory')
        ->and($announcement->type)->toBe('announcement')
        ->and($announcement->is_published)->toBeFalse();
});

test('admin announcement routes do not expose news records', function () {
    $admin = announcementAdminUser();
    $news = News::factory()->create([
        'type' => 'news',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.announcements.edit', $news))
        ->assertNotFound();

    $this->actingAs($admin)
        ->delete(route('admin.announcements.destroy', $news))
        ->assertNotFound();
});

test('public announcement index lists published announcements only', function () {
    News::factory()->create([
        'title' => 'Published Enrollment Advisory',
        'slug' => 'published-enrollment-advisory',
        'type' => 'announcement',
        'is_published' => true,
        'date' => now(),
    ]);
    News::factory()->create([
        'title' => 'Draft Enrollment Advisory',
        'slug' => 'draft-enrollment-advisory',
        'type' => 'announcement',
        'is_published' => false,
        'date' => now()->addMinute(),
    ]);
    News::factory()->create([
        'title' => 'Published Press Release',
        'slug' => 'published-press-release',
        'type' => 'news',
        'is_published' => true,
        'date' => now()->addMinutes(2),
    ]);

    $this->get(route('announcements.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('announcements/Index')
            ->has('announcements.data', 1)
            ->where('announcements.data.0.title', 'Published Enrollment Advisory')
            ->where('announcements.data.0.type', 'Announcement')
        );
});
