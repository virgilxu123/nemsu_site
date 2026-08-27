<script setup lang="ts">
import { useHttp } from '@inertiajs/vue3';
import { ArrowRight, MapPin } from 'lucide-vue-next';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

import type { RevealClasses } from '@/types';

type PsbrsVacancy = {
    id: string;
    position_name: string;
    description: string | null;
    salary_grade: number | null;
    monthly_salary: string | null;
    experience: string | null;
    appointment_type: string | null;
    campus: string | null;
    deadline: string | null;
    application_url: string;
};

type PsbrsVacanciesResponse = {
    data: PsbrsVacancy[];
};

type Vacancy = {
    id: string;
    position: string;
    details: string | null;
    salaryGrade: string | null;
    monthlySalary: string | null;
    experience: string | null;
    employmentType: string | null;
    campus: string | null;
    deadline: string | null;
    applicationUrl: string;
};

type JobMetadata = {
    label: string;
    icon: 'hash' | 'location';
};

defineProps<{
    revealClasses: RevealClasses;
}>();

const vacanciesApiUrl =
    import.meta.env.VITE_PSBRS_VACANCIES_API_URL
const vacanciesPageUrl =
    import.meta.env.VITE_PSBRS_VACANCIES_URL;
const vacanciesRequest = useHttp<Record<string, never>, PsbrsVacanciesResponse>(
    {},
);
const vacancies = ref<Vacancy[]>([]);
const hasLoaded = ref(false);
const errorMessage = ref<string | null>(null);

const isSafeWebUrl = (value: string): boolean => {
    try {
        const url = new URL(value);

        return url.protocol === 'http:' || url.protocol === 'https:';
    } catch {
        return false;
    }
};

const mapVacancy = (vacancy: PsbrsVacancy): Vacancy => ({
    id: vacancy.id,
    position: vacancy.position_name,
    details: vacancy.description,
    salaryGrade:
        vacancy.salary_grade === null ? null : String(vacancy.salary_grade),
    monthlySalary: vacancy.monthly_salary,
    experience: vacancy.experience,
    employmentType: vacancy.appointment_type,
    campus: vacancy.campus,
    deadline: vacancy.deadline,
    applicationUrl: isSafeWebUrl(vacancy.application_url)
        ? vacancy.application_url
        : vacanciesPageUrl,
});

const loadVacancies = async (): Promise<void> => {
    errorMessage.value = null;

    try {
        await vacanciesRequest.get(vacanciesApiUrl, {
            onSuccess: (response) => {
                if (!Array.isArray(response.data)) {
                    vacancies.value = [];
                    errorMessage.value =
                        'The PSBRS vacancies response could not be read.';

                    return;
                }

                vacancies.value = response.data.map(mapVacancy);
            },
            onHttpException: () => {
                errorMessage.value =
                    'Job opportunities are temporarily unavailable.';
            },
            onNetworkError: () => {
                errorMessage.value =
                    'Job opportunities are temporarily unavailable.';
            },
        });
    } catch {
        errorMessage.value = 'Job opportunities are temporarily unavailable.';
    } finally {
        hasLoaded.value = true;
    }
};

const displayedJobOpportunities = computed(() => vacancies.value.slice(0, 6));
const isLoading = computed(
    () => !hasLoaded.value || vacanciesRequest.processing,
);

const salaryFormatter = new Intl.NumberFormat('en-PH', {
    style: 'currency',
    currency: 'PHP',
    maximumFractionDigits: 0,
});

const deadlineFormatter = new Intl.DateTimeFormat('en-PH', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
});

const formatDeadline = (deadline: string): string => {
    const [year, month, day] = deadline.split('-').map(Number);

    if (!year || !month || !day) {
        return deadline;
    }

    return deadlineFormatter.format(new Date(year, month - 1, day));
};

const jobSummary = (job: Vacancy): string => {
    const compensation = [
        job.salaryGrade ? `Salary Grade: ${job.salaryGrade}` : null,
        job.monthlySalary
            ? `${salaryFormatter.format(Number(job.monthlySalary))}/month`
            : null,
    ].filter((value): value is string => Boolean(value));

    if (compensation.length > 0) {
        return compensation.join(' · ');
    }

    return job.details || 'See the vacancy details for requirements.';
};

const jobMetadata = (job: Vacancy): JobMetadata[] =>
    [
        {
            label: job.employmentType || 'Hiring',
            icon: 'hash',
        },
        {
            label:
                job.experience ||
                (job.deadline
                    ? `Deadline ${formatDeadline(job.deadline)}`
                    : 'Deadline not specified'),
            icon: 'hash',
        },
        job.campus
            ? {
                  label: job.campus,
                  icon: 'location',
              }
            : null,
    ].filter((value): value is JobMetadata => value !== null);

