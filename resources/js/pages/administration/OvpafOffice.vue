<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Building2, Mail, Phone } from 'lucide-vue-next';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { show as officeShow } from '@/actions/App/Http/Controllers/OvpafOfficeController';
import { home } from '@/routes';
import { vpaf } from '@/routes/administration';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type Office = {
    slug: string;
    title: string;
    acronym: string | null;
    description: string;
    head: string;
    email: string | null;
    phone: string | null;
    headImage: string | null;
};

type OfficeLink = {
    slug: string;
    title: string;
};

const props = defineProps<{
    office: Office;
    offices: OfficeLink[];
}>();

const heroBackgroundImage =
    '/images/administration/ovpaf/6I3A7029(1).jpg';
const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set(['office-hero']));
let revealObserver: IntersectionObserver | null = null;

const headInitials = computed(() =>
    props.office.head
        .split(/\s+/)
        .filter((part) => /^[A-Za-z]/.test(part))
        .slice(-2)
        .map((part) => part.charAt(0).toUpperCase())
        .join(''),
);

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
        <Head :title="props.office.title" />

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
                </div>

                <div
                    data-scroll-section="office-hero"
                    :class="revealClasses('office-hero')"
                    class="relative z-10 mx-auto max-w-7xl px-4 pb-24 sm:px-6 sm:pb-28 lg:px-8 lg:pb-12"
                >
                    <h3
                        class="mt-5 max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl"
                    >
                        {{ props.office.title }}
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
                            <li class="text-white/45" aria-hidden="true">/</li>
                            <li>
                                <Link
                                    :href="vpaf()"
                                    class="text-white/80 transition hover:text-[#f2b705]"
                                >
                                    Administration
                                </Link>
                            </li>
                            <li class="text-white/45" aria-hidden="true">/</li>
                            <li class="text-[#f2b705]" aria-current="page">
                                {{ props.office.acronym ?? 'Office' }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </section>

            <section class="relative z-20 pt-10 pb-14 sm:pt-12 sm:pb-16 lg:pt-0">
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_24rem] lg:items-start lg:gap-12 lg:px-8"
                >
                    <article
                        data-scroll-section="office-overview"
                        :class="revealClasses('office-overview', 'right')"
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
                            {{ props.office.title }}
                        </h4>
                        <p
                            class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300"
                        >
                            {{ props.office.description }}
                        </p>

                        <Link
                            :href="vpaf().url + '#ovpaf-offices'"
                            class="mt-8 inline-flex items-center gap-2 rounded-md bg-[#1711d4] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#f2b705] hover:text-slate-950"
                        >
                            <ArrowLeft class="size-4" aria-hidden="true" />
                            Back to OVPAF offices
                        </Link>
                    </article>

                    <aside
                        data-scroll-section="office-profile"
                        :class="revealClasses('office-profile', 'left')"
                        class="order-first z-20 mx-auto -mt-24 w-full max-w-sm overflow-hidden rounded-md border border-white/60 bg-white/95 p-2 text-slate-950 shadow-2xl ring-1 shadow-slate-950/25 ring-slate-950/5 backdrop-blur-xl sm:-mt-28 lg:order-none lg:sticky lg:top-24 lg:mt-[-8.5rem] lg:self-start dark:border-white/10 dark:bg-slate-950/90 dark:text-white"
                    >
                        <div class="relative overflow-hidden rounded-sm">
                            <img
                                v-if="props.office.headImage"
                                :src="props.office.headImage"
                                :alt="props.office.head"
                                class="h-96 w-full object-cover object-top [filter:contrast(.96)_saturate(.96)_blur(.2px)]"
                            />
                            <div
                                v-else
                                class="grid h-96 place-items-center bg-[#1711d4] text-white"
                            >
                                <div class="text-center">
                                    <span
                                        class="mx-auto grid size-24 place-items-center rounded-full bg-white/12 text-4xl font-semibold ring-1 ring-white/20"
                                    >
                                        {{ headInitials || 'OV' }}
                                    </span>
                                    <p
                                        class="mt-5 px-6 text-sm font-semibold tracking-[0.2em] text-[#f2b705] uppercase"
                                    >
                                        Head photo pending
                                    </p>
                                </div>
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
                                Office Head
                            </p>
                            <h4
                                class="mt-2 text-2xl leading-tight font-semibold text-slate-950 dark:text-white"
                            >
                                {{ props.office.head }}
                            </h4>
                            <div
                                class="mt-4 grid gap-3 border-t border-slate-200 pt-4 text-sm dark:border-white/10"
                            >
                                <a
                                    v-if="props.office.email"
                                    :href="`mailto:${props.office.email}`"
                                    class="inline-flex items-center gap-3 text-slate-600 transition hover:text-[#1711d4] dark:text-sky-100 dark:hover:text-[#f2b705]"
                                >
                                    <Mail class="size-4" aria-hidden="true" />
                                    {{ props.office.email }}
                                </a>
                                <span
                                    v-else
                                    class="inline-flex items-center gap-3 text-slate-400 dark:text-slate-500"
                                >
                                    <Mail class="size-4" aria-hidden="true" />
                                    Email not provided
                                </span>
                                <a
                                    v-if="props.office.phone"
                                    :href="`tel:${props.office.phone}`"
                                    class="inline-flex items-center gap-3 text-slate-600 transition hover:text-[#1711d4] dark:text-sky-100 dark:hover:text-[#f2b705]"
                                >
                                    <Phone class="size-4" aria-hidden="true" />
                                    {{ props.office.phone }}
                                </a>
                                <span
                                    v-else
                                    class="inline-flex items-center gap-3 text-slate-400 dark:text-slate-500"
                                >
                                    <Phone class="size-4" aria-hidden="true" />
                                    Contact number not provided
                                </span>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section
                id="other-offices"
                class="bg-[#1f007c] py-14 text-white sm:py-16"
            >
                <div
                    data-scroll-section="other-offices"
                    :class="revealClasses('other-offices')"
                    class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
                >
                    <p
                        class="text-sm font-semibold tracking-wide text-[#ffbf00] uppercase"
                    >
                        Offices under OVPAF
                    </p>
                    <nav
                        aria-label="Other offices under OVPAF"
                        class="mt-10 grid gap-x-12 gap-y-7 text-center sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <Link
                            v-for="officeLink in props.offices"
                            :key="officeLink.slug"
                            :href="officeShow.url(officeLink.slug)"
                            :class="[
                                'group inline-flex items-center justify-center gap-2 text-base font-bold transition hover:text-[#f2b705] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#f2b705] sm:text-lg',
                                officeLink.slug === props.office.slug
                                    ? 'text-[#f2b705]'
                                    : 'text-white',
                            ]"
                        >
                            <Building2 class="size-4" aria-hidden="true" />
                            <span>{{ officeLink.title }}</span>
                        </Link>
                    </nav>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
