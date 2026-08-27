<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Mail, MapPin, Phone } from 'lucide-vue-next';
import { show as studyShow } from '@/actions/App/Http/Controllers/GraduateProfessionalStudyController';
import { show as officeShow } from '@/actions/App/Http/Controllers/OvpaaOfficeController';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { show as collegeShow } from '@/routes/academics/academic-affairs/colleges';

type Office = {
    slug: string;
    name: string;
    headTitle: string;
    head: string;
    email: string | null;
    contact: string | null;
    description: string;
};

type CollegeLink = {
    slug: string;
    title: string;
};

type GraduateProfessionalStudyLink = {
    slug: string;
    title: string;
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
        description: string[];
        unitHead: string;
        role: string;
        biography: string[];
        email: string;
        phone: string;
        office: string;
        heroImage: string;
        image: string;
        priorities: string[];
    };
    offices: Office[];
    colleges: CollegeLink[];
    graduateProfessionalStudies: GraduateProfessionalStudyLink[];
    programGroups: ProgramGroup[];
};

const academicProgramSections = [
    {
        slug: 'undergraduate-programs',
        title: 'Undergraduate Programs',
        items: [],
    },
    {
        slug: 'graduate-and-professional-studies',
        title: 'Graduate and Professional Studies',
        items: [],
    },
];

defineProps<{
    academicAffairs: AcademicAffairs;
}>();
</script>

