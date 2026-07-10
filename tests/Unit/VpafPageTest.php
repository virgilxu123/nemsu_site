<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('vpaf page can be viewed', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('administration.vpaf'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('administration/Vpaf')
        );
});

test('vpaf page contains the supplied office directory', function () {
    $page = file_get_contents(resource_path('js/pages/administration/Vpaf.vue'));

    expect(substr_count($page, "        name: '"))->toBe(8);

    expect($page)
        ->toContain('revealClasses')
        ->toContain('data-scroll-section="ovpaf-hero"')
        ->toContain('data-scroll-section="ovpaf-overview"')
        ->toContain('data-scroll-section="ovpaf-profile"')
        ->toContain('data-scroll-section="ovpaf-offices"')
        ->toContain('Atty. Mitchiko Donaire-Maglinte')
        ->toContain('Procurement Management System Office')
        ->toContain('Alumni Affairs Office')
        ->toContain('Records Management Office')
        ->toContain('GAD and Values Restoration Office')
        ->toContain('Information and Public Affairs Office')
        ->toContain('Quality Assurance Office')
        ->toContain('Planning Office')
        ->toContain('General Services Office')
        ->not->toContain('id="freedom-of-information"')
        ->not->toContain('freedomOfInformationResources');
});
