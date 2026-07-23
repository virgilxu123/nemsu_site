<script setup lang="ts">
import { ArrowRight, Landmark } from 'lucide-vue-next';

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
        class="bg-white py-16 lg:py-20 dark:bg-slate-950"
    >
        <div
            :class="revealClasses('at-a-glance', 'up')"
            class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <header class="mb-9 text-center">
                <h2
                    class="font-serif text-3xl font-semibold tracking-tight text-[#1A2340] sm:text-4xl dark:text-white"
                >
                    NEMSU at a Glance
                </h2>
                <span
                    class="mx-auto mt-3 block h-1 w-16 rounded-full bg-[#F2B900]"
                    aria-hidden="true"
                ></span>
                <!-- <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-[#4B5563] dark:text-slate-300"
                >
                    Official figures from the NEMSU enrollment, HRMO, and campus
                    SNAP survey reports.
                </p> -->
            </header>

            <div class="grid gap-4 lg:grid-cols-[1.05fr_0.95fr]">
                <div class="grid gap-4 sm:grid-cols-2">
                    <article
                        v-for="(stat, index) in stats"
                        :key="stat.key"
                        :style="staggerDelay('at-a-glance', index)"
                        class="flex min-h-44 flex-col rounded-lg border border-[#D8DEE8] bg-white p-5 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-slate-900"
                    >
                        <span
                            class="block h-1 w-10 rounded-full bg-[#F2B900]"
                            aria-hidden="true"
                        ></span>
                        <p
                            class="mt-5 font-serif text-4xl font-semibold tracking-tight sm:text-5xl dark:text-sky-300"
                        >
                            {{ stat.value }}
                        </p>
                        <h4
                            class="mt-2 font-serif text-base font-semibold text-[#1A2340] dark:text-white"
                        >
                            {{ stat.label }}
                        </h4>
                        <p
                            v-if="stat.scope"
                            class="mt-auto pt-5 text-xs leading-5 font-medium text-[#6B7280] dark:text-slate-400"
                        >
                            {{ stat.scope }}
                        </p>
                    </article>
                </div>

                <article
                    class="relative isolate overflow-hidden rounded-lg border border-[#D8DEE8] bg-[#1c0ed7] p-5 text-white shadow-sm shadow-slate-900/5 dark:border-white/10"
                >
                    <div
                        class="absolute inset-0 -z-10 bg-[linear-gradient(135deg,rgba(28,14,215,0.98),rgba(28,14,215,0.82)),radial-gradient(circle_at_70%_20%,rgba(242,185,0,0.24),transparent_28%)]"
                    ></div>

                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p
                                class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase"
                            >
                                Location Map
                            </p>
                            <h4 class="mt-3 text-2xl font-semibold">
                                Campus footprint preview
                            </h4>
                            <p class="mt-3 text-sm leading-7 text-sky-100">
                                Seven campuses serving communities across
                                Surigao del Sur.
                            </p>
                        </div>
                        <!-- <span
                            class="hidden size-12 shrink-0 items-center justify-center rounded-md border border-white/15 bg-white/10 text-[#f2b705] sm:inline-flex"
                        >
                            <Building2 class="size-6" aria-hidden="true" />
                        </span> -->
                    </div>

                    <div
                        class="relative mx-auto mt-6 aspect-square w-full max-w-[32rem] overflow-hidden rounded-md border border-white/25 bg-[linear-gradient(rgba(11,102,128,0.055)_1px,transparent_1px),linear-gradient(90deg,rgba(11,102,128,0.055)_1px,transparent_1px),radial-gradient(circle_at_50%_45%,#ffffff_0%,#edf8fa_66%,#d9eef2_100%)] bg-[size:3rem_3rem,3rem_3rem,100%_100%] shadow-inner shadow-black/20"
                    >
                        <div
                            class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-[#0b6680]/10 to-transparent"
                        ></div>
                        <img
                            src="/images/campuses/tandag/facilities/nemsu_map.png"
                            alt="Map of Surigao del Sur showing the NEMSU campus footprint"
                            class="absolute inset-0 size-full scale-[1.035] object-contain drop-shadow-[0_12px_9px_rgba(6,27,73,0.28)]"
                        />

                        <svg
                            aria-hidden="true"
                            class="hidden"
                            viewBox="0 0 360 640"
                            preserveAspectRatio="none"
                        >
                            <defs>
                                <linearGradient
                                    id="sea"
                                    x1="0"
                                    y1="0"
                                    x2="1"
                                    y2="1"
                                >
                                    <stop offset="0" stop-color="#e7f5f7" />
                                    <stop offset="1" stop-color="#c9e8ed" />
                                </linearGradient>
                                <linearGradient
                                    id="land"
                                    x1="0"
                                    y1="0"
                                    x2="1"
                                    y2="1"
                                >
                                    <stop offset="0" stop-color="#4f9482" />
                                    <stop offset="0.52" stop-color="#257465" />
                                    <stop offset="1" stop-color="#155c54" />
                                </linearGradient>
                                <pattern
                                    id="terrain"
                                    width="28"
                                    height="28"
                                    patternUnits="userSpaceOnUse"
                                >
                                    <path
                                        d="M-6 21 Q5 10 16 21 T38 21"
                                        fill="none"
                                        stroke="#d7f0df"
                                        stroke-opacity=".16"
                                        stroke-width="1"
                                    />
                                    <path
                                        d="M-8 8 Q3-3 14 8 T36 8"
                                        fill="none"
                                        stroke="#d7f0df"
                                        stroke-opacity=".12"
                                        stroke-width="1"
                                    />
                                </pattern>
                                <filter
                                    id="map-shadow"
                                    x="-30%"
                                    y="-20%"
                                    width="170%"
                                    height="150%"
                                >
                                    <feDropShadow
                                        dx="-4"
                                        dy="7"
                                        flood-color="#062f39"
                                        flood-opacity=".24"
                                        stdDeviation="7"
                                    />
                                </filter>
                                <clipPath id="province-shape">
                                    <use href="#province-outline" />
                                </clipPath>
                                <path
                                    id="province-outline"
                                    d="M94 33 C110 20 132 18 147 24 L162 19 177 28 174 43 192 49 204 65 224 72 250 68 273 82 281 99 270 116 251 125 242 144 224 157 231 176 250 187 266 204 258 220 272 233 263 249 277 263 267 279 276 294 266 310 273 325 258 341 240 347 226 363 205 369 190 384 183 405 190 421 213 428 238 425 259 438 278 445 267 461 247 468 229 482 218 500 221 519 210 539 213 561 204 585 199 612 184 624 169 608 163 583 150 561 146 537 132 515 137 491 124 467 130 444 116 421 123 397 108 374 115 350 101 327 108 303 96 280 104 256 92 232 100 208 88 184 96 160 84 136 91 112 79 88 85 65 78 48 Z"
                                />
                            </defs>

                            <rect width="360" height="640" fill="url(#sea)" />
                            <g opacity=".22" stroke="#58a6b2" stroke-width="1">
                                <path d="M0 92 H360" />
                                <path d="M0 205 H360" />
                                <path d="M0 318 H360" />
                                <path d="M0 431 H360" />
                                <path d="M0 544 H360" />
                                <path d="M62 0 V640" />
                                <path d="M180 0 V640" />
                                <path d="M298 0 V640" />
                            </g>

                            <g filter="url(#map-shadow)">
                                <use
                                    href="#province-outline"
                                    fill="url(#land)"
                                    stroke="#0f5b61"
                                    stroke-width="2.5"
                                    stroke-linejoin="round"
                                />
                                <rect
                                    x="80"
                                    y="0"
                                    width="210"
                                    height="640"
                                    clip-path="url(#province-shape)"
                                    fill="url(#terrain)"
                                />
                            </g>

                            <g
                                fill="#3b8979"
                                stroke="#0f5b61"
                                stroke-width="1.5"
                            >
                                <path d="M204 42 l10 -7 8 8 -7 11 -10 -2 z" />
                                <path d="M222 55 l7 -4 5 6 -5 7 -7 -2 z" />
                                <path d="M279 215 l8 -5 6 7 -8 8 -7 -3 z" />
                                <path d="M281 274 l12 -8 8 8 -5 12 -12 1 z" />
                                <path d="M276 447 l8 -5 6 7 -6 7 -8 -2 z" />
                            </g>

                            <path
                                d="M151 44 C166 83 187 112 193 151 S209 214 202 253 187 315 188 363 180 402 194 430 212 452 207 493 197 536 194 586"
                                fill="none"
                                stroke="#f5cf63"
                                stroke-dasharray="3 5"
                                stroke-linecap="round"
                                stroke-width="2"
                            />

                            <g
                                fill="#316d71"
                                font-family="ui-sans-serif, system-ui, sans-serif"
                            >
                                <text
                                    x="290"
                                    y="315"
                                    font-size="10"
                                    letter-spacing="2"
                                    opacity=".72"
                                    text-anchor="middle"
                                    transform="rotate(90 290 315)"
                                >
                                    PHILIPPINE SEA
                                </text>
                                <text
                                    x="28"
                                    y="575"
                                    font-size="8"
                                    letter-spacing="1.2"
                                    opacity=".65"
                                >
                                    SURIGAO DEL SUR
                                </text>
                            </g>

                            <g transform="translate(30 34)">
                                <path
                                    d="M8 0 14 18 8 14 2 18Z"
                                    fill="#0b6680"
                                />
                                <text
                                    x="8"
                                    y="29"
                                    fill="#0b6680"
                                    font-family="ui-sans-serif, system-ui, sans-serif"
                                    font-size="8"
                                    font-weight="700"
                                    text-anchor="middle"
                                >
                                    N
                                </text>
                            </g>
                            <g
                                fill="#316d71"
                                font-family="ui-sans-serif, system-ui, sans-serif"
                                font-size="7"
                            >
                                <rect
                                    x="22"
                                    y="602"
                                    width="40"
                                    height="2"
                                    rx="1"
                                />
                                <text x="22" y="616">0</text>
                                <text x="48" y="616">50 km</text>
                            </g>
                        </svg>

                        <div
                            v-for="highlight in mapHighlights"
                            :key="highlight.label"
                            class="group absolute z-10 -translate-x-1/2 -translate-y-full"
                            :style="{
                                top: highlight.top,
                                left: highlight.left,
                            }"
                        >
                            <span
                                :class="[
                                    highlight.description === 'Main campus'
                                        ? 'bg-[#f2b705] text-[#061b49] ring-[#f2b705]/35'
                                        : 'bg-[#1711d4] text-white ring-[#1711d4]/25',
                                ]"
                                class="relative flex size-7 items-center justify-center rounded-full border-2 border-white shadow-lg ring-4 shadow-slate-950/30 transition duration-200 group-hover:scale-110"
                            >
                                <Landmark class="size-3.5" aria-hidden="true" />
                                <span
                                    class="absolute -inset-1.5 -z-10 rounded-full border border-white/70 bg-white/20"
                                ></span>
                            </span>
                            <div
                                :class="
                                    highlight.labelPosition === 'left'
                                        ? 'right-full mr-4'
                                        : 'left-full ml-4'
                                "
                                class="pointer-events-none absolute top-1/2 -translate-y-1/2 rounded border border-slate-200/90 bg-white/95 px-2.5 py-1.5 text-[0.58rem] leading-none whitespace-nowrap text-slate-700 shadow-md shadow-black/15 backdrop-blur transition duration-200 group-hover:border-[#1711d4]/35 group-hover:shadow-lg sm:text-[0.65rem]"
                            >
                                <span
                                    :class="
                                        highlight.labelPosition === 'left'
                                            ? 'left-full'
                                            : 'right-full'
                                    "
                                    class="absolute top-1/2 h-px w-4 -translate-y-1/2 bg-[#1711d4]/55"
                                ></span>
                                <p class="font-semibold text-slate-950">
                                    {{ highlight.label }}
                                </p>
                            </div>
                        </div>

                        <div
                            class="absolute top-4 left-4 flex size-9 flex-col items-center justify-center rounded-full border border-[#0b6680]/20 bg-white/85 text-[#0b6680] shadow-sm backdrop-blur"
                        >
                            <span class="text-[0.6rem] leading-none font-bold"
                                >N</span
                            >
                            <span
                                class="mt-0.5 block size-0 border-x-[4px] border-b-[7px] border-x-transparent border-b-[#0b6680]"
                            ></span>
                        </div>

                        <div
                            class="absolute right-3 bottom-3 flex items-center gap-2 rounded border border-[#0b6680]/15 bg-white/90 px-2.5 py-2 text-[0.6rem] font-semibold tracking-wide text-[#0b6680] uppercase shadow-sm backdrop-blur"
                        >
                            <span
                                class="size-2 rounded-full bg-[#f2b705]"
                            ></span>
                            7 campuses
                        </div>
                    </div>
                </article>
            </div>

            <div class="mt-12 flex justify-center">
                <!-- <a
                    href="#campuses"
                    class="inline-flex min-h-11 items-center gap-2 rounded-md bg-[#1C0ED7] px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#160BB2] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#1C0ED7]"
                >
                    View Campuses
                    <ArrowRight class="size-4" aria-hidden="true" />
                </a> -->
            </div>
        </div>
    </section>
</template>
