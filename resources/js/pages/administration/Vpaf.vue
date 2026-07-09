<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    ArrowUpRight,
    BadgeCheck,
    ShieldCheck,
} from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { citizensCharter, transparencySeal } from '@/routes/administration';
import { show as contentPageShow } from '@/routes/content-pages';

const nemsuSeal = 'https://nemsu.edu.ph/assets/images/NEMSU.png';

type Office = {
    name: string;
    href: string;
};
const listedOffices: Office[] = [
    {
        name: 'Procurement Management System Office',
        href: contentPageShow.url('procurement-management-system-office'),
    },
    {
        name: 'Alumni Affairs Office',
        href: contentPageShow.url('alumni-affairs-office'),
    },
    {
        name: 'Records Management Office',
        href: contentPageShow.url('records-management-office'),
    },
    {
        name: 'GAD and Values Restoration Office',
        href: contentPageShow.url('gad-and-values-restoration-office'),
    },
    {
        name: 'Information and Public Affairs Office',
        href: contentPageShow.url('information-and-public-affairs-office'),
    },
    {
        name: 'Quality Assurance Office',
        href: contentPageShow.url('quality-assurance-office'),
    },
    {
        name: 'Planning Office',
        href: contentPageShow.url('planning-office'),
    },
    {
        name: 'General Services Office',
        href: contentPageShow.url('general-services-office'),
    },
];

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
</script>

