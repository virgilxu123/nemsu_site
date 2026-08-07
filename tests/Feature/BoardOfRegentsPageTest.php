<?php

use Inertia\Testing\AssertableInertia as Assert;

test('board of regents page can be viewed', function () {
    $this->get(route('about.board-of-regents'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('about/BoardOfRegents')
        );
});

test('board members are presented in a governance hierarchy', function () {
    $boardPage = file_get_contents(
        resource_path('js/pages/about/BoardOfRegents.vue'),
    );

    expect($boardPage)->toContain(
        "title: 'Chairperson'",
        "title: 'Vice Chairperson'",
        "title: 'Members of the Board'",
        "title: 'Board Secretariat'",
        'v-for="(level, levelIndex) in boardLevels"',
    );

    expect($boardPage)->not->toContain(
        'Governance Structure',
        'Board leadership hierarchy',
        'Governing Leadership',
        'Executive Leadership',
        'Board Membership',
        'Administrative Support',
    );
});
