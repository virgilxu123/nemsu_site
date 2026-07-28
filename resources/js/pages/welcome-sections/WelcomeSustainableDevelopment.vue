<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';

import { index as newsIndex, show as newsShow } from '@/routes/news';
import type { RevealClasses, SdgArticle } from '@/types';

const props = defineProps<{
    articles: SdgArticle[];
    description: string;
    learnMoreUrl: string;
    revealClasses: RevealClasses;
}>();

const articleUrl = (article: SdgArticle): string =>
    article.slug
        ? newsShow.url(article.slug)
        : article.href || props.learnMoreUrl;
</script>

<template>
    <section
        id="sustainable-development"
        data-scroll-section="sustainable-development"
        class="border-y border-[#D8DEE8] bg-[#F8FAFC] py-20 sm:py-24 dark:border-white/10 dark:bg-slate-950"
    >
        <div
            :class="revealClasses('sustainable-development', 'up')"
            class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-0 lg:px-8"
        >
            <article class="lg:pr-12">
                <!-- <p
                    class="text-xs font-semibold tracking-[0.16em] text-[#1C0ED7] uppercase dark:text-sky-300"
                >
                    Research and extension
                </p> -->
                <h2
                    class="font-serif text-3xl font-bold tracking-tight text-[#1A2340] sm:text-4xl dark:text-white"
                >
                    NEMSU’s Commitment to the United Nations Sustainable
                    Development Goals
                </h2>
                <div
                    class="mt-5 h-0.5 w-14 bg-[#F2B900]"
                    aria-hidden="true"
                ></div>

                <div
                    class="mt-9 grid items-start gap-8 xl:grid-cols-[13rem_1fr]"
                >
                    <img
                        src="/storage/images/sdg/1639491308447.png"
                        alt="United Nations Sustainable Development Goals color wheel showing all 17 goals"
                        class="mx-auto h-auto w-full max-w-80 object-contain xl:max-w-52"
                    />
                    <div>
                        <h3
                            class="font-serif text-xl leading-snug font-bold text-[#334155] dark:text-slate-100"
                        >
                            University Contributions to Sustainable Development
                        </h3>
                        <p
                            class="mt-4 leading-7 text-[#4B5563] dark:text-slate-300"
                        >
                            {{ description }}
                        </p>
                        <a
                            :href="learnMoreUrl"
                            class="mt-6 inline-flex min-h-11 items-center gap-2 rounded-[4px] bg-[#1C0ED7] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7]"
                        >
                            Learn more
                            <ArrowRight class="size-4" aria-hidden="true" />
                        </a>
                    </div>
                </div>
            </article>

            <article class="lg:pl-12">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h3
                        class="font-serif text-2xl font-bold text-[#1A2340] dark:text-white"
                    >
                        Latest SDG Initiatives
                    </h3>
                    <Link
                        :href="newsIndex()"
                        class="inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7] dark:text-sky-300"
                    >
                        View all SDG initiatives
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </Link>
                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <a
                        v-for="article in articles.slice(0, 2)"
                        :key="article.id"
                        :href="articleUrl(article)"
                        class="group flex h-full flex-col overflow-hidden rounded-lg border border-[#D8DEE8] bg-white shadow-sm shadow-slate-900/5 transition duration-300 hover:-translate-y-1 hover:border-[#1C0ED7]/30 hover:shadow-lg focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7] dark:border-white/10 dark:bg-slate-900 dark:hover:border-sky-300/30"
                    >
                        <div
                            class="aspect-video overflow-hidden bg-[#F1F5F9] dark:bg-white/5"
                        >
                            <img
                                v-if="article.photoUrl"
                                :src="article.photoUrl"
                                :alt="article.title"
                                class="size-full object-cover transition duration-500 group-hover:scale-[1.03]"
                            />
                            <div
                                v-else
                                class="grid size-full place-items-center px-4 text-center text-xs text-[#6B7280] dark:text-slate-400"
                            >
                                SDG initiative
                            </div>
                        </div>
                        <div class="flex flex-1 flex-col p-4">
                            <h4
                                class="line-clamp-3 font-serif text-base leading-snug font-bold text-[#1A2340] transition-colors group-hover:text-[#1C0ED7] dark:text-white dark:group-hover:text-sky-300"
                            >
                                {{ article.title }}
                            </h4>
                            <p
                                class="mt-auto pt-4 text-xs font-medium text-[#6B7280] dark:text-slate-400"
                            >
                                {{ article.date || article.category }}
                            </p>
                        </div>
                    </a>
                    <p
                        v-if="articles.length === 0"
                        class="rounded-lg border border-dashed border-[#D8DEE8] bg-white p-8 text-center text-sm leading-6 text-[#6B7280] sm:col-span-2 dark:border-white/15 dark:bg-white/[0.03] dark:text-slate-400"
                    >
                        SDG initiatives will appear here after published records
                        are available.
                    </p>
                </div>
            </article>
        </div>
    </section>
</template>
