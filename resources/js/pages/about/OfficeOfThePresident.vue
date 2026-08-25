<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRight, CalendarDays, Newspaper, User } from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import PageHero from '@/components/PageHero.vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { index as newsIndex, show as newsShow } from '@/routes/news';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type NewsItem = {
    id: string;
    title: string;
    slug: string;
    excerpt?: string | null;
    date: string | null;
    office: string;
    photoUrl?: string | null;
};

type GalleryPhoto = {
    src: string;
    alt: string;
    caption: string;
};

type StrategicAgendaItem = {
    initial: string;
    direction: string;
};

defineProps<{
    pressReleases: NewsItem[];
}>();

const presidentPhoto =
    '/storage/images/governance/university-president/LOAYON, NEMESIO G SFTG NEMSU_6302.jpg';

const strategicAgendaItems: StrategicAgendaItem[] = [
    {
        initial: 'I',
        direction: 'Industry-driven research & innovation',
    },
    {
        initial: 'N',
        direction: 'Nurturing & transformative education',
    },
    {
        initial: 'N',
        direction: 'New technologies & entrepreneurial production',
    },
    {
        initial: 'O',
        direction: 'Outreach through market-oriented extension',
    },
    {
        initial: 'V',
        direction: 'Vibrant faculty & staff development',
    },
    {
        initial: 'A',
        direction: 'Accessible student services',
    },
    {
        initial: 'T',
        direction: 'Transparent governance & resilient infrastructure',
    },
    {
        initial: 'E',
        direction: 'Expansive knowledge-sharing through internationalization',
    },
];

