<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { BookOpenText, MapPin } from 'lucide-vue-next';
import { show as studyShow } from '@/actions/App/Http/Controllers/GraduateProfessionalStudyController';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { academicAffairs } from '@/routes/academics';

type CampusOffering = {
    name: string;
    courses: string[];
};

type Study = {
    slug: string;
    title: string;
    overview: string;
    campuses: CampusOffering[];
};

type StudyLink = {
    slug: string;
    title: string;
};

const props = defineProps<{
    study: Study;
    studies: StudyLink[];
}>();

const heroBackgroundImage = '/images/administration/ovpaf/6I3A7029(1).jpg';
</script>

<template>
    <PublicSiteLayout>
        <Head :title="props.study.title" />

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

                <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h1
                        class="mt-5 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                    >
                        {{ props.study.title }}
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
                                {{ props.study.title }}
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
                            class="text-sm font-light tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Graduate and Professional Studies
                        </p>
                        <nav
                            aria-label="Graduate and professional studies"
                            class="mt-7 grid gap-0"
                        >
                            <Link
                                v-for="studyLink in props.studies"
                                :key="studyLink.slug"
                                :href="studyShow.url(studyLink.slug)"
                                class="border-b border-slate-200 py-3 text-sm leading-none font-light text-slate-700 transition hover:text-[#0b6680] dark:border-white/10 dark:text-slate-300 dark:hover:text-sky-200"
                                :class="
                                    studyLink.slug === props.study.slug
                                        ? 'font-semibold text-[#9b1c31] dark:text-rose-200'
                                        : ''
                                "
                            >
                                {{ studyLink.title }}
                            </Link>
                        </nav>
                    </aside>

                    <div>
                        <article class="max-w-4xl">
                            <p
                                class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                Overview
                            </p>
                            <h2
                                class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                            >
                                {{ props.study.title }}
                            </h2>
                            <p
                                class="mt-5 text-uni-body text-slate-600 dark:text-slate-300"
                            >
                                {{ props.study.overview }}
                            </p>
                        </article>

                        <div class="mt-12 grid gap-8">
                            <section
                                v-for="campus in props.study.campuses"
                                :key="campus.name"
                                class="border-t border-slate-200 pt-8 dark:border-white/10"
                            >
                                <div
                                    class="grid gap-5 lg:grid-cols-[16rem_minmax(0,1fr)] lg:gap-10"
                                >
                                    <div>
                                        <p
                                            class="inline-flex items-center gap-2 text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                        >
                                            <MapPin
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                            Campus
                                        </p>
                                        <h3
                                            class="mt-3 text-2xl font-semibold tracking-normal text-slate-950 dark:text-white"
                                        >
                                            {{ campus.name }}
                                        </h3>
                                    </div>

                                    <div>
                                        <p
                                            class="inline-flex items-center gap-2 text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                        >
                                            <BookOpenText
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                            Courses
                                        </p>
                                        <ul
                                            class="mt-4 grid gap-3 text-uni-body text-slate-700 dark:text-slate-300"
                                        >
                                            <li
                                                v-for="course in campus.courses"
                                                :key="course"
                                                class="flex gap-3"
                                            >
                                                <span
                                                    class="mt-3 size-1.5 shrink-0 rounded-full bg-[#9b1c31]"
                                                    aria-hidden="true"
                                                ></span>
                                                <span>{{ course }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
