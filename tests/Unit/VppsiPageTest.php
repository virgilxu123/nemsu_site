<?php

use App\Http\Controllers\VppsiController;
use Tests\TestCase;

uses(TestCase::class);

test('vppsi page route uses the public controller', function () {
    $route = app('router')->getRoutes()->getByName('administration.vppsi');

    expect($route?->getActionName())->toBe(VppsiController::class);
});

test('vppsi page contains the supplied planning and strategy directory', function () {
    $page = file_get_contents(resource_path('js/pages/administration/Vppsi.vue'));

    expect(substr_count($page, "        name: '"))->toBe(8);

    expect($page)
        ->toContain('Dr. Florife O. Urbiztondo')
        ->toContain('Procurement Management System Office')
        ->toContain('Alumni Affairs Office')
        ->toContain('General Services Office')
        ->toContain('mrsacevedo@nemsu.edu.ph')
        ->toContain('planning@nemsu.edu.ph')
        ->toContain('class="mt-10 grid gap-x-12 gap-y-7 text-left sm:grid-cols-2 lg:grid-cols-3"')
        ->toContain('items-center justify-start gap-2 text-left')
        ->toContain('id="bac-matters"')
        ->toContain('data-scroll-section="bac-matters"')
        ->toContain('preserve-state');
});

test('vppsi hero displays its breadcrumb above the title', function () {
    $page = file_get_contents(resource_path('js/pages/administration/Vppsi.vue'));
    $breadcrumbPosition = strpos($page, 'aria-label="Breadcrumb"');
    $heroHeadingPosition = strpos($page, '<h3');

    expect($breadcrumbPosition)->not->toBeFalse();
    expect($heroHeadingPosition)->not->toBeFalse();
    expect($breadcrumbPosition)->toBeLessThan($heroHeadingPosition);
    expect(substr_count($page, 'aria-label="Breadcrumb"'))->toBe(1);

    expect($page)->not->toContain(
        'class="inline-flex rounded bg-white/10 px-3 py-1 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"'
    );
});
