<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('vppsi office page can be viewed', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('administration.vppsi.offices.show', 'planning-office'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('administration/VppsiOffice')
            ->where('office.title', 'Planning Office')
            ->where('office.head', 'Engr. Kennie F. Montenegro')
            ->where('office.email', 'planning@nemsu.edu.ph')
            ->has('offices', 8)
        );
});

test('unknown vppsi office page is hidden', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->get(route('administration.vppsi.offices.show', 'unknown-office'))
        ->assertNotFound();
});

test('vppsi page links offices to office detail routes', function () {
    $page = file_get_contents(resource_path('js/pages/administration/Vppsi.vue'));

    expect($page)
        ->toContain('VppsiOfficeController')
        ->toContain('officeShow.url(office.id)')
        ->not->toContain(':href="`#${office.id}`"');
});

test('vppsi office page uses the reusable office layout', function () {
    $page = file_get_contents(resource_path('js/pages/administration/VppsiOffice.vue'));

    expect($page)
        ->toContain('data-scroll-section="office-hero"')
        ->toContain('data-scroll-section="office-navigation"')
        ->toContain('data-scroll-section="office-overview"')
        ->toContain('data-scroll-section="office-profile"')
        ->toContain('md:grid-cols-[10rem_minmax(0,1fr)_18rem]')
        ->toContain('xl:grid-cols-[12rem_minmax(0,1fr)_24rem]')
        ->toContain('Other OVPPSI Offices')
        ->toContain('font-semibold text-[#9b1c31] dark:text-rose-200')
        ->toContain('headImage')
        ->toContain('officeShow.url')
        ->toContain('Back to OVPPSI offices');
});
