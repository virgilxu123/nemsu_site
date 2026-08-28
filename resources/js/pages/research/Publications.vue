<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowUpRight,
    ChevronLeft,
    ChevronRight,
    Download,
    FileSpreadsheet,
    Maximize2,
    X,
    ZoomIn,
} from 'lucide-vue-next';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { rie } from '@/routes/research';

const heroBackgroundImage =
    '/images/administration/ovprie/research/research-centers-hero.jpg';

type PublicationPoster = {
    id: string;
    title: string;
    image: string;
    url?: string | null;
};

type PublicationCollection = {
    slug: string;
    title: string;
    description: string;
    count: number;
    posters: PublicationPoster[];
};

type PublicationDownload = {
    title: string;
    description: string;
    href: string;
};

const props = defineProps<{
    collections: PublicationCollection[];
    totalPosters: number;
    downloads: PublicationDownload[];
}>();

const visibleCounts = ref<Record<string, number>>({});
const selectedPoster = ref<PublicationPoster | null>(null);

const getPosterFileNumber = (poster: PublicationPoster): number => {
    const fileName = poster.image.split('/').pop() ?? '';
    const match = fileName.match(/^(\d+)(?=\.[^.]+$)/);

    return match ? Number(match[1]) : Number.NEGATIVE_INFINITY;
};

const combinedCollection = computed<PublicationCollection>(() => {
    const posters = props.collections
        .flatMap((collection) => collection.posters)
        .toSorted((firstPoster, secondPoster) => {
            const numberDifference =
                getPosterFileNumber(secondPoster) -
                getPosterFileNumber(firstPoster);

            if (numberDifference !== 0) {
                return numberDifference;
            }

            return secondPoster.image.localeCompare(
                firstPoster.image,
                undefined,
                {
                    numeric: true,
                    sensitivity: 'base',
                },
            );
        });

    return {
        slug: 'scopus-publications',
        title: 'Scopus Publications',
        description:
            'All Scopus-indexed publication posters in one collection, ordered by filename from the largest number to the lowest.',
        count: posters.length,
        posters,
    };
});

const getVisibleCount = (slug: string): number => {
    return visibleCounts.value[slug] ?? 10;
};

const showMore = (collection: PublicationCollection) => {
    const current = getVisibleCount(collection.slug);
    visibleCounts.value[collection.slug] = current + 10;
};

const showLess = (collection: PublicationCollection) => {
    visibleCounts.value[collection.slug] = 10;
};

const getVisiblePosters = (collection: PublicationCollection) => {
    const count = getVisibleCount(collection.slug);

    return collection.posters.slice(0, count);
};

const visibleCollections = computed(() => [combinedCollection.value]);

const openImageViewer = (poster: PublicationPoster) => {
    selectedPoster.value = poster;
};

const closeImageViewer = () => {
    selectedPoster.value = null;
};

const currentPosterList = computed(() => {
    return selectedPoster.value ? combinedCollection.value.posters : [];
});

const currentPosterIndex = computed(() => {
    if (!selectedPoster.value) {
        return -1;
    }

    return currentPosterList.value.findIndex(
        (p) => p.id === selectedPoster.value?.id,
    );
});

const prevPoster = () => {
    if (currentPosterIndex.value > 0) {
        selectedPoster.value =
            currentPosterList.value[currentPosterIndex.value - 1];
    }
};

const nextPoster = () => {
    if (
        currentPosterIndex.value >= 0 &&
        currentPosterIndex.value < currentPosterList.value.length - 1
    ) {
        selectedPoster.value =
            currentPosterList.value[currentPosterIndex.value + 1];
    }
};

const handleKeyDown = (event: KeyboardEvent) => {
    if (!selectedPoster.value) {
        return;
    }

    if (event.key === 'Escape') {
        closeImageViewer();
    } else if (event.key === 'ArrowLeft') {
        prevPoster();
    } else if (event.key === 'ArrowRight') {
        nextPoster();
    }
};

watch(selectedPoster, (newVal) => {
    if (typeof window !== 'undefined') {
        if (newVal) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
});

onMounted(() => {
    window.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeyDown);

    if (typeof window !== 'undefined') {
        document.body.style.overflow = '';
    }
});
</script>

