<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PageHero from '@/components/PageHero.vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';

const heroBackgroundImage = '/storage/images/hero/6I3A5797.JPG';
import {
    Landmark,
    ChevronDown,
    Image as ImageIcon,
} from 'lucide-vue-next';

type AgendaItem = {
    number: string;
    title: string;
    summary: string;
    goals: string[];
    actions: string[];
};

const agendaItems: AgendaItem[] = [
    {
        number: '01',
        title: 'Industry- and Commercially-Driven Research and Innovation',
        summary:
            'Advance research and innovation in regional industries, food systems, climate resilience, public health, and poverty reduction.',
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
        title: 'Transformative Education and Excellence in Teaching and Learning',
        summary:
            'Develop innovative, research-oriented, and future-ready academic programs that prepare learners for employment and enterprise.',
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
        title: 'Technology- and Entrepreneurship-Driven Production',
        summary:
            'Transform university assets, industry partnerships, technology incubation, and research outputs into sustainable products and services.',
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
        title: 'Market-Oriented Extension and Inclusive Public Service',
        summary:
            'Deliver responsive extension programs through research application, technology transfer, entrepreneurship, and community partnership.',
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
        title: 'Vibrant and Equitable Faculty and Staff Development',
        summary:
            'Build a capable, supported, globally engaged, and future-ready academic and administrative workforce.',
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
        title: 'Accessible and Client-Focused Student Services',
        summary:
            'Provide inclusive, responsive, and holistic services that promote student well-being, development, and success.',
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
        title: 'Client-Centered, Transparent, and Efficient Governance',
        summary:
            'Strengthen institutional governance through digital transformation, responsive systems, fiscal sustainability, and resilient infrastructure.',
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
        title: 'Knowledge-Sharing and Skills-Driven Internationalization',
        summary:
            'Expand international learning, mobility, collaboration, and quality assurance to prepare globally competitive graduates and personnel.',
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
        <Head title="Strategic Development Agenda" />

        <main class="bg-white font-sans text-slate-950 dark:bg-slate-950 dark:text-white">
            <PageHero
                title="Strategic Development Agenda"
                kicker=""
                description="The Eight-Point INNOVATE Agenda provides the strategic framework for strengthening NEMSU's academic excellence, research impact, public service, institutional governance, and global engagement."
                :breadcrumbs="[
                    { title: 'Home', href: home().url },
                    { title: 'About NEMSU' },
                    { title: 'Strategic Development Agenda' }
                ]"
                :backgroundImage="heroBackgroundImage"
            />

            <!-- Transforming NEMSU -->
            <section class="border-b border-slate-200 dark:border-white/10">
                <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                    <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl dark:text-white">
                                Transforming NEMSU through the INNOVATE Agenda
                            </h2>
                            <p class="mt-6 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                Under the leadership of University President Prof. Nemesio G. Loayon, NEMSU advances a transformative development agenda that builds on the strengths of its academic and administrative community.
                            </p>
                            <p class="mt-4 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                The agenda responds to national and regional priorities through research and innovation, quality education, enterprise development, inclusive public service, employee development, student support, responsive governance, and international engagement.
                            </p>
                        </div>
                        <div class="aspect-[16/9] w-full rounded-md bg-slate-100 flex items-center justify-center border border-slate-200 dark:bg-slate-800 dark:border-white/10">
                            <ImageIcon class="h-16 w-16 text-slate-300 dark:text-slate-600" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- Agenda Grid -->
            <section class="bg-slate-50 dark:bg-slate-900/30">
                <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                    <div class="text-center max-w-3xl mx-auto">
                        <h2 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl dark:text-white">
                            Eight-Point INNOVATE Agenda
                        </h2>
                        <p class="mt-4 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                            The Eight-Point INNOVATE Agenda defines the University's strategic direction and guides the alignment of its academic, research, extension, administrative, and internationalization initiatives.
                        </p>
                        <p class="mt-4 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                            It is organized around eight interconnected development priorities designed to strengthen institutional performance and increase NEMSU's contribution to regional and national development.
                        </p>
                    </div>

                    <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div v-for="item in agendaItems" :key="item.number" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col dark:border-white/10 dark:bg-slate-900">
                            <div class="flex items-center gap-4">
                                <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ item.number }}</span>
                            </div>
                            <h3 class="mt-6 text-sm font-bold leading-snug text-slate-950 dark:text-white">
                                {{ item.title }}
                            </h3>
                            <p class="mt-3 text-xs leading-relaxed text-slate-600 dark:text-slate-400 flex-grow">
                                {{ item.summary }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Strategic Goals Accordion -->
            <section class="border-t border-slate-200 dark:border-white/10">
                <div class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                    <div class="text-center mb-12">
                        <h2 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl dark:text-white">
                            Strategic Goals and Priority Actions
                        </h2>
                        <p class="mt-4 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                            The following sections present the strategic goals and corresponding implementation actions for each agenda item.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <details v-for="item in agendaItems" :key="`accordion-${item.number}`" class="group rounded-lg border border-slate-200 bg-white dark:border-white/10 dark:bg-slate-900 [&_summary::-webkit-details-marker]:hidden">
                            <summary class="flex cursor-pointer items-center justify-between gap-4 p-4 text-slate-950 dark:text-white hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors rounded-lg">
                                <div class="flex items-center gap-4 sm:gap-6 flex-1">
                                    <span class="text-lg font-bold text-slate-900 dark:text-white w-6 text-center">{{ item.number }}</span>
                                    <div class="flex flex-col flex-1 min-w-0">
                                        <span class="text-sm font-bold truncate">{{ item.title }}</span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400 truncate hidden sm:block mt-0.5">{{ item.summary }}</span>
                                    </div>
                                </div>
                                <span class="transition-transform duration-200 group-open:rotate-180 shrink-0">
                                    <ChevronDown class="h-5 w-5 text-slate-400" />
                                </span>
                            </summary>
                            <div class="border-t border-slate-200 p-6 dark:border-white/10">
                                <div class="grid gap-8 sm:grid-cols-2">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Strategic Goals</h4>
                                        <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-300">
                                            <li v-for="(goal, idx) in item.goals" :key="idx" class="flex gap-2">
                                                <span class="font-bold text-slate-400 shrink-0 mt-0.5">{{ idx + 1 }}.</span>
                                                <span class="leading-relaxed">{{ goal }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Implementation Actions</h4>
                                        <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-300">
                                            <li v-for="(action, idx) in item.actions" :key="idx" class="flex gap-2">
                                                <span class="font-bold text-slate-400 shrink-0 mt-0.5">{{ idx + 1 }}.</span>
                                                <span class="leading-relaxed">{{ action }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </details>
                    </div>
                </div>
            </section>

            <!-- Commitment Footer -->
            <section class="border-t border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-900/30">
                <div class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                    <div class="rounded-xl border border-slate-200 bg-white p-8 sm:p-10 shadow-sm dark:border-white/10 dark:bg-slate-900">
                        <div class="grid gap-10 sm:grid-cols-2 sm:items-center">
                            <div class="flex flex-col gap-6">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white dark:border-white/10 dark:bg-slate-800">
                                    <Landmark class="h-6 w-6 text-slate-700 dark:text-slate-300" />
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold tracking-tight text-slate-950 dark:text-white">
                                        Our Commitment
                                    </h2>
                                    <p class="mt-3 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                        Through the INNOVATE Agenda, NEMSU reaffirms its commitment to academic excellence, institutional integrity, inclusive development, and national and global competitiveness.
                                    </p>
                                </div>
                            </div>
                            <div class="aspect-[4/3] w-full rounded-md bg-slate-100 flex items-center justify-center border border-slate-200 dark:bg-slate-800 dark:border-white/10">
                                <ImageIcon class="h-16 w-16 text-slate-300 dark:text-slate-600" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>