<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, ExternalLink } from 'lucide-vue-next';
import { computed } from 'vue';

import { vppsi } from '@/routes/administration';
import { index as servicesIndex } from '@/routes/services';
import type { BacDocument, JobOpportunity, RevealClasses } from '@/types';

const props = withDefaults(
    defineProps<{
        jobOpportunities?: JobOpportunity[];
        bacDocuments?: BacDocument[];
        revealClasses: RevealClasses;
    }>(),
    {
        jobOpportunities: () => [],
        bacDocuments: () => [],
    },
);

const displayedJobOpportunities = computed(() =>
    props.jobOpportunities.slice(0, 5),
);

const displayedBacDocuments = computed(() => props.bacDocuments.slice(0, 5));
</script>

<template>
    <section
        id="jobs-and-bac"
        data-scroll-section="jobs-and-bac"
        class="bg-white py-16 lg:py-20 dark:bg-slate-900"
    >
        <div
            :class="revealClasses('jobs-and-bac', 'up')"
            class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <header class="mb-9 text-center">
                <h2
                    class="font-serif text-3xl font-semibold tracking-tight text-[#1A2340] sm:text-4xl dark:text-white"
                >
                    Opportunities and Procurement
                </h2>
                <span
                    class="mx-auto mt-3 block h-1 w-16 rounded-full bg-[#F2B900]"
                    aria-hidden="true"
                ></span>
                <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-[#4B5563] sm:text-base dark:text-slate-300"
                >
                    Explore current employment opportunities and the latest
                    public bidding and procurement notices from NEMSU.
                </p>
            </header>

            <div class="grid gap-6 xl:grid-cols-2">
                <article
                    class="min-w-0 overflow-hidden rounded-lg border border-[#D8DEE8] bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-slate-950"
                    aria-labelledby="jobs-heading"
                >
                    <div
                        class="flex min-h-20 flex-wrap items-center justify-between gap-3 border-b border-[#D8DEE8] px-5 py-4 dark:border-white/10"
                    >
                        <h3
                            id="jobs-heading"
                            class="font-serif text-2xl font-semibold text-[#1A2340] dark:text-white"
                        >
                            Jobs and Opportunities
                        </h3>
                        <Link
                            :href="servicesIndex()"
                            class="inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-[#1C0ED7] transition-colors hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300 dark:hover:text-sky-200"
                        >
                            View opportunities
                            <ArrowRight class="size-4" aria-hidden="true" />
                        </Link>
                    </div>

                    <ul
                        v-if="displayedJobOpportunities.length"
                        class="divide-y divide-[#E5E7EB] md:hidden dark:divide-white/10"
                    >
                        <li
                            v-for="job in displayedJobOpportunities"
                            :key="job.id"
                            class="grid gap-3 p-5"
                        >
                            <div
                                class="flex flex-wrap items-start justify-between gap-3"
                            >
                                <h4
                                    class="max-w-md font-serif text-lg leading-snug font-semibold text-[#1A2340] dark:text-white"
                                >
                                    {{ job.position }}
                                </h4>
                                <span
                                    class="rounded-sm bg-[#FFF7D6] px-2.5 py-1 text-xs font-semibold text-[#7A5B00] dark:bg-[#F2B900]/15 dark:text-yellow-200"
                                >
                                    {{ job.isHiring ? 'Hiring' : 'Closed' }}
                                </span>
                            </div>
                            <p
                                class="text-xs font-medium text-[#6B7280] dark:text-slate-400"
                            >
                                Posted
                                {{ job.postedAt || 'date not specified' }}
                            </p>
                            <p
                                v-if="job.details"
                                class="line-clamp-3 text-sm leading-6 text-[#4B5563] dark:text-slate-300"
                            >
                                {{ job.details }}
                            </p>
                        </li>
                    </ul>

                    <p
                        v-else
                        class="px-5 py-10 text-center text-sm leading-6 text-[#6B7280] md:hidden dark:text-slate-400"
                    >
                        No published job opportunities are currently available.
                    </p>

                    <div class="hidden md:block">
                        <table class="w-full border-collapse text-left text-sm">
                            <caption class="sr-only">
                                Current NEMSU job opportunities
                            </caption>
                            <thead
                                class="bg-[#F8FAFC] text-xs font-semibold text-[#334155] dark:bg-white/5 dark:text-slate-300"
                            >
                                <tr>
                                    <th class="px-5 py-3" scope="col">
                                        Position
                                    </th>
                                    <th class="px-4 py-3" scope="col">
                                        Posted
                                    </th>
                                    <th class="px-4 py-3" scope="col">
                                        Status
                                    </th>
                                    <th
                                        class="px-5 py-3 text-right"
                                        scope="col"
                                    >
                                        Details
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="divide-y divide-[#E5E7EB] dark:divide-white/10"
                            >
                                <tr
                                    v-for="job in displayedJobOpportunities"
                                    :key="job.id"
                                    class="align-top transition-colors hover:bg-[#EEF2FF] dark:hover:bg-white/5"
                                >
                                    <td class="max-w-xs px-5 py-4">
                                        <p
                                            class="font-semibold text-[#1F2937] dark:text-white"
                                        >
                                            {{ job.position }}
                                        </p>
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-[#4B5563] dark:text-slate-300"
                                    >
                                        {{ job.postedAt || 'Not specified' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="inline-flex rounded-sm bg-[#FFF7D6] px-2.5 py-1 text-xs font-semibold text-[#7A5B00] dark:bg-[#F2B900]/15 dark:text-yellow-200"
                                        >
                                            {{
                                                job.isHiring
                                                    ? 'Hiring'
                                                    : 'Closed'
                                            }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <details
                                            v-if="job.details"
                                            class="group/details inline-block text-left"
                                        >
                                            <summary
                                                class="inline-flex min-h-11 cursor-pointer list-none items-center gap-1 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300 dark:hover:text-sky-200"
                                            >
                                                Read
                                                <ArrowRight
                                                    class="size-3.5 transition-transform group-open/details:rotate-90"
                                                    aria-hidden="true"
                                                />
                                            </summary>
                                            <p
                                                class="mt-2 max-w-xs text-sm leading-6 text-[#4B5563] dark:text-slate-300"
                                            >
                                                {{ job.details }}
                                            </p>
                                        </details>
                                        <span
                                            v-else
                                            class="text-[#94A3B8] dark:text-slate-500"
                                            >—</span
                                        >
                                    </td>
                                </tr>
                                <tr
                                    v-if="
                                        displayedJobOpportunities.length === 0
                                    "
                                >
                                    <td
                                        colspan="4"
                                        class="px-5 py-10 text-center text-sm text-[#6B7280] dark:text-slate-400"
                                    >
                                        No published job opportunities are
                                        currently available.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>

                <article
                    class="min-w-0 overflow-hidden rounded-lg border border-[#D8DEE8] bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-slate-950"
                    aria-labelledby="bac-heading"
                >
                    <div
                        class="flex min-h-20 flex-wrap items-center justify-between gap-3 border-b border-[#D8DEE8] px-5 py-4 dark:border-white/10"
                    >
                        <h3
                            id="bac-heading"
                            class="font-serif text-2xl font-semibold text-[#1A2340] dark:text-white"
                        >
                            BAC Matters
                        </h3>
                        <Link
                            :href="`${vppsi.url()}#bac-matters`"
                            class="inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-[#1C0ED7] transition-colors hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300 dark:hover:text-sky-200"
                        >
                            View BAC matters
                            <ArrowRight class="size-4" aria-hidden="true" />
                        </Link>
                    </div>

                    <ul
                        v-if="displayedBacDocuments.length"
                        class="divide-y divide-[#E5E7EB] md:hidden dark:divide-white/10"
                    >
                        <li
                            v-for="document in displayedBacDocuments"
                            :key="document.id"
                            class="grid gap-3 p-5"
                        >
                            <div
                                class="flex flex-wrap items-start justify-between gap-3"
                            >
                                <h4
                                    class="max-w-md font-serif text-lg leading-snug font-semibold text-[#1A2340] dark:text-white"
                                >
                                    {{ document.title }}
                                </h4>
                                <span
                                    class="rounded-sm bg-[#EEF2FF] px-2.5 py-1 text-xs font-semibold text-[#1C0ED7] dark:bg-sky-300/10 dark:text-sky-300"
                                >
                                    {{ document.type }}
                                </span>
                            </div>
                            <div
                                class="flex flex-wrap items-center justify-between gap-3"
                            >
                                <p
                                    class="text-xs font-medium text-[#6B7280] dark:text-slate-400"
                                >
                                    Posted
                                    {{
                                        document.postedAt ||
                                        'date not specified'
                                    }}
                                </p>
                                <a
                                    v-if="document.destinationUrl"
                                    :href="document.destinationUrl"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex min-h-11 items-center gap-1 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300 dark:hover:text-sky-200"
                                >
                                    Open document
                                    <ExternalLink
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                </a>
                            </div>
                        </li>
                    </ul>

                    <p
                        v-else
                        class="px-5 py-10 text-center text-sm leading-6 text-[#6B7280] md:hidden dark:text-slate-400"
                    >
                        No published BAC documents are currently available.
                    </p>

                    <div class="hidden md:block">
                        <table class="w-full border-collapse text-left text-sm">
                            <caption class="sr-only">
                                Latest NEMSU BAC documents
                            </caption>
                            <thead
                                class="bg-[#F8FAFC] text-xs font-semibold text-[#334155] dark:bg-white/5 dark:text-slate-300"
                            >
                                <tr>
                                    <th class="px-5 py-3" scope="col">
                                        Document
                                    </th>
                                    <th class="px-4 py-3" scope="col">Type</th>
                                    <th class="px-4 py-3" scope="col">
                                        Posted
                                    </th>
                                    <th
                                        class="px-5 py-3 text-right"
                                        scope="col"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="divide-y divide-[#E5E7EB] dark:divide-white/10"
                            >
                                <tr
                                    v-for="document in displayedBacDocuments"
                                    :key="document.id"
                                    class="align-top transition-colors hover:bg-[#EEF2FF] dark:hover:bg-white/5"
                                >
                                    <td
                                        class="max-w-xs px-5 py-4 font-semibold text-[#1F2937] dark:text-white"
                                    >
                                        {{ document.title }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="inline-flex rounded-sm bg-[#EEF2FF] px-2.5 py-1 text-xs font-semibold text-[#1C0ED7] dark:bg-sky-300/10 dark:text-sky-300"
                                        >
                                            {{ document.type }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-[#4B5563] dark:text-slate-300"
                                    >
                                        {{
                                            document.postedAt || 'Not specified'
                                        }}
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <a
                                            v-if="document.destinationUrl"
                                            :href="document.destinationUrl"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex min-h-11 items-center gap-1 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300 dark:hover:text-sky-200"
                                        >
                                            Open
                                            <ExternalLink
                                                class="size-3.5"
                                                aria-hidden="true"
                                            />
                                        </a>
                                        <span
                                            v-else
                                            class="text-[#94A3B8] dark:text-slate-500"
                                            >—</span
                                        >
                                    </td>
                                </tr>
                                <tr v-if="displayedBacDocuments.length === 0">
                                    <td
                                        colspan="4"
                                        class="px-5 py-10 text-center text-sm text-[#6B7280] dark:text-slate-400"
                                    >
                                        No published BAC documents are currently
                                        available.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
