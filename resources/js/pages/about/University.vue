<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { home } from '@/routes';

import {
    ChevronLeft,
    ChevronRight,
    Music2,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import PageHero from '@/components/PageHero.vue';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type HistoryItem = {
    year: string;
    title: string;
    description: string;
};

type HistorySlide = HistoryItem & {
    image: string;
    imageAlt: string;
};

type CoreValue = {
    title: string;
    description: string;
};

const sealImage = 'https://nemsu.edu.ph/assets/images/NEMSU.png';

const sealElements = [
    {
        title: 'Torch',
        image: '/storage/images/university-seal/Torch.png',
        meaning: 'Stands for guidance and enlightenment through knowledge.',
    },
    {
        title: 'Shield',
        image: '/storage/images/university-seal/Shield.png',
        meaning: 'Represents protection, academic freedom, and a safe, inclusive learning environment.',
    },
    {
        title: 'Book',
        image: '/storage/images/university-seal/Book.png',
        meaning: 'Represents the various fields of specialization offered by the university.',
    },
    {
        title: 'Outer Circle (Blue)',
        image: '/storage/images/university-seal/Circle blue.png',
        meaning: 'Symbolizes continuity and the continuous journey of learning.',
    },
    {
        title: 'Laurel',
        image: '/storage/images/university-seal/Laurel.png',
        meaning: 'Represents excellence, one of the core values of the institution.',
    },
    {
        title: '1982',
        image: '/storage/images/university-seal/1982.png',
        meaning: 'Marks the founding year and the university\'s growth from a polytechnic institution.',
    },
    {
        title: 'Surigao del Sur',
        image: '/storage/images/university-seal/Surigao del sur.png',
        meaning: 'Emphasizes NEMSU\'s presence as the sole SUC-HEI in the province.',
    },
    {
        title: 'Business',
        image: '/storage/images/university-seal/Business.png',
        meaning: 'Represents the College of Business and Accountancy and related fields.',
    },
    {
        title: 'Science',
        image: '/storage/images/university-seal/Science.png',
        meaning: 'Represents the College of Science and Mathematics and the pursuit of scientific knowledge.',
    },
    {
        title: 'Technology',
        image: '/storage/images/university-seal/Technology.png',
        meaning: 'Represents the College of Technology and engineering disciplines.',
    },
    {
        title: 'Farm',
        image: '/storage/images/university-seal/Farm.png',
        meaning: 'Represents agriculture and environmental stewardship as part of NEMSU\'s programs.',
    },
    {
        title: 'Inner Circle (White)',
        image: '/storage/images/university-seal/circle 1.png',
        meaning: 'Additional symbolic circle element representing unity and wholeness.',
    },
];
const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['university-hero']));
const activeHistorySlide = ref(0);
let revealObserver: IntersectionObserver | null = null;
let historySlideInterval: ReturnType<typeof setInterval> | null = null;

const historySlides: HistorySlide[] = [
    {
        year: '1982',
        title: 'The Tandag story begins',
        description:
            'A 153-student extension center planted the roots of today’s multi-campus University.',
        image: '/images/campuses/tandag/facilities/gallery/academic-building.webp',
        imageAlt: 'Academic building at NEMSU Tandag Campus',
    },
    {
        year: '1992',
        title: 'One growing academic system',
        description:
            'Campuses in Tandag, Cagwait, Tagbina, Lianga, and San Miguel came together under SSPC.',
        image: '/images/campuses/tandag/facilities/gallery/main-academic-complex.webp',
        imageAlt: 'Main academic complex at NEMSU Tandag Campus',
    },
    {
        year: '2010',
        title: 'A state university is born',
        description:
            'Republic Act No. 9998 converted the institution into Surigao del Sur State University.',
        image: '/images/campuses/tandag/facilities/gallery/administrative-building.webp',
        imageAlt: 'Administrative building at NEMSU Tandag Campus',
    },
    {
        year: '2021',
        title: 'NEMSU takes its name',
        description:
            'Republic Act No. 11584 established the name North Eastern Mindanao State University.',
        image: '/images/campuses/tandag/facilities/gallery/university-gymnasium.webp',
        imageAlt: 'University gymnasium at NEMSU Tandag Campus',
    },
];

