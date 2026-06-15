<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Building2,
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    ClipboardCheck,
    ExternalLink,
    FileText,
    Mail,
    Phone,
    UserRound,
} from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { vppsi } from '@/routes/administration';

type Office = {
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

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');

const offices: Office[] = [
    {
        name: 'Procurement Management System Office',
        head: 'Mrs. Ma. Reina S. Acevedo',
        email: 'mrsacevedo@nemsu.edu.ph',
        description:
            'The Procurement Management System Office ensures the efficient, transparent, and compliant acquisition of goods, services, and infrastructure required by the University. It facilitates procurement planning, bidding and awarding processes, contract management, and supplier coordination in adherence to government procurement laws, auditing rules, and institutional guidelines. The office safeguards accountability, promotes fair competition, ensures value for money, and strengthens procurement systems and internal controls.',
    },
    {
        name: 'Alumni Affairs Office',
        head: 'Mrs. Hasmenia Lasque',
        description:
            'The Alumni Affairs Office serves as the University link in fostering lasting relationships and active engagement with its alumni community. It manages programs that strengthen alumni participation in institutional activities, professional networking, community involvement, and University development efforts. The office maintains alumni records, facilitates communication and partnerships, and promotes opportunities for mentorship and career development.',
    },
    {
        name: 'Records Management Office',
        head: 'Mr. Joseph B. Cabadonga, Office In-charge',
        email: 'records@nemsu.edu.ph',
        description:
            'The Records Management Office is responsible for the systematic organization, safekeeping, and proper disposition of the University official records and documents. It ensures that records are accurately maintained, securely stored, and readily accessible in accordance with government archival standards, data privacy regulations, and institutional policies. Through standardized documentation practices, the office supports transparency, accountability, and the preservation of institutional memory.',
    },
    {
        name: 'GAD and Values Restoration Office',
        head: 'Ms. Roxanne T. Sarmiento | Mrs. Marlina Respecia',
        description:
            'The Gender and Development and Values Restoration Office promotes gender equality, inclusivity, and the integration of ethical and moral values across University programs and operations. It implements gender-responsive policies, capacity-building activities, and advocacy programs aligned with national GAD mandates and institutional development goals while fostering a safe, respectful, inclusive, and values-driven academic environment.',
    },
    {
        name: 'Information and Public Affairs Office',
        head: 'Mr. Joseph B. Cabadonga',
        email: 'information@nemsu.edu.ph',
        description:
            'The Information and Public Affairs Office manages the University official communications, public relations, and information dissemination strategies. It ensures accurate, timely, and transparent sharing of institutional updates, programs, and achievements through various media platforms. The office strengthens the University public image, coordinates media relations, produces official content, and supports consistent and credible internal and external communication.',
    },
    {
        name: 'Quality Assurance Office',
        head: 'Engr. Leah Guirimbao',
        email: 'qa@nemsu.edu.ph',
        description:
            'The Quality Assurance Office ensures that the University consistently upholds high standards in academic and administrative operations. It manages quality assurance systems, performance evaluation mechanisms, accreditation activities, and compliance monitoring across all units. Through sustained monitoring and data-driven improvement, the office strengthens institutional quality, accountability, credibility, and competitiveness.',
    },
    {
        name: 'Planning Office',
        head: 'Engr. Kennie F. Montenegro',
        email: 'planning@nemsu.edu.ph',
        description:
            'The Planning Office leads the development, coordination, and monitoring of the University strategic and operational plans to ensure alignment with its vision, mission, and institutional goals. It facilitates evidence-based planning, consolidates data and performance indicators, and develops plans, proposals, and policy frameworks that guide institutional growth, governance, and resource allocation.',
    },
    {
        name: 'General Services Office',
        head: 'Engr. McDonald Amparo',
        email: 'gsu@nemsu.edu.ph',
        description:
            'The General Services Office ensures the efficient delivery of essential support services that maintain the functionality, safety, and order of University facilities and operations. It oversees building and equipment maintenance, campus cleanliness, security support coordination, utilities management, and other logistical services required for a safe, well-maintained, and conducive learning and working environment.',
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="Planning and Strategic Initiatives" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate overflow-hidden bg-[#1711d4] py-16 text-white sm:py-20"
            >
                <div
                    class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.18),transparent_38%),radial-gradient(circle_at_bottom_right,rgba(242,183,5,0.2),transparent_35%)]"
                ></div>
                <div
                    class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-[1.25fr_0.75fr] lg:px-8"
                >
                    <div>
                        <p
                            class="inline-flex rounded bg-white/10 px-3 py-1 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                        >
                            Planning and Strategic Initiatives
                        </p>
                        <h1
                            class="mt-5 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                        >
                            Office of the Vice President for Planning and
                            Strategic Initiatives
                        </h1>
                        <p
                            class="mt-5 max-w-3xl text-lg leading-8 text-sky-100"
                        >
                            OVPPSI leads strategic planning, institutional
                            quality, communication, procurement, records, alumni
                            engagement, and essential support services.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a
                                href="#ovppsi-offices"
                                class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-semibold text-[#1711d4] transition hover:bg-[#f2b705] hover:text-slate-950"
                            >
                                Explore offices
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </a>
                            <Link
                                :href="home()"
                                class="inline-flex items-center rounded-md border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-[#1711d4]"
                            >
                                Back to Home
                            </Link>
                        </div>
                    </div>

                    <article
                        id="ovppsi-profile"
                        class="rounded-3xl border border-white/15 bg-white/10 p-6 shadow-2xl shadow-slate-950/25 backdrop-blur sm:p-8"
                    >
                        <span
                            class="inline-flex size-14 items-center justify-center rounded-2xl bg-white text-[#1711d4]"
                        >
                            <UserRound class="size-7" aria-hidden="true" />
                        </span>
                        <p
                            class="mt-6 text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                        >
                            Vice President
                        </p>
                        <h2 class="mt-2 text-2xl font-semibold">
                            Dr. Florife O. Urbiztondo
                        </h2>
                        <p class="mt-3 text-sm leading-7 text-sky-100">
                            Vice President for Planning and Strategic
                            Initiatives
                        </p>
                    </article>
                </div>
            </section>

            <section id="ovppsi-offices" class="py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Offices under OVPPSI
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal sm:text-4xl"
                        >
                            Planning and strategic service directory
                        </h2>
                    </div>

                    <div class="mt-10 grid gap-5 lg:grid-cols-2">
                        <article
                            v-for="office in offices"
                            :key="office.name"
                            class="flex flex-col rounded-2xl border border-slate-200 bg-[#f8fafc] p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                        >
                            <div class="flex items-start gap-4">
                                <span
                                    class="inline-flex size-11 shrink-0 items-center justify-center rounded-xl bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                                >
                                    <Building2
                                        class="size-5"
                                        aria-hidden="true"
                                    />
                                </span>
                                <div>
                                    <h3 class="text-lg leading-7 font-semibold">
                                        {{ office.name }}
                                    </h3>
                                    <p
                                        class="mt-1 text-sm font-semibold text-[#0b6680] dark:text-sky-300"
                                    >
                                        {{ office.head }}
                                    </p>
                                </div>
                            </div>

                            <p
                                class="mt-5 grow text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ office.description }}
                            </p>

                            <div
                                class="mt-6 grid gap-2 border-t border-slate-200 pt-5 text-sm dark:border-white/10"
                            >
                                <a
                                    v-if="office.email"
                                    :href="`mailto:${office.email}`"
                                    class="inline-flex items-center gap-3 text-slate-700 transition hover:text-[#1711d4] dark:text-slate-200 dark:hover:text-sky-200"
                                >
                                    <Mail
                                        class="size-4 shrink-0"
                                        aria-hidden="true"
                                    />
                                    {{ office.email }}
                                </a>
                                <span
                                    v-else
                                    class="inline-flex items-center gap-3 text-slate-400 dark:text-slate-500"
                                >
                                    <Mail
                                        class="size-4 shrink-0"
                                        aria-hidden="true"
                                    />
                                    Email not provided
                                </span>
                                <a
                                    v-if="office.phone"
                                    :href="`tel:${office.phone}`"
                                    class="inline-flex items-center gap-3 text-slate-700 transition hover:text-[#1711d4] dark:text-slate-200 dark:hover:text-sky-200"
                                >
                                    <Phone
                                        class="size-4 shrink-0"
                                        aria-hidden="true"
                                    />
                                    {{ office.phone }}
                                </a>
                                <span
                                    v-else
                                    class="inline-flex items-center gap-3 text-slate-400 dark:text-slate-500"
                                >
                                    <Phone
                                        class="size-4 shrink-0"
                                        aria-hidden="true"
                                    />
                                    Contact number not provided
                                </span>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section
                id="bac-matters"
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 sm:p-8 dark:border-white/10 dark:bg-white/4"
                    >
                        <ClipboardCheck
                            class="size-8 text-[#0b3d91] dark:text-sky-200"
                            aria-hidden="true"
                        />
                        <h2 class="mt-4 text-3xl font-semibold">BAC Matters</h2>
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
                                            <h3
                                                class="mt-2 text-sm leading-6 font-semibold text-slate-950 dark:text-white"
                                            >
                                                {{ matter.name }}
                                            </h3>
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
