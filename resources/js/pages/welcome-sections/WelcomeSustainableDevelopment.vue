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
                <p
                    class="text-xs font-semibold tracking-[0.16em] text-[#1C0ED7] uppercase dark:text-sky-300"
                >
                    Research and extension
                </p>
                <h2
                    class="mt-3 font-serif text-3xl font-bold tracking-tight text-[#1A2340] sm:text-4xl dark:text-white"
                >
                    Sustainable Development Goals
                </h2>
                <div
                    class="mt-5 h-0.5 w-14 bg-[#F2B900]"
                    aria-hidden="true"
                ></div>

                <div
                    class="mt-9 grid items-center gap-8 sm:grid-cols-[10rem_1fr]"
                >
                    <div
                        class="relative mx-auto aspect-square w-40 rounded-full p-[1.2rem]"
                        style="
                            background: conic-gradient(
                                #e5243b 0deg 21deg,
                                #dda63a 21deg 42deg,
                                #4c9f38 42deg 63deg,
                                #c5192d 63deg 84deg,
                                #ff3a21 84deg 105deg,
                                #26bde2 105deg 126deg,
                                #fcc30b 126deg 147deg,
                                #a21942 147deg 168deg,
                                #fd6925 168deg 189deg,
                                #dd1367 189deg 210deg,
                                #fd9d24 210deg 231deg,
                                #bf8b2e 231deg 252deg,
                                #3f7e44 252deg 273deg,
                                #0a97d9 273deg 294deg,
                                #56c02b 294deg 315deg,
                                #00689d 315deg 336deg,
                                #19486a 336deg 360deg
                            );
                        "
                        role="img"
                        aria-label="United Nations Sustainable Development Goals color wheel"
                    >
                        <div
                            class="grid size-full place-items-center rounded-full bg-[#F8FAFC] text-center dark:bg-slate-950"
                        >
                            <span
                                class="text-xs font-bold tracking-wide text-[#334155] uppercase dark:text-slate-200"
                            >
                                17 SDGs
                            </span>
                        </div>
                    </div>
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

            <article
                class="border-[#D8DEE8] lg:border-l lg:pl-12 dark:border-white/10"
            >
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

                <div
                    class="mt-5 divide-y divide-[#D8DEE8] border-y border-[#D8DEE8] dark:divide-white/10 dark:border-white/10"
                >
                    <a
                        v-for="article in articles.slice(0, 3)"
                        :key="article.id"
                        :href="articleUrl(article)"
                        class="group grid grid-cols-[7rem_1fr] gap-4 py-5 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7] sm:grid-cols-[9rem_1fr]"
                    >
                        <div
                            class="aspect-[4/3] overflow-hidden bg-white dark:bg-white/5"
                        >
                            <img
                                v-if="article.photoUrl"
                                :src="article.photoUrl"
                                :alt="article.title"
                                class="size-full object-cover transition duration-500 group-hover:scale-[1.025]"
                            />
                            <div
                                v-else
                                class="grid size-full place-items-center px-2 text-center text-xs text-[#94A3B8]"
                            >
                                SDG initiative
                            </div>
                        </div>
                        <div class="self-center">
                            <h4
                                class="line-clamp-2 font-serif text-base leading-snug font-bold text-[#1A2340] transition group-hover:text-[#1C0ED7] sm:text-lg dark:text-white"
                            >
                                {{ article.title }}
                            </h4>
                            <p
                                class="mt-2 text-xs text-[#6B7280] dark:text-slate-400"
                            >
                                {{ article.date || article.category }}
                            </p>
                        </div>
                    </a>
                    <p
                        v-if="articles.length === 0"
                        class="py-10 text-sm text-[#6B7280] dark:text-slate-400"
                    >
                        SDG initiatives will appear here after published records
                        are available.
                    </p>
                </div>
            </article>
        </div>
    </section>
</template>
