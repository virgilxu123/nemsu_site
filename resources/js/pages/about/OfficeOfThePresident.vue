<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    Maximize2,
    Newspaper,
    User,
    X,
} from 'lucide-vue-next';
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
    '/storage/images/governance/university-president/v2LOAYON, NEMESIO G SFFR NEMSU_1812 copy.jpg';

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
        src: '/storage/images/op/1.jpg',
        alt: 'Dr. Nemesio G. Loayon with university officials at the Office of the President',
        caption:
            'NEMSU Administration & Key Leaders during official meeting at the OP Office',
    },
    {
        src: '/storage/images/op/540296135_698286143231386_4935845870183219640_n.jpg',
        alt: 'President Loayon and delegation with Hon. Romeo S. Momo',
        caption:
            'Courtesy visit with Hon. Romeo S. Momo, Representative of 1st District Surigao del Sur at the House of Representatives',
    },
    {
        src: '/storage/images/op/547373498_710274315365902_7112370805895389088_n.jpg',
        alt: 'Dr. Nemesio G. Loayon and university leadership attending the CHED event',
        caption:
            'Higher Education Leaders Gathering under CHED Bagong Pilipinas ACHIEVE initiative',
    },
    {
        src: '/storage/images/op/559313047_730824059977594_8560694946242249261_n.jpg',
        alt: 'President Nemesio G. Loayon receiving honors at PAFTE convention',
        caption:
            'Honoring Our Trailblazers recognition at the PAFTE National Convention',
    },
    {
        src: '/storage/images/op/566209207_739741582419175_147463436556896519_n.jpg',
        alt: 'President Loayon leading a ribbon-cutting ceremony for extension project launch',
        caption:
            'Ribbon cutting and launch of university community extension project',
    },
    {
        src: '/storage/images/op/625900072_822495177477148_1831198748509807631_n.jpg',
        alt: 'Dr. Nemesio G. Loayon with Magkuno Award recipients',
        caption:
            'Magkuno Awards Ceremony honoring outstanding institutional achievers',
    },
    {
        src: '/storage/images/op/656151430_861393053587360_3461954049841534612_n.jpg',
        alt: 'President Loayon and NEMSU Vice Presidents with excellence trophies',
        caption:
            'NEMSU Executives celebrating prestigious regional and national awards',
    },
    {
        src: '/storage/images/op/720031952_925142100545788_8957349188716742116_n.jpg',
        alt: 'Dr. Nemesio G. Loayon and university officials at CHED event',
        caption:
            'CHED Bagong Pilipinas higher education gathering with university key leaders',
    },
];

const selectedPhotoIndex = ref<number | null>(null);

const openPhotoModal = (index: number) => {
    selectedPhotoIndex.value = index;
};

const closePhotoModal = () => {
    selectedPhotoIndex.value = null;
};

const nextPhoto = () => {
    if (selectedPhotoIndex.value !== null) {
        selectedPhotoIndex.value =
            (selectedPhotoIndex.value + 1) % presidentGallery.length;
    }
};

const prevPhoto = () => {
    if (selectedPhotoIndex.value !== null) {
        selectedPhotoIndex.value =
            (selectedPhotoIndex.value - 1 + presidentGallery.length) %
            presidentGallery.length;
    }
};

