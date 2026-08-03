<?php

test('the welcome page is a thin composition of reusable sections', function () {
    $welcomePage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/Welcome.vue',
    );

    expect($welcomePage)
        ->toContain("import WelcomeHero from '@/pages/welcome-sections/WelcomeHero.vue'")
        ->toContain("import WelcomeQuickActions from '@/pages/welcome-sections/WelcomeQuickActions.vue'")
        ->toContain("import WelcomeNews from '@/pages/welcome-sections/WelcomeNews.vue'")
        ->toContain("import WelcomeAtAGlance from '@/pages/welcome-sections/WelcomeAtAGlance.vue'")
        ->toContain("import WelcomeBAC from '@/pages/welcome-sections/WelcomeBAC.vue'")
        ->toContain("import WelcomeCampuses from '@/pages/welcome-sections/WelcomeCampuses.vue'")
        ->toContain("import WelcomeJobs from '@/pages/welcome-sections/WelcomeJobs.vue'")
        ->toContain("import WelcomeSustainableDevelopment from '@/pages/welcome-sections/WelcomeSustainableDevelopment.vue'")
        ->toContain('<WelcomeHero')
        ->toContain('<WelcomeQuickActions')
        ->toContain('<WelcomeNews')
        ->toContain('<WelcomeAtAGlance')
        ->toContain('<WelcomeCampuses')
        ->toContain('<WelcomeSustainableDevelopment')
        ->toContain('<WelcomeJobs')
        ->toContain('<WelcomeBAC')
        ->not->toContain('<section')
        ->not->toContain('IntersectionObserver')
        ->not->toContain('setTimeout')
        ->not->toContain('academicTracks')
        ->not->toContain('governanceLinks');

    expect(strpos($welcomePage, '<WelcomeQuickActions'))
        ->toBeLessThan(strpos($welcomePage, '<WelcomeNews'))
        ->and(strpos($welcomePage, '<WelcomeNews'))
        ->toBeLessThan(strpos($welcomePage, '<WelcomeAtAGlance'))
        ->and(strpos($welcomePage, '<WelcomeAtAGlance'))
        ->toBeLessThan(strpos($welcomePage, '<WelcomeCampuses'))
        ->and(strpos($welcomePage, '<WelcomeCampuses'))
        ->toBeLessThan(strpos($welcomePage, '<WelcomeSustainableDevelopment'))
        ->and(strpos($welcomePage, '<WelcomeSustainableDevelopment'))
        ->toBeLessThan(strpos($welcomePage, '<WelcomeJobs'))
        ->and(strpos($welcomePage, '<WelcomeJobs'))
        ->toBeLessThan(strpos($welcomePage, '<WelcomeBAC'));
});

test('the default welcome hero links its bold tagline to the home route', function () {
    $heroSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeHero.vue',
    );
    $welcomeContent = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/welcome-content.ts',
    );
    $heroSource = $heroSection.$welcomeContent;

    expect($heroSection)
        ->toContain("import { Link } from '@inertiajs/vue3'")
        ->toContain("import { home } from '@/routes'")
        ->toContain(':href="home()"')
        ->toContain('font-bold')
        ->and($heroSource)
        ->toContain('Walk a journey of Excellence and Success')
        ->not->toContain(
            'We drive sustainable development through quality instruction',
        );
});

