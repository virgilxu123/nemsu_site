<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    Building2,
    Calendar,
    ChevronDown,
    ChevronUp,
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
    sdgs: string[];
};

const heroBackgroundImage =
    '/images/administration/ovprie/research/research-centers-hero.jpg';

const director = {
    name: 'Hussein M. Alawi',
    role: 'Director, Research Centers / University Researcher IV',
    email: 'hmalawi@nemsu.edu.ph',
    address:
        '',
    image: '/images/administration/ovprie/director-research-center.png',
    summary:
        'Research Centers are integral to advancing the University’s research goals by managing activities, resources, and personnel in alignment with institutional priorities. They foster interdisciplinary collaboration, support grant proposals, and ensure research compliance with ethical and regulatory standards. The centers provide professional development for researchers, track research performance, and advocate for resources and recognition, strengthening their impact within the academic community and beyond.',
};

const researchCenters: ResearchCenter[] = [
    {
        name: 'Research Center for Continuing Education and Professional Development',
        acronym: 'RCCEPD',
        campus: 'Tandag Campus',
        established: 'December 19, 2023',
        summary:
            'RCCEPD serves as NEMSU’s hub for lifelong learning, professional development, and applied research that strengthens workforce competencies and responds to the evolving needs of the region. It develops research-based training programs, specialized courses, and capacity-building initiatives that enhance the skills of professionals in agriculture, fisheries, education, eco-tourism, and other priority sectors. Through strong partnerships with government agencies, industry, and community stakeholders, the center promotes innovation, knowledge exchange, and sustainable regional development while advancing the University\'s commitment to continuous learning and global competitiveness.',
        sdgs: [
            'SDG 4 – Quality Education',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 11 – Sustainable Cities and Communities',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Center for Local Leadership and Governance',
        acronym: 'CLLG',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'The Center for Local Leadership and Governance promotes evidence-based governance by conducting policy research, leadership development, and technical assistance for local government units, civil society organizations, and community leaders. It supports responsive, transparent, and accountable governance through research-driven solutions, digital innovation, and capacity-building programs aligned with national development priorities and sustainable development goals. The center strengthens NEMSU’s role as a strategic partner in improving local governance and public service delivery.',
        sdgs: [
            'SDG 4 – Quality Education',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 10 – Reduced Inequalities',
            'SDG 11 – Sustainable Cities and Communities',
            'SDG 16 – Peace, Justice and Strong Institutions',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Center for Instructional Innovation and Development',
        acronym: 'CIID',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'CIID serves as the University\'s center for instructional innovation, educational technology, and learning resource development. It supports faculty in the creation, evaluation, production, and dissemination of high-quality instructional materials while promoting innovative teaching practices and technology-enhanced learning. The center also provides facilities for educational technology training, creative learning spaces, and instructional media production to improve teaching effectiveness, student learning experiences, and institutional quality standards.',
        sdgs: [
            'SDG 3 – Good Health and Well-being',
            'SDG 4 – Quality Education',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 10 – Reduced Inequalities',
            'SDG 11 – Sustainable Cities and Communities',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Society, Human Interaction, Nature and Environment Research Center',
        acronym: 'SHINE',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'The SHINE Research Center advances interdisciplinary research on society, culture, biodiversity, environmental sustainability, and human-environment interactions to address complex regional challenges. By integrating the social sciences, natural sciences, and emerging technologies, it generates evidence-based knowledge that supports biodiversity conservation, climate resilience, inclusive development, and informed public policy. The center strengthens collaboration among researchers, communities, and stakeholders to promote sustainable development in the Caraga Region.',
        sdgs: [
            'SDG 3 – Good Health and Well-being',
            'SDG 4 – Quality Education',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 10 – Reduced Inequalities',
            'SDG 11 – Sustainable Cities and Communities',
            'SDG 13 – Climate Action',
            'SDG 14 – Life Below Water',
            'SDG 15 – Life on Land',
            'SDG 16 – Peace, Justice and Strong Institutions',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Research Center for Industrial Technology and Renewable Energy',
        acronym: 'RCITRE',
        campus: 'Cantilan Campus',
        established: 'December 19, 2023',
        summary:
            'RCITRE promotes research and innovation in industrial technology and renewable energy to address regional development needs while advancing environmental sustainability. The center develops practical solutions that support clean energy, green industries, technology transfer, and livelihood generation through strong collaboration among academia, industry, government, and local communities. It aims to enhance regional competitiveness by transforming research into technologies and innovations with social and economic impact.',
        sdgs: [
            'SDG 7 – Affordable and Clean Energy',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 11 – Sustainable Cities and Communities',
            'SDG 12 – Responsible Consumption and Production',
            'SDG 13 – Climate Action',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Food Innovation Center',
        acronym: 'FIC',
        campus: 'Cantilan Campus',
        established: 'October 14, 2025',
        summary:
            'The Food Innovation Center serves as a research and innovation hub for food product development, processing technologies, quality assurance, and entrepreneurship. It supports farmers, fisherfolk, MSMEs, and local industries through value addition, technology transfer, product commercialization, and business incubation. By maximizing local agricultural resources and promoting food safety and innovation, the center contributes to food security, economic growth, and sustainable regional development.',
        sdgs: [
            'SDG 1 – No Poverty',
            'SDG 2 – Zero Hunger',
            'SDG 4 – Quality Education',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 12 – Responsible Consumption and Production',
            'SDG 14 – Life Below Water',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Research Center for Climate-Smart Agriculture',
        acronym: 'RCC-SA',
        campus: 'San Miguel Campus',
        established: 'December 19, 2023',
        summary:
            'RCC-SA conducts research, innovation, and extension programs that promote climate-smart agricultural practices to improve productivity, resilience, and environmental sustainability. The center develops science-based solutions that enhance food security, climate adaptation, and sustainable resource management while empowering farming communities through research, technology transfer, and capacity-building initiatives.',
        sdgs: [
            'SDG 1 – No Poverty',
            'SDG 2 – Zero Hunger',
            'SDG 6 – Clean Water and Sanitation',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 12 – Responsible Consumption and Production',
            'SDG 13 – Climate Action',
            'SDG 15 – Life on Land',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Tourism and SMEs Innovation Research Center',
        acronym: 'TSMEIRC',
        campus: 'Cagwait Campus',
        established: 'December 19, 2023',
        summary:
            'TSMEIRC advances research and innovation that strengthen tourism development and the growth of small and medium enterprises. The center supports the improvement of hospitality services, local products, entrepreneurship, and sustainable tourism practices through research, technology, training, and collaborative partnerships. It contributes to local economic development by enhancing the competitiveness of tourism enterprises and community-based industries.',
        sdgs: [
            'SDG 1 – No Poverty',
            'SDG 4 – Quality Education',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 11 – Sustainable Cities and Communities',
            'SDG 12 – Responsible Consumption and Production',
            'SDG 13 – Climate Action',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Center of Research for Aquamarine Life Sustainability',
        acronym: 'CoRALS',
        campus: 'Lianga Campus',
        established: 'December 19, 2023',
        summary:
            'CoRALS conducts research on aquasilviculture, marine biodiversity, fish health, hatchery technologies, and integrated coastal resource management to promote sustainable fisheries and marine ecosystem conservation. The center develops innovative technologies and scientific knowledge that improve aquaculture productivity, strengthen food security, enhance climate resilience, and support the sustainable management of coastal and marine resources.',
        sdgs: [
            'SDG 2 – Zero Hunger',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 12 – Responsible Consumption and Production',
            'SDG 13 – Climate Action',
            'SDG 14 – Life Below Water',
            'SDG 15 – Life on Land',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Center for Aquasilviculture and Seaweed Advancement',
        acronym: 'AQUASEA',
        campus: 'Lianga Campus',
        established: 'October 14, 2025',
        summary:
            'AQUASEA serves as an interdisciplinary research center dedicated to aquasilviculture, seaweed development, mangrove restoration, and coastal ecosystem management. It integrates research, innovation, extension, and policy support to promote biodiversity conservation, blue economy initiatives, climate resilience, and sustainable livelihoods for coastal communities through science-based and community-centered solutions.',
        sdgs: [
            'SDG 1 – No Poverty',
            'SDG 2 – Zero Hunger',
            'SDG 4 – Quality Education',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 13 – Climate Action',
            'SDG 14 – Life Below Water',
            'SDG 15 – Life on Land',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Food and Farming Technology Research Center',
        acronym: 'FFTRC',
        campus: 'Tagbina Campus',
        established: 'December 19, 2023',
        summary:
            'FFTRC promotes research and technology development that improve agricultural productivity, food innovation, value addition, and sustainable farming systems. The center supports farmers through studies on modern agricultural technologies, digitalization, food security, climate resilience, and circular economy practices while strengthening partnerships that enhance rural livelihoods and regional agricultural development.',
        sdgs: [
            'SDG 1 – No Poverty',
            'SDG 2 – Zero Hunger',
            'SDG 4 – Quality Education',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 12 – Responsible Consumption and Production',
            'SDG 13 – Climate Action',
            'SDG 17 – Partnerships for the Goals',
        ],
    },
    {
        name: 'Agro-Forestry Industrial Research Center',
        acronym: 'AFIRC',
        campus: 'Bislig Campus',
        established: 'December 19, 2023',
        summary:
            'AFIRC advances research on agroforestry, sustainable natural resource management, and agro-industrial innovation to support resilient economic development and environmental conservation. It promotes the sustainable utilization of forest, agricultural, and coastal resources through technology development, industry collaboration, and community engagement while contributing to green growth and regional competitiveness.',
        sdgs: [
            'SDG 4 – Quality Education',
            'SDG 7 – Affordable and Clean Energy',
            'SDG 8 – Decent Work and Economic Growth',
            'SDG 9 – Industry, Innovation, and Infrastructure',
            'SDG 11 – Sustainable Cities and Communities',
            'SDG 12 – Responsible Consumption and Production',
            'SDG 13 – Climate Action',
            'SDG 15 – Life on Land',
            'SDG 17 – Partnerships for the Goals',
        ],
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
const expandedSummaries = ref<Record<string, boolean>>({});

const toggleSummary = (acronym: string) => {
    expandedSummaries.value[acronym] = !expandedSummaries.value[acronym];
};

const isExpanded = (acronym: string): boolean => {
    return !!expandedSummaries.value[acronym];
};

type SdgInfo = {
    number: number;
    name: string;
    image: string;
};

const SDG_DIRECTORY: Record<number, { name: string }> = {
    1: { name: 'No Poverty' },
    2: { name: 'Zero Hunger' },
    3: { name: 'Good Health and Well-being' },
    4: { name: 'Quality Education' },
    5: { name: 'Gender Equality' },
    6: { name: 'Clean Water and Sanitation' },
    7: { name: 'Affordable and Clean Energy' },
    8: { name: 'Decent Work and Economic Growth' },
    9: { name: 'Industry, Innovation, and Infrastructure' },
    10: { name: 'Reduced Inequalities' },
    11: { name: 'Sustainable Cities and Communities' },
    12: { name: 'Responsible Consumption and Production' },
    13: { name: 'Climate Action' },
    14: { name: 'Life Below Water' },
    15: { name: 'Life on Land' },
    16: { name: 'Peace, Justice and Strong Institutions' },
    17: { name: 'Partnerships for the Goals' },
};

const getCenterSdgs = (sdgStrings: string[]): SdgInfo[] => {
    return sdgStrings
        .map((str) => {
            const match = str.match(/SDG\s*(\d+)/i);
            if (!match) return null;
            const num = parseInt(match[1], 10);
            const info = SDG_DIRECTORY[num];
            if (!info) return null;
            const padded = String(num).padStart(2, '0');
            return {
                number: num,
                name: info.name,
                image: `/images/administration/ovprie/research/sdgs/E-WEB-Goal-${padded}.png`,
            };
        })
        .filter((item): item is SdgInfo => item !== null)
        .sort((a, b) => a.number - b.number);
};

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
        const q = searchQuery.value.trim().toLowerCase();
        const matchesSearch =
            q === '' ||
            center.name.toLowerCase().includes(q) ||
            center.acronym.toLowerCase().includes(q) ||
            center.summary.toLowerCase().includes(q) ||
            center.campus.toLowerCase().includes(q) ||
            center.sdgs.some((sdg) => sdg.toLowerCase().includes(q));

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
                                <div class="mt-3 flex flex-col gap-2">
                                    <a
                                        :href="`mailto:${director.email}`"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] transition hover:underline dark:text-sky-200"
                                    >
                                        <Mail class="size-4 shrink-0" aria-hidden="true" />
                                        <span>{{ director.email }}</span>
                                    </a>
                                    <div
                                        v-if="director.address"
                                        class="inline-flex items-start gap-2 text-xs leading-relaxed text-slate-600 dark:text-slate-300"
                                    >
                                        <MapPin class="mt-0.5 size-4 shrink-0 text-slate-400 dark:text-slate-500" aria-hidden="true" />
                                        <span>{{ director.address }}</span>
                                    </div>
                                </div>
                            </div>
                        </aside>

                        <!-- Centers Content & Grid -->
                        <div>
                            <!-- Service Overview -->
                            <div>
                                <p
                                    class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                >
                                    Research Centers
                                </p>
                                <h3
                                    class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                                >
                                    Service Overview
                                </h3>
                                <p
                                    class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                                >
                                    {{ director.summary }}
                                </p>
                            </div>

                            <!-- Search and Campus Filter Controls -->
                            <div class="mt-10 space-y-4">
                                <div class="relative w-full">
                                    <Search
                                        class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"
                                        aria-hidden="true"
                                    />
                                    <input
                                        v-model="searchQuery"
                                        type="search"
                                        placeholder="Search center by name, acronym, campus, or SDG (e.g. SDG 4, Climate)..."
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
                                            <!-- Top Bar: Campus -->
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

                                            <!-- Summary with See more / See less -->
                                            <div class="mt-4">
                                                <p
                                                    class="text-sm leading-relaxed text-slate-600 transition-all dark:text-slate-300"
                                                    :class="isExpanded(center.acronym) ? '' : 'line-clamp-3'"
                                                >
                                                    {{ center.summary }}
                                                </p>
                                                <button
                                                    v-if="center.summary.length > 150"
                                                    type="button"
                                                    @click="toggleSummary(center.acronym)"
                                                    class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-[#1711d4] hover:underline cursor-pointer dark:text-sky-300"
                                                >
                                                    <span>{{ isExpanded(center.acronym) ? 'See less' : 'See more' }}</span>
                                                    <ChevronUp v-if="isExpanded(center.acronym)" class="size-3.5" aria-hidden="true" />
                                                    <ChevronDown v-else class="size-3.5" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Addressed SDGs (Official Badges) -->
                                        <div
                                            v-if="center.sdgs && center.sdgs.length > 0"
                                            class="mt-6 border-t border-slate-100 pt-4 dark:border-white/10"
                                        >
                                            <div class="flex items-center justify-between gap-2">
                                                <p
                                                    class="text-[0.7rem] font-bold tracking-wider text-slate-400 uppercase dark:text-slate-500"
                                                >
                                                    Addressed SDGs
                                                </p>
                                                <!-- <span class="text-[0.65rem] font-medium text-slate-400 dark:text-slate-500">
                                                    {{ getCenterSdgs(center.sdgs).length }} Goals
                                                </span> -->
                                            </div>
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                <div
                                                    v-for="sdg in getCenterSdgs(center.sdgs)"
                                                    :key="sdg.number"
                                                    class="group/sdg relative flex aspect-square w-12 sm:w-14 shrink-0 items-center justify-center overflow-hidden rounded-md shadow-xs transition-all duration-200 hover:-translate-y-1 hover:scale-105 hover:shadow-md hover:z-20 cursor-default select-none bg-slate-100 dark:bg-slate-800"
                                                    :aria-label="`SDG ${sdg.number}: ${sdg.name}`"
                                                >
                                                    <img
                                                        :src="sdg.image"
                                                        :alt="`SDG ${sdg.number}: ${sdg.name}`"
                                                        class="h-full w-full object-cover"
                                                        loading="lazy"
                                                    />

                                                    <!-- Tooltip on hover -->
                                                    <div
                                                        class="pointer-events-none absolute bottom-full left-1/2 mb-1.5 -translate-x-1/2 opacity-0 transition-opacity duration-200 group-hover/sdg:opacity-100 z-30 whitespace-nowrap rounded-md bg-slate-950 px-2.5 py-1 text-xs font-medium text-white shadow-xl ring-1 ring-white/20 dark:bg-slate-900"
                                                    >
                                                        <span class="font-bold text-[#f2b705]">SDG {{ sdg.number }}:</span>
                                                        {{ sdg.name }}
                                                    </div>
                                                </div>
                                            </div>
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
