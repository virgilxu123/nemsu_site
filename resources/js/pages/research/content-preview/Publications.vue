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
import { index as currentPublications } from '@/routes/research/rie/publications';
import { sourceRepositories } from './content';
import ContentPreviewNav from './ContentPreviewNav.vue';

type PublicationPoster = {
    id: string;
    title: string;
    image: string;
    url: string | null;
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

const activeCollection = ref('all');
const visibleCounts = ref<Record<string, number>>({});
const selectedPoster = ref<PublicationPoster | null>(null);

const publicationRepositories = sourceRepositories.filter((repository) =>
    ['Completed Research Projects', 'Scopus Indexed Publications'].includes(
        repository.title,
    ),
);

const visibleCollections = computed(() =>
    activeCollection.value === 'all'
        ? props.collections
        : props.collections.filter(
              (collection) => collection.slug === activeCollection.value,
          ),
);

const visiblePosters = (collection: PublicationCollection) =>
    collection.posters.slice(0, visibleCounts.value[collection.slug] ?? 12);

const showMore = (collection: PublicationCollection): void => {
    visibleCounts.value[collection.slug] =
        (visibleCounts.value[collection.slug] ?? 12) + 12;
};

const openImageViewer = (poster: PublicationPoster) => {
    selectedPoster.value = poster;
};

const closeImageViewer = () => {
    selectedPoster.value = null;
};

const currentPosterList = computed(() => {
    if (!selectedPoster.value) return [];
    const collection = props.collections.find((col) =>
        col.posters.some((p) => p.id === selectedPoster.value?.id),
    );
    return collection ? collection.posters : [];
});

const currentPosterIndex = computed(() => {
    if (!selectedPoster.value) return -1;
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
    if (!selectedPoster.value) return;
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
        <Head title="Publications Content Preview | NEMSU" />

        <main class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section class="bg-[#1711d4] py-16 text-white sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <nav aria-label="Breadcrumb" class="text-sm font-semibold">
                        <ol class="flex flex-wrap items-center gap-2">
                            <li>
                                <Link
                                    :href="home().url"
                                    class="text-white/80 hover:text-[#f2b705]"
                                    >Home</Link
                                >
                            </li>
                            <li class="text-white/40" aria-hidden="true">/</li>
                            <li>
                                <Link
                                    :href="rie().url"
                                    class="text-white/80 hover:text-[#f2b705]"
                                    >RIE</Link
                                >
                            </li>
                            <li class="text-white/40" aria-hidden="true">/</li>
                            <li class="text-[#f2b705]" aria-current="page">
                                Publications preview
                            </li>
                        </ol>
                    </nav>
                    <div class="mt-8 max-w-4xl">
                        <p
                            class="text-sm font-semibold tracking-widest text-[#f2b705] uppercase"
                        >
                            Research outputs
                        </p>
                        <h1
                            class="mt-3 text-4xl font-semibold tracking-tight sm:text-5xl lg:text-6xl"
                        >
                            Scopus Publications and Completed Projects
                        </h1>
                        <p
                            class="mt-5 max-w-3xl text-base leading-8 text-sky-50 sm:text-lg"
                        >
                            Source repositories are presented first, followed by
                            {{ totalPosters }} locally curated publication
                            posters with direct study links where available.
                        </p>
                    </div>
                </div>
            </section>

            <ContentPreviewNav active="publications" />

            <section
                class="border-b border-slate-200 bg-[#f7f8f5] py-10 dark:border-white/10 dark:bg-white/[0.03]"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-4 md:grid-cols-2">
                        <a
                            v-for="repository in publicationRepositories"
                            :key="repository.href"
                            :href="repository.href"
                            target="_blank"
                            rel="noreferrer"
                            class="group flex items-start gap-4 rounded-xl border border-slate-200 bg-white p-5 transition hover:border-[#1711d4]/35 hover:shadow-md dark:border-white/10 dark:bg-slate-900"
                        >
                            <span
                                class="grid size-11 shrink-0 place-items-center rounded-lg bg-[#e7f3fb] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <FileSpreadsheet
                                    class="size-5"
                                    aria-hidden="true"
                                />
                            </span>
                            <span>
                                <span
                                    class="flex items-center gap-2 font-semibold"
                                >
                                    {{ repository.title }}
                                    <ArrowUpRight
                                        class="size-4"
                                        aria-hidden="true"
                                    />
                                </span>
                                <span
                                    class="mt-1 block text-sm leading-6 text-slate-600 dark:text-slate-300"
                                    >{{ repository.description }}</span
                                >
                                <span
                                    class="mt-2 block text-xs font-semibold text-[#1711d4] dark:text-sky-300"
                                    >Open source repository</span
                                >
                            </span>
                        </a>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
                        <span
                            class="font-semibold text-slate-600 dark:text-slate-300"
                            >Local copies:</span
                        >
                        <a
                            v-for="download in downloads"
                            :key="download.href"
                            :href="download.href"
                            download
                            class="inline-flex items-center gap-1.5 font-semibold text-[#1711d4] hover:underline dark:text-sky-300"
                        >
                            <Download class="size-4" aria-hidden="true" />
                            {{ download.title }}
                        </a>
                        <Link
                            :href="currentPublications().url"
                            class="font-semibold text-slate-500 underline underline-offset-4 hover:text-[#1711d4] dark:text-slate-400 dark:hover:text-sky-300"
                        >
                            Open current publications page
                        </Link>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col gap-5 border-b border-slate-200 pb-7 lg:flex-row lg:items-end lg:justify-between dark:border-white/10"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Publication gallery
                        </p>
                        <h2 class="mt-2 text-3xl font-semibold tracking-tight">
                            Curated Scopus collections
                        </h2>
                    </div>
                    <div
                        class="flex max-w-full gap-2 overflow-x-auto pb-1"
                        aria-label="Filter publication collections"
                    >
                        <button
                            type="button"
                            class="shrink-0 rounded-full border px-4 py-2 text-sm font-semibold transition"
                            :class="
                                activeCollection === 'all'
                                    ? 'border-[#1711d4] bg-[#1711d4] text-white'
                                    : 'border-slate-300 dark:border-white/15'
                            "
                            @click="activeCollection = 'all'"
                        >
                            All ({{ totalPosters }})
                        </button>
                        <button
                            v-for="collection in collections"
                            :key="collection.slug"
                            type="button"
                            class="shrink-0 rounded-full border px-4 py-2 text-sm font-semibold transition"
                            :class="
                                activeCollection === collection.slug
                                    ? 'border-[#1711d4] bg-[#1711d4] text-white'
                                    : 'border-slate-300 dark:border-white/15'
                            "
                            @click="activeCollection = collection.slug"
                        >
                            {{ collection.title }} ({{ collection.count }})
                        </button>
                    </div>
                </div>

                <div class="mt-10 space-y-14">
                    <section
                        v-for="collection in visibleCollections"
                        :key="collection.slug"
                    >
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <h3 class="text-2xl font-semibold">
                                    {{ collection.title }}
                                </h3>
                                <p
                                    class="mt-2 max-w-3xl text-sm leading-6 text-slate-600 dark:text-slate-300"
                                >
                                    {{ collection.description }}
                                </p>
                            </div>
                            <span
                                class="shrink-0 text-sm font-semibold text-[#9b1c31] dark:text-rose-300"
                                >{{ collection.count }} posters</span
                            >
                        </div>
                        <div
                            class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
                        >
                            <div
                                v-for="poster in visiblePosters(collection)"
                                :key="poster.id"
                                class="group flex flex-col justify-between overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-[#1711d4]/30 hover:shadow-lg dark:border-white/10 dark:bg-slate-900"
                            >
                                <button
                                    type="button"
                                    @click="openImageViewer(poster)"
                                    class="group/img relative grid aspect-4/5 w-full place-items-center overflow-hidden bg-slate-100 p-2 focus:outline-hidden focus:ring-2 focus:ring-[#1711d4]/50 dark:bg-slate-950"
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
                        <div
                            v-if="
                                visiblePosters(collection).length <
                                collection.posters.length
                            "
                            class="mt-7 text-center"
                        >
                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold transition hover:border-[#1711d4] hover:text-[#1711d4] dark:border-white/15 dark:hover:text-sky-300"
                                @click="showMore(collection)"
                            >
                                Show 12 more
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
