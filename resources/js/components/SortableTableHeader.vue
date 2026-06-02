<script setup lang="ts">
import { ChevronDown, ChevronUp, ChevronsUpDown } from 'lucide-vue-next';
import { computed } from 'vue';
import { TableHead } from '@/components/ui/table';
import type { SortDirection } from '@/types';

interface Props {
    column: string;
    label: string;
    sortBy?: string;
    sortDirection?: SortDirection;
}

const props = defineProps<Props>();

const emit = defineEmits<{
    (e: 'sort', column: string, direction: SortDirection): void;
}>();

const isSorted = computed(
    () => props.sortBy === props.column && !!props.sortDirection,
);

const handleSort = (): void => {
    let newDirection: SortDirection;

    if (!isSorted.value) {
        newDirection = 'asc';
    } else if (props.sortDirection === 'asc') {
        newDirection = 'desc';
    } else {
        newDirection = undefined;
    }

    emit('sort', props.column, newDirection);
};
</script>

<template>
    <TableHead
        class="group cursor-pointer border-b transition-colors select-none hover:bg-muted/50"
        @click="handleSort"
    >
        <div class="flex items-center justify-between gap-4">
            <span>{{ label }}</span>
            <span
                class="text-muted-foreground/50 transition-colors group-hover:text-muted-foreground"
            >
                <template v-if="!isSorted || !sortDirection">
                    <ChevronsUpDown class="h-4 w-4" />
                </template>
                <template v-else>
                    <ChevronUp
                        v-if="sortDirection === 'asc'"
                        class="h-4 w-4 text-primary"
                    />
                    <ChevronDown
                        v-else-if="sortDirection === 'desc'"
                        class="h-4 w-4 text-primary"
                    />
                </template>
            </span>
        </div>
    </TableHead>
</template>
