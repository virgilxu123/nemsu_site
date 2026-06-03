<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ChevronDown,
    Globe2,
    GraduationCap,
    Menu,
    Search,
    ShieldCheck,
    UserRound,
    X,
    Facebook,
    Youtube,
    Instagram,
    MonitorPlay,
    Phone,
    Mail,
    BadgeCheck,
    FileSearch,
} from 'lucide-vue-next';
import { ref } from 'vue';
import { dashboard, home } from '@/routes';
import {
    boardOfRegents,
    officeOfThePresident,
    university,
} from '@/routes/about';
import { transparencySeal } from '@/routes/administration';
import { index as announcementsIndex } from '@/routes/announcements';

type NavGroup = {
    label: string;
    shortLabel?: string;
    columns: {
        heading: string;
        links: {
            label: string;
            href: string;
        }[];
    }[];
};

const mobileOpen = ref(false);

const navGroups: NavGroup[] = [
    {
        label: 'About',
        columns: [
            {
                heading: 'University',
                links: [
                    { label: 'History', href: `${university().url}#history` },
                    {
                        label: 'Vision and Mission',
                        href: `${university().url}#vision-and-mission`,
                    },
                    {
                        label: 'Core Values',
                        href: `${university().url}#core-values`,
                    },
                    {
                        label: 'University Seal',
                        href: `${university().url}#university-seal`,
                    },
                ],
            },
            {
                heading: 'Leadership',
                links: [
                    { label: 'Board of Regents', href: boardOfRegents().url },
                    {
                        label: 'Office of the President',
                        href: officeOfThePresident().url,
                    },
                ],
            },
        ],
    },
    {
        label: 'Administration',
        columns: [
            {
                heading: 'Administration and Finance',
                links: [
                    { label: 'OVPAF Profile', href: '#governance' },
                    {
                        label: 'Offices under OVPAF',
                        href: '#governance',
                    },
                    // { label: 'Unit Head', href: '#governance' },
                    // { label: 'Email', href: '#governance' },
                    // { label: 'Contact Details', href: '#governance' },
                ],
            },
            {
                heading: 'Good Governance',
                links: [
                    { label: 'Transparency Seal', href: transparencySeal().url },
                    { label: 'Freedom of Information', href: '#governance' },
                    { label: "Citizen's Charter", href: '#governance' },
                ],
            },
        ],
    },
    {
        label: 'Planning and Strategic Initiatives',
        shortLabel: 'Planning & Strategy',
        columns: [
            {
                heading: 'OVPSI',
                links: [
                    { label: 'Profile', href: '#governance' },
                    { label: 'Offices under OVPSI', href: '#governance' },
                    // { label: 'Unit Head', href: '#governance' },
                    // { label: 'Email', href: '#governance' },
                    // { label: 'Contact Details', href: '#governance' },
                ],
            },
            {
                heading: 'Procurement',
                links: [{ label: 'BAC Matters', href: '#governance' }],
            },
        ],
    },
    {
        label: 'Academics',
        columns: [
            {
                heading: 'Academic Affairs',
                links: [
                    { label: 'OVPAA Profile', href: '#academics' },
                    { label: 'Offices under OVPAA', href: '#academics' },
                    // { label: 'Unit Head', href: '#academics' },
                    // { label: 'Email', href: '#academics' },
                    // { label: 'Contact Details', href: '#academics' },
                ],
            },
            {
                heading: 'Program Offerings',
                links: [
                    { label: 'Undergraduate Programs', href: '#academics' },
                    { label: 'Graduate School Programs', href: '#academics' },
                    { label: 'College of Law', href: '#academics' },
                    { label: 'College of Medicine', href: '#academics' },
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
                    { label: 'Profile', href: '#research' },
                    { label: 'RIE Manual', href: '#research' },
                    { label: 'Offices under OVPRIE', href: '#research' },
                    { label: 'Research Office', href: '#research' },
                    { label: 'Innovation Office', href: '#research' },
                    { label: 'Extension Office', href: '#research' },
                ],
            },
            {
                heading: 'Research, Innovation, Extension',
                links: [
                    { label: 'Research Centers', href: '#research' },
                    { label: 'Publication', href: '#research' },
                    {
                        label: 'Patents, UI, Copyrights and Trademarks',
                        href: '#research',
                    },
                    { label: 'News and Updates', href: '#research' },
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
                    { label: 'Tandag', href: '#campuses' },
                    { label: 'Cantilan', href: '#campuses' },
                    { label: 'San Miguel', href: '#campuses' },
                    { label: 'Cagwait', href: '#campuses' },
                ],
            },
            {
                heading: 'More Campuses',
                links: [
                    { label: 'Lianga', href: '#campuses' },
                    { label: 'Tagbina', href: '#campuses' },
                    { label: 'Bislig', href: '#campuses' },
                    { label: 'Campus Life', href: '#campuses' },
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
        class="min-h-screen bg-[#f7f8f5] text-slate-950 dark:bg-slate-950 dark:text-white"
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
                            class="rounded px-2 py-1 text-white/85 transition hover:bg-white/10 hover:text-white"
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
                            class="inline-flex h-10 items-center gap-1 whitespace-nowrap rounded-md px-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-white/10 dark:hover:text-white"
                            :title="group.label"
                        >
                            {{ group.shortLabel ?? group.label }}
                            <ChevronDown class="size-4" aria-hidden="true" />
                        </button>
                        <div
                            class="invisible absolute top-full left-0 w-136 translate-y-2 rounded-md border border-slate-200 bg-white p-4 opacity-0 shadow-xl shadow-slate-900/10 transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 dark:border-white/10 dark:bg-slate-900"
                        >
                            <div class="grid grid-cols-2 gap-4">
                                <section
                                    v-for="column in group.columns"
                                    :key="column.heading"
                                    class="space-y-2"
                                >
                                    <h2
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
                                :key="column.heading"
                            >
                                <p
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
            class="border-t border-slate-200 bg-white dark:border-white/10 dark:bg-slate-950"
        >
            <div
                class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-[1.2fr_2fr] lg:px-8"
            >
                <section class="space-y-5">
                    <div class="flex items-center gap-3">
                        <img
                            src="https://nemsu.edu.ph/assets/images/NEMSU.png"
                            alt="NEMSU seal"
                            class="h-14 w-14 rounded-full bg-white object-contain ring-1 ring-slate-200"
                        />
                        <div>
                            <p
                                class="text-sm font-semibold tracking-wide text-[#1711d4] uppercase dark:text-sky-200"
                            >
                                NEMSU
                            </p>
                            <p
                                class="text-sm text-slate-600 dark:text-slate-300"
                            >
                                Rosario, Tandag City, Surigao del Sur
                            </p>
                        </div>
                    </div>
                    <p
                        class="max-w-md text-sm leading-6 text-slate-600 dark:text-slate-300"
                    >
                        A research university advancing technology and
                        innovation for sustainable development across the NEMSU
                        system.
                    </p>
                    <div class="flex gap-2">
                        <a
                            href="#services"
                            class="inline-flex size-10 items-center justify-center rounded-md border border-sky-200 bg-sky-50 text-sky-700 transition hover:bg-sky-100 hover:text-sky-800 dark:border-sky-400/20 dark:bg-sky-400/10 dark:text-sky-200 dark:hover:bg-sky-400/15"
                            aria-label="Online services"
                        >
                            <Globe2 class="size-4" aria-hidden="true" />
                        </a>
                        <a
                            href="#governance"
                            class="inline-flex size-10 items-center justify-center rounded-md border border-emerald-200 bg-emerald-50 text-emerald-700 transition hover:bg-emerald-100 hover:text-emerald-800 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-200 dark:hover:bg-emerald-400/15"
                            aria-label="Governance"
                        >
                            <ShieldCheck class="size-4" aria-hidden="true" />
                        </a>
                        <a
                            href="#academics"
                            class="inline-flex size-10 items-center justify-center rounded-md border border-amber-200 bg-amber-50 text-amber-700 transition hover:bg-amber-100 hover:text-amber-800 dark:border-amber-400/20 dark:bg-amber-400/10 dark:text-amber-200 dark:hover:bg-amber-400/15"
                            aria-label="Academics"
                        >
                            <GraduationCap class="size-4" aria-hidden="true" />
                        </a>
                    </div>
                </section>

                <div
                    class="grid gap-8 sm:grid-cols-2 xl:grid-cols-[0.8fr_1.6fr_0.9fr]"
                >
                    <section>
                        <h2
                            class="text-sm font-semibold text-slate-950 dark:text-white"
                        >
                            Follow Us
                        </h2>
                        <div
                            class="mt-4 grid gap-3 text-sm text-slate-600 dark:text-slate-300"
                        >
                            <a
                                href="#"
                                class="group inline-flex items-center gap-2 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                            >
                                <Facebook
                                    class="size-4 text-[#1877f2] transition group-hover:scale-105"
                                    aria-hidden="true"
                                />
                                Facebook
                            </a>
                            <a
                                href="#"
                                class="group inline-flex items-center gap-2 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                            >
                                <MonitorPlay
                                    class="size-4 text-cyan-500 transition group-hover:scale-105 dark:text-cyan-300"
                                    aria-hidden="true"
                                />
                                Tiktok
                            </a>
                            <a
                                href="#"
                                class="group inline-flex items-center gap-2 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                            >
                                <Instagram
                                    class="size-4 text-pink-600 transition group-hover:scale-105 dark:text-pink-400"
                                    aria-hidden="true"
                                />
                                Instagram
                            </a>
                            <a
                                href="#"
                                class="group inline-flex items-center gap-2 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                            >
                                <Youtube
                                    class="size-4 text-red-600 transition group-hover:scale-105 dark:text-red-400"
                                    aria-hidden="true"
                                />
                                Youtube
                            </a>
                        </div>
                    </section>
                    <section class="sm:col-span-2 xl:col-span-1">
                        <h2
                            class="text-sm font-semibold text-slate-950 dark:text-white"
                        >
                            Contact Details
                        </h2>
                        <div
                            class="mt-4 grid gap-4 text-sm text-slate-600 sm:grid-cols-2 dark:text-slate-300"
                        >
                            <div
                                class="flex flex-col gap-1 rounded bg-slate-50 p-2.5 dark:bg-white/5"
                            >
                                <span
                                    class="text-xs font-semibold tracking-wider text-slate-900 uppercase dark:text-slate-200"
                                    >Office of the President</span
                                >
                                <a
                                    href="tel:+63862140001"
                                    class="inline-flex items-center gap-1.5 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                                >
                                    <Phone
                                        class="size-3.5 text-emerald-600 dark:text-emerald-300"
                                        aria-hidden="true"
                                    />
                                    (086) 214-0001
                                </a>
                            </div>
                            <div
                                class="flex flex-col gap-1 rounded bg-slate-50 p-2.5 dark:bg-white/5"
                            >
                                <span
                                    class="text-xs font-semibold tracking-wider text-slate-900 uppercase dark:text-slate-200"
                                    >Information Unit</span
                                >
                                <a
                                    href="mailto:info@nemsu.edu.ph"
                                    class="inline-flex items-center gap-1.5 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                                >
                                    <Mail
                                        class="size-3.5 text-sky-600 dark:text-sky-300"
                                        aria-hidden="true"
                                    />
                                    info@nemsu.edu.ph
                                </a>
                            </div>
                            <div
                                class="flex flex-col gap-1 rounded bg-slate-50 p-2.5 dark:bg-white/5"
                            >
                                <span
                                    class="text-xs font-semibold tracking-wider text-slate-900 uppercase dark:text-slate-200"
                                    >Registrar's Office</span
                                >
                                <a
                                    href="tel:+63862140002"
                                    class="inline-flex items-center gap-1.5 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                                >
                                    <Phone
                                        class="size-3.5 text-emerald-600 dark:text-emerald-300"
                                        aria-hidden="true"
                                    />
                                    (086) 214-0002
                                </a>
                            </div>
                            <div
                                class="flex flex-col gap-1 rounded bg-slate-50 p-2.5 dark:bg-white/5"
                            >
                                <span
                                    class="text-xs font-semibold tracking-wider text-slate-900 uppercase dark:text-slate-200"
                                    >Admission Office</span
                                >
                                <a
                                    href="tel:+63862140003"
                                    class="inline-flex items-center gap-1.5 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                                >
                                    <Phone
                                        class="size-3.5 text-emerald-600 dark:text-emerald-300"
                                        aria-hidden="true"
                                    />
                                    (086) 214-0003
                                </a>
                            </div>
                            <div
                                class="flex flex-col gap-1 rounded bg-slate-50 p-2.5 dark:bg-white/5"
                            >
                                <span
                                    class="text-xs font-semibold tracking-wider text-slate-900 uppercase dark:text-slate-200"
                                    >Guidance Office</span
                                >
                                <a
                                    href="tel:+63862140004"
                                    class="inline-flex items-center gap-1.5 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                                >
                                    <Phone
                                        class="size-3.5 text-emerald-600 dark:text-emerald-300"
                                        aria-hidden="true"
                                    />
                                    (086) 214-0004
                                </a>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h2
                            class="text-sm font-semibold text-slate-950 dark:text-white"
                        >
                            Resources
                        </h2>
                        <div
                            class="mt-4 grid gap-3 text-sm text-slate-600 dark:text-slate-300"
                        >
                            <a
                                href="#services"
                                class="group inline-flex items-center gap-2 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                            >
                                <BadgeCheck
                                    class="size-4 text-amber-600 transition group-hover:scale-105 dark:text-amber-300"
                                    aria-hidden="true"
                                />
                                Certification
                            </a>
                            <a
                                :href="transparencySeal().url"
                                class="group inline-flex items-center gap-2 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                            >
                                <ShieldCheck
                                    class="size-4 text-emerald-600 transition group-hover:scale-105 dark:text-emerald-300"
                                    aria-hidden="true"
                                />
                                Transparency Seal
                            </a>
                            <a
                                href="#governance"
                                class="group inline-flex items-center gap-2 transition hover:text-[#1711d4] dark:hover:text-sky-300"
                            >
                                <FileSearch
                                    class="size-4 text-sky-600 transition group-hover:scale-105 dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                Freedom of Information
                            </a>
                        </div>
                    </section>
                </div>
            </div>
            <div
                class="border-t border-slate-200 py-5 text-center text-xs text-slate-500 dark:border-white/10 dark:text-slate-400"
            >
                North Eastern Mindanao State University
            </div>
        </footer>
    </div>
</template>
