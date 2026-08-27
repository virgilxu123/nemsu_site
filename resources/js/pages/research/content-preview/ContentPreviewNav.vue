<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, BookOpenCheck } from 'lucide-vue-next';
import { rie } from '@/routes/research';
import { content_preview as rieContentPreview } from '@/routes/research/rie';
import { content_preview as centersContentPreview } from '@/routes/research/rie/centers';
import { content_preview as publicationsContentPreview } from '@/routes/research/rie/publications';

defineProps<{
    active: 'centers' | 'overview' | 'publications';
}>();

const links = [
    {
        id: 'overview',
        label: 'RIE Overview',
        href: rieContentPreview().url,
    },
    {
        id: 'centers',
        label: 'Research Centers',
        href: centersContentPreview().url,
    },
    {
        id: 'publications',
        label: 'Publications',
        href: publicationsContentPreview().url,
    },
] as const;
</script>

<template>
    <section
        class="border-b border-amber-200 bg-amber-50 text-slate-900 dark:border-amber-300/20 dark:bg-amber-300/10 dark:text-white"
    >
        <div
            class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8"
        >
            <div class="flex items-start gap-3">
                <BookOpenCheck
                    class="mt-0.5 size-5 shrink-0 text-amber-700 dark:text-amber-300"
                    aria-hidden="true"
                />
                <div>
                    <p class="text-sm font-semibold">Content preview</p>
                    <p
                        class="mt-0.5 text-xs leading-5 text-slate-600 dark:text-slate-300"
                    >
                        Source-aligned alternative. The current live pages
                        remain unchanged.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <Link
                    v-for="link in links"
                    :key="link.id"
                    :href="link.href"
                    class="rounded-full border px-3 py-1.5 text-xs font-semibold transition"
                    :class="
                        active === link.id
                            ? 'border-[#1711d4] bg-[#1711d4] text-white'
                            : 'border-slate-300 bg-white text-slate-700 hover:border-[#1711d4]/40 hover:text-[#1711d4] dark:border-white/15 dark:bg-slate-900 dark:text-slate-200 dark:hover:text-sky-300'
                    "
                >
                    {{ link.label }}
                </Link>
                <Link
                    :href="rie().url"
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold text-[#1711d4] hover:bg-white dark:text-sky-300 dark:hover:bg-white/10"
                >
                    <ArrowLeft class="size-3.5" aria-hidden="true" />
                    Current version
                </Link>
            </div>
        </div>
    </section>
</template>
