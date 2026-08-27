<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    ArrowUpRight,
    Building2,
    Download,
    FileText,
    Mail,
    Newspaper,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { show as officeShow } from '@/actions/App/Http/Controllers/OvprieOfficeController';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { centers as researchCentersRoute } from '@/routes/research/rie';
import { index as publicationIndex } from '@/routes/research/rie/publications';

type Leader = {
    name: string;
    role: string;
    email: string;
    image: string | null;
    alt: string;
    summary: string;
};

type OfficeUnit = {
    title: string;
    acronym?: string;
};

type OfficeGroup = {
    id: string;
    slug: string;
    title: string;
    acronym: string;
    director: Leader;
    units: OfficeUnit[];
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
    id: string;
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

type ResourceLink = {
    id: string;
    title: string;
    description: string;
    href: string;
    download?: boolean;
};

type RevealDirection = 'down' | 'left' | 'right' | 'up';

const manualUrl =
    'https://drive.google.com/file/d/1N_PgfkGK7-k68JBKqrNCW4BuOzhmHsXv/view?usp=sharing';

const heroBackgroundImage =
    '/images/administration/ovprie/research/research-centers-hero.jpg';

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
    name: 'Arturo G. Gracia, Jr., MSci',
    role: 'Director, Research and Innovation / University Researcher V',
    email: 'research@nemsu.edu.ph',
    image: null,
    alt: 'Arturo G. Gracia, Jr., MSci',
    summary:
        'RIDO supports University researchers through research programs, policy recommendations, funded project development, inter-campus collaboration, dissemination, and ethical compliance coordination.',
};

const kttoDirector: Leader = {
    name: 'Engr. Luzminda S. Bacquial, PhD',
    role: 'Director, KTTO / ITSO Manager',
    email: 'itso@nemsu.edu.ph',
    image: '/images/administration/ovprie/director-ktto.jpg',
    alt: 'Engr. Luzminda S. Bacquial, PhD',
    summary:
        'KTTO identifies, protects, manages, and commercializes intellectual property so research outputs can become viable technologies and market-ready solutions.',
};

const extensionDirector: Leader = {
    name: 'Abundio C. Miralles, EdD',
    role: 'Director, Extension Services and Linkages / University Extension Specialist V',
    email: 'extension@nemsu.edu.ph',
    image: null,
    alt: 'Abundio C. Miralles, EdD',
    summary:
        'ESLO bridges the University and broader community through education, training, technical assistance, sustainable development partnerships, and community empowerment.',
};

const officeGroups: OfficeGroup[] = [
    {
        id: 'research',
        slug: 'university-research-and-innovation-office',
        title: 'University Research and Innovation Office',
        acronym: 'RIDO',
        director: researchDirector,
        units: [
            { title: 'Research Centers' },
            { title: 'Research Operation Office' },
            { title: 'Creative Works Management Office' },
            { title: 'Publication and Printing Office' },
        ],
    },
    {
        id: 'innovation',
        slug: 'knowledge-and-technology-transfer-office',
        title: 'Knowledge and Technology Transfer Office',
        acronym: 'KTTO',
        director: kttoDirector,
        units: [
            {
                title: 'Innovation and Technology Support Office',
                acronym: 'ITSO',
            },
            {
                title: 'Intellectual Property and Technology Business Management Office',
            },
            { title: 'Technology Business Incubation Office', acronym: 'TBI' },
        ],
    },
    {
        id: 'extension',
        slug: 'extension-services-and-linkages-office',
        title: 'Extension Services and Linkages Office',
        acronym: 'ESLO',
        director: extensionDirector,
        units: [
            {
                title: 'Extension Planning and Implementation Office',
                acronym: 'EPIO',
            },
            { title: 'Monitoring and Impact Assessment Office' },
        ],
    },
];

const researchResources: ResourceLink[] = [
    {
        id: 'rie-manual',
        title: 'RIE Manual',
        description:
            'Policies and operating guidance for University RIE programs.',
        href: manualUrl,
    },
    {
        id: 'scopus-publication-records',
        title: 'Scopus Indexed Publications',
        description:
            'University publications indexed in the Scopus database.',
        href: '/files/administration/ovprie/research/scopus-indexed-publications.xlsx',
        download: true,
    },
    {
        id: 'completed-research-projects',
        title: 'Completed Research Projects',
        description:
            'Directory of completed research projects across NEMSU.',
        href: '/files/administration/ovprie/research/completed-research-projects.xlsx',
        download: true,
    },
];

const publicationPreviewImages = [
    '/images/administration/ovprie/research/scopus/2026/1.png',
    '/images/administration/ovprie/research/scopus/2026/2.png',
    '/images/administration/ovprie/research/scopus/new-template/5.png',
];

