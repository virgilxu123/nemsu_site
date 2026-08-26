<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('ovpaf office page can be viewed', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('administration.vpaf.offices.show', 'chief-administrative-office-finance-division'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('administration/OvpafOffice')
            ->where('office.title', 'Chief Administrative Office - Finance Division')
            ->where('office.head', 'Dr. Camilo Malong')
            ->where('office.email', 'chiefAO_FinanceDivision@nemsu.edu.ph')
            ->has('offices', 12)
        );
});

test('unknown ovpaf office page is hidden', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->get(route('administration.vpaf.offices.show', 'unknown-office'))
        ->assertNotFound();
});

test('ovpaf office page uses the reusable office layout', function () {
    $page = file_get_contents(resource_path('js/pages/administration/OvpafOffice.vue'));

    expect($page)
        ->toContain('data-scroll-section="office-hero"')
        ->toContain('data-scroll-section="office-navigation"')
        ->toContain('data-scroll-section="office-overview"')
        ->toContain('data-scroll-section="office-profile"')
        ->toContain('md:grid-cols-[10rem_minmax(0,1fr)_18rem]')
        ->toContain('xl:grid-cols-[12rem_minmax(0,1fr)_24rem]')
        ->toContain('Other OVPAF Offices')
        ->toContain('font-semibold text-[#9b1c31] dark:text-rose-200')
        ->toContain('headImage')
        ->toContain('Head photo pending')
        ->toContain('Back to OVPAF offices')
        ->toContain('officeShow.url');
});

test('ovpaf office hero displays its breadcrumb above the title', function () {
    $page = file_get_contents(resource_path('js/pages/administration/OvpafOffice.vue'));
    $breadcrumbPosition = strpos($page, 'aria-label="Breadcrumb"');
    $heroHeadingPosition = strpos($page, '<h3');

    expect($breadcrumbPosition)->not->toBeFalse();
    expect($heroHeadingPosition)->not->toBeFalse();
    expect($breadcrumbPosition)->toBeLessThan($heroHeadingPosition);
    expect(substr_count($page, 'aria-label="Breadcrumb"'))->toBe(1);
});
