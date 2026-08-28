<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    ArrowUpRight,
    Building2,
    Download,
    FileText,
    Mail,
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
    name: 'Arturo G. Gracia, Jr., MSc',
    role: 'Director, Research and Innovation / University Researcher V',
    email: 'research@nemsu.edu.ph',
    image: '/images/administration/ovprie/director-research.png',
    alt: 'Arturo G. Gracia, Jr., MSci',
    summary:
        'The University Research and Innovation Office, led by the Director and in coordination with the Office of the Vice President for Research, Innovation, and Extension (OVPRIE), supports university researchers by overseeing research programs, projects, and activities, recommending policies, and implementing strategic initiatives. The RIDO leads the development of project proposals for funding, fosters inter-campus collaboration, and facilitates the publication, dissemination, and application of research outputs. It also monitors ongoing research, ensures ethical compliance in 4 coordination with the University Research Ethics Committee (UREC), prepares reports, and handles other research-related tasks assigned by the VPRIE.',
};

const kttoDirector: Leader = {
    name: 'Engr. Luzminda S. Bacquial, PhD',
    role: 'Director, KTTO / ITSO Manager',
    email: 'itso@nemsu.edu.ph',
    image: '/images/administration/ovprie/director-ktto-1.jpg',
    alt: 'Engr. Luzminda S. Bacquial, PhD',
    summary:
        'The Knowledge and Technology Transfer Office (KTTO), led by the Director and in coordination with the Office of the Vice President for Research, Innovation, and Extension (OVPRIE), serves as a key driver of innovation and commercialization within the university. It identifies, protects, and manages intellectual property, ensuring that research outputs are transformed into viable technologies and market-ready solutions. By fostering partnerships with industry, government agencies, and other institutions, KTTO facilitates the commercialization of research through licensing agreements, technology transfer, and entrepreneurial initiatives. Beyond commercialization, it promotes a culture of innovation, knowledge sharing, and interdisciplinary collaboration. Ultimately, KTTO translates research discoveries into tangible societal benefits, contributing to economic growth, technological advancement, and the university’s broader mission of knowledge generation and impact.',
};

const extensionDirector: Leader = {
    name: 'Abundio C. Miralles, EdD',
    role: 'Director, Extension Services and Linkages / University Extension Specialist V',
    email: 'extension@nemsu.edu.ph',
    image: '/images/administration/ovprie/director-extension_.jpeg',
    alt: 'Abundio C. Miralles, EdD',
    summary:
        'The Extension Services and Linkages Office (ESLO), led by the Director and in coordination with the Office of the Vice President for Research, Innovation, and Extension (OVPRIE), serves as the bridge between the University and the broader community, ensuring that academic expertise translates into meaningful societal impact. It delivers education, training, and technical assistance tailored to address pressing community needs while fostering sustainable development. By establishing strong linkages with the community, the office facilitates the application of research-based solutions that enhance livelihoods and drive social progress. Through active collaboration and knowledge exchange, UESLO advances the university’s commitment to community empowerment, capacity building, and inclusive development.',
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
];

type ExtensionActivity = {
    title: string;
    image: string;
    href: string;
};

const showAllExtensionActivities = ref(false);

