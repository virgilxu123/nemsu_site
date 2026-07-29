<script setup lang="ts">
import { ArrowRight, Megaphone } from 'lucide-vue-next';

import type { QuickAction, RevealClasses, StaggerDelay } from '@/types';

defineProps<{
    actions: QuickAction[];
    revealClasses: RevealClasses;
    staggerDelay: StaggerDelay;
}>();
</script>

<template>
    <section
        data-scroll-section="quick-actions"
        class="bg-[#EEF2FF] dark:bg-slate-950"
        aria-label="Quick access"
    >
        <div
            :class="revealClasses('quick-actions')"
            class="mx-auto w-full max-w-[53rem] px-4 py-7 sm:px-6 sm:py-8 md:max-w-7xl lg:px-8 lg:py-9"
        >
            <div
                class="grid grid-cols-[repeat(auto-fit,minmax(min(100%,14rem),1fr))] gap-4 sm:gap-5 md:grid-cols-3 lg:gap-7"
            >
                <a
                    v-for="(action, index) in actions"
                    :key="action.title"
                    :href="action.href"
                    :style="staggerDelay('quick-actions', index)"
                    :class="
                        index === 1
                            ? 'from-[#2214C9] via-[#100668] to-[#07032F]'
                            : 'from-[#2617E6] via-[#1C0ED7] to-[#160BB2]'
                    "
                    class="group flex min-h-34 w-full flex-col gap-9 rounded-sm bg-linear-to-br p-4 text-white shadow-[0_5px_9px_rgba(15,23,42,0.32)] ring-1 ring-white/10 transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_16px_rgba(15,23,42,0.34)] focus-visible:outline-2 focus-visible:outline-offset-3 focus-visible:outline-[#F2B900] sm:min-h-38"
                >
                    <span class="flex items-center justify-between gap-3">
                        <span
                            class="flex size-9 shrink-0 items-center justify-center rounded-full bg-white/12 ring-1 ring-white/5"
                            aria-hidden="true"
                        >
                            <component
                                :is="action.icon ?? Megaphone"
                                class="size-3.5 fill-white text-white"
                                :stroke-width="1.75"
                            />
                        </span>
                        <span
                            class="inline-flex items-center gap-2 text-sm font-semibold text-[#F2B900] transition-colors group-hover:text-[#FFD84D]"
                        >
                            View Details
                            <ArrowRight
                                class="size-4 transition-transform group-hover:translate-x-1"
                                aria-hidden="true"
                            />
                        </span>
                    </span>

                    <span class="block min-w-0">
                        <span
                            class="inline-block font-serif text-xl font-semibold text-nowrap"
                        >
                            {{ action.title }}
                        </span>
                        <span
                            class="mt-2 block text-sm leading-6 text-white/80"
                        >
                            {{ action.description }}
                        </span>
                    </span>
                </a>
            </div>
        </div>
    </section>
</template>
