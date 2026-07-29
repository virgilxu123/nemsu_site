<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { show as officeShow } from '@/actions/App/Http/Controllers/OvpafOfficeController';
import { home } from '@/routes';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

const heroBackgroundImage =
    '/images/administration/ovpaf/6I3A7029(1).jpg';
const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['ovpaf-hero']));
let revealObserver: IntersectionObserver | null = null;

type Office = {
    name: string;
    href: string;
};
const listedOffices: Office[] = [
    {
        name: 'Chief Administrative Office - Finance Division',
        href: officeShow.url('chief-administrative-office-finance-division'),
    },
    {
        name: 'Chief Administrative Office - Admin Division',
        href: officeShow.url('chief-administrative-office-admin-division'),
    },
    {
        name: 'Supervising Administrative Office - Finance Division',
        href: officeShow.url(
            'supervising-administrative-office-finance-division',
        ),
    },
    {
        name: 'Supervising Administrative Office - Administration Division',
        href: officeShow.url(
            'supervising-administrative-office-administration-division',
        ),
    },
    {
        name: 'Accounting Office',
        href: officeShow.url('accounting-office'),
    },
    {
        name: 'Budget Office',
        href: officeShow.url('budget-office'),
    },
    {
        name: 'Human Resource Management Office',
        href: officeShow.url('human-resource-management-office'),
    },
    {
        name: 'Supply Office',
        href: officeShow.url('supply-office'),
    },
    {
        name: 'Cashier Office',
        href: officeShow.url('cashier-office'),
    },
    {
        name: 'Income-Generating Project and Auxiliary Services Office',
        href: officeShow.url(
            'income-generating-project-and-auxiliary-services-office',
        ),
    },
    {
        name: 'Disaster Risk Management Office',
        href: officeShow.url('disaster-risk-management-office'),
    },
    {
        name: 'Energy Efficiency and Conservation Office',
        href: officeShow.url('energy-efficiency-and-conservation-office'),
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
        <Head
            title="Office of the Vice President for Administration and Finance"
        />

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
                    data-scroll-section="ovpaf-hero"
                    :class="revealClasses('ovpaf-hero')"
                    class="relative z-10 mx-auto grid max-w-7xl items-center gap-10 px-4 pb-24 sm:px-6 sm:pb-28 lg:grid-cols-[1.25fr_0.75fr] lg:px-8 lg:pb-12"
                >
                    <div>
                        <p
                            class="inline-flex rounded bg-white/10 px-3 py-1 text-sm font-semibold tracking-wide text-[#f2b705] uppercase ring-1 ring-white/15"
                        >
                            Administration
                        </p>
                        <h3
                            class="mt-5 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                        >
                            Office of the Vice President for Administration and
                            Finance
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
                                    Administration
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div aria-hidden="true" class="hidden lg:block"></div>
                </div>
            </section>

            <section
                id="ovpaf-profile-details"
                class="relative z-20 pt-10 pb-14 sm:pt-12 sm:pb-16 lg:pt-0"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-start lg:gap-12 lg:px-8"
                >
                    <div
                        data-scroll-section="ovpaf-overview"
                        :class="revealClasses('ovpaf-overview', 'right')"
                        class="max-w-3xl pt-8 lg:pt-20"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Overview
                        </p>
                        <h4
                            class="mt-3 text-3xl font-semibold tracking-normal sm:text-4xl"
                        >
                            Stewarding Administrative and Financial Excellence
                        </h4>
                        <p
                            class="mt-5 text-lg leading-8 text-slate-600 dark:text-slate-300"
                        >
                            This section will contain the official profile of
                            the Office of the Vice President for Administration
                            and Finance. Placeholder text is shown here while
                            the final office profile, leadership statement, and
                            service overview are being prepared.
                        </p>
                        <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                        <p
                            class="mt-4 text-uni-body text-slate-600 dark:text-slate-300"
                        >
                            The OVPAF supports the University through responsive
                            administrative systems, sound financial stewardship,
                            personnel services, property management, and
                            coordinated operational support across campuses.
                        </p>
                    </div>

                    <article
                        id="ovpaf-profile"
                        data-scroll-section="ovpaf-profile"
                        :class="revealClasses('ovpaf-profile', 'left')"
                        class="order-first z-20 mx-auto -mt-24 w-full max-w-sm overflow-hidden bg-white/30 text-slate-950 shadow-[0_24px_70px_rgba(15,23,42,0.28)] ring-1 ring-white/45 backdrop-blur-2xl sm:-mt-28 lg:order-none lg:sticky lg:top-24 lg:mt-[-8.5rem] lg:self-start dark:bg-slate-950/35 dark:text-white dark:ring-white/15"
                    >
                        <div class="relative overflow-hidden">
                            <img
                                src="/images/administration/ovpaf/DONAIRE-MAGLINTE,%20,MICHIKO,%20N%20SFFB%20NEMSU_0880%20copy.jpg"
                                alt="Atty. Mitchiko Donaire-Maglinte"
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
                                OIC Vice President
                            </p>
                            <h5
                                class="mt-2 text-2xl leading-tight font-semibold text-slate-950 dark:text-white"
                            >
                                Atty. Mitchiko Donaire-Maglinte
                            </h5>
                            <p
                                class="mt-3 border-t border-slate-200 pt-4 text-sm leading-6 text-slate-600 dark:border-white/10 dark:text-sky-100"
                            >
                                OIC-Vice President for Administration and
                                Finance
                            </p>
                        </div>
                    </article>
                </div>
            </section>

            <section
                id="ovpaf-offices"
                class="bg-[#1f007c] py-14 text-white sm:py-16"
            >
                <div
                    data-scroll-section="ovpaf-offices"
                    :class="revealClasses('ovpaf-offices')"
                    class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
                >
                    <p
                        class="text-sm font-semibold tracking-wide text-[#ffbf00] uppercase dark:text-rose-300"
                    >
                        Offices under OVPAF
                    </p>
                    <nav
                        aria-label="Offices under OVPAF"
                        class="mt-10 grid gap-x-12 gap-y-7 text-left sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <Link
                            v-for="office in listedOffices"
                            :key="office.name"
                            :href="office.href"
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
        </div>
    </PublicSiteLayout>
</template>
