<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, Plus, RotateCcw, Search, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';
import AdminJobOpportunityController from '@/actions/App/Http/Controllers/Admin/JobOpportunityController';
import Heading from '@/components/Heading.vue';
import SortableTableHeader from '@/components/SortableTableHeader.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useTableQuery } from '@/composables/useTableQuery';
import { create, edit, index } from '@/routes/admin/job-opportunities';
import type { SortDirection, TableQueryFilters } from '@/types';
import type { JobOpportunityItem } from './types';

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedOpportunities = {
    data: JobOpportunityItem[];
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
};

type JobOpportunityFilters = TableQueryFilters & {
    search: string;
    hiring_status: 'all' | 'hiring' | 'closed';
    publication_status: 'all' | 'published' | 'draft';
    sort_by?: string;
    sort_direction?: SortDirection;
};

const props = defineProps<{
    filters: JobOpportunityFilters;
    opportunities: PaginatedOpportunities;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Job Opportunities', href: index() }],
    },
});

const { filters, handleFilter, handlePageLink, handleSort, resetFilter } =
    useTableQuery<JobOpportunityFilters>({
        url: index.url(),
        initialFilters: props.filters,
        only: ['filters', 'opportunities'],
        debounce: 250,
    });

const hasActiveFilters = computed(
    () =>
        filters.search !== '' ||
        filters.hiring_status !== 'all' ||
        filters.publication_status !== 'all' ||
        filters.sort_by !== undefined ||
        filters.sort_direction !== undefined,
);

const clearFilters = (): void => {
    resetFilter({
        hiring_status: 'all',
        publication_status: 'all',
    });
};

const deleteOpportunity = (opportunity: JobOpportunityItem): void => {
    if (!window.confirm(`Delete "${opportunity.name}"?`)) {
        return;
    }

    router.delete(AdminJobOpportunityController.destroy.url(opportunity.id), {
        preserveScroll: true,
    });
};

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');
</script>

<template>
    <Head title="Job Opportunities" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <Heading
                title="Job Opportunities"
                description="Manage position announcements and hiring availability."
            />

            <Button as-child>
                <Link :href="create()">
                    <Plus class="size-4" />
                    New job opportunity
                </Link>
            </Button>
        </div>

        <div class="flex flex-col gap-3 lg:flex-row lg:items-center">
            <div class="relative w-full lg:max-w-sm">
                <Search
                    class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                />
                <Input
                    v-model="filters.search"
                    class="pl-9"
                    placeholder="Search name, slug, or content"
                />
            </div>

            <select
                v-model="filters.hiring_status"
                @change="handleFilter({ hiring_status: filters.hiring_status })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All hiring statuses</option>
                <option value="hiring">Currently hiring</option>
                <option value="closed">Not hiring</option>
            </select>

            <select
                v-model="filters.publication_status"
                @change="
                    handleFilter({
                        publication_status: filters.publication_status,
                    })
                "
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All publication statuses</option>
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
            <table class="w-full min-w-[64rem] text-sm">
                <thead class="bg-muted/50 text-left">
                    <tr>
                        <SortableTableHeader
                            column="name"
                            label="Name"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <th class="px-4 py-3 text-left font-medium">Slug</th>
                        <SortableTableHeader
                            column="date"
                            label="Date"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="is_hiring"
                            label="Hiring"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            column="is_published"
                            label="Publication"
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
                        v-for="opportunity in opportunities.data"
                        :key="opportunity.id"
                        class="border-t border-sidebar-border/70"
                    >
                        <td class="max-w-md px-4 py-4 font-medium">
                            {{ opportunity.name }}
                        </td>
                        <td class="px-4 py-4">{{ opportunity.slug }}</td>
                        <td class="px-4 py-4">{{ opportunity.date }}</td>
                        <td class="px-4 py-4">
                            <Badge
                                :variant="
                                    opportunity.isHiring
                                        ? 'default'
                                        : 'secondary'
                                "
                            >
                                {{
                                    opportunity.isHiring
                                        ? 'Hiring'
                                        : 'Not hiring'
                                }}
                            </Badge>
                        </td>
                        <td class="px-4 py-4">
                            <Badge
                                :variant="
                                    opportunity.isPublished
                                        ? 'default'
                                        : 'secondary'
                                "
                            >
                                {{
                                    opportunity.isPublished
                                        ? 'Published'
                                        : 'Draft'
                                }}
                            </Badge>
                        </td>
                        <td class="px-4 py-4">
                            {{ opportunity.updatedAt ?? 'Not updated' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <Button size="icon" variant="ghost" as-child>
                                    <Link
                                        :href="edit(opportunity.id)"
                                        title="Edit"
                                    >
                                        <Edit class="size-4" />
                                        <span class="sr-only">Edit</span>
                                    </Link>
                                </Button>
                                <Button
                                    size="icon"
                                    variant="ghost"
                                    type="button"
                                    title="Delete"
                                    @click="deleteOpportunity(opportunity)"
                                >
                                    <Trash2 class="size-4" />
                                    <span class="sr-only">Delete</span>
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="opportunities.data.length === 0">
                        <td
                            colspan="7"
                            class="px-4 py-10 text-center text-muted-foreground"
                        >
                            No job opportunities found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            v-if="opportunities.total > 0"
            class="flex flex-wrap items-center justify-between gap-3 text-sm text-muted-foreground"
        >
            <div>
                Showing {{ opportunities.from }} to {{ opportunities.to }} of
                {{ opportunities.total }} job opportunities
            </div>
            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in opportunities.links"
                    :key="link.label"
                    type="button"
                    :variant="link.active ? 'default' : 'outline'"
                    size="sm"
                    :disabled="link.url === null"
                    @click="link.url && handlePageLink(link.url)"
                >
                    {{ paginationLabel(link.label) }}
                </Button>
            </div>
        </div>
    </div>
</template>
