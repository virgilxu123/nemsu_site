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
        class="bg-[#1C0ED7] bg-[linear-gradient(90deg,#0B075F_0%,#160BB2_48%,#1C0ED7_100%)] py-16 text-white lg:py-20"
    >
        <div
            data-scroll-section="campuses"
            :class="revealClasses('campuses', 'up')"
            class="mx-auto max-w-[90rem] px-4 sm:px-6 lg:px-8"
        >
            <header class="mb-9 text-center">
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
                    class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-white/80 sm:text-base"
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
                class="flex snap-x snap-mandatory [scrollbar-width:none] overflow-x-auto overscroll-x-contain [&::-webkit-scrollbar]:hidden"
                @scroll.passive="syncActivePage"
            >
                <Link
                    v-for="(campus, index) in campuses"
                    :key="campus.slug"
                    data-campus-card
                    :href="campusShow(campus.slug)"
                    :aria-label="`Explore ${campus.name} Campus`"
                    class="group relative isolate aspect-5/4 w-full shrink-0 snap-start overflow-hidden ring-1 ring-white/15 ring-inset focus-visible:z-10 focus-visible:outline-2 focus-visible:outline-offset-[-3px] focus-visible:outline-[#F2B900] sm:w-1/2 lg:w-1/4"
                >
                    <img
                        :src="photoForCampus(index)"
                        :alt="`${campus.name} Campus`"
                        class="absolute inset-0 -z-20 size-full object-cover transition duration-500 group-hover:scale-[1.04]"
                        loading="lazy"
                        draggable="false"
                    />
                    <span
                        class="absolute inset-0 -z-10 bg-linear-to-t from-black/55 via-[#0B075F]/18 to-transparent"
                        aria-hidden="true"
                    ></span>

                    <div
                        class="absolute inset-0 flex flex-col justify-end p-5 text-shadow-black/50 text-shadow-sm sm:p-6"
                    >
                        <h3
                            class="font-serif text-2xl leading-tight font-semibold text-white"
                        >
                            {{ campus.name }} Campus
                        </h3>
                        <p class="mt-0.5 text-sm leading-6 text-white/80">
                            {{ campus.focus }}
                        </p>
                        <span
                            class="inline-flex items-center gap-2 pt-2 text-sm font-semibold text-[#F2B900] transition-colors group-hover:text-yellow-300"
                        >
                            Explore campus
                            <ArrowRight class="size-4" aria-hidden="true" />
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
