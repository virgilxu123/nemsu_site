<?php

use App\Models\News;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

test('admin news edit resolves legacy and managed photo urls', function () {
    $admin = newsAdminUser();
    $legacyNews = News::factory()->create([
        'photo' => 'https://www.nemsu.edu.ph/files/News/admin%20legacy.jpg',
    ]);
    $managedNews = News::factory()->create([
        'photo' => 'news/photos/example.jpg',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.news.edit', $legacyNews))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('newsItem.photo_url', Storage::disk('public')->url('images/content/news/'.rawurlencode('admin legacy.jpg')))
        );

    $this->actingAs($admin)
        ->get(route('admin.news.edit', $managedNews))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('newsItem.photo_url', Storage::disk('public')->url('news/photos/example.jpg'))
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

test('admins can upload a lead photo and inline content images', function () {
    Storage::fake('public');
    $admin = newsAdminUser();
    $uploadId = (string) Str::uuid();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), newsPayload([
            'content' => '<p>Story body.</p><img src="blob:preview" data-upload-id="'.$uploadId.'" alt="Campus laboratory" onerror="bad()">',
            'photo_upload' => UploadedFile::fake()->image('lead.webp'),
            'content_images' => [
                $uploadId => UploadedFile::fake()->image('laboratory.png'),
            ],
        ]))
        ->assertSessionHasNoErrors();

    $news = News::query()->firstOrFail();
    $contentPath = str($news->content)->match('#/storage/(news/content/[^" ]+)#')->toString();

    expect($news->photo)->toStartWith('news/photos/')
        ->and($news->content)->toContain('<img')
        ->and($news->content)->toContain('alt="Campus laboratory"')
        ->and($news->content)->not->toContain('data-upload-id')
        ->and($news->content)->not->toContain('onerror');

    Storage::disk('public')->assertExists($news->photo);
    Storage::disk('public')->assertExists($contentPath);
});

test('news image uploads validate type and size', function () {
    Storage::fake('public');
    $admin = newsAdminUser();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), newsPayload([
            'photo_upload' => UploadedFile::fake()->create('lead.gif', 100, 'image/gif'),
        ]))
        ->assertSessionHasErrors('photo_upload');

    $this->actingAs($admin)
        ->post(route('admin.news.store'), newsPayload([
            'photo_upload' => UploadedFile::fake()->image('lead.jpg')->size(5121),
        ]))
        ->assertSessionHasErrors('photo_upload');
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

test('updating news preserves legacy photos and replaces managed uploads', function () {
    Storage::fake('public');
    $admin = newsAdminUser();
    $legacyNews = News::factory()->create(['photo' => 'legacy-photo.jpg']);

    $this->actingAs($admin)
        ->patch(route('admin.news.update', $legacyNews), newsPayload([
            'slug' => $legacyNews->slug,
        ]))
        ->assertSessionHasNoErrors();

    expect($legacyNews->refresh()->photo)->toBe('legacy-photo.jpg');

    $managedNews = News::factory()->create(['photo' => 'news/photos/original.jpg']);
    Storage::disk('public')->put($managedNews->photo, 'original');

    $this->actingAs($admin)
        ->patch(route('admin.news.update', $managedNews), newsPayload([
            'slug' => $managedNews->slug,
            'photo_upload' => UploadedFile::fake()->image('replacement.png'),
        ]))
        ->assertSessionHasNoErrors();

    $replacementPhoto = $managedNews->refresh()->photo;

    Storage::disk('public')->assertMissing('news/photos/original.jpg');
    Storage::disk('public')->assertExists($replacementPhoto);
});

test('removing news images deletes only managed uploads', function () {
    Storage::fake('public');
    $admin = newsAdminUser();
    Storage::disk('public')->put('news/photos/remove.jpg', 'photo');
    Storage::disk('public')->put('news/content/remove.jpg', 'content');
    $news = News::factory()->create([
        'photo' => 'news/photos/remove.jpg',
        'content' => '<p>Body</p><img src="/storage/news/content/remove.jpg" alt="Remove">',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.news.update', $news), newsPayload([
            'slug' => $news->slug,
            'content' => '<p>Body without image</p>',
            'remove_photo' => '1',
        ]))
        ->assertSessionHasNoErrors();

    expect($news->refresh()->photo)->toBeNull();
    Storage::disk('public')->assertMissing('news/photos/remove.jpg');
    Storage::disk('public')->assertMissing('news/content/remove.jpg');
});

test('admins can delete news', function () {
    Storage::fake('public');
    $admin = newsAdminUser();
    Storage::disk('public')->put('news/photos/delete.jpg', 'photo');
    Storage::disk('public')->put('news/content/delete.jpg', 'content');
    $news = News::factory()->create([
        'photo' => 'news/photos/delete.jpg',
        'content' => '<p>Body</p><img src="/storage/news/content/delete.jpg">',
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.news.destroy', $news))
        ->assertRedirect(route('admin.news.index'));

    $this->assertModelMissing($news);
    Storage::disk('public')->assertMissing('news/photos/delete.jpg');
    Storage::disk('public')->assertMissing('news/content/delete.jpg');
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
