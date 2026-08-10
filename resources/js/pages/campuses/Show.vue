<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    ExternalLink,
    FileText,
    Mail,
    MapPin,
    Phone,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
import type { CSSProperties } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';

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

type CampusLifeHighlight = {
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
    campusLifeOverview: string | null;
    campusLifeHighlights: CampusLifeHighlight[];
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
const activeCampusLifePhoto = ref<Record<number, number>>({});
const activeServiceHighlightPhoto = ref<Record<number, number>>({});
const activeGovernmentActivityPhoto = ref<Record<number, number>>({});
const activeUpdatePhoto = ref<Record<number, number>>({});
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

const isFacilitiesRevealSection = (section: string): boolean =>
    section.startsWith('campus-facility') ||
    section.startsWith('campus-facilities');

const setSectionVisibility = (section: string, isVisible: boolean): void => {
    const nextVisibleSections = new Set(visibleSections.value);

    if (isVisible) {
        nextVisibleSections.add(section);
    } else if (isFacilitiesRevealSection(section)) {
        return;
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
        [
            'transition-all ease-out will-change-transform motion-reduce:translate-x-0 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:blur-0 motion-reduce:transition-none',
            isFacilitiesRevealSection(section)
                ? 'duration-300'
                : 'duration-700',
        ].join(' '),
        isSectionVisible(section)
            ? 'translate-x-0 translate-y-0 opacity-100 blur-0'
            : `${revealOffset[direction]} opacity-0 blur-[2px]`,
    ].join(' ');

const revealDelay = (section: string, index: number): number =>
    isFacilitiesRevealSection(section) ? Math.min(index * 30, 150) : index * 80;

const staggerDelay = (section: string, index: number): CSSProperties => ({
    transitionDelay: isSectionVisible(section)
        ? `${revealDelay(section, index)}ms`
        : '0ms',
});

const setCampusLifePhoto = (highlightIndex: number, event: Event): void => {
    const slider = event.currentTarget as HTMLElement;
    const slideWidth = Math.max(slider.clientWidth, 1);
    const photoIndex = Math.round(slider.scrollLeft / slideWidth);

    activeCampusLifePhoto.value = {
        ...activeCampusLifePhoto.value,
        [highlightIndex]: photoIndex,
    };
};

const scrollCampusLifePhoto = (
    highlightIndex: number,
    event: MouseEvent,
    direction: -1 | 1,
): void => {
    const sliderFrame = (event.currentTarget as HTMLElement).closest(
        '[data-campus-life-photo-frame]',
    );
    const slider = sliderFrame?.querySelector<HTMLElement>(
        '[data-campus-life-photo-slider]',
    );
    const photoCount =
        props.campus.campusLifeHighlights[highlightIndex]?.images.length ?? 0;

    if (!slider || photoCount === 0) {
        return;
    }

    const slideWidth = Math.max(slider.clientWidth, 1);
    const currentIndex =
        activeCampusLifePhoto.value[highlightIndex] ??
        Math.round(slider.scrollLeft / slideWidth);
    const nextIndex = Math.min(
        Math.max(currentIndex + direction, 0),
        photoCount - 1,
    );

    activeCampusLifePhoto.value = {
        ...activeCampusLifePhoto.value,
        [highlightIndex]: nextIndex,
    };
    slider.scrollTo({
        left: slideWidth * nextIndex,
        behavior: 'smooth',
    });
};

const setServiceHighlightPhoto = (serviceIndex: number, event: Event): void => {
    const slider = event.currentTarget as HTMLElement;
    const slideWidth = Math.max(slider.clientWidth, 1);
    const photoIndex = Math.round(slider.scrollLeft / slideWidth);

    activeServiceHighlightPhoto.value = {
        ...activeServiceHighlightPhoto.value,
        [serviceIndex]: photoIndex,
    };
};

const scrollServiceHighlightPhoto = (
    serviceIndex: number,
    event: MouseEvent,
    direction: -1 | 1,
): void => {
    const sliderFrame = (event.currentTarget as HTMLElement).closest(
        '[data-service-photo-frame]',
    );
    const slider = sliderFrame?.querySelector<HTMLElement>(
        '[data-service-photo-slider]',
    );
    const photoCount =
        props.campus.serviceHighlights?.[serviceIndex]?.images.length ?? 0;

    if (!slider || photoCount === 0) {
        return;
    }

    const slideWidth = Math.max(slider.clientWidth, 1);
    const currentIndex =
        activeServiceHighlightPhoto.value[serviceIndex] ??
        Math.round(slider.scrollLeft / slideWidth);
    const nextIndex = Math.min(
        Math.max(currentIndex + direction, 0),
        photoCount - 1,
    );

    activeServiceHighlightPhoto.value = {
        ...activeServiceHighlightPhoto.value,
        [serviceIndex]: nextIndex,
    };
    slider.scrollTo({
        left: slideWidth * nextIndex,
        behavior: 'smooth',
    });
};

const setGovernmentActivityPhoto = (
    activityIndex: number,
    event: Event,
): void => {
    const slider = event.currentTarget as HTMLElement;
    const slideWidth = Math.max(slider.clientWidth, 1);
    const photoIndex = Math.round(slider.scrollLeft / slideWidth);

    activeGovernmentActivityPhoto.value = {
        ...activeGovernmentActivityPhoto.value,
        [activityIndex]: photoIndex,
    };
};

const scrollGovernmentActivityPhoto = (
    activityIndex: number,
    event: MouseEvent,
    direction: -1 | 1,
): void => {
    const sliderFrame = (event.currentTarget as HTMLElement).closest(
        '[data-usg-photo-frame]',
    );
    const slider = sliderFrame?.querySelector<HTMLElement>(
        '[data-usg-photo-slider]',
    );
    const photoCount =
        props.campus.studentGovernment.activities[activityIndex]?.images
            .length ?? 0;

    if (!slider || photoCount === 0) {
        return;
    }

    const slideWidth = Math.max(slider.clientWidth, 1);
    const currentIndex =
        activeGovernmentActivityPhoto.value[activityIndex] ??
        Math.round(slider.scrollLeft / slideWidth);
    const nextIndex = Math.min(
        Math.max(currentIndex + direction, 0),
        photoCount - 1,
    );

    activeGovernmentActivityPhoto.value = {
        ...activeGovernmentActivityPhoto.value,
        [activityIndex]: nextIndex,
    };
    slider.scrollTo({
        left: slideWidth * nextIndex,
        behavior: 'smooth',
    });
};

const setUpdatePhoto = (updateIndex: number, event: Event): void => {
    const slider = event.currentTarget as HTMLElement;
    const slideWidth = Math.max(slider.clientWidth, 1);
    const photoIndex = Math.round(slider.scrollLeft / slideWidth);

    activeUpdatePhoto.value = {
        ...activeUpdatePhoto.value,
        [updateIndex]: photoIndex,
    };
};

const scrollUpdatePhoto = (
    updateIndex: number,
    event: MouseEvent,
    direction: -1 | 1,
): void => {
    const sliderFrame = (event.currentTarget as HTMLElement).closest(
        '[data-update-photo-frame]',
    );
    const slider = sliderFrame?.querySelector<HTMLElement>(
        '[data-update-photo-slider]',
    );
    const photoCount = props.campus.updates[updateIndex]?.images?.length ?? 0;

    if (!slider || photoCount === 0) {
        return;
    }

    const slideWidth = Math.max(slider.clientWidth, 1);
    const currentIndex =
        activeUpdatePhoto.value[updateIndex] ??
        Math.round(slider.scrollLeft / slideWidth);
    const nextIndex = Math.min(
        Math.max(currentIndex + direction, 0),
        photoCount - 1,
    );

    activeUpdatePhoto.value = {
        ...activeUpdatePhoto.value,
        [updateIndex]: nextIndex,
    };
    slider.scrollTo({
        left: slideWidth * nextIndex,
        behavior: 'smooth',
    });
};

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
        activeCampusLifePhoto.value = {};
        activeServiceHighlightPhoto.value = {};
        activeGovernmentActivityPhoto.value = {};
        activeUpdatePhoto.value = {};
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
                        class="mt-6 text-justify text-lg leading-8 whitespace-pre-line text-slate-600 dark:text-slate-300"
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
                                class="absolute inset-x-0 top-0 h-1 bg-[#1711d4]"
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
                            Spaces for Learning, Research, and Service
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
                                class="mt-1 max-w-lg text-justify text-sm leading-6 text-sky-100"
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

        <section
            v-if="campus.campusLifeHighlights.length"
            class="bg-[#f7f8f5] py-20 dark:bg-slate-950"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-end"
                    data-scroll-section="campus-life-heading"
                    :class="revealClasses('campus-life-heading', 'right')"
                >
                    <div>
                        <p
                            class="text-lg font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Campus Life
                        </p>
                        <h2
                            class="mt-3 max-w-xl font-serif text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                        >
                            Student Experiences Beyond the Classroom
                        </h2>
                    </div>
                    <p
                        v-if="campus.campusLifeOverview"
                        class="max-w-3xl text-justify text-lg leading-8 text-slate-600 dark:text-slate-300"
                    >
                        {{ campus.campusLifeOverview }}
                    </p>
                </div>

                <div class="mt-14 grid gap-16 lg:gap-20">
                    <article
                        v-for="(
                            highlight, index
                        ) in campus.campusLifeHighlights"
                        :key="highlight.title"
                        :data-scroll-section="`campus-life-${index}`"
                        class="grid gap-7 lg:grid-cols-12 lg:items-center"
                        :class="revealClasses(`campus-life-${index}`, 'up')"
                        :style="staggerDelay(`campus-life-${index}`, index)"
                    >
                        <div
                            class="group/campus-life-slider relative isolate aspect-[16/10] overflow-hidden bg-[#160a45] lg:col-span-7"
                            :class="index % 2 === 1 ? 'lg:order-2' : ''"
                            data-campus-life-photo-frame
                        >
                            <div
                                class="campus-life-photo-slider flex size-full snap-x snap-mandatory overflow-x-auto scroll-smooth"
                                :aria-label="`${highlight.title} photo slider`"
                                data-campus-life-photo-slider
                                tabindex="0"
                                @scroll.passive="
                                    setCampusLifePhoto(index, $event)
                                "
                            >
                                <img
                                    v-for="image in highlight.images"
                                    :key="image.image"
                                    :src="image.image"
                                    :alt="image.alt"
                                    class="size-full shrink-0 snap-center object-contain"
                                    loading="lazy"
                                />
                            </div>

                            <div
                                class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-linear-to-t from-[#160a45]/75 to-transparent"
                                aria-hidden="true"
                            ></div>

                            <template v-if="highlight.images.length > 1">
                                <button
                                    type="button"
                                    class="absolute top-1/2 left-3 inline-flex size-10 -translate-y-1/2 items-center justify-center text-white/75 drop-shadow-md transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                    :aria-label="`Show previous photo for ${highlight.title}`"
                                    @click="
                                        scrollCampusLifePhoto(index, $event, -1)
                                    "
                                >
                                    <ChevronLeft
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </button>
                                <button
                                    type="button"
                                    class="absolute top-1/2 right-3 inline-flex size-10 -translate-y-1/2 items-center justify-center text-white/75 drop-shadow-md transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                    :aria-label="`Show next photo for ${highlight.title}`"
                                    @click="
                                        scrollCampusLifePhoto(index, $event, 1)
                                    "
                                >
                                    <ChevronRight
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </button>

                                <div
                                    class="pointer-events-none absolute bottom-3 left-1/2 flex -translate-x-1/2 items-center gap-1.5"
                                    aria-hidden="true"
                                >
                                    <span
                                        v-for="(
                                            image, imageIndex
                                        ) in highlight.images"
                                        :key="`${image.image}-indicator`"
                                        class="size-1.5 rounded-full transition"
                                        :class="
                                            (activeCampusLifePhoto[index] ??
                                                0) === imageIndex
                                                ? 'bg-white'
                                                : 'bg-white/45'
                                        "
                                    ></span>
                                </div>
                            </template>
                        </div>

                        <div
                            class="lg:col-span-5"
                            :class="index % 2 === 1 ? 'lg:order-1' : ''"
                        >
                            <p
                                class="text-sm font-semibold tracking-[0.18em] text-[#0b6680] uppercase dark:text-sky-300"
                            >
                                Student organization 0{{ index + 1 }}
                            </p>
                            <h3
                                class="mt-3 font-serif text-3xl leading-tight font-semibold text-slate-950 dark:text-white"
                            >
                                {{ highlight.title }}
                            </h3>
                            <p
                                class="mt-5 text-justify text-lg leading-8 text-slate-600 dark:text-slate-300"
                            >
                                {{ highlight.description }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-[#1f007c] py-16 text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="max-w-2xl"
                    data-scroll-section="campus-services-heading"
                    :class="revealClasses('campus-services-heading', 'right')"
                >
                    <p
                        class="text-lg font-semibold tracking-wide text-[#f2b705] uppercase"
                    >
                        Services
                    </p>
                    <h2
                        class="mt-3 font-serif text-3xl font-semibold tracking-tight"
                    >
                        Campus Support and Student Service Points
                    </h2>
                </div>

                <div
                    v-if="campus.serviceHighlights?.length"
                    class="mt-10 grid gap-x-8 gap-y-12 md:grid-cols-2"
                >
                    <article
                        v-for="(service, index) in campus.serviceHighlights ??
                        []"
                        :key="service.title"
                        :data-scroll-section="`campus-service-highlight-${index}`"
                        class="group"
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
                            class="relative isolate aspect-[16/10] overflow-hidden bg-[#160a45]"
                            data-service-photo-frame
                        >
                            <div
                                class="service-photo-slider flex size-full snap-x snap-mandatory scrollbar-none overflow-x-auto scroll-smooth"
                                :aria-label="`${service.title} photo slider`"
                                data-service-photo-slider
                                @scroll.passive="
                                    setServiceHighlightPhoto(index, $event)
                                "
                                tabindex="0"
                            >
                                <img
                                    v-for="image in service.images"
                                    :key="image.image"
                                    :src="image.image"
                                    :alt="image.alt"
                                    class="size-full shrink-0 snap-center object-contain"
                                    loading="lazy"
                                />
                            </div>
                            <div
                                class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-linear-to-t from-[#160a45]/75 to-transparent"
                                aria-hidden="true"
                            ></div>
                            <template v-if="service.images.length > 1">
                                <button
                                    type="button"
                                    class="absolute top-1/2 left-3 inline-flex size-10 -translate-y-1/2 items-center justify-center text-white/75 drop-shadow-md transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                    :aria-label="`Previous ${service.title} photo`"
                                    @click="
                                        scrollServiceHighlightPhoto(
                                            index,
                                            $event,
                                            -1,
                                        )
                                    "
                                >
                                    <ChevronLeft
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </button>
                                <button
                                    type="button"
                                    class="absolute top-1/2 right-3 inline-flex size-10 -translate-y-1/2 items-center justify-center text-white/75 drop-shadow-md transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                    :aria-label="`Next ${service.title} photo`"
                                    @click="
                                        scrollServiceHighlightPhoto(
                                            index,
                                            $event,
                                            1,
                                        )
                                    "
                                >
                                    <ChevronRight
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </button>
                                <div
                                    class="pointer-events-none absolute bottom-3 left-1/2 flex -translate-x-1/2 items-center gap-1.5"
                                    aria-hidden="true"
                                >
                                    <span
                                        v-for="(
                                            _, imageIndex
                                        ) in service.images"
                                        :key="imageIndex"
                                        class="size-1.5 rounded-full transition"
                                        :class="
                                            (activeServiceHighlightPhoto[
                                                index
                                            ] ?? 0) === imageIndex
                                                ? 'bg-white'
                                                : 'bg-white/45'
                                        "
                                    ></span>
                                </div>
                            </template>
                        </div>
                        <div class="mt-5 grid gap-3">
                            <p
                                class="text-sm font-semibold tracking-[0.18em] text-[#f2b705] uppercase"
                            >
                                Service point {{ index + 1 }}
                            </p>
                            <h3 class="text-2xl leading-tight font-semibold">
                                {{ service.title }}
                            </h3>
                            <p
                                class="max-w-2xl text-justify text-lg leading-8 text-sky-100"
                            >
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
                        class="bg-white/[0.08] p-5 text-lg leading-8 text-sky-100"
                        :class="revealClasses(`campus-service-${index}`, 'up')"
                        :style="staggerDelay(`campus-service-${index}`, index)"
                    >
                        {{ service }}
                    </li>
                </ul>
            </div>
        </section>

        <section class="bg-[#f7f8f5] py-16 sm:py-20 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="border-y border-slate-200 py-10 sm:py-12 dark:border-white/10"
                    data-scroll-section="campus-government-heading"
                    :class="revealClasses('campus-government-heading', 'right')"
                >
                    <div class="flex items-center gap-4">
                        <span
                            class="h-0.5 w-10 bg-[#f2b705]"
                            aria-hidden="true"
                        ></span>
                        <p
                            class="text-sm font-semibold tracking-[0.16em] text-[#1711d4] uppercase dark:text-blue-300"
                        >
                            University Student Government
                        </p>
                    </div>
                    <div
                        class="mt-7 grid gap-10 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-end"
                    >
                        <div>
                            <h2
                                class="max-w-4xl font-serif text-4xl leading-tight font-semibold tracking-tight text-slate-950 sm:text-5xl dark:text-white"
                            >
                                {{ campus.studentGovernment.name }}
                            </h2>
                            <p
                                class="mt-6 max-w-3xl text-xl leading-8 font-semibold text-[#1711d4] dark:text-blue-300"
                            >
                                {{ campus.studentGovernment.focus }}
                            </p>
                        </div>
                        <div
                            class="border-t border-slate-300 pt-6 lg:border-t-0 lg:border-l lg:pt-0 lg:pl-8 dark:border-white/15"
                        >
                            <span
                                class="mb-4 block h-1 w-10 bg-[#f2b705]"
                                aria-hidden="true"
                            ></span>
                            <p
                                class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase dark:text-slate-400"
                            >
                                Adviser
                            </p>
                            <p
                                class="text-lg font-semibold text-slate-700 dark:text-slate-200"
                            >
                                {{ campus.studentGovernment.adviser }}
                            </p>
                        </div>
                    </div>
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
                        class="overflow-hidden bg-white/80 dark:bg-white/5"
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
                            class="relative isolate aspect-[16/10] overflow-hidden bg-[#160a45]"
                            data-usg-photo-frame
                        >
                            <div
                                class="usg-photo-slider flex size-full snap-x snap-mandatory overflow-x-auto scroll-smooth"
                                :aria-label="`${activity.title} photo slider`"
                                data-usg-photo-slider
                                @scroll.passive="
                                    setGovernmentActivityPhoto(index, $event)
                                "
                                tabindex="0"
                            >
                                <img
                                    v-for="image in activity.images"
                                    :key="image.image"
                                    :src="image.image"
                                    :alt="image.alt"
                                    class="size-full shrink-0 snap-center object-contain"
                                    loading="lazy"
                                />
                            </div>
                            <div
                                class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-linear-to-t from-[#160a45]/75 to-transparent"
                                aria-hidden="true"
                            ></div>
                            <template v-if="activity.images.length > 1">
                                <button
                                    type="button"
                                    class="absolute top-1/2 left-3 inline-flex size-10 -translate-y-1/2 items-center justify-center text-white/75 drop-shadow-md transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                    :aria-label="`Previous ${activity.title} photo`"
                                    @click="
                                        scrollGovernmentActivityPhoto(
                                            index,
                                            $event,
                                            -1,
                                        )
                                    "
                                >
                                    <ChevronLeft
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </button>
                                <button
                                    type="button"
                                    class="absolute top-1/2 right-3 inline-flex size-10 -translate-y-1/2 items-center justify-center text-white/75 drop-shadow-md transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                    :aria-label="`Next ${activity.title} photo`"
                                    @click="
                                        scrollGovernmentActivityPhoto(
                                            index,
                                            $event,
                                            1,
                                        )
                                    "
                                >
                                    <ChevronRight
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </button>
                                <div
                                    class="pointer-events-none absolute bottom-3 left-1/2 flex -translate-x-1/2 items-center gap-1.5"
                                    aria-hidden="true"
                                >
                                    <span
                                        v-for="(
                                            _, imageIndex
                                        ) in activity.images"
                                        :key="imageIndex"
                                        class="size-1.5 rounded-full transition"
                                        :class="
                                            (activeGovernmentActivityPhoto[
                                                index
                                            ] ?? 0) === imageIndex
                                                ? 'bg-white'
                                                : 'bg-white/45'
                                        "
                                    ></span>
                                </div>
                            </template>
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
                                class="mt-3 text-justify text-lg leading-8 text-slate-600 dark:text-slate-300"
                            >
                                {{ activity.description }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-[#f7f8f5] py-20 dark:bg-slate-950">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid gap-10 lg:grid-cols-[22rem_minmax(0,1fr)] lg:items-start"
                >
                    <div class="lg:sticky lg:top-24">
                        <p
                            class="text-lg font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Updates
                        </p>
                        <h2
                            class="mt-3 font-serif text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                        >
                            Latest Campus Notices
                        </h2>
                        <p
                            class="mt-4 text-justify text-lg leading-8 text-slate-600 dark:text-slate-300"
                        >
                            Timely campus advisories, service updates, and
                            academic announcements.
                        </p>
                    </div>

                    <ol class="grid">
                        <li
                            v-for="(update, updateIndex) in campus.updates"
                            :key="update.title"
                            class="group relative grid gap-5 py-9 md:grid-cols-[10rem_minmax(0,1fr)]"
                        >
                            <time
                                class="text-base leading-7 font-semibold text-[#0b6680] md:pt-1 dark:text-sky-300"
                            >
                                {{ update.date }}
                            </time>
                            <div
                                class="relative max-w-3xl pl-5 before:absolute before:top-1.5 before:bottom-1 before:left-0 before:w-1 before:bg-[#f2b705] before:transition-all before:duration-200 group-hover:before:bg-[#1711d4] dark:before:bg-[#f2b705]/80 dark:group-hover:before:bg-sky-300"
                            >
                                <div
                                    v-if="update.images?.length"
                                    class="relative isolate mb-6 aspect-[16/10] overflow-hidden bg-[#160a45]"
                                    data-update-photo-frame
                                >
                                    <div
                                        class="update-photo-slider flex size-full snap-x snap-mandatory overflow-x-auto scroll-smooth"
                                        :aria-label="`${update.title} photo slider`"
                                        data-update-photo-slider
                                        tabindex="0"
                                        @scroll.passive="
                                            setUpdatePhoto(updateIndex, $event)
                                        "
                                    >
                                        <img
                                            v-for="image in update.images"
                                            :key="image.image"
                                            :src="image.image"
                                            :alt="image.alt"
                                            class="size-full shrink-0 snap-center object-contain"
                                            loading="lazy"
                                        />
                                    </div>

                                    <div
                                        class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-linear-to-t from-[#160a45]/75 to-transparent"
                                        aria-hidden="true"
                                    ></div>

                                    <template v-if="update.images.length > 1">
                                        <button
                                            type="button"
                                            class="absolute top-1/2 left-3 inline-flex size-10 -translate-y-1/2 items-center justify-center text-white/75 drop-shadow-md transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                            :aria-label="`Show previous photo for ${update.title}`"
                                            @click="
                                                scrollUpdatePhoto(
                                                    updateIndex,
                                                    $event,
                                                    -1,
                                                )
                                            "
                                        >
                                            <ChevronLeft
                                                class="size-6"
                                                aria-hidden="true"
                                            />
                                        </button>
                                        <button
                                            type="button"
                                            class="absolute top-1/2 right-3 inline-flex size-10 -translate-y-1/2 items-center justify-center text-white/75 drop-shadow-md transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                            :aria-label="`Show next photo for ${update.title}`"
                                            @click="
                                                scrollUpdatePhoto(
                                                    updateIndex,
                                                    $event,
                                                    1,
                                                )
                                            "
                                        >
                                            <ChevronRight
                                                class="size-6"
                                                aria-hidden="true"
                                            />
                                        </button>

                                        <div
                                            class="pointer-events-none absolute bottom-3 left-1/2 flex -translate-x-1/2 items-center gap-1.5"
                                            aria-hidden="true"
                                        >
                                            <span
                                                v-for="(
                                                    image, imageIndex
                                                ) in update.images"
                                                :key="`${image.image}-indicator`"
                                                class="size-1.5 rounded-full transition"
                                                :class="
                                                    (activeUpdatePhoto[
                                                        updateIndex
                                                    ] ?? 0) === imageIndex
                                                        ? 'bg-white'
                                                        : 'bg-white/45'
                                                "
                                            ></span>
                                        </div>
                                    </template>
                                </div>

                                <h3
                                    class="text-2xl leading-tight font-semibold text-slate-950 transition-colors group-hover:text-[#08047d] dark:text-white dark:group-hover:text-sky-200"
                                >
                                    {{ update.title }}
                                </h3>
                                <p
                                    class="mt-3 text-justify text-lg leading-8 text-slate-600 dark:text-slate-300"
                                >
                                    {{ update.summary }}
                                </p>
                            </div>
                        </li>
                    </ol>
                </div>
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

.campus-life-photo-slider,
.service-photo-slider,
.usg-photo-slider,
.update-photo-slider {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.campus-life-photo-slider::-webkit-scrollbar,
.service-photo-slider::-webkit-scrollbar,
.usg-photo-slider::-webkit-scrollbar,
.update-photo-slider::-webkit-scrollbar {
    display: none;
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
