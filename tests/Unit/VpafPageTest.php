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

    expect(substr_count($page, "        name: '"))->toBe(12);

    expect($page)
        ->toContain('Atty. Mitchiko Donaire-Maglinte')
        ->toContain('Chief Administrative Office - Finance Division')
        ->toContain('Energy Efficiency and Conservation Office')
        ->toContain('chiefAO_FinanceDivision@nemsu.edu.ph')
        ->toContain('hrmo.tandag@nemsu.edu.ph')
        ->toContain('supplyofficemain@gmail.com')
        ->toContain('id="freedom-of-information"')
        ->toContain('freedomOfInformationResources')
        ->toContain("People's FOI Manual")
        ->toContain('Freedom of Information Report');
});
