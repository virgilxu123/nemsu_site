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
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import PageHero from '@/components/PageHero.vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { goodGovernance } from '@/routes/administration';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type CampusCharter = {
    name: string;
    edition: string;
    href?: string;
};

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set());
let revealObserver: IntersectionObserver | null = null;

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

const showCharterHighlights = false;
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

const setSectionVisibility = (section: string, isVisible: boolean): void => {
    const nextVisibleSections = new Set(visibleSections.value);

    if (isVisible) {
        nextVisibleSections.add(section);
    } else {
        nextVisibleSections.delete(section);
    }

    visibleSections.value = nextVisibleSections;
};

const isSectionVisible = (section: string): boolean =>
    visibleSections.value.has(section);

const revealClasses = (
    section: string,
    direction: RevealDirection = 'up',
): string =>
    [
        'transition-all duration-700 ease-out will-change-transform motion-reduce:translate-x-0 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:blur-0 motion-reduce:transition-none',
        isSectionVisible(section)
            ? 'translate-x-0 translate-y-0 opacity-100 blur-0'
            : `${revealOffset[direction]} opacity-0 blur-[2px]`,
    ].join(' ');

onMounted(() => {
    const animatedSections = document.querySelectorAll<HTMLElement>(
        '[data-scroll-section]',
    );
    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;

    if (prefersReducedMotion) {
        visibleSections.value = new Set(
            Array.from(animatedSections)
                .map((section) => section.dataset.scrollSection)
                .filter(Boolean) as string[],
        );

        return;
    }

    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const section = entry.target.getAttribute(
                    'data-scroll-section',
                );

                if (section) {
                    setSectionVisibility(section, entry.isIntersecting);
                }
            });
        },
        {
            rootMargin: '0px',
            threshold: 0.1,
        },
    );

    animatedSections.forEach((section) => {
        revealObserver?.observe(section);
    });
});

onBeforeUnmount(() => {
    revealObserver?.disconnect();
});
</script>