<template>
    <PublicSiteLayout>
        <Head title="Academic Affairs" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate z-10 overflow-visible bg-slate-950 text-white"
            >
                <div
                    class="pointer-events-none absolute inset-0 z-0 bg-cover bg-fixed bg-center bg-no-repeat opacity-60 select-none"
                    :style="{
                        backgroundImage: `url('${academicAffairs.profile.heroImage}')`,
                    }"
                    aria-hidden="true"
                ></div>
                <div
                    class="pointer-events-none absolute inset-0 z-0 bg-[#1711d4]/70 mix-blend-multiply"
                    aria-hidden="true"
                ></div>
                <div
                    class="pointer-events-none absolute inset-0 z-0 overflow-hidden"
                    aria-hidden="true"
                >
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.2),transparent_38%),radial-gradient(circle_at_72%_28%,rgba(242,183,5,0.22),transparent_28%),linear-gradient(135deg,rgba(255,255,255,0.08),transparent_34%)]"
                    ></div>
                    <div
                        class="absolute inset-0 [background-image:linear-gradient(90deg,rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(180deg,rgba(255,255,255,0.08)_1px,transparent_1px)] [background-size:3.5rem_3.5rem] opacity-35"
                    ></div>
                    <div
                        class="absolute top-10 left-8 h-44 w-44 rounded-full border border-white/10 sm:h-64 sm:w-64"
                    ></div>
                </div>
                <div
                    class="relative z-10 mx-auto grid min-h-[34rem] max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1fr_24rem] lg:px-8 lg:py-20"
                >
                    <div class="flex flex-col justify-center">
                        <nav
                            aria-label="Breadcrumb"
                            class="ps-1 text-sm font-semibold"
                        >
                            <ol class="flex flex-wrap items-center gap-2">
                                <li>
                                    <Link
                                        :href="home()"
                                        class="text-white/80 transition hover:text-[#f2b705]"
                                    >
                                        Home
                                    </Link>
                                </li>
                                <li class="text-white/45" aria-hidden="true">
                                    /
                                </li>
                                <li class="text-[#f2b705]" aria-current="page">
                                    Academic Affairs
                                </li>
                            </ol>
                        </nav>

                        <h1
                            class="mt-6 max-w-4xl text-4xl leading-tight font-semibold tracking-normal sm:text-6xl"
                        >
                            {{ academicAffairs.profile.title }}
                        </h1>
                    </div>
                </div>
            </section>

            <section
                id="ovpaa-profile"
                class="relative z-20 scroll-mt-28 border-b border-slate-200 bg-[#f7f8f5] pt-10 pb-14 sm:pt-12 sm:pb-16 lg:pt-0 dark:border-white/10 dark:bg-slate-950"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-start lg:gap-12 lg:px-8"
                >
                    <div class="max-w-3xl pt-8 lg:pt-20">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Overview
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                        >
                            Leading Academic Excellence Across NEMSU
                        </h2>
                        <p
                            class="mt-5 text-justify text-lg/8 text-slate-600 dark:text-slate-300"
                        >
                            {{ academicAffairs.profile.summary }}
                        </p>
                        <p
                            v-for="paragraph in academicAffairs.profile
                                .description"
                            :key="paragraph"
                            class="mt-4 text-justify text-lg/8 text-slate-600 dark:text-slate-300"
                        >
                            {{ paragraph }}
                        </p>

                        <div class="mt-10">
                            <p
                                class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                            >
                                Vice President for Academic Affairs
                            </p>
                            <h3
                                class="mt-3 text-2xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                {{ academicAffairs.profile.unitHead }}
                            </h3>
                            <p
                                v-for="paragraph in academicAffairs.profile
                                    .biography"
                                :key="paragraph"
                                class="mt-4 text-justify text-lg/8 text-slate-600 dark:text-slate-300"
                            >
                                {{ paragraph }}
                            </p>
                        </div>
                    </div>

                    <article
                        class="z-20 order-first mx-auto -mt-24 w-full max-w-sm overflow-hidden bg-white/30 text-slate-950 shadow-[0_24px_70px_rgba(15,23,42,0.28)] ring-1 ring-white/45 backdrop-blur-2xl sm:-mt-28 lg:sticky lg:top-24 lg:order-none lg:mt-[-8.5rem] lg:self-start dark:bg-slate-950/35 dark:text-white dark:ring-white/15"
                    >
                        <div class="relative overflow-hidden">
                            <img
                                :src="academicAffairs.profile.image"
                                alt="Maria Lady Sol A. Suazo, Ph.D."
                                class="h-96 w-full object-cover object-top"
                            />
                            <div
                                class="absolute inset-x-0 bottom-0 h-24 bg-linear-to-t from-slate-950/45 to-transparent"
                                aria-hidden="true"
                            ></div>
                        </div>

                        <div class="px-4 pt-5 pb-4 sm:px-5 sm:pb-5">
                            <p
                                class="text-xs font-bold tracking-[0.22em] text-[#f2b705] uppercase"
                            >
                                Vice President
                            </p>
                            <h3
                                class="mt-2 text-2xl leading-tight font-semibold text-slate-950 dark:text-white"
                            >
                                {{ academicAffairs.profile.unitHead }}
                            </h3>
                            <p
                                class="mt-3 border-t border-slate-200 pt-4 text-sm leading-6 text-slate-600 dark:border-white/10 dark:text-sky-100"
                            >
                                {{ academicAffairs.profile.role }}
                            </p>

                            <div
                                class="mt-5 grid gap-3 border-t border-slate-200 pt-4 text-sm text-slate-600 dark:border-white/10 dark:text-slate-300"
                            >
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
                                <span class="inline-flex items-start gap-2">
                                    <MapPin
                                        class="mt-0.5 size-4 shrink-0"
                                        aria-hidden="true"
                                    />
                                    {{ academicAffairs.profile.office }}
                                </span>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <section
                id="ovpaa-offices"
                class="scroll-mt-28 bg-[#1f007c] py-14 text-white sm:py-16"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#ffbf00] uppercase"
                    >
                        Offices under OVPAA
                    </p>
                    <nav
                        aria-label="Offices under OVPAA"
                        class="mt-10 grid gap-x-12 gap-y-7 text-left sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <Link
                            v-for="office in academicAffairs.offices"
                            :key="office.name"
                            :href="officeShow.url(office.slug)"
                            class="group inline-flex items-center justify-start gap-2 text-left text-sm font-bold text-white transition hover:text-[#f2b705] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#f2b705] lg:text-base"
                        >
                            <span>{{ office.name }}</span>
                            <span
                                class="text-[#f2b705] transition group-hover:translate-x-1"
                                aria-hidden="true"
                            >
                                &gt;
                            </span>
                        </Link>
                    </nav>
                </div>
            </section>

            <section
                v-for="programSection in academicProgramSections"
                :id="programSection.slug"
                :key="programSection.slug"
                class="scroll-mt-28 bg-white py-14 sm:py-16 dark:bg-slate-950"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2
                        class="text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                    >
                        {{ programSection.title }}
                    </h2>
                    <ul
                        v-if="programSection.slug === 'undergraduate-programs'"
                        class="mt-7 grid gap-3 border-t border-slate-200 pt-5 text-uni-body text-slate-700 sm:grid-cols-2 dark:border-white/10 dark:text-slate-300"
                    >
                        <li
                            v-for="college in academicAffairs.colleges"
                            :key="college.slug"
                        >
                            <Link
                                :href="collegeShow.url(college.slug)"
                                class="font-semibold text-[#0742b7] transition hover:text-[#003171] dark:text-sky-200 dark:hover:text-rose-200"
                            >
                                {{ college.title }}
                            </Link>
                        </li>
                    </ul>
                    <ul
                        v-else-if="
                            programSection.slug ===
                            'graduate-and-professional-studies'
                        "
                        class="mt-7 grid gap-3 border-t border-slate-200 pt-5 text-uni-body text-slate-700 sm:grid-cols-2 dark:border-white/10 dark:text-slate-300"
                    >
                        <li
                            v-for="study in academicAffairs.graduateProfessionalStudies"
                            :key="study.slug"
                        >
                            <Link
                                :href="studyShow.url(study.slug)"
                                class="font-semibold text-[#0742b7] transition hover:text-[#003171] dark:text-sky-200 dark:hover:text-rose-200"
                            >
                                {{ study.title }}
                            </Link>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
