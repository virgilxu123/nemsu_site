<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ChevronDown,
    Globe2,
    Menu,
    Search,
    UserRound,
    X,
    Facebook,
    Phone,
    Mail,
} from 'lucide-vue-next';
import { ref } from 'vue';
import { dashboard, home } from '@/routes';
import {
    boardOfRegents,
    officeOfThePresident,
    university,
} from '@/routes/about';
import { academicAffairs } from '@/routes/academics';
import {
    citizensCharter,
    transparencySeal,
    vpaf,
    vppsi,
} from '@/routes/administration';
import { index as announcementsIndex } from '@/routes/announcements';
import { show as campusShow } from '@/routes/campuses';
import { rie } from '@/routes/research';

type NavGroup = {
    label: string;
    shortLabel?: string;
    columns: {
        heading?: string;
        links: {
            label: string;
            href: string;
        }[];
    }[];
};

const mobileOpen = ref(false);

const navGroups: NavGroup[] = [
    {
        label: 'About Us',
        columns: [
            {
                links: [
                    { label: 'The University', href: `${university().url}` },
                    { label: 'Board of Regents', href: boardOfRegents().url },
                    {
                        label: 'Office of the President',
                        href: officeOfThePresident().url,
                    },
                    {
                        label: 'INNOVATE Agenda',
                        href: `${officeOfThePresident().url}#innovate-agenda`,
                    },
                ],
            },
        ],
    },
    {
        label: 'Administration',
        columns: [
            {
                links: [
                    {
                        label: 'Administration and Finance',
                        href: `${vpaf().url}#ovpaf-profile`,
                    },
                    {
                        label: 'Good Governance',
                        href: `${vpaf().url}#ovpaf-offices`,
                    },
                    // { label: 'Unit Head', href: '#governance' },
                    // { label: 'Email', href: '#governance' },
                    // { label: 'Contact Details', href: '#governance' },
                ],
            },
        ],
    },
    {
        label: 'Planning and Strategic Initiatives',
        shortLabel: 'Planning & Strategy',
        columns: [
            {
                heading: 'OVPPSI',
                links: [
                    {
                        label: 'Profile',
                        href: `${vppsi().url}#ovppsi-profile`,
                    },
                    {
                        label: 'Offices under OVPPSI',
                        href: `${vppsi().url}#ovppsi-offices`,
                    },
                    // { label: 'Unit Head', href: '#governance' },
                    // { label: 'Email', href: '#governance' },
                    // { label: 'Contact Details', href: '#governance' },
                ],
            },
            {
                heading: 'Procurement',
                links: [
                    {
                        label: 'BAC Matters',
                        href: `${vppsi().url}#bac-matters`,
                    },
                ],
            },
        ],
    },
    {
        label: 'Academics',
        columns: [
            {
                heading: 'Academic Affairs',
                links: [
                    {
                        label: 'OVPAA Profile',
                        href: `${academicAffairs().url}#ovpaa-profile`,
                    },
                    {
                        label: 'Offices under OVPAA',
                        href: `${academicAffairs().url}#ovpaa-offices`,
                    },
                    // { label: 'Unit Head', href: '#academics' },
                    // { label: 'Email', href: '#academics' },
                    // { label: 'Contact Details', href: '#academics' },
                ],
            },
            {
                heading: 'Program Offerings',
                links: [
                    {
                        label: 'Undergraduate Programs',
                        href: `${academicAffairs().url}#undergraduate-programs`,
                    },
                    {
                        label: 'Graduate School Programs',
                        href: `${academicAffairs().url}#graduate-school-programs`,
                    },
                    {
                        label: 'College of Law',
                        href: `${academicAffairs().url}#college-of-law`,
                    },
                    {
                        label: 'College of Medicine',
                        href: `${academicAffairs().url}#college-of-medicine`,
                    },
                ],
            },
        ],
    },
    {
        label: 'Research, Innovation, and Extension',
        shortLabel: 'RIE',
        columns: [
            {
                heading: 'OVPRIE',
                links: [
                    { label: 'Profile', href: `${rie().url}#ovprie-profile` },
                    { label: 'RIE Manual', href: `${rie().url}#rie-manual` },
                    {
                        label: 'Offices under OVPRIE',
                        href: `${rie().url}#ovprie-offices`,
                    },
                    {
                        label: 'Research Office',
                        href: `${rie().url}#research`,
                    },
                    {
                        label: 'Innovation Office',
                        href: `${rie().url}#innovation`,
                    },
                    {
                        label: 'Extension Office',
                        href: `${rie().url}#extension`,
                    },
                ],
            },
            {
                heading: 'Research, Innovation, Extension',
                links: [
                    {
                        label: 'Research Centers',
                        href: `${rie().url}#research-centers`,
                    },
                    {
                        label: 'Publication',
                        href: `${rie().url}#publication`,
                    },
                    {
                        label: 'Patents, UI, Copyrights and Trademarks',
                        href: `${rie().url}#intellectual-property`,
                    },
                    {
                        label: 'News and Updates',
                        href: `${rie().url}#rie-news`,
                    },
                ],
            },
        ],
    },
    {
        label: 'Campuses',
        columns: [
            {
                heading: 'NEMSU System',
                links: [
                    { label: 'Tandag', href: campusShow('tandag').url },
                    { label: 'Cantilan', href: campusShow('cantilan').url },
                    { label: 'San Miguel', href: campusShow('san-miguel').url },
                    { label: 'Cagwait', href: campusShow('cagwait').url },
                ],
            },
            {
                heading: 'More Campuses',
                links: [
                    { label: 'Lianga', href: campusShow('lianga').url },
                    { label: 'Tagbina', href: campusShow('tagbina').url },
                    { label: 'Bislig', href: campusShow('bislig').url },
                    { label: 'Campus Life', href: campusShow('tandag').url },
                ],
            },
        ],
    },
];

