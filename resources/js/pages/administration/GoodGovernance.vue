<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRight, ArrowUpRight } from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import PageHero from '@/components/PageHero.vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { citizensCharter, transparencySeal } from '@/routes/administration';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

const heroBackgroundImage =
    '/images/administration/ovpaf/6I3A7029(1).jpg';
const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['good-governance-hero']));
let revealObserver: IntersectionObserver | null = null;

const governanceItems = [
    {
        title: 'Transparency Seal',
        description:
            'Public accountability resources, annual financial reports, and transparency records.',
        href: transparencySeal().url,
    },
    {
        title: "Citizen's Charter",
        description:
            'Service standards and commitments for university stakeholders.',
        href: citizensCharter().url,
    },
];

const freedomOfInformationResources = [
    {
        category: 'Manual',
        title: "People's FOI Manual",
        year: 'Current',
        href: 'https://drive.google.com/file/d/1S2QPmPW-sx98hcPxa6VTxzQ7X8ZpuBBf/view?pli=1',
    },
    {
        category: 'Manual',
        title: 'NEMSU One-Page Freedom of Information Manual',
        year: 'Current',
        href: 'https://drive.google.com/file/d/1T4_eUD8SAtTlDvvQGjNPNBjOeCNAACQO/view?usp=sharing',
    },
    {
        category: 'Form',
        title: 'NEMSU FOI Request Feedback Survey Form',
        year: 'Current',
        href: 'https://drive.google.com/file/d/1l1oAYuVyRquzj0e03E2_jcS-d0cmLPAm/view',
    },
    {
        category: 'Report',
        title: 'Freedom of Information Report',
        year: '2024',
        href: 'https://docs.google.com/spreadsheets/d/1Vi7eTrjR2FrY-7CwmHUXOYxlPNhHoKBy/edit?usp=drive_link&ouid=118069644834388500470&rtpof=true&sd=true',
    },
    {
        category: 'Report',
        title: 'Freedom of Information Report',
        year: '2023',
        href: 'https://docs.google.com/spreadsheets/d/13RwB_ZvmJwUnoWJbXiPhDhM6olvSdS2D/edit?usp=sharing',
    },
    {
        category: 'Report',
        title: 'Freedom of Information Report',
        year: '2022',
        href: 'https://docs.google.com/spreadsheets/d/1-peJiXcwBVjAdspKYb-QfTas4nO5cytZ/edit?usp=sharing',
    },
    {
        category: 'Report',
        title: 'Freedom of Information Report',
        year: '2021',
        href: 'https://docs.google.com/spreadsheets/d/1HQUNHkxSsrr5YRp2idNBvH2Sse3VauU3/edit?usp=sharing',
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
        <Head title="Good Governance" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <PageHero
                title="Good Governance and Public Accountability Resources"
                :breadcrumbs="[
                    { title: 'Home', href: home().url },
                    { title: 'Administration' },
                    { title: 'Good Governance' }
                ]"
                :backgroundImage="heroBackgroundImage"
            />

            <section
                id="good-governance"
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="governance-heading"
                        :class="revealClasses('governance-heading')"
                        class="max-w-3xl"
                    >
                        <h3 class="mt-3 text-3xl font-semibold tracking-normal">
                            Accountability and Public Service
                        </h3>
                    </div>

                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <article
                            v-for="(item, index) in governanceItems"
                            :key="item.title"
                            :data-scroll-section="`governance-resource-${index}`"
                            :class="
                                revealClasses(
                                    `governance-resource-${index}`,
                                    index % 2 === 0 ? 'right' : 'left',
                                )
                            "
                            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                        >
                            <h4 class="text-xl font-semibold">
                                {{ item.title }}
                            </h4>
                            <p
                                class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ item.description }}
                            </p>
                            <Link
                                :href="item.href"
                                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                            >
                                View resource
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </Link>
                        </article>
                    </div>
                </div>
            </section>

            <section id="freedom-of-information" class="py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="foi-heading"
                        :class="revealClasses('foi-heading')"
                        class="max-w-3xl"
                    >
                        <h3 class="mt-3 text-3xl font-semibold tracking-normal">
                            Freedom of Information
                        </h3>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Manuals, request resources, and annual FOI reports
                            are tabulated below for convenient public access.
                        </p>
                    </div>

                    <div
                        data-scroll-section="foi-table"
                        :class="revealClasses('foi-table')"
                        class="mt-8 overflow-hidden rounded-2xl border border-slate-200 shadow-sm shadow-slate-900/5 dark:border-white/10"
                    >
                        <div class="overflow-x-auto">
                            <table
                                class="min-w-full divide-y divide-slate-200 dark:divide-white/10"
                            >
                                <thead
                                    class="bg-blue-700 text-left text-white"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-5 py-4 text-xs font-semibold tracking-wide uppercase"
                                        >
                                            Category
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-5 py-4 text-xs font-semibold tracking-wide uppercase"
                                        >
                                            Document
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-5 py-4 text-xs font-semibold tracking-wide uppercase"
                                        >
                                            Year
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-5 py-4 text-right text-xs font-semibold tracking-wide uppercase"
                                        >
                                            Access
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-slate-200 bg-white dark:divide-white/10 dark:bg-white/4"
                                >
                                    <tr
                                        v-for="resource in freedomOfInformationResources"
                                        :key="`${resource.category}-${resource.title}-${resource.year}`"
                                        class="transition hover:bg-[#f7f8f5] dark:hover:bg-white/5"
                                    >
                                        <td
                                            class="px-5 py-4 text-sm font-semibold whitespace-nowrap text-[#0b6680] dark:text-sky-300"
                                        >
                                            {{ resource.category }}
                                        </td>
                                        <td
                                            class="min-w-72 px-5 py-4 text-sm font-medium text-slate-800 dark:text-slate-100"
                                        >
                                            {{ resource.title }}
                                        </td>
                                        <td
                                            class="px-5 py-4 text-sm whitespace-nowrap text-slate-600 dark:text-slate-300"
                                        >
                                            {{ resource.year }}
                                        </td>
                                        <td
                                            class="px-5 py-4 text-right whitespace-nowrap"
                                        >
                                            <a
                                                :href="resource.href"
                                                target="_blank"
                                                rel="noreferrer"
                                                class="inline-flex items-center gap-2 rounded-md bg-[#e7f3fb] px-3 py-2 text-sm font-semibold text-[#0b3d91] transition hover:bg-[#1711d4] hover:text-white dark:bg-sky-400/10 dark:text-sky-200 dark:hover:bg-sky-300 dark:hover:text-slate-950"
                                            >
                                                View
                                                <ArrowUpRight
                                                    class="size-4"
                                                    aria-hidden="true"
                                                />
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