<template>
    <PublicSiteLayout>
        <Head title="Citizen's Charter" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <PageHero
                title="Citizen's Charter"
                description="Review NEMSU's published service standards, requirements, processing commitments, and campus-specific charter documents."
                :breadcrumbs="[
                    { title: 'Home', href: home().url },
                    {
                        title: 'Good Governance',
                        href: goodGovernance().url,
                    },
                    { title: 'Citizen\'s Charter' },
                ]"
            />

            <section v-if="showCharterHighlights" class="py-12">
                <div
                    class="mx-auto grid max-w-7xl gap-5 px-4 sm:px-6 md:grid-cols-3 lg:px-8"
                >
                    <article
                        v-for="(highlight, index) in charterHighlights"
                        :key="highlight.title"
                        :data-scroll-section="`charter-highlight-${index}`"
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                        :class="revealClasses(`charter-highlight-${index}`)"
                    >
                        <span
                            class="inline-flex size-11 items-center justify-center rounded-xl bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                        >
                            <component
                                :is="highlight.icon"
                                class="size-5"
                                aria-hidden="true"
                            />
                        </span>
                        <h4
                            class="mt-4 text-xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            {{ highlight.title }}
                        </h4>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            {{ highlight.description }}
                        </p>
                    </article>
                </div>
            </section>

            <section
                id="charter-documents"
                class="border-y border-slate-200 bg-[#f7f8f5] py-16 sm:py-20 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="charter-documents-heading"
                        class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between"
                        :class="
                            revealClasses('charter-documents-heading', 'right')
                        "
                    >
                        <div class="max-w-3xl">
                            <p
                                class="text-sm font-semibold tracking-widest text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                Charter documents
                            </p>
                            <h2
                                class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                            >
                                Select a campus charter
                            </h2>
                            <p
                                class="mt-4 text-base leading-7 text-slate-600 dark:text-slate-300"
                            >
                                Choose a campus to preview its current Citizen's
                                Charter, or open the official document in a new
                                tab.
                            </p>
                        </div>

                        <p
                            class="inline-flex w-fit items-center rounded-full border border-[#1711d4]/15 bg-white px-4 py-2 text-sm font-semibold text-[#0b3d91] shadow-sm dark:border-white/10 dark:bg-white/5 dark:text-sky-200"
                        >
                            {{ campusCharters.length }} campus documents
                        </p>
                    </div>

                    <div
                        class="mt-8 grid items-start gap-6 lg:grid-cols-[19rem_minmax(0,1fr)]"
                    >
                        <div
                            data-scroll-section="campus-charter-mobile-selector"
                            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5 lg:hidden dark:border-white/10 dark:bg-white/4"
                            :class="
                                revealClasses(
                                    'campus-charter-mobile-selector',
                                    'right',
                                )
                            "
                        >
                            <label
                                for="campus-charter-select"
                                class="block text-sm font-semibold text-slate-950 dark:text-white"
                            >
                                Campus
                            </label>
                            <p
                                id="campus-charter-select-hint"
                                class="mt-1 text-sm text-slate-500 dark:text-slate-400"
                            >
                                Select a campus to update the document preview.
                            </p>
                            <select
                                id="campus-charter-select"
                                v-model="selectedCampusName"
                                aria-describedby="campus-charter-select-hint"
                                class="mt-4 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none focus:border-[#1711d4] focus:ring-2 focus:ring-[#1711d4]/20 dark:border-white/15 dark:bg-slate-900 dark:text-white dark:focus:border-sky-300 dark:focus:ring-sky-300/20"
                            >
                                <option
                                    v-for="campus in campusCharters"
                                    :key="`select-${campus.name}`"
                                    :value="campus.name"
                                >
                                    {{ campus.name }}
                                </option>
                            </select>
                        </div>

                        <aside
                            data-scroll-section="campus-charter-list"
                            class="sticky top-28 hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-900/5 lg:block dark:border-white/10 dark:bg-white/4"
                            :class="
                                revealClasses('campus-charter-list', 'right')
                            "
                            aria-label="Campus charter navigation"
                        >
                            <div
                                class="border-b border-[#0f0ab8] bg-[#1711d4] px-5 py-4 text-white dark:border-white/10"
                            >
                                <p
                                    class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                                >
                                    Campuses
                                </p>
                                <p class="mt-1 text-sm text-white/75">
                                    Choose a document to preview
                                </p>
                            </div>
                            <div
                                class="grid gap-px bg-slate-200 dark:bg-white/10"
                            >
                                <button
                                    v-for="campus in campusCharters"
                                    :key="campus.name"
                                    type="button"
                                    :aria-pressed="
                                        selectedCampus.name === campus.name
                                    "
                                    aria-controls="campus-charter-document"
                                    class="group flex min-h-14 items-center justify-between gap-3 bg-white px-5 py-3 text-left text-sm font-medium transition focus-visible:z-20 focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-[#1711d4] dark:bg-slate-900 dark:focus-visible:outline-sky-300"
                                    :class="
                                        selectedCampus.name === campus.name
                                            ? 'relative z-10 bg-[#e7f3fb] text-[#1711d4] dark:bg-sky-400/10 dark:text-sky-200'
                                            : 'text-slate-700 hover:bg-slate-50 hover:text-[#1711d4] dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white'
                                    "
                                    @click="selectedCampusName = campus.name"
                                >
                                    <span>{{ campus.name }}</span>
                                    <ArrowRight
                                        class="size-4 shrink-0 transition"
                                        :class="
                                            selectedCampus.name === campus.name
                                                ? 'translate-x-0 opacity-100'
                                                : '-translate-x-1 opacity-0 group-hover:translate-x-0 group-hover:opacity-100'
                                        "
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </aside>

                        <div
                            id="campus-charter-document"
                            data-scroll-section="campus-charter-viewer"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                            :class="revealClasses('campus-charter-viewer')"
                        >
                            <div
                                class="flex flex-col gap-3 border-b border-[#0f0ab8] bg-[#1711d4] px-5 py-4 text-white sm:flex-row sm:items-center sm:justify-between dark:border-white/10"
                            >
                                <div aria-live="polite">
                                    <p
                                        class="text-xs font-semibold tracking-widest text-[#f2b705] uppercase"
                                    >
                                        Selected campus
                                    </p>
                                    <h3
                                        class="mt-1 text-xl font-semibold text-white"
                                    >
                                        {{ selectedCampus.name }}
                                    </h3>
                                    <p class="mt-1 text-sm text-white/75">
                                        {{ selectedCampus.edition }}
                                    </p>
                                </div>
                                <a
                                    v-if="selectedCampus.href"
                                    :href="selectedCampus.href"
                                    target="_blank"
                                    rel="noreferrer"
                                    :aria-label="`Open ${selectedCampus.name} Citizen's Charter in a new tab`"
                                    class="inline-flex w-fit items-center gap-2 rounded-md bg-[#f2b705] px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-[#d9a404] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                >
                                    Open full document
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
                                class="h-[65vh] min-h-128 w-full bg-slate-100 sm:h-[70vh] dark:bg-slate-950"
                                loading="lazy"
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
                                <h4
                                    class="mt-5 text-xl font-semibold tracking-normal text-slate-950 dark:text-white"
                                >
                                    Document not yet available
                                </h4>
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

            <section class="py-14 sm:py-16">
                <div
                    data-scroll-section="charter-return-link"
                    class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
                    :class="revealClasses('charter-return-link')"
                >
                    <div
                        class="flex flex-col gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 sm:flex-row sm:items-center sm:justify-between sm:p-8 dark:border-white/10 dark:bg-white/4"
                    >
                        <div>
                            <p
                                class="text-sm font-semibold tracking-widest text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                More public resources
                            </p>
                            <h2
                                class="mt-2 text-2xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                Continue exploring Good Governance
                            </h2>
                        </div>

                        <Link
                            :href="goodGovernance().url"
                            class="group inline-flex w-fit items-center justify-center gap-2 rounded-md bg-[#1711d4] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0f0ab8] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1711d4]"
                        >
                            View all resources
                            <ArrowRight
                                class="size-4 transition group-hover:translate-x-1"
                                aria-hidden="true"
                            />
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
