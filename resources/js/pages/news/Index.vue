<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ArrowRight,
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    Megaphone,
    Newspaper,
} from 'lucide-vue-next';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { show as newsShow } from '@/routes/news';

type NewsItem = {
    id: string;
    type: string;
    title: string;
    slug: string;
    excerpt?: string | null;
    date: string | null;
    office: string;
    photoUrl?: string | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedNews = {
    data: NewsItem[];
    current_page: number;
    from: number | null;
    last_page: number;
    links: PaginationLink[];
    next_page_url: string | null;
    prev_page_url: string | null;
    to: number | null;
    total: number;
};

const props = defineProps<{
    featuredNews: NewsItem | null;
    news: PaginatedNews;
}>();

const campusBackdrop = 'https://nemsu.edu.ph/files/News/cm-00.jpg';
const nemsuSeal = 'https://nemsu.edu.ph/assets/images/NEMSU.png';
const scrollY = ref(0);

const paginationPages = () =>
    props.news.links.filter(
        (link) => !['&laquo; Previous', 'Next &raquo;'].includes(link.label),
    );

const paginationLabel = (label: string) =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');

const backdropStyle = computed(() => ({
    transform: `translate3d(0, ${scrollY.value * 0.16}px, 0) scale(1.08)`,
}));

const sealStyle = computed(() => ({
    transform: `translate3d(0, ${scrollY.value * -0.06}px, 0) rotate(${scrollY.value * 0.01}deg)`,
}));

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

const setupRevealAnimation = (): void => {
    const revealElements =
        document.querySelectorAll<HTMLElement>('[data-reveal]');

    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                entry.target.classList.toggle(
                    'opacity-100',
                    entry.isIntersecting,
                );
                entry.target.classList.toggle(
                    'translate-y-0',
                    entry.isIntersecting,
                );
                entry.target.classList.toggle(
                    'opacity-0',
                    !entry.isIntersecting,
                );
                entry.target.classList.toggle(
                    'translate-y-8',
                    !entry.isIntersecting,
                );
            });
        },
        {
            rootMargin: '0px',
            threshold: 0.1,
        },
    );

    revealElements.forEach((element) => revealObserver?.observe(element));
};

onMounted(() => {
    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;

    if (!prefersReducedMotion) {
        scrollY.value = window.scrollY;
        window.addEventListener('scroll', handleScroll, { passive: true });
        setupRevealAnimation();

        return;
    }

    document
        .querySelectorAll<HTMLElement>('[data-reveal]')
        .forEach((element) => {
            element.classList.remove('opacity-0', 'translate-y-8');
            element.classList.add('opacity-100', 'translate-y-0');
        });
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll);
    revealObserver?.disconnect();

    if (animationFrame !== 0) {
        window.cancelAnimationFrame(animationFrame);
    }
});
</script>

