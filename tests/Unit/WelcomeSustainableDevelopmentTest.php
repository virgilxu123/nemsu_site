<?php

test('the welcome sustainable development section presents the university commitment', function () {
    $section = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeSustainableDevelopment.vue',
    );
    $content = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/welcome-content.ts',
    );

    expect($section)
        ->toContain(
            'NEMSU’s Commitment to the United Nations Sustainable',
            'Development Goals',
        )
        ->toContain(
            'class="font-serif text-3xl font-bold tracking-tight',
        )
        ->not->toContain('class="mt-3 font-serif text-3xl')
        ->toContain('src="/storage/images/sdg/1639491308447.png"')
        ->toContain(
            'alt="United Nations Sustainable Development Goals color wheel showing all 17 goals"',
        )
        ->toContain('object-contain')
        ->and($content)
        ->toContain(
            'NEMSU advances the United Nations Sustainable Development Goals',
            'C.A.R.E.S. core values',
            'I.N.N.O.V.A.T.E. strategic agenda',
            'SDGs 4, 9, 10, and 17',
            'equitable and sustainable communities across the region.',
        )
        ->not->toContain('reaffirms its strong commitment');
});

test('the welcome sustainable development section presents two article cards without a divider', function () {
    $section = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeSustainableDevelopment.vue',
    );

    expect($section)
        ->toContain('v-for="article in articles.slice(0, 2)"')
        ->toContain(':href="articleUrl(article)"')
        ->toContain('class="mt-5 grid gap-4 sm:grid-cols-2"')
        ->toContain(
            'class="group flex h-full flex-col overflow-hidden rounded-lg border',
        )
        ->toContain('aspect-video')
        ->toContain('v-if="article.photoUrl"')
        ->toContain('{{ article.title }}')
        ->toContain('{{ article.date || article.category }}')
        ->toContain(':href="newsIndex()"')
        ->toContain('View all SDG initiatives')
        ->toContain('sm:col-span-2')
        ->toContain(
            'SDG initiatives will appear here after published records',
        )
        ->not->toContain('lg:border-l');
});
