<script setup lang="ts">
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { show as newsShow } from '@/routes/news';
import {
    ArrowRight,
    BookOpen,
    Building2,
    CalendarDays,
    FileText,
    GraduationCap,
    Landmark,
    MapPin,
    Megaphone,
    Microscope,
    ShieldCheck,
    Sparkles,
    Users,
} from 'lucide-vue-next';
import type { Component } from 'vue';

type Feature = {
    icon: Component;
    title: string;
    description: string;
    href: string;
};

type NewsItem = {
    id: string;
    type: string;
    title: string;
    slug: string;
    excerpt?: string | null;
    date: string | null;
    office: string;
    photoUrl?: string | null;
};

type Campus = {
    name: string;
    focus: string;
    detail: string;
};

type Metric = {
    label: string;
    value: string;
    note: string;
};

const heroImage = 'https://nemsu.edu.ph/files/News/cm-00.jpg';

const quickActions: Feature[] = [
    {
        icon: GraduationCap,
        title: 'Program Offerings',
        description:
            'Undergraduate, graduate, law, and medicine pathways across the NEMSU system.',
        href: '#academics',
    },
    {
        icon: FileText,
        title: 'Good Governance',
        description:
            "Transparency Seal, FOI, Citizen's Charter, accomplishment reports, and BAC matters.",
        href: '#governance',
    },
    {
        icon: Building2,
        title: 'Campus Directory',
        description:
            'Campus profiles, services, facilities, student government, and contact details.',
        href: '#campuses',
    },
];

const props = withDefaults(
    defineProps<{
        featuredNews?: NewsItem | null;
        pressReleases?: NewsItem[];
    }>(),
    {
        featuredNews: null,
        pressReleases: () => [],
    },
);

const campuses: Campus[] = [
    {
        name: 'Tandag',
        focus: 'Main Campus',
        detail: 'Central administration, graduate studies, engineering, information technology, and medicine.',
    },
    {
        name: 'Cantilan',
        focus: 'Technology Education',
        detail: 'Industrial technology, trades, and technical education programs.',
    },
    {
        name: 'San Miguel',
        focus: 'Agriculture and Forestry',
        detail: 'Agro-forestry, field laboratories, and community-based extension.',
    },
    {
        name: 'Lianga',
        focus: 'Fisheries and Marine Sciences',
        detail: 'Coastal resources, aquaculture, and marine research.',
    },
    {
        name: 'Cagwait',
        focus: 'Industrial Technology',
        detail: 'Technology programs and campus life near the coast.',
    },
    {
        name: 'Bislig',
        focus: 'Agroforestry and Industry',
        detail: 'Integrated programs for forestry, engineering, and regional industry.',
    },
];

const metrics: Metric[] = [
    { label: 'Campuses', value: '7', note: 'System-wide presence' },
    {
        label: 'Core Functions',
        value: '4',
        note: 'Instruction, research, extension, production',
    },
    {
        label: 'Public Services',
        value: '24+',
        note: 'Offices and online services',
    },
    {
        label: 'Priority Agenda',
        value: 'INNOVATE',
        note: 'Strategic university direction',
    },
];

const academicTracks: Feature[] = [
    {
        icon: BookOpen,
        title: 'Undergraduate Programs',
        description:
            'Campus, college, prospectus, objectives, and learning outcomes.',
        href: '#academics',
    },
    {
        icon: GraduationCap,
        title: 'Graduate School',
        description:
            'Advanced education aligned with research and professional practice.',
        href: '#academics',
    },
    {
        icon: Landmark,
        title: 'Law and Medicine',
        description:
            'Specialized colleges with dedicated program pages and updates.',
        href: '#academics',
    },
];

