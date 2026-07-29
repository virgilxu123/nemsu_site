<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { index as announcementsIndex } from '@/routes/announcements';
import { show as newsShow } from '@/routes/news';
import type { PublicNewsTickerItem } from '@/types/public-site';

const props = defineProps<{
    items: PublicNewsTickerItem[];
}>();

const tickerIndex = ref(0);
let tickerInterval: ReturnType<typeof window.setInterval> | null = null;

const currentTickerItem = computed(
    () => props.items[tickerIndex.value] ?? null,
);

const currentTickerHref = computed(() =>
    currentTickerItem.value
        ? newsShow(currentTickerItem.value.slug).url
        : announcementsIndex().url,
);

const stopTicker = (): void => {
    if (tickerInterval === null) {
        return;
    }

    window.clearInterval(tickerInterval);
    tickerInterval = null;
};

const startTicker = (): void => {
    stopTicker();

    if (props.items.length <= 1) {
        return;
    }

    tickerInterval = window.setInterval(() => {
        tickerIndex.value = (tickerIndex.value + 1) % props.items.length;
    }, 5000);
};

onMounted(() => {
    startTicker();
});

onBeforeUnmount(() => {
    stopTicker();
});

watch(
    () => props.items,
    (items) => {
        if (tickerIndex.value >= items.length) {
            tickerIndex.value = 0;
        }

        startTicker();
    },
);
</script>

<template>
    <div class="hidden min-w-0 flex-1 items-center sm:flex">
        <Transition
            mode="out-in"
            enter-active-class="motion-safe:transition motion-safe:duration-300 motion-safe:ease-out motion-reduce:transition-none"
            enter-from-class="opacity-0 motion-safe:-translate-y-1"
            enter-to-class="opacity-100 motion-safe:translate-y-0"
            leave-active-class="motion-safe:transition motion-safe:duration-200 motion-safe:ease-in motion-reduce:transition-none"
            leave-from-class="opacity-100 motion-safe:translate-y-0"
            leave-to-class="opacity-0 motion-safe:translate-y-1"
        >
            <Link
                v-if="currentTickerItem"
                :key="currentTickerItem.id"
                :href="currentTickerHref"
                class="group flex max-w-full min-w-0 items-center gap-2 rounded px-2 py-1 text-white/85 transition hover:bg-white/10 hover:text-white"
            >
                <span
                    class="shrink-0 rounded bg-white/15 px-2 py-0.5 text-[10px] font-semibold tracking-wide text-white uppercase"
                >
                    Latest
                </span>
                <span class="truncate font-medium text-[#ffbd02]">
                    {{ currentTickerItem.title }}
                </span>
            </Link>
            <Link
                v-else
                key="empty-ticker"
                :href="announcementsIndex()"
                class="flex max-w-full min-w-0 items-center gap-2 rounded px-2 py-1 text-white/85 transition hover:bg-white/10 hover:text-white"
            >
                <span
                    class="shrink-0 rounded bg-white/15 px-2 py-0.5 text-[10px] font-semibold tracking-wide text-white uppercase"
                >
                    Latest
                </span>
                <span class="truncate font-medium text-white">
                    Latest updates will appear here soon.
                </span>
            </Link>
        </Transition>
    </div>
</template>
