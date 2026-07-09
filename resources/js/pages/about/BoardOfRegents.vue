<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BadgeCheck,
    CalendarDays,
    FileText,
    UserRound,
    Users,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import type { CSSProperties } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';

type RegentKind = 'chair' | 'vice' | 'member' | 'secretary' | 'vacant';

type BoardMember = {
    name: string;
    designation: string;
    boardRole: string;
    initials: string;
    kind: RegentKind;
};

type GovernanceItem = {
    label: string;
    value: string;
    note: string;
};

type DocumentItem = {
    title: string;
    description: string;
};

const campusBackdrop = 'https://nemsu.edu.ph/files/News/cm-00.jpg';
const nemsuSeal = 'https://nemsu.edu.ph/assets/images/NEMSU.png';
const scrollY = ref(0);
const visibleSections = ref<Set<string>>(
    new Set(['roster-intro', 'board-chair']),
);

const boardMembers: BoardMember[] = [
    {
        name: 'HON. RICMAR P. AQUINO, PhD',
        designation: 'Commissioner, CHED',
        boardRole: 'Chairperson, NEMSU Board of Regents',
        initials: 'RA',
        kind: 'chair',
    },
    {
        name: 'HON. NEMESIO G. LOAYON, PhD',
        designation: 'SUC President III, NEMSU',
        boardRole: 'Vice Chairperson, NEMSU Board of Regents',
        initials: 'NL',
        kind: 'vice',
    },
    {
        name: 'HON. SENATOR LOREN B. LEGARDA',
        designation:
            'Chairman of Senate Committee on Higher, Technical, and Vocational Education',
        boardRole: 'Member',
        initials: 'LL',
        kind: 'member',
    },
    {
        name: 'HON. JUDE A. ACIDRE',
        designation: 'Chairman, House Committee on Higher Technical Education',
        boardRole: 'Member',
        initials: 'JA',
        kind: 'member',
    },
    {
        name: 'HON. GEMIMA A. OLAM, EnP, CESO IV',
        designation:
            'Regional Director, Department of Economy, Planning, and Development XIII',
        boardRole: 'Member',
        initials: 'GO',
        kind: 'member',
    },
    {
        name: 'HON. NOEL M. AJOC',
        designation: 'DOST Regional Director',
        boardRole: 'Member',
        initials: 'NA',
        kind: 'member',
    },
    {
        name: 'Vacant',
        designation: 'Private Sector Representative',
        boardRole: 'Member',
        initials: '',
        kind: 'vacant',
    },
    {
        name: 'Vacant',
        designation: 'Private Sector Representative',
        boardRole: 'Member',
        initials: '',
        kind: 'vacant',
    },
    {
        name: 'HON. JOHN FLOR B. RAMAS',
        designation: 'President, Alumni Associations',
        boardRole: 'Member',
        initials: 'JR',
        kind: 'member',
    },
    {
        name: 'HON. RUDYARD RYAN T. VERANO',
        designation: 'President, Federation of Faculty Club Associations',
        boardRole: 'Member',
        initials: 'RV',
        kind: 'member',
    },
    {
        name: 'HON. NEO P. VILLASON',
        designation: 'President, Federation of Supreme Student Government',
        boardRole: 'Member',
        initials: 'NV',
        kind: 'member',
    },
    {
        name: 'CATHERINE F. SALOMON, PhD(C)',
        designation: 'Board Secretary V',
        boardRole: 'Member',
        initials: 'CS',
        kind: 'secretary',
    },
];

const avatarClasses: Record<RegentKind, string> = {
    chair: 'bg-[#1711d4] text-white ring-[#f2b705]/50',
    vice: 'bg-[#0b6680] text-white ring-sky-200',
    member: 'bg-white text-[#1711d4] ring-slate-200',
    secretary: 'bg-[#f2b705] text-slate-950 ring-amber-100',
    vacant: 'bg-slate-100 text-slate-400 ring-slate-200 dark:bg-white/10 dark:text-slate-300 dark:ring-white/10',
};

const badgeClasses: Record<RegentKind, string> = {
    chair: 'bg-[#1711d4] text-white',
    vice: 'bg-[#e6f3f5] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200',
    member: 'bg-[#f8e7eb] text-[#9b1c31] dark:bg-rose-400/10 dark:text-rose-200',
    secretary:
        'bg-[#fff4cc] text-[#795200] dark:bg-[#f2b705]/15 dark:text-[#f2b705]',
    vacant: 'bg-slate-100 text-slate-500 dark:bg-white/10 dark:text-slate-300',
};

