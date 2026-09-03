<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ArrowRight,
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    Megaphone,
} from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { show as newsShow } from '@/routes/news';

type AnnouncementItem = {
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

type PaginatedAnnouncements = {
    data: AnnouncementItem[];
    from: number | null;
    links: PaginationLink[];
    to: number | null;
    total: number;
};

defineProps<{
    announcements: PaginatedAnnouncements;
}>();

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');
</script>

<template>
    <PublicSiteLayout>
        <Head title="Announcements" />

        <section
            class="relative isolate overflow-hidden bg-slate-950 text-white"
        >
            <img
                src="/storage/images/hero/6I3A7029(1).jpg"
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
                class="relative z-10 mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8"
            >
                <Link
                    :href="home()"
                    class="inline-flex w-fit items-center gap-2 rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm font-semibold text-white/90 backdrop-blur transition hover:bg-white/15 hover:text-white"
                >
                    <ArrowLeft class="size-4" aria-hidden="true" />
                    Back to home
                </Link>

                <div class="max-w-4xl py-16">
                    <p
                        class="inline-flex items-center gap-2 rounded-md bg-[#f2b705] px-3 py-1.5 text-xs font-semibold tracking-wide text-slate-950 uppercase"
                    >
                        <Megaphone class="size-4" aria-hidden="true" />
                        Announcements
                    </p>
                    <h1
                        class="mt-5 text-4xl leading-tight font-semibold tracking-normal text-balance sm:text-5xl lg:text-6xl"
                    >
                        Official advisories and notices
                    </h1>
                    <p
                        class="mt-5 max-w-2xl text-base leading-8 text-white/80 sm:text-lg"
                    >
                        Browse the latest public announcements from offices and
                        campuses across the NEMSU system.
                    </p>
                </div>
            </div>
        </section>

        <main class="bg-[#f7f8f5] dark:bg-slate-950">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div
                    v-if="announcements.data.length > 0"
                    class="grid gap-5 md:grid-cols-2 xl:grid-cols-3"
                >
                    <Link
                        v-for="announcement in announcements.data"
                        :key="announcement.id"
                        :href="newsShow(announcement.slug)"
                        class="group flex min-h-64 flex-col justify-between rounded-md border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5 transition hover:-translate-y-1 hover:border-[#9b1c31]/40 hover:shadow-lg hover:shadow-slate-900/10 dark:border-white/10 dark:bg-white/5"
                    >
                        <div>
                            <div
                                class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs font-medium text-slate-500 dark:text-slate-400"
                            >
                                <span
                                    class="rounded bg-[#9b1c31] px-2.5 py-1 text-white"
                                >
                                    {{ announcement.type }}
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <CalendarDays
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    {{ announcement.date }}
                                </span>
                            </div>

                            <h2
                                class="mt-4 text-xl leading-tight font-semibold tracking-normal text-slate-950 transition group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-200"
                            >
                                {{ announcement.title }}
                            </h2>
                            <p
                                v-if="announcement.excerpt"
                                class="mt-3 line-clamp-4 text-sm leading-7 text-slate-600 dark:text-slate-300"
                            >
                                {{ announcement.excerpt }}
                            </p>
                        </div>

                        <div
                            class="mt-6 flex items-center justify-between gap-4 border-t border-slate-200 pt-4 text-sm dark:border-white/10"
                        >
                            <span class="text-slate-500 dark:text-slate-400">
                                {{ announcement.office }}
                            </span>
                            <span
                                class="inline-flex items-center gap-1 font-semibold text-[#1711d4] dark:text-sky-200"
                            >
                                Read
                                <ArrowRight
                                    class="size-4 transition group-hover:translate-x-1"
                                    aria-hidden="true"
                                />
                            </span>
                        </div>
                    </Link>
                </div>

                <div
                    v-else
                    class="rounded-md border border-dashed border-slate-300 bg-white p-10 text-center text-slate-600 dark:border-white/15 dark:bg-white/5 dark:text-slate-300"
                >
                    No announcements are available right now.
                </div>

                <div
                    v-if="announcements.links.length > 3"
                    class="mt-8 flex flex-wrap items-center justify-between gap-4"
                >
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Showing {{ announcements.from ?? 0 }} to
                        {{ announcements.to ?? 0 }} of
                        {{ announcements.total }} announcements
                    </p>

                    <nav class="flex flex-wrap gap-2" aria-label="Pagination">
                        <Link
                            v-for="link in announcements.links"
                            :key="`${link.label}-${link.url}`"
                            :href="link.url ?? '#'"
                            :class="[
                                'inline-flex min-h-10 items-center justify-center rounded-md border px-3 text-sm font-semibold transition',
                                link.active
                                    ? 'border-[#1711d4] bg-[#1711d4] text-white'
                                    : 'border-slate-200 bg-white text-slate-700 hover:border-[#1711d4] hover:text-[#1711d4] dark:border-white/10 dark:bg-white/5 dark:text-slate-200',
                                link.url === null &&
                                    'pointer-events-none opacity-50',
                            ]"
                        >
                            <ChevronLeft
                                v-if="
                                    paginationLabel(link.label) === 'Previous'
                                "
                                class="size-4"
                                aria-hidden="true"
                            />
                            <ChevronRight
                                v-else-if="
                                    paginationLabel(link.label) === 'Next'
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
        </main>
    </PublicSiteLayout>
</template>
