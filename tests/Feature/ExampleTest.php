<?php

use App\Models\BacMatter;
use App\Models\Banner;
use App\Models\JobOpportunity;
use App\Models\News;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

function newsContentImageUrl(string $filename): string
{
    return Storage::disk('public')->url('images/content/news/'.rawurlencode($filename));
}

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('jobOpportunities', 0)
            ->has('bacDocuments', 0)
        );
});

test('home page includes the six latest published active job opportunities', function () {
    $publishedAt = Carbon::parse('2026-06-01 09:00:00');

    $eligibleJobs = collect(range(0, 6))->map(
        fn (int $index): JobOpportunity => JobOpportunity::factory()
            ->published()
            ->hiring()
            ->create([
                'name' => $index === 0
                    ? '<strong>Registrar&nbsp;Assistant</strong>'
                    : "Job Opportunity {$index}",
                'content' => $index === 0
                    ? '<p>Submit&nbsp;<strong>now</strong>.</p>'
                    : "<p>Details {$index}</p>",
                'date' => $publishedAt->copy()->subDays($index),
            ]),
    );

    JobOpportunity::factory()->hiring()->create([
        'name' => 'Newer Draft Opportunity',
        'date' => $publishedAt->copy()->addDays(2),
    ]);

    JobOpportunity::factory()->published()->create([
        'name' => 'Newer Closed Opportunity',
        'date' => $publishedAt->copy()->addDay(),
    ]);

    $response = $this->get(route('home'))->assertOk();
    $jobs = $response->inertiaProps('jobOpportunities');

    expect($jobs)
        ->toHaveCount(6)
        ->and(collect($jobs)->pluck('id')->all())
        ->toBe($eligibleJobs->take(6)->pluck('id')->all())
        ->and($jobs[0])
        ->toBe([
            'id' => $eligibleJobs[0]->id,
            'position' => 'Registrar Assistant',
            'details' => 'Submit now.',
            'postedAt' => 'Jun 1, 2026',
            'isHiring' => true,
        ])
        ->and(collect($jobs)->pluck('position')->all())
        ->not->toContain(
            'Job Opportunity 6',
            'Newer Draft Opportunity',
            'Newer Closed Opportunity',
        );
});

test('home page includes the five latest published BAC documents', function () {
    $publishedAt = Carbon::parse('2026-05-25 14:30:00');

    $localDocument = BacMatter::factory()->published()->create([
        'name' => '<strong>Digital&nbsp;Printing Equipment</strong>',
        'file' => 'bac-matters/digital-printing.pdf',
        'link' => 'https://example.com/ignored-link',
        'type' => 'ITB',
        'date' => $publishedAt,
    ]);

    $absoluteDocument = BacMatter::factory()->published()->create([
        'name' => 'Medical Equipment',
        'file' => null,
        'link' => 'https://drive.google.com/document/example',
        'type' => 'RFQ',
        'date' => $publishedAt->copy()->subDay(),
    ]);

    $rootRelativeDocument = BacMatter::factory()->published()->create([
        'name' => 'Campus Repairs',
        'file' => null,
        'link' => '/files/BAC/campus-repairs.pdf',
        'type' => 'NOA',
        'date' => $publishedAt->copy()->subDays(2),
    ]);

    $legacyDocument = BacMatter::factory()->published()->create([
        'name' => 'Legacy Bid File',
        'file' => null,
        'link' => 'legacy bid.pdf',
        'type' => 'Bid Bulletin 2',
        'date' => $publishedAt->copy()->subDays(3),
    ]);

    $documentWithoutDestination = BacMatter::factory()->published()->create([
        'name' => 'Procurement Notice',
        'file' => null,
        'link' => null,
        'type' => null,
        'date' => $publishedAt->copy()->subDays(4),
    ]);

    BacMatter::factory()->published()->create([
        'name' => 'Older Published Document',
        'date' => $publishedAt->copy()->subDays(5),
    ]);

    BacMatter::factory()->create([
        'name' => 'Newer Draft Document',
        'date' => $publishedAt->copy()->addDay(),
    ]);

    $response = $this->get(route('home'))->assertOk();
    $documents = $response->inertiaProps('bacDocuments');

    expect($documents)
        ->toHaveCount(5)
        ->and(collect($documents)->pluck('id')->all())
        ->toBe([
            $localDocument->id,
            $absoluteDocument->id,
            $rootRelativeDocument->id,
            $legacyDocument->id,
            $documentWithoutDestination->id,
        ])
        ->and($documents[0])
        ->toBe([
            'id' => $localDocument->id,
            'title' => 'Digital Printing Equipment',
            'type' => 'Invitation to Bid',
            'postedAt' => 'May 25, 2026',
            'destinationUrl' => Storage::disk('public')->url(
                'bac-matters/digital-printing.pdf',
            ),
        ])
        ->and($documents[1]['destinationUrl'])
        ->toBe('https://drive.google.com/document/example')
        ->and($documents[1]['type'])
        ->toBe('Request for Quotation')
        ->and($documents[2]['destinationUrl'])
        ->toBe('https://nemsu.edu.ph/files/BAC/campus-repairs.pdf')
        ->and($documents[2]['type'])
        ->toBe('Notice of Award')
        ->and($documents[3]['destinationUrl'])
        ->toBe('https://nemsu.edu.ph/files/BAC/legacy%20bid.pdf')
        ->and($documents[3]['type'])
        ->toBe('Bid Bulletin')
        ->and($documents[4]['destinationUrl'])
        ->toBeNull()
        ->and($documents[4]['type'])
        ->toBe('BAC Notice')
        ->and(collect($documents)->pluck('title')->all())
        ->not->toContain('Older Published Document', 'Newer Draft Document');
});

test('home page includes latest published press releases', function () {
    News::create([
        'id' => (string) Str::uuid(),
        'title' => 'Published press release',
        'slug' => 'published-press-release',
        'short_description' => 'A visible public update.',
        'content' => 'Full public update.',
        'photo' => 'https://nemsu.edu.ph/files/News/legacy%20absolute.jpg',
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
            ->where('pressReleases.0.photoUrl', newsContentImageUrl('legacy absolute.jpg'))
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
            ->where('banners.0.imageUrl', '/storage/images/banners/home/top%203.jpg')
            ->where('banners.0.link', 'https://nemsu.edu.ph')
        );
});

test('home page keeps latest news preview focused on five records', function () {
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
            ->has('pressReleases', 5)
            ->where('pressReleases.0.title', 'Published update 1')
            ->where('pressReleases.4.title', 'Published update 5')
        );

    expect(collect($response->inertiaProps('pressReleases'))->pluck('title')->all())
        ->not->toContain('Published update 6');
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
            ->where('featuredNews.photoUrl', newsContentImageUrl('featured story.jpg'))
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
        'photo' => "story.jpg\r\n",
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
            ->where('article.photoUrl', newsContentImageUrl('story.jpg'))
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
