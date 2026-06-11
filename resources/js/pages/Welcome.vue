<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BookOpen,
    Building2,
    CalendarDays,
    FileText,
    GraduationCap,
    Landmark,
    Megaphone,
    ShieldCheck,
} from 'lucide-vue-next';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import type { Component, CSSProperties } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import WelcomeAtAGlance from '@/pages/welcome-sections/WelcomeAtAGlance.vue';
import WelcomeCampuses from '@/pages/welcome-sections/WelcomeCampuses.vue';
import WelcomeHero from '@/pages/welcome-sections/WelcomeHero.vue';
import { index as newsIndex, show as newsShow } from '@/routes/news';

type Feature = {
    icon: Component;
    title: string;
    description: string;
    href: string;
};

type NewsItem = {
    id: string;
    type: string;
    title: string;
    slug: string;
    excerpt?: string | null;
    date: string | null;
    office: string;
    photoUrl?: string | null;
};

type BannerItem = {
    id: number | string;
    title?: string | null;
    summary?: string | null;
    imageUrl: string;
    link?: string | null;
};

type Campus = {
    slug: string;
    name: string;
    focus: string;
    detail: string;
    location: string;
};

type GlanceStat = {
    key: string;
    label: string;
    value: string;
    scope: string;
    description: string;
    icon:
        | 'accessibility'
        | 'graduates'
        | 'map'
        | 'personnel'
        | 'programs'
        | 'students';
};

type MapHighlight = {
    label: string;
    description: string;
    top: string;
    left: string;
    labelPosition: 'left' | 'right';
};

type Metric = {
    label: string;
    value: string;
    note: string;
};

type RevealDirection = 'down' | 'left' | 'right' | 'up';

const heroImage = 'https://nemsu.edu.ph/files/News/cm-00.jpg';
const fallbackHeroSlide: BannerItem = {
    id: 'nemsu-hero',
    title: 'North Eastern Mindanao State University',
    summary:
        'We drive sustainable development through quality instruction, innovative research, community collaboration, and technological advancement.',
    imageUrl: heroImage,
};

const sectionImages = {
    about: 'https://www.nemsu.edu.ph/files/News/reaffirmation-commitment-to-innovation-and-sustainable-development-01.jpg',
    academics: 'https://www.nemsu.edu.ph/files/Banner/RM-Top-3-banner.jpg',
    research: 'https://nemsu.edu.ph/files/News/REA-00.jpg',
    services: 'https://www.nemsu.edu.ph/files/Banner/BannerCOL-Passer.jpg',
};

const parallaxBackground = (image: string, overlay: string): CSSProperties => ({
    backgroundImage: `${overlay}, url("${image}")`,
});

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['hero']));
const activeHeroIndex = ref(0);
let revealObserver: IntersectionObserver | null = null;
let heroCarouselTimer: ReturnType<typeof window.setInterval> | null = null;
let shouldAutoRotateHero = false;

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

const props = withDefaults(
    defineProps<{
        banners?: BannerItem[];
        featuredNews?: NewsItem | null;
        pressReleases?: NewsItem[];
        announcements?: NewsItem[];
        atAGlanceStats?: GlanceStat[];
        atAGlanceMapHighlights?: MapHighlight[];
    }>(),
    {
        banners: () => [],
        featuredNews: null,
        pressReleases: () => [],
        announcements: () => [],
        atAGlanceStats: () => [],
        atAGlanceMapHighlights: () => [],
    },
);

const heroSlides = computed<BannerItem[]>(() => {
    const banners = props.banners ?? [];

    return [fallbackHeroSlide, ...banners];
});

const activeHeroSlide = computed<BannerItem>(
    () => heroSlides.value[activeHeroIndex.value] ?? fallbackHeroSlide,
);

const hasMultipleHeroSlides = computed(() => heroSlides.value.length > 1);
const isDefaultHeroSlide = computed(
    () => activeHeroSlide.value.id === fallbackHeroSlide.id,
);

