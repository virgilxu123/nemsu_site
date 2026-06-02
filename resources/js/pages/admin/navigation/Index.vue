<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, Plus, RotateCcw, Search, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';
import AdminNavigationItemController from '@/actions/App/Http/Controllers/Admin/NavigationItemController';
import Heading from '@/components/Heading.vue';
import SortableTableHeader from '@/components/SortableTableHeader.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useTableQuery } from '@/composables/useTableQuery';
import { create, edit, index } from '@/routes/admin/navigation';
import type { SortDirection, TableQueryFilters } from '@/types';

type NavigationItem = {
    id: string;
    label: string;
    location: string;
    parent: string | null;
    url: string;
    destination: string;
    isActive: boolean;
    sortOrder: number;
    updatedAt: string | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedNavigationItems = {
    data: NavigationItem[];
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
};

type NavigationFilters = TableQueryFilters & {
    search: string;
    location: 'main' | 'footer';
    active: 'all' | 'active' | 'inactive';
    sort_by?: string;
    sort_direction?: SortDirection;
};

const props = defineProps<{
    filters: NavigationFilters;
    items: PaginatedNavigationItems;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Navigation', href: index() }],
    },
});

const { filters, handleFilter, handlePageLink, handleSort, resetFilter } =
    useTableQuery<NavigationFilters>({
        url: index.url(),
        initialFilters: props.filters,
        only: ['filters', 'items'],
        debounce: 250,
    });

const clearFilters = (): void => {
    resetFilter({
        location: 'main',
        active: 'all',
    });
};

const hasActiveFilters = computed(
    () =>
        filters.search !== '' ||
        filters.location !== 'main' ||
        filters.active !== 'all' ||
        filters.sort_by !== undefined ||
        filters.sort_direction !== undefined,
);

const deleteItem = (item: NavigationItem): void => {
    if (!window.confirm(`Delete "${item.label}"?`)) {
        return;
    }

    router.delete(AdminNavigationItemController.destroy.url(item.id), {
        preserveScroll: true,
    });
};

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');
</script>

<template>
    <Head title="Navigation" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <Heading
                title="Navigation"
                description="Manage public main and footer menu items."
            />

            <Button as-child>
                <Link :href="create()">
                    <Plus class="size-4" />
                    New item
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
                    placeholder="Search label, URL, or route"
                />
            </div>

            <select
                v-model="filters.location"
                @change="handleFilter({ location: filters.location })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="main">Main</option>
                <option value="footer">Footer</option>
            </select>

            <select
                v-model="filters.active"
                @change="handleFilter({ active: filters.active })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All states</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
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
            <table class="w-full min-w-[56rem] text-sm">
                <thead class="bg-muted/50 text-left">
                    <tr>
                        <SortableTableHeader
                            column="label"
                            label="Item"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="location"
                            label="Location"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <th class="px-4 py-3 font-medium">Destination</th>
                        <SortableTableHeader
                            column="is_active"
                            label="State"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="sort_order"
                            label="Order"
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
                        v-for="item in items.data"
                        :key="item.id"
                        class="border-t border-sidebar-border/70"
                    >
                        <td class="max-w-lg px-4 py-4">
                            <div class="font-medium">{{ item.label }}</div>
                            <div class="mt-1 truncate text-muted-foreground">
                                Parent: {{ item.parent ?? 'None' }}
                            </div>
                        </td>
                        <td class="px-4 py-4 capitalize">
                            {{ item.location }}
                        </td>
                        <td class="px-4 py-4">
                            <div>{{ item.destination }}</div>
                            <div
                                class="mt-1 max-w-xs truncate text-muted-foreground"
                            >
                                {{ item.url }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <Badge
                                :variant="
                                    item.isActive ? 'default' : 'secondary'
                                "
                            >
                                {{ item.isActive ? 'Active' : 'Inactive' }}
                            </Badge>
                        </td>
                        <td class="px-4 py-4">{{ item.sortOrder }}</td>
                        <td class="px-4 py-4">
                            {{ item.updatedAt ?? 'Not updated' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <Button size="icon" variant="ghost" as-child>
                                    <Link :href="edit(item.id)" title="Edit">
                                        <Edit class="size-4" />
                                        <span class="sr-only">Edit</span>
                                    </Link>
                                </Button>
                                <Button
                                    size="icon"
                                    variant="ghost"
                                    type="button"
                                    title="Delete"
                                    @click="deleteItem(item)"
                                >
                                    <Trash2 class="size-4" />
                                    <span class="sr-only">Delete</span>
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="items.data.length === 0">
                        <td
                            colspan="7"
                            class="px-4 py-10 text-center text-muted-foreground"
                        >
                            No navigation items found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-muted-foreground">
                Showing {{ items.from ?? 0 }} to {{ items.to ?? 0 }} of
                {{ items.total }} items
            </p>

            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in items.links"
                    :key="`${link.label}-${link.url}`"
                    :variant="link.active ? 'default' : 'outline'"
                    size="sm"
                    :disabled="link.url === null"
                    type="button"
                    @click="link.url && handlePageLink(link.url)"
                >
                    {{ paginationLabel(link.label) }}
                </Button>
            </div>
        </div>
    </div>
</template>
