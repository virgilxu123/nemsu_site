<?php

use App\Models\Banner;
use App\Models\News;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('home page includes latest published press releases', function () {
    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Published press release',
        'slug' => 'published-press-release',
        'short_description' => 'A visible public update.',
        'content' => 'Full public update.',
        'author' => 'Public Information Office',
        'type' => 'news',
        'is_published' => true,
        'date' => now(),
    ]);

    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Draft press release',
        'slug' => 'draft-press-release',
        'content' => 'Hidden public update.',
        'type' => 'news',
        'is_published' => false,
        'date' => now()->addMinute(),
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('pressReleases', 1)
            ->where('pressReleases.0.title', 'Published press release')
            ->where('pressReleases.0.type', 'Press Release')
            ->where('pressReleases.0.office', 'Public Information Office')
        );
});

test('home page includes published banners for the hero carousel', function () {
    Banner::create([
        'photo' => 'top 3.jpg',
        'title' => 'Topnotcher Celebration',
        'content' => '<p>NEMSU celebrates another milestone.</p>',
        'link' => 'https://nemsu.edu.ph',
        'is_published' => true,
        'created_at' => now(),
    ]);

    Banner::create([
        'photo' => 'draft-banner.jpg',
        'title' => 'Hidden Banner',
        'is_published' => false,
        'created_at' => now()->addMinute(),
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('banners', 1)
            ->where('banners.0.title', 'Topnotcher Celebration')
            ->where('banners.0.summary', 'NEMSU celebrates another milestone.')
            ->where('banners.0.imageUrl', 'https://nemsu.edu.ph/files/Banner/top%203.jpg')
            ->where('banners.0.link', 'https://nemsu.edu.ph')
        );
});

test('home page keeps latest news preview focused', function () {
    $publishedAt = now();

    foreach (range(1, 7) as $index) {
        News::create([
            'id' => (string) Str::uuid(),
            'title' => "Published update {$index}",
            'slug' => "published-update-{$index}",
            'short_description' => "Visible update {$index}.",
            'content' => "Full update {$index}.",
            'author' => 'Public Information Office',
            'type' => 'news',
            'is_published' => true,
            'date' => $publishedAt->copy()->subMinutes($index),
        ]);
    }

    $response = $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('pressReleases', 3)
            ->where('pressReleases.0.title', 'Published update 1')
            ->where('pressReleases.2.title', 'Published update 3')
        );

    expect(collect($response->inertiaProps('pressReleases'))->pluck('title')->all())
        ->not->toContain('Published update 4');
});

test('home page includes latest published announcements separately from press releases', function () {
    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Enrollment schedule released',
        'slug' => 'enrollment-schedule-released',
        'short_description' => 'Please review the enrollment schedule for the coming term.',
        'content' => 'Full announcement.',
        'author' => 'Registrar Office',
        'type' => 'announcement',
        'is_published' => true,
        'date' => now(),
    ]);

    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Draft student advisory',
        'slug' => 'draft-student-advisory',
        'content' => 'Hidden announcement.',
        'type' => 'announcement',
        'is_published' => false,
        'date' => now()->addMinute(),
    ]);

    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Regular press release',
        'slug' => 'regular-press-release',
        'content' => 'Visible press release.',
        'type' => 'news',
        'is_published' => true,
        'date' => now()->subMinute(),
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('announcements', 1)
            ->where('announcements.0.title', 'Enrollment schedule released')
            ->where('announcements.0.type', 'Announcement')
            ->where('announcements.0.office', 'Registrar Office')
            ->has('pressReleases', 1)
            ->where('pressReleases.0.title', 'Regular press release')
        );
});

test('public news ticker shares five latest published announcements and press releases', function () {
    $publishedAt = now();

    foreach (range(1, 6) as $index) {
        News::factory()->create([
            'title' => "Ticker update {$index}",
            'slug' => "ticker-update-{$index}",
            'type' => $index % 2 === 0 ? 'news' : 'announcement',
            'is_published' => true,
            'date' => $publishedAt->copy()->subMinutes($index),
        ]);
    }

    News::factory()->create([
        'title' => 'Draft ticker update',
        'slug' => 'draft-ticker-update',
        'type' => 'announcement',
        'is_published' => false,
        'date' => $publishedAt->copy()->addMinute(),
    ]);

    $response = $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('publicNewsTicker', 5)
            ->where('publicNewsTicker.0.title', 'Ticker update 1')
            ->where('publicNewsTicker.0.type', 'Announcement')
            ->where('publicNewsTicker.1.title', 'Ticker update 2')
            ->where('publicNewsTicker.1.type', 'Press Release')
        );

    expect(collect($response->inertiaProps('publicNewsTicker'))->pluck('title')->all())
        ->toBe([
            'Ticker update 1',
            'Ticker update 2',
            'Ticker update 3',
            'Ticker update 4',
            'Ticker update 5',
        ])
        ->not->toContain('Ticker update 6', 'Draft ticker update');
});