const utilityLinks = [
    { label: 'Announcements', href: announcementsIndex().url },
    { label: 'Sustainability', href: '#about' },
    { label: 'Online Services', href: '#services' },
    { label: 'Directory', href: '#footer' },
    { label: 'Admission', href: '#services' },
];
</script>

<template>
    <div
        class="public-site min-h-screen bg-[#f7f8f5] text-slate-950 dark:bg-slate-950 dark:text-white"
    >
        <header
            class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur dark:border-white/10 dark:bg-slate-950/95"
        >
            <div
                class="border-b border-slate-200/70 bg-[#1711d4] text-white dark:border-white/10"
            >
                <div
                    class="mx-auto flex h-10 max-w-7xl items-center justify-between gap-4 px-4 text-xs sm:px-6 lg:px-8"
                >
                    <div class="hidden items-center gap-4 sm:flex">
                        <span>086-214-4221</span>
                        <span class="h-3 w-px bg-white/30"></span>
                        <span>information@nemsu.edu.ph</span>
                    </div>
                    <nav
                        class="flex min-w-0 flex-1 items-center justify-end gap-1 sm:flex-none"
                    >
                        <a
                            v-for="link in utilityLinks"
                            :key="link.label"
                            :href="link.href"
                            class="rounded px-2.5 py-1 text-white/85 transition hover:bg-white/10 hover:text-white"
                        >
                            {{ link.label }}
                        </a>
                    </nav>
                </div>
            </div>

            <div
                class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
            >
                <Link :href="home()" class="flex min-w-0 items-center gap-3">
                    <img
                        src="https://nemsu.edu.ph/assets/images/NEMSU.png"
                        alt="NEMSU seal"
                        class="h-12 w-12 shrink-0 rounded-full bg-white object-contain ring-1 ring-slate-200"
                    />
                    <span class="min-w-0">
                        <span
                            class="block text-sm font-semibold tracking-wide text-[#1711d4] uppercase dark:text-sky-200"
                            >NEMSU</span
                        >
                        <span
                            class="block truncate text-xs text-slate-600 dark:text-slate-300"
                            >North Eastern Mindanao State University</span
                        >
                    </span>
                </Link>

                <nav class="hidden items-center gap-1 xl:flex">
                    <div
                        v-for="group in navGroups"
                        :key="group.label"
                        class="group relative"
                    >
                        <button
                            type="button"
                            class="inline-flex h-10 items-center gap-1 rounded-md px-3 text-sm font-medium whitespace-nowrap text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-white/10 dark:hover:text-white"
                            :title="group.label"
                        >
                            {{ group.shortLabel ?? group.label }}
                            <ChevronDown class="size-4" aria-hidden="true" />
                        </button>
                        <div
                            class="invisible absolute top-full left-0 translate-y-2 rounded-md border border-slate-200 bg-white p-4 opacity-0 shadow-xl shadow-slate-900/10 transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 dark:border-white/10 dark:bg-slate-900"
                            :class="
                                group.columns.length === 1 ? 'w-72' : 'w-136'
                            "
                        >
                            <div
                                class="grid gap-4"
                                :class="
                                    group.columns.length === 1
                                        ? 'grid-cols-1'
                                        : 'grid-cols-2'
                                "
                            >
                                <section
                                    v-for="column in group.columns"
                                    :key="
                                        column.heading || column.links[0]?.label
                                    "
                                    class="space-y-2"
                                >
                                    <h2
                                        v-if="column.heading"
                                        class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                    >
                                        {{ column.heading }}
                                    </h2>
                                    <a
                                        v-for="item in column.links"
                                        :key="item.label"
                                        :href="item.href"
                                        class="block rounded-md px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                    >
                                        {{ item.label }}
                                    </a>
                                </section>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="hidden items-center gap-2 xl:flex">
                    <button
                        type="button"
                        class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-700 transition hover:bg-slate-100 dark:border-white/10 dark:text-slate-200 dark:hover:bg-white/10"
                        aria-label="Search"
                    >
                        <Search class="size-4" aria-hidden="true" />
                    </button>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="dashboard()"
                        class="inline-flex h-10 items-center gap-2 rounded-md bg-[#1711d4] px-4 text-sm font-semibold text-white transition hover:bg-[#0f0ab8]"
                    >
                        <UserRound class="size-4" aria-hidden="true" />
                        Dashboard
                    </Link>
                    <!-- Login removed per request -->
                </div>

                <button
                    type="button"
                    class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-800 xl:hidden dark:border-white/10 dark:text-white"
                    aria-label="Toggle menu"
                    @click="mobileOpen = !mobileOpen"
                >
                    <X v-if="mobileOpen" class="size-5" aria-hidden="true" />
                    <Menu v-else class="size-5" aria-hidden="true" />
                </button>
            </div>

            <div
                v-if="mobileOpen"
                class="border-t border-slate-200 bg-white px-4 py-4 xl:hidden dark:border-white/10 dark:bg-slate-950"
            >
                <nav class="mx-auto grid max-w-7xl gap-3">
                    <details
                        v-for="group in navGroups"
                        :key="group.label"
                        class="rounded-md border border-slate-200 p-3 dark:border-white/10"
                    >
                        <summary
                            class="cursor-pointer text-sm font-semibold text-slate-900 dark:text-white"
                        >
                            {{ group.label }}
                        </summary>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2">
                            <div
                                v-for="column in group.columns"
                                :key="column.heading || column.links[0]?.label"
                            >
                                <p
                                    v-if="column.heading"
                                    class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    {{ column.heading }}
                                </p>
                                <a
                                    v-for="item in column.links"
                                    :key="item.label"
                                    :href="item.href"
                                    class="block rounded-md py-2 text-sm text-slate-600 dark:text-slate-300"
                                    @click="mobileOpen = false"
                                >
                                    {{ item.label }}
                                </a>
                            </div>
                        </div>
                    </details>
                </nav>
            </div>
        </header>

        <main>
            <slot />
        </main>

        <footer
            id="footer"
            class="border-t-4 border-[#1711d4] bg-slate-950 text-white"
        >
            <div
                class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1.1fr_1fr_1fr] lg:px-8"
            >
                <section>
                    <div class="flex items-center gap-5">
                        <img
                            src="https://nemsu.edu.ph/assets/images/NEMSU.png"
                            alt="NEMSU seal"
                            class="size-24 shrink-0 rounded-full bg-white object-contain p-1 ring-4 ring-white/10"
                        />
                        <div>
                            <p
                                class="text-2xl font-bold tracking-wide text-white uppercase"
                            >
                                NEMSU
                            </p>
                            <p
                                class="mt-1 max-w-xs text-sm leading-6 font-medium text-sky-100"
                            >
                                North Eastern Mindanao State University
                            </p>
                        </div>
                    </div>

                    <div class="mt-7 grid gap-3 text-sm text-slate-300">
                        <p class="flex items-start gap-3">
                            <Globe2
                                class="mt-0.5 size-4 shrink-0 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            <span>
                                Rosario, Tandag City, 8300 Surigao del Sur,
                                Philippines
                            </span>
                        </p>
                        <a
                            href="tel:+63862144221"
                            class="flex items-center gap-3 transition hover:text-white"
                        >
                            <Phone
                                class="size-4 shrink-0 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            (086) 214-4221
                        </a>
                        <a
                            href="mailto:information@nemsu.edu.ph"
                            class="flex items-center gap-3 transition hover:text-white"
                        >
                            <Mail
                                class="size-4 shrink-0 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            information@nemsu.edu.ph
                        </a>
                    </div>

                    <div
                        class="mt-7 flex gap-2"
                        aria-label="Official social media"
                    >
                        <a
                            href="https://www.facebook.com/photo?fbid=434718275981498&set=a.158278150292180"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex size-10 items-center justify-center rounded-full border border-white/15 bg-white/5 transition hover:border-[#1877f2] hover:bg-[#1877f2]"
                            aria-label="NEMSU on Facebook"
                        >
                            <Facebook class="size-5" aria-hidden="true" />
                        </a>
                    </div>
                </section>

                <section>
                    <h2
                        class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                    >
                        Official Links
                    </h2>
                    <nav class="mt-5 grid gap-3 text-sm text-slate-300">
                        <a
                            href="https://nemsu.edu.ph/directory"
                            target="_blank"
                            rel="noopener"
                            class="transition hover:text-white"
                        >
                            University Directory
                        </a>
                        <a
                            :href="citizensCharter().url"
                            class="transition hover:text-white"
                        >
                            Citizen's Charter
                        </a>
                        <a
                            :href="transparencySeal().url"
                            class="transition hover:text-white"
                        >
                            Transparency Seal
                        </a>
                        <a
                            :href="`${vpaf().url}#freedom-of-information`"
                            class="transition hover:text-white"
                        >
                            Freedom of Information
                        </a>
                        <a
                            href="https://memo.nemsu.edu.ph"
                            target="_blank"
                            rel="noopener"
                            class="transition hover:text-white"
                        >
                            University Memoranda
                        </a>
                    </nav>
                </section>

                <section>
                    <h2
                        class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                    >
                        Government & Certification
                    </h2>
                    <div class="mt-5 flex flex-wrap items-center gap-4">
                        <a
                            :href="transparencySeal().url"
                            class="grid size-28 place-items-center rounded-md bg-white p-3 transition hover:-translate-y-1"
                            aria-label="Transparency Seal"
                        >
                            <img
                                src="https://nemsu.edu.ph/assets/images/seal.png"
                                alt="Transparency Seal"
                                class="max-h-full max-w-full object-contain"
                            />
                        </a>
                        <a
                            href="https://www.gov.ph"
                            target="_blank"
                            rel="noopener"
                            class="grid size-28 place-items-center rounded-md border border-white/15 bg-white/5 p-3 text-center text-xs leading-5 font-semibold text-sky-100 transition hover:-translate-y-1 hover:bg-white/10"
                        >
                            Republic of the Philippines
                        </a>
                    </div>
                </section>
            </div>
            <div
                class="border-t border-white/10 py-5 text-center text-xs text-slate-400"
            >
                © {{ new Date().getFullYear() }} North Eastern Mindanao State
                University. All rights reserved.
            </div>
        </footer>
    </div>
</template>
