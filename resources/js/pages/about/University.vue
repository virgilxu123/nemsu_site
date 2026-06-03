<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    BadgeCheck,
    BookOpen,
    Compass,
    Flag,
    Leaf,
    ShieldCheck,
    Sparkles,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import type { Component, CSSProperties } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type PageAnchor = {
    label: string;
    href: string;
};

type HistoryItem = {
    year: string;
    title: string;
    description: string;
};

type CoreValue = {
    title: string;
    description: string;
    icon: Component;
};

type SealPart = {
    title: string;
    description: string;
};

const sealImage = 'https://nemsu.edu.ph/assets/images/NEMSU.png';
const heroImage = 'https://nemsu.edu.ph/files/News/cm-00.jpg';

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['university-hero']));
let revealObserver: IntersectionObserver | null = null;

const pageAnchors: PageAnchor[] = [
    { label: 'History', href: '#history' },
    { label: 'Vision and Mission', href: '#vision-and-mission' },
    { label: 'Core Values', href: '#core-values' },
    { label: 'University Seal', href: '#university-seal' },
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
            'Promotes empathy, sincerity, and authenticity within a caring and supportive academic community.',
        icon: Leaf,
    },
    {
        title: 'Accountability',
        description:
            'Upholds integrity, transparency, responsibility, and ethical stewardship of resources for the common good.',
        icon: ShieldCheck,
    },
    {
        title: 'Responsiveness',
        description:
            'Commits to prompt action and quality communication for clients and stakeholders.',
        icon: Compass,
    },
    {
        title: 'Excellence',
        description:
            'Pursues the highest standards of performance through innovation, dedication, and impact.',
        icon: Sparkles,
    },
    {
        title: 'Service',
        description:
            'Embodies professionalism, dedication, collaboration, and continual improvement in service to the community and nation.',
        icon: BadgeCheck,
    },
];

const sealParts: SealPart[] = [
    {
        title: 'Ring',
        description:
            'Represents continuity, leadership, and the bridge between the university and the wider world.',
    },
    {
        title: 'Shield',
        description:
            'Represents the university purposes, mission, vision, and the academic fields across the campuses.',
    },
    {
        title: 'Color',
        description:
            'The sky-blue identity stands for faithful courage among teaching forces, students, administration, and staff.',
    },
    {
        title: 'Open Book',
        description: 'Symbolizes knowledge offered by the university.',
    },
    {
        title: 'Torch and Laurel',
        description:
            'The torch is a guiding light, while the laurel proclaims victory over global challenges.',
    },
];

const heroBackground = (image: string): CSSProperties => ({
    backgroundImage: `linear-gradient(115deg, rgba(23,17,212,.95), rgba(7,52,93,.82) 55%, rgba(5,15,36,.72)), url("${image}")`,
});

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
            rootMargin: '0px 0px -25% 0px',
            threshold: 0,
        },
    );

    animatedSections.forEach((section) => {
        revealObserver?.observe(section);
    });
});

onBeforeUnmount(() => {
    revealObserver?.disconnect();
});
</script>

