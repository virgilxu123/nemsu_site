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
    icon?: Component;
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

const parseDateBlock = (dateString: string | null) => {
    if (!dateString) return null;
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return null;
    return {
        month: date.toLocaleString('default', { month: 'short' }).toUpperCase(),
        day: date.getDate(),
        year: date.getFullYear(),
    };
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

const heroImage = '/storage/images/banners/home/default.MP4';
const fallbackHeroSlide: BannerItem = {
    id: 'nemsu-hero',
    title: 'North Eastern Mindanao State University',
    summary:
        'We drive sustainable development through quality instruction, innovative research, community collaboration, and technological advancement.',
    imageUrl: heroImage,
};

const sectionImages = {
    about: 'https://www.nemsu.edu.ph/files/News/reaffirmation-commitment-to-innovation-and-sustainable-development-01.jpg',
    academics: '/storage/images/banners/home/RM-Top-3-banner.jpg',
    research: 'https://nemsu.edu.ph/files/News/REA-00.jpg',
    services: '/storage/images/banners/home/BannerCOL-Passer.jpg',
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
let heroCarouselTimer: ReturnType<typeof window.setTimeout> | null = null;
let shouldAutoRotateHero = false;
let isHoveringHero = false;
let videoEndedWhileHovering = false;

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
        heroCarouselTimer !== null ||
        isHoveringHero
    ) {
        return;
    }

    const duration = isDefaultHeroSlide.value ? 0 : 6500;
    if (duration > 0) {
        heroCarouselTimer = window.setTimeout(showNextHeroSlide, duration);
    }
};

const stopHeroCarousel = (): void => {
    if (heroCarouselTimer === null) {
        return;
    }

    window.clearTimeout(heroCarouselTimer);
    heroCarouselTimer = null;
};

const resetHeroCarousel = (): void => {
    stopHeroCarousel();
    startHeroCarousel();
};

const showNextHeroSlide = (): void => {
    videoEndedWhileHovering = false;
    setHeroSlide(activeHeroIndex.value + 1);
    resetHeroCarousel();
};

const showPreviousHeroSlide = (): void => {
    videoEndedWhileHovering = false;
    setHeroSlide(activeHeroIndex.value - 1);
    resetHeroCarousel();
};

const selectHeroSlide = (index: number): void => {
    videoEndedWhileHovering = false;
    setHeroSlide(index);
    resetHeroCarousel();
};

const showNextHeroSlideManually = (): void => {
    showNextHeroSlide();
};

const showPreviousHeroSlideManually = (): void => {
    showPreviousHeroSlide();
};

const pauseHeroCarousel = (): void => {
    isHoveringHero = true;
    stopHeroCarousel();
};

const handleVideoEnded = (): void => {
    if (isHoveringHero) {
        videoEndedWhileHovering = true;
    } else {
        showNextHeroSlide();
    }
};

