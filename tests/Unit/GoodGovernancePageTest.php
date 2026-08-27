<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('good governance page can be viewed', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('administration.good-governance'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('administration/GoodGovernance')
        );
});

test('good governance page provides governance and foi resources', function () {
    $page = file_get_contents(resource_path('js/pages/administration/GoodGovernance.vue'));

    expect($page)
        ->toContain('revealClasses')
        ->toContain('data-scroll-section="governance-heading"')
        ->toContain('data-scroll-section="foi-heading"')
        ->toContain('data-scroll-section="foi-table"')
        ->toContain('governanceItems')
        ->toContain('freedomOfInformationResources')
        ->toContain('Transparency Seal')
        ->toContain("Citizen's Charter")
        ->toContain('id="freedom-of-information"')
        ->toContain("People's FOI Manual")
        ->toContain('NEMSU One-Page Freedom of Information Manual')
        ->toContain('NEMSU FOI Request Feedback Survey Form')
        ->toContain('Freedom of Information Report');

    expect(substr_count($page, "        href: 'https://"))->toBe(7);
});

test('public layout links to the good governance route helper', function () {
    $navigation = file_get_contents(resource_path('js/components/public-site/public-site-navigation.ts'));
    $footer = file_get_contents(resource_path('js/components/public-site/public-site-footer.ts'));

    expect($navigation)
        ->toContain('goodGovernance')
        ->toContain('href: goodGovernance().url');

    expect($footer)
        ->toContain('goodGovernance')
        ->toContain('href: `${goodGovernance().url}#freedom-of-information`');
});

test('public layout campus menu uses a single campus column', function () {
    $navigation = file_get_contents(resource_path('js/components/public-site/public-site-navigation.ts'));

    expect($navigation)
        ->toContain("label: 'Campuses'")
        ->toContain("heading: 'NEMSU System'")
        ->toContain("campusShow('tandag').url")
        ->toContain("campusShow('cantilan').url")
        ->toContain("campusShow('san-miguel').url")
        ->toContain("campusShow('cagwait').url")
        ->toContain("campusShow('lianga').url")
        ->toContain("campusShow('tagbina').url")
        ->toContain("campusShow('bislig').url")
        ->not->toContain("heading: 'More Campuses'");
});