<template>
    <PublicSiteLayout>
        <Head
            title="Office of the Vice President for Administration and Finance"
        />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate z-10 overflow-visible bg-[#1711d4] py-16 text-white sm:py-20"
            >
                <div
                    class="pointer-events-none absolute inset-0 z-0 overflow-hidden"
                    aria-hidden="true"
                >
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.2),transparent_38%),radial-gradient(circle_at_72%_28%,rgba(242,183,5,0.22),transparent_28%),linear-gradient(135deg,rgba(255,255,255,0.08),transparent_34%)]"
                    ></div>
                    <div
                        class="absolute inset-0 [background-image:linear-gradient(90deg,rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(180deg,rgba(255,255,255,0.08)_1px,transparent_1px)] [background-size:3.5rem_3.5rem] opacity-35"
                    ></div>
                    <div
                        class="absolute top-10 left-8 h-44 w-44 rounded-full border border-white/10 sm:h-64 sm:w-64"
                    ></div>
                    <img
                        :src="nemsuSeal"
                        alt=""
                        class="absolute top-1/2 -right-28 size-[30rem] -translate-y-1/2 object-contain opacity-[0.08] mix-blend-screen select-none sm:size-[38rem] lg:right-[4rem]"
                    />
                </div>
                <div
                    class="relative z-10 mx-auto grid max-w-7xl items-center gap-10 px-4 pb-72 sm:px-6 sm:pb-64 lg:grid-cols-[1.25fr_0.75fr] lg:px-8 lg:pb-0"
                >
                    <div>
                        <p
                            class="inline-flex rounded bg-white/10 px-3 py-1 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                        >
                            Administration and Finance
                        </p>
                        <h3
                            class="mt-5 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                        >
                            Office of the Vice President for Administration and
                            Finance
                        </h3>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a
                                href="#ovpaf-offices"
                                class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-semibold text-[#1711d4] transition hover:bg-[#f2b705] hover:text-slate-950"
                            >
                                Explore offices
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </a>
                            <Link
                                :href="home()"
                                class="inline-flex items-center rounded-md border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-[#1711d4]"
                            >
                                Back to Home
                            </Link>
                        </div>
                    </div>

                    <article
                        id="ovpaf-profile"
                        class="absolute top-[calc(100%+2rem)] right-4 z-20 w-[calc(100%-2rem)] max-w-sm overflow-hidden rounded-md border border-white/60 bg-white/95 p-2 text-slate-950 shadow-2xl ring-1 shadow-slate-950/25 ring-slate-950/5 backdrop-blur-xl sm:right-6 lg:top-12 lg:right-8 dark:border-white/10 dark:bg-slate-950/90 dark:text-white"
                    >
                        <div class="relative overflow-hidden rounded-sm">
                            <img
                                src="/images/administration/ovprie/ovpaf/DONAIRE-MAGLINTE,%20,MICHIKO,%20N%20SFFB%20NEMSU_0880%20copy.jpg"
                                alt="Atty. Mitchiko Donaire-Maglinte"
                                class="h-96 w-full object-cover object-top"
                            />
                            <div
                                class="absolute inset-x-0 bottom-0 h-24 bg-linear-to-t from-slate-950/45 to-transparent"
                                aria-hidden="true"
                            ></div>
                        </div>

                        <div class="px-4 pt-5 pb-4 sm:px-5 sm:pb-5">
                            <p
                                class="text-xs font-bold tracking-[0.22em] text-[#f2b705] uppercase"
                            >
                                OIC Vice President
                            </p>
                            <h5
                                class="mt-2 text-2xl leading-tight font-semibold text-slate-950 dark:text-white"
                            >
                                Atty. Mitchiko Donaire-Maglinte
                            </h5>
                            <p
                                class="mt-3 border-t border-slate-200 pt-4 text-sm leading-6 text-slate-600 dark:border-white/10 dark:text-sky-100"
                            >
                                OIC-Vice President for Administration and
                                Finance
                            </p>
                        </div>
                    </article>
                </div>
            </section>

            <section
                id="ovpaf-profile-details"
                class="pt-40 pb-14 sm:pt-36 sm:pb-16 lg:pt-20"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Overview
                        </p>
                        <h4
                            class="mt-3 text-3xl font-semibold tracking-normal sm:text-4xl"
                        >
                            Stewarding administrative and financial excellence
                        </h4>
                        <p
                            class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            This section will contain the official profile of
                            the Office of the Vice President for Administration
                            and Finance. Placeholder text is shown here while
                            the final office profile, leadership statement, and
                            service overview are being prepared.
                        </p>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                    </div>
                </div>
            </section>

            <section
                id="ovpaf-offices"
                class="bg-[#1f007c] py-14 text-white sm:py-16"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#ffbf00] uppercase dark:text-rose-300"
                    >
                        Offices under OVPAF
                    </p>
                    <nav
                        aria-label="Offices under OVPAF"
                        class="mt-10 grid gap-x-12 gap-y-7 text-center sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <Link
                            v-for="office in listedOffices"
                            :key="office.name"
                            :href="office.href"
                            class="group inline-flex items-center justify-center gap-2 text-base font-bold text-white transition hover:text-[#f2b705] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#f2b705] sm:text-lg"
                        >
                            <span>{{ office.name }}</span>
                            <span
                                class="text-[#f2b705] transition group-hover:translate-x-1"
                                aria-hidden="true"
                            >
                                &gt;
                            </span>
                        </Link>
                    </nav>
                </div>
            </section>

            <section
                id="good-governance"
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Good Governance
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                            Accountability and public service
                        </h2>
                    </div>

                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <article
                            v-for="(item, index) in governanceItems"
                            :key="item.title"
                            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                        >
                            <span
                                class="inline-flex size-11 items-center justify-center rounded-xl bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <ShieldCheck
                                    v-if="index === 0"
                                    class="size-5"
                                    aria-hidden="true"
                                />
                                <BadgeCheck
                                    v-else
                                    class="size-5"
                                    aria-hidden="true"
                                />
                            </span>
                            <h3 class="mt-4 text-xl font-semibold">
                                {{ item.title }}
                            </h3>
                            <p
                                class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ item.description }}
                            </p>
                            <Link
                                v-if="item.href"
                                :href="item.href"
                                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                            >
                                View resource
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </Link>
                            <p
                                v-else
                                class="mt-5 text-xs font-semibold tracking-wide text-slate-400 uppercase dark:text-slate-500"
                            >
                                Resource link pending
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="freedom-of-information" class="py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Good Governance
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                            Freedom of Information
                        </h2>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Manuals, request resources, and annual FOI reports
                            are tabulated below for convenient public access.
                        </p>
                    </div>

                    <div
                        class="mt-8 overflow-hidden rounded-2xl border border-slate-200 shadow-sm shadow-slate-900/5 dark:border-white/10"
                    >
                        <div class="overflow-x-auto">
                            <table
                                class="min-w-full divide-y divide-slate-200 dark:divide-white/10"
                            >
                                <thead
                                    class="bg-slate-950 text-left text-white"
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
