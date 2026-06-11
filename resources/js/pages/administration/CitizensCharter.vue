<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Clock3,
    ExternalLink,
    FileCheck2,
    FileText,
    Scale,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { vpaf } from '@/routes/administration';

type CampusCharter = {
    name: string;
    edition: string;
    href?: string;
};

const campusCharters: CampusCharter[] = [
    {
        name: 'Main Campus',
        edition: "Current Citizen's Charter",
        href: 'https://drive.google.com/file/d/1X4UVxlUVjEv2wZVMuwNDRAn9Wm0RRvXg/view',
    },
    {
        name: 'Cantilan Campus',
        edition: "Current Citizen's Charter",
        href: 'https://drive.google.com/file/d/1udVBXhVlqPOkA8aAo9RLNxmtIXb6Cb6V/view',
    },
    {
        name: 'San Miguel Campus',
        edition: "Current Citizen's Charter",
        href: 'https://drive.google.com/file/d/1Kt6mH7EaCNCmLlu89vsQn_XNciZzxlFt/view',
    },
    {
        name: 'Cagwait Campus',
        edition: "Current Citizen's Charter",
        href: 'https://drive.google.com/file/d/1CxvPdHUleOerWO4A0d5_x3Y88NL139H9/view',
    },
    {
        name: 'Lianga Campus',
        edition: "Current Citizen's Charter",
        href: 'https://drive.google.com/file/d/1Y1F90s6kPsEZyUHmi3GPHODmxFCijJLD/view',
    },
    {
        name: 'Tagbina Campus',
        edition: "Current Citizen's Charter",
        href: 'https://drive.google.com/file/d/17yAiv7G0oNYtKPsp6QrHf-d5FPFxY5AO/view',
    },
    {
        name: 'Bislig Campus',
        edition: "Current Citizen's Charter",
        href: 'https://drive.google.com/file/d/1iC2cx1QFdNoGer-oi_ILdOO7HfdBmKNp/view',
    },
];

const selectedCampusName = ref(campusCharters[0].name);
const selectedCampus = computed(
    () =>
        campusCharters.find(
            (campus) => campus.name === selectedCampusName.value,
        ) ?? campusCharters[0],
);

const selectedCampusPreviewUrl = computed(() =>
    selectedCampus.value.href?.replace(/\/view(?:\?.*)?$/, '/preview'),
);

