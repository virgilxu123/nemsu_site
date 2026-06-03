<?php

use Inertia\Testing\AssertableInertia as Assert;

test('about university page can be viewed', function () {
    $this->get(route('about.university'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('about/University')
        );
});
