<script setup lang="ts">
import PublicSiteLink from '@/components/public-site/PublicSiteLink.vue';
import type { PublicSiteNavigationGroup } from '@/types/public-site';

defineProps<{
    groups: PublicSiteNavigationGroup[];
}>();

const emit = defineEmits<{
    navigate: [];
}>();
</script>

<template>
    <div
        class="border-t border-slate-200 bg-white px-4 py-4 xl:hidden dark:border-white/10 dark:bg-slate-950"
    >
        <nav class="mx-auto grid max-w-7xl gap-3">
            <template v-for="group in groups" :key="group.label">
                <PublicSiteLink
                    v-if="group.href"
                    :href="group.href"
                    :external="group.external"
                    class="rounded-md border border-slate-200 p-3 text-sm font-semibold text-slate-900 dark:border-white/10 dark:text-white"
                    @click="emit('navigate')"
                >
                    {{ group.label }}
                </PublicSiteLink>
                <details
                    v-else
                    class="rounded-md border border-slate-200 p-3 dark:border-white/10"
                >
                    <summary
                        class="cursor-pointer text-sm font-semibold text-slate-900 dark:text-white"
                    >
                        {{ group.label }}
                    </summary>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                        <div
                            v-for="column in group.columns"
                            :key="column.heading || column.links[0]?.label"
                        >
                            <p
                                v-if="column.heading"
                                class="text-xs font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                            >
                                {{ column.heading }}
                            </p>
                            <template
                                v-for="item in column.links"
                                :key="item.label"
                            >
                                <PublicSiteLink
                                    v-if="item.href && !item.links"
                                    :href="item.href"
                                    :external="item.external"
                                    class="block rounded-md py-2 text-sm text-slate-600 dark:text-slate-300"
                                    @click="emit('navigate')"
                                >
                                    {{ item.label }}
                                </PublicSiteLink>
                                <details v-else class="rounded-md py-1">
                                    <summary
                                        class="cursor-pointer py-2 text-sm font-semibold text-slate-800 dark:text-slate-100"
                                    >
                                        {{ item.label }}
                                    </summary>
                                    <div class="ml-4 grid gap-1">
                                        <template
                                            v-for="child in item.links"
                                            :key="child.label"
                                        >
                                            <PublicSiteLink
                                                v-if="
                                                    child.href && !child.links
                                                "
                                                :href="child.href"
                                                :external="child.external"
                                                class="block rounded-md py-2 text-sm text-slate-600 dark:text-slate-300"
                                                @click="emit('navigate')"
                                            >
                                                {{ child.label }}
                                            </PublicSiteLink>
                                            <details
                                                v-else
                                                class="rounded-md py-1"
                                            >
                                                <summary
                                                    class="cursor-pointer py-2 text-sm font-semibold text-slate-700 dark:text-slate-200"
                                                >
                                                    {{ child.label }}
                                                </summary>
                                                <div class="ml-4 grid gap-1">
                                                    <PublicSiteLink
                                                        v-for="grandchild in child.links"
                                                        :key="grandchild.label"
                                                        :href="grandchild.href"
                                                        :external="
                                                            grandchild.external
                                                        "
                                                        class="block rounded-md py-2 text-sm text-slate-600 dark:text-slate-300"
                                                        @click="
                                                            emit('navigate')
                                                        "
                                                    >
                                                        {{ grandchild.label }}
                                                    </PublicSiteLink>
                                                </div>
                                            </details>
                                        </template>
                                    </div>
                                </details>
                            </template>
                        </div>
                    </div>
                </details>
            </template>
        </nav>
    </div>
</template>
