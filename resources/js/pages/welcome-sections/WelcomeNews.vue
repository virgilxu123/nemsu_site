<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';
import { computed } from 'vue';

import { index as announcementsIndex } from '@/routes/announcements';
import { show as newsShow } from '@/routes/news';
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
        class="bg-white py-16 lg:py-20 dark:bg-slate-950"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="mb-9 text-center">
                <h2
                    class="font-serif text-3xl font-semibold tracking-tight text-[#08045F] sm:text-4xl dark:text-white"
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
                class="grid gap-4 lg:grid-cols-[minmax(0,0.86fr)_minmax(0,1fr)] lg:items-start"
            >
                <article
                    class="min-w-0 overflow-hidden rounded-lg border border-[#D8DEE8] bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-slate-900"
                >
                    <Link
                        v-if="props.featuredNews"
                        :href="newsShow(props.featuredNews.slug)"
                        class="group flex h-full flex-col focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-[#1C0ED7]"
                    >
                        <div
                            class="relative aspect-video overflow-hidden bg-[#F1F5F9] dark:bg-white/5"
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
                            <span
                                class="absolute top-3 left-3 rounded-full bg-white px-2.5 py-1 text-[0.65rem] font-semibold text-[#1C0ED7] shadow-sm dark:bg-slate-900 dark:text-sky-300"
                            >
                                Featured
                            </span>
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <div
                                class="flex flex-wrap items-center gap-2 text-[0.65rem] text-[#252063] dark:text-slate-400"
                            >
                                <span
                                    class="font-semibold text-[#1C0ED7] uppercase dark:text-sky-300"
                                >
                                    {{
                                        props.featuredNews.type ||
                                        'University news'
                                    }}
                                </span>
                                <span
                                    v-if="props.featuredNews.date"
                                    class="size-1 rounded-full bg-[#1C0ED7]"
                                    aria-hidden="true"
                                ></span>
                                <span v-if="props.featuredNews.date">
                                    {{ props.featuredNews.date }}
                                </span>
                            </div>
                            <h3
                                class="mt-3 font-serif text-xl leading-tight font-semibold text-[#08045F] transition-colors group-hover:text-[#1C0ED7] sm:text-2xl dark:text-white"
                            >
                                {{ props.featuredNews.title }}
                            </h3>
                            <p
                                v-if="props.featuredNews.excerpt"
                                class="mt-3 line-clamp-4 mask-b-from-35% mask-b-to-95% text-base leading-7 text-[#4C4B8F] dark:text-slate-300"
                            >
                                {{ props.featuredNews.excerpt }}
                            </p>
                            <span class="mt-5 lg:mt-auto lg:pt-5">
                                <span
                                    class="inline-flex min-h-11 items-center gap-3 rounded-md bg-[#1C0ED7] px-5 py-2.5 text-sm font-semibold text-white transition-colors group-hover:bg-[#160BB2]"
                                >
                                    Read more
                                    <ArrowRight
                                        class="size-4 transition-transform group-hover:translate-x-1"
                                        aria-hidden="true"
                                    />
                                </span>
                            </span>
                        </div>
                    </Link>

                    <div
                        v-else
                        class="grid min-h-80 place-items-center bg-[#F8FAFC] p-6 text-center text-sm leading-6 text-[#6B7280] dark:bg-white/[0.03] dark:text-slate-400"
                    >
                        Featured news will appear here after a published news
                        record is marked as featured.
                    </div>
                </article>

                <section
                    class="grid min-w-0 content-start gap-4"
                    aria-label="Latest news"
                >
                    <h3 class="sr-only">Latest news</h3>

                    <template v-if="props.pressReleases.length">
                        <Link
                            v-for="item in props.pressReleases.slice(0, 5)"
                            :key="item.id"
                            :href="newsShow(item.slug)"
                            class="group grid min-h-28 grid-cols-[7.5rem_minmax(0,1fr)] overflow-hidden rounded-lg border border-[#D8DEE8] bg-white shadow-sm shadow-slate-900/5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1C0ED7] sm:grid-cols-[10rem_minmax(0,1fr)] dark:border-white/10 dark:bg-slate-900"
                        >
                            <div
                                class="relative min-h-28 overflow-hidden bg-[#F1F5F9] dark:bg-white/5"
                            >
                                <img
                                    v-if="item.photoUrl"
                                    :src="item.photoUrl"
                                    :alt="item.title"
                                    class="absolute inset-0 size-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                />
                                <div
                                    v-else
                                    class="grid size-full place-items-center px-3 text-center text-[0.65rem] text-[#94A3B8] dark:text-slate-500"
                                >
                                    University news image
                                </div>
                            </div>

                            <div
                                class="flex min-w-0 flex-col justify-center px-4 py-3"
                            >
                                <p
                                    class="flex flex-wrap items-center gap-2 text-[0.65rem] leading-4 text-[#262626] dark:text-slate-400"
                                >
                                    <span
                                        class="font-semibold text-[#334155] uppercase dark:text-slate-300"
                                    >
                                        {{ item.type || 'University news' }}
                                    </span>
                                    <span
                                        v-if="item.date"
                                        class="size-1 rounded-full bg-[#1C0ED7]"
                                        aria-hidden="true"
                                    ></span>
                                    <span v-if="item.date">
                                        {{ item.date }}
                                    </span>
                                </p>
                                <h4
                                    class="mt-1.5 line-clamp-2 text-sm leading-snug font-bold text-[#111111] uppercase transition-colors group-hover:text-[#1C0ED7] sm:text-base dark:text-white"
                                >
                                    {{ item.title }}
                                </h4>
                                <p
                                    v-if="item.excerpt || item.office"
                                    class="mt-1 line-clamp-1 text-xs text-[#A3A3A3] dark:text-slate-400"
                                >
                                    {{ item.excerpt || item.office }}
                                </p>
                            </div>
                        </Link>
                    </template>
                    <p
                        v-else
                        class="grid min-h-80 place-items-center rounded-lg border border-dashed border-[#D8DEE8] p-6 text-center text-sm leading-6 text-[#6B7280] dark:border-white/15 dark:text-slate-400"
                    >
                        Press releases will appear here after published news
                        records are available.
                    </p>
                </section>
            </div>

            <section
                class="mt-6 rounded-lg border border-[#D8DEE8] bg-white p-5 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-slate-900"
                aria-labelledby="announcements-heading"
            >
                <div class="flex min-h-11 items-center justify-between gap-4">
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
                            :datetime="announcement.item.date ?? undefined"
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
                    Announcements will appear here after published announcement
                    records are available.
                </p>
            </section>
        </div>
    </section>
</template>