const historyItems: HistoryItem[] = [
    {
        year: '1982',
        title: 'Bukidnon External Studies Center',
        description:
            'Bukidnon State University, then Bukidnon State College, opened an extension in Tandag City with 153 pioneering students.',
    },
    {
        year: '1992',
        title: 'Surigao del Sur Polytechnic College',
        description:
            'Republic Act No. 7377 created SSPC and brought together the Tandag center and schools in Cagwait, Tagbina, Lianga, and San Miguel.',
    },
    {
        year: '1998',
        title: 'State College Status',
        description:
            'Republic Act No. 8628 converted SSPC into Surigao del Sur Polytechnic State College and integrated the Cantilan campus.',
    },
    {
        year: '2010',
        title: 'University Conversion',
        description:
            'Republic Act No. 9998 converted the state college into Surigao del Sur State University.',
    },
    {
        year: '2018',
        title: 'Bislig Campus Integration',
        description:
            'A memorandum with the University of Southeastern Philippines led to the gradual turnover of the Bislig campus.',
    },
    {
        year: '2021',
        title: 'North Eastern Mindanao State University',
        description:
            'Republic Act No. 11584 renamed SDSSU to North Eastern Mindanao State University.',
    },
];

const coreValues: CoreValue[] = [
    {
        title: 'Compassion',
        description:
            'Compassion entails our value of promoting empathy, sincerity, and authenticity within the academic community to foster a caring and supportive environment where individuals feel understood, valued, and respected.',
    },
    {
        title: 'Accountability',
        description:
            'Accountability signifies our unwavering commitment to integrity, honesty, and transparent practices, coupled with a sense of responsibility for our actions and decisions, ensuring ethical, effiecient, and cost-effective stewardship of resources for the common good.',
    },
    {
        title: 'Responsiveness',
        description:
            'Responsive is a prompt action and release consistent quality communication that is focus on providing correct and complete action and/or information to clients and stakeholders.',
    },
    {
        title: 'Excellence',
        description:
            'Excellence means our consistent pursuit of the highest standards of performance, characterized by innovation, dedication, and impactful contributions across all aspects of endeavor.',
    },
    {
        title: 'Service',
        description:
            'Service is the embodiment of our professionalism, dedication, and a service-oriented mindset, committed to fulfilling our mission with excellence, integrity, and continual improvement, while fostering interdependence, collaboration, and sustainable success within the community and nation-building endeavors.',
    },
];

const hymnLyrics = `Onward with a noble mission
Unifying with a vision;
Glorious footprints of knowledge won
Breeding grounds of Glocal Champions

Emblem of Mindanaoan nobility
Radiates the name of a growing NEMSU;
North Eastern Mindanao State University
Flying flag above the pacific blue.

Refrain:
Live! Rise! Soar and Excel!
In the NEMSU education
Leading to a better world
By sculpting better lives,
The NEMSU vision, NEMSU touch

N.E.M.S.U
The laying portals of brilliant hatch
(Repeat Refrain)

Coda:
The NEMSU vision
NEMSU touch
NEMSU!`;

const showHistorySlide = (index: number): void => {
    activeHistorySlide.value =
        (index + historySlides.length) % historySlides.length;
};

const setSectionVisibility = (section: string, isVisible: boolean): void => {
    const nextVisibleSections = new Set(visibleSections.value);

    if (isVisible) {
        nextVisibleSections.add(section);
    } else {
        nextVisibleSections.delete(section);
    }

    visibleSections.value = nextVisibleSections;
};

const isSectionVisible = (section: string): boolean =>
    visibleSections.value.has(section);

const revealClasses = (
    section: string,
    direction: RevealDirection = 'up',
): string =>
    [
        'transition-all duration-700 ease-out will-change-transform motion-reduce:translate-x-0 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:blur-0 motion-reduce:transition-none',
        isSectionVisible(section)
            ? 'translate-x-0 translate-y-0 opacity-100 blur-0'
            : `${revealOffset[direction]} opacity-0 blur-[2px]`,
    ].join(' ');

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

    historySlideInterval = window.setInterval(() => {
        showHistorySlide(activeHistorySlide.value + 1);
    }, 6000);

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

    if (historySlideInterval !== null) {
        window.clearInterval(historySlideInterval);
    }
});
</script>

