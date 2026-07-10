<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    ChevronDown,
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
import {
    citizensCharter,
    goodGovernance,
    transparencySeal,
    vpaf,
    vppsi,
} from '@/routes/administration';
import { index as announcementsIndex } from '@/routes/announcements';
import { show as campusShow } from '@/routes/campuses';
import { index as servicesIndex } from '@/routes/services';
import { show as newsShow } from '@/routes/news';
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
        image: 'https://nemsu.edu.ph/assets/images/ISO.jpg',
        imageAlt: 'ISO certification logos',
        external: true,
    },
];

const governanceSealLinks: FooterImageLink[] = [
    {
        label: 'Transparency Seal',
        href: transparencySeal().url,
        image: '/storage/assets/image/the_transparency_seal2_0-150x150.png',
        imageAlt: 'Transparency Seal',
    },
    {
        label: 'Freedom of Information',
        href: `${goodGovernance().url}#freedom-of-information`,
        image: '/storage/assets/image/FOI-Logo_0-150x150.png',
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
                                <span class="truncate font-medium text-white">
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
            class="border-t-4 border-[#1711d4] bg-white text-slate-950 dark:bg-slate-950 dark:text-white"
        >
            <div
                class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:grid-cols-2 sm:px-6 lg:grid-cols-[1.05fr_1.15fr_0.9fr_0.9fr] lg:items-start lg:gap-12 lg:px-8 xl:gap-16"
            >
                <section class="grid content-start gap-7">
                    <div class="flex flex-col items-start gap-4">
                        <img
                            src="https://nemsu.edu.ph/assets/images/NEMSU.png"
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