const boardChair = boardMembers.find(
    (member) => member.kind === 'chair',
) as BoardMember;
const boardViceChair = boardMembers.find(
    (member) => member.kind === 'vice',
) as BoardMember;
const boardRepresentatives = boardMembers.filter(
    (member) => !['chair', 'vice'].includes(member.kind),
);

const rosterPatternStyle: CSSProperties = {
    backgroundImage:
        'linear-gradient(90deg, rgba(255,255,255,.95), rgba(255,255,255,.84))',
};

const sealParallaxStyle = (
    speed = -0.04,
    offset = 0,
    scale = 1,
): CSSProperties => ({
    transform: `translate3d(-50%, calc(-50% + ${scrollY.value * speed + offset}px), 0) scale(${scale}) rotate(${scrollY.value * 0.008}deg)`,
});

let animationFrame = 0;
let revealObserver: IntersectionObserver | null = null;

const handleScroll = (): void => {
    if (animationFrame !== 0) {
        return;
    }

    animationFrame = window.requestAnimationFrame(() => {
        scrollY.value = window.scrollY;
        animationFrame = 0;
    });
};

const setSectionVisibility = (section: string): void => {
    const nextVisibleSections = new Set(visibleSections.value);

    nextVisibleSections.add(section);

    visibleSections.value = nextVisibleSections;
};

const revealClasses = (
    section: string,
    direction: 'left' | 'right' | 'up' = 'up',
): string =>
    [
        'transition-all duration-700 ease-out will-change-transform motion-reduce:translate-x-0 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:blur-0 motion-reduce:transition-none',
        visibleSections.value.has(section)
            ? 'translate-y-0 opacity-100 blur-0'
            : [
                  direction === 'left' ? 'translate-x-8' : '',
                  direction === 'right' ? '-translate-x-8' : '',
                  direction === 'up' ? 'translate-y-8' : '',
                  'opacity-0 blur-[2px]',
              ].join(' '),
    ].join(' ');

onMounted(() => {
    const revealElements = document.querySelectorAll<HTMLElement>(
        '[data-scroll-section]',
    );
    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;

    scrollY.value = window.scrollY;
    window.addEventListener('scroll', handleScroll, { passive: true });

    if (prefersReducedMotion) {
        visibleSections.value = new Set(
            Array.from(revealElements)
                .map((element) => element.dataset.scrollSection)
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

                if (section && entry.isIntersecting) {
                    setSectionVisibility(section);
                    revealObserver?.unobserve(entry.target);
                }
            });
        },
        {
            rootMargin: '0px',
            threshold: 0.1,
        },
    );

    revealElements.forEach((element) => {
        revealObserver?.observe(element);
    });
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll);
    revealObserver?.disconnect();

    if (animationFrame !== 0) {
        window.cancelAnimationFrame(animationFrame);
    }
});

const governanceItems: GovernanceItem[] = [
    {
        label: 'Policy',
        value: 'Strategic Direction',
        note: 'Approves institutional priorities, major initiatives, and long-range plans.',
    },
    {
        label: 'Stewardship',
        value: 'Public Accountability',
        note: 'Oversees responsible use of resources and compliance with public governance standards.',
    },
    {
        label: 'Quality',
        value: 'Academic Excellence',
        note: 'Supports academic standards, research productivity, and service delivery across campuses.',
    },
];

