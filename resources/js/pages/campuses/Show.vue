<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BadgeCheck,
    CalendarDays,
    ChevronDown,
    ExternalLink,
    FileText,
    HeartHandshake,
    Mail,
    MapPin,
    Phone,
    ShieldCheck,
    Sparkles,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
import type { CSSProperties } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { show as campusShow } from '@/routes/campuses';

type Stat = {
    label: string;
    value: string;
    note: string;
};

type ProgramGroup = {
    college: string;
    offerings: string[];
};

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type FacilityGalleryItem = {
    image: string;
    alt: string;
    title?: string;
    description?: string;
    category?: string;
    status?: string;
    featured?: boolean;
    wide?: boolean;
};

type ServiceHighlight = {
    title: string;
    description: string;
    images: {
        image: string;
        alt: string;
    }[];
};

type StudentGovernmentActivity = {
    title: string;
    date: string;
    description: string;
    images: {
        image: string;
        alt: string;
    }[];
};

type Campus = {
    slug: string;
    name: string;
    label: string;
    location: string;
    heroImage: string;
    secondaryImage: string;
    profile: {
        headline: string;
        overview: string;
        highlights: string[];
    };
    director: {
        name: string;
        role: string;
        office: string;
        email: string | null;
        phone: string;
        photo: string;
    };
    contact: {
        address: string;
        email: string;
        phone: string | null;
        officeHours: string | null;
    };
    stats: Stat[];
    facilities: string[];
    facilityGallery: FacilityGalleryItem[];
    programs: ProgramGroup[];
    prospectuses: Record<string, string>;
    campusLife: string[];
    services: string[];
    serviceHighlights?: ServiceHighlight[];
    studentGovernment: {
        name: string;
        adviser: string;
        focus: string;
        initiatives: string[];
        activities: StudentGovernmentActivity[];
    };
    updates: {
        date: string;
        title: string;
        summary: string;
        images?: {
            image: string;
            alt: string;
        }[];
    }[];
};

const props = defineProps<{
    campus: Campus;
    campuses: Campus[];
}>();

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const collegeAnchorId = (college: string): string =>
    `college-${college
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-|-$/g, '')}`;

const collegePanelId = (college: string): string =>
    `${collegeAnchorId(college)}-programs`;

const activeCollegeAnchorId = ref('');
const openCollegeAnchorId = ref(
    props.campus.programs[0]?.college
        ? collegeAnchorId(props.campus.programs[0].college)
        : '',
);
const visibleSections = ref<Set<string>>(
    new Set(['campus-hero', 'campus-stats']),
);
let collegeMenuScrollFrame: number | null = null;
let revealObserver: IntersectionObserver | null = null;

const collegeProgramSections = (): HTMLElement[] =>
    Array.from(
        document.querySelectorAll<HTMLElement>('[data-college-program]'),
    );

const updateActiveCollegeAnchor = (): void => {
    const sections = collegeProgramSections();

    if (sections.length === 0) {
        return;
    }

    const activationOffset = Math.min(window.innerHeight * 0.34, 260);
    let activeSectionId = sections[0].id;

    sections.forEach((section) => {
        if (section.getBoundingClientRect().top <= activationOffset) {
            activeSectionId = section.id;
        }
    });

    activeCollegeAnchorId.value = activeSectionId;
};

const queueActiveCollegeUpdate = (): void => {
    if (collegeMenuScrollFrame !== null) {
        return;
    }

    collegeMenuScrollFrame = window.requestAnimationFrame(() => {
        collegeMenuScrollFrame = null;
        updateActiveCollegeAnchor();
    });
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

const staggerDelay = (section: string, index: number): CSSProperties => ({
    transitionDelay: isSectionVisible(section) ? `${index * 80}ms` : '0ms',
});

const isCollegeOpen = (college: string): boolean =>
    openCollegeAnchorId.value === collegeAnchorId(college);

const toggleCollege = (college: string): void => {
    const anchorId = collegeAnchorId(college);

    activeCollegeAnchorId.value = anchorId;
    openCollegeAnchorId.value =
        openCollegeAnchorId.value === anchorId ? '' : anchorId;
};

watch(
    () => props.campus.slug,
    () => {
        openCollegeAnchorId.value = props.campus.programs[0]?.college
            ? collegeAnchorId(props.campus.programs[0].college)
            : '';
        activeCollegeAnchorId.value = openCollegeAnchorId.value;
    },
);

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
    } else {
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
                threshold: 0.12,
            },
        );

        animatedSections.forEach((section) => {
            revealObserver?.observe(section);
        });
    }

    updateActiveCollegeAnchor();
    window.addEventListener('scroll', queueActiveCollegeUpdate, {
        passive: true,
    });
    window.addEventListener('resize', queueActiveCollegeUpdate);
});

