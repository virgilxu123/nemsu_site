<?php

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('campus page can be viewed', function () {
    $this->get(route('campuses.show', 'tandag'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('campuses/Show')
            ->has('campuses', 7)
            ->where('campus.slug', 'tandag')
            ->where('campus.name', 'Tandag Campus')
            ->has('campus.profile')
            ->has('campus.director')
            ->has('campus.facilities')
            ->has('campus.facilityGallery', 19)
            ->has('campus.programs')
            ->has('campus.services')
            ->has('campus.serviceHighlights', 4)
            ->has('campus.studentGovernment')
            ->has('campus.updates')
        );
});

test('unknown campus returns not found', function () {
    $this->get('/campuses/unknown-campus')
        ->assertNotFound();
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
