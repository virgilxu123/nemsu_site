<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Calendar, Mail, MapPin, Search } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { rie } from '@/routes/research';
import { centers } from '@/routes/research/rie';
import { ovprieAddress, researchCenters } from './content';
import ContentPreviewNav from './ContentPreviewNav.vue';

const heroBackgroundImage =
    '/images/administration/ovprie/research/research-centers-hero.jpg';

const campuses = [
    'All Campuses',
    ...Array.from(new Set(researchCenters.map((center) => center.campus))),
];

const selectedCampus = ref('All Campuses');
const searchQuery = ref('');

const filteredCenters = computed(() => {
    const query = searchQuery.value.trim().toLowerCase();

    return researchCenters.filter((center) => {
        const matchesCampus =
            selectedCampus.value === 'All Campuses' ||
            center.campus === selectedCampus.value;
        const matchesQuery =
            query === '' ||
            center.name.toLowerCase().includes(query) ||
            center.acronym.toLowerCase().includes(query) ||
            center.campus.toLowerCase().includes(query) ||
            center.summary.toLowerCase().includes(query) ||
            center.sdgs.some((sdg) => `sdg ${sdg}`.includes(query));

        return matchesCampus && matchesQuery;
    });
});

const sdgImage = (sdg: number): string =>
    `/images/administration/ovprie/research/sdgs/E-WEB-Goal-${String(sdg).padStart(2, '0')}.png`;
</script>

