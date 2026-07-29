<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ExternalLink } from 'lucide-vue-next';
import { computed } from 'vue';

import { vppsi } from '@/routes/administration';
import type { BacDocument, RevealClasses } from '@/types';

const props = withDefaults(
    defineProps<{
        bacDocuments?: BacDocument[];
        revealClasses: RevealClasses;
    }>(),
    {
        bacDocuments: () => [],
    },
);

const displayedBacDocuments = computed(() => props.bacDocuments.slice(0, 5));
</script>

<template>
    <section
        id="bac-matters"
        data-scroll-section="bac-matters"
        class="relative isolate overflow-hidden border-y border-[#1C0ED7] bg-[#EEF3FF] py-16 lg:py-20 dark:border-white/10 dark:bg-slate-950"
        aria-labelledby="bac-matters-heading"
    >
        <div
            class="pointer-events-none absolute top-10 right-[22%] hidden sm:block"
            aria-hidden="true"
        >
            <span
                class="block size-20 rounded-full bg-[#F8BC00] shadow-[0_18px_22px_-12px_rgba(139,103,0,0.55)]"
            ></span>
            <span
                class="absolute top-6 left-14 grid grid-cols-4 gap-2 text-[#1C0ED7]"
            >
                <span
                    v-for="dot in 12"
                    :key="`top-${dot}`"
                    class="size-1 rounded-full bg-current"
                ></span>
            </span>
        </div>

        <div
            class="pointer-events-none absolute bottom-10 left-[max(1rem,calc(50%_-_40rem))] grid grid-cols-3 gap-3 text-[#1C0ED7]"
            aria-hidden="true"
        >
            <span
                v-for="dot in 12"
                :key="`bottom-${dot}`"
                class="size-1 rounded-full bg-current"
            ></span>
        </div>

        <div
            :class="revealClasses('bac-matters', 'up')"
            class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <header class="mb-9 text-center">
                <h2
                    id="bac-matters-heading"
                    class="font-serif text-3xl font-semibold tracking-tight text-[#08045F] sm:text-4xl dark:text-white"
                >
                    BAC Matters
                </h2>
                <span
                    class="mx-auto mt-3 block h-1 w-16 rounded-full bg-[#F2B900]"
                    aria-hidden="true"
                ></span>
                <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-[#4D5D91] sm:text-base dark:text-slate-300"
                >
                    View the latest public bidding and procurement notices from
                    NEMSU.
                </p>
            </header>

            <div
                v-if="displayedBacDocuments.length"
                class="grid w-full gap-4 sm:grid-cols-2 lg:grid-cols-5 lg:items-start lg:gap-5 lg:pb-8"
            >
                <article
                    v-for="(document, index) in displayedBacDocuments"
                    :key="document.id"
                    :class="index % 2 === 1 ? 'lg:translate-y-8' : ''"
                    class="flex h-80 min-w-0 flex-col overflow-hidden rounded-md bg-[#09005B] p-4 text-white shadow-[0_18px_30px_-18px_rgba(8,4,95,0.72)] ring-1 ring-white/10 transition-transform dark:bg-[#06033A]"
                >
                    <p class="text-xs leading-5 text-white/65">
                        Posted
                        {{ document.postedAt || 'date not specified' }}
                    </p>

                    <span
                        class="mt-4 inline-flex w-fit rounded-full bg-white/10 px-2.5 py-1 text-xs font-semibold text-white/80"
                    >
                        {{ document.type }}
                    </span>

                    <h3
                        class="mt-3 line-clamp-3 font-serif text-sm leading-5 font-semibold text-white sm:text-base"
                        :title="document.title"
                    >
                        {{ document.title }}
                    </h3>

                    <a
                        v-if="document.destinationUrl"
                        :href="document.destinationUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group mt-auto inline-flex min-h-11 items-center justify-center gap-2 rounded-sm bg-white/10 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-white/20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F8BC00]"
                        :aria-label="`Open BAC document: ${document.title}`"
                    >
                        Open
                        <ExternalLink
                            class="size-3.5 transition-transform group-hover:translate-x-0.5"
                            aria-hidden="true"
                        />
                    </a>
                    <span
                        v-else
                        class="mt-auto inline-flex min-h-11 items-center justify-center rounded-sm bg-white/5 px-3 py-2 text-sm font-medium text-white/50"
                    >
                        Document unavailable
                    </span>
                </article>
            </div>

            <p
                v-else
                class="w-full rounded-md border border-dashed border-[#B9C6E4] bg-white/60 px-5 py-10 text-center text-sm leading-6 text-[#64729C] dark:border-white/15 dark:bg-white/[0.03] dark:text-slate-400"
            >
                No published BAC documents are currently available.
            </p>

            <div class="mt-8 text-center">
                <Link
                    :href="`${vppsi.url()}#bac-matters`"
                    class="inline-flex min-h-11 items-center justify-center rounded-md bg-[#F8BC00] px-7 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[#DFA900] focus-visible:outline-2 focus-visible:outline-offset-3 focus-visible:outline-[#1C0ED7]"
                >
                    View All
                </Link>
            </div>
        </div>
    </section>
</template>
