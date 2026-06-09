<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    BadgeCheck,
    BookOpenText,
    Building2,
    CalendarDays,
    GraduationCap,
    Mail,
    MapPin,
    Phone,
    ScrollText,
    Sparkles,
    Target,
} from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';

type Office = {
    name: string;
    head: string;
    email: string;
    contact: string;
    description: string;
};

type ProgramUpdate = {
    date: string;
    title: string;
    summary: string;
};

type CollegeProgram = {
    name: string;
    prospectus: string;
    objectives: string[];
    learningOutcomes: string[];
    updates: ProgramUpdate[];
};

type ProgramGroup = {
    slug: string;
    title: string;
    category: string;
    overview: string;
    colleges: CollegeProgram[];
};

type AcademicAffairs = {
    profile: {
        title: string;
        subtitle: string;
        summary: string;
        unitHead: string;
        role: string;
        email: string;
        phone: string;
        office: string;
        image: string;
        priorities: string[];
    };
    offices: Office[];
    programGroups: ProgramGroup[];
};

const props = defineProps<{
    academicAffairs: AcademicAffairs;
}>();

const pageAnchors = [
    { label: 'OVPAA Profile', href: '#ovpaa-profile' },
    { label: 'Offices under OVPAA', href: '#ovpaa-offices' },
    ...props.academicAffairs.programGroups.map((group) => ({
        label: group.title,
        href: `#${group.slug}`,
    })),
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="Academic Affairs" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section class="relative isolate overflow-hidden bg-slate-950 text-white">
                <img
                    :src="academicAffairs.profile.image"
                    alt=""
                    class="absolute inset-0 -z-20 h-full w-full object-cover"
                    aria-hidden="true"
                />
                <div
                    class="absolute inset-0 -z-10 bg-linear-to-r from-[#061b49] via-[#1711d4]/85 to-[#9b1c31]/70"
                ></div>

                <div
                    class="mx-auto grid min-h-[34rem] max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1fr_24rem] lg:px-8 lg:py-20"
                >
                    <div class="flex flex-col justify-end">
                        <p
                            class="inline-flex w-fit rounded bg-white/10 px-3 py-1.5 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                        >
                            {{ academicAffairs.profile.subtitle }}
                        </p>
                        <h1
                            class="mt-5 max-w-4xl text-4xl leading-tight font-semibold tracking-normal sm:text-6xl"
                        >
                            {{ academicAffairs.profile.title }}
                        </h1>
                        <p class="mt-6 max-w-2xl text-base leading-8 text-sky-50">
                            {{ academicAffairs.profile.summary }}
                        </p>
                    </div>

                    <nav
                        class="self-end rounded-md border border-white/15 bg-white/10 p-3 backdrop-blur"
                        aria-label="Academic affairs sections"
                    >
                        <a
                            v-for="anchor in pageAnchors"
                            :key="anchor.href"
                            :href="anchor.href"
                            class="flex min-h-11 items-center rounded-md px-4 text-sm font-semibold text-white/90 transition hover:bg-white hover:text-[#1711d4]"
                        >
                            {{ anchor.label }}
                        </a>
                    </nav>
                </div>
            </section>

            <section
                id="ovpaa-profile"
                class="scroll-mt-28 border-b border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-950"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            OVPAA Profile
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Academic leadership and coordination
                        </h2>
                        <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            {{ academicAffairs.profile.summary }}
                        </p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <article
                            class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <span
                                class="inline-flex size-12 items-center justify-center rounded-md bg-[#e7f3fb] text-[#1711d4] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <GraduationCap class="size-5" aria-hidden="true" />
                            </span>
                            <p
                                class="mt-5 text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                Unit Head
                            </p>
                            <h3 class="mt-2 text-lg font-semibold text-slate-950 dark:text-white">
                                {{ academicAffairs.profile.unitHead }}
                            </h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                {{ academicAffairs.profile.role }}
                            </p>
                        </article>

                        <article
                            class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <span
                                class="inline-flex size-12 items-center justify-center rounded-md bg-[#fff4cc] text-[#795200] dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                            >
                                <MapPin class="size-5" aria-hidden="true" />
                            </span>
                            <p
                                class="mt-5 text-xs font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                            >
                                Contact Details
                            </p>
                            <div class="mt-3 grid gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <a
                                    :href="`mailto:${academicAffairs.profile.email}`"
                                    class="inline-flex items-center gap-2 hover:text-[#1711d4] dark:hover:text-sky-200"
                                >
                                    <Mail class="size-4" aria-hidden="true" />
                                    {{ academicAffairs.profile.email }}
                                </a>
                                <a
                                    :href="`tel:${academicAffairs.profile.phone}`"
                                    class="inline-flex items-center gap-2 hover:text-[#1711d4] dark:hover:text-sky-200"
                                >
                                    <Phone class="size-4" aria-hidden="true" />
                                    {{ academicAffairs.profile.phone }}
                                </a>
                                <span>{{ academicAffairs.profile.office }}</span>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <div
                            v-for="priority in academicAffairs.profile.priorities"
                            :key="priority"
                            class="flex gap-3 rounded-md border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700 dark:border-white/10 dark:bg-white/[0.04] dark:text-slate-200"
                        >
                            <BadgeCheck
                                class="mt-0.5 size-4 shrink-0 text-[#0b6680] dark:text-sky-300"
                                aria-hidden="true"
                            />
                            {{ priority }}
                        </div>
                    </div>
                </div>
            </section>

            <section id="ovpaa-offices" class="scroll-mt-28 bg-white py-14 sm:py-16 dark:bg-slate-900">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Offices under OVPAA
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Academic service offices
                        </h2>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-3">
                        <article
                            v-for="office in academicAffairs.offices"
                            :key="office.name"
                            class="rounded-md border border-slate-200 bg-[#f7f8f5] p-6 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <Building2 class="size-7 text-[#1711d4] dark:text-sky-200" aria-hidden="true" />
                            <h3 class="mt-5 font-semibold text-slate-950 dark:text-white">
                                {{ office.name }}
                            </h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                {{ office.description }}
                            </p>
                            <div class="mt-5 grid gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <p class="font-semibold text-slate-900 dark:text-white">
                                    {{ office.head }}
                                </p>
                                <a :href="`mailto:${office.email}`" class="hover:text-[#1711d4] dark:hover:text-sky-200">
                                    {{ office.email }}
                                </a>
                                <a :href="`tel:${office.contact}`" class="hover:text-[#1711d4] dark:hover:text-sky-200">
                                    {{ office.contact }}
                                </a>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="bg-[#061b49] py-14 text-white sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase">
                            Program Offerings
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal text-white">
                            Prospectus, objectives, learning outcomes, and college updates
                        </h2>
                    </div>
                </div>
            </section>

            <section
                v-for="group in academicAffairs.programGroups"
                :id="group.slug"
                :key="group.slug"
                class="scroll-mt-28 border-b border-slate-200 bg-white py-14 sm:py-16 dark:border-white/10 dark:bg-slate-950"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-6 lg:grid-cols-[18rem_1fr]">
                        <aside>
                            <p
                                class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                {{ group.category }}
                            </p>
                            <h2
                                class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                {{ group.title }}
                            </h2>
                            <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                {{ group.overview }}
                            </p>
                        </aside>

                        <div class="grid gap-5">
                            <article
                                v-for="college in group.colleges"
                                :key="college.name"
                                class="rounded-md border border-slate-200 bg-[#f7f8f5] p-5 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                            >
                                <div
                                    class="flex flex-col justify-between gap-3 border-b border-slate-200 pb-5 sm:flex-row sm:items-start dark:border-white/10"
                                >
                                    <div>
                                        <h3 class="text-xl font-semibold text-slate-950 dark:text-white">
                                            {{ college.name }}
                                        </h3>
                                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                            News and Updates of the College
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex w-fit items-center gap-2 rounded bg-white px-3 py-2 text-xs font-semibold text-[#1711d4] ring-1 ring-slate-200 dark:bg-white/10 dark:text-sky-200 dark:ring-white/10"
                                    >
                                        <Sparkles class="size-3.5" aria-hidden="true" />
                                        Dummy data
                                    </span>
                                </div>

                                <div class="mt-6 grid gap-5 xl:grid-cols-2">
                                    <section class="rounded-md bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-950/40 dark:ring-white/10">
                                        <div class="flex items-center gap-3">
                                            <ScrollText class="size-5 text-[#0b6680] dark:text-sky-300" aria-hidden="true" />
                                            <h4 class="font-semibold text-slate-950 dark:text-white">
                                                Prospectus
                                            </h4>
                                        </div>
                                        <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                            {{ college.prospectus }}
                                        </p>
                                    </section>

                                    <section class="rounded-md bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-950/40 dark:ring-white/10">
                                        <div class="flex items-center gap-3">
                                            <Target class="size-5 text-[#9b1c31] dark:text-rose-300" aria-hidden="true" />
                                            <h4 class="font-semibold text-slate-950 dark:text-white">
                                                Program Objectives
                                            </h4>
                                        </div>
                                        <ul class="mt-3 grid gap-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                            <li
                                                v-for="objective in college.objectives"
                                                :key="objective"
                                                class="flex gap-3"
                                            >
                                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#9b1c31]"></span>
                                                {{ objective }}
                                            </li>
                                        </ul>
                                    </section>

                                    <section class="rounded-md bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-950/40 dark:ring-white/10">
                                        <div class="flex items-center gap-3">
                                            <BookOpenText class="size-5 text-[#1711d4] dark:text-sky-200" aria-hidden="true" />
                                            <h4 class="font-semibold text-slate-950 dark:text-white">
                                                Program Learning Outcomes
                                            </h4>
                                        </div>
                                        <ul class="mt-3 grid gap-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                            <li
                                                v-for="outcome in college.learningOutcomes"
                                                :key="outcome"
                                                class="flex gap-3"
                                            >
                                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#1711d4]"></span>
                                                {{ outcome }}
                                            </li>
                                        </ul>
                                    </section>

                                    <section class="rounded-md bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-950/40 dark:ring-white/10">
                                        <div class="flex items-center gap-3">
                                            <CalendarDays class="size-5 text-[#795200] dark:text-[#f2b705]" aria-hidden="true" />
                                            <h4 class="font-semibold text-slate-950 dark:text-white">
                                                News and Updates of the College
                                            </h4>
                                        </div>
                                        <div class="mt-3 grid gap-3">
                                            <article
                                                v-for="update in college.updates"
                                                :key="update.title"
                                                class="border-l-2 border-[#f2b705] pl-3"
                                            >
                                                <p class="text-xs font-semibold text-[#0b6680] dark:text-sky-300">
                                                    {{ update.date }}
                                                </p>
                                                <h5 class="mt-1 text-sm font-semibold text-slate-950 dark:text-white">
                                                    {{ update.title }}
                                                </h5>
                                                <p class="mt-1 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                                    {{ update.summary }}
                                                </p>
                                            </article>
                                        </div>
                                    </section>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
