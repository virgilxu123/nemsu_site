<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';

import { show as campusShow } from '@/routes/campuses';
import type { Campus, RevealClasses } from '@/types';

const props = defineProps<{
    campuses: Campus[];
    revealClasses: RevealClasses;
}>();

const campusPhotos = [
    '/storage/images/campuses/tandag/6I3A5798.JPG',
    'https://www.nemsu.edu.ph/files/Banner/RM-Top-3-banner.jpg',
    'https://www.nemsu.edu.ph/files/Banner/BannerCOL-Passer.jpg',
    'https://www.nemsu.edu.ph/files/News/reaffirmation-commitment-to-innovation-and-sustainable-development-01.jpg',
];

const photoForCampus = (index: number): string =>
    campusPhotos[index % campusPhotos.length];

const carouselRef = ref<HTMLElement | null>(null);
const activePage = ref(0);
const pageCount = ref(1);
const itemsPerPage = ref(1);

let carouselItemStep = 0;
let prefersReducedMotion = false;
let resizeObserver: ResizeObserver | null = null;

const syncActivePage = (): void => {
    const carousel = carouselRef.value;

    if (!carousel || carouselItemStep === 0) {
        activePage.value = 0;

        return;
    }

    const pageWidth = carouselItemStep * itemsPerPage.value;
    const page = Math.round(carousel.scrollLeft / pageWidth);

    activePage.value = Math.min(Math.max(page, 0), pageCount.value - 1);
};

const updateCarouselMetrics = (): void => {
    const carousel = carouselRef.value;
    const firstCard =
        carousel?.querySelector<HTMLElement>('[data-campus-card]');

    if (!carousel || !firstCard || carousel.clientWidth === 0) {
        return;
    }

    const styles = window.getComputedStyle(carousel);
    const gap = Number.parseFloat(styles.columnGap || styles.gap) || 0;

    carouselItemStep = firstCard.offsetWidth + gap;
    itemsPerPage.value = Math.max(
        1,
        Math.round((carousel.clientWidth + gap) / carouselItemStep),
    );
    pageCount.value = Math.max(
        1,
        Math.ceil(props.campuses.length / itemsPerPage.value),
    );

    syncActivePage();
};

const scrollToPage = (page: number): void => {
    const carousel = carouselRef.value;

    if (!carousel || carouselItemStep === 0) {
        return;
    }

    const targetPage = Math.min(Math.max(page, 0), pageCount.value - 1);
    const targetItem = targetPage * itemsPerPage.value;
    const maximumScrollLeft = carousel.scrollWidth - carousel.clientWidth;
    const targetLeft = Math.min(
        targetItem * carouselItemStep,
        maximumScrollLeft,
    );

    carousel.scrollTo({
        left: targetLeft,
        behavior: prefersReducedMotion ? 'auto' : 'smooth',
    });
};

const showPreviousPage = (): void => {
    scrollToPage(activePage.value - 1);
};

const showNextPage = (): void => {
    scrollToPage(activePage.value + 1);
};

onMounted(() => {
    prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;
    resizeObserver = new ResizeObserver(updateCarouselMetrics);

    if (carouselRef.value) {
        resizeObserver.observe(carouselRef.value);
    }

    updateCarouselMetrics();
});

onBeforeUnmount(() => {
    resizeObserver?.disconnect();
});
</script>

