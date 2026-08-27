<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Building2,
    Calendar,
    Mail,
    MapPin,
    Search,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { rie } from '@/routes/research';

type ResearchCenter = {
    name: string;
    acronym: string;
    campus: string;
    established: string;
    summary: string;
};

const director = {
    name: 'Hussein M. Alawi',
    role: 'Director, Research Centers / University Researcher IV',
    email: 'hmalawi@nemsu.edu.ph',
    image: null,
};

const researchCenters: ResearchCenter[] = [
    {
        name: 'Research Center for Continuing Education and Professional Development',
        acronym: 'RCCEPD',
        campus: 'Tandag Campus',
        established: 'December 19, 2023',
        summary:
            'Advances lifelong learning, professional development, and applied research for priority regional sectors.',
    },
    {
        name: 'Center for Local Leadership and Governance',
        acronym: 'CLLG',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'Promotes evidence-based governance, leadership development, and technical assistance for public and community institutions.',
    },
    {
        name: 'Center for Instructional Innovation and Development',
        acronym: 'CIID',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'Supports instructional innovation, educational technology, and the development of high-quality learning resources.',
    },
    {
        name: 'Society, Human Interaction, Nature and Environment Research Center',
        acronym: 'SHINE',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'Advances interdisciplinary research on society, biodiversity, sustainability, and human-environment interactions.',
    },
    {
        name: 'Research Center for Industrial Technology and Renewable Energy',
        acronym: 'RCITRE',
        campus: 'Cantilan Campus',
        established: 'December 19, 2023',
        summary:
            'Develops practical industrial and clean-energy solutions that support green industries and regional competitiveness.',
    },
    {
        name: 'Food Innovation Center',
        acronym: 'FIC',
        campus: 'Cantilan Campus',
        established: 'October 14, 2025',
        summary:
            'Supports food product development, processing, quality assurance, technology transfer, and entrepreneurship.',
    },
    {
        name: 'Research Center for Climate-Smart Agriculture',
        acronym: 'RCC-SA',
        campus: 'San Miguel Campus',
        established: 'December 19, 2023',
        summary:
            'Develops climate-smart agricultural practices that improve productivity, resilience, and food security.',
    },
    {
        name: 'Tourism and SMEs Innovation Research Center',
        acronym: 'TSMEIRC',
        campus: 'Cagwait Campus',
        established: 'December 19, 2023',
        summary:
            'Strengthens sustainable tourism, entrepreneurship, local products, and community-based industries.',
    },
    {
        name: 'Center of Research for Aquamarine Life Sustainability',
        acronym: 'CoRALS',
        campus: 'Lianga Campus',
        established: 'December 19, 2023',
        summary:
            'Advances sustainable fisheries, marine biodiversity, aquaculture, and integrated coastal resource management.',
    },
    {
        name: 'Center for Aquasilviculture and Seaweed Advancement',
        acronym: 'AQUASEA',
        campus: 'Lianga Campus',
        established: 'October 14, 2025',
        summary:
            'Integrates aquasilviculture, seaweed development, mangrove restoration, and coastal ecosystem management.',
    },
    {
        name: 'Food and Farming Technology Research Center',
        acronym: 'FFTRC',
        campus: 'Tagbina Campus',
        established: 'December 19, 2023',
        summary:
            'Improves agricultural productivity, food innovation, value addition, and sustainable farming systems.',
    },
    {
        name: 'Agro-Forestry Industrial Research Center',
        acronym: 'AFIRC',
        campus: 'Bislig Campus',
        established: 'December 19, 2023',
        summary:
            'Advances agroforestry, sustainable natural resource management, and agro-industrial innovation.',
    },
];

const campuses = [
    'All Campuses',
    'Tandag Campus',
    'Cantilan Campus',
    'San Miguel Campus',
    'Cagwait Campus',
    'Lianga Campus',
    'Tagbina Campus',
    'Bislig Campus',
];

const selectedCampus = ref('All Campuses');
const searchQuery = ref('');

