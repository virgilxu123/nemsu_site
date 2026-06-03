<script setup lang="ts">
import { ArrowRight, Building2, MapPin, Navigation } from 'lucide-vue-next';
import { ref, onMounted, onUnmounted } from 'vue';
import type { CSSProperties } from 'vue';

type Campus = { name: string; focus: string; detail: string; location: string };
type CampusPhoto = { primary: string; secondary: string };
type RevealDirection = 'down' | 'left' | 'right' | 'up';

const props = withDefaults(
    defineProps<{
        campuses: Campus[];
        backgroundStyle: CSSProperties;
        staggerDelay: (section: string, index: number) => CSSProperties;
        revealClasses: (section: string, direction?: RevealDirection) => string;
    }>(),
    {},
);

const stats = ref({
    population: 0,
    faculty: 0,
    graduates: 0,
    campuses: 0,
});

const campusPhotos: CampusPhoto[] = [
    {
        primary: 'https://nemsu.edu.ph/files/News/cm-00.jpg',
        secondary:
            'https://www.nemsu.edu.ph/files/News/reaffirmation-commitment-to-innovation-and-sustainable-development-01.jpg',
    },
    {
        primary: 'https://www.nemsu.edu.ph/files/Banner/RM-Top-3-banner.jpg',
        secondary: 'https://nemsu.edu.ph/files/News/REA-00.jpg',
    },
    {
        primary: 'https://www.nemsu.edu.ph/files/Banner/BannerCOL-Passer.jpg',
        secondary: 'https://nemsu.edu.ph/files/News/cm-00.jpg',
    },
    {
        primary:
            'https://www.nemsu.edu.ph/files/News/reaffirmation-commitment-to-innovation-and-sustainable-development-01.jpg',
        secondary: 'https://www.nemsu.edu.ph/files/Banner/RM-Top-3-banner.jpg',
    },
];

const photoForCampus = (index: number): CampusPhoto =>
    campusPhotos[index % campusPhotos.length];

const statsRef = ref<HTMLElement | null>(null);
let observer: IntersectionObserver | null = null;

const animateValue = (target: number, key: keyof typeof stats.value, duration: number) => {
    const startTime = performance.now();

    const update = (currentTime: number) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const easeOut = 1 - Math.pow(1 - progress, 3); // ease-out cubic
        stats.value[key] = Math.floor(easeOut * target);

        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            stats.value[key] = target;
        }
    };
    requestAnimationFrame(update);
};

onMounted(() => {
    observer = new IntersectionObserver(
        (entries) => {
            if (entries[0].isIntersecting) {
                // Dummy values for demonstration
                animateValue(32768, 'population', 2500);
                animateValue(850, 'faculty', 2500);
                animateValue(3200, 'graduates', 2500);
                animateValue(props.campuses.length, 'campuses', 2500);
            } else {
                // Reset stats when out of view so it animates again on next reveal
                stats.value.population = 0;
                stats.value.faculty = 0;
                stats.value.graduates = 0;
                stats.value.campuses = 0;
            }
        },
        { threshold: 0.1 }
    );

    if (statsRef.value) {
        observer.observe(statsRef.value);
    }
});

onUnmounted(() => {
    if (observer) {
        observer.disconnect();
    }
});
</script>

