<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('citizens charter page can be viewed', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('administration.citizens-charter'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('administration/CitizensCharter')
        );
});

test('citizens charter page provides a campus document viewer', function () {
    $page = file_get_contents(resource_path('js/pages/administration/CitizensCharter.vue'));

    expect($page)
        ->toContain("import PageHero from '@/components/PageHero.vue'")
        ->toContain('<PageHero')
        ->toContain('title="Citizen\'s Charter"')
        ->toContain('href: goodGovernance().url')
        ->toContain('campusCharters')
        ->toContain('selectedCampusName')
        ->toContain('selectedCampusPreviewUrl')
        ->toContain('id="campus-charter-select"')
        ->toContain('aria-label="Campus charter navigation"')
        ->toContain('aria-controls="campus-charter-document"')
        ->toContain(':aria-pressed=')
        ->toContain('loading="lazy"')
        ->toContain('View all resources')
        ->toContain('Main Campus')
        ->toContain('Cantilan Campus')
        ->toContain('Bislig Campus')
        ->toContain('1X4UVxlUVjEv2wZVMuwNDRAn9Wm0RRvXg')
        ->toContain('1iC2cx1QFdNoGer-oi_ILdOO7HfdBmKNp')
        ->toContain('id="charter-documents"')
        ->toContain('<iframe');

    expect(substr_count($page, 'https://drive.google.com/file/d/'))->toBe(7);
});
