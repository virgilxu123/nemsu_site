<?php

use App\Models\ContentPage;
use App\Models\MediaAsset;
use App\Models\NavigationItem;
use App\Models\News;
use App\Models\Program;
use App\Models\SiteMetric;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

test('legacy and cms content tables exist', function () {
    $tables = [
        'announcements',
        'bac_matters',
        'banners',
        'campuses',
        'colleges',
        'departments',
        'downloadable_files',
        'events',
        'galleries',
        'gallery_photos',
        'job_opportunities',
        'news',
        'news_views',
        'offices',
        'programs',
        'content_pages',
        'navigation_items',
        'office_profiles',
        'program_details',
        'campus_profiles',
        'media_assets',
        'site_metrics',
    ];

    foreach ($tables as $table) {
        expect(Schema::hasTable($table))->toBeTrue("Expected [{$table}] table to exist.");
    }
});

test('representative columns and indexes exist', function () {
    expect(Schema::hasColumns('news', ['slug', 'type', 'featured']))->toBeTrue();
    expect(Schema::hasIndex('news', ['slug'], 'unique'))->toBeTrue();
    expect(Schema::hasIndex('news', ['type']))->toBeTrue();
    expect(Schema::hasIndex('news', ['featured']))->toBeTrue();

    expect(Schema::hasColumn('programs', 'campus_id'))->toBeTrue();
    expect(Schema::hasIndex('programs', ['campus_id']))->toBeTrue();

    expect(Schema::hasColumn('content_pages', 'slug'))->toBeTrue();
    expect(Schema::hasIndex('content_pages', ['slug'], 'unique'))->toBeTrue();

    expect(Schema::hasColumn('navigation_items', 'parent_id'))->toBeTrue();
    expect(Schema::hasIndex('navigation_items', ['parent_id']))->toBeTrue();

    expect(Schema::hasColumn('media_assets', 'path'))->toBeTrue();
    expect(Schema::hasIndex('media_assets', ['path']))->toBeTrue();
});

test('representative content models support fillable fields and casts', function () {
    $news = News::create([
        'id' => (string) Str::uuid(),
        'title' => 'NEMSU Launches New Website',
        'slug' => 'nemsu-launches-new-website',
        'content' => 'Launch story',
        'type' => 'announcement',
        'is_published' => 1,
        'featured' => 1,
        'date' => '2026-05-25 08:00:00',
    ]);

    expect($news->date)->toBeInstanceOf(Carbon::class);
    expect($news->is_published)->toBeTrue();
    expect($news->featured)->toBeTrue();

    $program = Program::create([
        'name' => 'Bachelor of Science in Information Technology',
        'campus_id' => (string) Str::uuid(),
        'is_archived' => 1,
    ]);

    expect($program->degree_program)->toBe('baccalaureate');
    expect($program->is_archived)->toBeTrue();

    $page = ContentPage::create([
        'slug' => 'vision-and-mission',
        'title' => 'Vision and Mission',
        'is_published' => 1,
        'published_at' => '2026-05-25 09:00:00',
    ]);

    expect($page->getKey())->toBeString()->not->toBeEmpty();
    expect($page->status)->toBe('draft');
    expect($page->published_at)->toBeInstanceOf(Carbon::class);
    expect($page->is_published)->toBeTrue();

    $navigationItem = NavigationItem::create([
        'location' => 'main',
        'label' => 'About Us',
    ]);

    expect($navigationItem->getKey())->toBeString()->not->toBeEmpty();
    expect($navigationItem->is_active)->toBeTrue();

    $mediaAsset = MediaAsset::create([
        'path' => 'public_files/images/banner.jpg',
        'metadata' => ['legacy' => true],
    ]);

    expect($mediaAsset->disk)->toBe('public');
    expect($mediaAsset->metadata)->toBe(['legacy' => true]);
    expect($mediaAsset->is_published)->toBeTrue();

    $siteMetric = SiteMetric::create([
        'label' => 'Student Population',
        'value' => '12000',
        'is_published' => 1,
    ]);

    expect($siteMetric->scope)->toBe('system');
    expect($siteMetric->is_published)->toBeTrue();
});
