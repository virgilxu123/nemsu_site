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
        ->toContain('revealClasses')
        ->toContain('data-scroll-section="ovpaf-hero"')
        ->toContain('data-scroll-section="ovpaf-overview"')
        ->toContain('data-scroll-section="ovpaf-profile"')
        ->toContain('data-scroll-section="ovpaf-offices"')
        ->toContain('Atty. Mitchiko Donaire-Maglinte')
        ->toContain('Chief Administrative Office - Finance Division')
        ->toContain('Chief Administrative Office - Admin Division')
        ->toContain('Supervising Administrative Office - Finance Division')
        ->toContain('Supervising Administrative Office - Administration Division')
        ->toContain('Accounting Office')
        ->toContain('Budget Office')
        ->toContain('Human Resource Management Office')
        ->toContain('Supply Office')
        ->toContain('Cashier Office')
        ->toContain('Income-Generating Project and Auxiliary Services Office')
        ->toContain('Disaster Risk Management Office')
        ->toContain('Energy Efficiency and Conservation Office')
        ->toContain('class="mt-10 grid gap-x-12 gap-y-7 text-left sm:grid-cols-2 lg:grid-cols-3"')
        ->toContain('items-center justify-start gap-2 text-left')
        ->toContain('officeShow.url')
        ->not->toContain('id="freedom-of-information"')
        ->not->toContain('freedomOfInformationResources');
});
