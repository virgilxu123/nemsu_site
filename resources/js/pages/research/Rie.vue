<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import type { Component } from 'vue';
import {
    ArrowRight,
    ArrowUpRight,
    BookOpenText,
    Building2,
    Download,
    ExternalLink,
    FileText,
    FlaskConical,
    Handshake,
    Lightbulb,
    Mail,
    MapPin,
    Newspaper,
    ScrollText,
    ShieldCheck,
    UserRound,
} from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';

type Leader = {
    name: string;
    role: string;
    email: string;
    image: string;
    alt: string;
    summary: string;
};

type OfficeItem = {
    name: string;
    description: string;
};

type OfficeGroup = {
    id: string;
    title: string;
    director: Leader;
    icon: Component;
    offices: OfficeItem[];
};

type NewsUpdate = {
    tag: string;
    title: string;
    href: string;
};

type RegistryRecord = {
    title: string;
    meta: string;
    status?: string;
};

type RegistryDocument = {
    category: string;
    count: string;
    description: string;
    href: string;
    records: RegistryRecord[];
};

type FeaturedInnovation = {
    title: string;
    category: string;
    campus: string;
    summary: string;
    href: string;
    image?: string;
    fileType: 'Image' | 'PDF';
};

type RevealDirection = 'down' | 'left' | 'right' | 'up';

const address =
    'North Eastern Mindanao State University, Rosario, Tandag City, 8300, Surigao del Sur, Philippines';

const manualUrl =
    'https://drive.google.com/file/d/1N_PgfkGK7-k68JBKqrNCW4BuOzhmHsXv/view?usp=sharing';

const vicePresident: Leader = {
    name: 'Rolly G. Salvaleon, PhD',
    role: 'Vice President for Research, Innovation, and Extension',
    email: 'vpre@nemsu.edu.ph',
    image: '/images/administration/ovprie/vprie.jpg',
    alt: 'Rolly G. Salvaleon, PhD',
    summary:
        'OVPRIE steers the research, innovation, and extension agenda of the University in alignment with national development priorities and key agencies such as CHED, DOST, DA, NEDA, and DBM.',
};

const researchDirector: Leader = {
    name: 'Erwin B. Berry, EdD',
    role: 'Director, Research and Innovation',
    email: 'research@nemsu.edu.ph',
    image: '/images/administration/ovprie/director-research.jpg',
    alt: 'Erwin B. Berry, EdD',
    summary:
        'RIDO supports University researchers through research programs, policy recommendations, funded project development, inter-campus collaboration, dissemination, and ethical compliance coordination.',
};

const kttoDirector: Leader = {
    name: 'Engr. Luzminda S. Bacquial',
    role: 'Director, KTTO',
    email: 'itso@nemsu.edu.ph',
    image: '/images/administration/ovprie/director-ktto.jpg',
    alt: 'Engr. Luzminda S. Bacquial',
    summary:
        'KTTO identifies, protects, manages, and commercializes intellectual property so research outputs can become viable technologies and market-ready solutions.',
};

const extensionDirector: Leader = {
    name: 'Ma. Cristina S. Dela Cerna, PhD',
    role: 'Director, Extension Services and Linkages',
    email: 'extension@nemsu.edu.ph',
    image: '/images/administration/ovprie/director-extension.jpg',
    alt: 'Ma. Cristina S. Dela Cerna, PhD',
    summary:
        'ESLO bridges the University and broader community through education, training, technical assistance, sustainable development partnerships, and community empowerment.',
};

const officeGroups: OfficeGroup[] = [
    {
        id: 'research',
        title: 'University Research and Innovation Office',
        director: researchDirector,
        icon: FlaskConical,
        offices: [
            {
                name: 'Research Centers',
                description:
                    'Research Centers manage activities, resources, and personnel in alignment with institutional priorities while fostering interdisciplinary collaboration, grant proposals, ethical compliance, and research performance tracking.',
            },
            {
                name: 'Research Operation Office',
                description:
                    'The Research Operation Office coordinates and monitors research initiatives, provides technical and administrative support, and ensures research programs align with University goals, community needs, and national priorities.',
            },
            {
                name: 'Creative Works Management Office',
                description:
                    'The Creative Works Management Office oversees creative outputs from students, faculty, and staff through production support, exhibitions, intellectual property guidance, marketing, and external partnership opportunities.',
            },
            {
                name: 'Publication and Printing Office',
                description:
                    'The Publication and Printing Office manages University research journals from manuscript submission to publication, including editorial workflows, peer review, copy-editing, design, online platforms, indexing, and partnerships.',
            },
        ],
    },
    {
        id: 'innovation',
        title: 'Knowledge and Technology Transfer Office',
        director: kttoDirector,
        icon: Lightbulb,
        offices: [
            {
                name: 'Innovation and Technology Support Office',
                description:
                    'ITSO manages intellectual property assets, IP audits, filings for patents, trademarks, and copyrights, IP databases, policies, awareness activities, inquiries, and dispute support.',
            },
            {
                name: 'Intellectual Property and Technology Business Management Office',
                description:
                    'This office assesses University technologies for investment readiness, develops technology transfer strategies, negotiates licensing agreements, markets technologies, and supports licensees and spin-off companies.',
            },
            {
                name: 'Technology Business Incubation Office',
                description:
                    'The Technology Business Incubation Office supports startups through incubatee selection, mentorship, business planning, market validation, minimum viable product development, investor connections, and incubator operations.',
            },
        ],
    },
    {
        id: 'extension',
        title: 'Extension Services and Linkages Office',
        director: extensionDirector,
        icon: Handshake,
        offices: [
            {
                name: 'Extension Planning and Implementation Office',
                description:
                    'EPIO designs and implements community-based programs, conducts needs assessments, develops training materials, evaluates effectiveness, supports logistics, and builds partnerships with agencies, industries, NGOs, and communities.',
            },
            {
                name: 'Monitoring and Impact Assessment Office',
                description:
                    'The Monitoring and Impact Assessment Office conducts field visits, reviews, stakeholder consultations, and third-party impact assessments to strengthen accountability and guide future extension improvements.',
            },
        ],
    },
];