const fallbackAtAGlanceStats: GlanceStat[] = [
    {
        key: 'student-population',
        label: 'Current Enrollment',
        value: '33,338',
        scope: 'AY 2025-2026',
        description:
            'First-semester enrollment across eight reporting locations, including Marihatag Extension.',
        icon: 'students',
    },
    {
        key: 'faculty-staff-profile',
        label: 'Faculty and Staff',
        value: '1,563',
        scope: 'Dec. 31, 2025',
        description:
            'Seven-campus HRMO total: 974 plantilla and 589 non-plantilla personnel.',
        icon: 'personnel',
    },
    {
        key: 'academic-programs',
        label: 'Academic Programs',
        value: '99',
        scope: 'Apr. 30, 2026',
        description:
            'Undergraduate, graduate, post-graduate, and professional program offerings.',
        icon: 'programs',
    },
    {
        key: 'pwd-senior-citizens',
        label: 'PWD and Senior Personnel',
        value: '60',
        scope: 'Dec. 31, 2025',
        description:
            'Comprising 43 senior citizens and 17 persons with disabilities.',
        icon: 'accessibility',
    },
];

const fallbackAtAGlanceMapHighlights: MapHighlight[] = [
    {
        label: 'Cantilan',
        description: 'Campus',
        top: '9%',
        left: '41%',
        labelPosition: 'right',
    },
    {
        label: 'Tandag',
        description: 'Main campus',
        top: '28%',
        left: '55%',
        labelPosition: 'right',
    },
    {
        label: 'San Miguel',
        description: 'Campus',
        top: '34%',
        left: '41%',
        labelPosition: 'left',
    },
    {
        label: 'Cagwait',
        description: 'Campus',
        top: '40%',
        left: '59%',
        labelPosition: 'right',
    },
    {
        label: 'Lianga',
        description: 'Campus',
        top: '55%',
        left: '45%',
        labelPosition: 'left',
    },
    {
        label: 'Tagbina',
        description: 'Campus',
        top: '68%',
        left: '55%',
        labelPosition: 'right',
    },
    {
        label: 'Bislig',
        description: 'Campus',
        top: '83%',
        left: '59%',
        labelPosition: 'right',
    },
];

const atAGlanceStats = computed<GlanceStat[]>(() =>
    props.atAGlanceStats.length > 0
        ? props.atAGlanceStats
        : fallbackAtAGlanceStats,
);

const atAGlanceMapHighlights = computed<MapHighlight[]>(() =>
    props.atAGlanceMapHighlights.length > 0
        ? props.atAGlanceMapHighlights
        : fallbackAtAGlanceMapHighlights,
);

const setHeroSlide = (index: number): void => {
    const slideCount = heroSlides.value.length;

    if (slideCount === 0) {
        activeHeroIndex.value = 0;

        return;
    }

    activeHeroIndex.value = (index + slideCount) % slideCount;
};

const startHeroCarousel = (): void => {
    if (
        !shouldAutoRotateHero ||
        !hasMultipleHeroSlides.value ||
        heroCarouselTimer !== null
    ) {
        return;
    }

    heroCarouselTimer = window.setInterval(showNextHeroSlide, 6500);
};

const stopHeroCarousel = (): void => {
    if (heroCarouselTimer === null) {
        return;
    }

    window.clearInterval(heroCarouselTimer);
    heroCarouselTimer = null;
};

const resetHeroCarousel = (): void => {
    stopHeroCarousel();
    startHeroCarousel();
};

const showNextHeroSlide = (): void => {
    setHeroSlide(activeHeroIndex.value + 1);
};

const showPreviousHeroSlide = (): void => {
    setHeroSlide(activeHeroIndex.value - 1);
};

const selectHeroSlide = (index: number): void => {
    setHeroSlide(index);
    resetHeroCarousel();
};

const showNextHeroSlideManually = (): void => {
    showNextHeroSlide();
    resetHeroCarousel();
};

const showPreviousHeroSlideManually = (): void => {
    showPreviousHeroSlide();
    resetHeroCarousel();
};

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

    shouldAutoRotateHero = true;

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

    startHeroCarousel();
});

onBeforeUnmount(() => {
    revealObserver?.disconnect();
    stopHeroCarousel();
});

