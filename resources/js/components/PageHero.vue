<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    title: string;
    breadcrumbs: { title: string; href?: string }[];
    backgroundImage?: string;
    kicker?: string;
    description?: string;
}>();
</script>

<template>
    <section class="relative isolate z-10 overflow-visible bg-slate-950 py-16 text-white sm:py-20">
        <img
            :src="backgroundImage ?? '/storage/images/hero/6I3A5797.JPG'"
            alt=""
            class="pointer-events-none absolute inset-0 z-0 h-full w-full object-cover object-center opacity-60 select-none"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute inset-0 z-0 bg-[#1C0ED7]/80 mix-blend-multiply"
            aria-hidden="true"
        ></div>
        <div
            class="pointer-events-none absolute inset-0 z-0"
            style="background: linear-gradient(90deg, rgba(10, 17, 90, 0.94) 0%, rgba(28, 14, 215, 0.78) 42%, rgba(20, 24, 90, 0.46) 72%, rgba(10, 15, 60, 0.28) 100%), linear-gradient(180deg, rgba(5, 10, 50, 0.28) 0%, rgba(5, 10, 50, 0.05) 45%, rgba(5, 10, 50, 0.30) 100%);"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="text-sm font-semibold">
                <ol class="flex flex-wrap items-center gap-2">
                    <template v-for="(item, index) in breadcrumbs" :key="index">
                        <li>
                            <template v-if="index === breadcrumbs.length - 1">
                                <span class="text-[#f2b705]" aria-current="page">
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
                        <li v-if="index !== breadcrumbs.length - 1" class="text-white/45" aria-hidden="true">/</li>
                    </template>
                </ol>
            </nav>

            <p v-if="kicker" class="mt-6 text-sm font-bold tracking-widest text-white/80 uppercase">
                {{ kicker }}
            </p>

            <h1 :class="[kicker ? 'mt-3' : 'mt-6', 'max-w-4xl text-4xl font-semibold tracking-normal sm:text-5xl lg:text-6xl']">
                {{ title }}
            </h1>

            <p v-if="description" class="mt-6 max-w-3xl text-lg leading-relaxed text-white/90">
                {{ description }}
            </p>
            
            <slot />
        </div>
    </section>
</template>
