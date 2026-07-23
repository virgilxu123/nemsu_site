<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    ClipboardCheck,
    ExternalLink,
    FileText,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { show as officeShow } from '@/actions/App/Http/Controllers/VppsiOfficeController';
import { home } from '@/routes';
import { vppsi } from '@/routes/administration';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type Office = {
    id: string;
    name: string;
    head: string;
    description: string;
    email?: string;
    phone?: string;
};

type BacMatterFilter = {
    label: string;
    value: string;
};

type BacMatterItem = {
    id: number;
    name: string;
    type: string;
    date: string | null;
    destinationUrl: string | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedBacMatters = {
    data: BacMatterItem[];
    from: number | null;
    links: PaginationLink[];
    to: number | null;
    total: number;
};

defineProps<{
    filters: {
        activeType: string;
        options: BacMatterFilter[];
    };
    matters: PaginatedBacMatters;
}>();

const heroBackgroundImage =
    '/images/administration/ovpaf/6I3A7029(1).jpg';

const vicePresidentImage =
    '/images/administration/ovpaf/URBIZTONDO,%20FLORIFE,%20O%20SFFB%20NEMSU_4532%20copy.jpg';

const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['ovppsi-hero']));
let revealObserver: IntersectionObserver | null = null;

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');

const offices: Office[] = [
    {
        id: 'procurement-management-system-office',
        name: 'Procurement Management System Office',
        head: 'Mrs. Ma. Reina S. Acevedo',
        email: 'mrsacevedo@nemsu.edu.ph',
        description:
            'The Procurement Management System Office ensures the efficient, transparent, and compliant acquisition of goods, services, and infrastructure required by the University. It facilitates procurement planning, bidding and awarding processes, contract management, and supplier coordination in adherence to government procurement laws, auditing rules, and institutional guidelines. The office safeguards accountability, promotes fair competition, ensures value for money, and strengthens procurement systems and internal controls.',
    },
    {
        id: 'alumni-affairs-office',
        name: 'Alumni Affairs Office',
        head: 'Mrs. Hasmenia Lasque',
        description:
            'The Alumni Affairs Office serves as the University link in fostering lasting relationships and active engagement with its alumni community. It manages programs that strengthen alumni participation in institutional activities, professional networking, community involvement, and University development efforts. The office maintains alumni records, facilitates communication and partnerships, and promotes opportunities for mentorship and career development.',
    },
    {
        id: 'records-management-office',
        name: 'Records Management Office',
        head: 'Mr. Joseph B. Cabadonga, Office In-charge',
        email: 'records@nemsu.edu.ph',
        description:
            'The Records Management Office is responsible for the systematic organization, safekeeping, and proper disposition of the University official records and documents. It ensures that records are accurately maintained, securely stored, and readily accessible in accordance with government archival standards, data privacy regulations, and institutional policies. Through standardized documentation practices, the office supports transparency, accountability, and the preservation of institutional memory.',
    },
    {
        id: 'gad-and-values-restoration-office',
        name: 'GAD and Values Restoration Office',
        head: 'Ms. Roxanne T. Sarmiento | Mrs. Marlina Respecia',
        description:
            'The Gender and Development and Values Restoration Office promotes gender equality, inclusivity, and the integration of ethical and moral values across University programs and operations. It implements gender-responsive policies, capacity-building activities, and advocacy programs aligned with national GAD mandates and institutional development goals while fostering a safe, respectful, inclusive, and values-driven academic environment.',
    },
    {
        id: 'information-and-public-affairs-office',
        name: 'Information and Public Affairs Office',
        head: 'Mr. Joseph B. Cabadonga',
        email: 'information@nemsu.edu.ph',
        description:
            'The Information and Public Affairs Office manages the University official communications, public relations, and information dissemination strategies. It ensures accurate, timely, and transparent sharing of institutional updates, programs, and achievements through various media platforms. The office strengthens the University public image, coordinates media relations, produces official content, and supports consistent and credible internal and external communication.',
    },
    {
        id: 'quality-assurance-office',
        name: 'Quality Assurance Office',
        head: 'Engr. Leah Guirimbao',
        email: 'qa@nemsu.edu.ph',
        description:
            'The Quality Assurance Office ensures that the University consistently upholds high standards in academic and administrative operations. It manages quality assurance systems, performance evaluation mechanisms, accreditation activities, and compliance monitoring across all units. Through sustained monitoring and data-driven improvement, the office strengthens institutional quality, accountability, credibility, and competitiveness.',
    },
    {
        id: 'planning-office',
        name: 'Planning Office',
        head: 'Engr. Kennie F. Montenegro',
        email: 'planning@nemsu.edu.ph',
        description:
            'The Planning Office leads the development, coordination, and monitoring of the University strategic and operational plans to ensure alignment with its vision, mission, and institutional goals. It facilitates evidence-based planning, consolidates data and performance indicators, and develops plans, proposals, and policy frameworks that guide institutional growth, governance, and resource allocation.',
    },
    {
        id: 'general-services-office',
        name: 'General Services Office',
        head: 'Engr. McDonald Amparo',
        email: 'gsu@nemsu.edu.ph',
        description:
            'The General Services Office ensures the efficient delivery of essential support services that maintain the functionality, safety, and order of University facilities and operations. It oversees building and equipment maintenance, campus cleanliness, security support coordination, utilities management, and other logistical services required for a safe, well-maintained, and conducive learning and working environment.',
    },
];

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
        <Head title="Planning and Strategic Initiatives" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate z-10 overflow-visible bg-slate-950 py-16 text-white sm:py-20"
            >
                <img
                    :src="heroBackgroundImage"
                    alt=""
                    class="pointer-events-none absolute inset-0 z-0 h-full w-full object-cover object-center opacity-60 select-none"
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
                    data-scroll-section="ovppsi-hero"
                    :class="revealClasses('ovppsi-hero')"
                    class="relative z-10 mx-auto grid max-w-7xl items-center gap-10 px-4 pb-24 sm:px-6 sm:pb-28 lg:grid-cols-[1.25fr_0.75fr] lg:px-8 lg:pb-12"
                >
                    <div>
                        <p
                            class="inline-flex rounded bg-white/10 px-3 py-1 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                        >
                            Planning and Strategic Initiatives
                        </p>
                        <h3
                            class="mt-5 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                        >
                            Office of the Vice President for Planning and
                            Strategic Initiatives
                        </h3>

                        <nav
                            aria-label="Breadcrumb"
                            class="mt-8 text-sm font-semibold"
                        >
                            <ol class="flex flex-wrap items-center gap-2">
                                <li>
                                    <Link
                                        :href="home()"
                                        class="text-white/80 transition hover:text-[#f2b705]"
                                    >
                                        Home
                                    </Link>
                                </li>
                                <li class="text-white/45" aria-hidden="true">
                                    /
                                </li>
                                <li class="text-[#f2b705]" aria-current="page">
                                    Planning and Strategic Initiatives
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div aria-hidden="true" class="hidden lg:block"></div>
                </div>
            </section>

            <section
                id="ovppsi-profile-details"
                class="relative z-20 pt-10 pb-14 sm:pt-12 sm:pb-16 lg:pt-0"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-start lg:gap-12 lg:px-8"
                >
                    <div
                        data-scroll-section="ovppsi-overview"
                        :class="revealClasses('ovppsi-overview', 'right')"
                        class="max-w-3xl pt-8 lg:pt-20"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Overview
                        </p>
                        <h3
                            class="mt-3 text-3xl font-semibold tracking-normal sm:text-4xl"
                        >
                            Aligning Plans, Quality, and Institutional Growth
                        </h3>
                        <p
                            class="mt-5 text-uni-body text-slate-600 dark:text-slate-300"
                        >
                            The Office of the Vice President for Planning and
                            Strategic Initiatives leads strategic planning,
                            institutional quality, procurement coordination,
                            communication, records management, alumni
                            engagement, gender and values programs, and
                            essential support services.
                        </p>
                        <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300"
                        >
                            OVPPSI strengthens evidence-based planning,
                            transparent operations, and responsive service
                            delivery so University offices can align programs,
                            resources, and performance indicators with NEMSU's
                            long-term development goals.
                        </p>
                    </div>

                    <article
                        id="ovppsi-profile"
                        data-scroll-section="ovppsi-profile"
                        :class="revealClasses('ovppsi-profile', 'left')"
                        class="order-first z-20 mx-auto -mt-24 w-full max-w-sm overflow-hidden bg-white/30 text-slate-950 shadow-[0_24px_70px_rgba(15,23,42,0.28)] ring-1 ring-white/45 backdrop-blur-2xl sm:-mt-28 lg:order-none lg:sticky lg:top-24 lg:mt-[-8.5rem] lg:self-start dark:bg-slate-950/35 dark:text-white dark:ring-white/15"
                    >
                        <div class="relative overflow-hidden">
                            <img
                                :src="vicePresidentImage"
                                alt="Dr. Florife O. Urbiztondo"
                                class="h-96 w-full object-cover object-top [filter:contrast(.96)_saturate(.96)_blur(.2px)]"
                            />
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
                                Dr. Florife O. Urbiztondo
                            </h3>
                            <p
                                class="mt-3 border-t border-slate-200 pt-4 text-sm leading-6 text-slate-600 dark:border-white/10 dark:text-sky-100"
                            >
                                Vice President for Planning and Strategic
                                Initiatives
                            </p>
                        </div>
                    </article>
                </div>
            </section>

            <section
                id="ovppsi-offices"
                class="bg-[#1f007c] py-14 text-white sm:py-16"
            >
                <div
                    data-scroll-section="ovppsi-offices"
                    :class="revealClasses('ovppsi-offices')"
                    class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
                >
                    <p
                        class="text-sm font-semibold tracking-wide text-[#ffbf00] uppercase"
                    >
                        Offices under OVPPSI
                    </p>
                    <nav
                        aria-label="Offices under OVPPSI"
                        class="mt-10 grid gap-x-12 gap-y-7 text-left sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <Link
                            v-for="office in offices"
                            :key="office.name"
                            :href="officeShow.url(office.id)"
                            class="group inline-flex items-center justify-start gap-2 text-left text-sm font-bold text-white transition hover:text-[#f2b705] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#f2b705] lg:text-base"
                        >
                            <span>{{ office.name }}</span>
                            <span
                                class="text-[#f2b705] transition group-hover:translate-x-1"
                                aria-hidden="true"
                            >
                                &gt;
                            </span>
                        </Link>
                    </nav>
                </div>
            </section>

            <section
                id="bac-matters"
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="bac-matters"
                        :class="revealClasses('bac-matters')"
                    >
                        <h3 class="mt-4 text-3xl font-semibold">BAC Matters</h3>
                        <p
                            class="mt-3 max-w-3xl text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Browse published procurement notices and documents
                            from the Bids and Awards Committee.
                        </p>

                        <div
                            class="mt-8 grid gap-6 lg:grid-cols-[16rem_minmax(0,1fr)]"
                        >
                            <nav
                                class="grid content-start gap-2 sm:grid-cols-2 lg:grid-cols-1"
                                aria-label="BAC matter categories"
                            >
                                <Link
                                    v-for="filter in filters.options"
                                    :key="filter.value"
                                    :href="
                                        vppsi({
                                            query: { type: filter.value },
                                        })
                                    "
                                    :only="['filters', 'matters']"
                                    preserve-state
                                    preserve-scroll
                                    :aria-current="
                                        filters.activeType === filter.value
                                            ? 'page'
                                            : undefined
                                    "
                                    :class="[
                                        'rounded-md border px-4 py-3 text-left text-sm font-semibold transition',
                                        filters.activeType === filter.value
                                            ? 'border-[#1711d4] bg-[#1711d4] text-white shadow-sm'
                                            : 'border-slate-200 bg-[#f8fafc] text-slate-700 hover:border-[#1711d4]/40 hover:text-[#1711d4] dark:border-white/10 dark:bg-white/5 dark:text-slate-200 dark:hover:text-sky-200',
                                    ]"
                                >
                                    {{ filter.label }}
                                </Link>
                            </nav>

                            <div class="min-w-0">
                                <div
                                    v-if="matters.data.length > 0"
                                    class="overflow-hidden rounded-md border border-slate-200 dark:border-white/10"
                                >
                                    <article
                                        v-for="matter in matters.data"
                                        :key="matter.id"
                                        class="flex flex-col gap-4 border-b border-slate-200 p-4 last:border-b-0 sm:flex-row sm:items-center sm:justify-between dark:border-white/10"
                                    >
                                        <div class="min-w-0">
                                            <div
                                                class="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400"
                                            >
                                                <span
                                                    class="rounded bg-[#e7f3fb] px-2 py-1 text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                                                >
                                                    {{ matter.type }}
                                                </span>
                                                <span
                                                    v-if="matter.date"
                                                    class="inline-flex items-center gap-1.5"
                                                >
                                                    <CalendarDays
                                                        class="size-3.5"
                                                        aria-hidden="true"
                                                    />
                                                    {{ matter.date }}
                                                </span>
                                            </div>
                                            <h5
                                                class="mt-2 text-sm leading-6 font-semibold text-slate-950 dark:text-white"
                                            >
                                                {{ matter.name }}
                                            </h5>
                                        </div>

                                        <a
                                            v-if="matter.destinationUrl"
                                            :href="matter.destinationUrl"
                                            target="_blank"
                                            rel="noopener"
                                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-md border border-[#1711d4]/20 px-3 py-2 text-sm font-semibold text-[#1711d4] transition hover:border-[#1711d4] hover:bg-[#1711d4] hover:text-white dark:border-sky-300/20 dark:text-sky-200 dark:hover:bg-sky-300 dark:hover:text-slate-950"
                                        >
                                            <FileText
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                            View document
                                            <ExternalLink
                                                class="size-3.5"
                                                aria-hidden="true"
                                            />
                                        </a>
                                        <span
                                            v-else
                                            class="shrink-0 text-sm text-slate-400 dark:text-slate-500"
                                        >
                                            Document unavailable
                                        </span>
                                    </article>
                                </div>

                                <div
                                    v-else
                                    class="rounded-md border border-dashed border-slate-300 p-8 text-center text-sm text-slate-600 dark:border-white/15 dark:text-slate-300"
                                >
                                    No published BAC matters are available in
                                    this category.
                                </div>

                                <div
                                    v-if="matters.links.length > 3"
                                    class="mt-5 flex flex-wrap items-center justify-between gap-4"
                                >
                                    <p
                                        class="text-sm text-slate-600 dark:text-slate-400"
                                    >
                                        Showing {{ matters.from ?? 0 }} to
                                        {{ matters.to ?? 0 }} of
                                        {{ matters.total }} records
                                    </p>

                                    <nav
                                        class="flex flex-wrap gap-2"
                                        aria-label="BAC matters pagination"
                                    >
                                        <Link
                                            v-for="link in matters.links"
                                            :key="`${link.label}-${link.url}`"
                                            :href="link.url ?? '#'"
                                            preserve-scroll
                                            preserve-state
                                            :only="['filters', 'matters']"
                                            :class="[
                                                'inline-flex min-h-9 min-w-9 items-center justify-center rounded-md border px-3 text-sm font-semibold transition',
                                                link.active
                                                    ? 'border-[#1711d4] bg-[#1711d4] text-white'
                                                    : 'border-slate-200 text-slate-700 hover:border-[#1711d4] hover:text-[#1711d4] dark:border-white/10 dark:text-slate-200',
                                                link.url === null &&
                                                    'pointer-events-none opacity-50',
                                            ]"
                                        >
                                            <ChevronLeft
                                                v-if="
                                                    paginationLabel(
                                                        link.label,
                                                    ) === 'Previous'
                                                "
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                            <ChevronRight
                                                v-else-if="
                                                    paginationLabel(
                                                        link.label,
                                                    ) === 'Next'
                                                "
                                                class="size-4"
                                                aria-hidden="true"
                                            />
                                            <span v-else>{{
                                                paginationLabel(link.label)
                                            }}</span>
                                        </Link>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