<template>
    <PublicSiteLayout>
        <Head title="Research Centers Content Preview | NEMSU" />

        <main class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate overflow-hidden bg-slate-950 py-16 text-white sm:py-20"
            >
                <img
                    :src="heroBackgroundImage"
                    alt=""
                    class="absolute inset-0 size-full object-cover object-[52%_18%] opacity-50"
                    aria-hidden="true"
                />
                <div
                    class="absolute inset-0 bg-linear-to-r from-[#1711d4]/90 via-[#1711d4]/75 to-slate-950/80"
                    aria-hidden="true"
                ></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <nav aria-label="Breadcrumb" class="text-sm font-semibold">
                        <ol class="flex flex-wrap items-center gap-2">
                            <li>
                                <Link
                                    :href="home().url"
                                    class="text-white/80 hover:text-[#f2b705]"
                                    >Home</Link
                                >
                            </li>
                            <li class="text-white/40" aria-hidden="true">/</li>
                            <li>
                                <Link
                                    :href="rie().url"
                                    class="text-white/80 hover:text-[#f2b705]"
                                    >RIE</Link
                                >
                            </li>
                            <li class="text-white/40" aria-hidden="true">/</li>
                            <li class="text-[#f2b705]" aria-current="page">
                                Research centers preview
                            </li>
                        </ol>
                    </nav>
                    <div class="mt-8 max-w-4xl">
                        <p
                            class="text-sm font-semibold tracking-widest text-[#f2b705] uppercase"
                        >
                            Research and Innovation Director’s Office
                        </p>
                        <h1
                            class="mt-3 text-4xl font-semibold tracking-tight sm:text-5xl lg:text-6xl"
                        >
                            University Research Centers
                        </h1>
                        <p
                            class="mt-5 max-w-3xl text-base leading-8 text-sky-50 sm:text-lg"
                        >
                            All 12 source-listed centers, organized by campus
                            with establishment dates, complete center
                            descriptions, and SDG alignments.
                        </p>
                    </div>
                </div>
            </section>

            <ContentPreviewNav active="centers" />

            <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="grid gap-6 lg:grid-cols-[20rem_minmax(0,1fr)]">
                    <aside
                        class="h-fit rounded-xl border border-slate-200 bg-[#f7f8f5] p-6 lg:sticky lg:top-28 dark:border-white/10 dark:bg-white/[0.04]"
                    >
                        <p
                            class="text-xs font-semibold tracking-widest text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Director, Research Centers
                        </p>
                        <h2 class="mt-3 text-xl font-semibold">
                            Hussein M. Alawi
                        </h2>
                        <p
                            class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            Director, Research Centers / University Researcher
                            IV
                        </p>
                        <a
                            href="mailto:hmalawi@nemsu.edu.ph"
                            class="mt-5 flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-300"
                        >
                            <Mail class="size-4" aria-hidden="true" />
                            hmalawi@nemsu.edu.ph
                        </a>
                        <p
                            class="mt-3 flex items-start gap-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            <MapPin
                                class="mt-1 size-4 shrink-0"
                                aria-hidden="true"
                            />
                            {{ ovprieAddress }}
                        </p>
                        <Link
                            :href="centers().url"
                            class="mt-5 inline-flex text-xs font-semibold text-slate-500 underline underline-offset-4 hover:text-[#1711d4] dark:text-slate-400 dark:hover:text-sky-300"
                        >
                            Open current centers page
                        </Link>
                    </aside>

                    <div>
                        <div
                            class="rounded-xl border border-slate-200 bg-white p-5 dark:border-white/10 dark:bg-slate-900"
                        >
                            <label
                                for="center-search"
                                class="text-sm font-semibold"
                                >Find a research center</label
                            >
                            <div
                                class="mt-3 grid gap-3 sm:grid-cols-[minmax(0,1fr)_15rem]"
                            >
                                <div class="relative">
                                    <Search
                                        class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"
                                        aria-hidden="true"
                                    />
                                    <input
                                        id="center-search"
                                        v-model="searchQuery"
                                        type="search"
                                        placeholder="Name, acronym, campus, or SDG"
                                        class="h-11 w-full rounded-lg border border-slate-300 bg-white ps-10 pe-3 text-sm transition outline-none focus:border-[#1711d4] focus:ring-2 focus:ring-[#1711d4]/15 dark:border-white/15 dark:bg-slate-950"
                                    />
                                </div>
                                <select
                                    v-model="selectedCampus"
                                    aria-label="Filter by campus"
                                    class="h-11 rounded-lg border border-slate-300 bg-white px-3 text-sm outline-none focus:border-[#1711d4] dark:border-white/15 dark:bg-slate-950"
                                >
                                    <option
                                        v-for="campus in campuses"
                                        :key="campus"
                                        :value="campus"
                                    >
                                        {{ campus }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <p
                            class="mt-6 text-sm font-semibold text-slate-600 dark:text-slate-300"
                        >
                            {{ filteredCenters.length }} of
                            {{ researchCenters.length }} centers
                        </p>

                        <div class="mt-4 grid gap-5 xl:grid-cols-2">
                            <article
                                v-for="center in filteredCenters"
                                :key="center.acronym"
                                class="flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900"
                            >
                                <div
                                    class="flex items-start justify-between gap-4"
                                >
                                    <div>
                                        <span
                                            class="inline-flex rounded-full bg-[#1711d4]/10 px-3 py-1 text-xs font-bold text-[#1711d4] dark:bg-sky-300/10 dark:text-sky-300"
                                        >
                                            {{ center.acronym }}
                                        </span>
                                        <h2
                                            class="mt-3 text-xl leading-7 font-semibold"
                                        >
                                            {{ center.name }}
                                        </h2>
                                    </div>
                                </div>
                                <div
                                    class="mt-4 flex flex-wrap gap-x-4 gap-y-2 text-xs font-semibold text-slate-500 dark:text-slate-400"
                                >
                                    <span class="flex items-center gap-1.5"
                                        ><MapPin
                                            class="size-3.5"
                                            aria-hidden="true"
                                        />{{ center.campus }}</span
                                    >
                                    <span class="flex items-center gap-1.5"
                                        ><Calendar
                                            class="size-3.5"
                                            aria-hidden="true"
                                        />{{ center.established }}</span
                                    >
                                </div>
                                <p
                                    class="mt-5 text-justify text-sm leading-7 text-slate-600 dark:text-slate-300"
                                >
                                    {{ center.summary }}
                                </p>
                                <div
                                    class="mt-6 border-t border-slate-200 pt-5 dark:border-white/10"
                                >
                                    <p
                                        class="text-xs font-semibold tracking-wide text-slate-500 uppercase dark:text-slate-400"
                                    >
                                        Sustainable Development Goals
                                    </p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <img
                                            v-for="sdg in center.sdgs"
                                            :key="sdg"
                                            :src="sdgImage(sdg)"
                                            :alt="`SDG ${sdg}`"
                                            loading="lazy"
                                            class="size-11 rounded-sm"
                                        />
                                    </div>
                                </div>
                            </article>
                        </div>

                        <div
                            v-if="filteredCenters.length === 0"
                            class="mt-5 rounded-xl border border-dashed border-slate-300 p-10 text-center text-sm text-slate-600 dark:border-white/15 dark:text-slate-300"
                        >
                            No research center matches the selected filters.
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>