const resumeHeroCarousel = (): void => {
    isHoveringHero = false;
    if (videoEndedWhileHovering) {
        videoEndedWhileHovering = false;
        showNextHeroSlide();
    } else {
        startHeroCarousel();
    }
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
            rootMargin: '0px',
            threshold: 0.1,
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
        title: 'Program Offerings',
        description:
            'Undergraduate, graduate, law, and medicine pathways across the NEMSU system.',
        href: '#academics',
    },
    {
        title: 'Good Governance',
        description:
            "Transparency Seal, FOI, Citizen's Charter, accomplishment reports, and BAC matters.",
        href: '#governance',
    },
    {
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
            :handle-video-ended="handleVideoEnded"
            @mouseenter="pauseHeroCarousel"
            @mouseleave="resumeHeroCarousel"
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
                    class="group flex items-start gap-4 rounded-md border border-slate-200 p-4 transition hover:border-[#0b6680] hover:bg-slate-50 dark:border-white/10 dark:hover:border-sky-400/60 dark:hover:bg-white/5"
                >
                    <span v-if="action.icon"
                        class="inline-flex shrink-0 size-10 items-center justify-center rounded-md bg-[#e6f3f5] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                    >
                        <component
                            :is="action.icon"
                            class="size-5"
                            aria-hidden="true"
                        />
                    </span>
                    <span class="flex-1">
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
                        class="mt-1 size-4 shrink-0 text-slate-400 transition group-hover:translate-x-1 group-hover:text-[#0b6680]"
                        aria-hidden="true"
                    />
                </a>
            </div>
        </section>

        <!-- <section
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
                    <h3
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        A system built for Mindanaoan progress
                    </h3>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <article
                        class="rounded-md border border-slate-200 bg-white/90 p-6 shadow-sm shadow-slate-900/5 backdrop-blur dark:border-white/10 dark:bg-slate-950/70"
                    >
                        <h4
                            class="text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            Vision
                        </h4>
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
                        <h4
                            class="text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            Mission
                        </h4>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Quality instruction, innovative research, community
                            collaboration, and technological advancement.
                        </p>
                    </article>
                </div>
            </div>
        </section> -->

        <!-- <section
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
                        <h3
                            class="mt-3 max-w-2xl text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Program pages ready for prospectus, objectives, and
                            learning outcomes
                        </h3>
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
                        <h4
                            class="mt-5 text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            {{ track.title }}
                        </h4>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            {{ track.description }}
                        </p>
                    </article>
                </div>
            </div>
        </section> -->

        <section
            id="news"
            tabindex="-1"
            class="bg-[#f7f8f5] py-16 dark:bg-slate-950"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-10 flex flex-col items-center text-center">
                    <h2 class="text-3xl font-bold tracking-normal text-[#080565] dark:text-white sm:text-4xl">
                        News and Announcements
                    </h2>
                    <div class="mt-3 h-1 w-12 rounded-full bg-[#f2b705]"></div>
                </div>

                <div
                    data-scroll-section="news-top"
                    :class="[revealClasses('news-top')]"
                    class="grid items-stretch gap-6 lg:grid-cols-[1fr_1.15fr]"
                >
                    <!-- FEATURED STORY -->
                    <div class="flex h-full flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900">
                        <h3 class="mb-5 text-sm font-bold tracking-wide text-[#1711d4] uppercase dark:text-sky-300">
                            Featured Story
                        </h3>

                        <Link
                            v-if="props.featuredNews"
                            :href="newsShow(props.featuredNews.slug)"
                            class="group flex flex-1 flex-col"
                        >
                            <div class="relative overflow-hidden rounded-lg">
                                <img
                                    v-if="props.featuredNews.photoUrl"
                                    :src="props.featuredNews.photoUrl"
                                    :alt="props.featuredNews.title"
                                    class="aspect-[16/9] w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                />
                                <div
                                    v-else
                                    class="grid aspect-[16/9] w-full place-items-center bg-[#1711d4]/10 text-[#1711d4]"
                                >
                                    <Megaphone class="size-12 opacity-50" aria-hidden="true" />
                                </div>
                            </div>
                            
                            <div class="mt-6 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                <span class="rounded bg-[#1711d4] px-2.5 py-1 text-white">
                                    {{ props.featuredNews.type || 'Press Release' }}
                                </span>
                                <span class="inline-flex items-center gap-1.5" v-if="props.featuredNews.date">
                                    <CalendarDays class="size-3.5" aria-hidden="true" />
                                    {{ props.featuredNews.date }}
                                </span>
                            </div>
                            
                            <h4 class="mt-4 text-2xl font-bold leading-tight text-slate-950 transition group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-300 sm:text-3xl">
                                {{ props.featuredNews.title }}
                            </h4>
                            
                            <p v-if="props.featuredNews.excerpt" class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                {{ props.featuredNews.excerpt }}
                            </p>
                            
                            <div class="mt-auto pt-6">
                                <span class="inline-flex items-center gap-2 rounded-md bg-[#1711d4] px-5 py-2.5 text-sm font-semibold text-white transition group-hover:bg-[#080565]">
                                    Read Full Story
                                    <ArrowRight class="size-4" aria-hidden="true" />
                                </span>
                            </div>
                        </Link>
                        
                        <article
                            v-else
                            class="grid flex-1 place-items-center rounded-lg border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm leading-7 text-slate-500 dark:border-white/15 dark:bg-white/5 dark:text-slate-400"
                        >
                            Featured news will appear here after a published news record is marked as featured.
                        </article>
                    </div>

                    <!-- LATEST NEWS & ANNOUNCEMENTS -->
                    <div class="flex h-full flex-col gap-6">
                        <!-- LATEST NEWS -->
                        <div class="flex flex-1 flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900">
                            <div class="mb-5 flex items-center justify-between">
                                <h3 class="text-sm font-bold tracking-wide text-[#1711d4] uppercase dark:text-sky-300">
                                    Latest News
                                </h3>
                                <Link
                                    :href="newsIndex()"
                                    class="inline-flex items-center gap-1.5 text-sm font-medium text-[#1711d4] transition hover:underline dark:text-sky-300"
                                >
                                    See more news <ArrowRight class="size-4" aria-hidden="true" />
                                </Link>
                            </div>

                            <div class="flex flex-col gap-5">
                                <Link
                                    v-for="(item, index) in props.pressReleases"
                                    :key="item.id"
                                    :href="newsShow(item.slug)"
                                    class="group flex gap-4"
                                    :class="index !== props.pressReleases.length - 1 ? 'border-b border-slate-100 pb-5 dark:border-white/5' : ''"
                                >
                                    <div class="shrink-0 overflow-hidden rounded-md bg-slate-100 dark:bg-white/10 w-28 sm:w-36">
                                        <img
                                            v-if="item.photoUrl"
                                            :src="item.photoUrl"
                                            :alt="item.title"
                                            class="aspect-[4/3] h-full w-full object-cover transition duration-500 group-hover:scale-[1.05]"
                                        />
                                        <div
                                            v-else
                                            class="grid aspect-[4/3] h-full w-full place-items-center text-[#1711d4]/40"
                                        >
                                            <Megaphone class="size-6" aria-hidden="true" />
                                        </div>
                                    </div>
                                    <div class="flex min-w-0 flex-col justify-center">
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                                            <span class="tracking-wide text-[#1711d4] uppercase dark:text-sky-300">{{ item.type || 'Press Release' }}</span>
                                            <span class="inline-flex items-center gap-1" v-if="item.date">
                                                <CalendarDays class="size-3" aria-hidden="true" />
                                                {{ item.date }}
                                            </span>
                                        </div>
                                        <h4 class="mt-1.5 line-clamp-2 text-sm font-bold text-slate-950 transition group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-300 sm:text-base">
                                            {{ item.title }}
                                        </h4>
                                        <p class="mt-1.5 truncate text-[11px] font-medium text-slate-500 dark:text-slate-400">
                                            {{ item.office }}
                                        </p>
                                    </div>
                                </Link>
                                
                                <article
                                    v-if="props.pressReleases.length === 0"
                                    class="rounded-md border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500 dark:border-white/15 dark:bg-white/5 dark:text-slate-400"
                                >
                                    Press releases will appear here after published news records are available.
                                </article>
                            </div>
                        </div>

                        <!-- ANNOUNCEMENTS -->
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900">
                            <div class="mb-5 flex items-center justify-between">
                                <h3 class="text-sm font-bold tracking-wide text-[#1711d4] uppercase dark:text-sky-300">
                                    Announcements
                                </h3>
                                <Link
                                    :href="newsIndex()"
                                    class="inline-flex items-center gap-1.5 text-sm font-medium text-[#1711d4] transition hover:underline dark:text-sky-300"
                                >
                                    See all announcements <ArrowRight class="size-4" aria-hidden="true" />
                                </Link>
                            </div>
                            
                            <div v-if="props.announcements.length > 0" class="grid gap-4 sm:grid-cols-3">
                                <Link
                                    v-for="item in props.announcements"
                                    :key="item.id"
                                    :href="newsShow(item.slug)"
                                    class="group flex items-center gap-3 rounded-md border border-slate-200 p-3 transition hover:border-[#1711d4]/50 hover:shadow-sm dark:border-white/10 dark:hover:border-sky-300/50"
                                >
                                    <div v-if="parseDateBlock(item.date)" class="flex min-w-[3.5rem] shrink-0 flex-col items-center justify-center border-r border-[#f2b705] pr-3">
                                        <span class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400">{{ parseDateBlock(item.date)?.month }}</span>
                                        <span class="my-0.5 text-xl font-bold leading-none text-slate-950 dark:text-white">{{ parseDateBlock(item.date)?.day }}</span>
                                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400">{{ parseDateBlock(item.date)?.year }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="line-clamp-2 text-[13px] font-bold leading-snug text-slate-950 transition group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-300">
                                            {{ item.title }}
                                        </h4>
                                        <p class="mt-1 truncate text-[10px] font-medium text-slate-500 dark:text-slate-400">
                                            {{ item.office }}
                                        </p>
                                    </div>
                                </Link>
                            </div>
                            <article
                                v-else
                                class="rounded-md border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm leading-7 text-slate-500 dark:border-white/15 dark:bg-white/5 dark:text-slate-400"
                            >
                                Announcements will appear here after published announcement records are available.
                            </article>
                        </div>
                    </div>
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

        <!-- <section
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
                    <h3
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        Public accountability content grouped for quick access
                    </h3>
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
                        <h4
                            class="mt-5 font-semibold text-slate-950 dark:text-white"
                        >
                            {{ item.title }}
                        </h4>
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
                    <h3
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        Student and public services without the maze
                    </h3>
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
        </section> -->
    </PublicSiteLayout>
</template>
