<?php

test('every configured Tandag prospectus exists on the public disk', function () {
    $tandag = require dirname(__DIR__, 2).'/config/campuses/tandag.php';

    expect($tandag['prospectuses'])->not->toBeEmpty();

    foreach ($tandag['prospectuses'] as $program => $path) {
        expect(
            file_exists(dirname(__DIR__, 2).'/storage/app/public/'.$path),
            "Missing prospectus for {$program}: {$path}",
        )->toBeTrue();
    }
});

test('the campus page opens available prospectuses in a new tab', function () {
    $campusPage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($campusPage)
        ->toContain('campus.prospectuses[offering]')
        ->toContain('target="_blank"')
        ->toContain('rel="noopener noreferrer"')
        ->toContain('Prospectus PDF')
        ->toContain('Prospectus available');
});
