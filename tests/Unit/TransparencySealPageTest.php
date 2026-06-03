<?php

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('transparency seal page can be viewed', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->get(route('administration.transparency-seal'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('administration/TransparencySeal')
        );
});
