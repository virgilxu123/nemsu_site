<?php

use App\Models\News;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;

test('office of the president page can be viewed', function () {
    News::factory()->published()->create([
        'title' => 'Latest presidential press release',
        'slug' => 'latest-presidential-press-release',
        'type' => 'news',
    ]);

    News::factory()->draft()->create([
        'title' => 'Draft presidential press release',
        'type' => 'news',
    ]);

    $this->get(route('about.office-of-the-president'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('about/OfficeOfThePresident')
            ->has('pressReleases', 1)
            ->where('pressReleases.0.title', 'Latest presidential press release')
            ->where('pressReleases.0.slug', 'latest-presidential-press-release')
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