const charterHighlights = [
    {
        title: 'Service requirements',
        description:
            'Documents, qualifications, and steps required when requesting University services.',
        icon: FileCheck2,
    },
    {
        title: 'Processing commitments',
        description:
            'Published processing times and responsible offices for each government service.',
        icon: Clock3,
    },
    {
        title: 'Fees and accountability',
        description:
            'Applicable fees, service standards, and feedback channels for stakeholders.',
        icon: Scale,
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="Citizen's Charter" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate overflow-hidden bg-[#1711d4] py-14 text-white sm:py-16"
            >
                <div
                    class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.18),transparent_38%),radial-gradient(circle_at_bottom_right,rgba(242,183,5,0.2),transparent_35%)]"
                ></div>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <p
                        class="inline-flex rounded bg-white/10 px-3 py-1 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                    >
                        Good Governance
                    </p>
                    <h1
                        class="mt-5 text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                    >
                        Citizen's Charter
                    </h1>
                    <p class="mt-5 max-w-3xl text-lg leading-8 text-sky-100">
                        Select a campus to view its published service
                        requirements, processing commitments, fees, and
                        accountability standards.
                    </p>
                    <a
                        href="#charter-documents"
                        class="mt-8 inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-semibold text-[#1711d4] transition hover:bg-[#f2b705] hover:text-slate-950"
                    >
                        Browse campus charters
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </a>
                </div>
            </section>

            <section class="py-12">
                <div
                    class="mx-auto grid max-w-7xl gap-5 px-4 sm:px-6 md:grid-cols-3 lg:px-8"
                >
                    <article
                        v-for="highlight in charterHighlights"
                        :key="highlight.title"
                        class="rounded-2xl border border-slate-200 bg-[#f8fafc] p-5 dark:border-white/10 dark:bg-white/4"
                    >
                        <span
                            class="inline-flex size-10 items-center justify-center rounded-xl bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                        >
                            <component
                                :is="highlight.icon"
                                class="size-5"
                                aria-hidden="true"
                            />
                        </span>
                        <h2 class="mt-4 text-lg font-semibold">
                            {{ highlight.title }}
                        </h2>
                        <p
                            class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            {{ highlight.description }}
                        </p>
                    </article>
                </div>
            </section>

            <section
                id="charter-documents"
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Charter documents
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                            Campus charter viewer
                        </h2>
                    </div>

                    <div
                        class="mt-8 grid gap-6 lg:grid-cols-[18rem_minmax(0,1fr)]"
                    >
                        <aside
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                        >
                            <div
                                class="border-b border-slate-200 px-5 py-4 dark:border-white/10"
                            >
                                <p
                                    class="text-sm font-semibold text-slate-950 dark:text-white"
                                >
                                    Campuses
                                </p>
                            </div>
                            <div
                                class="grid grid-cols-2 gap-px bg-slate-200 sm:grid-cols-3 lg:grid-cols-1 dark:bg-white/10"
                            >
                                <button
                                    v-for="campus in campusCharters"
                                    :key="campus.name"
                                    type="button"
                                    class="min-h-12 bg-white px-5 py-3 text-left text-sm font-medium transition dark:bg-slate-900"
                                    :class="
                                        selectedCampus.name === campus.name
                                            ? 'relative z-10 bg-[#e7f3fb] text-[#1711d4] ring-2 ring-[#1711d4] ring-inset dark:bg-sky-400/10 dark:text-sky-200 dark:ring-sky-300'
                                            : 'text-slate-700 hover:bg-slate-50 hover:text-[#1711d4] dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white'
                                    "
                                    @click="selectedCampusName = campus.name"
                                >
                                    {{ campus.name }}
                                </button>
                            </div>
                        </aside>

                        <div
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                        >
                            <div
                                class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-white/10"
                            >
                                <div>
                                    <p
                                        class="text-sm font-semibold text-slate-950 dark:text-white"
                                    >
                                        {{ selectedCampus.name }}
                                    </p>
                                    <p
                                        class="mt-1 text-xs text-slate-500 dark:text-slate-400"
                                    >
                                        {{ selectedCampus.edition }}
                                    </p>
                                </div>
                                <a
                                    v-if="selectedCampus.href"
                                    :href="selectedCampus.href"
                                    target="_blank"
                                    rel="noreferrer"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                                >
                                    Open document
                                    <ExternalLink
                                        class="size-4"
                                        aria-hidden="true"
                                    />
                                </a>
                            </div>

                            <iframe
                                v-if="selectedCampusPreviewUrl"
                                :key="selectedCampusPreviewUrl"
                                :src="selectedCampusPreviewUrl"
                                :title="`${selectedCampus.name} Citizen's Charter`"
                                class="h-[70vh] min-h-128 w-full bg-slate-100 dark:bg-slate-950"
                            ></iframe>
                            <div
                                v-else
                                class="flex min-h-128 flex-col items-center justify-center px-6 py-16 text-center"
                            >
                                <span
                                    class="inline-flex size-16 items-center justify-center rounded-2xl bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                                >
                                    <FileText
                                        class="size-8"
                                        aria-hidden="true"
                                    />
                                </span>
                                <h3 class="mt-5 text-xl font-semibold">
                                    Document not yet available
                                </h3>
                                <p
                                    class="mt-3 max-w-md text-sm leading-7 text-slate-600 dark:text-slate-300"
                                >
                                    The Citizen's Charter for
                                    {{ selectedCampus.name }} will appear here
                                    once its official file is published.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-12">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Link
                        :href="vpaf()"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                    >
                        <ArrowRight
                            class="size-4 rotate-180"
                            aria-hidden="true"
                        />
                        Return to Administration and Finance
                    </Link>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
