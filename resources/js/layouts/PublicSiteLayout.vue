<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    ChevronDown,
    ChevronRight,
    Facebook,
    Mail,
    Menu,
    Phone,
    Search,
    UserRound,
    X,
} from 'lucide-vue-next';
import type { Component } from 'vue';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { dashboard, directory, home } from '@/routes';
import {
    boardOfRegents,
    innovateAgenda,
    officeOfThePresident,
    university,
} from '@/routes/about';
import { academicAffairs } from '@/routes/academics';
import { show as collegeShow } from '@/routes/academics/academic-affairs/colleges';
import { show as graduateProfessionalStudyShow } from '@/routes/academics/academic-affairs/graduate-professional-studies';
import {
    goodGovernance,
    transparencySeal,
    vpaf,
    vppsi,
} from '@/routes/administration';
import { index as announcementsIndex } from '@/routes/announcements';
import { show as campusShow } from '@/routes/campuses';
import { show as newsShow } from '@/routes/news';
import { rie } from '@/routes/research';
import { index as servicesIndex } from '@/routes/services';

type NavLink = {
    label: string;
    href?: string;
    links?: NavLink[];
};

type NavGroup = {
    label: string;
    shortLabel?: string;
    href?: string;
    columns: {
        heading?: string;
        links: NavLink[];
    }[];
};

type FooterContactItem = {
    label: string;
    value: string;
    href?: string;
};

type FooterOfficeContact = {
    office: string;
    value: string;
    href: string;
    icon: Component;
};

type FooterSocialLink = {
    label: string;
    href: string;
    icon: Component;
};

type FooterImageLink = {
    label: string;
    href: string;
    image: string;
    imageAlt: string;
    external?: boolean;
};

type PublicNewsTickerItem = {
    id: string;
    type: 'Announcement' | 'Press Release';
    title: string;
    slug: string;
    date: string | null;
};

const mobileOpen = ref(false);
const tickerIndex = ref(0);
const page = usePage();

let tickerInterval: ReturnType<typeof window.setInterval> | null = null;

const publicNewsTicker = computed(
    () => (page.props.publicNewsTicker ?? []) as PublicNewsTickerItem[],
);

const currentTickerItem = computed(
    () => publicNewsTicker.value[tickerIndex.value] ?? null,
);

const currentTickerHref = computed(() =>
    currentTickerItem.value
        ? newsShow(currentTickerItem.value.slug).url
        : announcementsIndex().url,
);

const headerSealImage = '/storage/images/branding/logos/nemsu-logo.png';

const undergraduateCollegeLinks = [
    {
        label: 'College of Agriculture and Forestry',
        href: collegeShow.url('college-of-agriculture-and-forestry'),
    },
    {
        label: 'College of Arts and Sciences',
        href: collegeShow.url('college-of-arts-and-sciences'),
    },
    {
        label: 'College of Business and Management',
        href: collegeShow.url('college-of-business-and-management'),
    },
    {
        label: 'College of Criminal Justice Education',
        href: collegeShow.url('college-of-criminal-justice-education'),
    },
    {
        label: 'College of Engineering and Technology',
        href: collegeShow.url('college-of-engineering-and-technology'),
    },
    {
        label: 'College of Fisheries and Aquatic Sciences',
        href: collegeShow.url('college-of-fisheries-and-aquatic-sciences'),
    },
    {
        label: 'College of Information Technology Education',
        href: collegeShow.url('college-of-information-technology-education'),
    },
    {
        label: 'College of Teacher Education',
        href: collegeShow.url('college-of-teacher-education'),
    },
];

const professionalStudyLinks = [
    {
        label: 'College of Law',
        href: graduateProfessionalStudyShow.url('college-of-law'),
    },
    {
        label: 'Graduate School',
        href: graduateProfessionalStudyShow.url('graduate-school'),
    },
];

const stopTicker = (): void => {
    if (tickerInterval === null) {
        return;
    }

    window.clearInterval(tickerInterval);
    tickerInterval = null;
};

