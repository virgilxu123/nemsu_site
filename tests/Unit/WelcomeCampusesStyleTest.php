<?php

test('the campuses section uses a responsive primary-gradient tile carousel', function () {
    $campusesSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeCampuses.vue',
    );

    expect($campusesSection)
        ->toContain('bg-[#1C0ED7]')
        ->toContain(
            'bg-[linear-gradient(90deg,#0B075F_0%,#160BB2_48%,#1C0ED7_100%)]',
        )
        ->toContain('font-serif text-3xl')
        ->toContain('bg-[#F2B900]')
        ->toContain(
            "Discover NEMSU's seven campuses, each advancing accessible",
        )
        ->toContain('max-w-2xl text-sm leading-7 text-white/80')
        ->toContain('max-w-[90rem]')
        ->toContain('snap-x snap-mandatory')
        ->toContain('overflow-x-auto')
        ->toContain('snap-start')
        ->toContain('aspect-5/4')
        ->toContain('sm:w-1/2')
        ->toContain('lg:w-1/4')
        ->toContain(
            'bg-linear-to-t from-black/55 via-[#0B075F]/18 to-transparent',
        )
        ->toContain('absolute inset-0 flex flex-col justify-end')
        ->toContain('text-shadow-sm')
        ->toContain('text-shadow-black/50')
        ->toContain('mt-0.5 text-sm leading-6')
        ->toContain(':href="campusShow(campus.slug)"')
        ->toContain('Explore campus')
        ->not->toContain('gap-4 overflow-x-auto')
        ->not->toContain('rounded-lg border border-[#D8DEE8] bg-white')
        ->not->toContain('campus.location')
        ->not->toContain('<MapPin')
        ->not->toContain('from-[#080529]/95');
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
