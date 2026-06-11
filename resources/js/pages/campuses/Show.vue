<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BadgeCheck,
    CalendarDays,
    ExternalLink,
    FileText,
    GraduationCap,
    HeartHandshake,
    Mail,
    MapPin,
    Phone,
    ShieldCheck,
    Sparkles,
    UsersRound,
} from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { show as campusShow } from '@/routes/campuses';

type Stat = {
    label: string;
    value: string;
    note: string;
};

type ProgramGroup = {
    college: string;
    offerings: string[];
};

type FacilityGalleryItem = {
    image: string;
    alt: string;
    title?: string;
    description?: string;
    category?: string;
    featured?: boolean;
    wide?: boolean;
};

type ServiceHighlight = {
    title: string;
    description: string;
    images: {
        image: string;
        alt: string;
    }[];
};

type StudentGovernmentActivity = {
    title: string;
    date: string;
    description: string;
    images: {
        image: string;
        alt: string;
    }[];
};

type Campus = {
    slug: string;
    name: string;
    label: string;
    location: string;
    heroImage: string;
    secondaryImage: string;
    profile: {
        headline: string;
        overview: string;
        highlights: string[];
    };
    director: {
        name: string;
        role: string;
        office: string;
        email: string;
        phone: string;
        photo: string;
    };
    contact: {
        address: string;
        email: string;
        phone: string;
        officeHours: string;
    };
    stats: Stat[];
    facilities: string[];
    facilityGallery: FacilityGalleryItem[];
    programs: ProgramGroup[];
    prospectuses: Record<string, string>;
    campusLife: string[];
    services: string[];
    serviceHighlights?: ServiceHighlight[];
    studentGovernment: {
        name: string;
        adviser: string;
        focus: string;
        initiatives: string[];
        activities: StudentGovernmentActivity[];
    };
    updates: {
        date: string;
        title: string;
        summary: string;
    }[];
};

defineProps<{
    campus: Campus;
    campuses: Campus[];
}>();
</script>

