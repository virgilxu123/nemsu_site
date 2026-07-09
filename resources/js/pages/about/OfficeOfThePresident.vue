<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BadgeCheck,
    BookOpen,
    Building2,
    CalendarDays,
    FileText,
    GraduationCap,
    Images,
    Landmark,
    Lightbulb,
    Map,
    Megaphone,
    Newspaper,
    Quote,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import type { Component, CSSProperties } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { index as newsIndex, show as newsShow } from '@/routes/news';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type ContentBlock = {
    id: string;
    label: string;
    title: string;
    body: string;
    icon: Component;
};

type AgendaItem = {
    number: string;
    title: string;
    summary: string;
    icon: Component;
    goals: string[];
    actions: string[];
};

type NewsItem = {
    id: string;
    title: string;
    slug: string;
    excerpt?: string | null;
    date: string | null;
    office: string;
    photoUrl?: string | null;
};

type GalleryPhoto = {
    src: string;
    alt: string;
    caption: string;
};

defineProps<{
    pressReleases: NewsItem[];
}>();

const nemsuSeal = 'https://nemsu.edu.ph/assets/images/NEMSU.png';
const presidentPhoto = 'https://www.nemsu.edu.ph/assets/bor/2.png';
const campusImage = 'https://nemsu.edu.ph/files/News/cm-00.jpg';

const presidentGallery: GalleryPhoto[] = [
    {
        src: 'https://nemsu.edu.ph/files/News/Project-Culmination-banner-00.jpg',
        alt: 'President Nemesio G. Loayon at a NEMSU community project',
        caption: 'Advancing sustainable livelihoods and marine conservation',
    },
    {
        src: 'https://nemsu.edu.ph/files/News/650x600-Banner-Bagong-Pilipinas.png',
        alt: 'President Nemesio G. Loayon during a university flag ceremony',
        caption: 'Leading the University community in public service',
    },
    {
        src: 'https://nemsu.edu.ph/files/News/up-00.jpg',
        alt: 'President Nemesio G. Loayon with higher education leaders',
        caption: 'Building partnerships for excellence and equity',
    },
    {
        src: 'https://nemsu.edu.ph/files/News/Flag-20202300.png',
        alt: 'President Nemesio G. Loayon addressing the NEMSU community',
        caption:
            'Sharing the University’s direction with the academic community',
    },
];

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['president-hero']));

let revealObserver: IntersectionObserver | null = null;

const setSectionVisibility = (section: string, isVisible: boolean): void => {
    const nextVisibleSections = new Set(visibleSections.value);

    if (isVisible) {
        nextVisibleSections.add(section);
    } else {
        nextVisibleSections.delete(section);
    }

    visibleSections.value = nextVisibleSections;
};

const isSectionVisible = (section: string): boolean =>
    visibleSections.value.has(section);

const revealClasses = (
    section: string,
    direction: RevealDirection = 'up',
): string =>
    [
        'transition-all duration-700 ease-out will-change-transform motion-reduce:translate-x-0 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:blur-0 motion-reduce:transition-none',
        isSectionVisible(section)
            ? 'translate-x-0 translate-y-0 opacity-100 blur-0'
            : `${revealOffset[direction]} opacity-0 blur-[2px]`,
    ].join(' ');

const heroBackground = (image: string): CSSProperties => ({
    backgroundImage: `linear-gradient(105deg, rgba(23,17,212,.96), rgba(13,57,118,.9) 48%, rgba(8,21,55,.76)), url("${image}")`,
});

const contentBlocks: ContentBlock[] = [
    {
        id: 'bio-note',
        label: 'Bio Note',
        title: 'A professor, researcher, and administrator in public service',
        body: 'Dr. Nemesio G. Loayon is a professor of Education specializing in Education Administration and the 4th University President of NEMSU Tandag. In more than three decades of service, his experiences molded him to become a multifaceted academician, researcher, and administrator equipped with a dedication to public service.',
        icon: Landmark,
    },
];

const agendaItems: AgendaItem[] = [
    {
        number: '01',
        title: 'Industry and commercially-driven research and innovation',
        summary:
            'Position research around regional industries, food systems, climate resilience, and poverty alleviation.',
        icon: Lightbulb,
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
        icon: GraduationCap,
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
        icon: Building2,
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
        icon: Megaphone,
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
        icon: BookOpen,
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
        icon: BadgeCheck,
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
        icon: Landmark,
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
        icon: Map,
        goals: ['Produce globally competitive graduates.'],
        actions: [
            'International curriculum and quality assurance for globally competitive education.',
            'Identify international mobility of student and faculty mobility and knowledge-based economy.',
        ],
    },
];