const innovationRegistryDocuments: RegistryDocument[] = [
    {
        category: 'Patents',
        count: '2',
        description:
            'Granted invention records covering protected devices and University-developed technical solutions.',
        href: '/files/administration/ovprie/innovation/patents.xlsx',
        records: [
            {
                title: 'Extendable Fruit Harvester',
                meta: 'Application No. 1/2022/050640',
                status: 'Granted',
            },
            {
                title: 'Multi-Functional Measurement Device',
                meta: 'Application No. 1-2021-050662',
                status: 'Granted',
            },
        ],
    },
    {
        category: 'Utility Models',
        count: '17',
        description:
            'Practical inventions and production methods registered from campus-based research and development work.',
        href: '/files/administration/ovprie/innovation/utility-models.xlsx',
        records: [
            {
                title: 'Freshwater Clam Chili Garlic Sauce',
                meta: 'Registration No. 2/2024/050355',
                status: 'Registered',
            },
            {
                title: 'Grower Ration for Upgrade Pigs',
                meta: 'Registration No. 2/2024/050259',
                status: 'Registered',
            },
        ],
    },
    {
        category: 'Copyrights',
        count: '65',
        description:
            'Protected instructional materials, product labels, creative works, and technology communication assets.',
        href: '/files/administration/ovprie/innovation/copyrights.xlsx',
        records: [
            {
                title: 'Lato Plus Liquid Foliar Biofertilizer',
                meta: 'Tagbina Campus',
                status: 'Registered',
            },
            {
                title: 'Tagbina Coffee Jam',
                meta: 'Tagbina Campus',
                status: 'Registered',
            },
        ],
    },
    {
        category: 'Industrial Designs',
        count: '9',
        description:
            'Protected designs for equipment, devices, and applied technology products developed across NEMSU campuses.',
        href: '/files/administration/ovprie/innovation/industrial-designs.xlsx',
        records: [
            {
                title: 'Rice Hull Stove',
                meta: 'Cagwait Campus',
                status: 'Registered',
            },
            {
                title: 'Portable Abaca Stripping Machine',
                meta: 'Cagwait Campus',
                status: 'Registered',
            },
        ],
    },
    {
        category: 'Trademarks',
        count: '6',
        description:
            'Registered marks supporting University identity, product recognition, and technology commercialization.',
        href: '/files/administration/ovprie/innovation/trademarks.xlsx',
        records: [
            {
                title: 'LAMI-ERS',
                meta: 'Registration No. 4/2016/00503613',
                status: 'Registered',
            },
            {
                title: 'North Eastern Mindanao State University Seal',
                meta: 'Registration No. 4/2024/00519383',
                status: 'Registered',
            },
        ],
    },
];