const extensionResources: ResourceLink[] = [
    {
        id: 'extension-projects',
        title: 'Extension Projects',
        description:
            'University extension programs and project records.',
        href: 'https://docs.google.com/spreadsheets/d/1fJRlzFi2CkeiezyFPHAASUPs8c3R4Phz/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        id: 'extension-activities',
        title: 'Extension Activities',
        description:
            'Updates and documentation from extension activities.',
        href: 'https://docs.google.com/document/d/1ZZlCGjtZiM44-SO8C9u91X2KxuPqDvaI/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
];

const innovationRegistryDocuments: RegistryDocument[] = [
    {
        id: 'patents',
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
        id: 'utility-models',
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
        id: 'copyrights',
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
        id: 'industrial-designs',
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
        id: 'trademarks',
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

const newsUpdates: NewsUpdate[] = [
    {
        tag: '#NEMSURIE',
        title: 'Research That Reaches the Field: NEMSU at the 3rd CRAFTE 2026',
        href: 'https://www.facebook.com/share/p/18D1f4b5xR/',
    },
    {
        tag: '#NEMSURIBenchmarking',
        title: 'Research and innovation benchmarking update',
        href: 'https://www.facebook.com/share/p/1BPM9L2QAf/',
    },
    {
        tag: '#NEMSUInnovation',
        title: 'University innovation activity and milestone',
        href: 'https://www.facebook.com/share/p/18ynyZpEoZ/',
    },
    {
        tag: '#ResearchCallDeadlineExtended',
        title: 'Research call deadline extension announcement',
        href: 'https://www.facebook.com/share/p/1BqrbDjUhm/',
    },
    {
        tag: '#NEMSUScopus',
        title: 'NEMSU surpasses its 2026 Scopus publication target',
        href: 'https://www.facebook.com/share/p/1YVbRjKecJ/',
    },
    {
        tag: '#NEMSURIPerformanceManagement',
        title: 'RIE performance management update',
        href: 'https://www.facebook.com/share/p/18xPV9tbzQ/',
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

const leaderInitials = (name: string): string =>
    name
        .split(/\s+/)
        .filter((part) => /^[A-Za-z]/.test(part))
        .slice(0, 2)
        .map((part) => part.charAt(0).toUpperCase())
        .join('');

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
        <Head title="Research, Innovation, and Extension" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
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
                    data-scroll-section="rie-hero"
                    :class="revealClasses('rie-hero')"
                    class="relative z-10 mx-auto grid max-w-7xl items-center gap-10 px-4 pb-24 sm:px-6 sm:pb-28 lg:grid-cols-[1.25fr_0.75fr] lg:px-8 lg:pb-12"
                >
                    <div>
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
                                <li class="text-white/45" aria-hidden="true">
                                    /
                                </li>
                                <li class="text-[#f2b705]" aria-current="page">
                                    Research, Innovation, and Extension
                                </li>
                            </ol>
                        </nav>
                        <h1
                            class="mt-6 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                        >
                            Office of the Vice President for Research,
                            Innovation, and Extension
                        </h1>
                    </div>

                    <div aria-hidden="true" class="hidden lg:block"></div>
                </div>
            </section>

            <section
                id="ovprie-profile"
                class="relative z-20 scroll-mt-28 pt-10 pb-14 sm:pt-12 sm:pb-16 lg:pt-0"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-start lg:gap-12 lg:px-8"
                >
                    <div
                        data-scroll-section="ovprie-profile-panel"
                        :class="revealClasses('ovprie-profile-panel', 'right')"
                        class="max-w-3xl pt-8 lg:pt-20"
                    >
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
                            class="mt-5 text-uni-body text-slate-600 dark:text-slate-300 text-justify"
                        >
                            The Office of the Vice President for Research,
                            Innovation, and Extension steers the University's
                            RIE agenda in alignment with national development
                            priorities and the thrusts of CHED, DOST, DA, NEDA,
                            DBM, and other relevant institutions.
                        </p>
                        <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300 text-justify"
                        >
                            OVPRIE advances knowledge generation, technology
                            transfer, and meaningful community engagement across
                            the NEMSU system in alignment with national
                            development priorities.
                        </p>

                        <!-- Key Documents & Repositories -->
                        <div
                            class="mt-10 border-t border-slate-200 pt-7 dark:border-white/10"
                        >
                            <p
                                class="text-xs font-bold tracking-widest text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                Key Documents & Repositories
                            </p>

                            <div class="mt-5 grid gap-5 sm:grid-cols-3">
                                <a
                                    v-for="resource in researchResources"
                                    :id="resource.id"
                                    :key="resource.href"
                                    :href="resource.href"
                                    :download="
                                        resource.download ? '' : undefined
                                    "
                                    :target="
                                        resource.download
                                            ? undefined
                                            : '_blank'
                                    "
                                    :rel="
                                        resource.download
                                            ? undefined
                                            : 'noreferrer'
                                    "
                                    class="group block border-l-2 border-slate-300 pl-4 transition-all hover:border-[#1711d4] dark:border-white/20 dark:hover:border-sky-300"
                                >
                                    <h3
                                        class="text-sm font-semibold text-slate-900 transition-colors group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-300"
                                    >
                                        {{ resource.title }}
                                        <span
                                            class="inline-block transition-transform duration-200 group-hover:translate-x-1"
                                            aria-hidden="true"
                                            >&rarr;</span
                                        >
                                    </h3>
                                    <p
                                        class="mt-1.5 text-xs leading-relaxed text-slate-600 dark:text-slate-400"
                                    >
                                        {{ resource.description }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <article
                        data-scroll-section="ovprie-profile-card"
                        :class="revealClasses('ovprie-profile-card', 'left')"
                        class="z-20 order-first mx-auto -mt-24 w-full max-w-sm overflow-hidden bg-white/30 text-slate-950 shadow-[0_24px_70px_rgba(15,23,42,0.28)] ring-1 ring-white/45 backdrop-blur-2xl sm:-mt-28 lg:sticky lg:top-24 lg:order-none lg:mt-[-8.5rem] lg:self-start dark:bg-slate-950/35 dark:text-white dark:ring-white/15"
                    >
                        <div class="relative overflow-hidden">
                            <img
                                v-if="vicePresident.image"
                                :src="vicePresident.image"
                                :alt="vicePresident.alt"
                                class="h-96 w-full object-cover object-top [filter:contrast(.96)_saturate(.96)_blur(.2px)]"
                            />
                            <div
                                v-else
                                class="grid h-96 place-items-center bg-[#1711d4] text-white"
                            >
                                <span
                                    class="grid size-24 place-items-center rounded-full bg-white/12 text-3xl font-semibold ring-1 ring-white/20"
                                >
                                    {{ leaderInitials(vicePresident.name) }}
                                </span>
                            </div>
                            <div
                                class="absolute inset-x-0 bottom-0 h-24 bg-linear-to-t from-slate-950/45 to-transparent"
                                aria-hidden="true"
                            ></div>
                        </div>

                        <div class="px-4 pt-5 pb-4 sm:px-5 sm:pb-5">
                            <p
                                class="text-xs font-bold tracking-[0.22em] text-[#f2b705] uppercase"
                            >
                                Vice President
                            </p>
                            <h3
                                class="mt-2 text-2xl leading-tight font-semibold text-slate-950 dark:text-white"
                            >
                                {{ vicePresident.name }}
                            </h3>
                            <p
                                class="mt-3 border-t border-slate-200 pt-4 text-sm leading-6 text-slate-600 dark:border-white/10 dark:text-sky-100"
                            >
                                {{ vicePresident.role }}
                            </p>
                            <a
                                :href="`mailto:${vicePresident.email}`"
                                class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                            >
                                <Mail class="size-4" aria-hidden="true" />
                                {{ vicePresident.email }}
                            </a>
                        </div>
                    </article>
                </div>
            </section>

            <section
                id="ovprie-offices"
                class="scroll-mt-28 bg-[#1f007c] py-14 text-white sm:py-16"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="ovprie-offices-heading"
                        :class="revealClasses('ovprie-offices-heading')"
                        class="max-w-3xl"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#ffbf00] uppercase"
                        >
                            Offices under OVPRIE
                        </p>
                    </div>

                    <nav
                        aria-label="Offices under OVPRIE"
                        class="mt-10 grid gap-x-12 gap-y-7 text-left sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <Link
                            v-for="group in officeGroups"
                            :key="`${group.slug}-directory`"
                            :href="officeShow.url(group.slug)"
                            class="group inline-flex items-start justify-start gap-2 text-left text-sm font-bold text-white transition hover:text-[#f2b705] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#f2b705] lg:text-base"
                        >
                            <span>
                                {{ group.title }} ({{ group.acronym }})
                            </span>
                            <span
                                class="mt-0.5 text-[#f2b705] transition group-hover:translate-x-1"
                                aria-hidden="true"
                            >
                                &gt;
                            </span>
                        </Link>
                    </nav>
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
                                v-if="group.director.image"
                                :src="group.director.image"
                                :alt="group.director.alt"
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
                                        {{
                                            leaderInitials(group.director.name)
                                        }}
                                    </span>
                                    <p class="mt-4 text-sm text-white/70">
                                        Official photo pending
                                    </p>
                                </div>
                            </div>
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
                                Service overview
                            </h3>
                            <p
                                class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ group.director.summary }}
                            </p>

                            <div
                                v-if="group.id === 'research'"
                                class="mt-8 space-y-6"
                            >
                                <section
                                    id="research-centers"
                                    class="relative overflow-hidden rounded-xl border border-slate-200/80 bg-linear-to-br from-[#061b49] via-[#0b2566] to-[#1711d4] p-6 text-white shadow-md sm:p-8"
                                >
                                    <div
                                        class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between"
                                    >
                                        <div class="max-w-xl">
                                            <p
                                                class="text-xs font-bold tracking-widest text-[#f2b705] uppercase"
                                            >
                                                University Research Centers
                                            </p>
                                            <h4
                                                class="mt-2 text-2xl font-bold tracking-normal text-white sm:text-3xl"
                                            >
                                                12 Specialized Research Centers
                                            </h4>
                                            <p
                                                class="mt-3 text-sm leading-relaxed text-sky-100"
                                            >
                                                Discover our specialized
                                                research centers across all 7
                                                NEMSU campuses focused on
                                                agriculture, biodiversity,
                                                renewable energy, and
                                                instructional innovation.
                                            </p>
                                        </div>
                                        <Link
                                            :href="researchCentersRoute().url"
                                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#f2b705] px-5 py-3 text-sm font-bold text-slate-950 transition hover:bg-white hover:text-[#061b49]"
                                        >
                                            Explore Research Centers
                                            <ArrowRight
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                        </Link>
                                    </div>
                                </section>

                                <section
                                    id="publication"
                                    class="scroll-mt-28 overflow-hidden rounded-md border border-slate-200 bg-[#f7f8f5] dark:border-white/10 dark:bg-white/[0.04]"
                                >
                                    <div
                                        class="grid grid-cols-3 gap-2 bg-slate-100 p-3 sm:gap-3 sm:p-4 dark:bg-slate-900"
                                    >
                                        <div
                                            v-for="(
                                                image, index
                                            ) in publicationPreviewImages"
                                            :key="image"
                                            class="grid aspect-4/5 place-items-center overflow-hidden rounded-sm bg-white p-1.5 shadow-sm sm:p-2 dark:bg-slate-950"
                                        >
                                            <img
                                                :src="image"
                                                :alt="`NEMSU publication poster preview ${index + 1}`"
                                                loading="lazy"
                                                class="max-h-full max-w-full object-contain"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6"
                                    >
                                        <div>
                                            <p
                                                class="text-xs font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                            >
                                                Published Articles
                                            </p>
                                            <h4
                                                class="mt-2 text-xl font-semibold text-slate-950 dark:text-white"
                                            >
                                                Explore NEMSU's Scopus
                                                publication posters
                                            </h4>
                                            <p
                                                class="mt-2 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-300"
                                            >
                                                Browse the current poster
                                                gallery or download the complete
                                                publication workbook above.
                                            </p>
                                        </div>
                                        <Link
                                            :href="publicationIndex().url"
                                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-md bg-[#1711d4] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#0b3d91]"
                                        >
                                            View all publications
                                            <ArrowRight
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                        </Link>
                                    </div>
                                </section>
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
                                            :id="document.id"
                                            :key="document.href"
                                            :data-scroll-section="`innovation-registry-${index}`"
                                            :class="
                                                revealClasses(
                                                    `innovation-registry-${index}`,
                                                    'up',
                                                )
                                            "
                                            class="scroll-mt-28 rounded-md border border-slate-200 bg-[#f7f8f5] p-5 dark:border-white/10 dark:bg-white/[0.04]"
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
                                class="mt-8 grid gap-6 sm:grid-cols-2"
                            >
                                <a
                                    v-for="resource in extensionResources"
                                    :id="resource.id"
                                    :key="resource.href"
                                    :href="resource.href"
                                    target="_blank"
                                    rel="noreferrer"
                                    class="group block border-l-2 border-slate-300 pl-4 transition-all hover:border-[#1711d4] dark:border-white/20 dark:hover:border-sky-300"
                                >
                                    <h4
                                        class="text-base font-semibold text-slate-900 transition-colors group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-300"
                                    >
                                        {{ resource.title }}
                                        <span
                                            class="inline-block transition-transform duration-200 group-hover:translate-x-1"
                                            aria-hidden="true"
                                            >&rarr;</span
                                        >
                                    </h4>
                                    <p
                                        class="mt-1.5 text-xs leading-relaxed text-slate-600 dark:text-slate-400"
                                    >
                                        {{ resource.description }}
                                    </p>
                                </a>
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
