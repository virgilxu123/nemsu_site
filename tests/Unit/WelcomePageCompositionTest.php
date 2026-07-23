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
        ->toContain("import WelcomeCampuses from '@/pages/welcome-sections/WelcomeCampuses.vue'")
        ->toContain("import WelcomeJobsAndBAC from '@/pages/welcome-sections/WelcomeJobsAndBAC.vue'")
        ->toContain("import WelcomeSustainableDevelopment from '@/pages/welcome-sections/WelcomeSustainableDevelopment.vue'")
        ->toContain('<WelcomeHero')
        ->toContain('<WelcomeQuickActions')
        ->toContain('<WelcomeNews')
        ->toContain('<WelcomeAtAGlance')
        ->toContain('<WelcomeCampuses')
        ->toContain('<WelcomeSustainableDevelopment')
        ->toContain('<WelcomeJobsAndBAC')
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
        ->toBeLessThan(strpos($welcomePage, '<WelcomeJobsAndBAC'));
});

test('the welcome news section owns typed routes and empty states', function () {
    $newsSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeNews.vue',
    );

    expect($newsSection)
        ->toContain("import { index as announcementsIndex } from '@/routes/announcements'")
        ->toContain("import { index as newsIndex, show as newsShow } from '@/routes/news'")
        ->toContain(':href="newsShow(props.featuredNews.slug)"')
        ->toContain(':href="newsShow(item.slug)"')
        ->toContain(':href="newsIndex()"')
        ->toContain(':href="announcementsIndex()"')
        ->toContain('bg-[#F8FAFC]')
        ->toContain('py-16 lg:py-20')
        ->toContain('class="mb-9 text-center"')
        ->toContain('bg-[#F2B900]')
        ->toContain('lg:grid-cols-2')
        ->toContain('lg:grid-rows-[1fr_auto]')
        ->toContain('aspect-video')
        ->toContain('sm:grid-cols-3')
        ->toContain('Featured news will appear here after a published news')
        ->toContain('Press releases will appear here after published')
        ->toContain('Announcements will appear here after published');

    $cardClasses = 'rounded-lg border border-[#D8DEE8] bg-white';
    $cardHeaderRowClasses =
        'class="flex min-h-11 items-center justify-between gap-4"';
    $featuredHeadingClasses =
        'text-sm font-bold tracking-wide text-[#334155] uppercase dark:text-slate-300';
    $secondaryHeadingClasses =
        'text-sm font-bold tracking-wide text-[#1A2340] uppercase dark:text-white';
    $announcementTileClasses = 'rounded-lg border border-[#D8DEE8]';

    expect(substr_count($newsSection, $cardClasses))
        ->toBe(3)
        ->and(substr_count($newsSection, $cardHeaderRowClasses))
        ->toBe(3)
        ->and(substr_count($newsSection, $featuredHeadingClasses))
        ->toBe(1)
        ->and(substr_count($newsSection, $secondaryHeadingClasses))
        ->toBe(2)
        ->and($newsSection)
        ->toContain($announcementTileClasses);
});

test('the welcome quick action cards use the brand colors and low-fi layout', function () {
    $quickActionsSection = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeQuickActions.vue',
    );

    expect($quickActionsSection)
        ->toContain('bg-[#1c0ed7]')
        ->toContain('hover:bg-[#160BB2]')
        ->toContain('py-6')
        ->toContain('gap-4')
        ->toContain('md:grid-cols-3')
        ->toContain('md:flex-row')
        ->not->toContain('border-b');
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
