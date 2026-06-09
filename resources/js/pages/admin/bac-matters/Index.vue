<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, ExternalLink, FileText, Plus, RotateCcw, Search, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';
import AdminBacMatterController from '@/actions/App/Http/Controllers/Admin/BacMatterController';
import Heading from '@/components/Heading.vue';
import SortableTableHeader from '@/components/SortableTableHeader.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useTableQuery } from '@/composables/useTableQuery';
import { create, edit, index } from '@/routes/admin/bac-matters';
import type { SortDirection, TableQueryFilters } from '@/types';
import type { BacMatterItem } from './types';

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedBacMatters = {
    data: BacMatterItem[];
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
};

type BacMatterFilters = TableQueryFilters & {
    search: string;
    type: string;
    status: 'all' | 'published' | 'draft';
    sort_by?: string;
    sort_direction?: SortDirection;
};

const props = defineProps<{
    filters: BacMatterFilters;
    types: string[];
    matters: PaginatedBacMatters;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'BAC Matters', href: index() }],
    },
});

const { filters, handleFilter, handlePageLink, handleSort, resetFilter } =
    useTableQuery<BacMatterFilters>({
        url: index.url(),
        initialFilters: props.filters,
        only: ['filters', 'matters'],
        debounce: 250,
    });

const hasActiveFilters = computed(
    () =>
        filters.search !== '' ||
        filters.type !== 'all' ||
        filters.status !== 'all' ||
        filters.sort_by !== undefined ||
        filters.sort_direction !== undefined,
);

const clearFilters = (): void => {
    resetFilter({
        type: 'all',
        status: 'all',
    });
};

const deleteMatter = (matter: BacMatterItem): void => {
    if (!window.confirm(`Delete "${matter.name}"?`)) {
        return;
    }

    router.delete(AdminBacMatterController.destroy.url(matter.id), {
        preserveScroll: true,
    });
};

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');
</script>

<template>
    <Head title="BAC Matters" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <Heading
                title="BAC Matters"
                description="Manage procurement notices, bid documents, and related BAC resources."
            />

            <Button as-child>
                <Link :href="create()">
                    <Plus class="size-4" />
                    New BAC matter
                </Link>
            </Button>
        </div>

        <div class="flex flex-col gap-3 md:flex-row md:items-center">
            <div class="relative w-full md:max-w-sm">
                <Search
                    class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                />
                <Input
                    v-model="filters.search"
                    class="pl-9"
                    placeholder="Search name, file, link, or type"
                />
            </div>

            <select
                v-model="filters.type"
                @change="handleFilter({ type: filters.type })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All types</option>
                <option v-for="type in types" :key="type" :value="type">
                    {{ type }}
                </option>
            </select>

            <select
                v-model="filters.status"
                @change="handleFilter({ status: filters.status })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All statuses</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>

            <Button
                v-if="hasActiveFilters"
                type="button"
                variant="outline"
                @click="clearFilters"
            >
                <RotateCcw class="size-4" />
                Clear filters
            </Button>
        </div>

        <div
            class="overflow-hidden rounded-md border border-sidebar-border/70 dark:border-sidebar-border"
        >
            <table class="w-full min-w-[58rem] text-sm">
                <thead class="bg-muted/50 text-left">
                    <tr>
                        <SortableTableHeader
                            column="name"
                            label="Name"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="type"
                            label="Type"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <th class="px-4 py-3 text-left font-medium">
                            Destination
                        </th>
                        <SortableTableHeader
                            column="date"
                            label="Date"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="is_published"
                            label="Status"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="updated_at"
                            label="Updated"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <th class="px-4 py-3 text-right font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="matter in matters.data"
                        :key="matter.id"
                        class="border-t border-sidebar-border/70"
                    >
                        <td class="max-w-lg px-4 py-4">
                            <div class="font-medium">
                                {{ matter.name }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            {{ matter.type ?? 'Not set' }}
                        </td>
                        <td class="px-4 py-4">
                            <a
                                v-if="matter.destinationUrl"
                                :href="matter.destinationUrl"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center gap-2 font-medium underline underline-offset-4"
                            >
                                <FileText
                                    v-if="matter.destinationLabel === 'File'"
                                    class="size-4"
                                />
                                <ExternalLink v-else class="size-4" />
                                {{ matter.destinationLabel }}
                            </a>
                            <span v-else class="text-muted-foreground">
                                None
                            </span>
                        </td>
                        <td class="px-4 py-4">{{ matter.date ?? 'Not set' }}</td>
                        <td class="px-4 py-4">
                            <Badge
                                :variant="
                                    matter.isPublished ? 'default' : 'secondary'
                                "
                            >
                                {{ matter.isPublished ? 'Published' : 'Draft' }}
                            </Badge>
                        </td>
                        <td class="px-4 py-4">
                            {{ matter.updatedAt ?? 'Not updated' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <Button size="icon" variant="ghost" as-child>
                                    <Link :href="edit(matter.id)" title="Edit">
                                        <Edit class="size-4" />
                                        <span class="sr-only">Edit</span>
                                    </Link>
                                </Button>
                                <Button
                                    size="icon"
                                    variant="ghost"
                                    type="button"
                                    title="Delete"
                                    @click="deleteMatter(matter)"
                                >
                                    <Trash2 class="size-4" />
                                    <span class="sr-only">Delete</span>
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="matters.data.length === 0">
                        <td
                            colspan="7"
                            class="px-4 py-10 text-center text-muted-foreground"
                        >
                            No BAC matters found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            v-if="matters.total > 0"
            class="flex flex-wrap items-center justify-between gap-3 text-sm text-muted-foreground"
        >
            <div>
                Showing {{ matters.from }} to {{ matters.to }} of
                {{ matters.total }} BAC matters
            </div>
            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in matters.links"
                    :key="link.label"
                    type="button"
                    :variant="link.active ? 'default' : 'outline'"
                    size="sm"
                    :disabled="link.url === null"
                    @click="handlePageLink(link.url)"
                >
                    {{ paginationLabel(link.label) }}
                </Button>
            </div>
        </div>
    </div>
</template>