const documentItems: DocumentItem[] = [
    {
        title: 'Board Resolutions',
        description:
            'Official policy actions and approvals issued by the governing board.',
    },
    {
        title: 'Meeting Highlights',
        description:
            'Summaries of key decisions, institutional directions, and public updates.',
    },
    {
        title: 'Governance References',
        description:
            'Mandates, charters, and public accountability documents for the university.',
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="Board of Regents" />

        <div
            class="relative isolate overflow-hidden bg-white dark:bg-slate-950"
        >
            <img
                :src="nemsuSeal"
                alt=""
                class="pointer-events-none fixed top-1/2 left-1/2 z-0 size-[42rem] max-w-none object-contain opacity-[0.045] dark:opacity-[0.025]"
                :style="sealParallaxStyle(-0.025, 0, 1)"
                aria-hidden="true"
            />

            <section
                class="relative z-10 border-t-4 border-[#333] bg-white/95 py-8 backdrop-blur-[1px] dark:bg-slate-950/95"
            >
                <div
                    class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8"
                >
                    <div
                        data-scroll-section="roster-intro"
                        :class="revealClasses('roster-intro')"
                        class="mx-auto max-w-2xl text-center"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Composition
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Current Board of Regents
                        </h2>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Chairperson, vice chairperson, national officials,
                            agency representatives, sectoral representatives,
                            and the board secretary.
                        </p>
                    </div>

                    <div
                        class="relative isolate mt-10 overflow-hidden border-y border-slate-200 bg-white/90 py-10 backdrop-blur-[1px] dark:border-white/10 dark:bg-slate-950/90"
                    >
                        <article
                            data-scroll-section="board-chair"
                            :class="revealClasses('board-chair')"
                            class="relative z-10 mx-auto grid max-w-xl justify-items-center text-center"
                        >
                            <span
                                :class="[
                                    'inline-flex size-40 items-center justify-center rounded-full text-3xl font-semibold shadow-lg ring-4 shadow-slate-900/15 ring-[#007a1b]',
                                    avatarClasses[boardChair.kind],
                                ]"
                            >
                                {{ boardChair.initials }}
                            </span>
                            <h3
                                class="mt-7 text-base font-bold tracking-wide text-slate-950 dark:text-white"
                            >
                                {{ boardChair.name }}
                            </h3>
                            <p
                                class="mt-1 text-sm leading-6 font-medium text-slate-700 italic dark:text-slate-300"
                            >
                                {{ boardChair.designation }}
                            </p>
                            <p
                                class="mt-1 text-sm font-bold text-[#12351c] dark:text-emerald-200"
                            >
                                {{ boardChair.boardRole }}
                            </p>
                        </article>
                    </div>

                    <div
                        class="relative isolate overflow-hidden border-b border-slate-200 py-10 dark:border-white/10"
                        :style="rosterPatternStyle"
                    >
                        <article
                            data-scroll-section="board-vice-chair"
                            :class="revealClasses('board-vice-chair')"
                            class="relative z-10 mx-auto grid max-w-xl justify-items-center text-center"
                        >
                            <span
                                :class="[
                                    'inline-flex size-40 items-center justify-center rounded-full text-3xl font-semibold shadow-lg ring-4 shadow-slate-900/15 ring-[#007a1b]',
                                    avatarClasses[boardViceChair.kind],
                                ]"
                            >
                                {{ boardViceChair.initials }}
                            </span>
                            <h3
                                class="mt-7 text-base font-bold tracking-wide text-slate-950 dark:text-white"
                            >
                                {{ boardViceChair.name }}
                            </h3>
                            <p
                                class="mt-1 text-sm leading-6 font-medium text-slate-700 italic dark:text-slate-300"
                            >
                                {{ boardViceChair.designation }}
                            </p>
                            <p
                                class="mt-1 text-sm font-bold text-[#12351c] dark:text-emerald-200"
                            >
                                {{ boardViceChair.boardRole }}
                            </p>
                        </article>
                    </div>

                    <div
                        class="relative isolate grid gap-x-12 gap-y-12 overflow-hidden border-b border-slate-200 py-10 sm:grid-cols-2 dark:border-white/10"
                    >
                        <article
                            v-for="(member, index) in boardRepresentatives"
                            :key="`${member.name}-${index}`"
                            :data-scroll-section="`board-representative-${index}`"
                            :class="
                                revealClasses(
                                    `board-representative-${index}`,
                                    index % 2 === 0 ? 'right' : 'left',
                                )
                            "
                            class="relative z-10 grid justify-items-center text-center"
                        >
                            <span
                                :class="[
                                    'inline-flex size-36 items-center justify-center rounded-full text-2xl font-semibold shadow-md ring-4 shadow-slate-900/15 ring-[#007a1b]',
                                    avatarClasses[member.kind],
                                ]"
                            >
                                <span
                                    v-if="member.kind !== 'vacant'"
                                    aria-hidden="true"
                                >
                                    {{ member.initials }}
                                </span>
                                <UserRound
                                    v-else
                                    class="size-16"
                                    aria-hidden="true"
                                />
                            </span>
                            <h3
                                class="mt-7 text-base font-bold tracking-wide text-slate-950 dark:text-white"
                            >
                                {{ member.name }}
                            </h3>
                            <p
                                class="mt-1 max-w-md text-sm leading-6 font-medium text-slate-700 italic dark:text-slate-300"
                            >
                                {{ member.designation }}
                            </p>
                            <p
                                :class="[
                                    'mt-2 inline-flex rounded px-2.5 py-1 text-xs font-semibold',
                                    badgeClasses[member.kind],
                                ]"
                            >
                                {{ member.boardRole }}
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section
                class="relative z-10 bg-white/95 py-14 backdrop-blur-[1px] dark:bg-slate-900/95"
            >
                <div
                    class="relative z-10 mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-8"
                >
                    <div
                        data-scroll-section="board-work-copy"
                        :class="revealClasses('board-work-copy', 'right')"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Board Work
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Policy leadership with a clear public record
                        </h2>
                        <p
                            class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            The page is ready for minutes, resolutions, meeting
                            schedules, and appointment updates while keeping the
                            presentation concise for public visitors.
                        </p>
                    </div>

                    <div class="grid gap-4">
                        <article
                            v-for="(item, index) in governanceItems"
                            :key="item.label"
                            :data-scroll-section="`board-work-item-${index}`"
                            :class="revealClasses(`board-work-item-${index}`)"
                            class="grid gap-4 rounded-md border border-slate-200 p-5 sm:grid-cols-[10rem_1fr] dark:border-white/10"
                        >
                            <div>
                                <p
                                    class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    {{ item.label }}
                                </p>
                                <p
                                    class="mt-2 font-semibold text-slate-950 dark:text-white"
                                >
                                    {{ item.value }}
                                </p>
                            </div>
                            <p
                                class="text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ item.note }}
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section
                class="relative isolate overflow-hidden bg-[#1711d4] py-14 text-white"
            >
                <img
                    :src="campusBackdrop"
                    alt=""
                    class="absolute inset-0 -z-20 h-full w-full object-cover opacity-20"
                    aria-hidden="true"
                />
                <div class="absolute inset-0 z-0 bg-[#1711d4]/90"></div>

                <div
                    class="relative z-10 mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8"
                >
                    <div
                        data-scroll-section="records-heading"
                        :class="[
                            revealClasses('records-heading', 'right'),
                            'flex items-start gap-4',
                        ]"
                    >
                        <span
                            class="inline-flex size-14 shrink-0 items-center justify-center rounded-md bg-white text-[#1711d4]"
                        >
                            <CalendarDays class="size-7" aria-hidden="true" />
                        </span>
                        <div>
                            <p
                                class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                            >
                                Meetings and Records
                            </p>
                            <h2
                                class="mt-3 text-3xl font-semibold tracking-normal"
                            >
                                A dedicated space for official board materials
                            </h2>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <article
                            v-for="(item, index) in documentItems"
                            :key="item.title"
                            :data-scroll-section="`records-item-${index}`"
                            :class="revealClasses(`records-item-${index}`)"
                            class="rounded-md border border-white/15 bg-white/10 p-5 backdrop-blur"
                        >
                            <FileText
                                class="size-7 text-[#f2b705]"
                                aria-hidden="true"
                            />
                            <h3 class="mt-5 font-semibold text-white">
                                {{ item.title }}
                            </h3>
                            <p class="mt-3 text-sm leading-7 text-sky-100">
                                {{ item.description }}
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section
                class="relative z-10 bg-[#f7f8f5]/95 py-14 backdrop-blur-[1px] dark:bg-slate-950/95"
            >
                <div
                    class="relative z-10 mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-[1fr_22rem] lg:px-8"
                >
                    <div
                        data-scroll-section="secretariat"
                        :class="revealClasses('secretariat', 'right')"
                        class="rounded-md border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                    >
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex size-11 items-center justify-center rounded-md bg-[#e6f3f5] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <Users class="size-5" aria-hidden="true" />
                            </span>
                            <div>
                                <p
                                    class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                                >
                                    Secretariat
                                </p>
                                <h2
                                    class="text-xl font-semibold tracking-normal text-slate-950 dark:text-white"
                                >
                                    Governance information desk
                                </h2>
                            </div>
                        </div>
                        <p
                            class="mt-5 max-w-3xl text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            Use this area for the office responsible for board
                            documentation, public requests, agenda coordination,
                            and official posting of regent information.
                        </p>
                    </div>

                    <Link
                        :href="`${home().url}#governance`"
                        data-scroll-section="governance-link"
                        :class="[
                            revealClasses('governance-link', 'left'),
                            'group flex min-h-full flex-col justify-between rounded-md border border-[#9b1c31]/25 bg-white p-6 shadow-sm shadow-slate-900/5 transition hover:border-[#9b1c31]/50 hover:bg-[#fff8f9] dark:border-rose-300/25 dark:bg-white/5 dark:hover:border-rose-200/50 dark:hover:bg-white/[0.08]',
                        ]"
                    >
                        <BadgeCheck
                            class="size-8 text-[#9b1c31] dark:text-rose-300"
                            aria-hidden="true"
                        />
                        <span class="mt-8">
                            <span
                                class="block font-semibold text-slate-950 dark:text-white"
                            >
                                View governance links
                            </span>
                            <span
                                class="mt-2 block text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                Transparency Seal, FOI, Citizen's Charter, and
                                public accountability resources.
                            </span>
                        </span>
                        <span
                            class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-200"
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
        </div>
    </PublicSiteLayout>
</template>