const featuredInnovations: FeaturedInnovation[] = [
    {
        title: 'Aerial Seed Planting Device',
        category: 'Technology Poster',
        campus: 'NEMSU Bislig',
        summary:
            'A reforestation device designed to improve soil-to-seed contact through a winged, self-drilling mechanism.',
        href: '/images/administration/ovprie/innovation/aerial-seed-planting-device.png',
        image: '/images/administration/ovprie/innovation/aerial-seed-planting-device.png',
        fileType: 'Image',
    },
    {
        title: 'SeaScoops Co. Product Brochure',
        category: 'Commercialization Flyer',
        campus: 'NEMSU Lianga',
        summary:
            'A market-facing brochure for dried fish danggit ice cream and related product offerings.',
        href: '/images/administration/ovprie/innovation/danggit-flyer.png',
        image: '/images/administration/ovprie/innovation/danggit-flyer.png',
        fileType: 'Image',
    },
    {
        title: 'Dried Fish Danggit Ice Cream',
        category: 'Product Poster',
        campus: 'NEMSU Lianga',
        summary:
            'A product communication asset for a local agri-aqua innovation developed with regional support.',
        href: '/images/administration/ovprie/innovation/dried-fish-ice-cream-poster.png',
        image: '/images/administration/ovprie/innovation/dried-fish-ice-cream-poster.png',
        fileType: 'Image',
    },
    {
        title: 'Banana Loaf Bread Flyer',
        category: 'Copyright Poster',
        campus: 'NEMSU Innovation Portfolio',
        summary:
            'A copyright-supported product flyer prepared for public presentation and promotion.',
        href: '/files/administration/ovprie/innovation/banana-loaf-bread-flyer.pdf',
        fileType: 'PDF',
    },
    {
        title: 'Lato Biofertilizer',
        category: 'Copyright Poster',
        campus: 'Tagbina Campus',
        summary:
            'A protected communication asset for a liquid foliar biofertilizer technology.',
        href: '/files/administration/ovprie/innovation/lato-biofertilizer.pdf',
        fileType: 'PDF',
    },
    {
        title: 'Tagbina Coffee Jam',
        category: 'Copyright Poster',
        campus: 'Tagbina Campus',
        summary:
            'A protected product poster highlighting a campus-developed food innovation.',
        href: '/files/administration/ovprie/innovation/tagbina-coffee-jam.pdf',
        fileType: 'PDF',
    },
];

const researchHighlights = [
    { title: 'Research Centers', icon: Building2 },
    { title: 'Scopus Indexed Publications', icon: ScrollText },
    { title: 'Completed Research Projects', icon: ShieldCheck },
];

const pageAnchors = [
    { label: 'Profile', href: '#ovprie-profile' },
    { label: 'RIE Manual', href: '#rie-manual' },
    { label: 'Offices', href: '#ovprie-offices' },
    { label: 'Research', href: '#research' },
    { label: 'Innovation', href: '#innovation' },
    { label: 'Portfolio', href: '#innovation-portfolio' },
    { label: 'Extension', href: '#extension' },
    { label: 'News', href: '#rie-news' },
];