const handleKeyDown = (e: KeyboardEvent) => {
    if (selectedPhotoIndex.value === null) return;
    if (e.key === 'Escape') closePhotoModal();
    if (e.key === 'ArrowRight') nextPhoto();
    if (e.key === 'ArrowLeft') prevPhoto();
};

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
    window.addEventListener('keydown', handleKeyDown);

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
    window.removeEventListener('keydown', handleKeyDown);
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
                        <div class="w-full max-w-[290px] overflow-hidden rounded">
                            <img
                                :src="presidentPhoto"
                                alt="Dr. Nemesio G. Loayon"
                                class="aspect-[3/4] w-full scale-110 object-cover"
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

                    <!-- Layout Gallery Grid System -->
                    <div class="relative mt-8">
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            <figure
                                v-for="(photo, index) in presidentGallery"
                                :key="photo.src"
                                :data-scroll-section="`president-gallery-${index}`"
                                :class="
                                    revealClasses(`president-gallery-${index}`)
                                "
                                class="group relative cursor-pointer overflow-hidden rounded-lg border border-slate-200 bg-white p-1.5 shadow-sm transition-all duration-300 hover:border-[#1711d4]/50 hover:shadow-md dark:border-white/10 dark:bg-slate-900 dark:hover:border-sky-400/50"
                                @click="openPhotoModal(index)"
                            >
                                <div
                                    class="relative aspect-[4/3] overflow-hidden rounded bg-slate-100 dark:bg-slate-800"
                                >
                                    <img
                                        :src="photo.src"
                                        :alt="photo.alt"
                                        loading="lazy"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    />
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-slate-950/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                    >
                                        <span
                                            class="inline-flex size-9 items-center justify-center rounded-full bg-white/90 text-slate-900 shadow-md backdrop-blur-sm dark:bg-slate-900/90 dark:text-white"
                                        >
                                            <Maximize2 class="size-4" />
                                        </span>
                                    </div>
                                </div>
                                <figcaption
                                    class="line-clamp-2 p-3 text-xs leading-relaxed text-slate-600 dark:text-slate-400"
                                >
                                    {{ photo.caption }}
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Lightbox Modal -->
        <Teleport to="body">
            <div
                v-if="selectedPhotoIndex !== null"
                class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 p-4 backdrop-blur-md transition-all duration-300"
                tabindex="0"
                @click.self="closePhotoModal"
            >
                <div
                    class="relative flex max-h-[90vh] w-full max-w-5xl flex-col items-center overflow-hidden rounded-xl bg-slate-900 shadow-2xl ring-1 ring-white/10"
                >
                    <!-- Close button -->
                    <button
                        type="button"
                        class="absolute top-4 right-4 z-10 rounded-full bg-slate-800/80 p-2 text-slate-300 transition hover:bg-slate-700 hover:text-white focus:outline-none"
                        @click="closePhotoModal"
                    >
                        <X class="size-5" />
                        <span class="sr-only">Close gallery</span>
                    </button>

                    <!-- Navigation controls -->
                    <button
                        type="button"
                        class="absolute left-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-slate-800/80 p-2.5 text-slate-300 transition hover:bg-slate-700 hover:text-white focus:outline-none"
                        @click="prevPhoto"
                    >
                        <ChevronLeft class="size-6" />
                        <span class="sr-only">Previous photo</span>
                    </button>

                    <button
                        type="button"
                        class="absolute right-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-slate-800/80 p-2.5 text-slate-300 transition hover:bg-slate-700 hover:text-white focus:outline-none"
                        @click="nextPhoto"
                    >
                        <ChevronRight class="size-6" />
                        <span class="sr-only">Next photo</span>
                    </button>

                    <!-- Image Display -->
                    <div
                        class="flex max-h-[75vh] w-full items-center justify-center overflow-hidden bg-black/60 p-4"
                    >
                        <img
                            :src="presidentGallery[selectedPhotoIndex].src"
                            :alt="presidentGallery[selectedPhotoIndex].alt"
                            class="max-h-[70vh] w-auto max-w-full rounded object-contain"
                        />
                    </div>

                    <!-- Caption & Counter Bar -->
                    <div
                        class="flex w-full items-center justify-between border-t border-white/10 bg-slate-900 px-6 py-4 text-white"
                    >
                        <p class="text-sm font-medium text-slate-200">
                            {{ presidentGallery[selectedPhotoIndex].caption }}
                        </p>
                        <span class="text-xs font-semibold text-slate-400">
                            {{ selectedPhotoIndex + 1 }} /
                            {{ presidentGallery.length }}
                        </span>
                    </div>
                </div>
            </div>
        </Teleport>
    </PublicSiteLayout>
</template>
