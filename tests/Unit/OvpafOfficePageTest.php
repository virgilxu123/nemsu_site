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
        ->toContain('data-scroll-section="office-overview"')
        ->toContain('data-scroll-section="office-profile"')
        ->toContain('headImage')
        ->toContain('Head photo pending')
        ->toContain('Back to OVPAF offices')
        ->toContain('officeShow.url');
});