onMounted(() => {
    const animatedSections = document.querySelectorAll<HTMLElement>(
        '[data-scroll-section]',
    );
    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;

    if (prefersReducedMotion) {
        visibleSections.value = new Set(
            Array.from(animatedSections)
                .map((section) => section.dataset.scrollSection)
                .filter(Boolean) as string[],
        );

        return;
    }

    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const section = entry.target.getAttribute(
                    'data-scroll-section',
                );

                if (section) {
                    setSectionVisibility(section, entry.isIntersecting);
                }
            });
        },
        {
            rootMargin: '0px',
            threshold: 0.1,
        },
    );

    animatedSections.forEach((section) => {
        revealObserver?.observe(section);
    });
});

onBeforeUnmount(() => {
    revealObserver?.disconnect();
});
</script>

<template>
    <PublicSiteLayout>
        <Head title="Office of the President" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate overflow-hidden bg-[#1711d4] py-14 text-white sm:py-16 lg:py-20"
                :style="heroBackground(campusImage)"
            >
                <div
                    class="absolute inset-y-0 left-0 -z-10 hidden w-1/2 -skew-x-12 bg-[#0b2f78]/60 lg:block"
                ></div>
                <img
                    :src="nemsuSeal"
                    alt=""
                    class="pointer-events-none absolute right-[-5rem] bottom-[-6rem] z-0 size-80 object-contain opacity-[0.055] sm:size-96 lg:size-[30rem]"
                    aria-hidden="true"
                />

                <div
                    data-scroll-section="president-hero"
                    :class="revealClasses('president-hero')"
                    class="relative z-10 mx-auto grid max-w-7xl items-center gap-8 px-4 sm:px-6 lg:grid-cols-[22rem_minmax(0,1fr)] lg:px-8"
                >
                    <div class="mx-auto w-56 sm:w-72 lg:w-80">
                        <div
                            class="relative aspect-square overflow-hidden rounded-full border-[8px] border-white bg-white shadow-2xl ring-4 shadow-slate-950/25 ring-[#0b3d91]"
                        >
                            <img
                                :src="presidentPhoto"
                                alt="Dr. Nemesio G. Loayon"
                                class="h-full w-full object-cover object-top"
                            />
                        </div>
                        <p
                            class="mt-4 text-center text-xs font-semibold tracking-wide text-sky-100 uppercase"
                        >
                            Current official portrait
                        </p>
                    </div>

                    <div class="text-center lg:text-left">
                        <p
                            class="inline-flex rounded bg-white/10 px-3 py-1 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                        >
                            Office of the President
                        </p>
                        <h1
                            class="mt-5 text-4xl font-semibold tracking-normal text-white sm:text-5xl lg:text-6xl"
                        >
                            Dr. Nemesio G. Loayon
                        </h1>
                        <p class="mt-3 text-xl text-sky-100 sm:text-2xl">
                            SUC President III
                        </p>
                        <div
                            class="mx-auto mt-8 grid max-w-2xl gap-3 sm:grid-cols-3 lg:mx-0"
                        >
                            <a
                                href="#presidents-message"
                                class="rounded-md border border-white/15 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-[#1711d4]"
                            >
                                President's Message
                            </a>
                            <a
                                href="#executive-corner"
                                class="rounded-md border border-white/15 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-[#1711d4]"
                            >
                                Executive Corner
                            </a>
                            <a
                                href="#innovate-agenda"
                                class="rounded-md border border-white/15 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-[#1711d4]"
                            >
                                INNOVATE Agenda
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section
                id="presidents-message"
                class="scroll-mt-28 border-b border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div
                    data-scroll-section="presidents-message"
                    :class="revealClasses('presidents-message', 'right')"
                    class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:px-8"
                >
                    <div
                        class="flex min-h-52 items-center justify-center rounded-md bg-[#1711d4] p-8 text-white shadow-xl shadow-[#1711d4]/15"
                    >
                        <div class="text-center">
                            <Quote
                                class="mx-auto size-12 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            <p
                                class="mt-5 text-sm font-semibold tracking-wide uppercase"
                            >
                                President's Message
                            </p>
                        </div>
                    </div>

                    <div class="self-center">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            From the University President
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Innovation with purpose, public service with impact
                        </h2>
                        <p
                            class="mt-5 text-base leading-8 text-slate-700 dark:text-slate-300"
                        >
                            NEMSU moves forward as one academic
                            community—grounded in responsive research, excellent
                            instruction, and technology-driven extension. Our
                            shared work is to create opportunities, strengthen
                            our communities, and shape a sustainable future for
                            Northeastern Mindanao.
                        </p>
                        <p
                            class="mt-5 font-semibold text-[#1711d4] dark:text-sky-200"
                        >
                            Dr. Nemesio G. Loayon, SUC President III
                        </p>
                    </div>
                </div>
            </section>

            <section class="relative isolate py-14 sm:py-16">
                <div class="mx-auto grid max-w-7xl gap-5 px-4 sm:px-6 lg:px-8">
                    <article
                        v-for="(block, index) in contentBlocks"
                        :id="block.id"
                        :key="block.id"
                        :data-scroll-section="`president-content-${index}`"
                        :class="
                            revealClasses(
                                `president-content-${index}`,
                                index % 2 === 0 ? 'right' : 'left',
                            )
                        "
                        class="scroll-mt-28 rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                    >
                        <div class="grid gap-5 lg:grid-cols-[17rem_1fr]">
                            <div
                                class="flex items-center gap-4 rounded-md bg-[#e7f3fb] p-4 text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <span
                                    class="inline-flex size-11 shrink-0 items-center justify-center rounded-md bg-white shadow-sm dark:bg-white/10"
                                >
                                    <component
                                        :is="block.icon"
                                        class="size-5"
                                        aria-hidden="true"
                                    />
                                </span>
                                <div>
                                    <p
                                        class="text-xs font-semibold tracking-wide uppercase"
                                    >
                                        {{ block.label }}
                                    </p>
                                    <h2
                                        class="mt-1 text-xl font-semibold tracking-normal text-slate-950 dark:text-white"
                                    >
                                        {{ block.title }}
                                    </h2>
                                </div>
                            </div>
                            <p
                                class="self-center text-base leading-8 text-slate-700 dark:text-slate-300"
                            >
                                {{ block.body }}
                            </p>
                        </div>
                    </article>
                </div>
            </section>

            <section
                id="executive-corner"
                class="scroll-mt-28 border-y border-slate-200 bg-slate-950 py-14 text-white sm:py-16 dark:border-white/10"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="executive-corner-heading"
                        :class="revealClasses('executive-corner-heading')"
                        class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between"
                    >
                        <div>
                            <p
                                class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                            >
                                Executive Corner
                            </p>
                            <h2
                                class="mt-3 text-3xl font-semibold tracking-normal text-white"
                            >
                                Press releases from the University
                            </h2>
                            <p
                                class="mt-4 max-w-2xl text-sm leading-7 text-slate-300"
                            >
                                Updates on presidential engagements,
                                institutional directions, and the work of the
                                NEMSU community.
                            </p>
                        </div>
                        <Link
                            :href="newsIndex()"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-sky-200 transition hover:text-white"
                        >
                            View all press releases
                            <ArrowRight class="size-4" aria-hidden="true" />
                        </Link>
                    </div>

                    <div
                        v-if="pressReleases.length"
                        class="mt-8 grid gap-5 lg:grid-cols-3"
                    >
                        <Link
                            v-for="(release, index) in pressReleases"
                            :key="release.id"
                            :href="newsShow(release.slug)"
                            :data-scroll-section="`executive-release-${index}`"
                            :class="
                                revealClasses(
                                    `executive-release-${index}`,
                                    index % 2 === 0 ? 'right' : 'up',
                                )
                            "
                            class="group overflow-hidden rounded-md border border-white/10 bg-white/[0.06] transition hover:-translate-y-1 hover:bg-white/10"
                        >
                            <div
                                class="aspect-[16/9] overflow-hidden bg-slate-800"
                            >
                                <img
                                    v-if="release.photoUrl"
                                    :src="release.photoUrl"
                                    :alt="release.title"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                />
                                <div
                                    v-else
                                    class="flex h-full items-center justify-center"
                                >
                                    <Newspaper
                                        class="size-10 text-slate-500"
                                        aria-hidden="true"
                                    />
                                </div>
                            </div>
                            <div class="p-5">
                                <div
                                    class="flex items-center gap-2 text-xs font-semibold tracking-wide text-sky-200 uppercase"
                                >
                                    <CalendarDays
                                        class="size-4"
                                        aria-hidden="true"
                                    />
                                    {{ release.date ?? 'Press release' }}
                                </div>
                                <h3
                                    class="mt-3 text-lg leading-7 font-semibold text-white"
                                >
                                    {{ release.title }}
                                </h3>
                                <p
                                    v-if="release.excerpt"
                                    class="mt-3 line-clamp-3 text-sm leading-6 text-slate-300"
                                >
                                    {{ release.excerpt }}
                                </p>
                            </div>
                        </Link>
                    </div>

                    <div
                        v-else
                        class="mt-8 rounded-md border border-dashed border-white/20 p-8 text-center text-sm text-slate-300"
                    >
                        Press releases will appear here once they are published.
                    </div>
                </div>
            </section>

            <section
                id="innovate-agenda"
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="president-strategy"
                        :class="revealClasses('president-strategy')"
                        class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]"
                    >
                        <div>
                            <p
                                class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                INNOVATE Agenda
                            </p>
                            <h2
                                class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                Transformative strategies for innovation and
                                sustainable development
                            </h2>
                            <p
                                class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                Prof. Loayon's administration proposes
                                transformative strategies aligned with the
                                strengths of the NEMSU Academic and
                                Administrative community and anchored on the
                                needs and demands of the country. The 8-Point
                                Agenda aspires to empower the academic
                                institution toward innovation and sustainable
                                development.
                            </p>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <a
                                v-for="item in agendaItems"
                                :key="item.number"
                                :href="`#roadmap-${item.number}`"
                                class="group rounded-md border border-slate-200 bg-white p-4 shadow-sm shadow-slate-900/5 transition hover:-translate-y-0.5 hover:border-[#1711d4]/30 hover:shadow-lg hover:shadow-slate-900/10 dark:border-white/10 dark:bg-white/[0.04]"
                            >
                                <div class="flex items-start gap-3">
                                    <span
                                        class="inline-flex size-10 shrink-0 items-center justify-center rounded-md bg-[#1711d4] text-sm font-semibold text-white"
                                    >
                                        {{ item.number }}
                                    </span>
                                    <div>
                                        <h3
                                            class="text-sm font-semibold text-slate-950 dark:text-white"
                                        >
                                            {{ item.title }}
                                        </h3>
                                        <p
                                            class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                                        >
                                            {{ item.summary }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="roadmap" class="py-14 sm:py-16">
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[20rem_1fr] lg:px-8"
                >
                    <aside
                        data-scroll-section="roadmap-heading"
                        :class="revealClasses('roadmap-heading', 'right')"
                        class="lg:sticky lg:top-32 lg:self-start"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Proposed Developmental Road Map
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            2025-2027 strategic direction
                        </h2>
                        <p
                            class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            The roadmap translates the 8-point agenda into
                            strategic goals and specific actions for the NEMSU
                            system.
                        </p>
                    </aside>

                    <div class="grid gap-5">
                        <article
                            v-for="(item, index) in agendaItems"
                            :id="`roadmap-${item.number}`"
                            :key="item.number"
                            :data-scroll-section="`roadmap-item-${item.number}`"
                            :class="
                                revealClasses(
                                    `roadmap-item-${item.number}`,
                                    index % 2 === 0 ? 'left' : 'up',
                                )
                            "
                            class="scroll-mt-28 overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <div
                                class="grid gap-4 border-b border-slate-200 bg-slate-950 p-5 text-white sm:grid-cols-[4rem_1fr] dark:border-white/10"
                            >
                                <span
                                    class="inline-flex size-14 items-center justify-center rounded-md bg-[#f2b705] text-lg font-bold text-slate-950"
                                >
                                    {{ item.number }}
                                </span>
                                <div>
                                    <h3
                                        class="text-xl font-semibold tracking-normal"
                                    >
                                        {{ item.title }}
                                    </h3>
                                    <p
                                        class="mt-2 text-sm leading-7 text-sky-100"
                                    >
                                        {{ item.summary }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-0 lg:grid-cols-2">
                                <section
                                    class="p-5 lg:border-r lg:border-slate-200 dark:lg:border-white/10"
                                >
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="inline-flex size-10 items-center justify-center rounded-md bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                                        >
                                            <component
                                                :is="item.icon"
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                        <h4
                                            class="text-sm font-semibold tracking-wide text-slate-950 uppercase dark:text-white"
                                        >
                                            Strategic Goals
                                        </h4>
                                    </div>
                                    <ol class="mt-4 grid gap-3">
                                        <li
                                            v-for="goal in item.goals"
                                            :key="goal"
                                            class="rounded-md bg-slate-50 p-4 text-sm leading-7 text-slate-700 dark:bg-white/5 dark:text-slate-300"
                                        >
                                            {{ goal }}
                                        </li>
                                    </ol>
                                </section>

                                <section
                                    class="border-t border-slate-200 p-5 lg:border-t-0 dark:border-white/10"
                                >
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="inline-flex size-10 items-center justify-center rounded-md bg-[#fff4cc] text-[#8a5a00] dark:bg-amber-400/10 dark:text-amber-200"
                                        >
                                            <FileText
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                        <h4
                                            class="text-sm font-semibold tracking-wide text-slate-950 uppercase dark:text-white"
                                        >
                                            Specific Actions
                                        </h4>
                                    </div>
                                    <ul class="mt-4 grid gap-3">
                                        <li
                                            v-for="action in item.actions"
                                            :key="action"
                                            class="flex gap-3 rounded-md bg-slate-50 p-4 text-sm leading-7 text-slate-700 dark:bg-white/5 dark:text-slate-300"
                                        >
                                            <BadgeCheck
                                                class="mt-1 size-4 shrink-0 text-[#1711d4] dark:text-sky-200"
                                                aria-hidden="true"
                                            />
                                            <span>{{ action }}</span>
                                        </li>
                                    </ul>
                                </section>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="bg-[#1711d4] py-14 text-white">
                <div
                    class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_22rem] lg:px-8"
                >
                    <div
                        data-scroll-section="president-records"
                        :class="revealClasses('president-records', 'right')"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                        >
                            Public Accountability
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-white"
                        >
                            A clear record for presidential directions,
                            roadmaps, and accomplishment reports.
                        </h2>
                        <p
                            class="mt-5 max-w-3xl text-sm leading-7 text-sky-100"
                        >
                            This page can now anchor the Office of the
                            President's message, INNOVATE agenda, ALPAS,
                            proposed road map, and public reports.
                        </p>
                    </div>

                    <Link
                        :href="`${home().url}#governance`"
                        data-scroll-section="president-governance-link"
                        :class="[
                            revealClasses('president-governance-link', 'left'),
                            'group flex min-h-full flex-col justify-between rounded-md border border-white/15 bg-white/10 p-6 backdrop-blur transition hover:bg-white hover:text-[#1711d4]',
                        ]"
                    >
                        <Building2 class="size-8" aria-hidden="true" />
                        <span class="mt-10">
                            <span class="block font-semibold">
                                View governance resources
                            </span>
                            <span
                                class="mt-3 block text-sm leading-7 text-sky-100 transition group-hover:text-[#1711d4]/80"
                            >
                                Transparency Seal, FOI, Citizen's Charter, and
                                other public resources.
                            </span>
                        </span>
                        <span
                            class="mt-6 inline-flex items-center gap-2 text-sm font-semibold"
                        >
                            Go to governance
                            <ArrowRight
                                class="size-4 transition group-hover:translate-x-1"
                                aria-hidden="true"
                            />
                        </span>
                    </Link>
                </div>
            </section>

            <section
                id="presidents-gallery"
                class="scroll-mt-28 bg-white py-14 sm:py-16 dark:bg-slate-950"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="presidents-gallery-heading"
                        :class="revealClasses('presidents-gallery-heading')"
                        class="flex items-end gap-4"
                    >
                        <span
                            class="inline-flex size-12 shrink-0 items-center justify-center rounded-md bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                        >
                            <Images class="size-6" aria-hidden="true" />
                        </span>
                        <div>
                            <p
                                class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                President's Gallery
                            </p>
                            <h2
                                class="mt-2 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                Leadership in action
                            </h2>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <figure
                            v-for="(photo, index) in presidentGallery"
                            :key="photo.src"
                            :data-scroll-section="`president-gallery-${index}`"
                            :class="
                                revealClasses(
                                    `president-gallery-${index}`,
                                    index % 2 === 0 ? 'right' : 'left',
                                )
                            "
                            class="group overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <div
                                class="aspect-[4/3] overflow-hidden bg-slate-100 dark:bg-slate-900"
                            >
                                <img
                                    :src="photo.src"
                                    :alt="photo.alt"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                />
                            </div>
                            <figcaption
                                class="p-4 text-sm leading-6 text-slate-600 dark:text-slate-300"
                            >
                                {{ photo.caption }}
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
