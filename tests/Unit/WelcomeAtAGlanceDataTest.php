<?php

test('the welcome content includes the official at a glance figures and reporting periods', function () {
    $welcomeContent = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/welcome-content.ts',
    );

    expect($welcomeContent)
        ->toContain("label: 'Current Enrollment'")
        ->toContain("value: '33,338'")
        ->toContain("scope: 'AY 2025–2026'")
        ->toContain("label: 'Faculty and Staff'")
        ->toContain("value: '1,563'")
        ->toContain("scope: 'As of Dec. 31, 2025'")
        ->toContain("label: 'Academic Programs'")
        ->toContain("value: '99'")
        ->toContain("scope: 'As of Apr. 30, 2026'")
        ->toContain("label: 'Campuses'")
        ->toContain("value: '7'");
});

test('the at a glance section identifies its official data sources', function () {
    $atAGlanceSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeAtAGlance.vue',
    );

    expect($atAGlanceSection)
        ->toContain('Official figures from the NEMSU enrollment,')
        ->toContain('HRMO, and campus reports.')
        ->not->toContain('Dummy figures');
});

test('the at a glance section matches the high fidelity composition', function () {
    $atAGlanceSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeAtAGlance.vue',
    );

    expect($atAGlanceSection)
        ->toContain('bg-[#EEF2FF] py-16 lg:py-20')
        ->toContain('w-full text-center text-[28vw]')
        ->toContain('bottom-[-2vw]')
        ->toContain('w-full max-w-7xl px-4 sm:px-6 lg:px-8')
        ->toContain('grid w-full items-center')
        ->toContain('size-36 rounded-full bg-[#F2B900]')
        ->toContain('radial-gradient(circle,#08045F_1.5px,transparent_1.5px)')
        ->toContain(
            'lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)]',
        )
        ->toContain('gap-8')
        ->toContain('lg:gap-0')
        ->toContain('max-w-[36rem]')
        ->toContain('lg:-ml-4')
        ->toContain('lg:justify-self-start')
        ->toContain('gap-y-9 pl-10 sm:max-w-xl sm:pl-14')
        ->toContain('v-for="(stat, index) in stats"')
        ->toContain('border-b border-[#08045F]')
        ->toContain('Seven campuses serving communities across')
        ->toContain('Surigao del Sur')
        ->toContain('{{ stat.value }}')
        ->toContain('{{ stat.label }}')
        ->toContain('{{ stat.scope }}')
        ->toContain('/storage/images/nemsu-at-glance/nemsu-map.png')
        ->toContain(
            'alt="Map of Surigao del Sur showing the seven NEMSU campuses"',
        )
        ->toContain('bg-[#F2B900]')
        ->toContain("import type {\n    GlanceStat,")
        ->not->toContain('getStatIcon')
        ->not->toContain('stat.icon')
        ->not->toContain('stat.description')
        ->not->toContain('rounded-lg border border-[#D8DEE8] bg-white p-5');
});

test('the campus map uses the supplied responsive image and preserves the map data contract', function () {
    $welcomePage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/Welcome.vue',
    );
    $atAGlanceSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeAtAGlance.vue',
    );

    expect($atAGlanceSection)
        ->toContain('mapHighlights: MapHighlight[];')
        ->toContain('/storage/images/nemsu-at-glance/nemsu-map.png')
        ->toContain('width="713"')
        ->toContain('height="764"')
        ->toContain('h-auto w-full object-contain')
        ->not->toContain('blur-3xl')
        ->not->toContain('drop-shadow-[')
        ->not->toContain('Map placeholder')
        ->not->toContain('Campus map placeholder')
        ->not->toContain(
            '/images/campuses/tandag/facilities/nemsu_map.png',
        )
        ->not->toContain('v-for="highlight in mapHighlights"')
        ->not->toContain('highlight.labelPosition')
        ->not->toContain('highlight.description')
        ->not->toContain('<svg')
        ->not->toContain('Landmark')
        ->and($welcomePage)
        ->toContain(':stats="atAGlanceStats"')
        ->toContain(':map-highlights="atAGlanceMapHighlights"');
});
