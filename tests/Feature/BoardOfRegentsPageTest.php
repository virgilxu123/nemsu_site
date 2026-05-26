<?php

use Inertia\Testing\AssertableInertia as Assert;

test('board of regents page can be viewed', function () {
    $this->get(route('about.board-of-regents'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('about/BoardOfRegents')
        );
});
