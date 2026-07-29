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
            'class="font-academic text-3xl leading-[1.08] font-bold tracking-tight',
        )
        ->not->toContain('sm:text-4xl lg:text-2xl')
        ->toContain('max-w-xl text-base leading-7')
        ->toContain('min-h-11 items-center gap-3')
        ->not->toContain('lg:text-xs')
        ->not->toContain('lg:text-[0.8125rem]')
        ->not->toContain('lg:text-[0.6875rem]')
        ->not->toContain('lg:text-[0.5rem]')
        ->toContain('bg-[#EEF3FF] py-16 lg:py-20')
        ->not->toContain('sm:py-20')
        ->not->toContain('lg:py-0')
        ->toContain('lg:-top-20 lg:-left-4 lg:text-[23rem]')
        ->toContain('data-sdg-watermark')
        ->not->toContain('top-1/2 -left-10 -translate-y-1/2')
        ->toContain(
            'class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8"',
        )
        ->toContain('class="grid w-full items-start')
        ->not->toContain('lg:h-[33.75rem]')
        ->not->toContain('lg:w-[50rem]')
        ->not->toContain('lg:max-w-[50rem]')
        ->toContain(
            'lg:grid-cols-[5rem_minmax(0,1.25fr)_minmax(15rem,0.8fr)_3.25rem]',
        )
        ->toContain('class="relative mx-auto size-20 lg:mt-5"')
        ->not->toContain('lg:mt-[4.375rem]')
        ->not->toContain('lg:w-[18.25rem]')
        ->not->toContain('lg:w-[10.625rem]')
        ->toContain('SDG')
        ->toContain('bg-[#F8BC00]')
        ->toContain('v-for="dot in 9"')
        ->toContain('data-sdg-logo-rail')
        ->toContain('absolute inset-y-0 left-1/2')
        ->toContain('relative ml-auto h-full w-[3.25rem]')
        ->toContain('src="/storage/images/sdg/sdg-logo.png"')
        ->toContain(
            'alt="United Nations Sustainable Development Goals vertical banner"',
        )
        ->not->toContain('src="/storage/images/sdg/1639491308447.png"')
        ->and($content)
        ->toContain(
            'NEMSU advances the United Nations Sustainable Development Goals',
            'C.A.R.E.S. core values',
            'I.N.N.O.V.A.T.E. strategic agenda',
            'SDGs 4, 9, 10, and 17',
            'equitable and sustainable communities across the region.',
        )
        ->not->toContain('reaffirms its strong commitment');

    expect(strpos($section, 'data-sdg-logo-rail'))
        ->toBeLessThan(strpos($section, ':class="revealClasses'));
});

test('the welcome sustainable development section presents a vertical stack of initiative cards', function () {
    $section = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeSustainableDevelopment.vue',
    );

    expect($section)
        ->toContain('v-for="article in articles.slice(0, 4)"')
        ->toContain(':href="articleUrl(article)"')
        ->toContain('class="grid gap-4 lg:gap-3"')
        ->toContain(
            'class="group relative flex min-h-22 overflow-hidden rounded-md border',
        )
        ->toContain('lg:h-[5.6875rem] lg:min-h-0')
        ->toContain('v-if="article.photoUrl"')
        ->toContain('absolute inset-0 size-full object-cover')
        ->toContain('linear-gradient(90deg')
        ->toContain('{{ article.title }}')
        ->toContain('{{ article.date || article.category }}')
        ->toContain('text-sm leading-snug font-bold text-white sm:text-base')
        ->toContain('text-[0.65rem] leading-4 font-medium')
        ->toContain(':href="newsIndex()"')
        ->toContain('View all SDG initiatives')
        ->toContain(
            'SDG initiatives will appear here after published',
            'records are available.',
        )
        ->not->toContain('lg:border-l');
});
