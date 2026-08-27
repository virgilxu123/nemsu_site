<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowUpRight, Download, FileSpreadsheet } from 'lucide-vue-next';
import { computed, ref } from 'vue';
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
                            class="mt-6 grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4"
                        >
                            <a
                                v-for="poster in visiblePosters(collection)"
                                :key="poster.id"
                                :href="poster.url ?? poster.image"
                                target="_blank"
                                rel="noreferrer"
                                class="group overflow-hidden rounded-lg border border-slate-200 bg-[#f7f8f5] shadow-sm transition hover:-translate-y-1 hover:border-[#1711d4]/30 hover:shadow-lg dark:border-white/10 dark:bg-white/[0.04]"
                            >
                                <span
                                    class="grid aspect-4/5 place-items-center overflow-hidden bg-slate-100 p-2 dark:bg-slate-900"
                                >
                                    <img
                                        :src="poster.image"
                                        :alt="poster.title"
                                        loading="lazy"
                                        decoding="async"
                                        class="max-h-full max-w-full object-contain transition group-hover:scale-[1.02]"
                                    />
                                </span>
                                <span
                                    class="flex items-center justify-between gap-2 px-3 py-3 text-xs font-semibold sm:text-sm"
                                >
                                    <span class="truncate">{{
                                        poster.title
                                    }}</span>
                                    <ArrowUpRight
                                        class="size-4 shrink-0 text-[#1711d4] dark:text-sky-300"
                                        aria-hidden="true"
                                    />
                                </span>
                            </a>
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
    </PublicSiteLayout>
</template>
