<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    ArrowUpRight,
    BadgeCheck,
    Building2,
    Mail,
    Phone,
    ShieldCheck,
    UserRound,
} from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { citizensCharter, transparencySeal } from '@/routes/administration';

type Office = {
    name: string;
    head: string;
    description: string;
    email?: string;
    phone?: string;
};

const offices: Office[] = [
    {
        name: 'Chief Administrative Office - Finance Division',
        head: 'Dr. Camilo Malong',
        email: 'chiefAO_FinanceDivision@nemsu.edu.ph',
        phone: '09125813688',
        description:
            'The CAO-Finance supervises the Financial Services Unit of the university and ensures the effective implementation of financial operations and services. The office reviews reports required by regulatory agencies such as the DBM, CHED, and CSC, and prepares memoranda, communications, terminal reports, training designs, proposals, and related documents. It also reviews supporting documents for vouchers and Budget Utilization Requests/Obligation Requests, conducts consultations and information services on financial operations, and oversees periodic monitoring and evaluation of the performance of financial units. In addition, the CAO-Finance facilitates workshops, seminars, and training programs, conducts orientations on financial matters across campuses, submits accomplishment reports on supervisory plan implementation, and performs other related functions as directed by the immediate supervisor.',
    },
    {
        name: 'Chief Administrative Office - Administration Division',
        head: 'Dr. Florife O. Urbiztondo',
        email: 'caoad@nemsu.edu.ph',
        description:
            'The office supervises the non-teaching personnel of the university and ensures compliance with the requirements of regulatory agencies such as the DBM, CHED, and CSC through the preparation of necessary reports and documents. It is also responsible for drafting memoranda, communications, terminal reports, training proposals, and activity designs, as well as reviewing reports on the university’s administrative and financial operations. In addition, the office reviews supporting documents for vouchers, Budget Utilization Requests (BUR), Obligation Requests (OR), the consolidated Annual Procurement Plan (APP), and semestral contracts of service for faculty and employees. It also conducts orientations on administrative and financial matters across campuses and performs other related functions as assigned by the University President.',
    },
    {
        name: 'Supervising Administrative Office - Finance Division',
        head: 'Mrs. Leorilie Kim Estrada',
        description:
            'The SAO-Finance oversees the Accounting Unit, Budget Unit, and other financial offices of the university. The office assists the Chief Administrative Officer for Finance in ensuring the smooth and efficient operation of all units under the Finance Division and aligns work processes and outputs with institutional priorities, internal policies, and external regulatory requirements. It supervises the preparation of budget and financial management functions and activities, while also reviewing, developing, and recommending internal work processes, standards, guidelines, and procedures in compliance with the Quality Management System (QMS) and other oversight agencies. In addition, the SAO-Finance evaluates and submits periodic and special reports, monitors the performance of subordinates against established standards, prepares the Work and Financial Plan (WFP) and Project Procurement Management Plan (PPMP) of the office, assumes the duties of the Chief Administrative Officer in their absence, and performs other regular or special functions as may be assigned from time to time.',
    },
    {
        name: 'Supervising Administrative Office - Administration Division',
        head: 'Engr. Christopher Badayos',
        description:
            'The Supervising Administrative Officer for Administration (SAO-Admin) oversees the Human Resource Management (HRM), Supply, Cashier, and other allied sections or units that may be established by the University President in accordance with the university’s organizational structure. The office assists the Chief Administrative Officer for Administration in managing the daily operations of administrative units and ensures the quality delivery of services in areas such as Property and Supply, Records, HR, Cashier, Project Management Unit, and General Services. It also aligns office processes and outputs with institutional priorities and applicable policies, prepares the Project Procurement Management Plan (PPMP), evaluates and submits periodic and special reports, and monitors the performance standards of units under its supervision. In addition, the SAO-Admin ensures the conduct of Complete Staff Work (CSW) on matters requiring the Chief’s attention, assumes the functions of the Chief Administrative Officer in their absence, submits accomplishment reports on supervisory plan implementation, and performs other duties as may be assigned from time to time.',
    },
    {
        name: 'Accounting Office',
        head: 'Mr. Calvin R. Sillar',
        email: 'accounting@nemsu.edu.ph',
        description:
            'The Accounting Unit is responsible for ensuring the accuracy, validity, and completeness of the university’s financial records and transactions. It checks the appropriateness of supporting documents and validates claims attached to Disbursement Vouchers (DVs), reviews journal entries and signs Journal Entry Vouchers (JEVs) for all funds, and examines liquidation reports submitted by accountable officers to certify the completeness of supporting documents. The office also prepares consolidated financial statements, monitors general and subsidiary ledgers, and prepares the office’s Project Procurement Management Plan (PPMP) and activity proposals. In addition, it prepares and certifies the correctness of financial reports such as FARs, BEDs, and payroll-related documents, oversees the overall operations of the Accounting Unit including report submissions to regulatory agencies, reviews the accuracy of computations and remittances of mandatory deductions, and performs other related tasks as assigned by immediate supervisors.',
    },
    {
        name: 'Budget Office',
        head: 'Mrs. Sandra Jessa S. Trajano',
        email: 'budget@nemsu.edu.ph',
        description:
            'The Budget Unit is responsible for overseeing and managing the university’s budgetary planning, allocation, monitoring, and reporting processes. It reviews and signs budgetary documents such as ORS/BURS, PRs, proposals, and PPMPs to ensure the availability of appropriations, allotments, and budgets. The office also monitors, records, and files SAROs and NCAs, prepares budget registries for all funds, and consolidates budgetary reports including FARs, BEDs, BP Forms, and Budget Utilization Reports. In addition, it encodes and submits the Agency Budget Proposal through the Online Submission of Budget Proposals (OSBP), finalizes budget proposals for submission to the DBM, and prepares reports required by Congress and other oversight agencies. The unit also organizes budget-related activities such as Budget Calls, Budget Forums, and Budget Presentations, monitors the implementation of proposed PAPs, reviews budgetary reports for STF and IGP, attends meetings and activities initiated by DBM, COA, NEDA, and other agencies, prepares the PPMP and activity proposals of the office, and performs other related tasks assigned by immediate supervisors.',
    },
    {
        name: 'Human Resource Management Office',
        head: 'Ms. Eunice Prado',
        email: 'hrmo.tandag@nemsu.edu.ph',
        description:
            'The Human Resource Management Office (HRMO) is responsible for overseeing recruitment, selection, and placement; performance management; rewards and recognition; learning and development; maintenance of personnel records; and the formulation of policies, rules, standards, and guidelines related to personnel management. Headed by the Human Resource Management Officer III, the office ensures the efficient administration of human resource functions within the university. The HRMO III is tasked with listing candidates aspiring for vacant positions, conducting preliminary evaluations of applicants’ qualifications, preparing and posting notices of vacant positions in compliance with CSC rules and regulations, notifying applicants of evaluation results, and submitting the selection lineup to the Personnel Selection Board (PSB) for deliberation.',
    },
    {
        name: 'Supply Office',
        head: 'Mrs. Jovelyn Clarit',
        email: 'supplyofficemain@gmail.com',
        description:
            'The Supply Office is responsible for the management, accountability, and proper distribution of the university’s supplies, materials, equipment, and other assets. It oversees the checking, acceptance, and receipt of deliveries intended for distribution and ensures equitable allocation based on the approved procurement program. The office also maintains records of books, supplies, materials, equipment, buildings, and other properties, including their accession and inventory. In addition, it prepares bills of lading, requisitions, and supporting documents for vouchers, conducts periodic physical and written inventories, processes insurance and licenses of school properties, and manages the maintenance, repair, storage, and warehousing of assets. The office likewise handles the disposal process of unserviceable properties, prepares supply management reports, and performs other related tasks as may be assigned by higher authorities.',
    },
    {
        name: 'Cashier Office',
        head: 'Mrs. Glesilda L. Canda',
        description:
            'The Cashier Office is responsible for the proper handling, disbursement, collection, and monitoring of the university’s financial transactions and funds. It manages the signing and processing of issued checks, LDDAP, ADA, ACIC, and related financial documents as approved by authorized officials, as well as the deposit of collections, income, and refunds to authorized banks. The office also handles cash withdrawals and disbursements for cash advances, honoraria, TES, and other compensation benefits, while maintaining accurate records of checks, deposits, and disbursement transactions. In addition, it advises management on fund collection and disbursement, processes payments to dealers and agencies, prepares liquidation and petty cash replenishment reports, and reviews, monitors, and submits financial reports to management and government agencies. The office is likewise responsible for issuing official receipts, supervising cashiering personnel, participating in finance committees during university activities, coordinating with the accountant and budget officer regarding fund availability, and performing other related administrative and financial functions.',
    },
    {
        name: 'Income-Generating Project and Auxiliary Services Office',
        head: 'Mr. Roel T. Lim',
        description:
            'The Income-Generating Projects (IGP) and Auxiliary Services Office is responsible for developing, managing, and strengthening the university’s income-generating initiatives and auxiliary services to support institutional sustainability and resource generation. The office formulates and reviews proposals, guidelines, and feasibility studies for various production and commercial projects across colleges and campuses, ensuring that these initiatives maximize available resources and contribute to the university’s development goals. It also oversees and evaluates production operations, auxiliary services, and prototype projects, while coordinating with campus units and stakeholders to improve efficiency, expand services, and promote the commercialization of university products and services. Additionally, the office consolidates production data and reports, facilitates coordination among personnel involved in production activities, and supports capability-building initiatives related to project and production management.',
    },
    {
        name: 'Disaster Risk Management Office',
        head: 'Mr. Robert R. Wariza',
        description:
            'The Disaster Risk Reduction and Management (DRRM) Office is responsible for ensuring the safety, preparedness, and resilience of the university community and its infrastructure through a comprehensive disaster risk management approach. The office serves as the primary coordinating body for disaster prevention and mitigation, preparedness, response, rehabilitation, and recovery across all university campuses. It develops and implements safety policies, conducts hazard assessments and structural evaluations, and promotes campus readiness through trainings, drills, and emergency planning activities. During emergencies and disasters, the office manages response operations, evacuation procedures, and resource coordination to protect lives and properties. It also oversees post-disaster recovery efforts, including damage assessment, restoration of essential services, psychosocial support, and coordination with local government units and disaster management agencies to ensure the continuity of university operations and the welfare of the academic community.',
    },
    {
        name: 'Energy Efficiency and Conservation Office',
        head: 'Engr. Kennie Montenegro',
        description:
            'The Energy Efficiency and Conservation Office is responsible for promoting and implementing sustainable energy management practices within the university in support of government energy conservation programs and institutional sustainability goals. The office prepares, formulates, and submits the university’s Energy Efficiency and Conservation Plan (EECP) consistent with the Government Energy Management Program (GEMP), and ensures the timely submission of monthly energy performance reports and annual energy efficiency and conservation programs to the Department of Energy (DOE). It also oversees the implementation, monitoring, and continuous improvement of energy efficiency measures across university offices, buildings, and facilities to promote responsible energy use and operational efficiency. Additionally, the office performs other related tasks as may be assigned by the immediate head.',
    },
];

