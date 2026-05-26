<?php

use Inertia\Testing\AssertableInertia as Assert;

test('office of the president page can be viewed', function () {
    $this->get(route('about.office-of-the-president'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('about/OfficeOfThePresident')
        );
});
