<script setup lang="ts">
import { ChevronDown, ChevronRight } from 'lucide-vue-next';
import PublicSiteLink from '@/components/public-site/PublicSiteLink.vue';
import type { PublicSiteNavigationGroup } from '@/types/public-site';

defineProps<{
    groups: PublicSiteNavigationGroup[];
}>();
</script>

<template>
    <nav class="hidden items-center gap-1 xl:flex">
        <div v-for="group in groups" :key="group.label" class="group relative">
            <PublicSiteLink
                v-if="group.href"
                :href="group.href"
                :external="group.external"
                class="inline-flex h-10 items-center rounded-md px-3 text-sm font-medium whitespace-nowrap text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-white/10 dark:hover:text-white"
                :title="group.label"
            >
                {{ group.shortLabel ?? group.label }}
            </PublicSiteLink>
            <button
                v-else
                type="button"
                class="inline-flex h-10 items-center gap-1 rounded-md px-3 text-sm font-medium whitespace-nowrap text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-white/10 dark:hover:text-white"
                :title="group.label"
            >
                {{ group.shortLabel ?? group.label }}
                <ChevronDown class="size-4" aria-hidden="true" />
            </button>
            <div
                v-if="!group.href"
                class="invisible absolute top-full left-0 translate-y-2 rounded-md border border-slate-200 bg-white p-4 opacity-0 shadow-xl shadow-slate-900/10 transition delay-0 duration-200 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100 group-focus-within:delay-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-hover:delay-150 motion-reduce:delay-0 dark:border-white/10 dark:bg-slate-900"
                :class="group.columns.length === 1 ? 'w-80' : 'w-136'"
            >
                <div
                    class="grid gap-4"
                    :class="
                        group.columns.length === 1
                            ? 'grid-cols-1'
                            : 'grid-cols-2'
                    "
                >
                    <section
                        v-for="column in group.columns"
                        :key="column.heading || column.links[0]?.label"
                        class="space-y-2"
                    >
                        <h2
                            v-if="column.heading"
                            class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            {{ column.heading }}
                        </h2>
                        <template
                            v-for="item in column.links"
                            :key="item.label"
                        >
                            <PublicSiteLink
                                v-if="item.href && !item.links"
                                :href="item.href"
                                :external="item.external"
                                class="block rounded-md px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                            >
                                {{ item.label }}
                            </PublicSiteLink>
                            <div v-else class="group/subnav relative">
                                <button
                                    type="button"
                                    class="flex w-full items-center justify-between gap-3 rounded-md px-3 py-2 text-left text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                >
                                    <span>{{ item.label }}</span>
                                    <ChevronRight
                                        class="size-4 shrink-0"
                                        aria-hidden="true"
                                    />
                                </button>
                                <div
                                    class="invisible absolute top-0 left-full z-50 w-80 rounded-md border border-slate-200 bg-white p-2 opacity-0 shadow-xl shadow-slate-900/10 transition delay-0 duration-200 group-focus-within/subnav:visible group-focus-within/subnav:opacity-100 group-focus-within/subnav:delay-150 group-hover/subnav:visible group-hover/subnav:opacity-100 group-hover/subnav:delay-150 motion-reduce:delay-0 dark:border-white/10 dark:bg-slate-900"
                                >
                                    <template
                                        v-for="child in item.links"
                                        :key="child.label"
                                    >
                                        <PublicSiteLink
                                            v-if="child.href && !child.links"
                                            :href="child.href"
                                            :external="child.external"
                                            class="block rounded-md px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                        >
                                            {{ child.label }}
                                        </PublicSiteLink>
                                        <div
                                            v-else
                                            class="group/flyout relative"
                                        >
                                            <button
                                                type="button"
                                                class="flex w-full items-center justify-between gap-3 rounded-md px-3 py-2 text-left text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                            >
                                                <span>{{ child.label }}</span>
                                                <ChevronRight
                                                    class="size-4 shrink-0"
                                                    aria-hidden="true"
                                                />
                                            </button>
                                            <div
                                                class="invisible absolute top-0 left-full z-50 max-h-[70vh] w-96 overflow-y-auto rounded-md border border-slate-200 bg-white p-2 opacity-0 shadow-xl shadow-slate-900/10 transition delay-0 duration-200 group-focus-within/flyout:visible group-focus-within/flyout:opacity-100 group-focus-within/flyout:delay-150 group-hover/flyout:visible group-hover/flyout:opacity-100 group-hover/flyout:delay-150 motion-reduce:delay-0 dark:border-white/10 dark:bg-slate-900"
                                            >
                                                <PublicSiteLink
                                                    v-for="grandchild in child.links"
                                                    :key="grandchild.label"
                                                    :href="grandchild.href"
                                                    :external="
                                                        grandchild.external
                                                    "
                                                    class="block rounded-md px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"
                                                >
                                                    {{ grandchild.label }}
                                                </PublicSiteLink>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </section>
                </div>
            </div>
        </div>
    </nav>
</template>
