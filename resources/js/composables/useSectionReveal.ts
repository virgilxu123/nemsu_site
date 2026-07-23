import { onBeforeUnmount, onMounted, ref } from 'vue';

import type { RevealClasses, RevealDirection, StaggerDelay } from '@/types';

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

export function useSectionReveal(): {
    revealClasses: RevealClasses;
    staggerDelay: StaggerDelay;
} {
    const visibleSections = ref<Set<string>>(new Set(['hero']));
    let revealObserver: IntersectionObserver | null = null;

    const setSectionVisibility = (
        section: string,
        isVisible: boolean,
    ): void => {
        const nextVisibleSections = new Set(visibleSections.value);

        if (isVisible) {
            nextVisibleSections.add(section);
        } else {
            nextVisibleSections.delete(section);
        }

        visibleSections.value = nextVisibleSections;
    };

    const revealClasses: RevealClasses = (section, direction = 'up'): string =>
        [
            'transition-all duration-700 ease-out will-change-transform motion-reduce:translate-x-0 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:blur-0 motion-reduce:transition-none',
            visibleSections.value.has(section)
                ? 'translate-x-0 translate-y-0 opacity-100 blur-0'
                : `${revealOffset[direction]} opacity-0 blur-[2px]`,
        ].join(' ');

    const staggerDelay: StaggerDelay = (section, index) => ({
        transitionDelay: visibleSections.value.has(section)
            ? `${index * 80}ms`
            : '0ms',
    });

    onMounted(() => {
        const animatedSections = document.querySelectorAll<HTMLElement>(
            '[data-scroll-section]',
        );
        const prefersReducedMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)',
        ).matches;

        if (prefersReducedMotion) {
            visibleSections.value = new Set(
                Array.from(animatedSections)
                    .map((section) => section.dataset.scrollSection)
                    .filter(Boolean) as string[],
            );

            return;
        }

        revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    const section = entry.target.getAttribute(
                        'data-scroll-section',
                    );

                    if (section) {
                        setSectionVisibility(section, entry.isIntersecting);
                    }
                });
            },
            {
                rootMargin: '0px',
                threshold: 0.1,
            },
        );

        animatedSections.forEach((section) => {
            revealObserver?.observe(section);
        });
    });

    onBeforeUnmount(() => {
        revealObserver?.disconnect();
    });

    return {
        revealClasses,
        staggerDelay,
    };
}
