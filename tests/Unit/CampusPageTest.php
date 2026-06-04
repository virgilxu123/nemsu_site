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
            ->has('campus', fn (Assert $page) => $page
                ->where('slug', 'tandag')
                ->where('name', 'Tandag Campus')
                ->has('profile')
                ->has('director')
                ->has('facilities')
                ->has('programs')
                ->has('services')
                ->has('studentGovernment')
                ->has('updates')
                ->etc()
            )
        );
});

test('unknown campus returns not found', function () {
    $this->get('/campuses/unknown-campus')
        ->assertNotFound();
});
