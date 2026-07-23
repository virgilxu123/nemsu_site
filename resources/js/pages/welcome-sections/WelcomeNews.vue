<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, CalendarDays } from 'lucide-vue-next';
import { computed } from 'vue';

import { index as announcementsIndex } from '@/routes/announcements';
import { index as newsIndex, show as newsShow } from '@/routes/news';
import type { NewsItem, RevealClasses } from '@/types';

type DateBlock = {
    month: string;
    day: number;
    year: number;
};

type AnnouncementDisplay = {
    item: NewsItem;
    date: DateBlock | null;
};

const props = withDefaults(
    defineProps<{
        featuredNews?: NewsItem | null;
        pressReleases?: NewsItem[];
        announcements?: NewsItem[];
        revealClasses: RevealClasses;
    }>(),
    {
        featuredNews: null,
        pressReleases: () => [],
        announcements: () => [],
    },
);

const parseDateBlock = (dateString: string | null): DateBlock | null => {
    if (!dateString) {
        return null;
    }

    const date = new Date(dateString);

    if (Number.isNaN(date.getTime())) {
        return null;
    }

    return {
        month: date.toLocaleString('en-US', { month: 'short' }),
        day: date.getDate(),
        year: date.getFullYear(),
    };
};

const announcementItems = computed<AnnouncementDisplay[]>(() =>
    props.announcements.slice(0, 3).map((item) => ({
        item,
        date: parseDateBlock(item.date),
    })),
);
</script>

