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

test('bislig campus page presents its official about content', function () {
    $this->get(route('campuses.show', 'bislig'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('campus.profile.overview', fn (string $overview): bool => str_contains(
                $overview,
                'became an integral part of NEMSU pursuant to the Memorandum of Agreement executed in 2018',
            ) && str_contains(
                $overview,
                'Center for Agro-Forestry Industrial Research',
            ) && str_contains(
                $overview,
                'Bachelor of Secondary Education Major in English – Level III Accredited',
            ))
        );
});

test('bislig campus page presents its official director and visit details', function () {
    expect(public_path('images/campuses/bislig/whelson-c-pasos.jpg'))
        ->toBeFile();

    $campusPage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($campusPage)
        ->toContain('{{ campus.director.office }}')
        ->toContain('{{ campus.contact.address }}')
        ->toContain('{{ campus.contact.email }}')
        ->toContain('v-if="campus.contact.phone"')
        ->toContain('v-if="campus.contact.officeHours"')
        ->not->toContain('v-if="campus.director.email"')
        ->not->toContain('campus.contact.facebook');

    $this->get(route('campuses.show', 'bislig'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('campus.director.name', 'Whelson C. Pasos')
            ->where('campus.director.role', 'Campus Director')
            ->where('campus.director.email', 'wcpasos@nemsu.edu.ph')
            ->where('campus.director.photo', '/images/campuses/bislig/whelson-c-pasos.jpg')
            ->where('campus.contact.address', 'Maharlika, Bislig City, Surigao del Sur, 8311')
            ->where('campus.contact.email', 'nemsubislig@nemsu.edu.ph')
            ->where('campus.contact.phone', null)
            ->where('campus.contact.officeHours', 'Monday to Friday, 8:00 AM - 5:00 PM')
        );
});

test('bislig campus groups its accredited program offerings by college', function () {
    $programs = [
        [
            'college' => 'College of Teacher Education',
            'offerings' => [
                'Bachelor of Secondary Education Major in English – Level III Accredited',
                'Bachelor of Technical-Vocational Teacher Education (Electrical Technology) – Level I Accredited',
            ],
        ],
        [
            'college' => 'College of Engineering and Technology',
            'offerings' => [
                'Bachelor of Science in Civil Engineering – Level II Accredited',
                'Bachelor of Science in Electrical Engineering – Level II Accredited',
                'Bachelor of Science in Mechanical Engineering – Level II Accredited',
            ],
        ],
        [
            'college' => 'College of Agriculture and Forestry',
            'offerings' => [
                'Bachelor of Science in Forestry – Level II Accredited',
            ],
        ],
    ];

    expect(config('campus_profiles.bislig.programs'))
        ->toBe($programs)
        ->and(config('campus_profiles.bislig.stats.2'))
        ->toMatchArray([
            'label' => 'Program Offerings',
            'value' => '6',
        ]);

    $this->get(route('campuses.show', 'bislig'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('campus.programs', $programs)
            ->where('campus.stats.2.value', '6')
        );
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