const startTicker = (): void => {
    stopTicker();

    if (typeof window === 'undefined' || publicNewsTicker.value.length <= 1) {
        return;
    }

    tickerInterval = window.setInterval(() => {
        tickerIndex.value =
            (tickerIndex.value + 1) % publicNewsTicker.value.length;
    }, 5000);
};

onMounted(() => {
    startTicker();
});

onBeforeUnmount(() => {
    stopTicker();
});

watch(publicNewsTicker, (items) => {
    if (tickerIndex.value >= items.length) {
        tickerIndex.value = 0;
    }

    startTicker();
});

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
                        href: innovateAgenda().url,
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
                        href: `${vpaf().url}`,
                    },
                    {
                        label: 'Good Governance',
                        href: goodGovernance().url,
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
        shortLabel: 'Planning',
        columns: [
            {
                links: [
                    {
                        label: 'Planning and Strategic Initiatives',
                        href: `${vppsi().url}`,
                    },
                    {
                        label: 'BAC Matters',
                        href: `${vppsi().url}#ovppsi-offices`,
                    },
                    // { label: 'Unit Head', href: '#governance' },
                    // { label: 'Email', href: '#governance' },
                    // { label: 'Contact Details', href: '#governance' },
                ],
            },
            
        ],
    },
    {
        label: 'Academics',
        columns: [
            {
                links: [
                    {
                        label: 'Academic Affairs',
                        href: academicAffairs().url,
                    },
                    {
                        label: 'Undergraduate',
                        links: undergraduateCollegeLinks,
                    },
                    {
                        label: 'Professional',
                        links: professionalStudyLinks,
                    },
                ],
            },
        ],
    },
    {
        label: 'Research, Innovation, and Extension (RIE)',
        shortLabel: 'RIE',
        columns: [
            {
                links: [
                    {
                        label: 'Research, Innovation, and Extension (RIE)',
                        href: rie().url,
                    },
                    {
                        label: 'Research Centers',
                        href: `${rie().url}#research-centers`,
                    },
                    {
                        label: 'Published Articles',
                        href: `${rie().url}#publication`,
                    },
                    {
                        label: 'Patents',
                        href: `${rie().url}#intellectual-property`,
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
                    { label: 'Tandag Campus', href: campusShow('tandag').url },
                    { label: 'Cantilan Campus', href: campusShow('cantilan').url },
                    { label: 'San Miguel Campus', href: campusShow('san-miguel').url },
                    { label: 'Cagwait Campus', href: campusShow('cagwait').url },
                    { label: 'Lianga Campus', href: campusShow('lianga').url },
                    { label: 'Tagbina Campus', href: campusShow('tagbina').url },
                    { label: 'Bislig Campus', href: campusShow('bislig').url },
                ],
            },
        ],
    },
];

const utilityLinks = [
    // { label: 'Announcements', href: announcementsIndex().url },
    { label: 'Sustainability', href: 'https://sdg.nemsu.edu.ph/' },
    { label: 'Online Services', href: servicesIndex().url },
    { label: 'Directory', href: directory().url },
    // { label: 'Admission', href: '#services' },
];

const footerContactItems: FooterContactItem[] = [
    {
        label: '',
        value: 'Rosario, Tandag City, 8300 Surigao del Sur, Philippines',
    },
];

const footerOfficeContacts: FooterOfficeContact[] = [
    {
        office: 'Office of the President',
        value: '(086) 214-0001',
        href: 'tel:+63862140001',
        icon: Phone,
    },
    {
        office: 'Information Unit',
        value: 'info@nemsu.edu.ph',
        href: 'mailto:info@nemsu.edu.ph',
        icon: Mail,
    },
    {
        office: "Registrar's Office",
        value: '(086) 214-0002',
        href: 'tel:+63862140002',
        icon: Phone,
    },
    {
        office: 'Admission Office',
        value: '(086) 214-0003',
        href: 'tel:+63862140003',
        icon: Phone,
    },
    {
        office: 'Guidance Office',
        value: '(086) 214-0004',
        href: 'tel:+63862140004',
        icon: Phone,
    },
];