<template>
    <PublicSiteLayout>
        <Head title="About the University" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate overflow-hidden bg-[#1711d4] bg-cover bg-center py-16 text-white sm:py-20"
                :style="heroBackground(heroImage)"
            >
                <img
                    :src="sealImage"
                    alt=""
                    class="pointer-events-none absolute right-6 bottom-6 z-0 hidden size-40 object-contain opacity-[0.06] sm:block lg:size-52"
                    aria-hidden="true"
                />

                <div
                    data-scroll-section="university-hero"
                    :class="revealClasses('university-hero')"
                    class="relative z-10 mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_25rem] lg:px-8"
                >
                    <div>
                        <p
                            class="inline-flex rounded bg-white/10 px-3 py-1 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                        >
                            About Us
                        </p>
                        <h1
                            class="mt-5 max-w-3xl text-4xl font-semibold tracking-normal text-white sm:text-5xl lg:text-6xl"
                        >
                            North Eastern Mindanao State University
                        </h1>
                        <p
                            class="mt-6 max-w-2xl text-base leading-8 text-sky-50 sm:text-lg"
                        >
                            One page for the university's history, vision and
                            mission, core values, and seal.
                        </p>
                    </div>

                    <nav
                        class="self-end rounded-md border border-white/15 bg-white/10 p-3 backdrop-blur"
                        aria-label="University page sections"
                    >
                        <a
                            v-for="anchor in pageAnchors"
                            :key="anchor.href"
                            :href="anchor.href"
                            class="block rounded-md px-4 py-3 text-sm font-semibold text-white/90 transition hover:bg-white hover:text-[#1711d4]"
                        >
                            {{ anchor.label }}
                        </a>
                    </nav>
                </div>
            </section>

            <section id="history" class="scroll-mt-28 py-14 sm:py-16">
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[20rem_1fr] lg:px-8"
                >
                    <div
                        data-scroll-section="history-heading"
                        :class="revealClasses('history-heading', 'right')"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            History
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            From extension center to state university
                        </h2>
                    </div>

                    <div class="grid gap-4">
                        <article
                            v-for="(item, index) in historyItems"
                            :key="item.year"
                            :data-scroll-section="`history-${index}`"
                            :class="revealClasses(`history-${index}`)"
                            class="grid gap-4 rounded-md border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5 sm:grid-cols-[6rem_1fr] dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <span
                                class="inline-flex h-12 w-20 items-center justify-center rounded-md bg-[#1711d4] text-sm font-bold text-white"
                            >
                                {{ item.year }}
                            </span>
                            <div>
                                <h3
                                    class="font-semibold text-slate-950 dark:text-white"
                                >
                                    {{ item.title }}
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300"
                                >
                                    {{ item.description }}
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section
                id="vision-and-mission"
                class="scroll-mt-28 border-y border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="vision-mission"
                        :class="revealClasses('vision-mission')"
                        class="grid gap-5 lg:grid-cols-2"
                    >
                        <article
                            class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <BookOpen
                                class="size-8 text-[#1711d4] dark:text-sky-200"
                                aria-hidden="true"
                            />
                            <p
                                class="mt-6 text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                Vision
                            </p>
                            <h2
                                class="mt-3 text-2xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                A Research University advancing technology and
                                innovation for sustainable development.
                            </h2>
                        </article>

                        <article
                            class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <Flag
                                class="size-8 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            <p
                                class="mt-6 text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                            >
                                Mission
                            </p>
                            <h2
                                class="mt-3 text-2xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                We drive sustainable development through quality
                                instruction, innovative research, community
                                collaboration, and technological advancement.
                            </h2>
                        </article>
                    </div>
                </div>
            </section>

            <section id="core-values" class="scroll-mt-28 py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="values-heading"
                        :class="revealClasses('values-heading')"
                        class="max-w-3xl"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Core Values
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            NEMSU CARES
                        </h2>
                    </div>

                    <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-5">
                        <article
                            v-for="(value, index) in coreValues"
                            :key="value.title"
                            :data-scroll-section="`value-${index}`"
                            :class="revealClasses(`value-${index}`)"
                            class="rounded-md border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <span
                                class="inline-flex size-11 items-center justify-center rounded-md bg-[#e7f3fb] text-[#1711d4] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <component
                                    :is="value.icon"
                                    class="size-5"
                                    aria-hidden="true"
                                />
                            </span>
                            <h3
                                class="mt-5 text-lg font-semibold text-slate-950 dark:text-white"
                            >
                                {{ value.title }}
                            </h3>
                            <p
                                class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ value.description }}
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section
                id="university-seal"
                class="scroll-mt-28 bg-[#1711d4] py-14 text-white sm:py-16"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[22rem_1fr] lg:px-8"
                >
                    <div
                        data-scroll-section="seal-visual"
                        :class="revealClasses('seal-visual', 'right')"
                        class="grid justify-items-center rounded-md border border-white/15 bg-white p-8 shadow-xl shadow-slate-950/20"
                    >
                        <img
                            :src="sealImage"
                            alt="NEMSU seal"
                            class="size-56 object-contain"
                        />
                    </div>

                    <div
                        data-scroll-section="seal-copy"
                        :class="revealClasses('seal-copy', 'left')"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                        >
                            University Seal
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-white"
                        >
                            The official emblem of the university
                        </h2>
                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            <article
                                v-for="part in sealParts"
                                :key="part.title"
                                class="rounded-md border border-white/15 bg-white/10 p-4 backdrop-blur"
                            >
                                <h3 class="font-semibold text-white">
                                    {{ part.title }}
                                </h3>
                                <p class="mt-2 text-sm leading-7 text-sky-100">
                                    {{ part.description }}
                                </p>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
