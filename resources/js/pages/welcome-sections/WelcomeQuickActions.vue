<script setup lang="ts">
import { ArrowRight } from 'lucide-vue-next';

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
        class="bg-white dark:bg-slate-950"
        aria-label="Quick access"
    >
        <div
            :class="revealClasses('quick-actions')"
            class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8"
        >
            <div class="grid gap-4 md:grid-cols-3">
                <a
                    v-for="(action, index) in actions"
                    :key="action.title"
                    :href="action.href"
                    :style="staggerDelay('quick-actions', index)"
                    class="group flex min-h-40 flex-col justify-between gap-5 border border-white/20 bg-[#1c0ed7] px-5 py-7 transition-colors hover:bg-[#160BB2] focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-white sm:px-6 md:min-h-32 md:flex-row md:items-center"
                >
                    <span class="min-w-0 flex-1">
                        <span
                            class="block font-serif text-xl font-semibold text-white"
                        >
                            {{ action.title }}
                        </span>
                        <span
                            class="mt-2 block text-sm leading-6 text-white/80"
                        >
                            {{ action.description }}
                        </span>
                    </span>
                    <span
                        class="flex items-center justify-between gap-3 text-sm font-semibold text-white transition-colors group-hover:text-white/90"
                    >
                        View details
                        <ArrowRight
                            class="size-4 transition-transform group-hover:translate-x-1"
                            aria-hidden="true"
                        />
                    </span>
                </a>
            </div>
        </div>
    </section>
</template>