const footerSocialLinks: FooterSocialLink[] = [
    {
        label: 'NEMSU on Facebook',
        href: 'https://www.facebook.com/nemsueduph',
        icon: Facebook,
    },
];

const certificationLinks: FooterImageLink[] = [
    {
        label: 'ISO Certification',
        href: 'https://drive.google.com/file/d/1LI4qP_Ge4NfFhDhZ5mlXR5dY5YP3laX4/view',
        image: '/storage/images/compliance/iso/iso.png',
        imageAlt: 'ISO certification logos',
        external: true,
    },
];

const governanceSealLinks: FooterImageLink[] = [
    {
        label: 'Transparency Seal',
        href: transparencySeal().url,
        image: '/storage/images/compliance/transparency-seal/the_transparency_seal2_0-150x150.png',
        imageAlt: 'Transparency Seal',
    },
    {
        label: 'Freedom of Information',
        href: `${vpaf().url}#freedom-of-information`,
        image: '/storage/images/compliance/freedom-of-information/FOI-Logo_0-150x150.png',
        imageAlt: 'Freedom of Information seal',
    },
];

const currentYear = new Date().getFullYear();
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
                    <div class="hidden min-w-0 flex-1 items-center sm:flex">
                        <Transition
                            mode="out-in"
                            enter-active-class="motion-safe:transition motion-safe:duration-300 motion-safe:ease-out motion-reduce:transition-none"
                            enter-from-class="opacity-0 motion-safe:-translate-y-1"
                            enter-to-class="opacity-100 motion-safe:translate-y-0"
                            leave-active-class="motion-safe:transition motion-safe:duration-200 motion-safe:ease-in motion-reduce:transition-none"
                            leave-from-class="opacity-100 motion-safe:translate-y-0"
                            leave-to-class="opacity-0 motion-safe:translate-y-1"
                        >
                            <Link
                                v-if="currentTickerItem"
                                :key="currentTickerItem.id"
                                :href="currentTickerHref"
                                class="group flex max-w-full min-w-0 items-center gap-2 rounded px-2 py-1 text-white/85 transition hover:bg-white/10 hover:text-white"
                            >
                                <span
                                    class="shrink-0 rounded bg-white/15 px-2 py-0.5 text-[10px] font-semibold tracking-wide text-white uppercase"
                                >
                                    Latest
                                </span>
                                <span
                                    class="truncate font-medium text-[#ffbd02]"
                                >
                                    {{ currentTickerItem.title }}
                                </span>
                            </Link>
                            <Link
                                v-else
                                key="empty-ticker"
                                :href="announcementsIndex()"
                                class="flex max-w-full min-w-0 items-center gap-2 rounded px-2 py-1 text-white/85 transition hover:bg-white/10 hover:text-white"
                            >
                                <span
                                    class="shrink-0 rounded bg-white/15 px-2 py-0.5 text-[10px] font-semibold tracking-wide text-white uppercase"
                                >
                                    Latest
                                </span>
                                <span class="truncate font-medium text-white">
                                    Latest updates will appear here soon.
                                </span>
                            </Link>
                        </Transition>
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
                        :src="headerSealImage"
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
                        <Link
                            v-if="group.href"
                            :href="group.href"
                            class="inline-flex h-10 items-center rounded-md px-3 text-sm font-medium whitespace-nowrap text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-white/10 dark:hover:text-white"
                            :title="group.label"
                        >
                            {{ group.shortLabel ?? group.label }}
                        </Link>
                        <button
                            v-else
                            type="button"
                            class="inline-flex h-10 items-center gap-1 rounded-md px-3 text-sm font-medium whitespace-nowrap text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-white/10 dark:hover:text-white"
                            :title="group.label"
                        >
                            {{ group.shortLabel ?? group.label }}
                            <ChevronDown class="size-4" aria-hidden="true" />
                        </button>
                        <div
                            v-if="!group.href"
                            class="invisible absolute top-full left-0 translate-y-2 rounded-md border border-slate-200 bg-white p-4 opacity-0 shadow-xl shadow-slate-900/10 transition delay-0 duration-200 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100 group-focus-within:delay-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-hover:delay-150 motion-reduce:delay-0 dark:border-white/10 dark:bg-slate-900"
                            :class="
                                group.columns.length === 1 ? 'w-80' : 'w-136'
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
                                    <template
                                        v-for="item in column.links"
                                        :key="item.label"
                                    >
                                        <a
                                            v-if="item.href && !item.links"
                                            :href="item.href"
                                            class="block rounded-md px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                        >
                                            {{ item.label }}
                                        </a>
                                        <div
                                            v-else
                                            class="group/subnav relative"
                                        >
                                            <button
                                                type="button"
                                                class="flex w-full items-center justify-between gap-3 rounded-md px-3 py-2 text-left text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                            >
                                                <span>{{ item.label }}</span>
                                                <ChevronRight
                                                    class="size-4 shrink-0"
                                                    aria-hidden="true"
                                                />
                                            </button>
                                            <div
                                                class="invisible absolute top-0 left-full z-50 w-80 rounded-md border border-slate-200 bg-white p-2 opacity-0 shadow-xl shadow-slate-900/10 transition delay-0 duration-200 group-focus-within/subnav:visible group-focus-within/subnav:opacity-100 group-focus-within/subnav:delay-150 group-hover/subnav:visible group-hover/subnav:opacity-100 group-hover/subnav:delay-150 motion-reduce:delay-0 dark:border-white/10 dark:bg-slate-900"
                                            >
                                                <template
                                                    v-for="child in item.links"
                                                    :key="child.label"
                                                >
                                                    <a
                                                        v-if="
                                                            child.href &&
                                                            !child.links
                                                        "
                                                        :href="child.href"
                                                        class="block rounded-md px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                                    >
                                                        {{ child.label }}
                                                    </a>
                                                    <div
                                                        v-else
                                                        class="group/flyout relative"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="flex w-full items-center justify-between gap-3 rounded-md px-3 py-2 text-left text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                                        >
                                                            <span>{{
                                                                child.label
                                                            }}</span>
                                                            <ChevronRight
                                                                class="size-4 shrink-0"
                                                                aria-hidden="true"
                                                            />
                                                        </button>
                                                        <div
                                                            class="invisible absolute top-0 left-full z-50 max-h-[70vh] w-96 overflow-y-auto rounded-md border border-slate-200 bg-white p-2 opacity-0 shadow-xl shadow-slate-900/10 transition delay-0 duration-200 group-focus-within/flyout:visible group-focus-within/flyout:opacity-100 group-focus-within/flyout:delay-150 group-hover/flyout:visible group-hover/flyout:opacity-100 group-hover/flyout:delay-150 motion-reduce:delay-0 dark:border-white/10 dark:bg-slate-900"
                                                        >
                                                            <a
                                                                v-for="grandchild in child.links"
                                                                :key="
                                                                    grandchild.label
                                                                "
                                                                :href="
                                                                    grandchild.href
                                                                "
                                                                class="block rounded-md px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                                            >
                                                                {{
                                                                    grandchild.label
                                                                }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
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
                    <template v-for="group in navGroups" :key="group.label">
                        <Link
                            v-if="group.href"
                            :href="group.href"
                            class="rounded-md border border-slate-200 p-3 text-sm font-semibold text-slate-900 dark:border-white/10 dark:text-white"
                            @click="mobileOpen = false"
                        >
                            {{ group.label }}
                        </Link>
                        <details
                            v-else
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
                                    <template
                                        v-for="item in column.links"
                                        :key="item.label"
                                    >
                                        <a
                                            v-if="item.href && !item.links"
                                            :href="item.href"
                                            class="block rounded-md py-2 text-sm text-slate-600 dark:text-slate-300"
                                            @click="mobileOpen = false"
                                        >
                                            {{ item.label }}
                                        </a>
                                        <details
                                            v-else
                                            class="rounded-md py-1"
                                        >
                                            <summary
                                                class="cursor-pointer py-2 text-sm font-semibold text-slate-800 dark:text-slate-100"
                                            >
                                                {{ item.label }}
                                            </summary>
                                            <div class="ml-4 grid gap-1">
                                                <template
                                                    v-for="child in item.links"
                                                    :key="child.label"
                                                >
                                                    <a
                                                        v-if="
                                                            child.href &&
                                                            !child.links
                                                        "
                                                        :href="child.href"
                                                        class="block rounded-md py-2 text-sm text-slate-600 dark:text-slate-300"
                                                        @click="
                                                            mobileOpen = false
                                                        "
                                                    >
                                                        {{ child.label }}
                                                    </a>
                                                    <details
                                                        v-else
                                                        class="rounded-md py-1"
                                                    >
                                                        <summary
                                                            class="cursor-pointer py-2 text-sm font-semibold text-slate-700 dark:text-slate-200"
                                                        >
                                                            {{ child.label }}
                                                        </summary>
                                                        <div
                                                            class="ml-4 grid gap-1"
                                                        >
                                                            <a
                                                                v-for="grandchild in child.links"
                                                                :key="
                                                                    grandchild.label
                                                                "
                                                                :href="
                                                                    grandchild.href
                                                                "
                                                                class="block rounded-md py-2 text-sm text-slate-600 dark:text-slate-300"
                                                                @click="
                                                                    mobileOpen = false
                                                                "
                                                            >
                                                                {{
                                                                    grandchild.label
                                                                }}
                                                            </a>
                                                        </div>
                                                    </details>
                                                </template>
                                            </div>
                                        </details>
                                    </template>
                                </div>
                            </div>
                        </details>
                    </template>
                </nav>
            </div>
        </header>

        <main>
            <slot />
        </main>

        <footer
            id="footer"
            class="border-t-1 border-[#1711d4] bg-white text-slate-950 dark:bg-slate-950 dark:text-white"
        >
            <div
                class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:grid-cols-2 sm:px-6 lg:grid-cols-[1.05fr_1.15fr_0.9fr_0.9fr] lg:items-start lg:gap-12 lg:px-8 xl:gap-16"
            >
                <section class="grid content-start gap-7">
                    <div class="flex flex-col items-start gap-4">
                        <img
                            src="/storage/images/branding/logos/nemsu-logo.png"
                            alt="NEMSU seal"
                            class="size-32 shrink-0 rounded-full object-contain shadow-sm ring-1 shadow-slate-900/10 ring-slate-200 dark:ring-white/15"
                        />
                        <p
                            class="text-4xl font-extrabold tracking-wide text-slate-950 dark:text-white"
                        >
                            NEMSU
                        </p>
                    </div>

                    <div
                        class="grid gap-3 text-sm text-slate-700 dark:text-slate-300"
                    >
                        <component
                            :is="item.href ? 'a' : 'p'"
                            v-for="item in footerContactItems"
                            :key="item.label"
                            :href="item.href"
                            class="flex rounded-md transition hover:text-[#1711d4] dark:hover:text-sky-200"
                        >
                            <span>
                                <span
                                    class="block text-xs font-semibold tracking-wide text-slate-500 dark:text-slate-400"
                                >
                                    {{ item.label }}
                                </span>
                                <span class="block leading-6">{{
                                    item.value
                                }}</span>
                            </span>
                        </component>
                    </div>

                    <div>
                        <h2
                            class="text-sm font-semibold tracking-wide text-slate-950 dark:text-white"
                        >
                            Follow Us
                        </h2>
                        <div
                            class="mt-4 flex flex-wrap gap-3"
                            aria-label="Official social media"
                        >
                            <a
                                v-for="social in footerSocialLinks"
                                :key="social.label"
                                :href="social.href"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex size-8 items-center justify-center rounded-full bg-[#1711d4]/10 text-[#1711d4] transition hover:bg-[#1711d4] hover:text-white dark:bg-[#f2b705]/15 dark:text-[#f2b705] dark:hover:bg-[#f2b705] dark:hover:text-slate-950"
                                :aria-label="social.label"
                            >
                                <component
                                    :is="social.icon"
                                    class="size-4"
                                    aria-hidden="true"
                                />
                            </a>
                        </div>
                    </div>
                </section>

                <section>
                    <h2
                        class="text-sm font-semibold tracking-wide text-slate-950 dark:text-white"
                    >
                        Contacts
                    </h2>
                    <div class="mt-5 grid gap-5">
                        <a
                            v-for="contact in footerOfficeContacts"
                            :key="contact.office"
                            :href="contact.href"
                            class="group flex items-center gap-3 text-sm text-slate-700 transition hover:text-[#1711d4] dark:text-slate-300 dark:hover:text-sky-200"
                        >
                            <span
                                class="inline-flex size-8 shrink-0 items-center justify-center rounded-full bg-[#1711d4]/10 text-[#1711d4] transition group-hover:bg-[#1711d4] group-hover:text-white dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                            >
                                <component
                                    :is="contact.icon"
                                    class="size-4"
                                    aria-hidden="true"
                                />
                            </span>
                            <span>
                                <span
                                    class="block font-semibold tracking-wide text-slate-950 dark:text-white"
                                >
                                    {{ contact.office }}
                                </span>
                                <span class="mt-1 block leading-6">
                                    {{ contact.value }}
                                </span>
                            </span>
                        </a>
                    </div>
                </section>

                <section
                    class="grid content-start justify-items-center text-center"
                >
                    <h2
                        class="text-sm font-semibold tracking-wide text-slate-950 dark:text-white"
                    >
                        Certification
                    </h2>
                    <div class="mt-5 grid gap-4">
                        <a
                            v-for="certification in certificationLinks"
                            :key="certification.label"
                            :href="certification.href"
                            :target="
                                certification.external ? '_blank' : undefined
                            "
                            :rel="
                                certification.external ? 'noopener' : undefined
                            "
                            class="grid min-h-36 justify-items-center"
                            :aria-label="certification.label"
                        >
                            <img
                                :src="certification.image"
                                :alt="certification.imageAlt"
                                class="mx-auto max-h-32 max-w-full object-contain"
                            />
                        </a>
                    </div>
                </section>

                <section
                    class="grid content-start justify-items-center text-center"
                >
                    <h2
                        class="text-sm font-semibold tracking-wide text-slate-950 dark:text-white"
                    >
                        Transparency Seal
                    </h2>
                    <div class="mt-5 grid justify-items-center gap-7">
                        <a
                            :href="governanceSealLinks[0].href"
                            :target="
                                governanceSealLinks[0].external
                                    ? '_blank'
                                    : undefined
                            "
                            :rel="
                                governanceSealLinks[0].external
                                    ? 'noopener'
                                    : undefined
                            "
                            class="grid justify-items-center"
                            :aria-label="governanceSealLinks[0].label"
                        >
                            <img
                                :src="governanceSealLinks[0].image"
                                :alt="governanceSealLinks[0].imageAlt"
                                class="mx-auto max-h-28 max-w-full object-contain"
                            />
                        </a>
                        <a
                            :href="governanceSealLinks[1].href"
                            :target="
                                governanceSealLinks[1].external
                                    ? '_blank'
                                    : undefined
                            "
                            :rel="
                                governanceSealLinks[1].external
                                    ? 'noopener'
                                    : undefined
                            "
                            class="grid justify-items-center gap-4 text-sm font-semibold tracking-wide text-slate-950 transition dark:text-white"
                            :aria-label="governanceSealLinks[1].label"
                        >
                            <span>{{ governanceSealLinks[1].label }}</span>
                            <img
                                :src="governanceSealLinks[1].image"
                                :alt="governanceSealLinks[1].imageAlt"
                                class="mx-auto max-h-28 max-w-full object-contain"
                            />
                        </a>
                    </div>
                </section>
            </div>
            <div
                class="border-t border-slate-200 bg-[#1711d4] px-4 py-5 text-center text-xs text-white dark:border-white/10"
            >
                © {{ currentYear }} North Eastern Mindanao State University. All
                rights reserved.
            </div>
        </footer>
    </div>
</template>
