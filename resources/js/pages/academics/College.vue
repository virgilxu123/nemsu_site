<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { show as collegeShow } from '@/actions/App/Http/Controllers/CollegeController';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { academicAffairs } from '@/routes/academics';

type Program = {
    title: string;
    campuses: string[];
    description: string | null;
    prospectusUrl: string | null;
};

type College = {
    slug: string;
    title: string;
    overview: string;
    programs: Program[];
};

type CollegeLink = {
    slug: string;
    title: string;
};

const props = defineProps<{
    college: College;
    colleges: CollegeLink[];
}>();

const heroBackgroundImage = '/images/administration/ovpaf/6I3A7029(1).jpg';
</script>

<template>
    <PublicSiteLayout>
        <Head :title="props.college.title" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate overflow-hidden bg-slate-950 py-16 text-white sm:py-20"
            >
                <img
                    :src="heroBackgroundImage"
                    alt=""
                    class="pointer-events-none absolute inset-0 z-0 h-full w-full object-cover object-center opacity-60 select-none"
                    aria-hidden="true"
                />
                <div
                    class="pointer-events-none absolute inset-0 z-0 bg-[#1711d4]/70 mix-blend-multiply"
                    aria-hidden="true"
                ></div>
                <div
                    class="pointer-events-none absolute inset-0 z-0 [background-image:linear-gradient(90deg,rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(180deg,rgba(255,255,255,0.08)_1px,transparent_1px)] [background-size:3.5rem_3.5rem] opacity-35"
                    aria-hidden="true"
                ></div>

                <div
                    class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
                >
                    <h1
                        class="mt-5 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                    >
                        {{ props.college.title }}
                    </h1>

                    <nav
                        aria-label="Breadcrumb"
                        class="mt-8 text-sm font-semibold"
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
                            <li class="text-white/45" aria-hidden="true">/</li>
                            <li>
                                <Link
                                    :href="academicAffairs()"
                                    class="text-white/80 transition hover:text-[#f2b705]"
                                >
                                    Academic Affairs
                                </Link>
                            </li>
                            <li class="text-white/45" aria-hidden="true">/</li>
                            <li class="text-[#f2b705]" aria-current="page">
                                {{ props.college.title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </section>

            <section class="py-14 sm:py-16">
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 md:grid-cols-[12rem_minmax(0,1fr)] lg:gap-12 lg:px-8 xl:grid-cols-[14rem_minmax(0,1fr)]"
                >
                    <aside
                        class="border-t border-slate-200 pt-8 md:sticky md:top-24 md:self-start dark:border-white/10"
                    >
                        <p
                            class="text-sm font-light tracking-wide text-[#1711d4] uppercase dark:text-sky-300"
                        >
                            Undergraduate Colleges
                        </p>
                        <nav
                            aria-label="Undergraduate colleges"
                            class="mt-7 grid gap-0"
                        >
                            <Link
                                v-for="collegeLink in props.colleges"
                                :key="collegeLink.slug"
                                :href="collegeShow.url(collegeLink.slug)"
                                class="border-b border-slate-200 py-3 text-sm leading-none font-light text-slate-700 transition hover:text-[#1711d4] dark:border-white/10 dark:text-slate-300 dark:hover:text-sky-200"
                                :class="
                                    collegeLink.slug === props.college.slug
                                        ? 'font-semibold text-[#1711d4] dark:text-sky-200'
                                        : ''
                                "
                            >
                                {{ collegeLink.title }}
                            </Link>
                        </nav>
                    </aside>

                    <div>
                        <article class="max-w-4xl">
                            <p
                                class="text-sm font-semibold tracking-wide text-[#1711d4] uppercase dark:text-sky-300"
                            >
                                Overview
                            </p>
                            <h2
                                class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                            >
                                {{ props.college.title }}
                            </h2>
                            <p
                                class="mt-5 text-justify text-lg/8 text-slate-600 dark:text-slate-300"
                            >
                                {{ props.college.overview }}
                            </p>
                        </article>

                        <section class="mt-12">
                            <p
                                class="text-sm font-semibold tracking-wide text-[#1711d4] uppercase dark:text-sky-300"
                            >
                                Programs Offered
                            </p>

                            <div
                                class="mt-8 border-y border-slate-200 dark:border-white/10"
                            >
                                <details
                                    v-for="program in props.college.programs"
                                    :key="program.title"
                                    name="college-programs"
                                    class="group border-b border-slate-200 last:border-b-0 dark:border-white/10"
                                >
                                    <summary
                                        class="flex cursor-pointer list-none items-start justify-between gap-6 py-6 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1711d4] [&::-webkit-details-marker]:hidden"
                                    >
                                        <span class="min-w-0">
                                            <span
                                                class="block text-lg/7 font-semibold tracking-normal text-slate-950 dark:text-white"
                                            >
                                                {{ program.title }}
                                            </span>
                                            <span
                                                class="mt-2 block text-sm/6 text-slate-500 dark:text-slate-400"
                                            >
                                                Offered at
                                                {{
                                                    program.campuses.join(', ')
                                                }}
                                            </span>
                                        </span>
                                        <span
                                            class="mt-1 text-2xl/7 font-light text-[#1711d4] transition-transform duration-200 group-open:rotate-45 dark:text-sky-300"
                                            aria-hidden="true"
                                        >
                                            +
                                        </span>
                                    </summary>

                                    <div
                                        class="grid gap-8 pr-10 pb-8 md:grid-cols-[minmax(0,1fr)_15rem] md:gap-12"
                                    >
                                        <div v-if="program.description">
                                            <h3
                                                class="text-sm font-semibold tracking-wide text-slate-950 uppercase dark:text-white"
                                            >
                                                About the program
                                            </h3>
                                            <p
                                                class="mt-3 text-base/7 text-slate-600 dark:text-slate-300"
                                            >
                                                {{ program.description }}
                                            </p>
                                        </div>

                                        <div
                                            class="border-l-2 border-[#1711d4] pl-5 dark:border-sky-300"
                                        >
                                            <h3
                                                class="text-sm font-semibold tracking-wide text-slate-950 uppercase dark:text-white"
                                            >
                                                Prospectus
                                            </h3>
                                            <a
                                                v-if="program.prospectusUrl"
                                                :href="program.prospectusUrl"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="mt-3 inline-flex text-sm/6 font-semibold text-[#1711d4] underline decoration-[#1711d4]/35 underline-offset-4 transition hover:text-[#0f0ab8] dark:text-sky-300 dark:hover:text-sky-100"
                                            >
                                                View program prospectus (PDF)
                                            </a>
                                            <p
                                                v-else
                                                class="mt-3 text-sm/6 text-slate-500 dark:text-slate-400"
                                            >
                                                The program prospectus will be
                                                available here soon.
                                            </p>
                                        </div>
                                    </div>
                                </details>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