<template>
    <section
        id="campuses"
        data-scroll-section="campuses"
        class="bg-[#1711d4] bg-cover bg-center bg-no-repeat text-white lg:bg-fixed"
        :style="backgroundStyle"
    >
        <div
            :class="revealClasses('campuses', 'left')"
            class="mx-auto grid w-[80%] gap-8 px-4 py-16 sm:px-6 lg:grid-cols-[30%_minmax(0,1fr)] lg:gap-10 lg:px-0 lg:py-0"
        >
            <div
                class="relative isolate overflow-hidden rounded-md border border-white/15 bg-[#061b49]/70 p-6 shadow-2xl shadow-black/20 backdrop-blur-sm sm:p-8 lg:sticky lg:top-[7.5rem] lg:flex lg:h-[80svh] lg:flex-col lg:justify-between lg:rounded-none lg:border-y-0 lg:border-l-0"
            >
                <div
                    class="absolute inset-0 -z-10 bg-linear-to-b from-[#061b49]/95 via-[#061b49]/82 to-[#061b49]/70"
                ></div>

                <div>
                    <span
                        class="inline-flex size-14 items-center justify-center rounded-md border border-white/20 bg-white/10 text-[#f2b705] backdrop-blur"
                    >
                        <Building2 class="size-7" aria-hidden="true" />
                    </span>
                    <p
                        class="mt-8 text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                    >
                        Campuses
                    </p>
                    <h2
                        class="mt-3 max-w-xl text-3xl font-semibold tracking-normal"
                    >
                        One NEMSU system, distinct campus strengths
                    </h2>
                    <p class="mt-5 max-w-md text-sm leading-7 text-sky-100">
                        A quick system view for the campus pages: population,
                        faculty and staff profile, graduates, and location map.
                    </p>
                </div>

                <div ref="statsRef" class="mt-8 grid grid-cols-2 gap-4">
                    <div class="border-t border-white/20 pt-4">
                        <p class="text-2xl font-semibold">{{ stats.population.toLocaleString() }}</p>
                        <p class="mt-1 text-sm text-sky-100">Student Population</p>
                    </div>
                    <div class="border-t border-white/20 pt-4">
                        <p class="text-2xl font-semibold">{{ stats.faculty.toLocaleString() }}</p>
                        <p class="mt-1 text-sm text-sky-100">Faculty and Staff</p>
                    </div>
                    <div class="border-t border-white/20 pt-4">
                        <p class="text-2xl font-semibold">{{ stats.graduates.toLocaleString() }}</p>
                        <p class="mt-1 text-sm text-sky-100">Graduates</p>
                    </div>
                    <div class="border-t border-white/20 pt-4">
                        <p class="text-2xl font-semibold">
                            {{ stats.campuses }}
                        </p>
                        <p class="mt-1 text-sm text-sky-100">Campuses</p>
                    </div>
                </div>

                <a
                    href="#services"
                    class="mt-8 inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-white/25 bg-white/10 px-5 text-sm font-semibold text-white transition hover:bg-white/[0.16]"
                >
                    Campus services
                    <ArrowRight class="size-4" aria-hidden="true" />
                </a>
            </div>

            <div
                class="grid gap-4 lg:py-16 lg:pr-8"
                aria-label="NEMSU campuses"
            >
                <article
                    v-for="(campus, index) in campuses"
                    :key="campus.name"
                    :data-scroll-section="`campus-row-${index}`"
                    :class="[
                        'group grid min-h-64 gap-6 rounded-md border border-white/15 bg-white/[0.08] p-5 backdrop-blur hover:border-[#f2b705]/45 hover:bg-white/[0.12] sm:p-6 xl:grid-cols-[minmax(19rem,0.9fr)_1fr]',
                        revealClasses(`campus-row-${index}`, 'up')
                    ]"
                >
                    <div
                        class="relative isolate min-h-[19rem] overflow-hidden rounded bg-white/[0.08] sm:min-h-[21rem]"
                    >
                        <div
                            class="absolute top-0 right-0 h-[72%] w-[88%] overflow-hidden rounded bg-slate-900 shadow-2xl shadow-black/25"
                        >
                            <img
                                :src="photoForCampus(index).primary"
                                :alt="`${campus.name} campus photo`"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                            />
                            <div
                                class="absolute inset-0 bg-linear-to-t from-slate-950/40 via-transparent to-transparent"
                            ></div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 h-[55%] w-[62%] overflow-hidden rounded border-4 border-[#061b49] bg-slate-900 shadow-2xl shadow-black/30"
                        >
                            <img
                                :src="photoForCampus(index).secondary"
                                :alt="`${campus.name} campus life photo`"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.05]"
                            />
                        </div>

                        <div
                            class="absolute right-4 bottom-4 rounded bg-[#061b49]/90 px-3 py-2 text-white shadow-lg shadow-black/25 backdrop-blur"
                        >
                            <p class="text-xs font-semibold uppercase">
                                Campus {{ String(index + 1).padStart(2, '0') }}
                            </p>
                            <p class="mt-0.5 text-sm font-semibold">
                                {{ campus.name }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 flex-col justify-between gap-6">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded bg-white/10 px-2.5 py-1 text-xs font-semibold text-[#f2b705]"
                                >
                                    <MapPin
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    {{ campus.location }}
                                </span>
                                <span
                                    class="inline-flex items-center gap-1.5 rounded bg-white/10 px-2.5 py-1 text-xs font-semibold text-white/80"
                                >
                                    <Navigation
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    NEMSU System
                                </span>
                            </div>
                            <h3 class="mt-4 font-semibold text-white">
                                {{ campus.focus }}
                            </h3>
                            <p class="mt-3 text-sm leading-7 text-sky-100">
                                {{ campus.detail }}
                            </p>
                        </div>

                        <div
                            class="grid gap-3 border-t border-white/10 pt-4 text-sm text-sky-100 sm:grid-cols-3"
                        >
                            <span>Population</span>
                            <span>Personnel</span>
                            <span>Graduates</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
