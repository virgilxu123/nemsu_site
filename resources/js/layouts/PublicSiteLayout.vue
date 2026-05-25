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
} from 'lucide-vue-next';
import { ref } from 'vue';
import { dashboard, home, login } from '@/routes';

type NavGroup = {
    label: string;
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
                    { label: 'History', href: '#about' },
                    { label: 'Vision and Mission', href: '#about' },
                    { label: 'Core Values', href: '#about' },
                    { label: 'University Seal', href: '#about' },
                ],
            },
            {
                heading: 'Leadership',
                links: [
                    { label: 'Board of Regents', href: '#governance' },
                    { label: 'Office of the President', href: '#governance' },
                    { label: 'INNOVATE Agenda', href: '#about' },
                    { label: 'ALPAS', href: '#about' },
                ],
            },
        ],
    },
    {
        label: 'Administration',
        columns: [
            {
                heading: 'Vice Presidents',
                links: [
                    {
                        label: 'Administration and Finance',
                        href: '#governance',
                    },
                    {
                        label: 'Planning and Strategic Initiatives',
                        href: '#governance',
                    },
                    { label: 'Academic Affairs', href: '#academics' },
                    {
                        label: 'Research, Innovation, and Extension',
                        href: '#research',
                    },
                ],
            },
            {
                heading: 'Good Governance',
                links: [
                    { label: 'Transparency Seal', href: '#governance' },
                    { label: 'Freedom of Information', href: '#governance' },
                    { label: "Citizen's Charter", href: '#governance' },
                    { label: 'BAC Matters', href: '#governance' },
                ],
            },
        ],
    },
    {
        label: 'Academics',
        columns: [
            {
                heading: 'Programs',
                links: [
                    { label: 'Undergraduate Programs', href: '#academics' },
                    { label: 'Graduate School Programs', href: '#academics' },
                    { label: 'College of Law', href: '#academics' },
                    { label: 'College of Medicine', href: '#academics' },
                ],
            },
            {
                heading: 'Support',
                links: [
                    { label: 'Admission', href: '#services' },
                    { label: 'Registrar', href: '#services' },
                    { label: 'Guidance Office', href: '#services' },
                    { label: 'University Library', href: '#services' },
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
                class="border-b border-slate-200/70 bg-[#062b49] text-white dark:border-white/10"
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
                            class="block text-sm font-semibold tracking-wide text-[#062b49] uppercase dark:text-sky-200"
                            >NEMSU</span
                        >
                        <span
                            class="block truncate text-xs text-slate-600 dark:text-slate-300"
                            >North Eastern Mindanao State University</span
                        >
                    </span>
                </Link>

                <nav class="hidden items-center gap-1 lg:flex">
                    <div
                        v-for="group in navGroups"
                        :key="group.label"
                        class="group relative"
                    >
                        <button
                            type="button"
                            class="inline-flex h-10 items-center gap-1 rounded-md px-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-white/10 dark:hover:text-white"
                        >
                            {{ group.label }}
                            <ChevronDown class="size-4" aria-hidden="true" />
                        </button>
                        <div
                            class="invisible absolute top-full left-0 w-[34rem] translate-y-2 rounded-md border border-slate-200 bg-white p-4 opacity-0 shadow-xl shadow-slate-900/10 transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 dark:border-white/10 dark:bg-slate-900"
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

                <div class="hidden items-center gap-2 lg:flex">
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
                        class="inline-flex h-10 items-center gap-2 rounded-md bg-[#062b49] px-4 text-sm font-semibold text-white transition hover:bg-[#0b3d66]"
                    >
                        <UserRound class="size-4" aria-hidden="true" />
                        Dashboard
                    </Link>
                    <Link
                        v-else
                        :href="login()"
                        class="inline-flex h-10 items-center gap-2 rounded-md bg-[#062b49] px-4 text-sm font-semibold text-white transition hover:bg-[#0b3d66]"
                    >
                        <UserRound class="size-4" aria-hidden="true" />
                        Login
                    </Link>
                </div>

                <button
                    type="button"
                    class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-800 lg:hidden dark:border-white/10 dark:text-white"
                    aria-label="Toggle menu"
                    @click="mobileOpen = !mobileOpen"
                >
                    <X v-if="mobileOpen" class="size-5" aria-hidden="true" />
                    <Menu v-else class="size-5" aria-hidden="true" />
                </button>
            </div>

            <div
                v-if="mobileOpen"
                class="border-t border-slate-200 bg-white px-4 py-4 lg:hidden dark:border-white/10 dark:bg-slate-950"
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
                                class="text-sm font-semibold tracking-wide text-[#062b49] uppercase dark:text-sky-200"
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
                            class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-700 dark:border-white/10 dark:text-slate-200"
                            aria-label="Online services"
                        >
                            <Globe2 class="size-4" aria-hidden="true" />
                        </a>
                        <a
                            href="#governance"
                            class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-700 dark:border-white/10 dark:text-slate-200"
                            aria-label="Governance"
                        >
                            <ShieldCheck class="size-4" aria-hidden="true" />
                        </a>
                        <a
                            href="#academics"
                            class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-700 dark:border-white/10 dark:text-slate-200"
                            aria-label="Academics"
                        >
                            <GraduationCap class="size-4" aria-hidden="true" />
                        </a>
                    </div>
                </section>

                <div class="grid gap-8 sm:grid-cols-3">
                    <section>
                        <h2
                            class="text-sm font-semibold text-slate-950 dark:text-white"
                        >
                            Information
                        </h2>
                        <div
                            class="mt-4 grid gap-2 text-sm text-slate-600 dark:text-slate-300"
                        >
                            <a href="#about">About Us</a>
                            <a href="#governance">Administration</a>
                            <a href="#academics">Academic Affairs</a>
                            <a href="#research">Research and Extension</a>
                        </div>
                    </section>
                    <section>
                        <h2
                            class="text-sm font-semibold text-slate-950 dark:text-white"
                        >
                            Services
                        </h2>
                        <div
                            class="mt-4 grid gap-2 text-sm text-slate-600 dark:text-slate-300"
                        >
                            <a href="#services">Admission</a>
                            <a href="#services">Registrar</a>
                            <a href="#services">Guidance Office</a>
                            <a href="#governance">BAC Matters</a>
                        </div>
                    </section>
                    <section>
                        <h2
                            class="text-sm font-semibold text-slate-950 dark:text-white"
                        >
                            Contact
                        </h2>
                        <div
                            class="mt-4 grid gap-2 text-sm text-slate-600 dark:text-slate-300"
                        >
                            <span>086-214-4221</span>
                            <span>information@nemsu.edu.ph</span>
                            <a href="#governance">Transparency Seal</a>
                            <a href="#governance">Freedom of Information</a>
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