test('news index page can be browsed', function () {
    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Featured newsroom story',
        'slug' => 'featured-newsroom-story',
        'short_description' => 'A highlighted public update.',
        'content' => 'Full highlighted update.',
        'author' => 'Public Information Office',
        'type' => 'news',
        'is_published' => true,
        'featured' => true,
        'date' => now(),
    ]);

    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Regular newsroom story',
        'slug' => 'regular-newsroom-story',
        'short_description' => 'A regular public update.',
        'content' => 'Full regular update.',
        'author' => 'Public Information Office',
        'type' => 'news',
        'is_published' => true,
        'featured' => false,
        'date' => now()->subDay(),
    ]);

    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Draft newsroom story',
        'slug' => 'draft-newsroom-story',
        'content' => 'Hidden update.',
        'type' => 'news',
        'is_published' => false,
        'date' => now()->addDay(),
    ]);

    $this->get(route('news.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('news/Index')
            ->where('featuredNews.title', 'Featured newsroom story')
            ->has('news.data', 1)
            ->where('news.data.0.title', 'Regular newsroom story')
            ->has('news.links')
        );
});

test('home page normalizes legacy press release typography', function () {
    News::create([
        'id' => (string) Str::uuid(),
        'title' => "\u{1D406}\u{1D425}\u{1D428}\u{1D41B}\u{1D41A}\u{1D425} Connections",
        'slug' => 'global-connections',
        'short_description' => '<p>Official&nbsp;update with legacy spacing.</p>',
        'content' => 'Full public update.',
        'author' => 'Public&nbsp;Information Office',
        'type' => 'news',
        'is_published' => true,
        'date' => now(),
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->where('pressReleases.0.title', 'Global Connections')
            ->where('pressReleases.0.excerpt', 'Official update with legacy spacing.')
            ->where('pressReleases.0.office', 'Public Information Office')
        );
});

test('home page includes featured news separately from press releases', function () {
    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Featured university story',
        'slug' => 'featured-university-story',
        'short_description' => 'A highlighted public update.',
        'content' => 'Full highlighted update.',
        'photo' => 'featured story.jpg',
        'author' => 'Public Information Office',
        'type' => 'news',
        'is_published' => true,
        'featured' => true,
        'date' => now()->subDay(),
    ]);

    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Regular university story',
        'slug' => 'regular-university-story',
        'short_description' => 'A regular public update.',
        'content' => 'Full public update.',
        'author' => 'Public Information Office',
        'type' => 'news',
        'is_published' => true,
        'featured' => false,
        'date' => now(),
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->where('featuredNews.title', 'Featured university story')
            ->where('featuredNews.photoUrl', 'https://nemsu.edu.ph/files/News/featured%20story.jpg')
            ->has('pressReleases', 1)
            ->where('pressReleases.0.title', 'Regular university story')
        );
});

test('published news article page can be viewed', function () {
    $news = News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Detailed university story',
        'slug' => 'detailed-university-story',
        'short_description' => 'A public article summary.',
        'content' => '<p>Full public article.</p><script>alert("x")</script><img src="/public_files/images/story.jpg" onerror="alert(1)">',
        'photo' => 'story.jpg',
        'author' => 'Public Information Office',
        'type' => 'news',
        'is_published' => true,
        'date' => now(),
    ]);

    $response = $this->get(route('news.show', $news->slug))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('news/Show')
            ->where('article.title', 'Detailed university story')
            ->where('article.slug', 'detailed-university-story')
            ->where('article.photoUrl', 'https://nemsu.edu.ph/files/News/story.jpg')
            ->has('article.galleryImages', 0)
            ->has('latestNews')
        );

    expect($response->inertiaProps('article.contentHtml'))
        ->toContain('Full public article.')
        ->toContain('<img')
        ->toContain('https://nemsu.edu.ph/public_files/images/story.jpg')
        ->not->toContain('<script')
        ->not->toContain('onerror');
});

test('draft news article page is not public', function () {
    $news = News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Hidden university story',
        'slug' => 'hidden-university-story',
        'content' => 'Hidden story.',
        'type' => 'news',
        'is_published' => false,
        'date' => now(),
    ]);

    $this->get(route('news.show', $news->slug))->assertNotFound();
});

test('published announcement article page can be viewed', function () {
    $announcement = News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Campus enrollment advisory',
        'slug' => 'campus-enrollment-advisory',
        'short_description' => 'Enrollment steps and reminders for students.',
        'content' => '<p>Bring the required documents.</p>',
        'author' => 'Registrar Office',
        'type' => 'announcement',
        'is_published' => true,
        'date' => now(),
    ]);

    $this->get(route('news.show', $announcement->slug))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('news/Show')
            ->where('article.title', 'Campus enrollment advisory')
            ->where('article.type', 'Announcement')
            ->where('article.office', 'Registrar Office')
        );
});
