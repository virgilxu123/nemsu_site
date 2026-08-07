<script setup lang="ts">
import type {
    GlanceStat,
    MapHighlight,
    RevealClasses,
    StaggerDelay,
} from '@/types';

defineProps<{
    stats: GlanceStat[];
    mapHighlights: MapHighlight[];
    staggerDelay: StaggerDelay;
    revealClasses: RevealClasses;
}>();
</script>

<template>
    <section
        id="at-a-glance"
        data-scroll-section="at-a-glance"
        class="relative isolate min-h-[34rem] overflow-hidden bg-[#EEF2FF] py-16 lg:py-20 dark:bg-slate-950"
    >
        <div
            class="pointer-events-none absolute inset-x-0 bottom-[-2vw] -z-10 overflow-hidden"
            aria-hidden="true"
        >
            <p
                class="w-full text-center font-serif text-[27.5vw] leading-[0.72] font-bold tracking-[-0.085em] whitespace-nowrap text-[#08045F]/5 select-none dark:text-white/5"
            >
                NEMSU
            </p>
        </div>

        <div
            :class="revealClasses('at-a-glance', 'up')"
            class="relative mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <div
                class="grid w-full items-center gap-8 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-0"
            >
                <div class="min-w-0">
                    <header class="relative max-w-xl pt-9">
                        <span
                            class="absolute top-0 left-0 size-36 rounded-full bg-[#F2B900] sm:size-40"
                            aria-hidden="true"
                        ></span>
                        <span
                            class="absolute top-0 left-24 size-20 bg-[radial-gradient(circle,#08045F_1.5px,transparent_1.5px)] bg-[size:0.75rem_0.75rem] sm:left-28"
                            aria-hidden="true"
                        ></span>

                        <div class="relative pl-10 sm:pl-14">
                            <h2
                                class="flex flex-wrap items-baseline text-3xl leading-[1.08] text-[#08045F] sm:text-4xl dark:text-white"
                            >
                                <span
                                    class="font-serif font-bold tracking-tight"
                                >
                                    NEMSU
                                </span>
                                <span class="ml-1 font-serif font-normal">
                                    at a
                                </span>
                                <span
                                    class="ml-2 font-sans text-[3.5rem] font-normal italic"
                                >
                                    Glance
                                </span>
                            </h2>
                            <span
                                class="mt-3 block h-0.5 w-12 bg-[#08045F] dark:bg-[#F2B900]"
                                aria-hidden="true"
                            ></span>
                            <p
                                class="mt-4 max-w-sm leading-5 text-[#252063] dark:text-slate-300"
                            >
                                Seven campuses serving communities across
                                Surigao del Sur
                            </p>
                            <p class="sr-only">
                                Official figures from the NEMSU enrollment,
                                HRMO, and campus reports.
                            </p>
                        </div>
                    </header>

                    <div
                        class="mt-14 grid grid-cols-2 gap-x-8 gap-y-9 pl-10 sm:max-w-xl sm:pl-14"
                    >
                        <article
                            v-for="(stat, index) in stats"
                            :key="stat.key"
                            :style="staggerDelay('at-a-glance', index)"
                            class="min-w-0 border-b border-[#08045F] pb-3 dark:border-white/30"
                        >
                            <p
                                class="font-serif text-2xl leading-none font-bold tracking-tight text-[#08045F] sm:text-3xl dark:text-white"
                            >
                                {{ stat.value }}
                            </p>
                            <h3
                                class="mt-2 text-sm leading-4 font-medium text-[#252063] dark:text-slate-200"
                            >
                                {{ stat.label }}
                            </h3>
                            <p
                                v-if="stat.scope"
                                class="mt-4 text-[0.65rem] leading-4 text-[#625F91] dark:text-slate-400"
                            >
                                {{ stat.scope }}
                            </p>
                        </article>
                    </div>
                </div>

                <figure
                    class="relative mx-auto w-full max-w-[36rem] lg:-ml-4 lg:justify-self-start"
                >
                    <img
                        src="/storage/images/nemsu-at-glance/nemsu-map.png"
                        alt="Map of Surigao del Sur showing the seven NEMSU campuses"
                        width="713"
                        height="764"
                        loading="lazy"
                        decoding="async"
                        class="h-auto w-full object-contain"
                    />
                </figure>
            </div>
        </div>
    </section>
</template>