<template>
    <PublicSiteLayout>
        <Head title="About the University" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
                        <PageHero
                title="About North Eastern Mindanao State University"
                description="A research university advancing technology, innovation, sustainable development, and public service across North Eastern Mindanao."
                :breadcrumbs="[
                    { title: 'Home', href: home().url },
                    { title: 'About Us' },
                    { title: 'About the University' },
                ]"
            />
            <!-- <section class="bg-white pt-4 pb-10 dark:bg-slate-950">
                <div
                    data-scroll-section="university-hero"
                    :class="revealClasses('university-hero')"
                    class="relative w-full"
                >
                    <div class="relative">
                        <div
                            class="absolute inset-x-0 top-12 bottom-0 bg-[#f5f8ff] dark:bg-slate-900"
                            aria-hidden="true"
                        ></div>
                        <div
                            class="absolute top-0 left-0 h-px w-full bg-[#0b3a75]/20"
                            aria-hidden="true"
                        ></div>
                        <div
                            class="absolute top-0 left-0 h-1.5 w-32 bg-[#f2b705]"
                            aria-hidden="true"
                        ></div>

                        <div
                            class="relative shadow-2xl shadow-slate-950/10"
                        >
                            <div
                                class="absolute -top-3 left-0 h-1 w-44 bg-[#f2b705]"
                                aria-hidden="true"
                            ></div>
                            <div
                                class="absolute -top-3 right-0 h-1 w-24 bg-[#0b3a75]"
                                aria-hidden="true"
                            ></div>
                            <div class="relative">
                                <div
                                    class="relative overflow-hidden border border-slate-200 bg-slate-950 shadow-xl shadow-slate-950/15 dark:border-white/10"
                                >
                                    <div
                                        class="relative h-[80vh] min-h-[24rem] max-h-[38rem]"
                                    >
                                        <img
                                            v-for="(slide, index) in historySlides"
                                            :key="slide.year"
                                            :src="slide.image"
                                            :alt="
                                                index === activeHistorySlide
                                                    ? slide.imageAlt
                                                    : ''
                                            "
                                            class="absolute inset-0 size-full object-cover object-center saturate-75 brightness-90 contrast-105 transition duration-1000 motion-reduce:transition-none"
                                            :class="
                                                index === activeHistorySlide
                                                    ? 'scale-100 opacity-100'
                                                    : 'scale-105 opacity-0'
                                            "
                                        />
                                        <div
                                            class="absolute inset-0 bg-linear-to-r from-[#061b3b]/45 via-[#061b3b]/10 to-transparent"
                                        ></div>
                                        <div
                                            class="absolute inset-x-0 bottom-0 h-28 bg-linear-to-t from-slate-950/45 to-transparent"
                                        ></div>
                                        <div
                                            class="absolute bottom-0 left-0 h-1 w-1/3 bg-[#f2b705]"
                                            aria-hidden="true"
                                        ></div>
                                    </div>
                                </div>

                                <div
                                    class="relative z-20 bg-[#061b3b] px-6 py-6 sm:absolute sm:inset-x-0 sm:top-[65%] sm:bg-transparent sm:px-10 sm:py-0"
                                >
                                    <div class="mx-auto max-w-7xl">
                                        <div
                                            class="max-w-[40rem] border-l-4 border-[#f2b705] bg-[#061b3b]/75 px-5 py-4 text-white shadow-2xl shadow-slate-950/30 backdrop-blur-[2px] sm:px-6"
                                        >
                                            <p
                                                class="text-xs font-semibold tracking-[0.22em] text-[#f2b705] uppercase sm:text-sm"
                                            >
                                                About the University
                                            </p>
                                            <h2
                                                class="mt-3 max-w-3xl font-serif text-3xl font-semibold tracking-normal text-white sm:text-4xl"
                                            >
                                                About North Eastern Mindanao
                                                State University
                                            </h2>
                                            <p
                                                class="mt-3 max-w-2xl text-justify text-sm leading-6 text-slate-100 sm:text-base"
                                            >
                                                A research university advancing
                                                technology, innovation,
                                                sustainable development, and
                                                public service across North
                                                Eastern Mindanao.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="relative z-10 flex flex-col gap-4 border-x border-b border-slate-200 bg-white/95 px-5 py-3 shadow-lg shadow-slate-950/10 backdrop-blur-sm sm:-mt-20 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:-mt-24 dark:border-white/10 dark:bg-slate-950/95"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="h-7 w-1 bg-[#f2b705]"
                                        aria-hidden="true"
                                    ></span>
                                    <p
                                        class="text-xs font-semibold tracking-[0.22em] text-slate-500 uppercase dark:text-slate-300"
                                    >
                                        Visual archive
                                        <span
                                            class="ml-2 text-[#0b3a75] dark:text-[#f2b705]"
                                        >
                                            {{
                                                historySlides[
                                                    activeHistorySlide
                                                ]?.year
                                            }}
                                        </span>
                                    </p>
                                </div>

                                <div
                                    class="flex flex-wrap items-center gap-3 sm:gap-4"
                                >
                                    <div
                                        class="flex items-center gap-1 bg-slate-100 p-1 dark:bg-white/10"
                                    >
                                        <button
                                            type="button"
                                            class="inline-flex size-8 items-center justify-center bg-white text-[#0b3a75] shadow-sm shadow-slate-900/5 transition hover:bg-[#0b3a75] hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0b3a75] active:scale-95 dark:bg-slate-950 dark:text-[#f2b705] dark:hover:bg-[#f2b705] dark:hover:text-slate-950"
                                            aria-label="Previous history milestone"
                                            @click="
                                                showHistorySlide(
                                                    activeHistorySlide - 1,
                                                )
                                            "
                                        >
                                            <ChevronLeft
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                        </button>
                                        <button
                                            type="button"
                                            class="inline-flex size-8 items-center justify-center bg-white text-[#0b3a75] shadow-sm shadow-slate-900/5 transition hover:bg-[#0b3a75] hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0b3a75] active:scale-95 dark:bg-slate-950 dark:text-[#f2b705] dark:hover:bg-[#f2b705] dark:hover:text-slate-950"
                                            aria-label="Next history milestone"
                                            @click="
                                                showHistorySlide(
                                                    activeHistorySlide + 1,
                                                )
                                            "
                                        >
                                            <ChevronRight
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                        </button>
                                    </div>

                                    <div
                                        class="flex h-8 items-center gap-1.5"
                                        aria-label="History slides"
                                    >
                                        <button
                                            v-for="(slide, index) in historySlides"
                                            :key="`indicator-${slide.year}`"
                                            type="button"
                                            class="h-1.5 transition-all"
                                            :class="
                                                index === activeHistorySlide
                                                    ? 'w-12 bg-[#f2b705]'
                                                    : 'w-4 bg-slate-300 hover:w-6 hover:bg-[#0b3a75]/60 dark:bg-white/30'
                                            "
                                            :aria-label="`Show ${slide.year} milestone`"
                                            @click="showHistorySlide(index)"
                                        ></button>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="h-px bg-[#f2b705]"
                                aria-hidden="true"
                            ></div>
                        </div>

                        <div
                            class="relative z-10 bg-[#f5f8ff] dark:bg-slate-900"
                        >
                            <div
                                class="mx-auto max-w-7xl px-6 pt-5 pb-6 sm:px-10"
                            >
                                <div
                                    class="max-w-xl border-l-2 border-[#f2b705] pl-6 lg:ml-auto"
                                    aria-label="Active history milestone"
                                >
                                    <p
                                        class="text-sm font-semibold tracking-[0.18em] text-[#0b3a75] uppercase dark:text-[#f2b705]"
                                    >
                                        {{
                                            historySlides[activeHistorySlide]
                                                ?.year
                                        }}
                                        Archival Milestone
                                    </p>
                                    <h3
                                        class="mt-3 text-xl font-semibold tracking-normal text-slate-950 dark:text-white"
                                    >
                                        {{
                                            historySlides[activeHistorySlide]
                                                ?.title
                                        }}
                                    </h3>
                                    <p
                                        class="mt-3 text-justify text-base leading-7 text-slate-600 dark:text-slate-300"
                                    >
                                        {{
                                            historySlides[activeHistorySlide]
                                                ?.description
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->


            <section
                id="history"
                data-scroll-section="history"
                :class="revealClasses('history', 'up')"
                class="bg-[#f5f8ff] py-16 sm:py-20 dark:bg-slate-900 relative"
            >
                <img src="/storage/images/university/history-bg-text.png" alt="History background text" class="absolute w-full left-0 top-0">

             <div class="px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#1711d4] uppercase dark:text-[#f2b705]"
                    >
                        History
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        From Extension Center to State University
                    </h2>
                </div>

                <div class="mx-auto overflow-x-auto max-w-400">
                <!-- <div class="flex justify-center overflow-x-auto max-w-700"> -->
                    <div class="flex mt-20 min-w-max">
                        <div v-for="(item, index) in historyItems" :key="item.year" class="w-65 max-w-65 py-4 pe-7 relative border-[#1711d4]" :class="{'border-t-4' : index !== historyItems.length - 1}">
                            <div class="absolute w-9 h-9 border-4 border-[#1711d4] rounded-full left-0 -top-5 bg-[#f5f8ff] flex items-center justify-center">
                                <div class="bg-brand-blue h-5 w-5 rounded-full"></div>
                            </div>
                            <h3 class="font-bold text-brand-navy mb-7 mt-3">{{ item.year }}</h3>
                            <div class="font-bold text-brand-navy">{{ item.title }}</div>
                            <p class="text-brand-navy">{{ item.description }}</p>
                        </div>
                    </div>
                </div>
             </div>
            </section>

            <!-- <section
                id="history"
                class="scroll-mt-28 bg-[#f5f8ff] py-16 sm:py-20 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="history-heading"
                        :class="revealClasses('history-heading')"
                        class="mx-auto max-w-3xl text-center"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#1711d4] uppercase dark:text-[#f2b705]"
                        >
                            History
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            From Extension Center to State University
                        </h2>
                    </div>

                    <div class="relative mt-14">
                        <div
                            class="absolute top-0 bottom-0 left-4 w-1 bg-white md:left-1/2 md:-translate-x-1/2 dark:bg-white/10"
                            aria-hidden="true"
                        ></div>

                        <article
                            v-for="(item, index) in historyItems"
                            :key="item.year"
                            :data-scroll-section="`history-${index}`"
                            class="relative grid pb-12 pl-12 last:pb-0 md:grid-cols-[minmax(0,1fr)_5rem_minmax(0,1fr)] md:pl-0"
                        >
                            <span
                                class="absolute top-7 left-4 z-10 size-6 -translate-x-1/2 rounded-full border-4 border-[#1711d4] bg-[#f5f8ff] md:left-1/2 dark:border-[#f2b705] dark:bg-slate-900"
                                aria-hidden="true"
                            ></span>

                            <div
                                :class="[
                                    revealClasses(
                                        `history-${index}`,
                                        index % 2 === 0 ? 'right' : 'left',
                                    ),
                                    index % 2 === 0
                                        ? 'md:col-start-1 md:mr-5'
                                        : 'md:col-start-3 md:ml-5',
                                ]"
                                class="relative bg-white p-7 shadow-sm shadow-slate-900/10 ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-white/10"
                            >
                                <span
                                    aria-hidden="true"
                                    :class="
                                        index % 2 === 0
                                            ? '-right-2'
                                            : '-left-2'
                                    "
                                    class="absolute top-8 hidden size-4 rotate-45 bg-white ring-1 ring-slate-200 md:block dark:bg-slate-950 dark:ring-white/10"
                                ></span>
                                <span
                                    class="font-serif text-3xl font-bold text-slate-950 dark:text-white"
                                >
                                    {{ item.year }}
                                </span>
                                <h3
                                    class="mt-8 font-semibold text-slate-950 dark:text-white"
                                >
                                    {{ item.title }}
                                </h3>
                                <p
                                    class="mt-3 text-justify text-sm leading-7 text-slate-600 dark:text-slate-300"
                                >
                                    {{ item.description }}
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </section> -->

            <section
                id="vision-and-mission"
                class="scroll-mt-28 border-y border-slate-200 bg-[#f5f8ff] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="vision-mission"
                        :class="revealClasses('vision-mission')"
                        class="grid items-start gap-12 lg:grid-cols-2"
                    >
                        <div
                            class="grid gap-10"
                        >
                            <article
                                class="border-b border-slate-300 pb-8 dark:border-white/10"
                            >
                                <h3
                                    class="font-black tracking-tight text-[#1711d4] uppercase sm:text-4xl dark:text-[#f2b705]"
                                >
                                    Vision
                                </h3>
                                <p
                                    class="mt-6 max-w-xl text-justify text-base leading-8 text-slate-600 dark:text-slate-300"
                                >
                                    A Research University advancing technology
                                    and innovation for sustainable development.
                                </p>
                            </article>

                            <article>
                                <h3
                                    class="font-black tracking-tight text-[#1711d4] uppercase sm:text-4xl dark:text-[#f2b705]"
                                >
                                    Mission
                                </h3>
                                <p
                                    class="mt-6 max-w-xl text-justify text-base leading-8 text-slate-600 dark:text-slate-300"
                                >
                                    We drive sustainable development through
                                    quality instruction, innovative research,
                                    community collaboration, and technological
                                    advancement.
                                </p>
                            </article>

                            <!-- <article>
                                <h3
                                    class="font-black tracking-tight text-[#1711d4] uppercase sm:text-4xl dark:text-[#f2b705]"
                                >
                                    Core Values
                                </h3>
                                <p
                                    class="mt-6 max-w-xl text-justify text-base leading-8 text-slate-600 dark:text-slate-300"
                                >
                                    Compassion, Accountability, Responsiveness,
                                    Excellence, and Service.
                                </p>
                            </article> -->

                            <article>
                                <h3
                                    class="font-black tracking-tight text-[#1711d4] uppercase sm:text-4xl dark:text-[#f2b705]"
                                >
                                    Quality Policy
                                </h3>
                                <p
                                    class="mt-6 max-w-xl text-justify text-base leading-8 text-slate-600 dark:text-slate-300"
                                >
                                   The North Eastern Mindanao State University commits itself to produce highly motivated, globally competitive, and morally upright human resource through the delivery of transformative and quality higher education that conforms to international standards driven by excellent instruction, relevant researches, sustainable extension, and production services. Together with our stakeholders, we shall endeavor for continual improvement of our quality management system in consonance with statutory and regulatory requirements for clients and industry satisfaction for quality of life.
                                </p>
                            </article>
                        </div>

                        <article
                            id="nemsu-hymn"
                            class="scroll-mt-28"
                        >
                            <!-- <Music2
                                class="mx-auto mb-5 size-10 text-[#f2b705]"
                                aria-hidden="true"
                            /> -->
                            <h3
                                class="text-sm font-bold tracking-[0.2em] text-[#1711d4] uppercase dark:text-[#f2b705]"
                            >
                                NEMSU Hymn
                            </h3>
                            <h3
                                class="mt-3 text-2xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                NEMSU Touch
                            </h3>
                            <!-- <dl
                                class="mt-6 grid max-w-xl gap-3 text-sm text-left sm:grid-cols-3"
                            >
                                <div>
                                    <dt
                                        class="font-semibold text-slate-950 dark:text-white"
                                    >
                                        Lyricist
                                    </dt>
                                    <dd
                                        class="mt-1 text-slate-600 dark:text-slate-300"
                                    >
                                        Prof. Evelyn T. Bagood
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="font-semibold text-slate-950 dark:text-white"
                                    >
                                        Composer
                                    </dt>
                                    <dd
                                        class="mt-1 text-slate-600 dark:text-slate-300"
                                    >
                                        Mr. Castor V. Balacuit
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="font-semibold text-slate-950 dark:text-white"
                                    >
                                        Arranger
                                    </dt>
                                    <dd
                                        class="mt-1 text-slate-600 dark:text-slate-300"
                                    >
                                        Mr. Carl Martin R. Engcoy
                                    </dd>
                                </div>
                            </dl> -->
                            <div
                                class="mt-2 flex flex-col gap-7 pt-5 text-left md:flex-row dark:border-white/10"
                            >
                                <div class="flex-1">
                                    <p
                                        class="whitespace-pre-line text-sm leading-7 text-slate-600 dark:text-slate-300"
                                    >
                                        {{ hymnLyrics }}
                                    </p>
                                </div>
                                <div class="flex-1">
                                    <iframe
                                        class="aspect-video w-full rounded mt-2"
                                        src="https://www.youtube.com/embed/Z7SPq_B6S5o?si=TiVW6BdzWuTj6S5M"
                                        title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen
                                    ></iframe>

                                       <dl
                                class="mt-6 grid max-w-xl gap-3 text-sm text-left ms-2"
                                    >
                                    <div>
                                        <dt
                                            class="font-semibold text-slate-950 dark:text-white"
                                        >
                                            Lyricist
                                        </dt>
                                        <dd
                                            class="mt-1 text-slate-600 dark:text-slate-300"
                                        >
                                            Prof. Evelyn T. Bagood
                                        </dd>
                                    </div>
                                    <div>
                                        <dt
                                            class="font-semibold text-slate-950 dark:text-white"
                                        >
                                            Composer
                                        </dt>
                                        <dd
                                            class="mt-1 text-slate-600 dark:text-slate-300"
                                        >
                                            Mr. Castor V. Balacuit
                                        </dd>
                                    </div>
                                    <div>
                                        <dt
                                            class="font-semibold text-slate-950 dark:text-white"
                                        >
                                            Arranger
                                        </dt>
                                        <dd
                                            class="mt-1 text-slate-600 dark:text-slate-300"
                                        >
                                            Mr. Carl Martin R. Engcoy
                                        </dd>
                                    </div>
                                </dl>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section id="core-values" class="scroll-mt-28 py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="values-heading"
                        :class="revealClasses('values-heading')"
                        class="text-center"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#1711d4] uppercase dark:text-[#f2b705]"
                        >
                            Core Values
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                        >
                            NEMSU CARES
                        </h2>
                    </div>

                    <div
                        class="mt-10 grid items-stretch gap-6 lg:grid-cols-[11rem_minmax(0,1fr)]"
                    >
                        <div
                            class="hidden border-l-4 border-[#1711d4] pl-7 text-[#1711d4] lg:grid lg:grid-rows-5 dark:text-[#f2b705]"
                            aria-label="NEMSU CARES"
                        >
                            <span
                                v-for="letter in ['C', 'A', 'R', 'E', 'S']"
                                :key="letter"
                                class="grid min-h-20 items-center text-5xl font-bold"
                            >
                                {{ letter }}
                            </span>
                        </div>

                        <div class="divide-y divide-slate-200 dark:divide-white/10">
                            <article
                                v-for="(value, index) in coreValues"
                                :key="value.title"
                                :data-scroll-section="`value-${index}`"
                                :class="revealClasses(`value-${index}`)"
                                class="py-5"
                            >
                                <div>
                                    <h3
                                        class="text-lg font-semibold text-slate-950 dark:text-white"
                                    >
                                        {{ value.title }}
                                    </h3>
                                    <p
                                        class="mt-1 text-justify text-sm leading-7 text-slate-600 dark:text-slate-300"
                                    >
                                        {{ value.description }}
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section
                aria-hidden="true"
                class="hidden"
            >
                <div
                    class="mx-auto grid max-w-7xl items-start gap-10 px-4 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-8"
                >
                    <div
                        data-scroll-section="hymn-identity"
                        :class="revealClasses('hymn-identity', 'right')"
                        class="border-l-4 border-[#1711d4] pl-6 text-[#1711d4] dark:text-[#f2b705]"
                    >
                        <Music2
                            class="size-12"
                            aria-hidden="true"
                        />
                        <p
                            class="mt-6 text-sm font-semibold tracking-[0.2em] uppercase"
                        >
                            University Tradition
                        </p>
                        <p
                            class="mt-3 text-3xl font-semibold text-slate-950 dark:text-white"
                        >
                            Live. Rise. Soar. Excel.
                        </p>
                    </div>

                    <div
                        data-scroll-section="hymn-copy"
                        :class="revealClasses('hymn-copy', 'left')"
                        class="lg:border-l lg:border-slate-300 lg:pl-10 dark:lg:border-white/10"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#1711d4] uppercase dark:text-[#f2b705]"
                        >
                            NEMSU Hymn
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            The University’s shared song
                        </h2>
                        <dl class="mt-6 grid gap-4 text-sm sm:grid-cols-3">
                            <div>
                                <dt
                                    class="font-semibold text-slate-950 dark:text-white"
                                >
                                    Lyricist
                                </dt>
                                <dd
                                    class="mt-1 text-slate-600 dark:text-slate-300"
                                >
                                    Prof. Evelyn T. Bagood
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="font-semibold text-slate-950 dark:text-white"
                                >
                                    Composer
                                </dt>
                                <dd
                                    class="mt-1 text-slate-600 dark:text-slate-300"
                                >
                                    Mr. Castor V. Balacuit
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="font-semibold text-slate-950 dark:text-white"
                                >
                                    Arranger
                                </dt>
                                <dd
                                    class="mt-1 text-slate-600 dark:text-slate-300"
                                >
                                    Mr. Carl Martin R. Engcoy
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </section>

            <section
                id="university-seal"
                class="scroll-mt-28 bg-[#1711d4] py-14 text-white sm:py-16"
            >
                <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                    <div class="mt-18 grid gap-10 text-left lg:grid-cols-[1fr_1.5fr]">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                        >
                            University Seal
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-white sm:text-4xl"
                        >
                            Symbol of Identity and Excellence
                        </h2>
                        <!-- <p class="mt-4 max-w-3xl mx-auto text-justify text-base leading-7 text-slate-200 lg:hidden">
                            The University Logo reflects the identity of North Eastern Mindanao State University (NEMSU) as the pioneering state university in the province, committed to providing quality education across various fields of specialization. It symbolizes the university's growth from a polytechnic institution to a comprehensive higher education provider.
                        </p> -->
                    </div>

                    <div class="mt-18 grid gap-10 text-left lg:grid-cols-[1fr_1.5fr]">
                        <div>
                            <p
                                data-scroll-section="seal-desc-mobile"
                                :class="revealClasses('seal-desc-mobile')"
                                class="text-justify text-base leading-7 text-slate-200 mb-8 block lg:hidden"
                            >
                                The University Logo reflects the identity of North Eastern Mindanao State University (NEMSU) as the pioneering state university in the province, committed to providing quality education across various fields of specialization. It symbolizes the university's growth from a polytechnic institution to a comprehensive higher education provider.
                            </p>
                            <div
                                data-scroll-section="seal-image"
                                :class="revealClasses('seal-image')"
                                class="flex justify-center"
                            >
                                <img
                                    :src="sealImage"
                                    alt="NEMSU University Seal"
                                    class="size-80 object-contain drop-shadow-2xl sm:size-100"
                                />
                            </div>
                            <p
                                data-scroll-section="seal-desc-desktop"
                                :class="revealClasses('seal-desc-desktop', 'left')"
                                class="mt-8 text-justify text-base leading-7 text-slate-200 hidden lg:block"
                            >
                                The University Logo reflects the identity of North Eastern Mindanao State University (NEMSU) as the pioneering state university in the province, committed to providing quality education across various fields of specialization. It symbolizes the university's growth from a polytechnic institution to a comprehensive higher education provider.
                            </p>
                        </div>

                        <div
                            data-scroll-section="seal-symbols"
                            :class="revealClasses('seal-symbols', 'left')"
                        >
                         

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div
                                    v-for="element in sealElements"
                                    :key="element.title"
                                    class="flex flex-col gap-4 items-start rounded-lg bg-white/16 border border-white/15 p-4 text-left transition-transform duration-200 hover:scale-105"
                                >
                                    <img
                                        :src="element.image"
                                        :alt="element.title"
                                        class="size-16 shrink-0 object-contain rounded"
                                    />
                                    <div>
                                        <h3 class="text-base font-semibold text-white">
                                            {{ element.title }}
                                        </h3>
                                        <p class="mt-1 text-xs leading-5 text-slate-300">
                                            {{ element.meaning }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
