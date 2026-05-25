<script setup lang="ts">
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { home } from '@/routes';
import { show as newsShow } from '@/routes/news';
import { ArrowLeft, CalendarDays, Megaphone } from 'lucide-vue-next';

type NewsArticle = {
    id: string;
    type: string;
    title: string;
    slug: string;
    excerpt?: string | null;
    contentHtml: string;
    date: string | null;
    office: string;
    photoUrl?: string | null;
};

type NewsItem = Omit<NewsArticle, 'contentHtml'>;

const props = defineProps<{
    article: NewsArticle;
    latestNews: NewsItem[];
}>();
</script>

<template>
    <PublicSiteLayout>
        <Head :title="props.article.title" />

        <article class="bg-[#f7f8f5] dark:bg-slate-950">
            <header
                class="relative isolate overflow-hidden bg-[#06131f] text-white"
            >
                <img
                    v-if="props.article.photoUrl"
                    :src="props.article.photoUrl"
                    :alt="props.article.title"
                    class="absolute inset-0 h-full w-full object-cover opacity-60"
                />
                <div
                    v-else
                    class="absolute inset-0 grid place-items-center bg-[#062b49]"
                >
                    <Megaphone
                        class="size-20 text-white/30"
                        aria-hidden="true"
                    />
                </div>
                <div
                    class="absolute inset-0 bg-linear-to-t from-[#06131f] via-[#06131f]/80 to-[#06131f]/20"
                ></div>

                <div
                    class="relative mx-auto flex min-h-[72svh] max-w-7xl flex-col justify-between px-4 py-8 sm:px-6 lg:px-8"
                >
                    <Link
                        :href="home()"
                        class="inline-flex w-fit items-center gap-2 rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm font-semibold text-white/90 backdrop-blur transition hover:bg-white/15 hover:text-white"
                    >
                        <ArrowLeft class="size-4" aria-hidden="true" />
                        Back to home
                    </Link>

                    <div class="grid gap-8 py-12 lg:grid-cols-[1fr_18rem]">
                        <div class="max-w-5xl">
                            <div class="mb-6 h-1 w-16 bg-[#f2b705]"></div>
                            <div
                                class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs font-medium text-white/80"
                            >
                                <span
                                    class="rounded bg-[#9b1c31] px-2.5 py-1 text-white shadow-sm"
                                >
                                    {{ props.article.type }}
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <CalendarDays
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    {{ props.article.date }}
                                </span>
                                <span>{{ props.article.office }}</span>
                            </div>

                            <h1
                                class="mt-5 max-w-5xl text-4xl leading-[1.02] font-semibold tracking-normal text-balance sm:text-5xl lg:text-6xl"
                            >
                                {{ props.article.title }}
                            </h1>

                            <p
                                v-if="props.article.excerpt"
                                class="mt-6 max-w-3xl text-base leading-8 text-white/80 sm:text-lg"
                            >
                                {{ props.article.excerpt }}
                            </p>
                        </div>

                        <aside
                            class="hidden self-end border-t border-white/20 pt-5 text-sm leading-6 text-white/70 lg:block"
                        >
                            <p class="font-semibold text-white">
                                {{ props.article.office }}
                            </p>
                            <p class="mt-2">
                                Published
                                <span class="text-white">{{
                                    props.article.date
                                }}</span>
                            </p>
                        </aside>
                    </div>
                </div>
            </header>

            <div
                class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[minmax(0,1fr)_21rem] lg:px-8"
            >
                <main class="min-w-0">
                    <div
                        class="mx-auto mb-8 flex max-w-3xl flex-wrap items-center gap-x-4 gap-y-2 border-b border-slate-200 pb-6 text-sm text-slate-500 dark:border-white/10 dark:text-slate-400"
                    >
                        <span
                            class="font-semibold text-slate-950 dark:text-white"
                        >
                            {{ props.article.office }}
                        </span>
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                        <span>{{ props.article.date }}</span>
                    </div>

                    <div
                        class="mx-auto max-w-3xl text-[1.04rem] leading-8 text-slate-700 dark:text-slate-200 [&_a]:font-semibold [&_a]:text-[#0b6680] hover:[&_a]:text-[#9b1c31] dark:[&_a]:text-sky-200 [&_blockquote]:my-9 [&_blockquote]:border-l-4 [&_blockquote]:border-[#9b1c31] [&_blockquote]:bg-white [&_blockquote]:py-4 [&_blockquote]:pr-5 [&_blockquote]:pl-5 [&_blockquote]:text-lg [&_blockquote]:leading-8 [&_blockquote]:font-medium [&_blockquote]:text-slate-700 dark:[&_blockquote]:bg-white/5 dark:[&_blockquote]:text-slate-200 [&_br]:my-2 [&_h2]:mt-12 [&_h2]:text-3xl [&_h2]:leading-tight [&_h2]:font-semibold [&_h2]:text-slate-950 dark:[&_h2]:text-white [&_h3]:mt-9 [&_h3]:text-2xl [&_h3]:leading-tight [&_h3]:font-semibold [&_h3]:text-slate-950 dark:[&_h3]:text-white [&_img]:my-9 [&_img]:w-full [&_img]:rounded-md [&_img]:object-cover [&_img]:shadow-sm [&_li]:my-2 [&_ol]:my-6 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:my-6 [&_strong]:font-semibold [&_ul]:my-6 [&_ul]:list-disc [&_ul]:pl-6"
                        v-html="props.article.contentHtml"
                    ></div>
                </main>

                <aside
                    class="grid content-start gap-5 border-t border-slate-200 pt-6 lg:sticky lg:top-28 lg:border-t-0 lg:pt-0 dark:border-white/10"
                >
                    <div
                        class="border-b border-slate-200 pb-4 dark:border-white/10"
                    >
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Latest News
                        </p>
                        <h2
                            class="mt-2 text-xl leading-tight font-semibold text-slate-950 dark:text-white"
                        >
                            More from NEMSU
                        </h2>
                    </div>

                    <Link
                        v-for="item in props.latestNews"
                        :key="item.id"
                        :href="newsShow(item.slug)"
                        class="group grid grid-cols-[5.5rem_1fr] gap-3 border-b border-slate-200 pb-4 transition last:border-b-0 hover:border-[#9b1c31]/45 dark:border-white/10"
                    >
                        <div
                            class="overflow-hidden rounded-md bg-slate-100 dark:bg-white/10"
                        >
                            <img
                                v-if="item.photoUrl"
                                :src="item.photoUrl"
                                :alt="item.title"
                                class="aspect-[4/3] h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                            />
                            <div
                                v-else
                                class="grid aspect-[4/3] place-items-center text-[#9b1c31] dark:text-rose-200"
                            >
                                <Megaphone class="size-5" aria-hidden="true" />
                            </div>
                        </div>
                        <div class="min-w-0">
                            <p
                                class="text-[11px] font-medium text-slate-500 dark:text-slate-400"
                            >
                                {{ item.date }}
                            </p>
                            <h3
                                class="mt-1 line-clamp-2 text-sm leading-5 font-semibold text-slate-950 transition group-hover:text-[#062b49] dark:text-white dark:group-hover:text-sky-100"
                            >
                                {{ item.title }}
                            </h3>
                        </div>
                    </Link>
                </aside>
            </div>
        </article>
    </PublicSiteLayout>
</template>