test('the welcome news section matches the high fidelity layout and retains announcements', function () {
    $newsSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeNews.vue',
    );

    expect($newsSection)
        ->toContain("import { index as announcementsIndex } from '@/routes/announcements'")
        ->toContain("import { show as newsShow } from '@/routes/news'")
        ->not->toContain('index as newsIndex')
        ->toContain(':href="newsShow(props.featuredNews.slug)"')
        ->toContain(':href="newsShow(item.slug)"')
        ->toContain(':href="announcementsIndex()"')
        ->not->toContain(':href="newsIndex()"')
        ->toContain('bg-white py-16 lg:py-20')
        ->toContain('class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"')
        ->toContain('class="mb-9 text-center"')
        ->toContain('bg-[#F2B900]')
        ->toContain('text-[#08045F]')
        ->toContain('text-[#4C4B8F]')
        ->toContain('lg:grid-cols-[minmax(0,0.86fr)_minmax(0,1fr)]')
        ->toContain('aspect-video')
        ->toContain('absolute top-3 left-3')
        ->toContain('line-clamp-4')
        ->toContain('mask-b-from-35%')
        ->toContain('mask-b-to-95%')
        ->toContain('props.pressReleases.slice(0, 5)')
        ->toContain('aria-label="Latest news"')
        ->toContain('grid-cols-[7.5rem_minmax(0,1fr)]')
        ->toContain('item.excerpt || item.office')
        ->not->toContain('View all news')
        ->toContain('class="mt-6 rounded-lg border border-[#D8DEE8] bg-white')
        ->toContain('sm:grid-cols-3')
        ->toContain('Featured news will appear here after a published news')
        ->toContain('Press releases will appear here after published')
        ->toContain('Announcements will appear here after published');

    $announcementTileClasses = 'rounded-lg border border-[#D8DEE8]';

    expect($newsSection)
        ->toContain($announcementTileClasses)
        ->and(strpos($newsSection, 'aria-labelledby="announcements-heading"'))
        ->toBeGreaterThan(strpos($newsSection, 'data-scroll-section="news-top"'));
});

test('the welcome quick action cards match the high fidelity layout', function () {
    $quickActionsSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeQuickActions.vue',
    );

    expect($quickActionsSection)
        ->toContain('bg-[#EEF2FF]')
        ->toContain('max-w-[53rem]')
        ->toContain('py-9')
        ->toContain('gap-7')
        ->toContain('md:grid-cols-3')
        ->toContain('min-h-38')
        ->toContain('bg-linear-to-br')
        ->toContain('from-[#2214C9]')
        ->toContain('from-[#2617E6]')
        ->toContain('rounded-full bg-white/12')
        ->toContain('text-[#F2B900]')
        ->toContain('View Details');
});

test('the welcome page types are exported from the type barrel', function () {
    $typeIndex = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/types/index.ts',
    );

    expect($typeIndex)->toContain("export * from './welcome';");
});

test('the welcome behavior is isolated in composables', function () {
    $welcomePage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/Welcome.vue',
    );
    $heroCarousel = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/composables/useHeroCarousel.ts',
    );
    $sectionReveal = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/composables/useSectionReveal.ts',
    );

    expect($welcomePage)
        ->toContain('} = useHeroCarousel({')
        ->toContain('slides: heroSlides')
        ->toContain('fallbackSlide: fallbackHeroSlide')
        ->toContain(':hero-slides="heroSlides"')
        ->toContain(':active-hero-index="activeHeroIndex"')
        ->toContain(':active-hero-slide="activeHeroSlide"')
        ->toContain(':is-default-hero-slide="isDefaultHeroSlide"')
        ->toContain(':has-multiple-hero-slides="hasMultipleHeroSlides"')
        ->toContain(':select-hero-slide="selectHeroSlide"')
        ->toContain(
            ':show-next-hero-slide-manually="showNextHeroSlideManually"',
        )
        ->toContain(
            ':show-previous-hero-slide-manually="showPreviousHeroSlideManually"',
        )
        ->toContain(':handle-video-ended="handleVideoEnded"')
        ->toContain('@mouseenter="pauseHeroCarousel"')
        ->toContain('@mouseleave="resumeHeroCarousel"')
        ->and($heroCarousel)
        ->toContain('(index + slideCount) % slideCount')
        ->toContain('const duration = isDefaultHeroSlide.value ? 0 : 6500')
        ->toContain("'(prefers-reduced-motion: reduce)'")
        ->toContain('if (!shouldAutoRotateHero)')
        ->toContain('videoEndedWhileHovering')
        ->and($sectionReveal)
        ->toContain('new IntersectionObserver')
        ->toContain("'[data-scroll-section]'")
        ->toContain("'(prefers-reduced-motion: reduce)'")
        ->toContain('revealObserver?.disconnect()');
});
