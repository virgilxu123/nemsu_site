<?php

test('public site header emphasizes the NEMSU brand and displays its tagline', function () {
    $header = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/PublicSiteHeader.vue',
    );

    expect($header)
        ->toContain('text-2xl leading-none font-bold')
        ->toContain('NEMSU')
        ->toContain('Walk a journey of Excellence and Success')
        ->not->toContain('North Eastern Mindanao State University');
});