const newsUpdates: NewsUpdate[] = [
    {
        tag: '#NEMSURICallForResearchProposals',
        title: '2027 and 2028 funding call for research proposals',
        href: 'https://www.facebook.com/reel/1644974993391176',
    },
    {
        tag: '#NEMSURIPeerMentoring',
        title: 'RIE peer mentoring activity',
        href: 'https://www.facebook.com/share/p/1DB8mBqxQh/',
    },
    {
        tag: '#NEMSUCITEScopusMentoring',
        title: 'Scopus mentoring for CITE researchers',
        href: 'https://www.facebook.com/share/p/1BMjB2CJPp/',
    },
    {
        tag: '#NEMSUITSOInnovationAward',
        title: 'Innovation award update from ITSO',
        href: 'https://www.facebook.com/share/p/1bBhmcVPqu/',
    },
    {
        tag: '#SDG17PartnershipsfortheGoals',
        title: 'Partnerships for research, innovation, and extension',
        href: 'https://www.facebook.com/share/p/19DfbRmK8W/',
    },
    {
        tag: '#NEMSUTBI',
        title: 'Technology Business Incubation update',
        href: 'https://www.facebook.com/share/p/1GGAXSkTrn/',
    },
];

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['rie-hero']));
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
            rootMargin: '0px 0px -25% 0px',
            threshold: 0,
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
        <Head title="Research, Innovation, and Extension" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate overflow-hidden bg-[#061b49] text-white"
            >
                <div
                    class="absolute inset-0 -z-10 bg-linear-to-br from-[#061b49] via-[#1711d4] to-[#9b1c31]"
                ></div>

                <div
                    data-scroll-section="rie-hero"
                    :class="revealClasses('rie-hero')"
                    class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1fr_22rem] lg:px-8 lg:py-20 xl:grid-cols-[1fr_24rem]"
                >
                    <div class="flex flex-col justify-center">
                        <div class="flex flex-wrap items-center gap-2">
                            <p
                                class="inline-flex w-fit rounded bg-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                            >
                                OVPRIE
                            </p>
                            <p
                                class="inline-flex w-fit rounded bg-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-sky-50 uppercase ring-1 ring-white/15"
                            >
                                Research, Innovation, and Extension
                            </p>
                        </div>
                        <h1
                            class="mt-5 max-w-5xl text-4xl leading-tight font-semibold tracking-normal sm:text-5xl xl:text-6xl"
                        >
                            Office of the Vice President for Research,
                            Innovation, and Extension
                        </h1>
                        <p
                            class="mt-6 max-w-3xl text-base leading-8 text-sky-50"
                        >
                            OVPRIE advances knowledge generation, technology
                            transfer, and meaningful community engagement across
                            the NEMSU system.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a
                                href="#ovprie-offices"
                                class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-semibold text-[#1711d4] shadow-sm transition hover:bg-[#f2b705] hover:text-slate-950"
                            >
                                Explore offices
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </a>
                            <a
                                :href="manualUrl"
                                target="_blank"
                                rel="noreferrer"
                                class="inline-flex items-center gap-2 rounded-md bg-[#f2b705] px-5 py-3 text-sm font-semibold text-slate-950 shadow-sm transition hover:bg-white hover:text-[#1711d4]"
                            >
                                RIE Manual
                                <ExternalLink
                                    class="size-4"
                                    aria-hidden="true"
                                />
                            </a>
                        </div>
                        <div
                            class="mt-8 flex flex-wrap gap-2 text-xs font-semibold tracking-wide text-sky-50 uppercase"
                        >
                            <span
                                class="rounded bg-white/10 px-3 py-2 ring-1 ring-white/15"
                            >
                                Research
                            </span>
                            <span
                                class="rounded bg-white/10 px-3 py-2 ring-1 ring-white/15"
                            >
                                Innovation
                            </span>
                            <span
                                class="rounded bg-white/10 px-3 py-2 ring-1 ring-white/15"
                            >
                                Extension
                            </span>
                        </div>
                    </div>

                    <nav
                        class="self-center rounded-md border border-white/15 bg-white p-4 text-slate-950 shadow-2xl shadow-slate-950/25 dark:bg-slate-950 dark:text-white"
                        aria-label="RIE page sections"
                    >
                        <p
                            class="px-2 text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            In This Section
                        </p>
                        <p
                            class="mt-2 px-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            Jump to the profile, offices, resources, and latest
                            RIE updates.
                        </p>
                        <div class="mt-4 grid gap-1">
                            <a
                                v-for="(anchor, index) in pageAnchors"
                                :key="anchor.href"
                                :href="anchor.href"
                                class="flex min-h-11 items-center gap-3 rounded-md px-3 text-sm font-semibold text-slate-700 transition hover:bg-[#e7f3fb] hover:text-[#1711d4] dark:text-slate-200 dark:hover:bg-white/10 dark:hover:text-sky-200"
                            >
                                <span
                                    class="inline-flex size-6 shrink-0 items-center justify-center rounded bg-slate-100 text-xs text-slate-500 dark:bg-white/10 dark:text-slate-300"
                                >
                                    {{ index + 1 }}
                                </span>
                                {{ anchor.label }}
                            </a>
                        </div>
                    </nav>
                </div>
            </section>

            <section
                id="ovprie-profile"
                class="scroll-mt-28 border-b border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-950"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="ovprie-profile-panel"
                        :class="revealClasses('ovprie-profile-panel')"
                        class="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm shadow-slate-900/5 lg:grid lg:grid-cols-[20rem_1fr] dark:border-white/10 dark:bg-white/[0.04]"
                    >
                        <aside class="bg-slate-950 text-white">
                            <img
                                :src="vicePresident.image"
                                :alt="vicePresident.alt"
                                class="aspect-[4/5] w-full object-cover"
                            />
                            <div class="border-t border-white/10 p-5">
                                <p
                                    class="text-xs font-semibold tracking-wide text-[#f2b705] uppercase"
                                >
                                    Vice President
                                </p>
                                <h3 class="mt-2 text-xl font-semibold">
                                    {{ vicePresident.name }}
                                </h3>
                                <p class="mt-2 text-sm leading-6 text-sky-100">
                                    {{ vicePresident.role }}
                                </p>
                            </div>
                        </aside>

                        <div class="p-6 sm:p-8 lg:p-10">
                            <div class="max-w-3xl">
                                <p
                                    class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    OVPRIE Profile
                                </p>
                                <h2
                                    class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                                >
                                    University-wide RIE leadership
                                </h2>
                                <p
                                    class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300"
                                >
                                    The Office of the Vice President for
                                    Research, Innovation, and Extension
                                    formulates and implements strategic
                                    policies, oversees research, innovation, and
                                    extension programs, facilitates
                                    collaborations, manages grants and funding,
                                    and ensures compliance with regulatory
                                    requirements.
                                </p>
                            </div>

                            <div class="mt-8 grid gap-4 md:grid-cols-2">
                                <article
                                    class="rounded-md border border-slate-200 bg-[#f7f8f5] p-5 dark:border-white/10 dark:bg-slate-950/50"
                                >
                                    <div class="flex items-start gap-4">
                                        <span
                                            class="inline-flex size-11 shrink-0 items-center justify-center rounded-md bg-[#e7f3fb] text-[#1711d4] dark:bg-sky-400/10 dark:text-sky-200"
                                        >
                                            <UserRound
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                        <div>
                                            <p
                                                class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                            >
                                                Office Focus
                                            </p>
                                            <h3
                                                class="mt-1 text-lg font-semibold text-slate-950 dark:text-white"
                                            >
                                                RIE Administration
                                            </h3>
                                            <p
                                                class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                                            >
                                                Research management, technology
                                                transfer, and extension linkages
                                                across the NEMSU system.
                                            </p>
                                        </div>
                                    </div>
                                </article>

                                <article
                                    class="rounded-md border border-slate-200 bg-[#f7f8f5] p-5 dark:border-white/10 dark:bg-slate-950/50"
                                >
                                    <div class="flex items-start gap-4">
                                        <span
                                            class="inline-flex size-11 shrink-0 items-center justify-center rounded-md bg-[#fff4cc] text-[#795200] dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                                        >
                                            <MapPin
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                        <div class="min-w-0">
                                            <p
                                                class="text-xs font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                            >
                                                Contact Details
                                            </p>
                                            <div
                                                class="mt-2 grid gap-2 text-sm text-slate-600 dark:text-slate-300"
                                            >
                                                <a
                                                    :href="`mailto:${vicePresident.email}`"
                                                    class="inline-flex min-w-0 items-center gap-2 hover:text-[#1711d4] dark:hover:text-sky-200"
                                                >
                                                    <Mail
                                                        class="size-4 shrink-0"
                                                        aria-hidden="true"
                                                    />
                                                    <span class="break-all">{{
                                                        vicePresident.email
                                                    }}</span>
                                                </a>
                                                <span
                                                    class="inline-flex items-start gap-2"
                                                >
                                                    <MapPin
                                                        class="mt-0.5 size-4 shrink-0"
                                                        aria-hidden="true"
                                                    />
                                                    <span>{{ address }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <div
                                class="mt-6 flex flex-wrap gap-2 border-t border-slate-200 pt-5 dark:border-white/10"
                            >
                                <span
                                    class="rounded bg-[#e7f3fb] px-3 py-2 text-xs font-semibold tracking-wide text-[#0b3d91] uppercase dark:bg-sky-400/10 dark:text-sky-200"
                                >
                                    Research
                                </span>
                                <span
                                    class="rounded bg-[#fff4cc] px-3 py-2 text-xs font-semibold tracking-wide text-[#795200] uppercase dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                                >
                                    Innovation
                                </span>
                                <span
                                    class="rounded bg-emerald-50 px-3 py-2 text-xs font-semibold tracking-wide text-emerald-700 uppercase dark:bg-emerald-400/10 dark:text-emerald-200"
                                >
                                    Extension
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="rie-manual" class="scroll-mt-28 py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="rie-manual-card"
                        :class="revealClasses('rie-manual-card')"
                        class="grid gap-6 rounded-md border border-slate-200 bg-[#061b49] p-6 text-white shadow-sm shadow-slate-900/10 sm:p-8 lg:grid-cols-[1fr_auto] lg:items-center dark:border-white/10"
                    >
                        <div>
                            <FileText
                                class="size-8 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            <h2 class="mt-4 text-3xl font-semibold">
                                RIE Manual
                            </h2>
                            <p
                                class="mt-3 max-w-3xl text-sm leading-7 text-sky-50"
                            >
                                Access the official Research, Innovation, and
                                Extension manual for policies, processes, and
                                guidance used across OVPRIE programs.
                            </p>
                        </div>
                        <a
                            :href="manualUrl"
                            target="_blank"
                            rel="noreferrer"
                            class="inline-flex items-center justify-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-semibold text-[#1711d4] transition hover:bg-[#f2b705] hover:text-slate-950"
                        >
                            Open manual
                            <ArrowUpRight class="size-4" aria-hidden="true" />
                        </a>
                    </div>
                </div>
            </section>

            <section
                id="ovprie-offices"
                class="scroll-mt-28 border-y border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="ovprie-offices-heading"
                        :class="revealClasses('ovprie-offices-heading')"
                        class="max-w-3xl"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Offices under OVPRIE
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                        >
                            Research, innovation, and extension service
                            directory
                        </h2>
                    </div>

                    <div class="mt-10 grid gap-5 lg:grid-cols-3">
                        <article
                            v-for="(group, index) in officeGroups"
                            :key="group.id"
                            :data-scroll-section="`ovprie-office-card-${group.id}`"
                            :class="
                                revealClasses(
                                    `ovprie-office-card-${group.id}`,
                                    index % 2 === 0 ? 'right' : 'up',
                                )
                            "
                            class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                        >
                            <component
                                :is="group.icon"
                                class="size-8 text-[#1711d4] dark:text-sky-200"
                                aria-hidden="true"
                            />
                            <h3
                                class="mt-5 text-xl font-semibold text-slate-950 dark:text-white"
                            >
                                {{ group.title }}
                            </h3>
                            <p
                                class="mt-2 text-sm font-semibold text-[#0b6680] dark:text-sky-300"
                            >
                                {{ group.director.name }}
                            </p>
                            <p
                                class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ group.director.summary }}
                            </p>
                            <a
                                :href="`#${group.id}`"
                                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                            >
                                View offices
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </a>
                        </article>
                    </div>
                </div>
            </section>

            <section
                v-for="group in officeGroups"
                :id="group.id"
                :key="`${group.id}-section`"
                class="scroll-mt-28 border-b border-slate-200 bg-white py-14 sm:py-16 dark:border-white/10 dark:bg-slate-950"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-8 lg:grid-cols-[22rem_1fr]">
                        <aside
                            :data-scroll-section="`${group.id}-director`"
                            :class="
                                revealClasses(`${group.id}-director`, 'right')
                            "
                        >
                            <img
                                :src="group.director.image"
                                :alt="group.director.alt"
                                class="aspect-[4/5] w-full rounded-md object-cover shadow-lg shadow-slate-900/10"
                            />
                            <div class="mt-5">
                                <p
                                    class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    {{ group.director.role }}
                                </p>
                                <h2
                                    class="mt-2 text-2xl font-semibold text-slate-950 dark:text-white"
                                >
                                    {{ group.director.name }}
                                </h2>
                                <a
                                    :href="`mailto:${group.director.email}`"
                                    class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                                >
                                    <Mail class="size-4" aria-hidden="true" />
                                    {{ group.director.email }}
                                </a>
                            </div>
                        </aside>

                        <div
                            :data-scroll-section="`${group.id}-overview`"
                            :class="
                                revealClasses(`${group.id}-overview`, 'left')
                            "
                        >
                            <p
                                class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                            >
                                {{ group.title }}
                            </p>
                            <h3
                                class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                            >
                                Office overview
                            </h3>
                            <p
                                class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ group.director.summary }}
                            </p>

                            <div class="mt-8 grid gap-4 md:grid-cols-2">
                                <article
                                    v-for="office in group.offices"
                                    :id="
                                        office.name === 'Research Centers'
                                            ? 'research-centers'
                                            : office.name ===
                                                'Publication and Printing Office'
                                              ? 'publication'
                                              : office.name ===
                                                  'Intellectual Property and Technology Business Management Office'
                                                ? 'intellectual-property'
                                                : undefined
                                    "
                                    :key="office.name"
                                    :data-scroll-section="`${group.id}-${office.name}`"
                                    :class="
                                        revealClasses(
                                            `${group.id}-${office.name}`,
                                            'up',
                                        )
                                    "
                                    class="scroll-mt-28 rounded-md border border-slate-200 bg-[#f7f8f5] p-5 dark:border-white/10 dark:bg-white/[0.04]"
                                >
                                    <Building2
                                        class="size-6 text-[#1711d4] dark:text-sky-200"
                                        aria-hidden="true"
                                    />
                                    <h4
                                        class="mt-4 text-lg font-semibold text-slate-950 dark:text-white"
                                    >
                                        {{ office.name }}
                                    </h4>
                                    <p
                                        class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                                    >
                                        {{ office.description }}
                                    </p>
                                </article>
                            </div>

                            <div
                                v-if="group.id === 'research'"
                                class="mt-8 grid gap-4 md:grid-cols-3"
                            >
                                <article
                                    v-for="highlight in researchHighlights"
                                    :key="highlight.title"
                                    class="rounded-md border border-slate-200 bg-white p-5 dark:border-white/10 dark:bg-white/[0.04]"
                                >
                                    <component
                                        :is="highlight.icon"
                                        class="size-6 text-[#0b6680] dark:text-sky-300"
                                        aria-hidden="true"
                                    />
                                    <h4 class="mt-4 font-semibold">
                                        {{ highlight.title }}
                                    </h4>
                                </article>
                            </div>

                            <div
                                v-if="group.id === 'innovation'"
                                id="innovation-portfolio"
                                data-scroll-section="innovation-portfolio"
                                :class="revealClasses('innovation-portfolio')"
                                class="mt-10 scroll-mt-28 space-y-10"
                            >
                                <section
                                    class="grid gap-6 overflow-hidden rounded-md bg-[#061b49] p-6 text-white shadow-sm shadow-slate-900/10 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:items-center lg:p-8"
                                >
                                    <div>
                                        <p
                                            class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                                        >
                                            Innovation Portfolio
                                        </p>
                                        <h4
                                            class="mt-3 text-2xl font-semibold tracking-normal sm:text-3xl"
                                        >
                                            Intellectual property, protected
                                            works, and technology showcases
                                        </h4>
                                        <p
                                            class="mt-4 text-sm leading-7 text-sky-50"
                                        >
                                            KTTO presents registry documents and
                                            selected public-facing materials
                                            that show how NEMSU research outputs
                                            move toward protection,
                                            commercialization, and community
                                            use.
                                        </p>
                                    </div>

                                    <div
                                        class="self-center rounded-md border border-white/10 bg-white/[0.06] p-4 shadow-inner shadow-slate-950/10"
                                    >
                                        <div
                                            class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
                                        >
                                            <p
                                                class="text-xs font-semibold tracking-wide text-sky-100 uppercase"
                                            >
                                                Registry Snapshot
                                            </p>
                                            <a
                                                href="#ip-registry"
                                                class="inline-flex items-center gap-2 text-sm font-semibold text-[#f2b705] transition hover:text-white"
                                            >
                                                Download source files
                                                <ArrowRight
                                                    class="size-4"
                                                    aria-hidden="true"
                                                />
                                            </a>
                                        </div>

                                        <div
                                            class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3"
                                        >
                                            <article
                                                v-for="document in innovationRegistryDocuments"
                                                :key="document.category"
                                                class="min-h-28 rounded-md bg-white p-4 text-slate-950 ring-1 ring-white/20 dark:bg-slate-950/80 dark:text-white"
                                            >
                                                <p
                                                    class="text-3xl font-semibold text-[#1711d4] dark:text-[#f2b705]"
                                                >
                                                    {{ document.count }}
                                                </p>
                                                <p
                                                    class="mt-2 text-xs leading-5 font-semibold tracking-wide text-slate-600 uppercase dark:text-sky-100"
                                                >
                                                    {{ document.category }}
                                                </p>
                                                <p
                                                    class="mt-1 text-xs text-slate-500 dark:text-slate-400"
                                                >
                                                    records
                                                </p>
                                            </article>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <div
                                        data-scroll-section="innovation-featured-heading"
                                        :class="
                                            revealClasses(
                                                'innovation-featured-heading',
                                                'right',
                                            )
                                        "
                                        class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"
                                    >
                                        <div>
                                            <p
                                                class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                            >
                                                Featured technologies and
                                                creative works
                                            </p>
                                            <h4
                                                class="mt-2 text-2xl font-semibold tracking-normal text-slate-950 dark:text-white"
                                            >
                                                Public-ready posters and flyers
                                            </h4>
                                        </div>
                                        <a
                                            href="#ip-registry"
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                                        >
                                            View registry documents
                                            <ArrowRight
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                        </a>
                                    </div>

                                    <div
                                        class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3"
                                    >
                                        <article
                                            v-for="(
                                                innovation, index
                                            ) in featuredInnovations"
                                            :key="innovation.href"
                                            :data-scroll-section="`innovation-featured-${index}`"
                                            :class="
                                                revealClasses(
                                                    `innovation-featured-${index}`,
                                                    'up',
                                                )
                                            "
                                            class="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/[0.04]"
                                        >
                                            <a
                                                :href="innovation.href"
                                                target="_blank"
                                                rel="noreferrer"
                                                class="block bg-slate-100 dark:bg-white/5"
                                            >
                                                <img
                                                    v-if="innovation.image"
                                                    :src="innovation.image"
                                                    :alt="innovation.title"
                                                    class="aspect-[4/3] w-full object-cover transition duration-300 hover:scale-[1.02]"
                                                />
                                                <div
                                                    v-else
                                                    class="flex aspect-[4/3] w-full items-center justify-center"
                                                >
                                                    <FileText
                                                        class="size-12 text-[#1711d4] dark:text-sky-200"
                                                        aria-hidden="true"
                                                    />
                                                </div>
                                            </a>

                                            <div class="p-5">
                                                <div
                                                    class="flex flex-wrap items-center gap-2"
                                                >
                                                    <span
                                                        class="rounded bg-[#e7f3fb] px-2.5 py-1 text-xs font-semibold tracking-wide text-[#0b3d91] uppercase dark:bg-sky-400/10 dark:text-sky-200"
                                                    >
                                                        {{
                                                            innovation.category
                                                        }}
                                                    </span>
                                                    <span
                                                        class="rounded bg-[#fff4cc] px-2.5 py-1 text-xs font-semibold tracking-wide text-[#795200] uppercase dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                                                    >
                                                        {{
                                                            innovation.fileType
                                                        }}
                                                    </span>
                                                </div>
                                                <h5
                                                    class="mt-4 text-lg font-semibold text-slate-950 dark:text-white"
                                                >
                                                    {{ innovation.title }}
                                                </h5>
                                                <p
                                                    class="mt-1 text-sm font-semibold text-[#0b6680] dark:text-sky-300"
                                                >
                                                    {{ innovation.campus }}
                                                </p>
                                                <p
                                                    class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                                                >
                                                    {{ innovation.summary }}
                                                </p>
                                                <a
                                                    :href="innovation.href"
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                                                >
                                                    Open material
                                                    <ArrowUpRight
                                                        class="size-4"
                                                        aria-hidden="true"
                                                    />
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                </section>

                                <section id="ip-registry" class="scroll-mt-28">
                                    <div
                                        data-scroll-section="innovation-registry-heading"
                                        :class="
                                            revealClasses(
                                                'innovation-registry-heading',
                                                'right',
                                            )
                                        "
                                    >
                                        <p
                                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                        >
                                            IP Registry
                                        </p>
                                        <h4
                                            class="mt-2 text-2xl font-semibold tracking-normal text-slate-950 dark:text-white"
                                        >
                                            Downloadable source documents
                                        </h4>
                                    </div>

                                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                                        <article
                                            v-for="(
                                                document, index
                                            ) in innovationRegistryDocuments"
                                            :key="document.href"
                                            :data-scroll-section="`innovation-registry-${index}`"
                                            :class="
                                                revealClasses(
                                                    `innovation-registry-${index}`,
                                                    'up',
                                                )
                                            "
                                            class="rounded-md border border-slate-200 bg-[#f7f8f5] p-5 dark:border-white/10 dark:bg-white/[0.04]"
                                        >
                                            <div
                                                class="flex items-start justify-between gap-4"
                                            >
                                                <div>
                                                    <p
                                                        class="text-xs font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                                    >
                                                        {{ document.count }}
                                                        records
                                                    </p>
                                                    <h5
                                                        class="mt-2 text-lg font-semibold text-slate-950 dark:text-white"
                                                    >
                                                        {{ document.category }}
                                                    </h5>
                                                </div>
                                                <FileText
                                                    class="size-7 shrink-0 text-[#1711d4] dark:text-sky-200"
                                                    aria-hidden="true"
                                                />
                                            </div>
                                            <p
                                                class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                                            >
                                                {{ document.description }}
                                            </p>

                                            <div
                                                class="mt-4 space-y-3 border-t border-slate-200 pt-4 dark:border-white/10"
                                            >
                                                <div
                                                    v-for="record in document.records"
                                                    :key="record.title"
                                                >
                                                    <p
                                                        class="text-sm font-semibold text-slate-950 dark:text-white"
                                                    >
                                                        {{ record.title }}
                                                    </p>
                                                    <p
                                                        class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400"
                                                    >
                                                        {{ record.meta }}
                                                        <span
                                                            v-if="record.status"
                                                        >
                                                            -
                                                            {{ record.status }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>

                                            <a
                                                :href="document.href"
                                                target="_blank"
                                                rel="noreferrer"
                                                class="mt-5 inline-flex items-center gap-2 rounded-md bg-[#1711d4] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#f2b705] hover:text-slate-950 dark:bg-sky-500 dark:hover:bg-[#f2b705]"
                                            >
                                                <Download
                                                    class="size-4"
                                                    aria-hidden="true"
                                                />
                                                Download registry
                                            </a>
                                        </article>
                                    </div>
                                </section>
                            </div>

                            <div
                                v-if="group.id === 'extension'"
                                class="mt-8 rounded-md border border-slate-200 bg-[#f7f8f5] p-5 dark:border-white/10 dark:bg-white/[0.04]"
                            >
                                <BookOpenText
                                    class="size-6 text-[#0b6680] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                                <h4 class="mt-4 text-lg font-semibold">
                                    Extension Projects
                                </h4>
                                <p
                                    class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                                >
                                    Extension projects are monitored for
                                    relevance, inclusivity, sustainability, and
                                    measurable community benefit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section
                id="rie-news"
                class="scroll-mt-28 bg-[#061b49] py-14 text-white sm:py-16"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="rie-news-heading"
                        :class="revealClasses('rie-news-heading', 'right')"
                        class="max-w-3xl"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                        >
                            News and Updates OVPRIE
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                            Recent RIE activities and announcements
                        </h2>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <article
                            v-for="(update, index) in newsUpdates"
                            :key="update.href"
                            :data-scroll-section="`rie-news-${index}`"
                            :class="revealClasses(`rie-news-${index}`, 'up')"
                            class="rounded-md border border-white/10 bg-white/10 p-5 backdrop-blur"
                        >
                            <Newspaper
                                class="size-6 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            <p
                                class="mt-4 text-xs font-semibold tracking-wide text-sky-100 uppercase"
                            >
                                {{ update.tag }}
                            </p>
                            <h3 class="mt-2 text-lg font-semibold">
                                {{ update.title }}
                            </h3>
                            <a
                                :href="update.href"
                                target="_blank"
                                rel="noreferrer"
                                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#f2b705]"
                            >
                                View update
                                <ArrowUpRight
                                    class="size-4"
                                    aria-hidden="true"
                                />
                            </a>
                        </article>
                    </div>
                </div>
            </section>

            <section class="bg-white py-10 dark:bg-slate-950">
                <div
                    class="mx-auto flex max-w-7xl flex-col gap-3 px-4 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8"
                >
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Research, Innovation, and Extension Administration
                    </p>
                    <Link
                        :href="home()"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                    >
                        Back to Home
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </Link>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
