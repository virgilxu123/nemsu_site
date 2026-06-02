<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, Plus, RotateCcw, Search, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';
import AdminContentPageController from '@/actions/App/Http/Controllers/Admin/ContentPageController';
import Heading from '@/components/Heading.vue';
import SortableTableHeader from '@/components/SortableTableHeader.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useTableQuery } from '@/composables/useTableQuery';
import { create, edit, index } from '@/routes/admin/content-pages';
import type { SortDirection, TableQueryFilters } from '@/types';

type ContentPageItem = {
    id: string;
    title: string;
    slug: string;
    section: string | null;
    excerpt: string | null;
    status: string;
    isPublished: boolean;
    publishedAt: string | null;
    sortOrder: number;
    updatedAt: string | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedPages = {
    data: ContentPageItem[];
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
};

type ContentPageFilters = TableQueryFilters & {
    search: string;
    status: 'all' | 'published' | 'draft';
    section: string;
    sort_by?: string;
    sort_direction?: SortDirection;
};

const props = defineProps<{
    filters: ContentPageFilters;
    sections: string[];
    pages: PaginatedPages;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Content Pages', href: index() }],
    },
});

const { filters, handleFilter, handlePageLink, handleSort, resetFilter } =
    useTableQuery<ContentPageFilters>({
        url: index.url(),
        initialFilters: props.filters,
        only: ['filters', 'pages'],
        debounce: 250,
    });

const clearFilters = (): void => {
    resetFilter({
        status: 'all',
        section: '',
    });
};

const hasActiveFilters = computed(
    () =>
        filters.search !== '' ||
        filters.status !== 'all' ||
        filters.section !== '' ||
        filters.sort_by !== undefined ||
        filters.sort_direction !== undefined,
);

const deletePage = (item: ContentPageItem): void => {
    if (!window.confirm(`Delete "${item.title}"?`)) {
        return;
    }

    router.delete(AdminContentPageController.destroy.url(item.id), {
        preserveScroll: true,
    });
};

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');
</script>

<template>
    <Head title="Content pages" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <Heading
                title="Content Pages"
                description="Manage static and semi-static CMS pages."
            />

            <Button as-child>
                <Link :href="create()">
                    <Plus class="size-4" />
                    New page
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
                    placeholder="Search title, slug, section, or excerpt"
                />
            </div>

            <select
                v-model="filters.status"
                @change="handleFilter({ status: filters.status })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All statuses</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>

            <select
                v-model="filters.section"
                @change="handleFilter({ section: filters.section })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="">All sections</option>
                <option
                    v-for="section in sections"
                    :key="section"
                    :value="section"
                >
                    {{ section }}
                </option>
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
                            column="title"
                            label="Page"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="section"
                            label="Section"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="status"
                            label="Status"
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
                            column="published_at"
                            label="Published"
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
                        v-for="item in pages.data"
                        :key="item.id"
                        class="border-t border-sidebar-border/70"
                    >
                        <td class="max-w-xl px-4 py-4">
                            <div class="font-medium">{{ item.title }}</div>
                            <div class="mt-1 truncate text-muted-foreground">
                                {{ item.excerpt || item.slug }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            {{ item.section ?? 'Not set' }}
                        </td>
                        <td class="px-4 py-4">
                            <Badge
                                :variant="
                                    item.isPublished ? 'default' : 'secondary'
                                "
                            >
                                {{ item.isPublished ? 'Published' : 'Draft' }}
                            </Badge>
                        </td>
                        <td class="px-4 py-4">{{ item.sortOrder }}</td>
                        <td class="px-4 py-4">
                            {{ item.publishedAt ?? 'Not published' }}
                        </td>
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
                                    @click="deletePage(item)"
                                >
                                    <Trash2 class="size-4" />
                                    <span class="sr-only">Delete</span>
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="pages.data.length === 0">
                        <td
                            colspan="7"
                            class="px-4 py-10 text-center text-muted-foreground"
                        >
                            No content pages found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-muted-foreground">
                Showing {{ pages.from ?? 0 }} to {{ pages.to ?? 0 }} of
                {{ pages.total }} pages
            </p>

            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in pages.links"
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
