<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BadgeCheck,
    Building2,
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
                class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8"
            >
                <div>
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        Profile of the Campus
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                    >
                        {{ campus.profile.headline }}
                    </h2>
                    <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                        {{ campus.profile.overview }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <article
                        class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div class="flex items-start gap-4">
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
                        <div class="mt-5 grid gap-2 text-sm text-slate-600 dark:text-slate-300">
                            <a :href="`mailto:${campus.director.email}`" class="inline-flex items-center gap-2 hover:text-[#1711d4] dark:hover:text-sky-200">
                                <Mail class="size-4" aria-hidden="true" />
                                {{ campus.director.email }}
                            </a>
                            <a :href="`tel:${campus.director.phone}`" class="inline-flex items-center gap-2 hover:text-[#1711d4] dark:hover:text-sky-200">
                                <Phone class="size-4" aria-hidden="true" />
                                {{ campus.director.phone }}
                            </a>
                        </div>
                    </article>

                    <article
                        class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <span
                            class="inline-flex size-12 items-center justify-center rounded-md bg-[#fff4cc] text-[#795200] dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                        >
                            <MapPin class="size-5" aria-hidden="true" />
                        </span>
                        <h3 class="mt-5 font-semibold text-slate-950 dark:text-white">
                            Contact Details
                        </h3>
                        <div class="mt-4 grid gap-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            <p>{{ campus.contact.address }}</p>
                            <p>{{ campus.contact.email }}</p>
                            <p>{{ campus.contact.phone }}</p>
                            <p>{{ campus.contact.officeHours }}</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-white py-16 dark:bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Facilities
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
                            Learning spaces and service points
                        </h2>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div
                            v-for="facility in campus.facilities"
                            :key="facility"
                            class="flex items-center gap-3 rounded-md border border-slate-200 p-4 text-sm font-medium text-slate-700 dark:border-white/10 dark:text-slate-200"
                        >
                            <Building2 class="size-4 shrink-0 text-[#0b6680] dark:text-sky-300" aria-hidden="true" />
                            {{ facility }}
                        </div>
                    </div>
                </div>

                <div class="mt-14 grid gap-4 md:grid-cols-2">
                    <article
                        v-for="group in campus.programs"
                        :key="group.college"
                        class="rounded-md border border-slate-200 bg-[#f7f8f5] p-6 dark:border-white/10 dark:bg-white/5"
                    >
                        <div class="flex items-center gap-3">
                            <GraduationCap class="size-6 text-[#1711d4] dark:text-sky-200" aria-hidden="true" />
                            <h3 class="font-semibold text-slate-950 dark:text-white">
                                {{ group.college }}
                            </h3>
                        </div>
                        <ul class="mt-5 grid gap-3 text-sm text-slate-600 dark:text-slate-300">
                            <li
                                v-for="offering in group.offerings"
                                :key="offering"
                                class="flex gap-3"
                            >
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#9b1c31]"></span>
                                {{ offering }}
                            </li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-[#061b49] py-16 text-white">
            <div
                class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-3 lg:px-8"
            >
                <article class="rounded-md border border-white/10 bg-white/[0.06] p-6">
                    <HeartHandshake class="size-7 text-[#f2b705]" aria-hidden="true" />
                    <h2 class="mt-5 text-xl font-semibold">Campus Life</h2>
                    <ul class="mt-5 grid gap-3 text-sm leading-6 text-sky-100">
                        <li v-for="item in campus.campusLife" :key="item">
                            {{ item }}
                        </li>
                    </ul>
                </article>

                <article class="rounded-md border border-white/10 bg-white/[0.06] p-6">
                    <ShieldCheck class="size-7 text-emerald-300" aria-hidden="true" />
                    <h2 class="mt-5 text-xl font-semibold">Services</h2>
                    <ul class="mt-5 grid gap-3 text-sm leading-6 text-sky-100">
                        <li v-for="service in campus.services" :key="service">
                            {{ service }}
                        </li>
                    </ul>
                </article>

                <article class="rounded-md border border-white/10 bg-white/[0.06] p-6">
                    <Sparkles class="size-7 text-rose-200" aria-hidden="true" />
                    <h2 class="mt-5 text-xl font-semibold">
                        University Student Government
                    </h2>
                    <p class="mt-3 text-sm leading-6 text-sky-100">
                        {{ campus.studentGovernment.name }}
                    </p>
                    <p class="mt-2 text-xs font-semibold tracking-wide text-[#f2b705] uppercase">
                        {{ campus.studentGovernment.focus }}
                    </p>
                    <ul class="mt-5 grid gap-3 text-sm leading-6 text-sky-100">
                        <li
                            v-for="initiative in campus.studentGovernment.initiatives"
                            :key="initiative"
                        >
                            {{ initiative }}
                        </li>
                    </ul>
                </article>
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
