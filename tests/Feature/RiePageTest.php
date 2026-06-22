<?php

use Inertia\Testing\AssertableInertia as Assert;

test('research innovation and extension page can be viewed', function () {
    $this->get(route('research.rie'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('research/Rie')
        );
});
