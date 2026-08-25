<?php

use App\Models\News;
use App\Models\Office;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;

test('office of the president page only displays news assigned to the president office', function () {
    $presidentOfficeById = Office::query()->forceCreate([
        'id' => 17,
        'code' => 'OP-ID',
        'name' => 'Office matched by ID',
        'slug' => 'office-matched-by-id',
        'campus_id' => 1,
    ]);
    $presidentOfficeByName = Office::query()->forceCreate([
        'id' => 18,
        'code' => 'OP-NAME',
        'name' => 'President Office',
        'slug' => 'president-office',
        'campus_id' => 1,
    ]);
    $unrelatedOffice = Office::query()->forceCreate([
        'id' => 19,
        'code' => 'OTHER',
        'name' => 'Other Office',
        'slug' => 'other-office',
        'campus_id' => 1,
    ]);

    News::factory()->published()->create([
        'title' => 'President news matched by office ID',
        'slug' => 'president-news-matched-by-office-id',
        'office_id' => $presidentOfficeById->id,
        'type' => 'news',
        'date' => now(),
    ]);

    News::factory()->published()->create([
        'title' => 'President news matched by office name',
        'slug' => 'president-news-matched-by-office-name',
        'office_id' => $presidentOfficeByName->id,
        'type' => 'news',
        'date' => now()->subDay(),
    ]);

    News::factory()->draft()->create([
        'title' => 'Draft presidential press release',
        'office_id' => $presidentOfficeById->id,
        'type' => 'news',
    ]);

    News::factory()->published()->create([
        'title' => 'President office announcement',
        'office_id' => $presidentOfficeById->id,
        'type' => 'announcement',
    ]);

    News::factory()->published()->create([
        'title' => 'Unrelated office news',
        'office_id' => $unrelatedOffice->id,
        'type' => 'news',
    ]);

    $this->get(route('about.office-of-the-president'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('about/OfficeOfThePresident')
            ->has('pressReleases', 2)
            ->where('pressReleases.0.title', 'President news matched by office ID')
            ->where('pressReleases.0.slug', 'president-news-matched-by-office-id')
            ->where('pressReleases.1.title', 'President news matched by office name')
            ->where('pressReleases.1.slug', 'president-news-matched-by-office-name')
        );
});

test('legacy innovate agenda url redirects to the president page agenda section', function () {
    expect(Route::has('about.innovate-agenda'))->toBeFalse();

    $this->get('/about/innovate-agenda')
        ->assertMovedPermanently()
        ->assertRedirect('/about/office-of-the-president#strategic-directional-agenda');
});

test('strategic agenda is presented between executives corner and the president gallery', function () {
    $presidentPage = file_get_contents(
        resource_path('js/pages/about/OfficeOfThePresident.vue'),
    );
    $publicSiteLayout = file_get_contents(
        resource_path('js/layouts/PublicSiteLayout.vue'),
    );

    expect($presidentPage)
        ->toContain('NEMSU 8-POINT STRATEGIC DIRECTIONAL AGENDA')
        ->toContain('id="executive-corner"')
        ->toContain('id="strategic-directional-agenda"')
        ->toContain('id="presidents-gallery"')
        ->toContain('Industry-driven research & innovation')
        ->toContain('Nurturing & transformative education')
        ->toContain('New technologies & entrepreneurial production')
        ->toContain('Outreach through market-oriented extension')
        ->toContain('Vibrant faculty & staff development')
        ->toContain('Accessible student services')
        ->toContain('Transparent governance & resilient infrastructure')
        ->toContain(
            'Expansive knowledge-sharing through internationalization',
        );

    expect(strpos($presidentPage, 'id="executive-corner"'))
        ->toBeLessThan(
            strpos($presidentPage, 'id="strategic-directional-agenda"'),
        )
        ->and(
            strpos($presidentPage, 'id="strategic-directional-agenda"'),
        )
        ->toBeLessThan(strpos($presidentPage, 'id="presidents-gallery"'));

    expect($publicSiteLayout)
        ->not->toContain('INNOVATE Agenda')
        ->not->toContain('innovateAgenda');

    expect(
        file_exists(resource_path('js/pages/about/InnovateAgenda.vue')),
    )->toBeFalse();
});
