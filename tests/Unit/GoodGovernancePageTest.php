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
        ->toContain('data-scroll-section="good-governance-hero"')
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
