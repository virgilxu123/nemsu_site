<?php

use App\Models\ContentPage;
use App\Models\News;
use Inertia\Testing\AssertableInertia as Assert;

test('sitemap lists indexable pages and excludes unpublished content', function () {
    $publishedNews = News::factory()->published()->create([
        'slug' => 'published-university-update',
    ]);
    $draftNews = News::factory()->draft()->create([
        'slug' => 'draft-university-update',
    ]);
    $publishedPage = ContentPage::factory()->published()->create([
        'slug' => 'public-information-page',
    ]);
    $draftPage = ContentPage::factory()->draft()->create([
        'slug' => 'draft-information-page',
    ]);

    $this->get(route('sitemap'))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
        ->assertSee(route('home'), false)
        ->assertSee(route('news.show', $publishedNews), false)
        ->assertSee(route('content-pages.show', $publishedPage), false)
        ->assertDontSee(route('news.show', $draftNews), false)
        ->assertDontSee(route('content-pages.show', $draftPage), false);
});

test('robots file advertises the production sitemap', function () {
    expect(file_get_contents(public_path('robots.txt')))
        ->toContain('Sitemap: https://nemsu.edu.ph/sitemap.xml');
});

test('public pages expose complete metadata and search verification', function () {
    config()->set('seo.google_site_verification', 'verification-token');

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('seo.title', 'North Eastern Mindanao State University')
            ->where('seo.canonical', route('home'))
            ->where('seo.robots', 'index, follow')
            ->where('seo.googleSiteVerification', 'verification-token')
            ->where('seo.schema.0.@type', 'CollegeOrUniversity')
            ->where('seo.schema.0.address.addressLocality', 'Tandag City')
            ->where('seo.schema.0.contactPoint.contactType', 'University information')
            ->where('seo.schema.0.sameAs.0', 'https://www.facebook.com/nemsuofficialph')
            ->where('seo.schema.1.@type', 'WebSite')
            ->where('seo.schema.2.@type', 'WebPage')
        )
        ->assertSee('name="description"', false)
        ->assertSee('property="og:title"', false)
        ->assertSee('rel="canonical"', false)
        ->assertSee('application/ld+json', false);
});

test('news articles expose news schema canonical metadata and optimized inline images', function () {
    $news = News::factory()->published()->create([
        'title' => 'NEMSU Opens Marine Research Center',
        'slug' => 'nemsu-opens-marine-research-center',
        'short_description' => 'A new center advances coastal and marine research.',
        'author' => 'Public Information Office',
        'content' => '<p>Story body.</p><img src="/storage/news/content/research.jpg" alt="Marine researchers">',
        'photo' => '/storage/news/photos/research.jpg',
        'type' => 'news',
    ]);

    $this->get(route('news.show', $news))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('seo.canonical', route('news.show', $news))
            ->where('seo.type', 'article')
            ->where('seo.schema.2.@type', 'NewsArticle')
            ->where('seo.schema.2.headline', 'NEMSU Opens Marine Research Center')
            ->where('seo.schema.2.articleSection', 'Press Release')
            ->where('seo.schema.3.@type', 'BreadcrumbList')
            ->where('article.contentHtml', fn (string $html): bool => str_contains($html, 'loading="lazy"')
                && str_contains($html, 'decoding="async"')
                && str_contains($html, 'alt="Marine researchers"'))
        );
});

test('crawler guidance files expose discovery links and performance directives', function () {
    $llms = file_get_contents(public_path('llms.txt'));
    $apacheConfiguration = file_get_contents(public_path('.htaccess'));

    expect($llms)
        ->toContain('# North Eastern Mindanao State University')
        ->toContain('https://nemsu.edu.ph/sitemap.xml')
        ->toContain('https://nemsu.edu.ph/about/university')
        ->and($apacheConfiguration)
        ->toContain('BROTLI_COMPRESS')
        ->toContain('DEFLATE')
        ->toContain('ExpiresActive On');
});

test('newsroom category filters separate press releases and announcements', function () {
    $pressRelease = News::factory()->published()->create([
        'slug' => 'press-release-story',
        'type' => 'news',
    ]);
    $announcement = News::factory()->published()->create([
        'slug' => 'announcement-story',
        'type' => 'announcement',
    ]);

    $this->get(route('news.index', ['category' => 'announcements']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('activeCategory', 'announcements')
            ->has('categories', 3)
            ->has('news.data', 1)
            ->where('news.data.0.id', $announcement->id)
            ->where('news.data.0.type', 'Announcement')
            ->where('news.data', fn ($items): bool => collect($items)->doesntContain('id', $pressRelease->id))
        );
});
