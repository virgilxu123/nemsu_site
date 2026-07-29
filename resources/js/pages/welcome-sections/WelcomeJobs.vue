<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, MapPin } from 'lucide-vue-next';
import { computed } from 'vue';

import { index as servicesIndex } from '@/routes/services';
import type { JobOpportunity, RevealClasses } from '@/types';

type JobMetadata = {
    label: string;
    showIcon: boolean;
};

const props = withDefaults(
    defineProps<{
        jobOpportunities?: JobOpportunity[];
        revealClasses: RevealClasses;
    }>(),
    {
        jobOpportunities: () => [],
    },
);

const displayedJobOpportunities = computed(() =>
    props.jobOpportunities.slice(0, 6),
);

const jobSummary = (job: JobOpportunity): string => {
    const compensation = [
        job.salaryGrade ? `Salary Grade: ${job.salaryGrade}` : null,
        job.monthlySalary ? `${job.monthlySalary}/month` : null,
    ].filter((value): value is string => Boolean(value));

    if (compensation.length > 0) {
        return compensation.join(' · ');
    }

    return job.details || `Posted ${job.postedAt || 'date not specified'}`;
};

const jobMetadata = (job: JobOpportunity): JobMetadata[] =>
    [
        {
            label: job.employmentType || (job.isHiring ? 'Hiring' : 'Closed'),
            showIcon: Boolean(job.employmentType),
        },
        {
            label:
                job.experience ||
                (job.postedAt
                    ? `Posted ${job.postedAt}`
                    : 'Date not specified'),
            showIcon: Boolean(job.experience),
        },
        job.campus
            ? {
                  label: job.campus,
                  showIcon: true,
              }
            : null,
    ].filter((value): value is JobMetadata => value !== null);
</script>

<template>
    <section
        id="job-opportunities"
        data-scroll-section="job-opportunities"
        class="relative isolate overflow-hidden bg-[#2115DB] py-16 text-white lg:py-20 dark:bg-[#100970]"
        aria-labelledby="job-opportunities-heading"
    >
        <div
            class="pointer-events-none absolute top-8 left-[max(1rem,calc(50%_-_40rem))] hidden sm:block"
            aria-hidden="true"
        >
            <span
                class="block size-20 rounded-full bg-white shadow-[0_14px_20px_rgba(2,0,84,0.34)]"
            ></span>
            <span
                class="absolute top-6 left-14 grid grid-cols-4 gap-3 text-[#F2B900]"
            >
                <span
                    v-for="dot in 12"
                    :key="`top-${dot}`"
                    class="size-1 rounded-full bg-current"
                ></span>
            </span>
        </div>

        <div
            class="pointer-events-none absolute right-[max(1rem,calc(50%_-_40rem))] bottom-10 grid grid-cols-4 gap-3 text-[#F2B900]"
            aria-hidden="true"
        >
            <span
                v-for="dot in 16"
                :key="`bottom-${dot}`"
                class="size-1 rounded-full bg-current"
            ></span>
        </div>

        <div
            class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <div :class="revealClasses('job-opportunities', 'up')">
                <header class="text-center">
                    <h2
                        id="job-opportunities-heading"
                        class="font-academic text-3xl leading-[1.08] font-bold tracking-tight text-white sm:text-4xl"
                    >
                        Job Opportunities
                    </h2>
                    <span
                        class="mx-auto mt-3 block h-1 w-16 rounded-full bg-[#F2B900]"
                        aria-hidden="true"
                    ></span>
                    <p
                        class="mx-auto mt-4 max-w-2xl text-base leading-7 text-white/85"
                    >
                        Explore current employment opportunities from NEMSU.
                    </p>
                </header>

                <div
                    v-if="displayedJobOpportunities.length"
                    class="mt-9 grid w-full gap-4 md:grid-cols-2 lg:gap-3"
                >
                    <article
                        v-for="job in displayedJobOpportunities"
                        :key="job.id"
                        class="flex min-h-32 min-w-0 flex-col rounded-md bg-[#09005B] p-4 shadow-[0_8px_18px_rgba(4,0,55,0.18)] ring-1 ring-white/5 dark:bg-[#06033A]"
                    >
                        <div class="flex items-start justify-between gap-3">
                            <h3
                                class="min-w-0 font-academic text-sm leading-snug font-bold text-white sm:text-base"
                            >
                                {{ job.position }}
                            </h3>
                            <Link
                                :href="servicesIndex()"
                                class="group inline-flex min-h-11 shrink-0 items-center gap-2 text-sm font-semibold text-white/90 transition-colors hover:text-[#F2B900] focus-visible:rounded-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2B900]"
                                :aria-label="`View job: ${job.position}`"
                            >
                                View Job
                                <ArrowRight
                                    class="size-3.5 transition-transform group-hover:translate-x-0.5"
                                    aria-hidden="true"
                                />
                            </Link>
                        </div>

                        <p
                            class="mt-1 line-clamp-2 text-sm leading-6 text-white/70"
                            :title="jobSummary(job)"
                        >
                            {{ jobSummary(job) }}
                        </p>

                        <ul
                            class="mt-auto flex flex-wrap items-center gap-x-5 gap-y-2 pt-3 text-xs leading-4 text-white/70"
                            :aria-label="`${job.position} details`"
                        >
                            <li
                                v-for="metadata in jobMetadata(job)"
                                :key="metadata.label"
                                class="inline-flex min-w-0 items-center gap-1"
                            >
                                <MapPin
                                    v-if="metadata.showIcon"
                                    class="size-3 shrink-0 fill-[#F2B900] text-[#F2B900]"
                                    aria-hidden="true"
                                />
                                <span class="truncate">{{
                                    metadata.label
                                }}</span>
                            </li>
                        </ul>
                    </article>
                </div>

                <p
                    v-else
                    class="mt-9 w-full rounded-md bg-[#09005B] px-5 py-10 text-center text-base leading-7 text-white/75 ring-1 ring-white/5"
                >
                    No published job opportunities are currently available.
                </p>

                <div class="mt-7 text-center">
                    <Link
                        :href="servicesIndex()"
                        class="group inline-flex min-h-11 items-center justify-center gap-3 rounded-md bg-white px-7 py-2.5 text-sm font-semibold text-[#1C0ED7] shadow-sm transition-colors hover:bg-[#FFF7D6] focus-visible:outline-2 focus-visible:outline-offset-3 focus-visible:outline-[#F2B900]"
                    >
                        View All
                        <ArrowRight
                            class="size-4 transition-transform group-hover:translate-x-0.5"
                            aria-hidden="true"
                        />
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
