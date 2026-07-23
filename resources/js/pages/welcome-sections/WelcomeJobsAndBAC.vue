<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, ExternalLink } from 'lucide-vue-next';

import { vppsi } from '@/routes/administration';
import { index as servicesIndex } from '@/routes/services';
import type { BacDocument, JobOpportunity, RevealClasses } from '@/types';

withDefaults(
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
</script>

<template>
    <section
        id="jobs-and-bac"
        data-scroll-section="jobs-and-bac"
        class="bg-white py-20 sm:py-24 dark:bg-slate-950"
    >
        <div
            :class="revealClasses('jobs-and-bac', 'up')"
            class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <div class="max-w-2xl">
                <p
                    class="text-xs font-semibold tracking-[0.16em] text-[#1C0ED7] uppercase dark:text-sky-300"
                >
                    University notices
                </p>
                <h2
                    class="mt-3 font-serif text-3xl font-bold tracking-tight text-[#1A2340] sm:text-4xl dark:text-white"
                >
                    Opportunities and Procurement
                </h2>
                <div
                    class="mt-5 h-0.5 w-14 bg-[#F2B900]"
                    aria-hidden="true"
                ></div>
            </div>

            <div class="mt-9 grid gap-12 xl:grid-cols-2 xl:gap-0">
                <article class="min-w-0 xl:pr-10">
                    <div
                        class="flex flex-wrap items-center justify-between gap-3 border-b border-[#D8DEE8] pb-4 dark:border-white/10"
                    >
                        <h2
                            class="font-serif text-2xl font-bold text-[#1A2340] dark:text-white"
                        >
                            Jobs and Opportunities
                        </h2>
                        <Link
                            :href="servicesIndex()"
                            class="inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300"
                        >
                            View Opportunities
                            <ArrowRight class="size-4" aria-hidden="true" />
                        </Link>
                    </div>

                    <div
                        class="overflow-x-auto border-b border-[#D8DEE8] dark:border-white/10"
                    >
                        <table
                            class="w-full min-w-[42rem] border-collapse text-left text-sm"
                        >
                            <thead
                                class="bg-[#F8FAFC] text-xs font-semibold text-[#334155] dark:bg-white/5 dark:text-slate-300"
                            >
                                <tr>
                                    <th class="w-12 px-4 py-3" scope="col">
                                        #
                                    </th>
                                    <th class="px-4 py-3" scope="col">
                                        Position
                                    </th>
                                    <th class="px-4 py-3" scope="col">
                                        Posted
                                    </th>
                                    <th class="px-4 py-3" scope="col">
                                        Status
                                    </th>
                                    <th
                                        class="px-4 py-3 text-right"
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
                                    v-for="(
                                        job, index
                                    ) in jobOpportunities.slice(0, 10)"
                                    :key="job.id"
                                    class="align-top transition hover:bg-[#EEF2FF] dark:hover:bg-white/5"
                                >
                                    <td
                                        class="px-4 py-4 font-medium text-[#6B7280] dark:text-slate-400"
                                    >
                                        {{ index + 1 }}
                                    </td>
                                    <td class="max-w-xs px-4 py-4">
                                        <p
                                            class="font-semibold text-[#1F2937] dark:text-white"
                                        >
                                            {{ job.position }}
                                        </p>
                                        <p
                                            v-if="job.campus"
                                            class="mt-1 text-xs text-[#6B7280] dark:text-slate-400"
                                        >
                                            {{ job.campus }}
                                        </p>
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-[#4B5563] dark:text-slate-300"
                                    >
                                        {{ job.postedAt || 'Not specified' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="border-l-2 border-[#F2B900] pl-2 text-xs font-semibold text-[#334155] dark:text-slate-300"
                                            >Hiring</span
                                        >
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <details
                                            class="group/details text-left"
                                        >
                                            <summary
                                                class="inline-flex min-h-11 cursor-pointer list-none items-center gap-1 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300"
                                            >
                                                Details
                                                <ArrowRight
                                                    class="size-3.5 transition group-open/details:rotate-90"
                                                    aria-hidden="true"
                                                />
                                            </summary>
                                            <div
                                                class="mt-2 w-64 rounded-[2px] border border-[#D8DEE8] bg-white p-3 text-xs leading-5 text-[#4B5563] shadow-[0_1px_2px_rgba(15,23,42,0.06)] dark:border-white/10 dark:bg-slate-950 dark:text-slate-300"
                                            >
                                                <dl
                                                    class="grid grid-cols-[auto_1fr] gap-x-2 gap-y-1"
                                                >
                                                    <template
                                                        v-if="job.deadline"
                                                        ><dt
                                                            class="font-semibold"
                                                        >
                                                            Deadline
                                                        </dt>
                                                        <dd>
                                                            {{ job.deadline }}
                                                        </dd></template
                                                    >
                                                    <template
                                                        v-if="job.salaryGrade"
                                                        ><dt
                                                            class="font-semibold"
                                                        >
                                                            Salary grade
                                                        </dt>
                                                        <dd>
                                                            {{
                                                                job.salaryGrade
                                                            }}
                                                        </dd></template
                                                    >
                                                    <template
                                                        v-if="job.monthlySalary"
                                                        ><dt
                                                            class="font-semibold"
                                                        >
                                                            Salary
                                                        </dt>
                                                        <dd>
                                                            {{
                                                                job.monthlySalary
                                                            }}
                                                        </dd></template
                                                    >
                                                    <template
                                                        v-if="
                                                            job.employmentType
                                                        "
                                                        ><dt
                                                            class="font-semibold"
                                                        >
                                                            Type
                                                        </dt>
                                                        <dd>
                                                            {{
                                                                job.employmentType
                                                            }}
                                                        </dd></template
                                                    >
                                                    <template
                                                        v-if="job.experience"
                                                        ><dt
                                                            class="font-semibold"
                                                        >
                                                            Experience
                                                        </dt>
                                                        <dd>
                                                            {{ job.experience }}
                                                        </dd></template
                                                    >
                                                </dl>
                                                <p
                                                    v-if="job.details"
                                                    class="mt-2"
                                                >
                                                    {{ job.details }}
                                                </p>
                                                <p
                                                    v-else
                                                    class="mt-2 text-[#6B7280] dark:text-slate-400"
                                                >
                                                    Additional details will be
                                                    posted when available.
                                                </p>
                                            </div>
                                        </details>
                                    </td>
                                </tr>
                                <tr v-if="jobOpportunities.length === 0">
                                    <td
                                        colspan="5"
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
                    class="min-w-0 border-[#D8DEE8] xl:border-l xl:pl-10 dark:border-white/10"
                >
                    <div
                        class="flex flex-wrap items-center justify-between gap-3 border-b border-[#D8DEE8] pb-4 dark:border-white/10"
                    >
                        <h2
                            class="font-serif text-2xl font-bold text-[#1A2340] dark:text-white"
                        >
                            BAC Matters
                        </h2>
                        <Link
                            :href="`${vppsi.url()}#bac-matters`"
                            class="inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300"
                        >
                            View BAC Matters
                            <ArrowRight class="size-4" aria-hidden="true" />
                        </Link>
                    </div>

                    <div
                        class="overflow-x-auto border-b border-[#D8DEE8] dark:border-white/10"
                    >
                        <table
                            class="w-full min-w-[38rem] border-collapse text-left text-sm"
                        >
                            <thead
                                class="bg-[#F8FAFC] text-xs font-semibold text-[#334155] dark:bg-white/5 dark:text-slate-300"
                            >
                                <tr>
                                    <th class="w-12 px-4 py-3" scope="col">
                                        #
                                    </th>
                                    <th class="px-4 py-3" scope="col">
                                        Document Title
                                    </th>
                                    <th class="px-4 py-3" scope="col">Type</th>
                                    <th class="px-4 py-3" scope="col">
                                        Posted On
                                    </th>
                                    <th
                                        class="px-4 py-3 text-right"
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
                                    v-for="(
                                        document, index
                                    ) in bacDocuments.slice(0, 10)"
                                    :key="document.id"
                                    class="transition hover:bg-[#EEF2FF] dark:hover:bg-white/5"
                                >
                                    <td
                                        class="px-4 py-4 font-medium text-[#6B7280] dark:text-slate-400"
                                    >
                                        {{ index + 1 }}
                                    </td>
                                    <td
                                        class="max-w-xs px-4 py-4 font-semibold text-[#1F2937] dark:text-white"
                                    >
                                        {{ document.title }}
                                    </td>
                                    <td
                                        class="px-4 py-4 text-[#4B5563] dark:text-slate-300"
                                    >
                                        {{ document.type }}
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-[#4B5563] dark:text-slate-300"
                                    >
                                        {{
                                            document.postedAt || 'Not specified'
                                        }}
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <a
                                            v-if="document.destinationUrl"
                                            :href="document.destinationUrl"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex min-h-11 items-center gap-1 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:text-sky-300"
                                        >
                                            Open
                                            <ExternalLink
                                                class="size-3.5"
                                                aria-hidden="true"
                                            />
                                        </a>
                                        <span v-else class="text-[#94A3B8]"
                                            >—</span
                                        >
                                    </td>
                                </tr>
                                <tr v-if="bacDocuments.length === 0">
                                    <td
                                        colspan="5"
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
