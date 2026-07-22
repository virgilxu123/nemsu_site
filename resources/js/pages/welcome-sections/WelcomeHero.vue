<script setup lang="ts">
import {
    ArrowRight,
    ChevronLeft,
    ChevronRight,
    Sparkles,
} from 'lucide-vue-next';
import { ref, watch } from 'vue';

type BannerItem = {
    id: number | string;
    title?: string | null;
    summary?: string | null;
    imageUrl: string;
    link?: string | null;
};
type Metric = { label: string; value: string; note: string };

const props = withDefaults(
    defineProps<{
        heroSlides: BannerItem[];
        activeHeroIndex: number | null;
        activeHeroSlide: BannerItem;
        isDefaultHeroSlide: boolean;
        hasMultipleHeroSlides: boolean;
        metrics: Metric[];
        fallbackHeroSlide: BannerItem;
        revealClasses: (section: string) => string;
        selectHeroSlide: (index: number) => void;
        showNextHeroSlideManually: () => void;
        showPreviousHeroSlideManually: () => void;
        handleVideoEnded?: () => void;
    }>(),
    {},
);

const videoRefs = ref<Record<number, HTMLVideoElement>>({});

const setVideoRef = (el: any, index: number) => {
    if (el) {
        videoRefs.value[index] = el as HTMLVideoElement;
    }
};

watch(
    () => props.activeHeroIndex,
    (newIndex) => {
        Object.entries(videoRefs.value).forEach(([key, video]) => {
            const index = Number(key);
            if (index === newIndex) {
                video.currentTime = 0;
                video.play().catch(() => {});
            } else {
                video.pause();
            }
        });
    },
    { immediate: true }
);
</script>