const governanceLinks: Feature[] = [
    {
        icon: ShieldCheck,
        title: 'Transparency Seal',
        description:
            'Public accountability documents, reports, and compliance materials.',
        href: '#governance',
    },
    {
        icon: FileText,
        title: 'Freedom of Information',
        description:
            'FOI access, request guidance, and public information channels.',
        href: '#governance',
    },
    {
        icon: Megaphone,
        title: "Citizen's Charter",
        description:
            'Frontline services, processing times, requirements, and contacts.',
        href: '#governance',
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="North Eastern Mindanao State University" />

        <section class="relative overflow-hidden bg-[#062b49] text-white">
            <img
                :src="heroImage"
                alt="NEMSU campus activity"
                class="absolute inset-0 h-full w-full object-cover opacity-28"
            />
            <div class="absolute inset-0 bg-[#062b49]/82"></div>

            <div
                class="relative mx-auto grid min-h-[72svh] max-w-7xl content-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8"
            >
                <div class="max-w-3xl">
                    <p
                        class="inline-flex items-center gap-2 rounded-md border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold tracking-wide text-sky-100 uppercase"
                    >
                        <Sparkles class="size-4" aria-hidden="true" />
                        Research University for Sustainable Development
                    </p>
                    <h1
                        class="mt-6 text-4xl font-semibold tracking-normal text-balance sm:text-5xl lg:text-6xl"
                    >
                        North Eastern Mindanao State University
                    </h1>
                    <p
                        class="mt-6 max-w-2xl text-base leading-8 text-sky-50 sm:text-lg"
                    >
                        We drive sustainable development through quality
                        instruction, innovative research, community
                        collaboration, and technological advancement.
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a
                            href="#academics"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-md bg-[#f2b705] px-5 text-sm font-semibold text-slate-950 transition hover:bg-[#ffd24a]"
                        >
                            Explore Programs
                            <ArrowRight class="size-4" aria-hidden="true" />
                        </a>
                        <a
                            href="#services"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-md border border-white/25 px-5 text-sm font-semibold text-white transition hover:bg-white/10"
                        >
                            Online Services
                            <ArrowRight class="size-4" aria-hidden="true" />
                        </a>
                    </div>
                </div>

                <aside class="self-end border-l border-white/20 pl-6">
                    <p
                        class="text-sm font-semibold tracking-wide text-sky-100 uppercase"
                    >
                        NEMSU at a glance
                    </p>
                    <div class="mt-5 grid grid-cols-2 gap-4">
                        <div
                            v-for="metric in metrics"
                            :key="metric.label"
                            class="border-t border-white/20 pt-4"
                        >
                            <p class="text-3xl font-semibold text-white">
                                {{ metric.value }}
                            </p>
                            <p class="mt-1 text-sm font-medium text-sky-100">
                                {{ metric.label }}
                            </p>
                            <p class="mt-1 text-xs text-sky-200">
                                {{ metric.note }}
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section
            class="border-b border-slate-200 bg-white dark:border-white/10 dark:bg-slate-950"
        >
            <div
                class="mx-auto grid max-w-7xl gap-4 px-4 py-6 sm:px-6 md:grid-cols-3 lg:px-8"
            >
                <a
                    v-for="action in quickActions"
                    :key="action.title"
                    :href="action.href"
                    class="group grid grid-cols-[auto_1fr_auto] items-start gap-4 rounded-md border border-slate-200 p-4 transition hover:border-[#0b6680] hover:bg-slate-50 dark:border-white/10 dark:hover:border-sky-400/60 dark:hover:bg-white/5"
                >
                    <span
                        class="inline-flex size-10 items-center justify-center rounded-md bg-[#e6f3f5] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                    >
                        <component
                            :is="action.icon"
                            class="size-5"
                            aria-hidden="true"
                        />
                    </span>
                    <span>
                        <span
                            class="block text-sm font-semibold text-slate-950 dark:text-white"
                            >{{ action.title }}</span
                        >
                        <span
                            class="mt-1 block text-sm leading-6 text-slate-600 dark:text-slate-300"
                            >{{ action.description }}</span
                        >
                    </span>
                    <ArrowRight
                        class="mt-1 size-4 text-slate-400 transition group-hover:translate-x-1 group-hover:text-[#0b6680]"
                        aria-hidden="true"
                    />
                </a>
            </div>
        </section>

        <section id="about" class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div
                class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8"
            >
                <div>
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        About NEMSU
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        A system built for Mindanaoan progress
                    </h2>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <article
                        class="rounded-md border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-white/5"
                    >
                        <h3
                            class="text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            Vision
                        </h3>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            A Research University advancing technology and
                            innovation for sustainable development.
                        </p>
                    </article>
                    <article
                        class="rounded-md border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-white/5"
                    >
                        <h3
                            class="text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            Mission
                        </h3>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Quality instruction, innovative research, community
                            collaboration, and technological advancement.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="academics" class="bg-white py-16 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col justify-between gap-6 md:flex-row md:items-end"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Academic Affairs
                        </p>
                        <h2
                            class="mt-3 max-w-2xl text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Program pages ready for prospectus, objectives, and
                            learning outcomes
                        </h2>
                    </div>
                    <a
                        href="#campuses"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#062b49] dark:text-sky-200"
                    >
                        View campuses
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </a>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <article
                        v-for="track in academicTracks"
                        :key="track.title"
                        class="rounded-md border border-slate-200 bg-[#fbfcfa] p-6 dark:border-white/10 dark:bg-white/5"
                    >
                        <component
                            :is="track.icon"
                            class="size-7 text-[#0b6680] dark:text-sky-300"
                            aria-hidden="true"
                        />
                        <h3
                            class="mt-5 text-lg font-semibold text-slate-950 dark:text-white"
                        >
                            {{ track.title }}
                        </h3>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            {{ track.description }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="updates" class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid items-start gap-8 lg:grid-cols-[minmax(0,1.15fr)_minmax(24rem,0.85fr)]"
                >
                    <div class="grid gap-4">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Featured
                        </p>

                        <Link
                            v-if="props.featuredNews"
                            :href="newsShow(props.featuredNews.slug)"
                            class="group relative isolate min-h-[26rem] overflow-hidden rounded-md border border-slate-200 bg-slate-950 shadow-sm shadow-slate-900/10 dark:border-white/10"
                        >
                            <img
                                v-if="props.featuredNews.photoUrl"
                                :src="props.featuredNews.photoUrl"
                                :alt="props.featuredNews.title"
                                class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                            />
                            <div
                                v-else
                                class="absolute inset-0 grid place-items-center bg-[#062b49]"
                            >
                                <Megaphone
                                    class="size-14 text-white/60"
                                    aria-hidden="true"
                                />
                            </div>
                            <div
                                class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/55 to-slate-950/5"
                            ></div>
                            <div
                                class="relative flex min-h-[26rem] flex-col justify-end p-5 sm:p-7"
                            >
                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs font-medium text-white/80"
                                >
                                    <span
                                        class="rounded bg-[#9b1c31] px-2.5 py-1 text-white"
                                    >
                                        Featured News
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1.5"
                                    >
                                        <CalendarDays
                                            class="size-3.5"
                                            aria-hidden="true"
                                        />
                                        {{ props.featuredNews.date }}
                                    </span>
                                </div>
                                <h3
                                    class="mt-4 max-w-2xl text-2xl leading-tight font-semibold tracking-normal text-white sm:text-3xl"
                                >
                                    {{ props.featuredNews.title }}
                                </h3>
                                <p
                                    v-if="props.featuredNews.excerpt"
                                    class="mt-3 line-clamp-3 max-w-2xl text-sm leading-7 text-white/85"
                                >
                                    {{ props.featuredNews.excerpt }}
                                </p>
                                <p
                                    class="mt-4 text-xs font-medium text-white/70"
                                >
                                    {{ props.featuredNews.office }}
                                </p>
                            </div>
                        </Link>

                        <article
                            v-else
                            class="grid min-h-[26rem] place-items-center rounded-md border border-dashed border-slate-300 bg-white p-6 text-center text-sm leading-7 text-slate-600 dark:border-white/15 dark:bg-white/5 dark:text-slate-300"
                        >
                            Featured news will appear here after a published
                            news record is marked as featured.
                        </article>
                    </div>

                    <div class="grid gap-4">
                        <div
                            class="flex items-center justify-between border-b border-slate-200 pb-3 dark:border-white/10"
                        >
                            <h2
                                class="text-sm font-semibold tracking-wide text-slate-950 uppercase dark:text-white"
                            >
                                Latest News
                            </h2>
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#9b1c31]"
                                aria-hidden="true"
                            ></span>
                        </div>

                        <Link
                            v-for="item in props.pressReleases"
                            :key="item.id"
                            :href="newsShow(item.slug)"
                            class="group grid grid-cols-[7rem_1fr] gap-4 rounded-md border border-slate-200 bg-white p-3 transition hover:border-[#9b1c31]/45 hover:bg-white sm:grid-cols-[8rem_1fr] dark:border-white/10 dark:bg-white/5 dark:hover:border-rose-300/50 dark:hover:bg-white/[0.07]"
                        >
                            <div
                                class="overflow-hidden rounded bg-slate-100 dark:bg-white/10"
                            >
                                <img
                                    v-if="item.photoUrl"
                                    :src="item.photoUrl"
                                    :alt="item.title"
                                    class="aspect-[4/3] h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                />
                                <div
                                    v-else
                                    class="grid aspect-[4/3] h-full w-full place-items-center text-[#9b1c31] dark:text-rose-200"
                                >
                                    <Megaphone
                                        class="size-6"
                                        aria-hidden="true"
                                    />
                                </div>
                            </div>
                            <div class="min-w-0 self-center">
                                <div
                                    class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] font-medium text-slate-500 dark:text-slate-400"
                                >
                                    <span
                                        class="rounded bg-[#f8e7eb] px-2 py-0.5 text-[#9b1c31] dark:bg-rose-400/10 dark:text-rose-200"
                                        >{{ item.type }}</span
                                    >
                                    <span
                                        class="inline-flex items-center gap-1.5"
                                    >
                                        <CalendarDays
                                            class="size-3.5"
                                            aria-hidden="true"
                                        />
                                        {{ item.date }}
                                    </span>
                                </div>
                                <h3
                                    class="mt-2 line-clamp-2 font-sans text-sm leading-6 font-semibold tracking-normal text-slate-950 transition group-hover:text-[#062b49] dark:text-white dark:group-hover:text-sky-100"
                                >
                                    {{ item.title }}
                                </h3>
                                <p
                                    class="mt-2 truncate text-xs font-medium text-slate-500 dark:text-slate-400"
                                >
                                    {{ item.office }}
                                </p>
                            </div>
                        </Link>
                        <article
                            v-if="props.pressReleases.length === 0"
                            class="rounded-md border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-600 dark:border-white/15 dark:bg-white/5 dark:text-slate-300"
                        >
                            Press releases will appear here after published news
                            records are available.
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="campuses" class="bg-white py-16 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                    >
                        Campuses
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        One system, distinct campus strengths
                    </h2>
                </div>
                <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <article
                        v-for="campus in campuses"
                        :key="campus.name"
                        class="rounded-md border border-slate-200 p-5 dark:border-white/10"
                    >
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex size-10 items-center justify-center rounded-md bg-[#edf7ed] text-[#2f6f4e] dark:bg-emerald-400/10 dark:text-emerald-200"
                            >
                                <MapPin class="size-5" aria-hidden="true" />
                            </span>
                            <div>
                                <h3
                                    class="font-semibold text-slate-950 dark:text-white"
                                >
                                    {{ campus.name }}
                                </h3>
                                <p
                                    class="text-sm text-[#2f6f4e] dark:text-emerald-200"
                                >
                                    {{ campus.focus }}
                                </p>
                            </div>
                        </div>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            {{ campus.detail }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="research" class="bg-[#062b49] py-16 text-white">
            <div
                class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-3 lg:px-8"
            >
                <div class="lg:col-span-1">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                    >
                        Research, Innovation, and Extension
                    </p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                        A clearer home for RIE work
                    </h2>
                </div>
                <div class="grid gap-4 md:grid-cols-3 lg:col-span-2">
                    <article class="rounded-md border border-white/15 p-5">
                        <Microscope
                            class="size-7 text-[#f2b705]"
                            aria-hidden="true"
                        />
                        <h3 class="mt-5 font-semibold">Research</h3>
                        <p class="mt-3 text-sm leading-7 text-sky-100">
                            Centers, publications, manuals, and research news.
                        </p>
                    </article>
                    <article class="rounded-md border border-white/15 p-5">
                        <Sparkles
                            class="size-7 text-[#f2b705]"
                            aria-hidden="true"
                        />
                        <h3 class="mt-5 font-semibold">Innovation</h3>
                        <p class="mt-3 text-sm leading-7 text-sky-100">
                            Patents, utility models, copyrights, and trademarks.
                        </p>
                    </article>
                    <article class="rounded-md border border-white/15 p-5">
                        <Users
                            class="size-7 text-[#f2b705]"
                            aria-hidden="true"
                        />
                        <h3 class="mt-5 font-semibold">Extension</h3>
                        <p class="mt-3 text-sm leading-7 text-sky-100">
                            Programs, community partnerships, and updates.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="governance" class="bg-white py-16 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        Good Governance
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        Public accountability content grouped for quick access
                    </h2>
                </div>
                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <a
                        v-for="item in governanceLinks"
                        :key="item.title"
                        :href="item.href"
                        class="rounded-md border border-slate-200 p-6 transition hover:border-[#9b1c31] hover:bg-[#fff8f9] dark:border-white/10 dark:hover:border-rose-300/60 dark:hover:bg-white/5"
                    >
                        <component
                            :is="item.icon"
                            class="size-7 text-[#9b1c31] dark:text-rose-300"
                            aria-hidden="true"
                        />
                        <h3
                            class="mt-5 font-semibold text-slate-950 dark:text-white"
                        >
                            {{ item.title }}
                        </h3>
                        <p
                            class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            {{ item.description }}
                        </p>
                    </a>
                </div>
            </div>
        </section>

        <section id="services" class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div
                class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8"
            >
                <div>
                    <p
                        class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                    >
                        Online Services
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        Student and public services without the maze
                    </h2>
                    <p
                        class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                    >
                        Admission, directory, registrar, guidance,
                        certifications, downloadable forms, and office contacts
                        are designed as direct paths.
                    </p>
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <a
                        v-for="label in [
                            'Admission',
                            'Directory',
                            'Registrar',
                            'Guidance Office',
                            'Certification',
                            'Downloadable Forms',
                        ]"
                        :key="label"
                        href="#services"
                        class="inline-flex items-center justify-between rounded-md border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 dark:border-white/10 dark:bg-white/5 dark:text-white"
                    >
                        {{ label }}
                        <ArrowRight
                            class="size-4 text-slate-400"
                            aria-hidden="true"
                        />
                    </a>
                </div>
            </div>
        </section>
    </PublicSiteLayout>
</template>
