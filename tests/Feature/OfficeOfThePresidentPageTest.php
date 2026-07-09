<?php

use App\Models\News;
use Inertia\Testing\AssertableInertia as Assert;

test('office of the president page can be viewed', function () {
    News::factory()->published()->create([
        'title' => 'Latest presidential press release',
        'slug' => 'latest-presidential-press-release',
        'type' => 'news',
    ]);

    News::factory()->draft()->create([
        'title' => 'Draft presidential press release',
        'type' => 'news',
    ]);

    $this->get(route('about.office-of-the-president'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('about/OfficeOfThePresident')
            ->has('pressReleases', 1)
            ->where('pressReleases.0.title', 'Latest presidential press release')
            ->where('pressReleases.0.slug', 'latest-presidential-press-release')
        );
});

test('innovate agenda page can be viewed', function () {
    $this->get(route('about.innovate-agenda'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('about/InnovateAgenda')
        );
});
