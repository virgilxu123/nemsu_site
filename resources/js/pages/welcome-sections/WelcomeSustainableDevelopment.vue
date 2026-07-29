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
        class="relative isolate overflow-hidden border-y border-[#D8DEE8] bg-[#EEF3FF] py-16 lg:py-20 dark:border-white/10 dark:bg-slate-950"
    >
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <span
                class="absolute top-0 left-0 font-academic text-[20rem] leading-none font-semibold tracking-[-0.12em] text-[#DCE5F7] select-none sm:text-[26rem] lg:-top-20 lg:-left-4 lg:text-[23rem] dark:text-white/[0.025]"
                data-sdg-watermark
            >
                SDG
            </span>
        </div>

        <div
            class="pointer-events-none absolute inset-y-0 left-1/2 z-10 hidden w-full max-w-7xl -translate-x-1/2 px-4 sm:px-6 lg:block lg:px-8"
            data-sdg-logo-rail
        >
            <div
                class="relative ml-auto h-full w-[3.25rem] overflow-hidden"
                aria-label="United Nations Sustainable Development Goals"
            >
                <img
                    src="/storage/images/sdg/sdg-logo-1.png"
                    alt="United Nations Sustainable Development Goals vertical banner"
                    class="absolute top-0 left-0 h-auto w-[3.25rem] max-w-none"
                />
            </div>
        </div>

        <div
            :class="revealClasses('sustainable-development', 'up')"
            class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <div
                class="grid w-full items-start gap-10 lg:grid-cols-[5rem_minmax(0,1.25fr)_minmax(15rem,0.8fr)_3.25rem] lg:gap-8"
            >
                <div
                    class="relative mx-auto size-20 lg:mt-5"
                    aria-hidden="true"
                >
                    <span
                        class="absolute inset-0 rounded-full bg-[#F8BC00] shadow-[0_18px_22px_-12px_rgba(139,103,0,0.55)]"
                    ></span>
                    <span
                        class="absolute -top-2 left-1/2 grid -translate-x-1/2 grid-cols-3 gap-2"
                    >
                        <span
                            v-for="dot in 9"
                            :key="dot"
                            class="size-1 rounded-full bg-[#1C0ED7]"
                        ></span>
                    </span>
                </div>

                <article class="max-w-xl">
                    <h2
                        class="font-academic text-3xl leading-[1.08] font-bold tracking-tight text-[#08045F] sm:text-4xl dark:text-white"
                    >
                        NEMSU’s Commitment to the United Nations Sustainable
                        Development Goals
                    </h2>
                    <div
                        class="mt-5 h-0.5 w-14 bg-[#F2B900] lg:mt-4"
                        aria-hidden="true"
                    ></div>

                    <h3
                        class="mt-5 max-w-sm text-sm leading-5 font-bold text-[#08045F] dark:text-slate-100"
                    >
                        University Contributions to Sustainable Development
                    </h3>
                    <p
                        class="mt-5 max-w-xl text-base leading-7 text-[#4D5D91] dark:text-slate-300"
                    >
                        {{ description }}
                    </p>
                    <a
                        :href="learnMoreUrl"
                        class="mt-5 inline-flex min-h-11 items-center gap-3 rounded-md bg-[#F8BC00] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#DFA900] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7]"
                    >
                        Learn more
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </a>
                </article>

                <article class="min-w-0">
                    <div class="sr-only">
                        <h3
                            class="font-academic text-2xl font-bold text-[#08045F] dark:text-white"
                        >
                            Latest SDG Initiatives
                        </h3>
                    </div>

                    <div class="grid gap-4 lg:gap-3">
                        <a
                            v-for="article in articles.slice(0, 4)"
                            :key="article.id"
                            :href="articleUrl(article)"
                            class="group relative flex min-h-22 overflow-hidden rounded-md border border-white/15 bg-[#100A69] shadow-[0_16px_28px_-16px_rgba(8,4,95,0.65)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_34px_-16px_rgba(8,4,95,0.75)] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7] lg:h-[5.6875rem] lg:min-h-0 dark:border-white/10"
                        >
                            <img
                                v-if="article.photoUrl"
                                :src="article.photoUrl"
                                :alt="article.title"
                                class="absolute inset-0 size-full object-cover transition duration-500 group-hover:scale-[1.04]"
                            />
                            <div
                                class="absolute inset-0 bg-[linear-gradient(90deg,rgba(8,4,95,0.96)_0%,rgba(8,4,95,0.78)_58%,rgba(8,4,95,0.42)_100%)]"
                                aria-hidden="true"
                            ></div>
                            <div
                                class="relative z-10 flex min-h-22 flex-1 flex-col justify-end p-4 lg:min-h-0 lg:p-3"
                            >
                                <h4
                                    class="line-clamp-2 max-w-60 font-academic text-sm leading-snug font-bold text-white sm:text-base"
                                >
                                    {{ article.title }}
                                </h4>
                                <p
                                    class="mt-2 text-[0.65rem] leading-4 font-medium text-white/60"
                                >
                                    {{ article.date || article.category }}
                                </p>
                            </div>
                        </a>
                        <p
                            v-if="articles.length === 0"
                            class="rounded-lg border border-dashed border-[#B9C6E4] bg-white/60 p-8 text-center text-sm leading-6 text-[#64729C] dark:border-white/15 dark:bg-white/[0.03] dark:text-slate-400"
                        >
                            SDG initiatives will appear here after published
                            records are available.
                        </p>
                    </div>

                    <Link
                        v-if="articles.length > 0"
                        :href="newsIndex()"
                        class="mt-5 inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-[#1C0ED7] hover:text-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7] dark:text-sky-300"
                    >
                        View all SDG initiatives
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </Link>
                </article>
            </div>
        </div>
    </section>
</template>