<template>
    <PublicSiteLayout>
        <Head title="News" />

        <section
            class="relative isolate overflow-hidden bg-[#06131f] text-white"
        >
            <img
                :src="campusBackdrop"
                alt=""
                class="pointer-events-none absolute inset-x-0 top-[-8rem] -z-20 h-[calc(100%+16rem)] w-full object-cover opacity-45"
                :style="backdropStyle"
                aria-hidden="true"
            />
            <div class="absolute inset-0 -z-10 bg-[#06131f]/70"></div>
            <img
                :src="nemsuSeal"
                alt=""
                class="pointer-events-none absolute right-[-5rem] bottom-[-8rem] -z-10 hidden size-[34rem] object-contain opacity-[0.16] lg:block xl:right-[2rem]"
                :style="sealStyle"
                aria-hidden="true"
            />

            <div
                class="mx-auto grid max-w-7xl gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[minmax(0,1fr)_20rem] lg:px-8"
            >
                <div
                    data-reveal
                    class="relative isolate min-h-[34rem] translate-y-8 overflow-hidden rounded-md opacity-0 shadow-2xl shadow-black/20 transition duration-700 ease-out motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none"
                >
                    <img
                        v-if="props.featuredNews?.photoUrl"
                        :src="props.featuredNews.photoUrl"
                        :alt="props.featuredNews.title"
                        class="absolute inset-0 h-full w-full object-cover"
                    />
                    <div
                        v-else
                        class="absolute inset-0 grid place-items-center bg-[#1711d4]"
                    >
                        <Newspaper
                            class="size-24 text-white/25"
                            aria-hidden="true"
                        />
                    </div>
                    <div
                        class="absolute inset-0 bg-linear-to-t from-[#06131f] via-[#06131f]/70 to-[#06131f]/15"
                    ></div>

                    <div
                        class="relative flex min-h-[34rem] flex-col justify-between p-5 sm:p-8"
                    >
                        <Link
                            :href="`${home().url}#news`"
                            class="inline-flex w-fit items-center gap-2 rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm font-semibold text-white/90 backdrop-blur transition hover:bg-white/15 hover:text-white"
                        >
                            <ArrowLeft class="size-4" aria-hidden="true" />
                            Back to home
                        </Link>

                        <div class="max-w-4xl">
                            <div class="mb-5 flex items-center gap-3">
                                <img
                                    :src="nemsuSeal"
                                    alt="NEMSU seal"
                                    class="size-14 rounded-full bg-white object-contain p-1 shadow-lg ring-1 shadow-black/20 ring-white/50"
                                />
                                <div
                                    class="h-px min-w-12 flex-1 bg-linear-to-r from-[#f2b705] to-transparent"
                                ></div>
                            </div>
                            <p
                                class="inline-flex items-center gap-2 rounded-md bg-[#f2b705] px-3 py-1.5 text-xs font-semibold tracking-wide text-slate-950 uppercase"
                            >
                                <Newspaper class="size-4" aria-hidden="true" />
                                Newsroom
                            </p>
                            <h1
                                class="mt-5 max-w-4xl text-4xl leading-tight font-semibold tracking-normal text-balance sm:text-5xl lg:text-6xl"
                            >
                                Latest stories from NEMSU
                            </h1>
                            <p
                                class="mt-5 max-w-2xl text-base leading-8 text-white/80 sm:text-lg"
                            >
                                Browse university announcements, campus
                                milestones, research updates, and public
                                information releases from across the NEMSU
                                system.
                            </p>

                            <Link
                                v-if="props.featuredNews"
                                :href="newsShow(props.featuredNews.slug)"
                                class="mt-8 inline-flex min-h-11 items-center gap-2 rounded-md bg-white px-5 py-2 text-sm font-semibold text-[#1711d4] transition hover:bg-[#f2b705]"
                            >
                                Read featured story
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </Link>
                        </div>
                    </div>
                </div>

                <aside
                    data-reveal
                    class="grid translate-y-8 content-between gap-5 border-t border-white/15 pt-6 opacity-0 transition duration-700 ease-out motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none lg:border-t-0 lg:pt-0"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                        >
                            Featured Story
                        </p>
                        <Link
                            v-if="props.featuredNews"
                            :href="newsShow(props.featuredNews.slug)"
                            class="group mt-4 block border-t border-white/15 pt-5"
                        >
                            <div
                                class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs font-medium text-white/70"
                            >
                                <span
                                    class="rounded bg-[#9b1c31] px-2.5 py-1 text-white"
                                >
                                    {{ props.featuredNews.type }}
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <CalendarDays
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    {{ props.featuredNews.date }}
                                </span>
                            </div>
                            <h2
                                class="mt-4 text-2xl leading-tight font-semibold tracking-normal text-white transition group-hover:text-[#f2b705]"
                            >
                                {{ props.featuredNews.title }}
                            </h2>
                            <p
                                v-if="props.featuredNews.excerpt"
                                class="mt-4 line-clamp-4 text-sm leading-7 text-white/75"
                            >
                                {{ props.featuredNews.excerpt }}
                            </p>
                            <p class="mt-5 text-xs font-medium text-white/55">
                                {{ props.featuredNews.office }}
                            </p>
                        </Link>
                        <p
                            v-else
                            class="mt-4 border-t border-white/15 pt-5 text-sm leading-7 text-white/70"
                        >
                            Featured news will appear here once a published
                            story is marked as featured.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-3 border-t border-white/15 pt-5"
                    >
                        <div>
                            <p class="text-3xl font-semibold">
                                {{ props.news.total }}
                            </p>
                            <p class="mt-1 text-xs font-medium text-white/65">
                                Published updates
                            </p>
                        </div>
                        <div>
                            <p class="text-3xl font-semibold">
                                {{ props.news.current_page }}
                            </p>
                            <p class="mt-1 text-xs font-medium text-white/65">
                                Current page
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section
            class="relative isolate overflow-hidden bg-[#1711d4] py-8 text-white"
        >
            <img
                :src="campusBackdrop"
                alt=""
                class="pointer-events-none absolute inset-0 -z-20 h-full w-full object-cover opacity-30"
                :style="backdropStyle"
                aria-hidden="true"
            />
            <div class="absolute inset-0 -z-10 bg-[#1711d4]/88"></div>
            <img
                :src="nemsuSeal"
                alt=""
                class="pointer-events-none absolute top-1/2 right-[-3rem] -z-10 size-72 -translate-y-1/2 object-contain opacity-[0.12] sm:size-96"
                :style="sealStyle"
                aria-hidden="true"
            />

            <div
                data-reveal
                class="mx-auto flex translate-y-8 flex-col gap-6 px-4 opacity-0 transition duration-700 ease-out motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none sm:px-6 md:flex-row md:items-center md:justify-between lg:max-w-7xl lg:px-8"
            >
                <div class="flex items-center gap-4">
                    <img
                        :src="nemsuSeal"
                        alt="NEMSU seal"
                        class="size-16 shrink-0 rounded-full bg-white object-contain p-1.5 ring-1 ring-white/50"
                    />
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                        >
                            North Eastern Mindanao State University
                        </p>
                        <h2
                            class="mt-1 text-2xl font-semibold tracking-normal text-white sm:text-3xl"
                        >
                            NEMSU Newsroom
                        </h2>
                    </div>
                </div>
                <p class="max-w-xl text-sm leading-7 text-sky-100">
                    Official stories, announcements, campus milestones, and
                    public information releases from across the university
                    system.
                </p>
            </div>
        </section>

        <section
            class="relative isolate overflow-hidden bg-[#f7f8f5] py-14 dark:bg-slate-950"
        >
            <img
                :src="nemsuSeal"
                alt=""
                class="pointer-events-none absolute top-8 left-[-8rem] -z-10 hidden size-[36rem] object-contain opacity-[0.07] lg:block dark:opacity-[0.04]"
                :style="sealStyle"
                aria-hidden="true"
            />
            <img
                :src="nemsuSeal"
                alt=""
                class="pointer-events-none absolute right-[-10rem] bottom-[-8rem] -z-10 size-[30rem] object-contain opacity-[0.05] dark:opacity-[0.035]"
                :style="sealStyle"
                aria-hidden="true"
            />
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    data-reveal
                    class="flex translate-y-8 flex-col justify-between gap-4 border-b border-slate-200 pb-6 opacity-0 transition duration-700 ease-out motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none sm:flex-row sm:items-end dark:border-white/10"
                >
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Browse News
                        </p>
                        <h2
                            class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white"
                        >
                            Recent university updates
                        </h2>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Showing {{ props.news.from ?? 0 }}-{{
                            props.news.to ?? 0
                        }}
                        of
                        {{ props.news.total }}
                    </p>
                </div>

                <div
                    v-if="props.news.data.length > 0"
                    class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3"
                >
                    <Link
                        v-for="item in props.news.data"
                        :key="item.id"
                        :href="newsShow(item.slug)"
                        data-reveal
                        class="group flex min-h-full translate-y-8 flex-col overflow-hidden rounded-md border border-slate-200 bg-white opacity-0 shadow-sm shadow-slate-900/5 transition duration-700 ease-out hover:-translate-y-0.5 hover:border-[#0b6680]/50 hover:shadow-lg hover:shadow-slate-900/10 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none dark:border-white/10 dark:bg-white/5 dark:hover:border-sky-300/50"
                    >
                        <div
                            class="overflow-hidden bg-slate-100 dark:bg-white/10"
                        >
                            <img
                                v-if="item.photoUrl"
                                :src="item.photoUrl"
                                :alt="item.title"
                                class="aspect-[16/10] w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                            />
                            <div
                                v-else
                                class="grid aspect-[16/10] place-items-center text-[#9b1c31] dark:text-rose-200"
                            >
                                <Megaphone class="size-10" aria-hidden="true" />
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <div
                                class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs font-medium text-slate-500 dark:text-slate-400"
                            >
                                <span
                                    class="rounded bg-[#f8e7eb] px-2.5 py-1 text-[#9b1c31] dark:bg-rose-400/10 dark:text-rose-200"
                                >
                                    {{ item.type }}
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <CalendarDays
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    {{ item.date }}
                                </span>
                            </div>
                            <h3
                                class="mt-4 line-clamp-2 text-lg leading-7 font-semibold tracking-normal text-slate-950 transition group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-100"
                            >
                                {{ item.title }}
                            </h3>
                            <p
                                v-if="item.excerpt"
                                class="mt-3 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ item.excerpt }}
                            </p>
                            <div
                                class="mt-auto flex items-center justify-between gap-4 pt-5 text-xs font-medium text-slate-500 dark:text-slate-400"
                            >
                                <span class="truncate">{{ item.office }}</span>
                                <ArrowRight
                                    class="size-4 shrink-0 transition group-hover:translate-x-1 group-hover:text-[#0b6680] dark:group-hover:text-sky-200"
                                    aria-hidden="true"
                                />
                            </div>
                        </div>
                    </Link>
                </div>

                <article
                    v-else
                    data-reveal
                    class="mt-8 translate-y-8 rounded-md border border-dashed border-slate-300 bg-white p-8 text-center text-sm leading-7 text-slate-600 opacity-0 transition duration-700 ease-out motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none dark:border-white/15 dark:bg-white/5 dark:text-slate-300"
                >
                    Published news records will appear here once they are
                    available.
                </article>

                <nav
                    v-if="props.news.last_page > 1"
                    data-reveal
                    class="mt-10 flex translate-y-8 flex-col items-center justify-between gap-4 border-t border-slate-200 pt-6 opacity-0 transition duration-700 ease-out motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none sm:flex-row dark:border-white/10"
                    aria-label="News pagination"
                >
                    <div class="flex gap-2">
                        <Link
                            v-if="props.news.prev_page_url"
                            :href="props.news.prev_page_url"
                            class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 bg-white text-slate-700 transition hover:border-[#0b6680] hover:text-[#0b6680] dark:border-white/10 dark:bg-white/5 dark:text-slate-200"
                            aria-label="Previous page"
                        >
                            <ChevronLeft class="size-4" aria-hidden="true" />
                        </Link>
                        <span
                            v-else
                            class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-300 dark:border-white/10 dark:text-slate-600"
                        >
                            <ChevronLeft class="size-4" aria-hidden="true" />
                        </span>

                        <Link
                            v-if="props.news.next_page_url"
                            :href="props.news.next_page_url"
                            class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 bg-white text-slate-700 transition hover:border-[#0b6680] hover:text-[#0b6680] dark:border-white/10 dark:bg-white/5 dark:text-slate-200"
                            aria-label="Next page"
                        >
                            <ChevronRight class="size-4" aria-hidden="true" />
                        </Link>
                        <span
                            v-else
                            class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-300 dark:border-white/10 dark:text-slate-600"
                        >
                            <ChevronRight class="size-4" aria-hidden="true" />
                        </span>
                    </div>

                    <div class="flex flex-wrap justify-center gap-2">
                        <template
                            v-for="link in paginationPages()"
                            :key="link.label"
                        >
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                class="inline-flex h-10 min-w-10 items-center justify-center rounded-md border px-3 text-sm font-semibold transition"
                                :class="
                                    link.active
                                        ? 'border-[#1711d4] bg-[#1711d4] text-white dark:border-sky-200 dark:bg-sky-200 dark:text-slate-950'
                                        : 'border-slate-200 bg-white text-slate-700 hover:border-[#0b6680] hover:text-[#0b6680] dark:border-white/10 dark:bg-white/5 dark:text-slate-200'
                                "
                            >
                                {{ paginationLabel(link.label) }}
                            </Link>
                            <span
                                v-else
                                class="inline-flex h-10 min-w-10 items-center justify-center rounded-md border border-slate-200 px-3 text-sm font-semibold text-slate-400 dark:border-white/10 dark:text-slate-500"
                            >
                                {{ paginationLabel(link.label) }}
                            </span>
                        </template>
                    </div>
                </nav>
            </div>
        </section>
    </PublicSiteLayout>
</template>
