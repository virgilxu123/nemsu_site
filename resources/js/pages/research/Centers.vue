<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
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

const heroBackgroundImage =
    '/images/administration/ovprie/research/research-centers-hero.jpg';

const director = {
    name: 'Hussein M. Alawi',
    role: 'Director, Research Centers / University Researcher IV',
    email: 'hmalawi@nemsu.edu.ph',
    image: '/images/administration/ovprie/director-research-center.png',
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


const leaderInitials = (name: string): string =>
    name
        .split(/\s+/)
        .filter((part) => /^[A-Za-z]/.test(part))
        .slice(0, 2)
        .map((part) => part.charAt(0).toUpperCase())
        .join('');

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
                class="relative isolate z-10 overflow-hidden bg-slate-950 py-16 text-white sm:py-20"
            >
                <img
                    :src="heroBackgroundImage"
                    alt="Research and Development Office"
                    class="hero-zoom-image pointer-events-none absolute inset-0 z-0 h-full w-full object-cover object-[52%_18%] opacity-70 select-none"
                    aria-hidden="true"
                />
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
                    class="relative z-10 mx-auto max-w-7xl px-4 pb-24 sm:px-6 sm:pb-28 lg:px-8 lg:pb-12"
                >
                    <!-- Breadcrumbs -->
                    <nav
                        aria-label="Breadcrumb"
                        class="ps-1 text-sm font-semibold"
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

                    <div class="mt-6 max-w-3xl">
                        <h1
                            class="text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
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
                </div>
            </section>

            <!-- Main Content: Director & Centers Grid -->
            <section
                class="border-b border-slate-200 bg-white py-14 sm:py-16 dark:border-white/10 dark:bg-slate-950"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-8 lg:grid-cols-[22rem_1fr]">
                        <!-- Director Sidebar -->
                        <aside class="self-start lg:sticky lg:top-24">
                            <img
                                v-if="director.image"
                                :src="director.image"
                                :alt="director.name"
                                class="aspect-[4/5] w-full rounded-md object-cover shadow-lg shadow-slate-900/10"
                            />
                            <div
                                v-else
                                class="grid aspect-[4/5] w-full place-items-center rounded-md bg-[#1711d4] text-white shadow-lg shadow-slate-900/10"
                            >
                                <div class="text-center">
                                    <span
                                        class="mx-auto grid size-24 place-items-center rounded-full bg-white/12 text-3xl font-semibold ring-1 ring-white/20"
                                    >
                                        {{ leaderInitials(director.name) }}
                                    </span>
                                    <p class="mt-4 text-sm text-white/70">
                                        Official photo pending
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5">
                                <p
                                    class="text-xs font-semibold leading-relaxed tracking-wide text-[#9b1c31] uppercase text-pretty dark:text-rose-300"
                                >
                                    {{ director.role }}
                                </p>
                                <h2
                                    class="mt-2 text-2xl font-semibold text-slate-950 dark:text-white"
                                >
                                    {{ director.name }}
                                </h2>
                                <a
                                    :href="`mailto:${director.email}`"
                                    class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                                >
                                    <Mail class="size-4" aria-hidden="true" />
                                    {{ director.email }}
                                </a>
                            </div>
                        </aside>

                        <!-- Centers Content & Grid -->
                        <div>
                            <!-- Search and Campus Filter Controls -->
                            <div class="space-y-4">
                                <div class="relative w-full">
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

                                <!-- Campus Filter Badges -->
                                <div class="mt-6 flex flex-wrap items-center gap-2">
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

                            <!-- Centers Grid -->
                            <div class="mt-8">
                                <div
                                    v-if="filteredCenters.length > 0"
                                    class="grid gap-6 sm:grid-cols-2"
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
                                            </div>

                                            <!-- Center Name -->
                                            <h3
                                                class="mt-4 text-lg font-bold leading-snug text-slate-950 transition-colors group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-300"
                                            >
                                                {{ center.name }} ({{ center.acronym }})
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
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>

<style scoped>
.hero-zoom-image {
    animation: hero-zoom 15s ease-in-out infinite alternate;
    transform: scale(1.03);
    transform-origin: 52% 18%;
    will-change: transform;
}

@keyframes hero-zoom {
    from {
        transform: scale(1);
    }

    to {
        transform: scale(1.12);
    }
}

@media (prefers-reduced-motion: reduce) {
    .hero-zoom-image {
        animation: none;
        transform: scale(1.03);
    }
}
</style>
