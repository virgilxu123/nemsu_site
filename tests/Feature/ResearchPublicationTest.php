<?php

use Inertia\Testing\AssertableInertia as Assert;

test('research publications page can be rendered with poster study urls', function () {
    $response = $this->get(route('research.rie.publications.index'));

    $response->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('research/Publications')
            ->has('collections')
            ->has('totalPosters')
            ->has('downloads')
            ->where('collections.0.posters.0.url', 'https://doi.org/10.32479/irmm.23351')
        );
});