const filteredCenters = computed(() => {
    return researchCenters.filter((center) => {
        const matchesCampus =
            selectedCampus.value === 'All Campuses' ||
            center.campus === selectedCampus.value;
        const matchesSearch =
            searchQuery.value.trim() === '' ||
            center.name
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            center.acronym
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            center.summary
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            center.campus
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase());

        return matchesCampus && matchesSearch;
    });
});
</script>

<template>
    <PublicSiteLayout>
        <Head title="Research Centers | NEMSU" />

        <main class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <!-- Hero Section -->
            <section
                class="relative isolate overflow-hidden bg-[#061b49] text-white"
            >
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(14,165,233,0.28),transparent_38%),linear-gradient(135deg,rgba(23,17,212,0.28),transparent_62%)]"
                    aria-hidden="true"
                ></div>
                <div
                    class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-18 lg:px-8 lg:py-20"
                >
                    <!-- Breadcrumbs -->
                    <nav
                        aria-label="Breadcrumb"
                        class="mb-6 text-sm font-semibold"
                    >
                        <ol class="flex flex-wrap items-center gap-2">
                            <li>
                                <Link
                                    :href="home().url"
                                    class="text-white/80 transition hover:text-[#f2b705]"
                                >
                                    Home
                                </Link>
                            </li>
                            <li class="text-white/45" aria-hidden="true">/</li>
                            <li>
                                <Link
                                    :href="rie().url"
                                    class="text-white/80 transition hover:text-[#f2b705]"
                                >
                                    Research, Innovation, and Extension
                                </Link>
                            </li>
                            <li class="text-white/45" aria-hidden="true">/</li>
                            <li class="text-[#f2b705]" aria-current="page">
                                Research Centers
                            </li>
                        </ol>
                    </nav>

                    <div
                        class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end"
                    >
                        <div class="max-w-3xl">
                            <p
                                class="text-xs font-bold tracking-widest text-[#f2b705] uppercase"
                            >
                                Office of Research and Innovation
                            </p>
                            <h1
                                class="mt-3 text-4xl font-semibold tracking-tight sm:text-5xl lg:text-6xl"
                            >
                                University Research Centers
                            </h1>
                            <p
                                class="mt-5 max-w-2xl text-base leading-8 text-sky-50 sm:text-lg"
                            >
                                Specialized institutional research centers
                                driving innovation, sustainable regional
                                development, biodiversity conservation, and
                                community empowerment across NEMSU campuses.
                            </p>
                        </div>

                        <div
                            class="flex w-fit items-center gap-4 rounded-lg border border-white/15 bg-white/10 px-6 py-5 backdrop-blur"
                        >
                            <Building2
                                class="size-8 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            <div>
                                <p class="text-3xl font-bold">
                                    {{ researchCenters.length }}
                                </p>
                                <p class="text-xs font-medium tracking-wide text-sky-100 uppercase">
                                    Research Centers
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Director Profile & Search Controls -->
            <section
                class="border-b border-slate-200 bg-slate-50 py-10 dark:border-white/10 dark:bg-slate-900/50"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        class="grid gap-8 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)] lg:items-center"
                    >
                        <!-- Director Leadership Card -->
                        <div
                            class="flex flex-col gap-4 rounded-xl border border-slate-200/80 bg-white p-6 shadow-xs sm:flex-row sm:items-center sm:gap-6 dark:border-white/10 dark:bg-slate-950"
                        >
                            <div
                                class="flex size-16 shrink-0 items-center justify-center rounded-xl bg-[#061b49] text-xl font-bold text-white shadow-md ring-2 ring-[#f2b705]/50"
                            >
                                HA
                            </div>
                            <div>
                                <p
                                    class="text-xs font-bold tracking-widest text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    Office of the Director
                                </p>
                                <h2
                                    class="mt-1 text-xl font-bold text-slate-950 dark:text-white"
                                >
                                    {{ director.name }}
                                </h2>
                                <p
                                    class="text-xs leading-5 text-slate-600 dark:text-slate-400"
                                >
                                    {{ director.role }}
                                </p>
                                <a
                                    :href="`mailto:${director.email}`"
                                    class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-[#1711d4] transition hover:underline dark:text-sky-300"
                                >
                                    <Mail class="size-3.5" aria-hidden="true" />
                                    {{ director.email }}
                                </a>
                            </div>
                        </div>

                        <!-- Search and Campus Filter -->
                        <div class="space-y-4">
                            <div class="relative">
                                <Search
                                    class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"
                                    aria-hidden="true"
                                />
                                <input
                                    v-model="searchQuery"
                                    type="search"
                                    placeholder="Search center by name, acronym, or field..."
                                    class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pr-4 pl-9 text-sm text-slate-900 placeholder:text-slate-400 focus:border-[#1711d4] focus:outline-hidden focus:ring-1 focus:ring-[#1711d4] dark:border-white/15 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-500"
                                />
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <button
                                    v-for="campus in campuses"
                                    :key="campus"
                                    type="button"
                                    @click="selectedCampus = campus"
                                    class="rounded-full px-3 py-1 text-xs font-semibold transition cursor-pointer"
                                    :class="
                                        selectedCampus === campus
                                            ? 'bg-[#1711d4] text-white shadow-xs dark:bg-sky-500 dark:text-slate-950'
                                            : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-100 dark:bg-white/5 dark:text-slate-300 dark:ring-white/10 dark:hover:bg-white/10'
                                    "
                                >
                                    {{ campus }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Centers Grid -->
            <section class="py-14 sm:py-18">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        v-if="filteredCenters.length > 0"
                        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <article
                            v-for="center in filteredCenters"
                            :key="center.acronym"
                            class="group relative flex flex-col justify-between rounded-xl border border-slate-200/80 bg-white p-6 shadow-xs transition-all duration-300 hover:-translate-y-1 hover:border-[#1711d4]/40 hover:shadow-lg hover:shadow-slate-900/5 dark:border-white/10 dark:bg-slate-900/40 dark:hover:border-sky-400/40"
                        >
                            <div>
                                <!-- Top Bar: Campus & Acronym -->
                                <div
                                    class="flex items-center justify-between gap-2"
                                >
                                    <span
                                        class="inline-flex items-center gap-1 text-xs font-semibold text-[#9b1c31] dark:text-rose-300"
                                    >
                                        <MapPin
                                            class="size-3.5 shrink-0"
                                            aria-hidden="true"
                                        />
                                        {{ center.campus }}
                                    </span>
                                    <span
                                        class="rounded-md bg-[#e7f3fb] px-2.5 py-0.5 text-xs font-bold tracking-wide text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                                    >
                                        {{ center.acronym }}
                                    </span>
                                </div>

                                <!-- Center Name -->
                                <h3
                                    class="mt-4 text-lg font-bold leading-snug text-slate-950 transition-colors group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-300"
                                >
                                    {{ center.name }}
                                </h3>

                                <!-- Established Date -->
                                <p
                                    class="mt-2 inline-flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400"
                                >
                                    <Calendar
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    Established {{ center.established }}
                                </p>

                                <!-- Summary -->
                                <p
                                    class="mt-4 text-sm leading-relaxed text-slate-600 dark:text-slate-300"
                                >
                                    {{ center.summary }}
                                </p>
                            </div>

                            <div
                                class="mt-6 border-t border-slate-100 pt-4 dark:border-white/5"
                            >
                                <span
                                    class="text-xs font-semibold text-[#1711d4] dark:text-sky-300"
                                >
                                    NEMSU Research Center
                                </span>
                            </div>
                        </article>
                    </div>

                    <!-- Empty State -->
                    <div
                        v-else
                        class="rounded-xl border border-dashed border-slate-300 p-12 text-center dark:border-white/15"
                    >
                        <Building2
                            class="mx-auto size-12 text-slate-400 dark:text-slate-500"
                            aria-hidden="true"
                        />
                        <h3
                            class="mt-4 text-base font-semibold text-slate-900 dark:text-white"
                        >
                            No research centers found
                        </h3>
                        <p
                            class="mt-1 text-sm text-slate-500 dark:text-slate-400"
                        >
                            Try adjusting your search terms or campus filter.
                        </p>
                        <button
                            type="button"
                            @click="
                                selectedCampus = 'All Campuses';
                                searchQuery = '';
                            "
                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-[#1711d4] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#0b3d91]"
                        >
                            Reset filters
                        </button>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>
