<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ArrowUpRight,
    Download,
    FileSpreadsheet,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { rie } from '@/routes/research';

const heroBackgroundImage =
    '/images/administration/ovprie/research/research-centers-hero.jpg';

type PublicationPoster = {
    id: string;
    title: string;
    image: string;
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

const visibleCollections = computed(() => {
    if (activeCollection.value === 'all') {
        return props.collections;
    }

    return props.collections.filter(
        (collection) => collection.slug === activeCollection.value,
    );
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
                            Scopus-indexed journal and conference
                            publications.
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
                            Scopus publication collections
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
                                    : 'border-slate-300 bg-white text-slate-700 hover:border-[#1711d4]/40 dark:border-white/15 dark:bg-slate-900 dark:text-slate-200'
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
                                    : 'border-slate-300 bg-white text-slate-700 hover:border-[#1711d4]/40 dark:border-white/15 dark:bg-slate-900 dark:text-slate-200'
                            "
                            @click="activeCollection = collection.slug"
                        >
                            {{ collection.title }} ({{ collection.count }})
                        </button>
                    </div>
                </div>

                <div class="mt-10 space-y-16">
                    <section
                        v-for="collection in visibleCollections"
                        :id="collection.slug"
                        :key="collection.slug"
                        class="scroll-mt-28"
                    >
                        <div
                            class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"
                        >
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
                            <p
                                class="shrink-0 text-sm font-semibold text-[#9b1c31] dark:text-rose-300"
                            >
                                {{ collection.count }} posters
                            </p>
                        </div>

                        <div
                            class="mt-6 grid grid-cols-2 gap-3 sm:gap-5 md:grid-cols-3 xl:grid-cols-4"
                        >
                            <a
                                v-for="poster in getVisiblePosters(collection)"
                                :key="poster.id"
                                :href="poster.image"
                                target="_blank"
                                rel="noreferrer"
                                class="group overflow-hidden rounded-md border border-slate-200 bg-[#f7f8f5] shadow-sm transition hover:-translate-y-1 hover:border-[#1711d4]/30 hover:shadow-lg dark:border-white/10 dark:bg-white/[0.04]"
                            >
                                <span
                                    class="grid aspect-4/5 place-items-center overflow-hidden bg-slate-100 p-2 sm:p-3 dark:bg-slate-900"
                                >
                                    <img
                                        :src="poster.image"
                                        :alt="poster.title"
                                        loading="lazy"
                                        decoding="async"
                                        class="max-h-full max-w-full object-contain transition duration-300 group-hover:scale-[1.02]"
                                    />
                                </span>
                                <span
                                    class="flex items-center justify-between gap-2 px-3 py-3 text-xs font-semibold text-slate-700 sm:px-4 sm:text-sm dark:text-slate-200"
                                >
                                    <span class="truncate">{{
                                        poster.title
                                    }}</span>
                                    <ArrowUpRight
                                        class="size-4 shrink-0 text-[#1711d4] dark:text-sky-200"
                                        aria-hidden="true"
                                    />
                                </span>
                            </a>
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