onMounted(() => {
    void loadVacancies();
});

onBeforeUnmount(() => {
    vacanciesRequest.cancel();
});
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
                    v-if="isLoading"
                    class="mt-9 grid w-full gap-4 md:grid-cols-2 lg:gap-3"
                    role="status"
                    aria-label="Loading job opportunities"
                >
                    <div
                        v-for="placeholder in 6"
                        :key="placeholder"
                        class="min-h-32 animate-pulse rounded-md bg-[#09005B] p-4 ring-1 ring-white/5 dark:bg-[#06033A]"
                        aria-hidden="true"
                    >
                        <div class="h-5 w-2/3 rounded bg-white/15"></div>
                        <div class="mt-3 h-4 w-1/2 rounded bg-white/10"></div>
                        <div class="mt-8 h-3 w-3/4 rounded bg-white/10"></div>
                    </div>
                </div>

                <div
                    v-else-if="displayedJobOpportunities.length"
                    class="mt-9 grid w-full gap-4 md:grid-cols-2 lg:gap-3"
                >
                    <article
                        v-for="job in displayedJobOpportunities"
                        :key="job.id"
                        class="flex min-h-26 min-w-0 flex-col rounded-md bg-[#09005B] p-4 shadow-[0_8px_18px_rgba(4,0,55,0.18)] ring-1 ring-white/5 dark:bg-[#06033A]"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3
                                    class="min-w-0 font-academic text-sm leading-snug font-bold text-white sm:text-base"
                                >
                                    {{ job.position }}
                                </h3>
                                <p
                                    class="mt-1 line-clamp-2 text-sm leading-6 text-white/70"
                                    :title="jobSummary(job)"
                                >
                                    {{ jobSummary(job) }}
                                </p>
                            </div>
                            <a
                                :href="job.applicationUrl"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group inline-flex shrink-0 items-center gap-2 text-sm font-semibold text-white/90 transition-colors hover:text-[#F2B900] focus-visible:rounded-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2B900]"
                                :aria-label="`View job: ${job.position}`"
                            >
                                View Job
                                <ArrowRight
                                    class="transition-transform group-hover:translate-x-0.5"
                                    aria-hidden="true"
                                />
                            </a>
                        </div>

                        <!-- <p
                            class="mt-1 line-clamp-2 text-sm leading-6 text-white/70"
                            :title="jobSummary(job)"
                        >
                            {{ jobSummary(job) }}
                        </p> -->

                        <ul
                            class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs leading-4 text-white/70"
                            :aria-label="`${job.position} details`"
                        >
                            <li
                                v-for="metadata in jobMetadata(job)"
                                :key="metadata.label"
                                class="inline-flex min-w-0 items-center gap-1"
                            >
                                <MapPin
                                    v-if="metadata.icon === 'location'"
                                    class="size-3 shrink-0 fill-[#F2B900] text-[#F2B900]"
                                    aria-hidden="true"
                                />
                                <span
                                    v-else
                                    class="shrink-0 font-semibold text-[#F2B900]"
                                    aria-hidden="true"
                                    >#</span
                                >
                                <span class="truncate">{{
                                    metadata.label
                                }}</span>
                            </li>
                        </ul>
                    </article>
                </div>

                <p
                    v-else-if="!errorMessage"
                    class="mt-9 w-full rounded-md bg-[#09005B] px-5 py-10 text-center text-base leading-7 text-white/75 ring-1 ring-white/5"
                >
                    No published job opportunities are currently available.
                </p>

                <div
                    v-else
                    class="mt-9 w-full rounded-md bg-[#09005B] px-5 py-8 text-center text-base leading-7 text-white/75 ring-1 ring-white/5"
                    role="alert"
                >
                    <p>{{ errorMessage }}</p>
                    <button
                        type="button"
                        class="mt-3 min-h-11 rounded-md border border-white/40 px-5 py-2 text-sm font-semibold text-white transition-colors hover:border-[#F2B900] hover:text-[#F2B900] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2B900]"
                        @click="loadVacancies"
                    >
                        Try Again
                    </button>
                </div>

                <div class="mt-7 text-center">
                    <a
                        :href="vacanciesPageUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group inline-flex min-h-11 items-center justify-center gap-3 rounded-md bg-white px-7 py-2.5 text-sm font-semibold text-[#1C0ED7] shadow-sm transition-colors hover:bg-[#FFF7D6] focus-visible:outline-2 focus-visible:outline-offset-3 focus-visible:outline-[#F2B900]"
                    >
                        View All
                        <ArrowRight
                            class="size-4 transition-transform group-hover:translate-x-0.5"
                            aria-hidden="true"
                        />
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
