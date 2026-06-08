<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BadgeCheck,
    CalendarDays,
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
    campusLife: string[];
    services: string[];
    studentGovernment: {
        name: string;
        adviser: string;
        focus: string;
        initiatives: string[];
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

        <section class="relative isolate overflow-hidden bg-slate-950 text-white">
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

        <section class="border-b border-slate-200 bg-white dark:border-white/10 dark:bg-slate-950">
            <div
                class="mx-auto grid max-w-7xl gap-4 px-4 py-6 sm:px-6 md:grid-cols-4 lg:px-8"
            >
                <article
                    v-for="stat in campus.stats"
                    :key="stat.label"
                    class="rounded-md border border-slate-200 p-5 dark:border-white/10"
                >
                    <p class="text-3xl font-semibold text-[#1711d4] dark:text-sky-200">
                        {{ stat.value }}
                    </p>
                    <h2 class="mt-2 text-sm font-semibold text-slate-950 dark:text-white">
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
                        class="mt-3 max-w-3xl text-3xl leading-tight font-semibold tracking-normal text-slate-950 dark:text-white sm:text-4xl"
                    >
                        {{ campus.profile.headline }}
                    </h2>
                    <p
                        class="mt-6 whitespace-pre-line text-base leading-8 text-slate-600 dark:text-slate-300"
                    >
                        {{ campus.profile.overview }}
                    </p>
                </article>

                <aside class="grid gap-4 lg:sticky lg:top-24">
                    <article
                        class="relative overflow-hidden rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div class="absolute inset-x-0 top-0 h-1 bg-[#1711d4]"></div>
                        <div class="flex items-center gap-4">
                            <span
                                class="inline-flex size-12 shrink-0 items-center justify-center rounded-md bg-[#e6f3f5] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <UsersRound class="size-5" aria-hidden="true" />
                            </span>
                            <div>
                                <p class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300">
                                    Campus Director
                                </p>
                                <h3 class="mt-2 font-semibold text-slate-950 dark:text-white">
                                    {{ campus.director.name }}
                                </h3>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
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
                                <Mail class="size-4 shrink-0" aria-hidden="true" />
                                {{ campus.director.email }}
                            </a>
                            <a
                                :href="`tel:${campus.director.phone}`"
                                class="inline-flex min-h-10 items-center gap-3 rounded-md px-3 transition hover:bg-[#e6f3f5] hover:text-[#1711d4] dark:hover:bg-white/10 dark:hover:text-sky-200"
                            >
                                <Phone class="size-4 shrink-0" aria-hidden="true" />
                                {{ campus.director.phone }}
                            </a>
                        </div>
                    </article>

                    <article
                        class="relative overflow-hidden rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div class="absolute inset-x-0 top-0 h-1 bg-[#f2b705]"></div>
                        <div class="flex items-center gap-4">
                            <span
                                class="inline-flex size-12 shrink-0 items-center justify-center rounded-md bg-[#fff4cc] text-[#795200] dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                            >
                                <MapPin class="size-5" aria-hidden="true" />
                            </span>
                            <div>
                                <p class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300">
                                    Visit the Campus
                                </p>
                                <h3 class="mt-2 font-semibold text-slate-950 dark:text-white">
                                    Contact Details
                                </h3>
                            </div>
                        </div>
                        <div
                            class="mt-6 grid gap-4 border-t border-slate-200 pt-5 text-sm leading-6 text-slate-600 dark:border-white/10 dark:text-slate-300"
                        >
                            <p class="flex gap-3">
                                <MapPin class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300" aria-hidden="true" />
                                <span>{{ campus.contact.address }}</span>
                            </p>
                            <a
                                :href="`mailto:${campus.contact.email}`"
                                class="flex gap-3 transition hover:text-[#1711d4] dark:hover:text-sky-200"
                            >
                                <Mail class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300" aria-hidden="true" />
                                <span>{{ campus.contact.email }}</span>
                            </a>
                            <a
                                :href="`tel:${campus.contact.phone}`"
                                class="flex gap-3 transition hover:text-[#1711d4] dark:hover:text-sky-200"
                            >
                                <Phone class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300" aria-hidden="true" />
                                <span>{{ campus.contact.phone }}</span>
                            </a>
                            <p class="flex gap-3">
                                <CalendarDays class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300" aria-hidden="true" />
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
                        <h3 class="mt-2 text-xl font-semibold text-slate-950 dark:text-white">
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
                    class="mt-6 grid gap-4 sm:grid-cols-2 lg:auto-rows-[15rem] lg:grid-flow-dense lg:grid-cols-6"
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
                            v-if="facility.title || facility.description || facility.category"
                            class="absolute inset-x-0 bottom-0 bg-linear-to-t from-slate-950/90 via-slate-950/65 to-transparent px-5 pt-16 pb-5 text-white"
                        >
                            <p
                                v-if="facility.category"
                                class="text-xs font-semibold tracking-wide text-[#f2b705] uppercase"
                            >
                                {{ facility.category }}
                            </p>
                            <h4 v-if="facility.title" class="mt-1 font-semibold">
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

        <section class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        Program Offerings
                    </p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
                        Academic pathways available at the campus
                    </h2>
                </div>

                <div class="mt-8 columns-1 gap-4 md:columns-2">
                    <article
                        v-for="group in campus.programs"
                        :key="group.college"
                        class="mb-4 break-inside-avoid-column rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                        :class="
                            group.offerings.length > 10
                                ? 'border-[#1711d4]/25 ring-1 ring-[#1711d4]/10 dark:border-sky-300/20 dark:ring-sky-300/10'
                                : ''
                        "
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex min-w-0 items-start gap-3">
                                <span
                                    class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-md bg-[#e6f3f5] text-[#1711d4] dark:bg-sky-400/10 dark:text-sky-200"
                                >
                                    <GraduationCap class="size-4" aria-hidden="true" />
                                </span>
                                <h3 class="text-base leading-6 font-semibold text-slate-950 dark:text-white">
                                    {{ group.college }}
                                </h3>
                            </div>
                            <span
                                class="shrink-0 rounded bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 dark:bg-white/10 dark:text-slate-300"
                            >
                                {{ group.offerings.length }}
                                {{ group.offerings.length === 1 ? 'program' : 'programs' }}
                            </span>
                        </div>
                        <ul class="mt-5 grid gap-2.5 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            <li
                                v-for="offering in group.offerings"
                                :key="offering"
                                class="flex gap-3"
                            >
                                <span class="mt-2.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#9b1c31]"></span>
                                {{ offering }}
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
                    <HeartHandshake class="size-7 text-[#9b1c31] dark:text-rose-300" aria-hidden="true" />
                    <p
                        class="mt-5 text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        Campus Life
                    </p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
                        Student experiences beyond the classroom
                    </h2>
                </div>

                <ul class="grid gap-3 sm:grid-cols-2">
                    <li
                        v-for="item in campus.campusLife"
                        :key="item"
                        class="flex gap-3 rounded-md border border-slate-200 p-5 text-sm leading-6 text-slate-700 dark:border-white/10 dark:text-slate-200"
                    >
                        <BadgeCheck class="mt-1 size-4 shrink-0 text-[#0b6680] dark:text-sky-300" aria-hidden="true" />
                        {{ item }}
                    </li>
                </ul>
            </div>
        </section>

        <section class="bg-[#061b49] py-16 text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <ShieldCheck class="size-7 text-emerald-300" aria-hidden="true" />
                    <p class="mt-5 text-sm font-semibold tracking-wide text-[#f2b705] uppercase">
                        Services
                    </p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                        Campus support and student service points
                    </h2>
                </div>

                <ul class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <li
                        v-for="service in campus.services"
                        :key="service"
                        class="flex gap-3 rounded-md border border-white/10 bg-white/[0.06] p-5 text-sm leading-6 text-sky-100"
                    >
                        <ShieldCheck class="mt-1 size-4 shrink-0 text-emerald-300" aria-hidden="true" />
                        {{ service }}
                    </li>
                </ul>
            </div>
        </section>

        <section class="bg-white py-16 dark:bg-slate-900">
            <div
                class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8"
            >
                <div>
                    <Sparkles class="size-7 text-[#1711d4] dark:text-sky-200" aria-hidden="true" />
                    <p
                        class="mt-5 text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        University Student Government
                    </p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
                        {{ campus.studentGovernment.name }}
                    </h2>
                    <p class="mt-4 text-sm font-semibold text-[#0b6680] dark:text-sky-300">
                        {{ campus.studentGovernment.focus }}
                    </p>
                </div>

                <ul class="grid gap-3">
                    <li
                        v-for="initiative in campus.studentGovernment.initiatives"
                        :key="initiative"
                        class="flex items-center gap-4 rounded-md border border-slate-200 p-5 text-sm font-medium text-slate-700 dark:border-white/10 dark:text-slate-200"
                    >
                        <Sparkles class="size-4 shrink-0 text-[#f2b705]" aria-hidden="true" />
                        {{ initiative }}
                    </li>
                </ul>
            </div>
        </section>

        <section class="bg-[#f7f8f5] py-16 dark:bg-slate-950">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Updates
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
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
                        <p class="inline-flex items-center gap-2 text-xs font-semibold text-[#0b6680] dark:text-sky-300">
                            <CalendarDays class="size-3.5" aria-hidden="true" />
                            {{ update.date }}
                        </p>
                        <h3 class="mt-4 font-semibold text-slate-950 dark:text-white">
                            {{ update.title }}
                        </h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
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