const quickActions: Feature[] = [
    {
        icon: GraduationCap,
        title: 'Program Offerings',
        description:
            'Undergraduate, graduate, law, and medicine pathways across the NEMSU system.',
        href: '#academics',
    },
    {
        icon: FileText,
        title: 'Good Governance',
        description:
            "Transparency Seal, FOI, Citizen's Charter, accomplishment reports, and BAC matters.",
        href: '#governance',
    },
    {
        icon: Building2,
        title: 'Campus Directory',
        description:
            'Campus profiles, services, facilities, student government, and contact details.',
        href: '#campuses',
    },
];

const campuses: Campus[] = [
    {
        slug: 'tandag',
        name: 'Tandag',
        focus: 'Main Campus',
        detail: 'Central administration, graduate studies, engineering, information technology, and medicine.',
        location: 'Tandag City',
    },
    {
        slug: 'cantilan',
        name: 'Cantilan',
        focus: 'Technology Education',
        detail: 'Industrial technology, trades, and technical education programs.',
        location: 'Cantilan',
    },
    {
        slug: 'san-miguel',
        name: 'San Miguel',
        focus: 'Agriculture and Forestry',
        detail: 'Agro-forestry, field laboratories, and community-based extension.',
        location: 'San Miguel',
    },
    {
        slug: 'lianga',
        name: 'Lianga',
        focus: 'Fisheries and Marine Sciences',
        detail: 'Coastal resources, aquaculture, and marine research.',
        location: 'Lianga',
    },
    {
        slug: 'cagwait',
        name: 'Cagwait',
        focus: 'Industrial Technology',
        detail: 'Technology programs and campus life near the coast.',
        location: 'Cagwait',
    },
    {
        slug: 'tagbina',
        name: 'Tagbina',
        focus: 'Community-Based Education',
        detail: 'Accessible academic programs and extension services for southern Surigao del Sur communities.',
        location: 'Tagbina',
    },
    {
        slug: 'bislig',
        name: 'Bislig',
        focus: 'Agroforestry and Industry',
        detail: 'Integrated programs for forestry, engineering, and regional industry.',
        location: 'Bislig City',
    },
];

const metrics: Metric[] = [
    { label: 'Campuses', value: '7', note: 'System-wide presence' },
    {
        label: 'Core Functions',
        value: '4',
        note: 'Instruction, research, extension, production',
    },
    {
        label: 'Public Services',
        value: '24+',
        note: 'Offices and online services',
    },
    {
        label: 'Priority Agenda',
        value: 'INNOVATE',
        note: 'Strategic university direction',
    },
];

const academicTracks: Feature[] = [
    {
        icon: BookOpen,
        title: 'Undergraduate Programs',
        description:
            'Campus, college, prospectus, objectives, and learning outcomes.',
        href: '#academics',
    },
    {
        icon: GraduationCap,
        title: 'Graduate School',
        description:
            'Advanced education aligned with research and professional practice.',
        href: '#academics',
    },
    {
        icon: Landmark,
        title: 'Law and Medicine',
        description:
            'Specialized colleges with dedicated program pages and updates.',
        href: '#academics',
    },
];

