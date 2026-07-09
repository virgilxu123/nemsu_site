<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import type { BreadcrumbItem } from '@/types';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Home', href: '/' },
    { title: 'About Us', href: '/about/university' },
    { title: 'INNOVATE Agenda', href: '/about/innovate-agenda' },
];

type AgendaItem = {
    number: string;
    title: string;
    summary: string;
    goals: string[];
    actions: string[];
};

const pageIntro =
    "Prof. Loayon's administration proposes transformative strategies aligned with the strengths of the NEMSU Academic and Administrative community and anchored on the needs and demands of the country.";

const agendaItems: AgendaItem[] = [
    {
        number: '01',
        title: 'Industry and commercially-driven research and innovation',
        summary:
            'Position research around regional industries, food systems, climate resilience, and poverty alleviation.',
        goals: [
            'Generate research and innovations focused on disaster resilience, crisis-oriented, and climate-adaptive industries in Fishery, Agri-forestry, Mining, Eco-Tourism, FAME, health services, food security, and poverty alleviation.',
            'Produce branches of artistic and scientific knowledge, intellectual property, or technological invention to hone the ecology of innovation among governance, human capital, natural resources, techno-scientific infrastructures, and environmental management standards.',
            'Upscale human capital and change-dynamic mechanisms for social legislation strategists, public administrators, community-sectoral and industry leaders to promote inclusive development and programs.',
        ],
        actions: [
            'Implement interdisciplinary research programs addressing pressing gaps in FAME, health services, food security, poverty alleviation, renewable energy, environmental conservation, climate change, and disaster preparedness.',
            'Intensify capacity building of researchers and innovators to establish research partnerships with leading universities in the country and abroad.',
            'Establish Technology Business Incubation and Food Innovation Centers to support start-up products, spin-off companies, and agri-business innovation.',
            'Establish research centers across campuses, including industrial park, teaching excellence, agriculture, tourism, marine, food technology, and forestry innovation centers.',
        ],
    },
    {
        number: '02',
        title: 'Transformative education and excellence in teaching and learning',
        summary:
            'Educate students through innovation, research, extension, and future-ready academic programs.',
        goals: [
            'Educate and train students to sharpen innovative mindset, systematic thinking, collective attitude as researchers, adaptors, agents, and enablers of innovative start-ups and business incubation projects.',
            'Train students to become research-skilled and future-ready graduates whose psychosocial characters do not search for employment opportunities but create livelihood and business opportunities.',
            'Serve as convener, agent, and enabler in building and promoting disaster-resilient, crisis-oriented, and climate-adaptive economy.',
        ],
        actions: [
            'Recalibrate curricular programs and institutionalize research-based innovation-led instruction.',
            'Modernize classroom buildings, information technology gadgets, laboratories, libraries, learning commons, workshops, and simulation rooms.',
            'Introduce multiple learning delivery modes for optimum learning outcomes and research excellence.',
            'Develop a practical model for learning assessment and competency-based competitiveness for employment and livelihood opportunities.',
            'Subject academic programs ready for CHED recognition as COD/COE and intensify licensure exam review for high passing percentage.',
        ],
    },
    {
        number: '03',
        title: 'Innovative Technology and entrepreneurial driven-production',
        summary:
            'Use land assets, industry partnerships, and technology incubation to generate products and services.',
        goals: [
            'Maximize land areas of the University as potential for joint and feasible revenue-generating and livelihood multiplying enterprises under Public Private Partnership developers and innovators engagement.',
            'Establish FAME enterprise competitiveness policy and research centers to mark all research-based and knowledge-driven products and services.',
            'Increase the commercial activities among campuses in support of instruction, research, and extension functions of the University.',
        ],
        actions: [
            'Establish strong linkages and networking with the government, academe, industries, and communities to maximize entrepreneurial, technological, and innovative ecosystem of the University.',
            'Revisit the resource generation manual to scale up resource generation initiatives, investments, entrepreneurship, and fiscal autonomy.',
            'Establish Technology Business Incubation and startup enterprise supported by simulation and business models with hands-on experience.',
        ],
    },
    {
        number: '04',
        title: 'Market-oriented extension and inclusive public service',
        summary:
            'Mobilize selected faculty, research and extension staff, and students for public project modeling.',
        goals: [
            'Organize, train, and mobilize selected faculty fellows, research and extension staff, and students to serve as social technocrats in the conduct of the University extension services to its partner institutions and beneficiaries.',
            'Forge partnerships with communities as strategic growth poles for pilot project modeling.',
        ],
        actions: [
            'Design pragmatic extension services grounded on research engagement, technology transfer, entrepreneurship, and social responsibility.',
            'Establish strong linkages and networking industries locally and internationally.',
            'Strengthen alliance with Philippine Exclusive Economic Zone for Filipino professionals and exclusive economic zone.',
            'Intensify knowledge sharing and technology transfer to recipients and beneficiaries.',
            'Monitor, assist, and supervise project implementation to ensure progress and sustainability.',
        ],
    },
    {
        number: '05',
        title: 'Vibrant and equitable Faculty and Staff development programs',
        summary:
            'Create a globally engaged and impactful faculty and staff development program.',
        goals: [
            'Institutionalized and globally-engaged an impactful faculty and staff development program.',
        ],
        actions: [
            'Strengthened faculty and staff mobility.',
            'Well-funded institution and externally institutionalized succession plan with sound benefits and compensation.',
        ],
    },
    {
        number: '06',
        title: 'Accessible and client-focused student services',
        summary:
            'Strengthen holistic student services and essential student support facilities.',
        goals: [
            'Comprehensive student services that propel the holistic development of the learners.',
        ],
        actions: [
            'Institutionalize the Campus Ministers per Campuses of the University.',
            'Provide workspace, dormitories, student center, sports and recreation center, learning commons, multi-faith center, and campus security technology.',
        ],
    },
    {
        number: '07',
        title: 'Client-centered, transparent, and efficient governance',
        summary:
            'Modernize governance through smart systems, disaster resilience, and digital transformation.',
        goals: [
            'Establish NEMSU as a Smart University with digitalized disaster-resilient infrastructure, facilities, and governance technology-enabled governance.',
        ],
        actions: [
            'Strengthen resource generation and adequate fiscal space for governance and support operations.',
            'Accelerate digital transformation and automation of transactions.',
            'Implement physical and infrastructure development plan reflected in the LUDIP.',
        ],
    },
    {
        number: '08',
        title: 'Knowledge-sharing and skills-driven internationalization programs',
        summary:
            'Prepare globally competitive graduates through international mobility and quality assurance.',
        goals: ['Produce globally competitive graduates.'],
        actions: [
            'International curriculum and quality assurance for globally competitive education.',
            'Identify international mobility of student and faculty mobility and knowledge-based economy.',
        ],
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="INNOVATE Agenda" />

        <main class="bg-white font-sans text-slate-950 dark:bg-slate-950 dark:text-white">
            <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>

            <!-- Page Header -->
            <section class="border-b border-slate-200 dark:border-white/10">
                <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
                    <div class="max-w-4xl">
                        <h1
                            class="text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl dark:text-white"
                        >
                            INNOVATE Agenda
                        </h1>

                        <p
                            class="mt-5 max-w-3xl text-lg font-medium leading-8 text-slate-800 sm:text-xl dark:text-slate-100"
                        >
                            Strategic Development Agenda of North Eastern
                            Mindanao State University
                        </p>

                        <p
                            class="mt-6 max-w-3xl text-base leading-8 text-slate-600 dark:text-slate-300"
                        >
                            {{ pageIntro }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- Agenda Index -->
            <section class="border-b border-slate-200 dark:border-white/10">
                <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <h2
                            class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl dark:text-white"
                        >
                            Eight-Point INNOVATE Agenda
                        </h2>

                        <p
                            class="mt-4 text-base leading-8 text-slate-600 dark:text-slate-300"
                        >
                            The agenda sets the University’s institutional
                            direction through eight areas of development,
                            covering research, instruction, enterprise,
                            extension, faculty and staff development, student
                            services, governance, and internationalization.
                        </p>
                    </div>

                    <ol class="mt-10 divide-y divide-slate-200 border-y border-slate-200 dark:divide-white/10 dark:border-white/10">
                        <li
                            v-for="item in agendaItems"
                            :key="item.number"
                            class="group"
                        >
                            <a
                                :href="`#agenda-${item.number}`"
                                class="grid gap-4 py-6 transition hover:bg-slate-50 sm:grid-cols-[6rem_1fr] sm:px-4 dark:hover:bg-white/[0.03]"
                                :aria-label="`Go to agenda ${item.number}: ${item.title}`"
                            >
                                <div
                                    class="text-sm font-semibold tracking-wide text-slate-500 dark:text-slate-400"
                                >
                                    {{ item.number }}
                                </div>

                                <div>
                                    <h3
                                        class="text-lg font-semibold leading-snug text-slate-950 dark:text-white"
                                    >
                                        {{ item.title }}
                                    </h3>

                                    <p
                                        class="mt-2 max-w-3xl text-sm leading-7 text-slate-600 dark:text-slate-400"
                                    >
                                        {{ item.summary }}
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ol>
                </div>
            </section>

            <!-- Agenda Details -->
            <section class="py-12 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <h2
                            class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl dark:text-white"
                        >
                            Strategic Goals and Implementation Actions
                        </h2>

                        <p
                            class="mt-4 text-base leading-8 text-slate-600 dark:text-slate-300"
                        >
                            The following sections present the strategic goals
                            and corresponding implementation actions for each
                            agenda item.
                        </p>
                    </div>

                    <div class="mt-10 space-y-14">
                        <article
                            v-for="item in agendaItems"
                            :id="`agenda-${item.number}`"
                            :key="item.number"
                            class="scroll-mt-28 border-t border-slate-300 pt-10 dark:border-white/15"
                        >
                            <header class="max-w-4xl">
                                <p
                                    class="text-sm font-semibold tracking-wide text-slate-500 dark:text-slate-400"
                                >
                                    Agenda {{ item.number }}
                                </p>

                                <h3
                                    class="mt-2 text-2xl font-semibold leading-tight tracking-tight text-slate-950 sm:text-3xl dark:text-white"
                                >
                                    {{ item.title }}
                                </h3>

                                <p
                                    class="mt-4 max-w-3xl text-base leading-8 text-slate-600 dark:text-slate-300"
                                >
                                    {{ item.summary }}
                                </p>
                            </header>

                            <div
                                class="mt-8 grid gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]"
                            >
                                <section
                                    :aria-labelledby="`goals-heading-${item.number}`"
                                >
                                    <h4
                                        :id="`goals-heading-${item.number}`"
                                        class="border-b border-slate-200 pb-3 text-base font-semibold text-slate-950 dark:border-white/10 dark:text-white"
                                    >
                                        Strategic Goals
                                    </h4>

                                    <ol class="mt-5 space-y-4">
                                        <li
                                            v-for="(goal, index) in item.goals"
                                            :key="index"
                                            class="grid grid-cols-[2rem_1fr] gap-3 text-sm leading-7 text-slate-700 dark:text-slate-300"
                                        >
                                            <span
                                                class="font-semibold text-slate-400 dark:text-slate-500"
                                            >
                                                {{ index + 1 }}.
                                            </span>

                                            <span>
                                                {{ goal }}
                                            </span>
                                        </li>
                                    </ol>
                                </section>

                                <section
                                    :aria-labelledby="`actions-heading-${item.number}`"
                                >
                                    <h4
                                        :id="`actions-heading-${item.number}`"
                                        class="border-b border-slate-200 pb-3 text-base font-semibold text-slate-950 dark:border-white/10 dark:text-white"
                                    >
                                        Implementation Actions
                                    </h4>

                                    <ol class="mt-5 space-y-4">
                                        <li
                                            v-for="(action, index) in item.actions"
                                            :key="index"
                                            class="grid grid-cols-[2rem_1fr] gap-3 text-sm leading-7 text-slate-700 dark:text-slate-300"
                                        >
                                            <span
                                                class="font-semibold text-slate-400 dark:text-slate-500"
                                            >
                                                {{ index + 1 }}.
                                            </span>

                                            <span>
                                                {{ action }}
                                            </span>
                                        </li>
                                    </ol>
                                </section>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>