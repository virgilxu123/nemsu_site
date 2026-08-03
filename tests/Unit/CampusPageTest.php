<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class, LazilyRefreshDatabase::class);

test('campus page can be viewed', function () {
    $this->get(route('campuses.show', 'tandag'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('campuses/Show')
            ->has('campuses', 7)
            ->where('campus.slug', 'tandag')
            ->where('campus.name', 'Tandag Campus')
            ->where('campus.director.photo', '/images/campuses/tandag/cd.png')
            ->has('campus.profile')
            ->has('campus.director')
            ->has('campus.facilities')
            ->has('campus.facilityGallery', 19)
            ->has('campus.programs')
            ->has('campus.services')
            ->has('campus.serviceHighlights', 4)
            ->has('campus.studentGovernment')
            ->has('campus.studentGovernment.activities', 5)
            ->has('campus.updates')
        );
});

test('unknown campus returns not found', function () {
    $this->get('/campuses/unknown-campus')
        ->assertNotFound();
});

test('tandag campus director photo is configured', function () {
    expect(config('campus_profiles.tandag.director.photo'))
        ->toBe('/images/campuses/tandag/cd.png');
});

test('all campus data files are loaded', function () {
    expect(config('campus_profiles'))
        ->toHaveKeys([
            'tandag',
            'cantilan',
            'san-miguel',
            'lianga',
            'cagwait',
            'tagbina',
            'bislig',
        ]);
});

test('each campus page uses its corresponding local hero image', function (
    string $campus,
    string $imagePath,
) {
    expect(Storage::disk('public')->exists($imagePath))->toBeTrue();

    $this->get(route('campuses.show', $campus))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('campus.heroImage', Storage::disk('public')->url($imagePath))
        );
})->with([
    'Tandag' => ['tandag', 'images/campuses/tandag/6I3A5798.JPG'],
    'Cantilan' => ['cantilan', 'images/campuses/cantilan/Cantilan.jpg'],
    'San Miguel' => ['san-miguel', 'images/campuses/san-miguel/San Miguel.jpg'],
    'Lianga' => ['lianga', 'images/campuses/lianga/Lianga.jpg'],
    'Cagwait' => ['cagwait', 'images/campuses/cagwait/Cagwait.jpg'],
    'Tagbina' => ['tagbina', 'images/campuses/tagbina/Tagbina.jpg'],
    'Bislig' => ['bislig', 'images/campuses/bislig/Bislig.jpg'],
]);

test('the campus hero renders the configured image as a cover image', function () {
    $campusPage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($campusPage)
        ->toContain(':src="campus.heroImage"')
        ->toContain('class="campus-hero-image')
        ->toContain('object-cover object-center')
        ->not->toContain(':style="heroBackgroundStyle"');
});