const extensionActivities: ExtensionActivity[] = [
    {
        title: 'Going digital for stronger communities',
        image: '/images/administration/ovprie/extension/activity-1.jpg',
        href: 'https://www.facebook.com/share/p/1HXBC7UXz4/',
    },
    {
        title: 'Empowering education through technology',
        image: '/images/administration/ovprie/extension/activity-2.jpg',
        href: 'https://www.facebook.com/share/p/1bWnY922ZQ/',
    },
    {
        title: 'Project Mobilization, Partnership Building, and Team Formation',
        image: '/images/administration/ovprie/extension/activity-3.jpg',
        href: 'https://www.facebook.com/share/p/1CubWSy6Qw/',
    },
    {
        title: 'Training Needs Assessment for the Beneficiaries of Barangay Tigao, Cortes',
        image: '/images/administration/ovprie/extension/activity-4.jpg',
        href: 'https://www.facebook.com/share/p/18jt7Ny2rd/',
    },
    {
        title: 'Seminar on Youth Challenges and Solutions for Barangay Balete, Bayabas',
        image: '/images/administration/ovprie/extension/activity-5.jpg',
        href: 'https://www.facebook.com/share/p/1CfkmYLmKb/',
    },
    {
        title: 'Artificial Intelligence (AI) Business Essentials Seminar',
        image: '/images/administration/ovprie/extension/activity-6.jpg',
        href: 'https://www.facebook.com/share/p/1ehiPeC98Q/',
    },
    {
        title: 'Empowering communities through financial stewardship',
        image: '/images/administration/ovprie/extension/activity-7.jpg',
        href: 'https://www.facebook.com/share/p/1PcfT2c12K/',
    },
    {
        title: 'Training on Good Governance and Environmental Management System',
        image: '/images/administration/ovprie/extension/activity-8.jpg',
        href: 'https://www.facebook.com/share/p/1CkQPND3vy/',
    },
    {
        title: 'Strengthening community capacity through education',
        image: '/images/administration/ovprie/extension/activity-9.jpg',
        href: 'https://www.facebook.com/share/p/1BnbJdRV82/',
    },
    {
        title: 'Strengthening local governance through technology',
        image: '/images/administration/ovprie/extension/activity-10.jpg',
        href: 'https://www.facebook.com/share/p/14iPj8q4dw1/',
    },
    {
        title: 'Nurturing skills for sustainable enterprise',
        image: '/images/administration/ovprie/extension/activity-11.jpg',
        href: 'https://www.facebook.com/share/p/1GLFaXjrNk/',
    },
    {
        title: 'Strengthening financial stewardship',
        image: '/images/administration/ovprie/extension/activity-12.jpg',
        href: 'https://www.facebook.com/share/p/1HHQNG8tQu/',
    },
    {
        title: 'Building stronger communities through leadership',
        image: '/images/administration/ovprie/extension/activity-13.jpg',
        href: 'https://www.facebook.com/share/p/1BpcSHYGVY/',
    },
    {
        title: 'Crafting creativity into sustainable enterprise',
        image: '/images/administration/ovprie/extension/activity-14.jpg',
        href: 'https://www.facebook.com/share/p/18ibid4LVQ/',
    },
    {
        title: 'Fostering financial empowerment',
        image: '/images/administration/ovprie/extension/activity-15.jpg',
        href: 'https://www.facebook.com/share/p/1CqBjaM4V6/',
    },
    {
        title: 'Empowering local governance through technology',
        image: '/images/administration/ovprie/extension/activity-16.jpg',
        href: 'https://www.facebook.com/share/p/18frSmgupb/',
    },
    {
        title: 'College of Teacher Education, Barangay San Agustin Sur and DepEd Tandag City Division',
        image: '/images/administration/ovprie/extension/activity-17.jpg',
        href: 'https://www.facebook.com/share/p/18YZqpHgkC/',
    },
    {
        title: '1-Day Action Research Implementation Support (EduTech Forge Project)',
        image: '/images/administration/ovprie/extension/activity-18.jpg',
        href: 'https://www.facebook.com/share/p/18vKQ6ndr2/',
    },
    {
        title: 'Strengthening digital readiness',
        image: '/images/administration/ovprie/extension/activity-19.jpg',
        href: 'https://www.facebook.com/share/p/1D8bS52LFx/',
    },
    {
        title: 'Empowering communities through knowledge and skills',
        image: '/images/administration/ovprie/extension/activity-20.jpg',
        href: 'https://www.facebook.com/share/p/18VcUPaw5t/',
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

type KttoTechnology = {
    title: string;
    image: string;
    href: string;
};

const showAllKttoTechnologies = ref(false);

const kttoTechnologies: KttoTechnology[] = [
    {
        title: 'Fruit Juicer',
        image: '/images/administration/ovprie/ktto/tech-1.jpg',
        href: 'https://www.facebook.com/photo.php?fbid=1036389065800932&set=pb.100082895454339.-2207520000&type=3',
    },
    {
        title: 'Crown Cork Opener and Resealer',
        image: '/images/administration/ovprie/ktto/tech-2.jpg',
        href: 'https://www.facebook.com/photo/?fbid=1036392092467296&set=pb.100082895454339.-2207520000',
    },
    {
        title: 'Process of Producing a Cucumber (Cucumis sativus) Ice Cream',
        image: '/images/administration/ovprie/ktto/tech-3.jpg',
        href: 'https://www.facebook.com/photo/?fbid=1036394629133709&set=pb.100082895454339.-2207520000',
    },
    {
        title: 'Aerial Seed Planting Device',
        image: '/images/administration/ovprie/ktto/tech-4.jpg',
        href: 'https://www.facebook.com/photo.php?fbid=1011948111578361&set=pb.100082895454339.-2207520000&type=3',
    },
    {
        title: 'Composition of a Wild Sugarcane (Saccharum spontaneum) Nutritional Bar',
        image: '/images/administration/ovprie/ktto/tech-5.jpg',
        href: 'https://www.facebook.com/photo.php?fbid=985706904202482&set=pb.100082895454339.-2207520000&type=3',
    },
    {
        title: 'A Composition for Loaf Bread Utilizing Cardava (Musa acuminata var. Cardava) Flour',
        image: '/images/administration/ovprie/ktto/tech-6.jpg',
        href: 'https://www.facebook.com/photo.php?fbid=985642437542262&set=pb.100082895454339.-2207520000&type=3',
    },
    {
        title: 'The Formulation of Making Food Seasoning with Dried Fish Danggit (Siganus Spp.) Powder',
        image: '/images/administration/ovprie/ktto/tech-7.jpg',
        href: 'https://www.facebook.com/photo.php?fbid=985633210876518&set=pb.100082895454339.-2207520000&type=3',
    },
    {
        title: 'Soya Milk Ice Cream and The Process of Making Thereof',
        image: '/images/administration/ovprie/ktto/tech-8.jpg',
        href: 'https://www.facebook.com/photo.php?fbid=985631204210052&set=pb.100082895454339.-2207520000&type=3',
    },
    {
        title: 'Aerial Seed Planting Device (Component System)',
        image: '/images/administration/ovprie/ktto/tech-9.jpg',
        href: 'https://www.facebook.com/photo.php?fbid=980579224715250&set=pb.100082895454339.-2207520000&type=3',
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

const newsUpdateImages: string[] = [
    '/images/administration/ovprie/news/news-1.jpg',
    '/images/administration/ovprie/news/news-2.jpg',
    '/images/administration/ovprie/news/news-3.jpg',
    '/images/administration/ovprie/news/news-4.jpg',
    '/images/administration/ovprie/news/news-5.jpg',
    '/images/administration/ovprie/news/news-6.jpg',
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
                            University-wide RIE Leadership
                        </h2>
                        <p
                            class="mt-5 text-uni-body text-slate-600 dark:text-slate-300 text-justify"
                        >
                            The Office of the Vice President for Research,
                            Innovation, and Extension (OVPRIE) is responsible
                            for steering the University's research, innovation,
                            and extension agenda in alignment with national
                            development priorities and the thrusts of key
                            agencies such as CHED, DOST, DA, NEDA, DBM, and
                            other relevant institutions. It formulates and
                            implements strategic policies, oversees research,
                            innovation and extension programs, facilitates
                            collaborations, manages grants and funding, and
                            ensures compliance with regulatory requirements.
                            Through its leadership, OVPRIE fosters a dynamic
                            research and innovation ecosystem that advances
                            knowledge generation, technology transfer, and
                            meaningful community engagement.
                        </p>
                        <!-- <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300 text-justify"
                        >
                            OVPRIE advances knowledge generation, technology
                            transfer, and meaningful community engagement across
                            the NEMSU system in alignment with national
                            development priorities.
                        </p> -->

                        <!-- Key Documents & Repositories -->
                        <div
                            class="mt-10 border-t border-slate-200 pt-7 dark:border-white/10"
                        >
                            <p
                                class="text-xs font-bold tracking-widest text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                Key Documents & Repositories
                            </p>

                            <div class="mt-5 grid gap-6 sm:grid-cols-3">
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
                                    class="group flex flex-col justify-start border-l-2 border-slate-300 pl-4 transition-all hover:border-[#1711d4] dark:border-white/20 dark:hover:border-sky-300"
                                >
                                    <h4
                                        class="flex min-h-[2.6rem] items-start text-sm font-semibold leading-snug text-slate-900 transition-colors group-hover:text-[#1711d4] sm:text-[0.925rem] dark:text-white dark:group-hover:text-sky-300"
                                    >
                                        <span>{{ resource.title }}&nbsp;<span
                                            class="inline-block transition-transform duration-200 group-hover:translate-x-1"
                                            aria-hidden="true"
                                            >&rarr;</span
                                        ></span>
                                    </h4>
                                    <p
                                        class="mt-1 text-xs leading-relaxed text-slate-600 dark:text-slate-400"
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
                id="rie-news"
                class="scroll-mt-28 bg-white py-12 text-slate-950 sm:py-16 dark:bg-slate-950 dark:text-white"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="rie-news-heading"
                        :class="revealClasses('rie-news-heading', 'right')"
                        class="mb-9 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
                    >
                        <div class="max-w-3xl">
                            <p
                                class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                News and Updates OVPRIE
                            </p>
                        </div>
                    </div>

                    <!-- Bento Grid -->
                    <div
                        data-scroll-section="rie-news-grid"
                        :class="revealClasses('rie-news-grid', 'up')"
                        class="grid gap-3.5 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)] lg:grid-rows-2"
                    >
                        <!-- Featured (Large Left Card) - Spans 2 rows -->
                        <a
                            v-if="newsUpdates[0]"
                            :href="newsUpdates[0].href"
                            target="_blank"
                            rel="noreferrer"
                            class="group relative row-span-1 overflow-hidden rounded-2xl ring-1 ring-slate-900/10 shadow-xl shadow-slate-900/10 transition-all duration-500 hover:ring-[#f2b705] hover:shadow-2xl lg:row-span-2 dark:ring-white/15 dark:shadow-black/40"
                        >
                            <img
                                :src="newsUpdateImages[0]"
                                :alt="newsUpdates[0].title"
                                class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-105"
                            />
                            <div
                                class="absolute inset-0 bg-linear-to-t from-black/90 via-black/40 to-black/10"
                            ></div>
                            <div
                                class="relative flex h-full min-h-[28rem] flex-col justify-end p-6 sm:p-8 lg:min-h-full"
                            >
                                <div
                                    class="flex flex-wrap items-center gap-2"
                                >
                                    <span
                                        class="rounded bg-[#f2b705] px-2.5 py-1 text-[0.65rem] font-bold tracking-wide text-slate-950 uppercase shadow-md"
                                    >
                                        {{ newsUpdates[0].tag }}
                                    </span>
                                </div>
                                <h3
                                    class="mt-3 text-2xl leading-tight font-bold text-white transition-colors group-hover:text-[#f2b705] sm:text-3xl"
                                >
                                    {{ newsUpdates[0].title }}
                                </h3>
                            </div>
                        </a>

                        <!-- Right Column: Top Row (2 medium cards) -->
                        <div class="grid gap-3.5 sm:grid-cols-2">
                            <a
                                v-for="(item, index) in newsUpdates.slice(1, 3)"
                                :key="item.href"
                                :href="item.href"
                                target="_blank"
                                rel="noreferrer"
                                class="group relative overflow-hidden rounded-2xl ring-1 ring-slate-900/10 shadow-lg shadow-slate-900/10 transition-all duration-500 hover:ring-[#f2b705] hover:shadow-xl dark:ring-white/15 dark:shadow-black/30"
                            >
                                <img
                                    :src="newsUpdateImages[index + 1]"
                                    :alt="item.title"
                                    class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-105"
                                />
                                <div
                                    class="absolute inset-0 bg-linear-to-t from-black/85 via-black/35 to-black/5"
                                ></div>
                                <div
                                    class="relative flex min-h-52 flex-col justify-end p-4 sm:min-h-56"
                                >
                                    <span
                                        class="mb-2 w-fit rounded bg-[#f2b705] px-2 py-0.5 text-[0.6rem] font-bold tracking-wide text-slate-950 uppercase shadow-md"
                                    >
                                        {{ item.tag }}
                                    </span>
                                    <h3
                                        class="line-clamp-2 text-sm leading-snug font-bold text-white transition-colors group-hover:text-[#f2b705]"
                                    >
                                        {{ item.title }}
                                    </h3>
                                </div>
                            </a>
                        </div>

                        <!-- Right Column: Bottom Row (3 smaller cards) -->
                        <div class="grid gap-3.5 sm:grid-cols-3">
                            <a
                                v-for="(item, index) in newsUpdates.slice(3, 6)"
                                :key="item.href"
                                :href="item.href"
                                target="_blank"
                                rel="noreferrer"
                                class="group relative overflow-hidden rounded-2xl ring-1 ring-slate-900/10 shadow-lg shadow-slate-900/10 transition-all duration-500 hover:ring-[#f2b705] hover:shadow-xl dark:ring-white/15 dark:shadow-black/30"
                            >
                                <img
                                    :src="newsUpdateImages[index + 3]"
                                    :alt="item.title"
                                    class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-105"
                                />
                                <div
                                    class="absolute inset-0 bg-linear-to-t from-black/85 via-black/35 to-black/5"
                                ></div>
                                <div
                                    class="relative flex min-h-44 flex-col justify-end p-3.5 sm:min-h-48"
                                >
                                    <span
                                        class="mb-2 w-fit rounded bg-[#f2b705] px-2 py-0.5 text-[0.6rem] font-bold tracking-wide text-slate-950 uppercase shadow-md"
                                    >
                                        {{ item.tag }}
                                    </span>
                                    <h3
                                        class="line-clamp-2 text-[0.8rem] leading-snug font-bold text-white transition-colors group-hover:text-[#f2b705]"
                                    >
                                        {{ item.title }}
                                    </h3>
                                </div>
                            </a>
                        </div>
                    </div>
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
                    <div class="grid gap-8 lg:grid-cols-[24rem_1fr]">
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
                                    class="text-xs font-semibold leading-relaxed tracking-wide text-[#9b1c31] uppercase text-pretty dark:text-rose-300"
                                >
                                    {{ group.director.role }}
                                </p>
                                <h2
                                    class="mt-2 text-xl font-semibold text-slate-950 sm:text-2xl lg:text-[1.35rem] xl:text-2xl dark:text-white"
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
                                Service Overview
                            </h3>
                            <p
                                class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300 text-justify"
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
                                            class="mt-4 text-sm leading-7 text-sky-50 text-justify"
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

                                <section class="scroll-mt-28">
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
                                                class="text-xs font-bold tracking-widest text-[#9b1c31] uppercase dark:text-rose-300"
                                            >
                                                Commercialization & Technology Transfer
                                            </p>
                                            <h4
                                                class="mt-1 text-xl font-bold tracking-normal text-slate-950 dark:text-white"
                                            >
                                                Featured Technologies & Innovations
                                            </h4>
                                        </div>
                                        <a
                                            href="#ip-registry"
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                                        >
                                            View IP registry documents
                                            <ArrowRight
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                        </a>
                                    </div>

                                    <div
                                        class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3"
                                    >
                                        <a
                                            v-for="tech in (showAllKttoTechnologies ? kttoTechnologies : kttoTechnologies.slice(0, 6))"
                                            :key="tech.href"
                                            :href="tech.href"
                                            target="_blank"
                                            rel="noreferrer"
                                            class="group relative overflow-hidden rounded-2xl ring-1 ring-slate-900/10 shadow-lg shadow-slate-900/10 transition-all duration-500 hover:ring-[#f2b705] hover:shadow-xl dark:ring-white/15 dark:shadow-black/30"
                                        >
                                            <img
                                                :src="tech.image"
                                                :alt="tech.title"
                                                class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-105"
                                            />
                                            <div
                                                class="absolute inset-0 bg-linear-to-t from-black/85 via-black/35 to-black/5"
                                            ></div>
                                            <div
                                                class="relative flex min-h-52 flex-col justify-end p-5 sm:min-h-56"
                                            >
                                                <h4
                                                    class="text-sm font-bold text-white transition-colors group-hover:text-[#f2b705]"
                                                >
                                                    {{ tech.title }}
                                                </h4>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Show More / Show Less Toggle Button -->
                                    <div class="mt-6 flex justify-center">
                                        <button
                                            type="button"
                                            @click="showAllKttoTechnologies = !showAllKttoTechnologies"
                                            class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-xs font-bold text-slate-800 shadow-xs transition hover:border-[#1711d4] hover:bg-slate-50 hover:text-[#1711d4] dark:border-white/20 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-sky-300 dark:hover:text-sky-300"
                                        >
                                            <span>{{ showAllKttoTechnologies ? 'Show Fewer Technologies' : 'View All 9 Protected Technologies' }}</span>
                                            <span aria-hidden="true">{{ showAllKttoTechnologies ? '↑' : '↓' }}</span>
                                        </button>
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
                                                    <!-- <p
                                                        class="text-xs font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                                    >
                                                        {{ document.count }}
                                                        records
                                                    </p> -->
                                                    <h5
                                                        class="mt-2 text-lg font-semibold text-slate-950 dark:text-white"
                                                    >
                                                        {{ document.category }}
                                                    </h5>
                                                </div>
                                                <!-- <FileText
                                                    class="size-7 shrink-0 text-[#1711d4] dark:text-sky-200"
                                                    aria-hidden="true"
                                                /> -->
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
                                class="mt-8 space-y-10"
                            >
                                <!-- Core Extension Repositories -->
                                <div class="grid gap-6 sm:grid-cols-2">
                                    <a
                                        v-for="resource in extensionResources"
                                        :id="resource.id"
                                        :key="resource.href"
                                        :href="resource.href"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="group flex flex-col justify-start border-l-2 border-slate-300 pl-4 transition-all hover:border-[#1711d4] dark:border-white/20 dark:hover:border-sky-300"
                                    >
                                        <h4
                                            class="text-base font-semibold text-slate-900 transition-colors group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-300"
                                        >
                                            {{ resource.title }}&nbsp;<span
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

                                <!-- Extension Activities & Community Initiatives Cards -->
                                <div class="border-t border-slate-200 pt-8 dark:border-white/10">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                                        <div>
                                            <p class="text-xs font-bold tracking-widest text-[#9b1c31] uppercase dark:text-rose-300">
                                                Community Outreach & Engagements
                                            </p>
                                            <h4 class="mt-1 text-xl font-bold tracking-normal text-slate-950 dark:text-white">
                                                Recent Extension Activities
                                            </h4>
                                        </div>
                                        <!-- <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                            20 Community Updates
                                        </span> -->
                                    </div>

                                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                        <a
                                            v-for="activity in (showAllExtensionActivities ? extensionActivities : extensionActivities.slice(0, 6))"
                                            :key="activity.href"
                                            :href="activity.href"
                                            target="_blank"
                                            rel="noreferrer"
                                            class="group relative overflow-hidden rounded-2xl ring-1 ring-slate-900/10 shadow-lg shadow-slate-900/10 transition-all duration-500 hover:ring-[#f2b705] hover:shadow-xl dark:ring-white/15 dark:shadow-black/30"
                                        >
                                            <img
                                                :src="activity.image"
                                                :alt="activity.title"
                                                class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-105"
                                            />
                                            <div
                                                class="absolute inset-0 bg-linear-to-t from-black/85 via-black/35 to-black/5"
                                            ></div>
                                            <div
                                                class="relative flex min-h-52 flex-col justify-end p-5 sm:min-h-56"
                                            >
                                                <h4
                                                    class="text-sm font-bold text-white transition-colors group-hover:text-[#f2b705]"
                                                >
                                                    {{ activity.title }}
                                                </h4>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Show More / Show Less Toggle Button -->
                                    <div class="mt-6 flex justify-center">
                                        <button
                                            type="button"
                                            @click="showAllExtensionActivities = !showAllExtensionActivities"
                                            class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-xs font-bold text-slate-800 shadow-xs transition hover:border-[#1711d4] hover:bg-slate-50 hover:text-[#1711d4] dark:border-white/20 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-sky-300 dark:hover:text-sky-300"
                                        >
                                            <span>{{ showAllExtensionActivities ? 'Show Fewer Activities' : 'View All 20 Extension Activities' }}</span>
                                            <span aria-hidden="true">{{ showAllExtensionActivities ? '↑' : '↓' }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
