<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

import { useHeroCarousel } from '@/composables/useHeroCarousel';
import { useSectionReveal } from '@/composables/useSectionReveal';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import {
    campusBackgroundStyle,
    campuses,
    fallbackAtAGlanceMapHighlights,
    fallbackAtAGlanceStats,
    fallbackHeroSlide,
    metrics,
    quickActions,
} from '@/pages/welcome-sections/welcome-content';
import WelcomeAtAGlance from '@/pages/welcome-sections/WelcomeAtAGlance.vue';
import WelcomeCampuses from '@/pages/welcome-sections/WelcomeCampuses.vue';
import WelcomeHero from '@/pages/welcome-sections/WelcomeHero.vue';
import WelcomeNews from '@/pages/welcome-sections/WelcomeNews.vue';
import WelcomeQuickActions from '@/pages/welcome-sections/WelcomeQuickActions.vue';
import type {
    BannerItem,
    GlanceStat,
    MapHighlight,
    WelcomePageProps,
} from '@/types';

const props = withDefaults(defineProps<WelcomePageProps>(), {
    banners: () => [],
    featuredNews: null,
    pressReleases: () => [],
    announcements: () => [],
    atAGlanceStats: () => [],
    atAGlanceMapHighlights: () => [],
});

const { revealClasses, staggerDelay } = useSectionReveal();

const heroSlides = computed<BannerItem[]>(() => [
    fallbackHeroSlide,
    ...props.banners,
]);

const {
    activeHeroIndex,
    activeHeroSlide,
    hasMultipleHeroSlides,
    isDefaultHeroSlide,
    selectHeroSlide,
    showNextHeroSlideManually,
    showPreviousHeroSlideManually,
    pauseHeroCarousel,
    resumeHeroCarousel,
    handleVideoEnded,
} = useHeroCarousel({
    slides: heroSlides,
    fallbackSlide: fallbackHeroSlide,
});

const atAGlanceStats = computed<GlanceStat[]>(() =>
    props.atAGlanceStats.length > 0
        ? props.atAGlanceStats
        : fallbackAtAGlanceStats,
);

const atAGlanceMapHighlights = computed<MapHighlight[]>(() =>
    props.atAGlanceMapHighlights.length > 0
        ? props.atAGlanceMapHighlights
        : fallbackAtAGlanceMapHighlights,
);
</script>

<template>
    <PublicSiteLayout>
        <Head title="North Eastern Mindanao State University" />

        <WelcomeHero
            :hero-slides="heroSlides"
            :active-hero-index="activeHeroIndex"
            :active-hero-slide="activeHeroSlide"
            :is-default-hero-slide="isDefaultHeroSlide"
            :has-multiple-hero-slides="hasMultipleHeroSlides"
            :metrics="metrics"
            :fallback-hero-slide="fallbackHeroSlide"
            :reveal-classes="revealClasses"
            :select-hero-slide="selectHeroSlide"
            :show-next-hero-slide-manually="showNextHeroSlideManually"
            :show-previous-hero-slide-manually="showPreviousHeroSlideManually"
            :handle-video-ended="handleVideoEnded"
            @mouseenter="pauseHeroCarousel"
            @mouseleave="resumeHeroCarousel"
        />

        <WelcomeQuickActions
            :actions="quickActions"
            :reveal-classes="revealClasses"
            :stagger-delay="staggerDelay"
        />

        <WelcomeNews
            :featured-news="props.featuredNews"
            :press-releases="props.pressReleases"
            :announcements="props.announcements"
            :reveal-classes="revealClasses"
        />

        <WelcomeAtAGlance
            :stats="atAGlanceStats"
            :map-highlights="atAGlanceMapHighlights"
            :stagger-delay="staggerDelay"
            :reveal-classes="revealClasses"
        />

        <WelcomeCampuses
            :campuses="campuses"
            :background-style="campusBackgroundStyle"
            :stagger-delay="staggerDelay"
            :reveal-classes="revealClasses"
        />

        <!-- Sustainable Development Goal -->

        <!-- Job and Opportunities | BAC Matters -->
    </PublicSiteLayout>
</template>
