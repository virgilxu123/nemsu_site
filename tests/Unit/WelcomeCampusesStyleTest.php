<?php

test('the campuses section uses the high fidelity staggered campus carousel', function () {
    $campusesSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeCampuses.vue',
    );

    expect($campusesSection)
        ->toContain('bg-[#1C0ED7]')
        ->not->toContain('linear-gradient(90deg,#0B075F')
        ->toContain('rounded-full bg-white')
        ->toContain('data-campus-dots="top"')
        ->toContain('grid grid-cols-4 gap-2')
        ->toContain('data-campus-dots="bottom"')
        ->toContain('grid-cols-3 gap-2 sm:grid')
        ->toContain('v-for="dot in 12"')
        ->toContain('font-serif text-3xl')
        ->toContain('bg-[#F2B900]')
        ->toContain(
            "Discover NEMSU's seven campuses, each advancing accessible",
        )
        ->toContain('max-w-7xl')
        ->toContain('snap-x snap-mandatory')
        ->toContain('overflow-x-auto')
        ->toContain('snap-start')
        ->toContain('aspect-[4/5]')
        ->toContain('lg:aspect-[4/9]')
        ->toContain('w-[72%]')
        ->toContain('sm:w-[42%]')
        ->toContain('md:w-[30%]')
        ->toContain('lg:basis-0')
        ->toContain('lg:grow')
        ->toContain("index % 2 === 1 ? 'lg:translate-y-8' : ''")
        ->toContain(
            'linear-gradient(to_bottom,transparent_28%,rgba(8,4,95,0.35)_54%,#08045F_72%)',
        )
        ->toContain('absolute inset-0 flex flex-col justify-end')
        ->toContain('text-shadow-sm')
        ->toContain('text-shadow-black/50')
        ->toContain('{{ campus.name }} Campus')
        ->toContain('{{ campus.focus }}')
        ->toContain(':href="campusShow(campus.slug)"')
        ->toContain('bg-white/10')
        ->toContain('Explore')
        ->not->toContain('rounded-lg border border-[#D8DEE8] bg-white')
        ->not->toContain('campus.location')
        ->not->toContain('<MapPin')
        ->not->toContain('from-[#080529]/95');

    expect(substr_count($campusesSection, 'v-for="dot in 12"'))->toBe(2);
});

test('the campuses carousel exposes accessible synchronized controls', function () {
    $campusesSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeCampuses.vue',
    );

    expect($campusesSection)
        ->toContain('aria-label="Previous campuses"')
        ->toContain('aria-label="Next campuses"')
        ->toContain('aria-controls="campus-carousel"')
        ->toContain(':aria-current=')
        ->toContain('scrollToPage')
        ->toContain('syncActivePage')
        ->toContain('ResizeObserver')
        ->toContain('(prefers-reduced-motion: reduce)')
        ->toContain("behavior: prefersReducedMotion ? 'auto' : 'smooth'");
});

test('the campuses section removes the former overview and statistics', function () {
    $campusesSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeCampuses.vue',
    );

    expect($campusesSection)
        ->not->toContain('One NEMSU system, distinct campus strengths')
        ->not->toContain('Campus footprint preview')
        ->not->toContain('A quick system view for the campus pages')
        ->not->toContain('Student Population')
        ->not->toContain('Faculty and Staff')
        ->not->toContain('Graduates')
        ->not->toContain('IntersectionObserver')
        ->not->toContain('backgroundStyle')
        ->not->toContain('staggerDelay')
        ->not->toContain('lg:sticky');
});

test('the welcome page passes only the required campus carousel props', function () {
    $welcomePage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/Welcome.vue',
    );
    $welcomeContent = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/welcome-content.ts',
    );

    preg_match(
        '/<WelcomeCampuses(?<markup>.*?)\\/>/s',
        $welcomePage,
        $matches,
    );

    expect($matches)->toHaveKey('markup')
        ->and($matches['markup'])
        ->toContain(':campuses="campuses"')
        ->toContain(':reveal-classes="revealClasses"')
        ->not->toContain('background-style')
        ->not->toContain('stagger-delay')
        ->and($welcomePage)
        ->not->toContain('campusBackgroundStyle')
        ->and($welcomeContent)
        ->not->toContain('export const campusBackgroundStyle');
});

test('the welcome content keeps all seven campuses in the carousel', function () {
    $welcomeContent = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/welcome-content.ts',
    );

    expect($welcomeContent)
        ->toContain("slug: 'tandag'")
        ->toContain("slug: 'cantilan'")
        ->toContain("slug: 'san-miguel'")
        ->toContain("slug: 'lianga'")
        ->toContain("slug: 'cagwait'")
        ->toContain("slug: 'tagbina'")
        ->toContain("slug: 'bislig'");
});