<template>
    <PublicSiteLayout>
        <Head :title="campus.name" />

        <section
            class="relative isolate overflow-hidden bg-slate-950 text-white"
        >
            <img
                :src="campus.heroImage"
                :alt="campus.name"
                class="absolute inset-0 -z-20 h-full w-full object-cover"
            />
            <div
                class="absolute inset-0 -z-10 bg-linear-to-r from-slate-950 via-[#061b49]/90 to-[#1711d4]/55"
            ></div>

            <div
                class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1fr_26rem] lg:px-8 lg:py-20"
            >
                <div class="flex min-h-[30rem] flex-col justify-end">
                    <div class="flex flex-wrap items-center gap-2">
                        <Link
                            :href="home()"
                            class="rounded bg-white/10 px-3 py-1.5 text-xs font-semibold text-white/85 transition hover:bg-white/15 hover:text-white"
                        >
                            NEMSU
                        </Link>
                        <span
                            class="inline-flex items-center gap-1.5 rounded bg-[#f2b705] px-3 py-1.5 text-xs font-semibold text-[#2f2400]"
                        >
                            <MapPin class="size-3.5" aria-hidden="true" />
                            {{ campus.location }}
                        </span>
                    </div>

                    <p
                        class="mt-8 text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                    >
                        {{ campus.label }}
                    </p>
                    <h1
                        class="mt-3 max-w-4xl text-4xl leading-tight font-semibold tracking-normal sm:text-6xl"
                    >
                        {{ campus.name }}
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-sky-100">
                        {{ campus.profile.headline }}
                    </p>
                </div>

                <aside
                    class="self-end rounded-md border border-white/15 bg-white/10 p-5 shadow-2xl shadow-black/25 backdrop-blur-md"
                >
                    <div class="overflow-hidden rounded bg-slate-900">
                        <img
                            :src="campus.secondaryImage"
                            :alt="`${campus.name} campus view`"
                            class="aspect-[4/3] w-full object-cover"
                        />
                    </div>
                    <div class="mt-5 grid gap-3">
                        <div
                            v-for="highlight in campus.profile.highlights"
                            :key="highlight"
                            class="flex items-center gap-3 rounded bg-white/10 p-3 text-sm text-sky-50"
                        >
                            <BadgeCheck
                                class="size-4 shrink-0 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            {{ highlight }}
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section
            class="border-b border-slate-200 bg-white dark:border-white/10 dark:bg-slate-950"
        >
            <div
                class="mx-auto grid max-w-7xl gap-4 px-4 py-6 sm:px-6 md:grid-cols-4 lg:px-8"
            >
                <article
                    v-for="stat in campus.stats"
                    :key="stat.label"
                    class="rounded-md border border-slate-200 p-5 dark:border-white/10"
                >
                    <p
                        class="text-3xl font-semibold text-[#1711d4] dark:text-sky-200"
                    >
                        {{ stat.value }}
                    </p>
                    <h2
                        class="mt-2 text-sm font-semibold text-slate-950 dark:text-white"
                    >
                        {{ stat.label }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        {{ stat.note }}
                    </p>
                </article>
            </div>
        </section>

        <section class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div
                class="mx-auto grid max-w-7xl items-start gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_24rem] lg:px-8"
            >
                <article class="max-w-4xl">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        About the Campus
                    </p>
                    <h2
                        class="mt-3 max-w-3xl text-3xl leading-tight font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                    >
                        {{ campus.profile.headline }}
                    </h2>
                    <p
                        class="mt-6 text-base leading-8 whitespace-pre-line text-slate-600 dark:text-slate-300"
                    >
                        {{ campus.profile.overview }}
                    </p>
                </article>

                <aside class="grid gap-4 lg:sticky lg:top-24">
                    <article
                        class="relative overflow-hidden rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div
                            class="absolute inset-x-0 top-0 h-1 bg-[#1711d4]"
                        ></div>
                        <div class="flex items-center gap-4">
                            <span
                                class="inline-flex size-12 shrink-0 items-center justify-center rounded-md bg-[#e6f3f5] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <UsersRound class="size-5" aria-hidden="true" />
                            </span>
                            <div>
                                <p
                                    class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    Campus Director
                                </p>
                                <h3
                                    class="mt-2 font-semibold text-slate-950 dark:text-white"
                                >
                                    {{ campus.director.name }}
                                </h3>
                                <p
                                    class="mt-1 text-sm text-slate-500 dark:text-slate-400"
                                >
                                    {{ campus.director.office }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="mt-6 grid gap-2 border-t border-slate-200 pt-5 text-sm text-slate-600 dark:border-white/10 dark:text-slate-300"
                        >
                            <a
                                :href="`mailto:${campus.director.email}`"
                                class="inline-flex min-h-10 items-center gap-3 rounded-md px-3 transition hover:bg-[#e6f3f5] hover:text-[#1711d4] dark:hover:bg-white/10 dark:hover:text-sky-200"
                            >
                                <Mail
                                    class="size-4 shrink-0"
                                    aria-hidden="true"
                                />
                                {{ campus.director.email }}
                            </a>
                            <a
                                :href="`tel:${campus.director.phone}`"
                                class="inline-flex min-h-10 items-center gap-3 rounded-md px-3 transition hover:bg-[#e6f3f5] hover:text-[#1711d4] dark:hover:bg-white/10 dark:hover:text-sky-200"
                            >
                                <Phone
                                    class="size-4 shrink-0"
                                    aria-hidden="true"
                                />
                                {{ campus.director.phone }}
                            </a>
                        </div>
                    </article>

                    <article
                        class="relative overflow-hidden rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div
                            class="absolute inset-x-0 top-0 h-1 bg-[#f2b705]"
                        ></div>
                        <div class="flex items-center gap-4">
                            <span
                                class="inline-flex size-12 shrink-0 items-center justify-center rounded-md bg-[#fff4cc] text-[#795200] dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                            >
                                <MapPin class="size-5" aria-hidden="true" />
                            </span>
                            <div>
                                <p
                                    class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    Visit the Campus
                                </p>
                                <h3
                                    class="mt-2 font-semibold text-slate-950 dark:text-white"
                                >
                                    Contact Details
                                </h3>
                            </div>
                        </div>
                        <div
                            class="mt-6 grid gap-4 border-t border-slate-200 pt-5 text-sm leading-6 text-slate-600 dark:border-white/10 dark:text-slate-300"
                        >
                            <p class="flex gap-3">
                                <MapPin
                                    class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <span>{{ campus.contact.address }}</span>
                            </p>
                            <a
                                :href="`mailto:${campus.contact.email}`"
                                class="flex gap-3 transition hover:text-[#1711d4] dark:hover:text-sky-200"
                            >
                                <Mail
                                    class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <span>{{ campus.contact.email }}</span>
                            </a>
                            <a
                                :href="`tel:${campus.contact.phone}`"
                                class="flex gap-3 transition hover:text-[#1711d4] dark:hover:text-sky-200"
                            >
                                <Phone
                                    class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <span>{{ campus.contact.phone }}</span>
                            </a>
                            <p class="flex gap-3">
                                <CalendarDays
                                    class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <span>{{ campus.contact.officeHours }}</span>
                            </p>
                        </div>
                    </article>
                </aside>
            </div>
        </section>

        <section class="bg-white py-16 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Facilities
                        </p>
                        <h3
                            class="mt-2 text-xl font-semibold text-slate-950 dark:text-white"
                        >
                            Spaces across the campus
                        </h3>
                    </div>
                    <span
                        class="shrink-0 text-sm font-medium text-slate-500 dark:text-slate-400"
                    >
                        {{ campus.facilityGallery.length }} photos
                    </span>
                </div>

                <div
                    v-if="campus.facilityGallery.length"
                    class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-flow-dense lg:auto-rows-[15rem] lg:grid-cols-6"
                >
                    <figure
                        v-for="facility in campus.facilityGallery"
                        :key="facility.image"
                        class="group relative min-h-64 overflow-hidden rounded-md border border-slate-200 bg-slate-100 shadow-sm shadow-slate-900/5 lg:min-h-0 dark:border-white/10 dark:bg-slate-800"
                        :class="[
                            facility.featured
                                ? 'sm:col-span-2 lg:col-span-4 lg:row-span-2'
                                : facility.wide
                                  ? 'sm:col-span-2 lg:col-span-2 lg:row-span-2'
                                  : 'lg:col-span-2',
                        ]"
                    >
                        <img
                            :src="facility.image"
                            :alt="facility.alt"
                            loading="lazy"
                            decoding="async"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                        />
                        <figcaption
                            v-if="
                                facility.title ||
                                facility.description ||
                                facility.category
                            "
                            class="absolute inset-x-0 bottom-0 bg-linear-to-t from-slate-950/90 via-slate-950/65 to-transparent px-5 pt-16 pb-5 text-white"
                        >
                            <p
                                v-if="facility.category"
                                class="text-xs font-semibold tracking-wide text-[#f2b705] uppercase"
                            >
                                {{ facility.category }}
                            </p>
                            <h4
                                v-if="facility.title"
                                class="mt-1 font-semibold"
                            >
                                {{ facility.title }}
                            </h4>
                            <p
                                v-if="facility.description"
                                class="mt-1 max-w-lg text-sm leading-6 text-sky-100"
                            >
                                {{ facility.description }}
                            </p>
                        </figcaption>
                    </figure>
                </div>
                <div
                    v-else
                    class="mt-6 rounded-md border border-dashed border-slate-300 px-6 py-12 text-center text-sm text-slate-500 dark:border-white/15 dark:text-slate-400"
                >
                    Facility photos will be added soon.
                </div>
            </div>
        </section>

        <section
            class="bg-[linear-gradient(145deg,#f7f8f5_0%,#ffffff_55%,#edf7f8_100%)] py-16 dark:bg-slate-950"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end"
                >
                    <div class="max-w-2xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Program Offerings
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Academic pathways available at the campus
                        </h2>
                        <p
                            class="mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            Select a program with an available prospectus to
                            review its curriculum in a new tab.
                        </p>
                    </div>
                    <div
                        class="inline-flex w-fit items-center gap-2 rounded-md border border-[#0b6680]/15 bg-white/80 px-3 py-2 text-xs font-semibold text-[#0b6680] shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:text-sky-200"
                    >
                        <FileText class="size-4" aria-hidden="true" />
                        Prospectus available
                    </div>
                </div>

                <div class="mt-10 columns-1 gap-5 md:columns-2">
                    <article
                        v-for="group in campus.programs"
                        :key="group.college"
                        class="relative mb-5 break-inside-avoid-column overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                        :class="
                            group.offerings.length > 10
                                ? 'border-[#1711d4]/25 ring-1 ring-[#1711d4]/10 dark:border-sky-300/20 dark:ring-sky-300/10'
                                : ''
                        "
                    >
                        <div
                            class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-[#1711d4] via-[#0b6680] to-[#f2b705]"
                        ></div>
                        <div
                            class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 pt-6 pb-5 dark:border-white/10"
                        >
                            <div class="flex min-w-0 items-start gap-3">
                                <span
                                    class="inline-flex size-10 shrink-0 items-center justify-center rounded-md bg-[#e6f3f5] text-[#1711d4] ring-1 ring-[#0b6680]/10 dark:bg-sky-400/10 dark:text-sky-200 dark:ring-white/10"
                                >
                                    <GraduationCap
                                        class="size-5"
                                        aria-hidden="true"
                                    />
                                </span>
                                <div>
                                    <p
                                        class="text-[0.65rem] font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                    >
                                        Academic Unit
                                    </p>
                                    <h3
                                        class="mt-1 text-base leading-6 font-semibold text-slate-950 dark:text-white"
                                    >
                                        {{ group.college }}
                                    </h3>
                                </div>
                            </div>
                            <span
                                class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-white/10 dark:text-slate-300"
                            >
                                {{ group.offerings.length }}
                                {{
                                    group.offerings.length === 1
                                        ? 'program'
                                        : 'programs'
                                }}
                            </span>
                        </div>
                        <ul
                            class="grid gap-2 p-4 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            <li
                                v-for="offering in group.offerings"
                                :key="offering"
                                class="group/offering"
                            >
                                <a
                                    v-if="campus.prospectuses[offering]"
                                    :href="campus.prospectuses[offering]"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex min-w-0 items-center gap-3 rounded-md border border-[#0b6680]/10 bg-[#f4fafb] px-3 py-2.5 font-medium text-slate-800 transition duration-200 hover:-translate-y-0.5 hover:border-[#0b6680]/30 hover:bg-[#e6f3f5] hover:text-[#0b6680] hover:shadow-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1711d4] dark:border-white/10 dark:bg-white/[0.04] dark:text-sky-100 dark:hover:border-sky-300/30 dark:hover:bg-white/10"
                                    :aria-label="`View ${offering} prospectus in a new tab`"
                                >
                                    <span
                                        class="inline-flex size-8 shrink-0 items-center justify-center rounded bg-white text-[#0b6680] shadow-sm ring-1 ring-[#0b6680]/10 dark:bg-white/10 dark:text-sky-200 dark:ring-white/10"
                                    >
                                        <FileText
                                            class="size-4"
                                            aria-hidden="true"
                                        />
                                    </span>
                                    <span class="min-w-0 flex-1">{{
                                        offering
                                    }}</span>
                                    <span
                                        class="hidden shrink-0 items-center gap-1 rounded-full bg-white px-2.5 py-1 text-[0.6rem] font-semibold tracking-wide text-[#9b1c31] uppercase shadow-sm ring-1 ring-[#9b1c31]/10 transition group-hover/offering:bg-[#9b1c31] group-hover/offering:text-white sm:inline-flex dark:bg-white/10 dark:text-rose-200 dark:ring-white/10"
                                    >
                                        Prospectus PDF
                                        <ExternalLink
                                            class="size-3"
                                            aria-hidden="true"
                                        />
                                    </span>
                                    <ExternalLink
                                        class="size-3.5 shrink-0 text-[#9b1c31] sm:hidden dark:text-rose-300"
                                        aria-hidden="true"
                                    />
                                </a>
                                <span
                                    v-else
                                    class="flex items-start gap-3 rounded-md px-3 py-2 text-slate-600 dark:text-slate-300"
                                >
                                    <span
                                        class="mt-2.5 size-1.5 shrink-0 rounded-full bg-[#9b1c31]/70"
                                    ></span>
                                    <span>{{ offering }}</span>
                                </span>
                            </li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-white py-16 dark:bg-slate-900">
            <div
                class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8"
            >
                <div>
                    <HeartHandshake
                        class="size-7 text-[#9b1c31] dark:text-rose-300"
                        aria-hidden="true"
                    />
                    <p
                        class="mt-5 text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        Campus Life
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        Student experiences beyond the classroom
                    </h2>
                </div>

                <ul class="grid gap-3 sm:grid-cols-2">
                    <li
                        v-for="item in campus.campusLife"
                        :key="item"
                        class="flex gap-3 rounded-md border border-slate-200 p-5 text-sm leading-6 text-slate-700 dark:border-white/10 dark:text-slate-200"
                    >
                        <BadgeCheck
                            class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                            aria-hidden="true"
                        />
                        {{ item }}
                    </li>
                </ul>
            </div>
        </section>

        <section class="bg-[#061b49] py-16 text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <ShieldCheck
                        class="size-7 text-emerald-300"
                        aria-hidden="true"
                    />
                    <p
                        class="mt-5 text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                    >
                        Services
                    </p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                        Campus support and student service points
                    </h2>
                </div>

                <div
                    v-if="campus.serviceHighlights?.length"
                    class="mt-8 grid gap-5 md:grid-cols-2"
                >
                    <article
                        v-for="service in campus.serviceHighlights ?? []"
                        :key="service.title"
                        class="overflow-hidden rounded-lg border border-white/10 bg-white/[0.07] shadow-lg shadow-black/10"
                    >
                        <div
                            class="grid h-56 grid-cols-[minmax(0,1.55fr)_minmax(5rem,0.7fr)] gap-1 bg-slate-950/40"
                        >
                            <img
                                :src="service.images[0].image"
                                :alt="service.images[0].alt"
                                class="h-full w-full object-cover"
                            />
                            <div class="grid min-h-0 gap-1">
                                <img
                                    v-for="image in service.images.slice(1)"
                                    :key="image.image"
                                    :src="image.image"
                                    :alt="image.alt"
                                    class="h-full min-h-0 w-full object-cover"
                                />
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-3">
                                <span
                                    class="grid size-9 shrink-0 place-items-center rounded-md bg-emerald-300/15 text-emerald-300"
                                >
                                    <ShieldCheck
                                        class="size-5"
                                        aria-hidden="true"
                                    />
                                </span>
                                <h3 class="text-lg font-semibold">
                                    {{ service.title }}
                                </h3>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-sky-100">
                                {{ service.description }}
                            </p>
                        </div>
                    </article>
                </div>

                <ul
                    v-else
                    class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <li
                        v-for="service in campus.services"
                        :key="service"
                        class="flex gap-3 rounded-md border border-white/10 bg-white/[0.06] p-5 text-sm leading-6 text-sky-100"
                    >
                        <ShieldCheck
                            class="mt-1 size-4 shrink-0 text-emerald-300"
                            aria-hidden="true"
                        />
                        {{ service }}
                    </li>
                </ul>
            </div>
        </section>

        <section class="bg-white py-16 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
                    <div>
                        <Sparkles
                            class="size-7 text-[#1711d4] dark:text-sky-200"
                            aria-hidden="true"
                        />
                        <p
                            class="mt-5 text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            University Student Government
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            {{ campus.studentGovernment.name }}
                        </h2>
                        <p
                            class="mt-4 text-sm font-semibold text-[#0b6680] dark:text-sky-300"
                        >
                            {{ campus.studentGovernment.focus }}
                        </p>
                    </div>

                    <ul class="grid gap-3">
                        <li
                            v-for="initiative in campus.studentGovernment
                                .initiatives"
                            :key="initiative"
                            class="flex items-center gap-4 rounded-md border border-slate-200 p-5 text-sm font-medium text-slate-700 dark:border-white/10 dark:text-slate-200"
                        >
                            <Sparkles
                                class="size-4 shrink-0 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            {{ initiative }}
                        </li>
                    </ul>
                </div>

                <div
                    v-if="campus.studentGovernment.activities.length"
                    class="mt-12 grid gap-6 lg:grid-cols-2"
                >
                    <article
                        v-for="activity in campus.studentGovernment.activities"
                        :key="activity.title"
                        class="overflow-hidden rounded-lg border border-slate-200 bg-[#f7f8f5] dark:border-white/10 dark:bg-white/5"
                    >
                        <div
                            v-if="activity.images.length"
                            class="grid grid-cols-2 gap-1 bg-slate-200 dark:bg-slate-800"
                        >
                            <img
                                v-for="image in activity.images"
                                :key="image.image"
                                :src="image.image"
                                :alt="image.alt"
                                class="aspect-4/3 size-full object-cover"
                                loading="lazy"
                            />
                        </div>
                        <div class="p-6">
                            <p
                                class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                {{ activity.date }}
                            </p>
                            <h3
                                class="mt-2 text-xl font-semibold text-slate-950 dark:text-white"
                            >
                                {{ activity.title }}
                            </h3>
                            <p
                                class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300"
                            >
                                {{ activity.description }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Updates
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Latest campus notices
                        </h2>
                    </div>
                    <Link
                        :href="home().url + '#campuses'"
                        class="inline-flex min-h-11 items-center gap-2 rounded-md border border-slate-300 bg-white px-4 text-sm font-semibold text-[#1711d4] transition hover:border-[#1711d4]/40 hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:text-sky-100"
                    >
                        All campuses
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </Link>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <article
                        v-for="update in campus.updates"
                        :key="update.title"
                        class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <p
                            class="inline-flex items-center gap-2 text-xs font-semibold text-[#0b6680] dark:text-sky-300"
                        >
                            <CalendarDays class="size-3.5" aria-hidden="true" />
                            {{ update.date }}
                        </p>
                        <h3
                            class="mt-4 font-semibold text-slate-950 dark:text-white"
                        >
                            {{ update.title }}
                        </h3>
                        <p
                            class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            {{ update.summary }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-white py-12 dark:bg-slate-900">
            <div
                class="mx-auto flex max-w-7xl gap-3 overflow-x-auto px-4 sm:px-6 lg:px-8"
                aria-label="Other campuses"
            >
                <Link
                    v-for="item in campuses"
                    :key="item.slug"
                    :href="campusShow(item.slug)"
                    class="inline-flex min-h-11 shrink-0 items-center rounded-md border px-4 text-sm font-semibold transition"
                    :class="
                        item.slug === campus.slug
                            ? 'border-[#1711d4] bg-[#1711d4] text-white'
                            : 'border-slate-200 text-slate-700 hover:border-[#1711d4]/40 hover:text-[#1711d4] dark:border-white/10 dark:text-slate-200 dark:hover:text-sky-200'
                    "
                >
                    {{ item.name }}
                </Link>
            </div>
        </section>
    </PublicSiteLayout>
</template>
