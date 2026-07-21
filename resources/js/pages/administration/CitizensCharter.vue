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
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { goodGovernance, vpaf } from '@/routes/administration';
import { home } from '@/routes';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type CampusCharter = {
    name: string;
    edition: string;
    href?: string;
};

const heroLeftImage =
    '/images/administration/ovpaf/6I3A7029(1).jpg';
const heroRightImage =
    '/images/campuses/tandag/facilities/gallery/administrative-building.jpg';
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
            <section class="relative isolate overflow-hidden bg-[#07113f] py-4 text-slate-950 sm:py-6 lg:py-8 dark:bg-slate-950 dark:text-white">
                <div class="pointer-events-none absolute inset-0 z-0 bg-gradient-to-r from-[#1711d4]/70 via-[#1711d4]/45 to-slate-950/80" aria-hidden="true"></div>

                <div class="relative z-10 w-full">
                    <div class="relative flex w-full flex-col items-center py-4 lg:h-[18rem] lg:py-0">
                        <div
                            class="pointer-events-none absolute top-1/2 left-1/2 z-0 hidden h-[18rem] w-[49rem] -translate-x-1/2 -translate-y-1/2 lg:block"
                            aria-hidden="true"
                        >
                            <div class="absolute top-0 -left-16 size-16 bg-[#4661ff] [clip-path:polygon(100%_0,100%_100%,0_100%)]"></div>
                            <div class="absolute top-0 -right-16 size-16 bg-[#4661ff] [clip-path:polygon(0_0,100%_100%,0_100%)]"></div>
                            <div class="absolute bottom-0 -left-16 size-16 bg-[#4661ff] [clip-path:polygon(0_0,100%_0,100%_100%)]"></div>
                            <div class="absolute bottom-0 -right-16 size-16 bg-[#4661ff] [clip-path:polygon(0_0,100%_0,0_100%)]"></div>
                        </div>

                        <div class="relative z-10 w-full overflow-hidden bg-slate-200 lg:absolute lg:top-1/2 lg:left-0 lg:h-[15rem] lg:w-[48%] lg:-translate-y-1/2 dark:bg-slate-800">
                            <img
                                :src="heroLeftImage"
                                alt="NEMSU administration building facade"
                                class="h-40 w-full object-cover object-center sm:h-48 lg:h-full"
                            />
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-[#1711d4]/70 via-[#1711d4]/55 to-slate-950/65 mix-blend-multiply" aria-hidden="true"></div>
                        </div>

                        <div class="relative z-20 -my-5 min-h-44 w-[90%] max-w-4xl text-center text-white sm:min-h-48 lg:absolute lg:top-1/2 lg:left-1/2 lg:m-0 lg:h-[18rem] lg:w-[49rem] lg:-translate-x-1/2 lg:-translate-y-1/2">
                            <div class="relative z-10 flex min-h-44 w-full flex-col items-center justify-center overflow-hidden bg-[#073b73] px-8 py-6 text-center sm:min-h-48 sm:px-12 lg:h-full lg:px-16">
                                <img
                                    src="/images/administration/ovpaf/pattern.png"
                                    alt=""
                                    class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-screen"
                                    aria-hidden="true"
                                />
                                <h3 class="relative z-10 text-3xl font-semibold whitespace-nowrap tracking-normal text-[#7dd3fc] sm:text-5xl lg:text-[3.35rem]">
                                    CITIZEN'S CHARTER
                                </h3>
                                <nav
                                    class="relative z-10 mt-5 text-sm text-white/80"
                                    aria-label="Breadcrumb"
                                >
                                    <ol class="flex flex-wrap items-center justify-center gap-2">
                                        <li>
                                            <Link
                                                :href="home()"
                                                class="transition hover:text-[#f2b705]"
                                            >
                                                Home
                                            </Link>
                                        </li>
                                        <li class="text-white/80" aria-hidden="true">
                                            /
                                        </li>
                                        <li>
                                            <Link
                                                :href="goodGovernance()"
                                                class="transition hover:text-[#f2b705]"
                                            >
                                                Good Governance
                                            </Link>
                                        </li>
                                        <li class="text-white/80" aria-hidden="true">
                                            /
                                        </li>
                                        <li class="text-[#f2b705]" aria-current="page">
                                            Citizen's Charter
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                        <div class="relative z-10 w-full overflow-hidden bg-slate-200 lg:absolute lg:top-1/2 lg:right-0 lg:h-[15rem] lg:w-[48%] lg:-translate-y-1/2 dark:bg-slate-800">
                            <img
                                :src="heroRightImage"
                                alt="NEMSU campus administrative building"
                                class="h-40 w-full object-cover object-center sm:h-48 lg:h-full"
                            />
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-[#1711d4]/70 via-[#1711d4]/55 to-slate-950/65 mix-blend-multiply" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-12">
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
                        <h4 class="mt-4 text-xl font-semibold tracking-normal text-slate-950 dark:text-white">
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
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="charter-documents-heading"
                        class="max-w-3xl"
                        :class="revealClasses('charter-documents-heading', 'right')"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Charter documents
                        </p>
                        <h4 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
                            Campus charter viewer
                        </h4>
                    </div>

                    <div
                        class="mt-8 grid gap-6 lg:grid-cols-[18rem_minmax(0,1fr)]"
                    >
                        <aside
                            data-scroll-section="campus-charter-list"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                            :class="revealClasses('campus-charter-list', 'right')"
                        >
                            <div
                                class="border-b border-[#0f0ab8] bg-[#1711d4] px-5 py-4 text-white dark:border-white/10"
                            >
                                <p
                                    class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
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
                            data-scroll-section="campus-charter-viewer"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                            :class="revealClasses('campus-charter-viewer')"
                        >
                            <div
                                class="flex flex-col gap-3 border-b border-[#0f0ab8] bg-[#1711d4] px-5 py-4 text-white sm:flex-row sm:items-center sm:justify-between dark:border-white/10"
                            >
                                <div>
                                    <p
                                        class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                                    >
                                        {{ selectedCampus.name }}
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-white/85"
                                    >
                                        {{ selectedCampus.edition }}
                                    </p>
                                </div>
                                <a
                                    v-if="selectedCampus.href"
                                    :href="selectedCampus.href"
                                    target="_blank"
                                    rel="noreferrer"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-white transition hover:text-[#f2b705]"
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
                                <h4 class="mt-5 text-xl font-semibold tracking-normal text-slate-950 dark:text-white">
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

            <section class="py-12">
                <div
                    data-scroll-section="charter-return-link"
                    class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
                    :class="revealClasses('charter-return-link')"
                >
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