<template>
    <section
        data-scroll-section="hero"
        class="relative min-h-[calc(100svh-7.5rem)] overflow-hidden bg-slate-950 text-white"
    >
        <template v-for="(slide, index) in heroSlides" :key="slide.id">
            <video
                v-if="slide.imageUrl.toLowerCase().endsWith('.mp4')"
                :ref="(el) => setVideoRef(el, index)"
                :src="slide.imageUrl"
                autoplay
                muted
                playsinline
                @ended="handleVideoEnded ? handleVideoEnded() : showNextHeroSlideManually()"
                class="absolute inset-0 h-full w-full bg-slate-950 transition-all duration-1000 ease-out motion-reduce:transition-none"
                :class="[
                    slide.id === fallbackHeroSlide.id
                        ? 'object-cover object-center'
                        : 'object-contain object-center',
                    index === activeHeroIndex
                        ? 'scale-100 opacity-100'
                        : 'scale-[1.015] opacity-0',
                ]"
            ></video>
            <img
                v-else
                :src="slide.imageUrl"
                :alt="slide.title || 'NEMSU banner'"
                class="absolute inset-0 h-full w-full bg-slate-950 transition-all duration-1000 ease-out motion-reduce:transition-none"
                :class="[
                    slide.id === fallbackHeroSlide.id
                        ? 'object-cover object-center'
                        : 'object-contain object-center',
                    index === activeHeroIndex
                        ? 'scale-100 opacity-100'
                        : 'scale-[1.015] opacity-0',
                ]"
            />
        </template>
        <div
            class="absolute inset-0 transition duration-700"
            :class="
                isDefaultHeroSlide
                    ? 'bg-linear-to-r from-[#080565]/96 via-[#080565]/60 to-[#120da9]/20'
                    : 'bg-linear-to-r from-[#120da9]/18 via-[#120da9]/5 to-[#120da9]/10'
            "
        ></div>
        <div
            class="absolute inset-x-0 bottom-0 h-36 bg-linear-to-t from-black/55 to-transparent"
        ></div>

        <div
            v-if="isDefaultHeroSlide"
            :class="revealClasses('hero')"
            class="relative mx-auto grid min-h-[calc(100svh-7.5rem)] max-w-7xl content-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8"
        >
            <div class="max-w-3xl">
                <!-- <p
                    class="inline-flex items-center gap-2 rounded-md border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold tracking-wide text-sky-100 uppercase"
                >
                    <Sparkles class="size-4" aria-hidden="true" />
                    Research University for Sustainable Development
                </p> -->
                <h2
                    class="mt-6 text-4xl font-semibold tracking-normal text-balance sm:text-5xl lg:text-6xl"
                >
                    {{
                        fallbackHeroSlide.title ||
                        'North Eastern Mindanao State University'
                    }}
                </h2>
                <p
                    class="mt-6 max-w-2xl text-base leading-8 text-sky-50 sm:text-lg"
                >
                    {{
                        fallbackHeroSlide.summary ||
                        'We drive sustainable development through quality instruction, innovative research, community collaboration, and technological advancement.'
                    }}
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a
                        href="#academics"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-md border border-white/25 bg-white/10 px-5 text-sm font-semibold text-white transition hover:bg-white/[0.18]"
                    >
                        Explore Programs
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </a>
                    <a
                        href="#services"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-md border border-white/25 px-5 text-sm font-semibold text-white transition hover:bg-white/10"
                    >
                        Online Services
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </a>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div
                        v-for="metric in metrics"
                        :key="metric.label"
                        class="border-t border-white/20 pt-4"
                    >
                        <p class="text-3xl font-semibold text-white">
                            {{ metric.value }}
                        </p>
                        <p class="mt-1 text-sm font-medium text-sky-100">
                            {{ metric.label }}
                        </p>
                        <p class="mt-1 text-xs text-sky-200">
                            {{ metric.note }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <a
            v-else-if="activeHeroSlide.link"
            :href="activeHeroSlide.link"
            target="_blank"
            rel="noopener"
            class="absolute inset-0 z-[5]"
            :aria-label="activeHeroSlide.title || 'Open banner link'"
        ></a>

        <div
            v-if="hasMultipleHeroSlides"
            class="absolute right-4 bottom-5 left-4 z-20 mx-auto flex max-w-7xl justify-center px-0 sm:right-6 sm:left-6 lg:px-8"
        >
            <div class="flex items-center gap-2">
                <button
                    v-for="(slide, index) in heroSlides"
                    :key="`hero-dot-${slide.id}`"
                    type="button"
                    class="h-2.5 rounded-full transition-all"
                    :class="
                        index === activeHeroIndex
                            ? 'w-9 bg-[#f2b705]'
                            : 'w-2.5 bg-white/45 hover:bg-white/75'
                    "
                    :aria-label="`Show banner ${index + 1}`"
                    :aria-current="
                        index === activeHeroIndex ? 'true' : undefined
                    "
                    @click="selectHeroSlide(index)"
                ></button>
            </div>
        </div>

        <button
            v-if="hasMultipleHeroSlides"
            type="button"
            class="absolute top-1/2 left-3 z-20 inline-flex size-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-black/25 text-white shadow-2xl shadow-slate-950/35 backdrop-blur-xl transition duration-300 hover:scale-105 hover:border-[#f2b705]/60 hover:bg-black/40 focus-visible:ring-2 focus-visible:ring-[#f2b705] focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 sm:left-5 lg:left-8"
            aria-label="Previous banner"
            @click="showPreviousHeroSlideManually"
        >
            <ChevronLeft class="size-6" aria-hidden="true" />
        </button>

        <button
            v-if="hasMultipleHeroSlides"
            type="button"
            class="absolute top-1/2 right-3 z-20 inline-flex size-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-black/25 text-white shadow-2xl shadow-slate-950/35 backdrop-blur-xl transition duration-300 hover:scale-105 hover:border-[#f2b705]/60 hover:bg-black/40 focus-visible:ring-2 focus-visible:ring-[#f2b705] focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 sm:right-5 lg:right-8"
            aria-label="Next banner"
            @click="showNextHeroSlideManually"
        >
            <ChevronRight class="size-6" aria-hidden="true" />
        </button>
    </section>
</template>
