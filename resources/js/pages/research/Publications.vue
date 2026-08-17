<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ArrowUpRight,
    Download,
    FileSpreadsheet,
    Images,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { rie } from '@/routes/research';

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
                class="relative isolate overflow-hidden bg-[#061b49] text-white"
            >
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(14,165,233,0.28),transparent_38%),linear-gradient(135deg,rgba(23,17,212,0.28),transparent_62%)]"
                    aria-hidden="true"
                ></div>
                <div
                    class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24"
                >
                    <Link
                        :href="rie().url"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-sky-100 transition hover:text-white"
                    >
                        <ArrowLeft class="size-4" aria-hidden="true" />
                        Back to Research, Innovation, and Extension
                    </Link>

                    <div
                        class="mt-10 grid gap-10 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end"
                    >
                        <div class="max-w-3xl">
                            <p
                                class="text-sm font-semibold tracking-[0.18em] text-[#f2b705] uppercase"
                            >
                                Office of Research and Innovation
                            </p>
                            <h1
                                class="mt-4 text-4xl font-semibold tracking-tight sm:text-5xl lg:text-6xl"
                            >
                                Published Articles
                            </h1>
                            <p
                                class="mt-6 max-w-2xl text-base leading-8 text-sky-50 sm:text-lg"
                            >
                                Explore NEMSU researchers and their recognized
                                Scopus-indexed journal and conference
                                publications.
                            </p>
                        </div>

                        <div
                            class="flex w-fit items-center gap-4 rounded-md border border-white/15 bg-white/10 px-5 py-4 backdrop-blur"
                        >
                            <Images
                                class="size-8 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            <div>
                                <p class="text-3xl font-semibold">
                                    {{ totalPosters }}
                                </p>
                                <p class="text-sm text-sky-100">
                                    publication posters
                                </p>
                            </div>
                        </div>
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
                                v-for="poster in collection.posters"
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
                    </section>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>
