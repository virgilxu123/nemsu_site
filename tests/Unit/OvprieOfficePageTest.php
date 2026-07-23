<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('ovprie office page can be viewed', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('research.rie.offices.show', 'research-centers'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('research/OvprieOffice')
            ->where('office.title', 'Research Centers')
            ->where('office.cluster', 'University Research and Innovation Office')
            ->where('office.head', 'Erwin B. Berry, EdD')
            ->where('office.email', 'research@nemsu.edu.ph')
            ->has('offices', 9)
        );
});

test('unknown ovprie office page is hidden', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->get(route('research.rie.offices.show', 'unknown-office'))
        ->assertNotFound();
});

test('rie page links ovprie offices to office detail routes', function () {
    $page = file_get_contents(resource_path('js/pages/research/Rie.vue'));

    expect($page)
        ->toContain('OvprieOfficeController')
        ->toContain('const officeLinks = officeGroups.flatMap((group) => group.offices)')
        ->toContain('aria-label="Offices under OVPRIE"')
        ->toContain('class="mt-10 grid gap-x-12 gap-y-7 text-left sm:grid-cols-2 lg:grid-cols-3"')
        ->toContain('items-center justify-start gap-2 text-left')
        ->toContain('officeShow.url(office.slug)')
        ->not->toContain('View office')
        ->not->toContain('Office overview');
});

test('ovprie office page uses the reusable office layout', function () {
    $page = file_get_contents(resource_path('js/pages/research/OvprieOffice.vue'));

    expect($page)
        ->toContain('data-scroll-section="office-hero"')
        ->toContain('data-scroll-section="office-navigation"')
        ->toContain('data-scroll-section="office-overview"')
        ->toContain('data-scroll-section="office-profile"')
        ->toContain('md:grid-cols-[10rem_minmax(0,1fr)_18rem]')
        ->toContain('xl:grid-cols-[12rem_minmax(0,1fr)_24rem]')
        ->toContain('Other OVPRIE Offices')
        ->toContain('font-semibold text-[#9b1c31] dark:text-rose-200')
        ->toContain('headImage')
        ->toContain('officeShow.url')
        ->toContain('Back to OVPRIE offices');
});