const governanceItems = [
    {
        title: 'Transparency Seal',
        description:
            'Public accountability resources, annual financial reports, and transparency records.',
        href: transparencySeal().url,
    },
    {
        title: "Citizen's Charter",
        description:
            'Service standards and commitments for university stakeholders.',
        href: citizensCharter().url,
    },
];

const freedomOfInformationResources = [
    {
        category: 'Manual',
        title: "People's FOI Manual",
        year: 'Current',
        href: 'https://drive.google.com/file/d/1S2QPmPW-sx98hcPxa6VTxzQ7X8ZpuBBf/view?pli=1',
    },
    {
        category: 'Manual',
        title: 'NEMSU One-Page Freedom of Information Manual',
        year: 'Current',
        href: 'https://drive.google.com/file/d/1T4_eUD8SAtTlDvvQGjNPNBjOeCNAACQO/view?usp=sharing',
    },
    {
        category: 'Form',
        title: 'NEMSU FOI Request Feedback Survey Form',
        year: 'Current',
        href: 'https://drive.google.com/file/d/1l1oAYuVyRquzj0e03E2_jcS-d0cmLPAm/view',
    },
    {
        category: 'Report',
        title: 'Freedom of Information Report',
        year: '2024',
        href: 'https://docs.google.com/spreadsheets/d/1Vi7eTrjR2FrY-7CwmHUXOYxlPNhHoKBy/edit?usp=drive_link&ouid=118069644834388500470&rtpof=true&sd=true',
    },
    {
        category: 'Report',
        title: 'Freedom of Information Report',
        year: '2023',
        href: 'https://docs.google.com/spreadsheets/d/13RwB_ZvmJwUnoWJbXiPhDhM6olvSdS2D/edit?usp=sharing',
    },
    {
        category: 'Report',
        title: 'Freedom of Information Report',
        year: '2022',
        href: 'https://docs.google.com/spreadsheets/d/1-peJiXcwBVjAdspKYb-QfTas4nO5cytZ/edit?usp=sharing',
    },
    {
        category: 'Report',
        title: 'Freedom of Information Report',
        year: '2021',
        href: 'https://docs.google.com/spreadsheets/d/1HQUNHkxSsrr5YRp2idNBvH2Sse3VauU3/edit?usp=sharing',
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head
            title="Office of the Vice President for Administration and Finance"
        />

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
                            Administration and Finance
                        </p>
                        <h1
                            class="mt-5 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                        >
                            Office of the Vice President for Administration and
                            Finance
                        </h1>
                        <p
                            class="mt-5 max-w-3xl text-lg leading-8 text-sky-100"
                        >
                            OVPAF leads the University’s administrative,
                            financial, personnel, property, safety, and
                            institutional support services.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a
                                href="#ovpaf-offices"
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
                        id="ovpaf-profile"
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
                            OIC Vice President
                        </p>
                        <h2 class="mt-2 text-2xl font-semibold">
                            Atty. Mitchiko Donaire-Maglinte
                        </h2>
                        <p class="mt-3 text-sm leading-7 text-sky-100">
                            OIC-Vice President for Administration and Finance
                        </p>
                    </article>
                </div>
            </section>

            <section id="ovpaf-offices" class="py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Offices under OVPAF
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal sm:text-4xl"
                        >
                            Administrative and financial service directory
                        </h2>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            These offices coordinate the resources, systems, and
                            support services that sustain University operations
                            across campuses.
                        </p>
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
                                    <h3
                                        class="text-lg leading-7 font-semibold text-slate-950 dark:text-white"
                                    >
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
                id="good-governance"
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 sm:py-16 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Good Governance
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                            Accountability and public service
                        </h2>
                    </div>

                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <article
                            v-for="(item, index) in governanceItems"
                            :key="item.title"
                            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                        >
                            <span
                                class="inline-flex size-11 items-center justify-center rounded-xl bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <ShieldCheck
                                    v-if="index === 0"
                                    class="size-5"
                                    aria-hidden="true"
                                />
                                <BadgeCheck
                                    v-else
                                    class="size-5"
                                    aria-hidden="true"
                                />
                            </span>
                            <h3 class="mt-4 text-xl font-semibold">
                                {{ item.title }}
                            </h3>
                            <p
                                class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ item.description }}
                            </p>
                            <Link
                                v-if="item.href"
                                :href="item.href"
                                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
                            >
                                View resource
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </Link>
                            <p
                                v-else
                                class="mt-5 text-xs font-semibold tracking-wide text-slate-400 uppercase dark:text-slate-500"
                            >
                                Resource link pending
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="freedom-of-information" class="py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Good Governance
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal">
                            Freedom of Information
                        </h2>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Manuals, request resources, and annual FOI reports
                            are tabulated below for convenient public access.
                        </p>
                    </div>

                    <div
                        class="mt-8 overflow-hidden rounded-2xl border border-slate-200 shadow-sm shadow-slate-900/5 dark:border-white/10"
                    >
                        <div class="overflow-x-auto">
                            <table
                                class="min-w-full divide-y divide-slate-200 dark:divide-white/10"
                            >
                                <thead
                                    class="bg-slate-950 text-left text-white"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-5 py-4 text-xs font-semibold tracking-wide uppercase"
                                        >
                                            Category
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-5 py-4 text-xs font-semibold tracking-wide uppercase"
                                        >
                                            Document
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-5 py-4 text-xs font-semibold tracking-wide uppercase"
                                        >
                                            Year
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-5 py-4 text-right text-xs font-semibold tracking-wide uppercase"
                                        >
                                            Access
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-slate-200 bg-white dark:divide-white/10 dark:bg-white/4"
                                >
                                    <tr
                                        v-for="resource in freedomOfInformationResources"
                                        :key="`${resource.category}-${resource.title}-${resource.year}`"
                                        class="transition hover:bg-[#f7f8f5] dark:hover:bg-white/5"
                                    >
                                        <td
                                            class="px-5 py-4 text-sm font-semibold whitespace-nowrap text-[#0b6680] dark:text-sky-300"
                                        >
                                            {{ resource.category }}
                                        </td>
                                        <td
                                            class="min-w-72 px-5 py-4 text-sm font-medium text-slate-800 dark:text-slate-100"
                                        >
                                            {{ resource.title }}
                                        </td>
                                        <td
                                            class="px-5 py-4 text-sm whitespace-nowrap text-slate-600 dark:text-slate-300"
                                        >
                                            {{ resource.year }}
                                        </td>
                                        <td
                                            class="px-5 py-4 text-right whitespace-nowrap"
                                        >
                                            <a
                                                :href="resource.href"
                                                target="_blank"
                                                rel="noreferrer"
                                                class="inline-flex items-center gap-2 rounded-md bg-[#e7f3fb] px-3 py-2 text-sm font-semibold text-[#0b3d91] transition hover:bg-[#1711d4] hover:text-white dark:bg-sky-400/10 dark:text-sky-200 dark:hover:bg-sky-300 dark:hover:text-slate-950"
                                            >
                                                View
                                                <ArrowUpRight
                                                    class="size-4"
                                                    aria-hidden="true"
                                                />
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