onBeforeUnmount(() => {
    revealObserver?.disconnect();
    window.removeEventListener('scroll', queueActiveCollegeUpdate);
    window.removeEventListener('resize', queueActiveCollegeUpdate);

    if (collegeMenuScrollFrame !== null) {
        window.cancelAnimationFrame(collegeMenuScrollFrame);
    }
});
</script>

<template>
    <PublicSiteLayout>
        <Head :title="campus.name" />

        <section
            class="relative isolate bg-[#f7f8f5] pb-28 sm:pb-5 lg:pb-5 dark:bg-slate-950"
        >
            <div
                class="relative flex h-[87svh] items-center overflow-hidden bg-slate-950 text-white"
            >
                <img
                    :src="campus.heroImage"
                    alt=""
                    class="campus-hero-image pointer-events-none absolute inset-0 z-0 h-full w-full object-cover object-center opacity-80 select-none"
                    aria-hidden="true"
                />
                <div
                    class="pointer-events-none absolute inset-0 z-0 bg-[#1711d4]/40 mix-blend-multiply select-none"
                    aria-hidden="true"
                ></div>

                <div
                    class="relative z-10 mx-auto grid w-full max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1fr_26rem] lg:px-8"
                >
                    <div
                        class="flex flex-col items-start justify-center gap-3"
                        data-scroll-section="campus-hero"
                        :class="revealClasses('campus-hero')"
                    >
                        <div class="flex flex-wrap items-center gap-2">
                            <Link
                                :href="home()"
                                class="rounded bg-white/10 px-3 py-1.5 text-xs font-semibold text-white/85 transition text-shadow-[0_2px_8px_rgb(0_0_0_/_0.9)] hover:bg-white/15 hover:text-white"
                            >
                                NEMSU
                            </Link>
                            <span
                                class="inline-flex items-center gap-1.5 rounded bg-[#f2b705] px-3 py-1.5 text-xs font-semibold text-[#2f2400]"
                            >
                                <MapPin class="size-3.5" aria-hidden="true" />
                                {{ campus.location }}
                            </span>
                        </div>

                        <h1
                            class="mt-3 max-w-4xl font-serif text-4xl leading-tight font-semibold tracking-tight text-white text-shadow-[0_4px_18px_rgb(0_0_0_/_0.95)] sm:text-6xl"
                        >
                            {{ campus.name }}
                        </h1>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase text-shadow-[0_2px_10px_rgb(0_0_0_/_0.95)]"
                        >
                            {{ campus.label }}
                        </p>
                        <!-- <p class="mt-5 max-w-2xl text-base leading-8 text-sky-100">
                            {{ campus.profile.headline }}
                        </p> -->
                    </div>
                </div>
            </div>

            <div
                class="inset-x-0 top-[80svh] z-20 mx-auto grid w-full max-w-[100rem] grid-cols-2 gap-3 px-4 py-4 sm:px-6 md:grid-cols-4 lg:absolute lg:-translate-y-1/2 lg:gap-2 lg:px-8"
            >
                <article
                    v-for="(stat, index) in campus.stats"
                    :key="stat.label"
                    :data-scroll-section="`campus-stat-${index}`"
                    class="rounded-md bg-[#08047d]/70 p-4 text-center text-yellow-300 shadow-sm shadow-slate-900/10 transition-opacity duration-1000 ease-out motion-reduce:opacity-100 motion-reduce:transition-none sm:p-5 lg:-translate-y-1/4 dark:bg-[#0b3d91]"
                    :class="
                        isSectionVisible(`campus-stat-${index}`)
                            ? 'opacity-100'
                            : 'opacity-0'
                    "
                    :style="staggerDelay(`campus-stat-${index}`, index)"
                >
                    <p
                        class="font-serif text-3xl leading-none font-light text-yellow-500 sm:text-5xl lg:py-2 lg:text-6xl"
                    >
                        {{ stat.value }}
                    </p>
                    <h5 class="mt-3 text-sm font-semibold text-white">
                        {{ stat.label }}
                    </h5>
                    <p class="mt-1 text-sm text-sky-100">
                        {{ stat.note }}
                    </p>
                </article>
            </div>
        </section>

        <section class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div
                class="mx-auto grid max-w-7xl items-start gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_24rem] lg:px-8"
            >
                <article
                    class="max-w-4xl"
                    data-scroll-section="campus-about"
                    :class="revealClasses('campus-about', 'right')"
                >
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        About the Campus
                    </p>
                    <h4
                        class="mt-3 max-w-3xl font-serif text-3xl leading-tight font-semibold tracking-tight text-slate-950 sm:text-4xl dark:text-white"
                    >
                        {{ campus.profile.headline }}
                    </h4>
                    <p
                        class="mt-6 text-lg leading-8 whitespace-pre-line text-slate-600 dark:text-slate-300"
                    >
                        {{ campus.profile.overview }}
                    </p>
                </article>

                <aside
                    class="grid gap-4 lg:sticky lg:top-24"
                    data-scroll-section="campus-contact"
                    :class="revealClasses('campus-contact', 'left')"
                >
                    <article
                        class="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div
                            class="aspect-square bg-slate-100 dark:bg-white/10"
                        >
                            <img
                                :src="campus.director.photo"
                                :alt="`${campus.director.name} portrait`"
                                class="h-full w-full object-cover object-top"
                            />
                        </div>

                        <div class="p-6">
                            <p
                                class="text-xs font-semibold tracking-[0.2em] text-[#f2b705] uppercase"
                            >
                                {{ campus.director.role }}
                            </p>
                            <h3
                                class="mt-3 font-serif text-2xl leading-tight font-semibold tracking-tight text-slate-950 dark:text-white"
                            >
                                {{ campus.director.name }}
                            </h3>
                            <div
                                class="mt-5 border-t border-slate-200 pt-5 dark:border-white/10"
                            >
                                <p
                                    class="text-sm leading-6 text-slate-600 dark:text-slate-300"
                                >
                                    {{ campus.director.office }}
                                </p>
                            </div>
                        </div>
                    </article>

                    <article
                        class="relative overflow-hidden rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div
                            class="absolute inset-x-0 top-0 h-1 bg-[#f2b705]"
                        ></div>
                        <div class="flex items-center gap-4">
                            <div>
                                <p
                                    class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    Visit the Campus
                                </p>
                                <h3
                                    class="mt-2 font-semibold text-slate-950 dark:text-white"
                                >
                                    Contact Details
                                </h3>
                            </div>
                        </div>
                        <div
                            class="mt-6 grid gap-4 border-t border-slate-200 pt-5 text-sm leading-6 text-slate-600 dark:border-white/10 dark:text-slate-300"
                        >
                            <p class="flex gap-3">
                                <MapPin
                                    class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <span>{{ campus.contact.address }}</span>
                            </p>
                            <a
                                :href="`mailto:${campus.contact.email}`"
                                class="flex gap-3 transition hover:text-[#1711d4] dark:hover:text-sky-200"
                            >
                                <Mail
                                    class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <span>{{ campus.contact.email }}</span>
                            </a>
                            <a
                                v-if="campus.contact.phone"
                                :href="`tel:${campus.contact.phone}`"
                                class="flex gap-3 transition hover:text-[#1711d4] dark:hover:text-sky-200"
                            >
                                <Phone
                                    class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <span>{{ campus.contact.phone }}</span>
                            </a>
                            <p
                                v-if="campus.contact.officeHours"
                                class="flex gap-3"
                            >
                                <CalendarDays
                                    class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <span>{{ campus.contact.officeHours }}</span>
                            </p>
                        </div>
                    </article>
                </aside>
            </div>
        </section>
        <section
            class="bg-[linear-gradient(145deg,#f7f8f5_0%,#ffffff_55%,#edf7f8_100%)] py-16 dark:bg-slate-950"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end"
                    data-scroll-section="campus-programs-heading"
                    :class="revealClasses('campus-programs-heading')"
                >
                    <div class="max-w-2xl">
                        <h4
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Program Offerings
                        </h4>
                    </div>
                </div>

                <div class="mt-10 gap-6 lg:items-start">
                    <div class="grid gap-5">
                        <article
                            v-for="(group, index) in campus.programs"
                            :id="collegeAnchorId(group.college)"
                            :key="group.college"
                            :data-college-program="
                                collegeAnchorId(group.college)
                            "
                            :data-scroll-section="`campus-program-${index}`"
                            class="relative scroll-mt-24 overflow-hidden rounded-md bg-white/90 shadow-sm shadow-slate-900/5 dark:bg-white/5"
                            :class="[
                                group.offerings.length > 10
                                    ? 'bg-white dark:bg-white/[0.07]'
                                    : '',
                                revealClasses(`campus-program-${index}`, 'up'),
                            ]"
                            :style="
                                staggerDelay(`campus-program-${index}`, index)
                            "
                        >
                            <div
                                class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-[#1711d4] via-[#0b6680] to-[#f2b705]"
                            ></div>
                            <button
                                type="button"
                                class="group/college flex w-full items-start justify-between gap-4 px-6 pt-6 pb-4 text-left transition hover:bg-white/60 focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-[#1711d4] dark:hover:bg-white/[0.04]"
                                :aria-expanded="isCollegeOpen(group.college)"
                                :aria-controls="collegePanelId(group.college)"
                                @click="toggleCollege(group.college)"
                            >
                                <span class="flex min-w-0 items-start gap-3">
                                    <span>
                                        <span
                                            class="mt-1 block text-lg leading-6 font-semibold text-slate-950 dark:text-white"
                                        >
                                            {{ group.college }}
                                        </span>
                                    </span>
                                </span>
                                <span class="flex shrink-0 items-center gap-2">
                                    <span
                                        class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-white/10 dark:text-slate-300"
                                    >
                                        {{ group.offerings.length }}
                                        {{
                                            group.offerings.length === 1
                                                ? 'program'
                                                : 'programs'
                                        }}
                                    </span>
                                    <ChevronDown
                                        class="mt-1 size-5 text-slate-400 transition-transform duration-200 group-hover/college:text-[#0b6680] dark:text-slate-500 dark:group-hover/college:text-sky-200"
                                        :class="
                                            isCollegeOpen(group.college)
                                                ? 'rotate-180'
                                                : ''
                                        "
                                        aria-hidden="true"
                                    />
                                </span>
                            </button>
                            <Transition
                                enter-active-class="motion-safe:transition motion-safe:duration-200 motion-safe:ease-out motion-reduce:transition-none"
                                enter-from-class="motion-safe:-translate-y-1 motion-safe:opacity-0"
                                enter-to-class="motion-safe:translate-y-0 motion-safe:opacity-100"
                                leave-active-class="motion-safe:transition motion-safe:duration-150 motion-safe:ease-in motion-reduce:transition-none"
                                leave-from-class="motion-safe:translate-y-0 motion-safe:opacity-100"
                                leave-to-class="motion-safe:-translate-y-1 motion-safe:opacity-0"
                            >
                                <div
                                    v-show="isCollegeOpen(group.college)"
                                    :id="collegePanelId(group.college)"
                                    class="border-t border-slate-100 dark:border-white/10"
                                >
                                    <ul
                                        class="grid gap-3 p-4 text-base leading-7 text-slate-600 dark:text-slate-300"
                                    >
                                        <li
                                            v-for="offering in group.offerings"
                                            :key="offering"
                                            class="group/offering"
                                        >
                                            <a
                                                v-if="
                                                    campus.prospectuses[
                                                        offering
                                                    ]
                                                "
                                                :href="
                                                    campus.prospectuses[
                                                        offering
                                                    ]
                                                "
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="flex min-w-0 items-center gap-3 rounded-md bg-white/70 px-4 py-3 font-medium text-slate-800 transition-colors duration-150 hover:bg-[#e6f3f5] hover:text-[#0b6680] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1711d4] dark:bg-white/[0.04] dark:text-sky-100 dark:hover:bg-white/10"
                                                :aria-label="`View ${offering} prospectus in a new tab`"
                                            >
                                                <span class="min-w-0 flex-1">{{
                                                    offering
                                                }}</span>
                                                <span
                                                    class="hidden shrink-0 items-center gap-1 rounded-full bg-white px-2.5 py-1 text-[0.6rem] font-semibold tracking-wide text-[#9b1c31] uppercase transition-colors group-hover/offering:bg-[#9b1c31] group-hover/offering:text-white sm:inline-flex dark:bg-white/10 dark:text-rose-200"
                                                >
                                                    Prospectus PDF
                                                    <ExternalLink
                                                        class="size-3"
                                                        aria-hidden="true"
                                                    />
                                                </span>
                                                <ExternalLink
                                                    class="size-3.5 shrink-0 text-[#9b1c31] sm:hidden dark:text-rose-300"
                                                    aria-hidden="true"
                                                />
                                            </a>
                                            <span
                                                v-else
                                                class="flex min-w-0 items-center gap-3 rounded-md bg-white/70 px-4 py-3 font-medium text-slate-700 dark:bg-white/[0.04] dark:text-slate-300"
                                            >
                                                <span class="min-w-0 flex-1">{{
                                                    offering
                                                }}</span>
                                                <span
                                                    class="hidden shrink-0 items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-[0.6rem] font-semibold tracking-wide text-slate-500 uppercase sm:inline-flex dark:bg-white/10 dark:text-slate-300"
                                                >
                                                    Prospectus pending
                                                    <FileText
                                                        class="size-3"
                                                        aria-hidden="true"
                                                    />
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </Transition>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white py-16 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between gap-4">
                    <div
                        data-scroll-section="campus-facilities-heading"
                        :class="
                            revealClasses('campus-facilities-heading', 'right')
                        "
                    >
                        <h4
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Facilities
                        </h4>
                        <h2
                            class="mt-3 max-w-2xl font-serif text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                        >
                            Spaces for learning, research, service, and campus
                            life
                        </h2>
                    </div>
                    <div
                        class="hidden shrink-0 items-center gap-2 text-xs font-semibold sm:flex"
                    >
                        <span
                            class="rounded-full bg-[#e6f3f5] px-3 py-1.5 text-[#0b6680] dark:bg-sky-300/10 dark:text-sky-200"
                        >
                            {{ campus.facilities.length }} facilities
                        </span>
                        <span
                            class="rounded-full bg-slate-100 px-3 py-1.5 text-slate-600 dark:bg-white/10 dark:text-slate-300"
                        >
                            {{ campus.facilityGallery.length }} photos
                        </span>
                    </div>
                </div>

                <div
                    v-if="campus.facilityGallery.length"
                    class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-flow-dense lg:auto-rows-[15rem] lg:grid-cols-6"
                >
                    <figure
                        v-for="(facility, index) in campus.facilityGallery"
                        :key="facility.image"
                        :data-scroll-section="`campus-facility-${index}`"
                        class="group relative min-h-64 overflow-hidden rounded-md border border-slate-200 bg-slate-100 shadow-sm shadow-slate-900/5 lg:min-h-0 dark:border-white/10 dark:bg-slate-800"
                        :class="[
                            facility.featured
                                ? 'sm:col-span-2 lg:col-span-4 lg:row-span-2'
                                : facility.wide
                                  ? 'sm:col-span-2 lg:col-span-2 lg:row-span-2'
                                  : 'lg:col-span-2',
                            revealClasses(`campus-facility-${index}`, 'up'),
                        ]"
                        :style="staggerDelay(`campus-facility-${index}`, index)"
                    >
                        <img
                            :src="facility.image"
                            :alt="facility.alt"
                            loading="lazy"
                            decoding="async"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105 motion-reduce:transform-none motion-reduce:transition-none"
                        />
                        <figcaption
                            v-if="
                                facility.title ||
                                facility.description ||
                                facility.category ||
                                facility.status
                            "
                            class="absolute inset-x-0 bottom-0 bg-linear-to-t from-slate-950/90 via-slate-950/65 to-transparent px-5 pt-16 pb-5 text-white"
                        >
                            <div class="flex flex-wrap items-center gap-2">
                                <p
                                    v-if="facility.category"
                                    class="text-xs font-semibold tracking-wide text-[#f2b705] uppercase"
                                >
                                    {{ facility.category }}
                                </p>
                                <span
                                    v-if="facility.status"
                                    class="rounded-full px-2.5 py-1 text-[0.65rem] font-semibold tracking-wide uppercase"
                                    :class="
                                        facility.status === 'Not functional'
                                            ? 'bg-rose-500 text-white'
                                            : 'bg-amber-300 text-slate-950'
                                    "
                                >
                                    {{ facility.status }}
                                </span>
                            </div>
                            <h4
                                v-if="facility.title"
                                class="mt-1 font-semibold"
                            >
                                {{ facility.title }}
                            </h4>
                            <p
                                v-if="facility.description"
                                class="mt-1 max-w-lg text-sm leading-6 text-sky-100"
                            >
                                {{ facility.description }}
                            </p>
                        </figcaption>
                    </figure>
                </div>
                <div
                    v-else
                    data-scroll-section="campus-facilities-empty"
                    class="mt-6 rounded-md border border-dashed border-slate-300 px-6 py-12 text-center text-sm text-slate-500 dark:border-white/15 dark:text-slate-400"
                    :class="revealClasses('campus-facilities-empty')"
                >
                    Facility photos will be added soon.
                </div>
            </div>
        </section>

        <!-- <section class="bg-white py-16 dark:bg-slate-900">
            <div
                class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8"
            >
                <div
                    data-scroll-section="campus-life-heading"
                    :class="revealClasses('campus-life-heading', 'right')"
                >
                    <HeartHandshake
                        class="size-7 text-[#9b1c31] dark:text-rose-300"
                        aria-hidden="true"
                    />
                    <p
                        class="mt-5 text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        Campus Life
                    </p>
                    <h2
                        class="mt-3 font-serif text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                    >
                        Student experiences beyond the classroom
                    </h2>
                </div>

                <ul class="grid gap-3 sm:grid-cols-2">
                    <li
                        v-for="(item, index) in campus.campusLife"
                        :key="item"
                        :data-scroll-section="`campus-life-${index}`"
                        class="flex gap-3 rounded-md border border-slate-200 p-5 text-sm leading-6 text-slate-700 dark:border-white/10 dark:text-slate-200"
                        :class="revealClasses(`campus-life-${index}`, 'up')"
                        :style="staggerDelay(`campus-life-${index}`, index)"
                    >
                        <BadgeCheck
                            class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                            aria-hidden="true"
                        />
                        {{ item }}
                    </li>
                </ul>
            </div>
        </section> -->

        <section class="bg-[#1f007c] py-16 text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="max-w-2xl"
                    data-scroll-section="campus-services-heading"
                    :class="revealClasses('campus-services-heading', 'right')"
                >
                    <ShieldCheck
                        class="size-7 text-emerald-300"
                        aria-hidden="true"
                    />
                    <p
                        class="mt-5 text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                    >
                        Services
                    </p>
                    <h2
                        class="mt-3 font-serif text-3xl font-semibold tracking-tight"
                    >
                        Campus support and student service points
                    </h2>
                </div>

                <div
                    v-if="campus.serviceHighlights?.length"
                    class="mt-8 grid gap-5 md:grid-cols-2"
                >
                    <article
                        v-for="(service, index) in campus.serviceHighlights ??
                        []"
                        :key="service.title"
                        :data-scroll-section="`campus-service-highlight-${index}`"
                        class="overflow-hidden rounded-lg border border-white/10 bg-white/[0.07] shadow-lg shadow-black/10"
                        :class="
                            revealClasses(
                                `campus-service-highlight-${index}`,
                                'up',
                            )
                        "
                        :style="
                            staggerDelay(
                                `campus-service-highlight-${index}`,
                                index,
                            )
                        "
                    >
                        <div
                            class="grid h-56 gap-1 bg-slate-950/40"
                            :class="
                                service.images.length === 1
                                    ? 'grid-cols-1'
                                    : 'grid-cols-[minmax(0,1.55fr)_minmax(5rem,0.7fr)]'
                            "
                        >
                            <img
                                :src="service.images[0].image"
                                :alt="service.images[0].alt"
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-if="service.images.length > 1"
                                class="grid min-h-0 gap-1"
                            >
                                <img
                                    v-for="image in service.images.slice(1)"
                                    :key="image.image"
                                    :src="image.image"
                                    :alt="image.alt"
                                    class="h-full min-h-0 w-full object-cover"
                                />
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-3">
                                <span
                                    class="grid size-9 shrink-0 place-items-center rounded-md bg-emerald-300/15 text-emerald-300"
                                >
                                    <ShieldCheck
                                        class="size-5"
                                        aria-hidden="true"
                                    />
                                </span>
                                <h3 class="text-lg font-semibold">
                                    {{ service.title }}
                                </h3>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-sky-100">
                                {{ service.description }}
                            </p>
                        </div>
                    </article>
                </div>

                <ul
                    v-else
                    class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <li
                        v-for="(service, index) in campus.services"
                        :key="service"
                        :data-scroll-section="`campus-service-${index}`"
                        class="flex gap-3 rounded-md border border-white/10 bg-white/[0.06] p-5 text-sm leading-6 text-sky-100"
                        :class="revealClasses(`campus-service-${index}`, 'up')"
                        :style="staggerDelay(`campus-service-${index}`, index)"
                    >
                        <ShieldCheck
                            class="mt-1 size-4 shrink-0 text-emerald-300"
                            aria-hidden="true"
                        />
                        {{ service }}
                    </li>
                </ul>
            </div>
        </section>

        <section class="bg-[#f7f8f5] py-16 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
                    <div
                        data-scroll-section="campus-government-heading"
                        :class="
                            revealClasses('campus-government-heading', 'right')
                        "
                    >
                        <Sparkles
                            class="size-7 text-[#1711d4] dark:text-sky-200"
                            aria-hidden="true"
                        />
                        <p
                            class="mt-5 text-lg font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            University Student Government
                        </p>
                        <h2
                            class="mt-3 font-serif text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                        >
                            {{ campus.studentGovernment.name }}
                        </h2>
                        <p
                            class="mt-4 text-lg font-semibold text-[#0b6680] dark:text-sky-300"
                        >
                            {{ campus.studentGovernment.focus }}
                        </p>
                        <p
                            class="mt-3 text-sm text-slate-600 dark:text-slate-300"
                        >
                            Adviser:
                            <span class="font-semibold">{{
                                campus.studentGovernment.adviser
                            }}</span>
                        </p>
                    </div>

                    <ul class="grid gap-3">
                        <li
                            v-for="(initiative, index) in campus
                                .studentGovernment.initiatives"
                            :key="initiative"
                            :data-scroll-section="`campus-government-initiative-${index}`"
                            class="flex items-center gap-4 rounded-md bg-white p-5 text-lg font-medium text-slate-700 shadow-sm shadow-[#1711d4]/10 dark:bg-white/5 dark:text-slate-200 dark:shadow-black/20"
                            :class="
                                revealClasses(
                                    `campus-government-initiative-${index}`,
                                    'up',
                                )
                            "
                            :style="
                                staggerDelay(
                                    `campus-government-initiative-${index}`,
                                    index,
                                )
                            "
                        >
                            <Sparkles
                                class="size-4 shrink-0 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            {{ initiative }}
                        </li>
                    </ul>
                </div>

                <div
                    v-if="campus.studentGovernment.activities.length"
                    class="mt-12 grid gap-6 lg:grid-cols-2"
                >
                    <article
                        v-for="(activity, index) in campus.studentGovernment
                            .activities"
                        :key="activity.title"
                        :data-scroll-section="`campus-government-activity-${index}`"
                        class="overflow-hidden rounded-lg bg-white shadow-md shadow-[#1711d4]/10 dark:bg-white/5 dark:shadow-black/20"
                        :class="
                            revealClasses(
                                `campus-government-activity-${index}`,
                                'up',
                            )
                        "
                        :style="
                            staggerDelay(
                                `campus-government-activity-${index}`,
                                index,
                            )
                        "
                    >
                        <div
                            v-if="activity.images.length"
                            class="grid grid-cols-2 gap-1 bg-slate-200 dark:bg-slate-800"
                        >
                            <img
                                v-for="image in activity.images"
                                :key="image.image"
                                :src="image.image"
                                :alt="image.alt"
                                class="aspect-4/3 size-full object-cover"
                                loading="lazy"
                            />
                        </div>
                        <div class="p-6">
                            <p
                                class="text-lg font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                {{ activity.date }}
                            </p>
                            <h3
                                class="mt-2 text-xl font-semibold text-slate-950 dark:text-white"
                            >
                                {{ activity.title }}
                            </h3>
                            <p
                                class="mt-3 text-lg leading-8 text-slate-600 dark:text-slate-300"
                            >
                                {{ activity.description }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Updates
                        </p>
                        <h2
                            class="mt-3 font-serif text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                        >
                            Latest campus notices
                        </h2>
                    </div>
                    <Link
                        :href="home().url + '#campuses'"
                        class="inline-flex min-h-11 items-center gap-2 rounded-md border border-slate-300 bg-white px-4 text-sm font-semibold text-[#1711d4] transition hover:border-[#1711d4]/40 hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:text-sky-100"
                    >
                        All campuses
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </Link>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <article
                        v-for="update in campus.updates"
                        :key="update.title"
                        class="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div
                            v-if="update.images?.length"
                            class="relative border-b border-slate-200 bg-slate-100 dark:border-white/10 dark:bg-slate-800"
                        >
                            <div
                                class="flex snap-x snap-mandatory overflow-x-auto"
                                tabindex="0"
                                :aria-label="`${update.title} photo gallery`"
                            >
                                <img
                                    v-for="image in update.images"
                                    :key="image.image"
                                    :src="image.image"
                                    :alt="image.alt"
                                    class="aspect-video w-full shrink-0 snap-center object-cover"
                                    loading="lazy"
                                    decoding="async"
                                />
                            </div>
                            <span
                                class="absolute right-3 bottom-3 rounded-full bg-slate-950/75 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur-sm"
                            >
                                {{ update.images.length }}
                                {{
                                    update.images.length === 1
                                        ? 'photo'
                                        : 'photos'
                                }}
                            </span>
                        </div>
                        <div class="p-6">
                            <p
                                class="inline-flex items-center gap-2 text-xs font-semibold text-[#0b6680] dark:text-sky-300"
                            >
                                <CalendarDays
                                    class="size-3.5"
                                    aria-hidden="true"
                                />
                                {{ update.date }}
                            </p>
                            <h3
                                class="mt-4 font-semibold text-slate-950 dark:text-white"
                            >
                                {{ update.title }}
                            </h3>
                            <p
                                class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300"
                            >
                                {{ update.summary }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-white py-12 dark:bg-slate-900">
            <div
                class="mx-auto flex max-w-7xl gap-3 overflow-x-auto px-4 sm:px-6 lg:px-8"
                aria-label="Other campuses"
            >
                <Link
                    v-for="item in campuses"
                    :key="item.slug"
                    :href="campusShow(item.slug)"
                    class="inline-flex min-h-11 shrink-0 items-center rounded-md border px-4 text-sm font-semibold transition"
                    :class="
                        item.slug === campus.slug
                            ? 'border-[#1711d4] bg-[#1711d4] text-white'
                            : 'border-slate-200 text-slate-700 hover:border-[#1711d4]/40 hover:text-[#1711d4] dark:border-white/10 dark:text-slate-200 dark:hover:text-sky-200'
                    "
                >
                    {{ item.name }}
                </Link>
            </div>
        </section>
    </PublicSiteLayout>
</template>

<style scoped>
.campus-hero-image {
    animation: campus-hero-zoom 15s ease-in-out infinite alternate;
    transform: scale(1.03);
    transform-origin: center;
    will-change: transform;
}

@keyframes campus-hero-zoom {
    from {
        transform: scale(1);
    }

    to {
        transform: scale(1.12);
    }
}

@media (prefers-reduced-motion: reduce) {
    .campus-hero-image {
        animation: none;
        transform: scale(1.03);
    }
}
</style>
