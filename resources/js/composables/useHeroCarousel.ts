import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import type { ComputedRef, Ref } from 'vue';

import type { BannerItem } from '@/types';

type UseHeroCarouselOptions = {
    slides: ComputedRef<BannerItem[]>;
    fallbackSlide: BannerItem;
};

type UseHeroCarouselReturn = {
    activeHeroIndex: Ref<number>;
    activeHeroSlide: ComputedRef<BannerItem>;
    hasMultipleHeroSlides: ComputedRef<boolean>;
    isDefaultHeroSlide: ComputedRef<boolean>;
    selectHeroSlide: (index: number) => void;
    showNextHeroSlideManually: () => void;
    showPreviousHeroSlideManually: () => void;
    pauseHeroCarousel: () => void;
    resumeHeroCarousel: () => void;
    handleVideoEnded: () => void;
};

export function useHeroCarousel({
    slides,
    fallbackSlide,
}: UseHeroCarouselOptions): UseHeroCarouselReturn {
    const activeHeroIndex = ref(0);
    let heroCarouselTimer: ReturnType<typeof window.setTimeout> | null = null;
    let shouldAutoRotateHero = false;
    let isHoveringHero = false;
    let videoEndedWhileHovering = false;

    const activeHeroSlide = computed<BannerItem>(
        () => slides.value[activeHeroIndex.value] ?? fallbackSlide,
    );
    const hasMultipleHeroSlides = computed(() => slides.value.length > 1);
    const isDefaultHeroSlide = computed(
        () => activeHeroSlide.value.id === fallbackSlide.id,
    );

    const setHeroSlide = (index: number): void => {
        const slideCount = slides.value.length;

        if (slideCount === 0) {
            activeHeroIndex.value = 0;

            return;
        }

        activeHeroIndex.value = (index + slideCount) % slideCount;
    };

    const stopHeroCarousel = (): void => {
        if (heroCarouselTimer === null) {
            return;
        }

        window.clearTimeout(heroCarouselTimer);
        heroCarouselTimer = null;
    };

    const showNextHeroSlide = (): void => {
        videoEndedWhileHovering = false;
        setHeroSlide(activeHeroIndex.value + 1);
        resetHeroCarousel();
    };

    const startHeroCarousel = (): void => {
        if (
            !shouldAutoRotateHero ||
            !hasMultipleHeroSlides.value ||
            heroCarouselTimer !== null ||
            isHoveringHero
        ) {
            return;
        }

        const duration = isDefaultHeroSlide.value ? 0 : 6500;

        if (duration > 0) {
            heroCarouselTimer = window.setTimeout(showNextHeroSlide, duration);
        }
    };

    const resetHeroCarousel = (): void => {
        stopHeroCarousel();
        startHeroCarousel();
    };

    const showPreviousHeroSlide = (): void => {
        videoEndedWhileHovering = false;
        setHeroSlide(activeHeroIndex.value - 1);
        resetHeroCarousel();
    };

    const selectHeroSlide = (index: number): void => {
        videoEndedWhileHovering = false;
        setHeroSlide(index);
        resetHeroCarousel();
    };

    const pauseHeroCarousel = (): void => {
        isHoveringHero = true;
        stopHeroCarousel();
    };

    const handleVideoEnded = (): void => {
        if (!shouldAutoRotateHero) {
            return;
        }

        if (isHoveringHero) {
            videoEndedWhileHovering = true;
        } else {
            showNextHeroSlide();
        }
    };

    const resumeHeroCarousel = (): void => {
        isHoveringHero = false;

        if (videoEndedWhileHovering) {
            videoEndedWhileHovering = false;
            showNextHeroSlide();
        } else {
            startHeroCarousel();
        }
    };

    onMounted(() => {
        shouldAutoRotateHero = !window.matchMedia(
            '(prefers-reduced-motion: reduce)',
        ).matches;

        startHeroCarousel();
    });

    onBeforeUnmount(() => {
        stopHeroCarousel();
    });

    return {
        activeHeroIndex,
        activeHeroSlide,
        hasMultipleHeroSlides,
        isDefaultHeroSlide,
        selectHeroSlide,
        showNextHeroSlideManually: showNextHeroSlide,
        showPreviousHeroSlideManually: showPreviousHeroSlide,
        pauseHeroCarousel,
        resumeHeroCarousel,
        handleVideoEnded,
    };
}
