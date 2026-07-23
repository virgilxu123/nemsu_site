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
        ->toContain(
            'Official figures from the NEMSU enrollment, HRMO, and campus',
        )
        ->not->toContain('Dummy figures');
});

test('the at a glance statistics use the welcome card system without icons', function () {
    $atAGlanceSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeAtAGlance.vue',
    );

    expect($atAGlanceSection)
        ->toContain('class="bg-white py-16 lg:py-20 dark:bg-slate-950"')
        ->toContain('rounded-lg border border-[#D8DEE8] bg-white p-5')
        ->toContain('bg-[#F2B900]')
        ->toContain('text-[#1C0ED7]')
        ->toContain('bg-[#1c0ed7] p-5 text-white')
        ->toContain(
            'linear-gradient(135deg,rgba(28,14,215,0.98),rgba(28,14,215,0.82))',
        )
        ->toContain("import type {\n    GlanceStat,")
        ->not->toContain('getStatIcon')
        ->not->toContain('stat.icon')
        ->not->toContain('stat.description')
        ->not->toContain('CalendarDays')
        ->not->toContain('bg-[#061b49] p-5 text-white')
        ->not->toContain('radial-gradient(circle_at_15%_20%');
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
