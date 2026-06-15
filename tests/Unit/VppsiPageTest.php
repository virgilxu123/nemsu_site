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
        ->toContain('id="bac-matters"');
});