const presidentGallery: GalleryPhoto[] = [
    {
        src: 'https://placehold.net/400x400.png',
        alt: 'President Nemesio G. Loayon at a NEMSU community project',
        caption: 'Advancing sustainable livelihoods and marine conservation',
    },
    {
        src: 'https://placehold.net/400x400.png',
        alt: 'President Nemesio G. Loayon during a university flag ceremony',
        caption: 'Leading the University community in public service',
    },
    {
        src: 'https://placehold.net/400x400.png',
        alt: 'President Nemesio G. Loayon with higher education leaders',
        caption: 'Building partnerships for excellence and equity',
    },
    {
        src: 'https://placehold.net/400x400.png',
        alt: 'President Nemesio G. Loayon addressing the NEMSU community',
        caption:
            'Sharing the University’s direction with the academic community',
    },
];

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(
    new Set(['president-message-section']),
);
let revealObserver: IntersectionObserver | null = null;

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
        { rootMargin: '0px', threshold: 0.1 },
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
        <Head title="Office of the President" />

        <main
            class="bg-white font-sans text-slate-950 dark:bg-slate-950 dark:text-white"
        >
            <PageHero
                title="Office of the President"
                :breadcrumbs="[
                    { title: 'Home', href: home().url },
                    { title: 'About Us' },
                    { title: 'Office of the President' },
                ]"
            />

            <!-- SECTION 1: President Portrait & Message Layout (Top Alignment Rule) -->
            <section
                id="presidents-message"
                class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16 text-lg"
            >
                <div
                    data-scroll-section="president-message-section"
                    :class="revealClasses('president-message-section')"
                    class="grid grid-cols-1 gap-12 lg:grid-cols-[280px_1fr]"
                >
                    <!-- Left Column: Portrait Box & Action Links Panel -->
                    <div class="flex flex-col items-center lg:items-start">
                        <div class="w-full max-w-[260px] overflow-hidden">
                            <img
                                :src="presidentPhoto"
                                alt="Dr. Nemesio G. Loayon"
                                class="aspect-[3/4] w-full rounded object-cover"
                            />
                        </div>
                    </div>

                    <!-- Right Column: Text Layout Flow -->
                    <div
                        class="prose prose-slate dark:prose-invert max-w-none text-justify font-sans"
                    >
                        <p
                            class=" font-semibold text-slate-700 italic dark:text-slate-300"
                        >
                            Dear Corporate Partners, Faculty, Staff, Students,
                            and the NEMSU community,
                        </p>

                        <p
                            class="mt-4 leading-7 text-slate-600 dark:text-slate-300"
                        >
                            As the President of North Eastern Mindanao State
                            University (NEMSU), I am delighted to present the
                            Medium-Term Development Plan for the years 2025 to
                            2030. This comprehensive blueprint embodies our
                            commitment to excellence, innovation, and service to
                            our community and nation.
                        </p>

                        <p
                            class="mt-4 leading-7 text-slate-600 dark:text-slate-300"
                        >
                            This plan serves as our guiding compass in pursuing
                            our university's mission to provide quality
                            education, foster research, and promote community
                            engagement. It encapsulates our collective
                            aspirations and endeavors to uplift lives through
                            education and empowerment.
                        </p>

                        <p
                            class="mt-4 leading-7 text-slate-600 dark:text-slate-300"
                        >
                            By fostering collaboration among faculty, staff,
                            students, alumni, and stakeholders, we can achieve
                            remarkable feats and surmount challenges that lie
                            ahead. As we set forth on this exciting journey of
                            transformation, let's take a moment to reflect on
                            the wise words of Ralph Waldo Emerson: "Don't follow
                            where the path may lead. Go instead where there is
                            no path and leave a trail." This quote reminds us of
                            our dedication to thinking outside the box,
                            embracing creativity, and fearlessly venturing into
                            uncharted territory in education, research, and
                            community involvement.
                        </p>

                        <p
                            class="mt-4 leading-7 text-slate-600 dark:text-slate-300"
                        >
                            In line with this spirit, let us draw inspiration
                            from Philippians 4:13, "I can do all things through
                            Christ who strengthens me." With faith as our guide
                            and courage in our hearts, we are empowered to
                            overcome obstacles and achieve remarkable
                            accomplishments in our pursuit of excellence and
                            service to others.
                        </p>

                        <p
                            class="mt-4 leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Together, let us embrace the opportunities that
                            await us and work tirelessly to build a brighter
                            future for future generations.
                        </p>

                        <!-- Signature End Block -->
                        <div class="mt-8 pt-4">
                            <p
                                class="text-base font-bold tracking-wide text-slate-900 uppercase dark:text-white"
                            >
                                DR. NEMESIO G. LOAYON
                            </p>
                            <p
                                class="text-xs font-medium text-slate-500 dark:text-slate-400"
                            >
                                SUC President III
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION 3: Executives' Corner (Press Releases Grid Layout Rule) -->
            <section
                id="executive-corner"
                class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8"
            >
                <div
                    data-scroll-section="executive-corner-heading"
                    :class="revealClasses('executive-corner-heading')"
                    class="relative flex flex-col items-center gap-4 border-b border-slate-200 pb-6 text-center sm:min-h-14 sm:justify-center dark:border-white/5"
                >
                    <h2
                        class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white"
                    >
                        Executive's Corner
                    </h2>
                    <span
                        aria-hidden="true"
                        class="block h-1 w-12 rounded-full bg-[#f2b705]"
                    ></span>
                    <Link
                        :href="newsIndex()"
                        class="inline-flex items-center gap-1.5 rounded border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 sm:absolute sm:top-1/2 sm:right-0 sm:-translate-y-1/2 dark:border-white/10 dark:bg-slate-900 dark:text-slate-300"
                    >
                        see all news releases
                        <ArrowRight class="size-3.5 text-slate-400" />
                    </Link>
                </div>

                <!-- Three-Column Card Matrix -->
                <div
                    v-if="pressReleases.length"
                    class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <Link
                        v-for="(release, index) in pressReleases"
                        :key="release.id"
                        :href="newsShow(release.slug)"
                        :data-scroll-section="`executive-release-${index}`"
                        :class="revealClasses(`executive-release-${index}`)"
                        class="group flex flex-col overflow-hidden rounded border border-slate-200 bg-white p-3 shadow-sm transition-all hover:border-[#1711d4] hover:shadow dark:border-white/10 dark:bg-white/[0.02]"
                    >
                        <div
                            class="aspect-[16/10] overflow-hidden rounded bg-slate-100 dark:bg-slate-900"
                        >
                            <img
                                v-if="release.photoUrl"
                                :src="release.photoUrl"
                                :alt="release.title"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                            />
                            <div
                                v-else
                                class="flex h-full items-center justify-center"
                            >
                                <Newspaper class="size-8 text-slate-400" />
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col pt-4">
                            <span
                                class="inline-block text-[11px] font-semibold tracking-wider text-slate-500 uppercase dark:text-slate-400"
                            >
                                Executives' Corner
                            </span>
                            <h3
                                class="mt-2 line-clamp-2 text-base leading-snug font-bold text-slate-900 capitalize sm:text-lg dark:text-white"
                            >
                                {{ release.title.toLowerCase() }}
                            </h3>

                            <!-- Metadata elements row -->
                            <div
                                class="mt-3 flex items-center gap-4 text-xs text-slate-400"
                            >
                                <span class="inline-flex items-center gap-1">
                                    <User class="size-3.5" /> by PIO
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <CalendarDays class="size-3.5" />
                                    {{ release.date ?? 'Recent Update' }}
                                </span>
                            </div>

                            <p
                                v-if="release.excerpt"
                                class="mt-3 line-clamp-3 text-xs leading-relaxed text-slate-500 dark:text-slate-400"
                            >
                                {{ release.excerpt }}
                            </p>

                            <div class="mt-auto pt-4">
                                <span
                                    class="inline-flex items-center gap-1 rounded bg-[#1711d4] px-3 py-1.5 text-xs text-white transition group-hover:bg-[#0b3d91]"
                                >
                                    Read More <ArrowRight class="size-3" />
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>

                <div
                    v-else
                    class="mt-8 border border-dashed border-slate-200 p-8 text-center text-xs text-slate-400 dark:border-white/10"
                >
                    No press releases available at this time.
                </div>
            </section>

            <section
                id="strategic-directional-agenda"
                class="border-y border-slate-200 bg-slate-50 py-12 lg:py-16 dark:border-white/10 dark:bg-slate-900/40"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="strategic-agenda-heading"
                        :class="revealClasses('strategic-agenda-heading')"
                        class="mx-auto max-w-3xl text-center"
                    >
                        <p
                            class="text-sm font-semibold tracking-widest text-[#1711d4] uppercase dark:text-[#f2b705]"
                        >
                            Strategic Direction
                        </p>
                        <h2
                            class="mt-3 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl dark:text-white"
                        >
                            NEMSU 8-POINT STRATEGIC DIRECTIONAL AGENDA
                        </h2>
                        <span
                            aria-hidden="true"
                            class="mx-auto mt-4 block h-1 w-12 rounded-full bg-[#f2b705]"
                        ></span>
                    </div>

                    <div class="mx-auto mt-10 max-w-5xl space-y-3">
                        <article
                            v-for="(item, index) in strategicAgendaItems"
                            :key="`${item.initial}-${item.direction}`"
                            :data-scroll-section="`strategic-agenda-${index}`"
                            :class="revealClasses(`strategic-agenda-${index}`)"
                            class="group flex items-center gap-4 rounded-lg border border-slate-200 bg-white px-4 py-4 shadow-sm transition hover:border-[#f2b705]/70 hover:shadow-md sm:gap-6 sm:px-6 dark:border-white/10 dark:bg-slate-900"
                        >
                            <span
                                class="inline-flex size-12 shrink-0 items-center justify-center rounded bg-[#1711d4] text-2xl font-bold text-white shadow-sm transition group-hover:bg-[#0b3d91]"
                            >
                                {{ item.initial }}
                            </span>
                            <!-- <span
                                aria-hidden="true"
                                class="hidden h-px min-w-8 flex-1 border-t border-dashed border-[#1711d4]/30 sm:block dark:border-[#f2b705]/40"
                            ></span> -->
                            <p
                                class="min-w-0 flex-[2] text-sm leading-6 font-semibold text-slate-700 sm:text-base dark:text-slate-200"
                            >
                                {{ item.direction }}
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <!-- SECTION 7: President's Gallery (Bottom Placement Rule) -->
            <section
                id="presidents-gallery"
                class="border-t border-slate-200 bg-slate-50/50 py-12 dark:border-white/5 dark:bg-transparent"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="presidents-gallery-heading"
                        :class="revealClasses('presidents-gallery-heading')"
                        class="text-center"
                    >
                        <h2
                            class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white"
                        >
                            President's Gallery
                        </h2>
                        <span
                            aria-hidden="true"
                            class="mx-auto mt-4 block h-1 w-12 rounded-full bg-[#f2b705]"
                        ></span>
                    </div>

                    <!-- Layout Carousel Grid System -->
                    <div class="relative mt-8">
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <figure
                                v-for="(photo, index) in presidentGallery"
                                :key="photo.src"
                                :data-scroll-section="`president-gallery-${index}`"
                                :class="
                                    revealClasses(`president-gallery-${index}`)
                                "
                                class="group relative overflow-hidden rounded border border-slate-200 bg-white p-1 shadow-sm dark:border-white/10 dark:bg-slate-900"
                            >
                                <div
                                    class="aspect-[4/3] overflow-hidden rounded-sm bg-slate-100 dark:bg-slate-800"
                                >
                                    <img
                                        :src="photo.src"
                                        :alt="photo.alt"
                                        loading="lazy"
                                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-102"
                                    />
                                </div>
                                <figcaption
                                    class="line-clamp-2 p-3 text-xs leading-relaxed text-slate-600 dark:text-slate-400"
                                >
                                    {{ photo.caption }}
                                </figcaption>
                            </figure>
                        </div>

                        <!-- Page Dot Indicator nodes matching layout blueprint references -->
                        <div
                            class="mt-6 flex items-center justify-center gap-1.5"
                        >
                            <span
                                class="size-1.5 rounded-full bg-slate-300 dark:bg-slate-700"
                            ></span>
                            <span
                                class="size-1.5 rounded-full bg-[#1711d4] dark:bg-sky-400"
                            ></span>
                            <span
                                class="size-1.5 rounded-full bg-slate-300 dark:bg-slate-700"
                            ></span>
                            <span
                                class="size-1.5 rounded-full bg-slate-300 dark:bg-slate-700"
                            ></span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>
