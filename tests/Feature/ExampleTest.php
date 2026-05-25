<?php

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
            ->has('latestNews')
        );

    expect($response->inertiaProps('article.contentHtml'))
        ->toContain('Full public article.')
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
