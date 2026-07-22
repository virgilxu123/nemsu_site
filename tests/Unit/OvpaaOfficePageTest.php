<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('ovpaa office page can be viewed', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('academics.academic-affairs.offices.show', 'curriculum-development-office'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('academics/OvpaaOffice')
            ->where('office.title', 'Curriculum Development Office')
            ->where('office.headTitle', 'Director')
            ->where('office.head', 'Dr. Karla Jeane P. Roz-Estrada')
            ->where('office.email', null)
            ->has('offices', 10)
        );
});

test('unknown ovpaa office page is hidden', function () {
    $this->get(route('academics.academic-affairs.offices.show', 'unknown-office'))
        ->assertNotFound();
});

test('academic affairs page links offices to office detail routes', function () {
    $page = file_get_contents(resource_path('js/pages/academics/AcademicAffairs.vue'));

    expect($page)
        ->toContain('OvpaaOfficeController')
        ->toContain('officeShow.url(office.slug)')
        ->toContain('Offices under OVPAA')
        ->not->toContain('office.email || office.contact');
});

test('ovpaa office page uses the reusable office layout', function () {
    $page = file_get_contents(resource_path('js/pages/academics/OvpaaOffice.vue'));

    expect($page)
        ->toContain('data-scroll-section="office-hero"')
        ->toContain('data-scroll-section="office-navigation"')
        ->toContain('data-scroll-section="office-overview"')
        ->toContain('data-scroll-section="office-profile"')
        ->toContain('md:grid-cols-[10rem_minmax(0,1fr)_18rem]')
        ->toContain('xl:grid-cols-[12rem_minmax(0,1fr)_24rem]')
        ->toContain('md:order-none')
        ->toContain('Other OVPAA Offices')
        ->toContain('font-semibold text-[#9b1c31] dark:text-rose-200')
        ->toContain('headImage')
        ->toContain('Head photo pending')
        ->toContain('Back to OVPAA offices')
        ->toContain('officeShow.url');
});
