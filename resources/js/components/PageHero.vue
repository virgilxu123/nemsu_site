<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    title: string;
    breadcrumbs: { title: string; href?: string }[];
    kicker?: string;
    description?: string;
}>();
</script>

<template>
    <section
        class="relative isolate z-10 flex min-h-80 items-center overflow-visible bg-slate-950 py-14 text-white sm:min-h-88 sm:py-16 lg:min-h-96"
    >
        <img
            src="/storage/images/hero/6I3A7029(1).jpg"
            alt=""
            class="pointer-events-none absolute inset-0 z-0 h-full w-full object-cover object-center opacity-60 select-none"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute inset-0 z-0 bg-[#1711d4]/70 mix-blend-multiply"
            aria-hidden="true"
        ></div>
        <div
            class="pointer-events-none absolute inset-0 z-0 overflow-hidden"
            aria-hidden="true"
        >
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.2),transparent_38%),radial-gradient(circle_at_72%_28%,rgba(242,183,5,0.22),transparent_28%),linear-gradient(135deg,rgba(255,255,255,0.08),transparent_34%)]"
            ></div>
            <div
                class="absolute inset-0 [background-image:linear-gradient(90deg,rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(180deg,rgba(255,255,255,0.08)_1px,transparent_1px)] [background-size:3.5rem_3.5rem] opacity-35"
            ></div>
            <div
                class="absolute top-10 left-8 h-44 w-44 rounded-full border border-white/10 sm:h-64 sm:w-64"
            ></div>
        </div>

        <div
            class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <div class="flex w-full max-w-4xl flex-col items-start">
                <nav aria-label="Breadcrumb" class="ps-1 text-sm font-semibold">
                    <ol class="flex flex-wrap items-center gap-2">
                        <template
                            v-for="(item, index) in breadcrumbs"
                            :key="index"
                        >
                            <li>
                                <template
                                    v-if="index === breadcrumbs.length - 1"
                                >
                                    <span
                                        class="text-[#f2b705]"
                                        aria-current="page"
                                    >
                                        {{ item.title }}
                                    </span>
                                </template>
                                <template v-else>
                                    <Link
                                        v-if="item.href"
                                        :href="item.href"
                                        class="text-white/80 transition hover:text-[#f2b705]"
                                    >
                                        {{ item.title }}
                                    </Link>
                                    <span v-else class="text-white/80">
                                        {{ item.title }}
                                    </span>
                                </template>
                            </li>
                            <li
                                v-if="index !== breadcrumbs.length - 1"
                                class="text-white/45"
                                aria-hidden="true"
                            >
                                /
                            </li>
                        </template>
                    </ol>
                </nav>

                <p
                    v-if="kicker"
                    class="mt-6 text-sm font-bold tracking-widest text-white/80 uppercase"
                >
                    {{ kicker }}
                </p>

                <h1
                    :class="[
                        kicker ? 'mt-3' : 'mt-6',
                        'w-full text-4xl leading-tight font-semibold tracking-normal text-balance sm:text-5xl lg:text-6xl',
                    ]"
                >
                    {{ title }}
                </h1>

                <p
                    v-if="description"
                    class="mt-6 w-full max-w-3xl text-lg leading-relaxed text-pretty text-white/90"
                >
                    {{ description }}
                </p>

                <slot />
            </div>
        </div>
    </section>
</template>