<template>
    <section
        id="campuses"
        tabindex="-1"
        class="relative isolate overflow-hidden bg-[#1C0ED7] py-16 text-white lg:py-20"
    >
        <div
            class="pointer-events-none absolute top-11 left-[12%] hidden size-20 sm:block"
            aria-hidden="true"
        >
            <span class="absolute top-0 left-0 size-16 rounded-full bg-white">
            </span>
            <div
                data-campus-dots="top"
                class="absolute top-7 left-7 grid grid-cols-4 gap-2"
            >
                <span
                    v-for="dot in 12"
                    :key="`top-dot-${dot}`"
                    class="size-1.5 rounded-full bg-[#F2B900]"
                ></span>
            </div>
        </div>
        <div
            data-campus-dots="bottom"
            class="pointer-events-none absolute right-[8%] bottom-10 hidden grid-cols-3 gap-2 sm:grid"
            aria-hidden="true"
        >
            <span
                v-for="dot in 12"
                :key="`bottom-dot-${dot}`"
                class="size-1.5 rounded-full bg-[#F2B900]"
            ></span>
        </div>

        <div
            data-scroll-section="campuses"
            :class="revealClasses('campuses', 'up')"
            class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <header class="mx-auto mb-10 max-w-2xl text-center">
                <h2
                    class="font-serif text-3xl font-semibold tracking-tight text-white sm:text-4xl"
                >
                    Campuses
                </h2>
                <span
                    class="mx-auto mt-3 block h-1 w-16 rounded-full bg-[#F2B900]"
                    aria-hidden="true"
                ></span>
                <p
                    class="mt-4 text-sm leading-6 text-white/90 sm:text-base sm:leading-7"
                >
                    Discover NEMSU's seven campuses, each advancing accessible
                    education, innovation, and community service across Surigao
                    del Sur.
                </p>
            </header>

            <div
                id="campus-carousel"
                ref="carouselRef"
                role="region"
                aria-label="NEMSU campuses carousel"
                class="flex snap-x snap-mandatory [scrollbar-width:none] items-start gap-4 overflow-x-auto overscroll-x-contain pb-2 lg:overflow-visible lg:pb-8 [&::-webkit-scrollbar]:hidden"
                @scroll.passive="syncActivePage"
            >
                <Link
                    v-for="(campus, index) in campuses"
                    :key="campus.slug"
                    data-campus-card
                    :href="campusShow(campus.slug)"
                    :aria-label="`Explore ${campus.name} Campus`"
                    :class="index % 2 === 1 ? 'lg:translate-y-8' : ''"
                    class="group relative isolate aspect-[4/5] w-[72%] max-w-[18rem] shrink-0 snap-start overflow-hidden rounded-sm bg-[#08045F] shadow-[0_1rem_1.5rem_rgba(3,2,44,0.35)] ring-1 ring-white/10 transition-transform duration-300 ring-inset focus-visible:z-10 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#F2B900] sm:w-[42%] md:w-[30%] lg:aspect-[4/9] lg:w-auto lg:max-w-none lg:min-w-0 lg:grow lg:basis-0"
                >
                    <img
                        :src="photoForCampus(index)"
                        :alt="`${campus.name} Campus`"
                        class="absolute inset-x-0 top-0 -z-20 h-[68%] w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                        loading="lazy"
                        draggable="false"
                    />
                    <span
                        class="absolute inset-0 -z-10 bg-[linear-gradient(to_bottom,transparent_28%,rgba(8,4,95,0.35)_54%,#08045F_72%)]"
                        aria-hidden="true"
                    ></span>

                    <div
                        class="absolute inset-0 flex flex-col justify-end p-4 text-shadow-black/50 text-shadow-sm lg:p-3 xl:p-4"
                    >
                        <h3
                            class="font-serif text-base leading-tight font-semibold text-white xl:text-lg"
                        >
                            {{ campus.name }} Campus
                        </h3>
                        <p
                            class="mt-1 text-[0.65rem] leading-4 text-white/70 xl:text-xs"
                        >
                            {{ campus.focus }}
                        </p>
                        <span
                            class="mt-3 inline-flex min-h-8 w-fit items-center gap-2 rounded-md bg-white/10 px-3 py-1.5 text-[0.65rem] font-medium text-white ring-1 ring-white/10 transition-colors group-hover:bg-white/15 group-hover:text-[#F2B900]"
                        >
                            Explore
                            <ArrowRight class="size-3" aria-hidden="true" />
                        </span>
                    </div>
                </Link>
            </div>

            <div
                v-if="pageCount > 1"
                role="group"
                class="mt-7 flex items-center justify-center gap-3"
                aria-label="Campus carousel controls"
            >
                <button
                    type="button"
                    class="inline-flex size-11 items-center justify-center rounded-md border border-white/25 bg-white/10 text-white transition-colors hover:border-white/45 hover:bg-white/15 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2B900] disabled:cursor-not-allowed disabled:opacity-40"
                    :disabled="activePage === 0"
                    aria-label="Previous campuses"
                    aria-controls="campus-carousel"
                    @click="showPreviousPage"
                >
                    <ChevronLeft class="size-5" aria-hidden="true" />
                </button>

                <div
                    role="group"
                    class="flex items-center gap-1"
                    aria-label="Campus pages"
                >
                    <button
                        v-for="page in pageCount"
                        :key="page"
                        type="button"
                        class="inline-flex size-11 items-center justify-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2B900]"
                        :aria-label="`Show campus page ${page} of ${pageCount}`"
                        :aria-current="
                            page - 1 === activePage ? 'page' : undefined
                        "
                        aria-controls="campus-carousel"
                        @click="scrollToPage(page - 1)"
                    >
                        <span
                            :class="
                                page - 1 === activePage
                                    ? 'w-7 bg-[#F2B900]'
                                    : 'w-2.5 bg-white/40'
                            "
                            class="h-2.5 rounded-full transition-all"
                            aria-hidden="true"
                        ></span>
                    </button>
                </div>

                <button
                    type="button"
                    class="inline-flex size-11 items-center justify-center rounded-md border border-white/25 bg-white/10 text-white transition-colors hover:border-white/45 hover:bg-white/15 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2B900] disabled:cursor-not-allowed disabled:opacity-40"
                    :disabled="activePage === pageCount - 1"
                    aria-label="Next campuses"
                    aria-controls="campus-carousel"
                    @click="showNextPage"
                >
                    <ChevronRight class="size-5" aria-hidden="true" />
                </button>
            </div>
        </div>
    </section>
</template>