<template>
    <PublicSiteLayout>
        <Head title="Published Articles | NEMSU" />

        <main class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate z-10 overflow-hidden bg-slate-950 py-16 text-white sm:py-20"
            >
                <img
                    :src="heroBackgroundImage"
                    alt="Research and Development Office"
                    class="hero-zoom-image pointer-events-none absolute inset-0 z-0 h-full w-full object-cover object-[52%_18%] opacity-70 select-none"
                    aria-hidden="true"
                />
                <div
                    class="pointer-events-none absolute inset-0 z-0 bg-[#1711d4]/70 mix-blend-multiply"
                    aria-hidden="true"
                ></div>
                <div
                    class="pointer-events-none absolute inset-0 z-0 overflow-hidden"
                    aria-hidden="true"
                >
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.2),transparent_38%),radial-gradient(circle_at_72%_28%,rgba(242,183,5,0.22),transparent_28%),linear-gradient(135deg,rgba(255,255,255,0.08),transparent_34%)]"
                    ></div>
                    <div
                        class="absolute inset-0 [background-image:linear-gradient(90deg,rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(180deg,rgba(255,255,255,0.08)_1px,transparent_1px)] [background-size:3.5rem_3.5rem] opacity-35"
                    ></div>
                    <div
                        class="absolute top-10 left-8 h-44 w-44 rounded-full border border-white/10 sm:h-64 sm:w-64"
                    ></div>
                </div>
                <div
                    class="relative z-10 mx-auto max-w-7xl px-4 pb-24 sm:px-6 sm:pb-28 lg:px-8 lg:pb-12"
                >
                    <!-- Breadcrumbs -->
                    <nav
                        aria-label="Breadcrumb"
                        class="ps-1 text-sm font-semibold"
                    >
                        <ol class="flex flex-wrap items-center gap-2">
                            <li>
                                <Link
                                    :href="home().url"
                                    class="text-white/80 transition hover:text-[#f2b705]"
                                >
                                    Home
                                </Link>
                            </li>
                            <li class="text-white/45" aria-hidden="true">/</li>
                            <li>
                                <Link
                                    :href="rie().url"
                                    class="text-white/80 transition hover:text-[#f2b705]"
                                >
                                    Research, Innovation, and Extension
                                </Link>
                            </li>
                            <li class="text-white/45" aria-hidden="true">/</li>
                            <li class="text-[#f2b705]" aria-current="page">
                                Published Articles
                            </li>
                        </ol>
                    </nav>

                    <div class="mt-6 max-w-3xl">
                        <h1
                            class="text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                        >
                            Published Articles
                        </h1>
                        <p
                            class="mt-5 max-w-2xl text-base leading-8 text-sky-50 sm:text-lg"
                        >
                            Explore NEMSU researchers and their recognized
                            Scopus-indexed journal and conference publications.
                        </p>
                    </div>
                </div>
            </section>

            <section
                class="border-b border-slate-200 bg-[#f7f8f5] dark:border-white/10 dark:bg-white/[0.03]"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-4 px-4 py-8 sm:px-6 md:grid-cols-2 lg:px-8"
                >
                    <a
                        v-for="download in downloads"
                        :key="download.href"
                        :href="download.href"
                        download
                        class="group flex items-start gap-4 rounded-md border border-slate-200 bg-white p-5 transition hover:border-[#1711d4]/35 hover:shadow-sm dark:border-white/10 dark:bg-slate-900 dark:hover:border-sky-300/30"
                    >
                        <span
                            class="grid size-11 shrink-0 place-items-center rounded-md bg-[#e7f3fb] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                        >
                            <FileSpreadsheet
                                class="size-5"
                                aria-hidden="true"
                            />
                        </span>
                        <span class="min-w-0">
                            <span class="block font-semibold">
                                {{ download.title }}
                            </span>
                            <span
                                class="mt-1 block text-sm leading-6 text-slate-600 dark:text-slate-300"
                            >
                                {{ download.description }}
                            </span>
                            <span
                                class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                            >
                                Download workbook
                                <Download class="size-4" aria-hidden="true" />
                            </span>
                        </span>
                    </a>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col gap-5 border-b border-slate-200 pb-8 lg:flex-row lg:items-end lg:justify-between dark:border-white/10"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Publication gallery
                        </p>
                        <h2
                            class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl"
                        >
                            Scopus Publication Collections
                        </h2>
                    </div>

                    <p
                        class="shrink-0 rounded-full border border-[#1711d4]/20 bg-[#1711d4]/5 px-4 py-2 text-sm font-semibold text-[#1711d4] dark:border-sky-300/20 dark:bg-sky-300/10 dark:text-sky-200"
                    >
                        {{ totalPosters }} posters
                    </p>
                </div>

                <div class="mt-10 space-y-16">
                    <section
                        v-for="collection in visibleCollections"
                        :id="collection.slug"
                        :key="collection.slug"
                        class="scroll-mt-28"
                    >
                       

                        <div
                            class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
                        >
                            <div
                                v-for="poster in getVisiblePosters(collection)"
                                :key="poster.id"
                                class="group flex flex-col justify-between overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-[#1711d4]/30 hover:shadow-lg dark:border-white/10 dark:bg-slate-900"
                            >
                                <button
                                    type="button"
                                    @click="openImageViewer(poster)"
                                    class="group/img relative grid aspect-4/5 w-full place-items-center overflow-hidden bg-slate-100 p-2 focus:ring-2 focus:ring-[#1711d4]/50 focus:outline-hidden sm:p-3 dark:bg-slate-950"
                                    :title="'View full poster image'"
                                >
                                    <img
                                        :src="poster.image"
                                        :alt="poster.title"
                                        loading="lazy"
                                        decoding="async"
                                        class="max-h-full max-w-full object-contain transition duration-300 group-hover/img:scale-[1.03]"
                                    />
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-slate-950/25 opacity-0 transition-opacity duration-200 group-hover/img:opacity-100"
                                    >
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-slate-900/85 px-3 py-1.5 text-xs font-semibold text-white shadow-md backdrop-blur-xs"
                                        >
                                            <ZoomIn
                                                class="size-3.5"
                                                aria-hidden="true"
                                            />
                                            View Image
                                        </span>
                                    </div>
                                </button>
                                <div
                                    class="border-t border-slate-200 bg-white p-3 dark:border-white/10 dark:bg-slate-900"
                                >
                                    <a
                                        v-if="poster.url"
                                        :href="poster.url"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-xs font-semibold text-slate-800 shadow-xs transition hover:border-[#1711d4] hover:bg-slate-50 hover:text-[#1711d4] sm:text-sm dark:border-white/20 dark:bg-slate-800 dark:text-slate-100 dark:hover:border-sky-300 dark:hover:bg-slate-700 dark:hover:text-sky-300"
                                    >
                                        <span>View Article</span>
                                        <ArrowUpRight
                                            class="size-4 shrink-0 text-[#1711d4] dark:text-sky-300"
                                            aria-hidden="true"
                                        />
                                    </a>
                                    <button
                                        v-else
                                        type="button"
                                        @click="openImageViewer(poster)"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-xs font-semibold text-slate-800 shadow-xs transition hover:border-[#1711d4] hover:bg-slate-50 hover:text-[#1711d4] sm:text-sm dark:border-white/20 dark:bg-slate-800 dark:text-slate-100 dark:hover:border-sky-300 dark:hover:bg-slate-700 dark:hover:text-sky-300"
                                    >
                                        <span>View Image</span>
                                        <Maximize2
                                            class="size-4 shrink-0 text-[#1711d4] dark:text-sky-300"
                                            aria-hidden="true"
                                        />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Show More / Show Less Buttons -->
                        <div
                            v-if="collection.posters.length > 10"
                            class="mt-8 flex flex-wrap items-center justify-center gap-3"
                        >
                            <button
                                v-if="
                                    getVisibleCount(collection.slug) <
                                    collection.posters.length
                                "
                                type="button"
                                @click="showMore(collection)"
                                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-xs font-bold text-slate-800 shadow-xs transition hover:border-[#1711d4] hover:bg-slate-50 hover:text-[#1711d4] dark:border-white/20 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-sky-300 dark:hover:text-sky-300"
                            >
                                <span>
                                    Show 10 More Posters ({{
                                        Math.min(
                                            getVisibleCount(collection.slug),
                                            collection.posters.length,
                                        )
                                    }}
                                    of {{ collection.posters.length }})
                                </span>
                                <span aria-hidden="true">&darr;</span>
                            </button>

                            <button
                                v-if="getVisibleCount(collection.slug) > 10"
                                type="button"
                                @click="showLess(collection)"
                                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-xs font-bold text-slate-800 shadow-xs transition hover:border-[#1711d4] hover:bg-slate-50 hover:text-[#1711d4] dark:border-white/20 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-sky-300 dark:hover:text-sky-300"
                            >
                                <span>Show Less</span>
                                <span aria-hidden="true">&uarr;</span>
                            </button>
                        </div>
                    </section>
                </div>
            </section>
        </main>

        <!-- Image Viewer Modal -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="selectedPoster"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 p-4 backdrop-blur-md sm:p-6"
                    @click.self="closeImageViewer"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="selectedPoster.title"
                >
                    <div
                        class="relative flex max-h-[92vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl border border-white/10 bg-slate-900 shadow-2xl"
                    >
                        <!-- Modal Header -->
                        <div
                            class="flex items-center justify-between border-b border-white/10 px-5 py-4 text-white"
                        >
                            <div class="min-w-0 pr-4">
                                <h3
                                    class="truncate text-base font-semibold sm:text-lg"
                                >
                                    {{ selectedPoster.title }}
                                </h3>
                                <p
                                    v-if="currentPosterList.length > 1"
                                    class="text-xs text-slate-400"
                                >
                                    {{ currentPosterIndex + 1 }} of
                                    {{ currentPosterList.length }} posters
                                </p>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                <a
                                    v-if="selectedPoster.url"
                                    :href="selectedPoster.url"
                                    target="_blank"
                                    rel="noreferrer"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-900 shadow-xs transition hover:bg-slate-100"
                                >
                                    <span>View Article</span>
                                    <ArrowUpRight
                                        class="size-3.5 text-[#1711d4]"
                                        aria-hidden="true"
                                    />
                                </a>
                                <button
                                    type="button"
                                    @click="closeImageViewer"
                                    class="grid size-8 place-items-center rounded-lg border border-white/15 bg-white/10 text-slate-200 transition hover:bg-white/20"
                                    title="Close viewer"
                                >
                                    <X class="size-4" aria-hidden="true" />
                                </button>
                            </div>
                        </div>

                        <!-- Modal Body -->
                        <div
                            class="relative flex min-h-[50vh] flex-1 items-center justify-center overflow-hidden bg-slate-950/80 p-4 sm:p-8"
                        >
                            <button
                                v-if="currentPosterIndex > 0"
                                type="button"
                                @click="prevPoster"
                                class="absolute left-3 z-10 grid size-10 place-items-center rounded-full border border-white/10 bg-slate-900/80 text-white shadow-md transition hover:bg-slate-800"
                                title="Previous image"
                            >
                                <ChevronLeft
                                    class="size-6"
                                    aria-hidden="true"
                                />
                            </button>

                            <img
                                :src="selectedPoster.image"
                                :alt="selectedPoster.title"
                                class="max-h-[70vh] max-w-full rounded-md object-contain shadow-lg"
                            />

                            <button
                                v-if="
                                    currentPosterIndex <
                                    currentPosterList.length - 1
                                "
                                type="button"
                                @click="nextPoster"
                                class="absolute right-3 z-10 grid size-10 place-items-center rounded-full border border-white/10 bg-slate-900/80 text-white shadow-md transition hover:bg-slate-800"
                                title="Next image"
                            >
                                <ChevronRight
                                    class="size-6"
                                    aria-hidden="true"
                                />
                            </button>
                        </div>

                        <!-- Modal Footer -->
                        <div
                            class="flex items-center justify-center border-t border-white/10 bg-slate-900/90 px-5 py-3 text-xs text-slate-400"
                        >
                            <span
                                >Use &larr; &rarr; arrow keys to navigate, Esc
                                to close</span
                            >
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </PublicSiteLayout>
</template>

<style scoped>
.hero-zoom-image {
    animation: hero-zoom 15s ease-in-out infinite alternate;
    transform: scale(1.03);
    transform-origin: 52% 18%;
    will-change: transform;
}

@keyframes hero-zoom {
    from {
        transform: scale(1);
    }

    to {
        transform: scale(1.12);
    }
}

@media (prefers-reduced-motion: reduce) {
    .hero-zoom-image {
        animation: none;
        transform: scale(1.03);
    }
}
</style>
