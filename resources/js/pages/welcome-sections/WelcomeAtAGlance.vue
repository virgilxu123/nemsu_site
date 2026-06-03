<script setup lang="ts">
import {
    ArrowRight,
    Building2,
    GraduationCap,
    MapPin,
    UserCheck,
    Users,
} from 'lucide-vue-next';
import type { Component, CSSProperties } from 'vue';

type GlanceIcon = 'students' | 'personnel' | 'graduates' | 'map';
type RevealDirection = 'down' | 'left' | 'right' | 'up';

type GlanceStat = {
    key: string;
    label: string;
    value: string;
    scope: string;
    description: string;
    icon: GlanceIcon;
};

type MapHighlight = {
    label: string;
    description: string;
    top: string;
    left: string;
};

defineProps<{
    stats: GlanceStat[];
    mapHighlights: MapHighlight[];
    staggerDelay: (section: string, index: number) => CSSProperties;
    revealClasses: (section: string, direction?: RevealDirection) => string;
}>();

const iconComponents: Record<GlanceIcon, Component> = {
    students: Users,
    personnel: UserCheck,
    graduates: GraduationCap,
    map: MapPin,
};
</script>

<template>
    <section
        id="at-a-glance"
        data-scroll-section="at-a-glance"
        class="relative isolate overflow-hidden bg-[#f7f8f5] py-16 dark:bg-slate-950"
    >
        <div
            class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_15%_20%,rgba(242,183,5,0.20),transparent_28%),radial-gradient(circle_at_85%_10%,rgba(11,102,128,0.18),transparent_30%),linear-gradient(135deg,rgba(255,255,255,0.92),rgba(230,243,245,0.74))] dark:bg-[radial-gradient(circle_at_15%_20%,rgba(242,183,5,0.10),transparent_28%),radial-gradient(circle_at_85%_10%,rgba(56,189,248,0.12),transparent_30%),linear-gradient(135deg,rgba(2,6,23,1),rgba(15,23,42,0.94))]"
        ></div>

        <div
            :class="revealClasses('at-a-glance', 'up')"
            class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <div
                class="flex flex-col justify-between gap-6 md:flex-row md:items-end"
            >
                <div class="max-w-3xl">
                    <p
                        class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                    >
                        NEMSU at a Glance
                    </p>
                    <h2
                        class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 sm:text-4xl dark:text-white"
                    >
                        A quick system-wide snapshot for students, personnel,
                        graduates, and campus locations
                    </h2>
                    <p
                        class="mt-4 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300"
                    >
                        Dummy figures are shown for layout testing. The section
                        is data-driven, so real values can be supplied once the
                        official records are ready.
                    </p>
                </div>

                <a
                    href="#campuses"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-[#0b6680]/20 bg-white/80 px-5 text-sm font-semibold text-[#1711d4] shadow-sm shadow-slate-900/5 backdrop-blur transition hover:-translate-y-0.5 hover:border-[#0b6680]/45 hover:bg-white dark:border-white/10 dark:bg-white/5 dark:text-sky-100 dark:hover:bg-white/[0.08]"
                >
                    View campuses
                    <ArrowRight class="size-4" aria-hidden="true" />
                </a>
            </div>

            <div class="mt-10 grid gap-5 lg:grid-cols-[1.05fr_0.95fr]">
                <div class="grid gap-4 sm:grid-cols-2">
                    <article
                        v-for="(stat, index) in stats"
                        :key="stat.key"
                        :style="staggerDelay('at-a-glance', index)"
                        class="group relative isolate overflow-hidden rounded-md border border-slate-200 bg-white/88 p-6 shadow-sm shadow-slate-900/5 backdrop-blur transition hover:-translate-y-1 hover:border-[#0b6680]/45 hover:shadow-xl hover:shadow-slate-900/10 dark:border-white/10 dark:bg-slate-950/70 dark:hover:border-sky-300/45"
                    >
                        <div
                            class="absolute top-0 right-0 -z-10 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-[#f2b705]/20 transition group-hover:scale-125 dark:bg-[#f2b705]/10"
                        ></div>

                        <div class="flex items-start justify-between gap-4">
                            <span
                                class="inline-flex size-12 items-center justify-center rounded-md bg-[#e6f3f5] text-[#0b6680] dark:bg-sky-400/10 dark:text-sky-200"
                            >
                                <component
                                    :is="iconComponents[stat.icon]"
                                    class="size-6"
                                    aria-hidden="true"
                                />
                            </span>
                            <span
                                class="rounded bg-[#fff4cc] px-2.5 py-1 text-xs font-semibold text-[#795200] dark:bg-[#f2b705]/15 dark:text-[#f2b705]"
                            >
                                {{ stat.scope }}
                            </span>
                        </div>

                        <p
                            class="mt-7 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white"
                        >
                            {{ stat.value }}
                        </p>
                        <h3
                            class="mt-3 text-base font-semibold text-slate-950 dark:text-white"
                        >
                            {{ stat.label }}
                        </h3>
                        <p
                            class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            {{ stat.description }}
                        </p>
                    </article>
                </div>

                <article
                    class="relative isolate overflow-hidden rounded-md border border-slate-200 bg-[#061b49] p-5 text-white shadow-xl shadow-slate-900/15 dark:border-white/10"
                >
                    <div
                        class="absolute inset-0 -z-10 bg-[linear-gradient(135deg,rgba(6,27,73,0.98),rgba(11,102,128,0.78)),radial-gradient(circle_at_70%_20%,rgba(242,183,5,0.24),transparent_28%)]"
                    ></div>

                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p
                                class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                            >
                                Location Map
                            </p>
                            <h3 class="mt-3 text-2xl font-semibold">
                                Campus footprint preview
                            </h3>
                            <p class="mt-3 text-sm leading-7 text-sky-100">
                                Replace these sample pins with campus
                                coordinates, labels, or an embedded map when
                                final data is available.
                            </p>
                        </div>
                        <span
                            class="hidden size-12 shrink-0 items-center justify-center rounded-md border border-white/15 bg-white/10 text-[#f2b705] sm:inline-flex"
                        >
                            <Building2 class="size-6" aria-hidden="true" />
                        </span>
                    </div>

                    <div
                        class="relative mt-6 min-h-[22rem] overflow-hidden rounded-md border border-white/15 bg-[#0b6680]/35"
                    >
                        <div
                            class="absolute inset-0 bg-[linear-gradient(120deg,transparent_0_18%,rgba(255,255,255,0.08)_18%_19%,transparent_19%_42%,rgba(255,255,255,0.08)_42%_43%,transparent_43%_100%),radial-gradient(circle_at_35%_35%,rgba(242,183,5,0.28),transparent_18%),radial-gradient(circle_at_68%_62%,rgba(255,255,255,0.18),transparent_22%)]"
                        ></div>
                        <div
                            class="absolute inset-x-8 top-1/2 h-px -rotate-12 bg-white/20"
                        ></div>
                        <div
                            class="absolute inset-y-8 left-1/2 w-px rotate-12 bg-white/20"
                        ></div>

                        <div
                            v-for="highlight in mapHighlights"
                            :key="highlight.label"
                            class="absolute"
                            :style="{ top: highlight.top, left: highlight.left }"
                        >
                            <span
                                class="relative flex size-4 rounded-full bg-[#f2b705] ring-4 ring-[#f2b705]/20"
                            >
                                <span
                                    class="absolute inset-0 animate-ping rounded-full bg-[#f2b705]/60"
                                ></span>
                            </span>
                            <div
                                class="mt-2 w-36 rounded bg-white/95 p-2 text-xs text-slate-700 shadow-lg shadow-black/20"
                            >
                                <p class="font-semibold text-slate-950">
                                    {{ highlight.label }}
                                </p>
                                <p class="mt-1 leading-5">
                                    {{ highlight.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