<template>
    <section
        id="news"
        tabindex="-1"
        class="bg-[#F8FAFC] py-16 lg:py-20 dark:bg-slate-950"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="mb-9 text-center">
                <h2
                    class="font-serif text-3xl font-semibold tracking-tight text-[#1A2340] sm:text-4xl dark:text-white"
                >
                    News and Announcements
                </h2>
                <span
                    class="mx-auto mt-3 block h-1 w-16 rounded-full bg-[#F2B900]"
                    aria-hidden="true"
                ></span>
            </header>

            <div
                data-scroll-section="news-top"
                :class="revealClasses('news-top')"
                class="grid gap-4 lg:grid-cols-2 lg:items-stretch"
            >
                <article
                    class="flex min-w-0 flex-col rounded-lg border border-[#D8DEE8] bg-white p-5 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-slate-900"
                >
                    <div
                        class="flex min-h-11 items-center justify-between gap-4"
                    >
                        <h3
                            class="text-sm font-bold tracking-wide text-[#334155] uppercase dark:text-slate-300"
                        >
                            Featured news
                        </h3>
                    </div>

                    <Link
                        v-if="props.featuredNews"
                        :href="newsShow(props.featuredNews.slug)"
                        class="group mt-5 flex flex-1 flex-col focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7]"
                    >
                        <div
                            class="aspect-video overflow-hidden rounded-lg bg-[#F1F5F9] dark:bg-white/5"
                        >
                            <img
                                v-if="props.featuredNews.photoUrl"
                                :src="props.featuredNews.photoUrl"
                                :alt="props.featuredNews.title"
                                class="size-full object-cover transition duration-500 group-hover:scale-[1.02]"
                            />
                            <div
                                v-else
                                class="grid size-full place-items-center text-sm text-[#6B7280] dark:text-slate-400"
                            >
                                University news image
                            </div>
                        </div>

                        <div
                            class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs text-[#6B7280] dark:text-slate-400"
                        >
                            <span
                                class="rounded-sm bg-[#1C0ED7] px-2.5 py-1 font-semibold text-white uppercase"
                            >
                                {{
                                    props.featuredNews.type || 'University news'
                                }}
                            </span>
                            <span
                                v-if="props.featuredNews.date"
                                class="inline-flex items-center gap-1.5"
                            >
                                <CalendarDays
                                    class="size-3.5"
                                    aria-hidden="true"
                                />
                                {{ props.featuredNews.date }}
                            </span>
                        </div>
                        <h3
                            class="mt-4 max-w-3xl font-serif text-2xl leading-tight font-semibold text-[#1A2340] transition-colors group-hover:text-[#1C0ED7] sm:text-3xl dark:text-white"
                        >
                            {{ props.featuredNews.title }}
                        </h3>
                        <p
                            v-if="props.featuredNews.excerpt"
                            class="mt-3 max-w-3xl text-base leading-7 text-[#4B5563] dark:text-slate-300"
                        >
                            {{ props.featuredNews.excerpt }}
                        </p>
                        <span class="mt-6 lg:mt-auto lg:pt-6">
                            <span
                                class="inline-flex min-h-11 items-center gap-3 rounded-md bg-[#1C0ED7] px-5 py-2.5 text-sm font-semibold text-white transition-colors group-hover:bg-[#160BB2]"
                            >
                                Read more
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </span>
                        </span>
                    </Link>

                    <div
                        v-else
                        class="mt-5 grid min-h-80 flex-1 place-items-center rounded-lg border border-dashed border-[#D8DEE8] bg-[#F8FAFC] p-6 text-center text-sm leading-6 text-[#6B7280] dark:border-white/15 dark:bg-white/[0.03] dark:text-slate-400"
                    >
                        Featured news will appear here after a published news
                        record is marked as featured.
                    </div>
                </article>

                <div
                    class="grid min-w-0 gap-4 lg:h-full lg:grid-rows-[1fr_auto]"
                >
                    <section
                        class="flex min-h-0 flex-col rounded-lg border border-[#D8DEE8] bg-white p-5 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-slate-900"
                        aria-labelledby="latest-news-heading"
                    >
                        <div
                            class="flex min-h-11 items-center justify-between gap-4"
                        >
                            <h3
                                id="latest-news-heading"
                                class="text-sm font-bold tracking-wide text-[#1A2340] uppercase dark:text-white"
                            >
                                Latest news
                            </h3>
                            <Link
                                :href="newsIndex()"
                                class="inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7] dark:text-sky-300"
                            >
                                View all news
                                <ArrowRight class="size-4" aria-hidden="true" />
                            </Link>
                        </div>

                        <div
                            v-if="props.pressReleases.length"
                            class="mt-3 flex-1 divide-y divide-[#D8DEE8] dark:divide-white/10"
                        >
                            <Link
                                v-for="item in props.pressReleases.slice(0, 3)"
                                :key="item.id"
                                :href="newsShow(item.slug)"
                                class="group grid grid-cols-[7rem_1fr] gap-4 py-3 first:pt-0 last:pb-0 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] sm:grid-cols-[9rem_1fr]"
                            >
                                <div
                                    class="aspect-video overflow-hidden rounded-md bg-[#F1F5F9] dark:bg-white/5"
                                >
                                    <img
                                        v-if="item.photoUrl"
                                        :src="item.photoUrl"
                                        :alt="item.title"
                                        class="size-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                    />
                                </div>
                                <div class="min-w-0 self-center">
                                    <p
                                        class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs leading-5 text-[#6B7280] dark:text-slate-400"
                                    >
                                        <span
                                            class="font-semibold text-[#1C0ED7] uppercase dark:text-sky-300"
                                            >{{
                                                item.type || 'University news'
                                            }}</span
                                        >
                                        <span
                                            v-if="item.date"
                                            class="inline-flex items-center gap-1.5"
                                        >
                                            <CalendarDays
                                                class="size-3.5"
                                                aria-hidden="true"
                                            />
                                            {{ item.date }}
                                        </span>
                                    </p>
                                    <h4
                                        class="mt-1 line-clamp-2 text-base leading-snug font-semibold text-[#1A2340] transition-colors group-hover:text-[#1C0ED7] dark:text-white"
                                    >
                                        {{ item.title }}
                                    </h4>
                                    <p
                                        v-if="item.office"
                                        class="mt-1 truncate text-xs text-[#6B7280] dark:text-slate-400"
                                    >
                                        {{ item.office }}
                                    </p>
                                </div>
                            </Link>
                        </div>
                        <p
                            v-else
                            class="mt-3 grid flex-1 place-items-center rounded-lg border border-dashed border-[#D8DEE8] p-6 text-center text-sm leading-6 text-[#6B7280] dark:border-white/15 dark:text-slate-400"
                        >
                            Press releases will appear here after published news
                            records are available.
                        </p>
                    </section>

                    <section
                        class="rounded-lg border border-[#D8DEE8] bg-white p-5 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-slate-900"
                        aria-labelledby="announcements-heading"
                    >
                        <div
                            class="flex min-h-11 items-center justify-between gap-4"
                        >
                            <h3
                                id="announcements-heading"
                                class="text-sm font-bold tracking-wide text-[#1A2340] uppercase dark:text-white"
                            >
                                Official announcements
                            </h3>
                            <Link
                                :href="announcementsIndex()"
                                class="text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7] dark:text-sky-300"
                            >
                                View all
                            </Link>
                        </div>

                        <div
                            v-if="announcementItems.length"
                            class="mt-3 grid gap-3 sm:grid-cols-3"
                        >
                            <Link
                                v-for="announcement in announcementItems"
                                :key="announcement.item.id"
                                :href="newsShow(announcement.item.slug)"
                                class="group grid grid-cols-[3.75rem_1fr] gap-3 rounded-lg border border-[#D8DEE8] p-3 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] dark:border-white/10"
                            >
                                <time
                                    v-if="announcement.date"
                                    :datetime="
                                        announcement.item.date ?? undefined
                                    "
                                    class="border-r border-[#D8DEE8] pr-3 text-center dark:border-white/10"
                                >
                                    <span
                                        class="block text-xs text-[#6B7280] dark:text-slate-400"
                                        >{{ announcement.date.month }}</span
                                    >
                                    <span
                                        class="block font-serif text-2xl leading-none font-semibold text-[#111827] dark:text-white"
                                        >{{ announcement.date.day }}</span
                                    >
                                    <span
                                        class="mt-1 block text-[0.7rem] text-[#6B7280] dark:text-slate-400"
                                        >{{ announcement.date.year }}</span
                                    >
                                    <span
                                        class="mx-auto mt-2 block h-0.5 w-6 bg-[#F2B900]"
                                        aria-hidden="true"
                                    ></span>
                                </time>
                                <div class="min-w-0 self-center">
                                    <h4
                                        class="line-clamp-2 text-sm leading-snug font-semibold text-[#1A2340] transition-colors group-hover:text-[#1C0ED7] dark:text-white"
                                    >
                                        {{ announcement.item.title }}
                                    </h4>
                                    <p
                                        class="mt-1 truncate text-xs text-[#6B7280] dark:text-slate-400"
                                    >
                                        {{
                                            announcement.item.office ||
                                            announcement.item.type
                                        }}
                                    </p>
                                </div>
                            </Link>
                        </div>
                        <p
                            v-else
                            class="mt-3 rounded-lg border border-dashed border-[#D8DEE8] p-6 text-center text-sm leading-6 text-[#6B7280] dark:border-white/15 dark:text-slate-400"
                        >
                            Announcements will appear here after published
                            announcement records are available.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>