const governanceLinks: Feature[] = [
    {
        icon: ShieldCheck,
        title: 'Transparency Seal',
        description:
            'Public accountability documents, reports, and compliance materials.',
        href: '#governance',
    },
    {
        icon: FileText,
        title: 'Freedom of Information',
        description:
            'FOI access, request guidance, and public information channels.',
        href: '#governance',
    },
    {
        icon: Megaphone,
        title: "Citizen's Charter",
        description:
            'Frontline services, processing times, requirements, and contacts.',
        href: '#governance',
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="North Eastern Mindanao State University" />

        <WelcomeHero
            :hero-slides="heroSlides"
            :active-hero-index="activeHeroIndex"
            :active-hero-slide="activeHeroSlide"
            :is-default-hero-slide="isDefaultHeroSlide"
            :has-multiple-hero-slides="hasMultipleHeroSlides"
            :metrics="metrics"
            :fallback-hero-slide="fallbackHeroSlide"
            :reveal-classes="revealClasses"
            :select-hero-slide="selectHeroSlide"
            :show-next-hero-slide-manually="showNextHeroSlideManually"
            :show-previous-hero-slide-manually="showPreviousHeroSlideManually"
        />

        <section
            data-scroll-section="quick-actions"
            class="border-b border-slate-200 bg-white dark:border-white/10 dark:bg-slate-950"
        >
            <div
                :class="revealClasses('quick-actions')"
                class="mx-auto grid max-w-7xl gap-4 px-4 py-6 sm:px-6 md:grid-cols-3 lg:px-8"
            >
                <a
                    v-for="(action, index) in quickActions"
                    :key="action.title"
                    :href="action.href"
                    :style="staggerDelay('quick-actions', index)"
                    class="group grid grid-cols-[auto_1fr_auto] items-start gap-4 rounded-md border border-slate-200 p-4 transition hover:border-[#0b6680] hover:bg-slate-50 dark:border-white/10 dark:hover:border-sky-400/60 dark:hover:bg-white/5"
                >
                    <span
                        class="inline-flex size-10 items-center justify-center rounded-md bg-[#e6f3f5] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                    >
                        <component
                            :is="action.icon"
                            class="size-5"
                            aria-hidden="true"
                        />
                    </span>
                    <span>
                        <span
                            class="block text-sm font-semibold text-slate-950 dark:text-white"
                            >{{ action.title }}</span
                        >
                        <span
                            class="mt-1 block text-sm leading-6 text-slate-600 dark:text-slate-300"
                            >{{ action.description }}</span
                        >
                    </span>
                    <ArrowRight
                        class="mt-1 size-4 text-slate-400 transition group-hover:translate-x-1 group-hover:text-[#0b6680]"
                        aria-hidden="true"
                    />
                </a>
            </div>
        </section>

        <section
            id="about"
            data-scroll-section="about"
            class="relative isolate overflow-hidden bg-[#f7f8f5] bg-cover bg-center bg-no-repeat py-16 lg:bg-fixed dark:bg-slate-950"
            :style="
                parallaxBackground(
                    sectionImages.about,
                    'linear-gradient(115deg, rgba(247,248,245,.97), rgba(247,248,245,.88) 58%, rgba(6,43,73,.74))',
                )
            "
        >
            <div
                :class="revealClasses('about', 'right')"
                class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8"
            >
                <div>
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        About NEMSU
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        A system built for Mindanaoan progress
                    </h2>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <article
                        class="rounded-md border border-slate-200 bg-white/90 p-6 shadow-sm shadow-slate-900/5 backdrop-blur dark:border-white/10 dark:bg-slate-950/70"
                    >
                        <h3
                            class="text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            Vision
                        </h3>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            A Research University advancing technology and
                            innovation for sustainable development.
                        </p>
                    </article>
                    <article
                        class="rounded-md border border-slate-200 bg-white/90 p-6 shadow-sm shadow-slate-900/5 backdrop-blur dark:border-white/10 dark:bg-slate-950/70"
                    >
                        <h3
                            class="text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            Mission
                        </h3>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Quality instruction, innovative research, community
                            collaboration, and technological advancement.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section
            id="academics"
            data-scroll-section="academics"
            class="relative isolate overflow-hidden bg-white bg-cover bg-center bg-no-repeat py-16 lg:bg-fixed dark:bg-slate-900"
            :style="
                parallaxBackground(
                    sectionImages.academics,
                    'linear-gradient(100deg, rgba(255,255,255,.98), rgba(255,255,255,.92) 64%, rgba(230,243,245,.82))',
                )
            "
        >
            <div
                :class="revealClasses('academics')"
                class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
            >
                <div
                    class="flex flex-col justify-between gap-6 md:flex-row md:items-end"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Academic Affairs
                        </p>
                        <h2
                            class="mt-3 max-w-2xl text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Program pages ready for prospectus, objectives, and
                            learning outcomes
                        </h2>
                    </div>
                    <a
                        href="#campuses"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                    >
                        View campuses
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </a>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <article
                        v-for="(track, index) in academicTracks"
                        :key="track.title"
                        :style="staggerDelay('academics', index)"
                        class="rounded-md border border-slate-200 bg-white/[0.88] p-6 shadow-sm shadow-slate-900/5 backdrop-blur transition hover:-translate-y-1 hover:border-[#0b6680]/50 hover:shadow-lg hover:shadow-slate-900/10 dark:border-white/10 dark:bg-slate-950/70"
                    >
                        <component
                            :is="track.icon"
                            class="size-7 text-[#0b6680] dark:text-sky-300"
                            aria-hidden="true"
                        />
                        <h3
                            class="mt-5 text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            {{ track.title }}
                        </h3>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            {{ track.description }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section
            id="news"
            tabindex="-1"
            class="bg-[#f7f8f5] py-16 dark:bg-slate-950"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    data-scroll-section="news-top"
                    :class="[revealClasses('news-top')]"
                    class="grid items-start gap-8 lg:grid-cols-[minmax(0,1.15fr)_minmax(24rem,0.85fr)]"
                >
                    <div class="grid gap-4">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Featured
                        </p>

                        <Link
                            v-if="props.featuredNews"
                            :href="newsShow(props.featuredNews.slug)"
                            class="group relative isolate min-h-[26rem] overflow-hidden rounded-md border border-slate-200 bg-slate-950 shadow-sm shadow-slate-900/10 dark:border-white/10"
                        >
                            <img
                                v-if="props.featuredNews.photoUrl"
                                :src="props.featuredNews.photoUrl"
                                :alt="props.featuredNews.title"
                                class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                            />
                            <div
                                v-else
                                class="absolute inset-0 grid place-items-center bg-[#1711d4]"
                            >
                                <Megaphone
                                    class="size-14 text-white/60"
                                    aria-hidden="true"
                                />
                            </div>
                            <div
                                class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/55 to-slate-950/5"
                            ></div>
                            <div
                                class="relative flex min-h-[26rem] flex-col justify-end p-5 sm:p-7"
                            >
                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs font-medium text-white/80"
                                >
                                    <span
                                        class="rounded bg-[#9b1c31] px-2.5 py-1 text-white"
                                    >
                                        Featured News
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1.5"
                                    >
                                        <CalendarDays
                                            class="size-3.5"
                                            aria-hidden="true"
                                        />
                                        {{ props.featuredNews.date }}
                                    </span>
                                </div>
                                <h3
                                    class="mt-4 max-w-2xl text-2xl leading-tight font-semibold tracking-normal text-white sm:text-3xl"
                                >
                                    {{ props.featuredNews.title }}
                                </h3>
                                <p
                                    v-if="props.featuredNews.excerpt"
                                    class="mt-3 line-clamp-3 max-w-2xl text-sm leading-7 text-white/85"
                                >
                                    {{ props.featuredNews.excerpt }}
                                </p>
                                <p
                                    class="mt-4 text-xs font-medium text-white/70"
                                >
                                    {{ props.featuredNews.office }}
                                </p>
                            </div>
                        </Link>

                        <article
                            v-else
                            class="grid min-h-[26rem] place-items-center rounded-md border border-dashed border-slate-300 bg-white p-6 text-center text-sm leading-7 text-slate-600 dark:border-white/15 dark:bg-white/5 dark:text-slate-300"
                        >
                            Featured news will appear here after a published
                            news record is marked as featured.
                        </article>
                    </div>

                    <div class="grid gap-4">
                        <div
                            class="flex items-center justify-between border-b border-slate-200 pb-3 dark:border-white/10"
                        >
                            <h2
                                class="text-sm font-semibold tracking-wide text-slate-950 uppercase dark:text-white"
                            >
                                Latest News
                            </h2>
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#9b1c31]"
                                aria-hidden="true"
                            ></span>
                        </div>

                        <Link
                            v-for="item in props.pressReleases"
                            :key="item.id"
                            :href="newsShow(item.slug)"
                            class="group grid grid-cols-[7rem_1fr] gap-4 rounded-md border border-slate-200 bg-white p-3 transition hover:border-[#9b1c31]/45 hover:bg-white sm:grid-cols-[8rem_1fr] dark:border-white/10 dark:bg-white/5 dark:hover:border-rose-300/50 dark:hover:bg-white/[0.07]"
                        >
                            <div
                                class="overflow-hidden rounded bg-slate-100 dark:bg-white/10"
                            >
                                <img
                                    v-if="item.photoUrl"
                                    :src="item.photoUrl"
                                    :alt="item.title"
                                    class="aspect-[4/3] h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                />
                                <div
                                    v-else
                                    class="grid aspect-[4/3] h-full w-full place-items-center text-[#9b1c31] dark:text-rose-200"
                                >
                                    <Megaphone
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </div>
                            </div>
                            <div class="min-w-0 self-center">
                                <div
                                    class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold text-slate-500 dark:text-slate-400"
                                >
                                    <span
                                        class="tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                        >{{ item.type }}</span
                                    >
                                    <span
                                        class="inline-flex items-center gap-1.5"
                                    >
                                        <CalendarDays
                                            class="size-3.5"
                                            aria-hidden="true"
                                        />
                                        {{ item.date }}
                                    </span>
                                </div>
                                <h3
                                    class="mt-2 line-clamp-2 font-semibold text-slate-950 transition group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-100"
                                >
                                    {{ item.title }}
                                </h3>
                                <p
                                    class="mt-3 truncate text-xs font-semibold text-slate-500 dark:text-slate-400"
                                >
                                    {{ item.office }}
                                </p>
                            </div>
                        </Link>

                        <Link
                            :href="newsIndex()"
                            class="group mt-1 inline-flex min-h-12 w-full items-center justify-between gap-3 rounded-md border border-[#9b1c31]/25 bg-white px-4 py-3 text-left text-sm font-semibold text-[#1711d4] shadow-sm shadow-slate-900/5 transition hover:border-[#9b1c31]/50 hover:bg-[#fff8f9] dark:border-rose-300/25 dark:bg-white/5 dark:text-sky-100 dark:hover:border-rose-200/50 dark:hover:bg-white/[0.08]"
                        >
                            <span class="min-w-0">
                                <span class="block"> See more news </span>
                                <span
                                    class="mt-0.5 block text-xs font-medium text-slate-500 dark:text-slate-400"
                                >
                                    Browse the full NEMSU newsroom
                                </span>
                            </span>
                            <span
                                class="inline-flex size-9 shrink-0 items-center justify-center rounded-md bg-[#1711d4] text-white transition group-hover:bg-[#9b1c31]"
                            >
                                <ArrowRight
                                    class="size-4 transition group-hover:translate-x-1"
                                    aria-hidden="true"
                                />
                            </span>
                        </Link>
                        <article
                            v-if="props.pressReleases.length === 0"
                            class="rounded-md border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-600 dark:border-white/15 dark:bg-white/5 dark:text-slate-300"
                        >
                            Press releases will appear here after published news
                            records are available.
                        </article>
                    </div>
                </div>

                <div
                    data-scroll-section="announcements"
                    :class="[
                        revealClasses('announcements', 'up'),
                        'mt-10 border-t border-slate-200 pt-8 dark:border-white/10',
                    ]"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Announcements
                        </p>
                        <h2
                            class="mt-3 max-w-2xl text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Time-sensitive notices from university offices
                        </h2>
                    </div>

                    <div
                        v-if="props.announcements.length > 0"
                        class="mt-6 grid gap-4 md:grid-cols-3"
                    >
                        <Link
                            v-for="item in props.announcements"
                            :key="item.id"
                            :href="newsShow(item.slug)"
                            class="group flex min-h-48 flex-col rounded-md border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5 transition hover:-translate-y-0.5 hover:border-[#0b6680]/55 hover:shadow-lg hover:shadow-slate-900/10 dark:border-white/10 dark:bg-white/5 dark:hover:border-sky-300/50"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <span
                                    class="inline-flex size-11 items-center justify-center rounded-md bg-[#fff4cc] text-[#795200] dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                                >
                                    <Megaphone
                                        class="size-5"
                                        aria-hidden="true"
                                    />
                                </span>
                                <span
                                    class="inline-flex items-center gap-1.5 rounded bg-[#e6f3f5] px-2.5 py-1 text-xs font-semibold text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                                >
                                    <CalendarDays
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    {{ item.date }}
                                </span>
                            </div>

                            <div class="mt-5 min-w-0">
                                <p
                                    class="text-xs font-semibold tracking-wide text-[#795200] uppercase dark:text-[#f2b705]"
                                >
                                    {{ item.type }}
                                </p>
                                <h3
                                    class="mt-2 line-clamp-2 font-semibold text-slate-950 transition group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-100"
                                >
                                    {{ item.title }}
                                </h3>
                                <p
                                    v-if="item.excerpt"
                                    class="mt-3 line-clamp-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                                >
                                    {{ item.excerpt }}
                                </p>
                            </div>

                            <div
                                class="mt-auto flex items-center justify-between gap-4 pt-5 text-xs font-medium text-slate-500 dark:text-slate-400"
                            >
                                <span class="truncate">{{ item.office }}</span>
                                <ArrowRight
                                    class="size-4 shrink-0 transition group-hover:translate-x-1 group-hover:text-[#0b6680] dark:group-hover:text-sky-200"
                                    aria-hidden="true"
                                />
                            </div>
                        </Link>
                    </div>

                    <article
                        v-else
                        class="mt-6 rounded-md border border-dashed border-slate-300 bg-white p-6 text-sm leading-7 text-slate-600 dark:border-white/15 dark:bg-white/5 dark:text-slate-300"
                    >
                        Announcements will appear here after published
                        announcement records are available.
                    </article>
                </div>
            </div>
        </section>

        <WelcomeAtAGlance
            :stats="atAGlanceStats"
            :map-highlights="atAGlanceMapHighlights"
            :stagger-delay="staggerDelay"
            :reveal-classes="revealClasses"
        />

        <WelcomeCampuses
            :campuses="campuses"
            :background-style="
                parallaxBackground(
                    sectionImages.research,
                    'linear-gradient(100deg, rgba(6,43,73,.96), rgba(6,43,73,.82) 58%, rgba(6,43,73,.58))',
                )
            "
            :stagger-delay="staggerDelay"
            :reveal-classes="revealClasses"
        />

        <section
            id="governance"
            data-scroll-section="governance"
            class="bg-white py-16 dark:bg-slate-900"
        >
            <div
                :class="revealClasses('governance', 'right')"
                class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
            >
                <div class="max-w-2xl">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        Good Governance
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        Public accountability content grouped for quick access
                    </h2>
                </div>
                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <a
                        v-for="(item, index) in governanceLinks"
                        :key="item.title"
                        :href="item.href"
                        :style="staggerDelay('governance', index)"
                        class="rounded-md border border-slate-200 p-6 transition hover:border-[#9b1c31] hover:bg-[#fff8f9] dark:border-white/10 dark:hover:border-rose-300/60 dark:hover:bg-white/5"
                    >
                        <component
                            :is="item.icon"
                            class="size-7 text-[#9b1c31] dark:text-rose-300"
                            aria-hidden="true"
                        />
                        <h3
                            class="mt-5 font-semibold text-slate-950 dark:text-white"
                        >
                            {{ item.title }}
                        </h3>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            {{ item.description }}
                        </p>
                    </a>
                </div>
            </div>
        </section>

        <section
            id="services"
            data-scroll-section="services"
            class="bg-[#f7f8f5] bg-cover bg-center bg-no-repeat py-16 lg:bg-fixed dark:bg-slate-950"
            :style="
                parallaxBackground(
                    sectionImages.services,
                    'linear-gradient(100deg, rgba(247,248,245,.97), rgba(247,248,245,.9) 58%, rgba(6,43,73,.76))',
                )
            "
        >
            <div
                :class="revealClasses('services')"
                class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8"
            >
                <div>
                    <p
                        class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                    >
                        Online Services
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        Student and public services without the maze
                    </h2>
                    <p
                        class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                    >
                        Admission, directory, registrar, guidance,
                        certifications, downloadable forms, and office contacts
                        are designed as direct paths.
                    </p>
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <a
                        v-for="(label, index) in [
                            'Admission',
                            'Directory',
                            'Registrar',
                            'Guidance Office',
                            'Certification',
                            'Downloadable Forms',
                        ]"
                        :key="label"
                        href="#services"
                        :style="staggerDelay('services', index)"
                        class="inline-flex items-center justify-between rounded-md border border-slate-200 bg-white/90 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm shadow-slate-900/5 backdrop-blur transition hover:-translate-y-0.5 hover:border-[#0b6680]/50 hover:bg-white dark:border-white/10 dark:bg-slate-950/70 dark:text-white"
                    >
                        {{ label }}
                        <ArrowRight
                            class="size-4 text-slate-400"
                            aria-hidden="true"
                        />
                    </a>
                </div>
            </div>
        </section>
    </PublicSiteLayout>
</template>
