<?php

test('the welcome page includes the official at a glance figures and reporting periods', function () {
    $welcomePage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/Welcome.vue',
    );

    expect($welcomePage)
        ->toContain("label: 'Current Enrollment'")
        ->toContain("value: '33,338'")
        ->toContain("scope: 'AY 2025-2026'")
        ->toContain("label: 'Faculty and Staff'")
        ->toContain("value: '1,563'")
        ->toContain("label: 'Academic Programs'")
        ->toContain("value: '99'")
        ->toContain("scope: 'Apr. 30, 2026'")
        ->toContain("label: 'PWD and Senior Personnel'")
        ->toContain("value: '60'")
        ->toContain("scope: 'Dec. 31, 2025'");
});

test('the at a glance section identifies its official data sources', function () {
    $atAGlanceSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeAtAGlance.vue',
    );

    expect($atAGlanceSection)
        ->toContain('Official figures from the NEMSU enrollment, HRMO, and')
        ->not->toContain('Dummy figures');
});

test('the campus map uses the official map asset and data-driven callouts', function () {
    $welcomePage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/Welcome.vue',
    );
    $atAGlanceSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeAtAGlance.vue',
    );

    expect($atAGlanceSection)
        ->toContain('/images/campuses/tandag/facilities/nemsu_map.png')
        ->toContain("highlight.description === 'Main campus'")
        ->toContain('highlight.labelPosition')
        ->toContain('7 campuses')
        ->and($welcomePage)
        ->toContain("labelPosition: 'left'")
        ->toContain("labelPosition: 'right'");
});
