<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Edit,
    FileText,
    Plus,
    RotateCcw,
    Search,
    Trash2,
} from 'lucide-vue-next';
import { computed } from 'vue';
import AdminProgramController from '@/actions/App/Http/Controllers/Admin/ProgramController';
import Heading from '@/components/Heading.vue';
import SortableTableHeader from '@/components/SortableTableHeader.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useTableQuery } from '@/composables/useTableQuery';
import { create, edit, index } from '@/routes/admin/programs';
import type { SortDirection, TableQueryFilters } from '@/types';
import type { ProgramItem, SelectOption } from './types';

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedPrograms = {
    data: ProgramItem[];
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
};

type ProgramFilters = TableQueryFilters & {
    search: string;
    campus_id: string;
    college_id: string;
    degree_program: string;
    archive_status: 'all' | 'active' | 'archived';
    sort_by?: string;
    sort_direction?: SortDirection;
};

const props = defineProps<{
    filters: ProgramFilters;
    degreePrograms: string[];
    campuses: SelectOption[];
    colleges: SelectOption[];
    programs: PaginatedPrograms;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Programs', href: index() }],
    },
});

const { filters, handleFilter, handlePageLink, handleSort, resetFilter } =
    useTableQuery<ProgramFilters>({
        url: index.url(),
        initialFilters: props.filters,
        only: ['filters', 'programs'],
        debounce: 250,
    });

const hasActiveFilters = computed(
    () =>
        filters.search !== '' ||
        filters.campus_id !== 'all' ||
        filters.college_id !== 'all' ||
        filters.degree_program !== 'all' ||
        filters.archive_status !== 'active' ||
        filters.sort_by !== undefined ||
        filters.sort_direction !== undefined,
);

const clearFilters = (): void => {
    resetFilter({
        campus_id: 'all',
        college_id: 'all',
        degree_program: 'all',
        archive_status: 'active',
    });
};

const deleteProgram = (program: ProgramItem): void => {
    if (!window.confirm(`Delete "${program.name}"?`)) {
        return;
    }

    router.delete(AdminProgramController.destroy.url(program.id), {
        preserveScroll: true,
    });
};

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');

const degreeLabel = (degree: string): string =>
    degree.replace(/\b\w/g, (character) => character.toUpperCase());
</script>

<template>
    <Head title="Programs" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <Heading
                title="Programs"
                description="Manage academic programs, campus assignments, and program documents."
            />

            <Button as-child>
                <Link :href="create()">
                    <Plus class="size-4" />
                    New program
                </Link>
            </Button>
        </div>

        <div class="flex flex-col gap-3 xl:flex-row xl:items-center">
            <div class="relative w-full xl:max-w-sm">
                <Search
                    class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                />
                <Input
                    v-model="filters.search"
                    class="pl-9"
                    placeholder="Search name, code, document, or degree"
                />
            </div>

            <select
                v-model="filters.campus_id"
                @change="handleFilter({ campus_id: filters.campus_id })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All campuses</option>
                <option
                    v-for="campus in campuses"
                    :key="campus.id"
                    :value="campus.id"
                >
                    {{ campus.name }}
                </option>
            </select>

            <select
                v-model="filters.college_id"
                @change="handleFilter({ college_id: filters.college_id })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All colleges</option>
                <option
                    v-for="college in colleges"
                    :key="college.id"
                    :value="college.id"
                >
                    {{ college.label ?? college.name }}
                </option>
            </select>

            <select
                v-model="filters.degree_program"
                @change="
                    handleFilter({ degree_program: filters.degree_program })
                "
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All degrees</option>
                <option
                    v-for="degree in degreePrograms"
                    :key="degree"
                    :value="degree"
                >
                    {{ degreeLabel(degree) }}
                </option>
            </select>

            <select
                v-model="filters.archive_status"
                @change="
                    handleFilter({ archive_status: filters.archive_status })
                "
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All statuses</option>
                <option value="active">Active</option>
                <option value="archived">Archived</option>
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
            <table class="w-full min-w-[74rem] text-sm">
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
                            column="code"
                            label="Code"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <th class="px-4 py-3 text-left font-medium">
                            Campus
                        </th>
                        <th class="px-4 py-3 text-left font-medium">
                            College
                        </th>
                        <SortableTableHeader
                            column="degree_program"
                            label="Degree"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <th class="px-4 py-3 text-left font-medium">
                            Documents
                        </th>
                        <SortableTableHeader
                            column="is_archived"
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
                        v-for="program in programs.data"
                        :key="program.id"
                        class="border-t border-sidebar-border/70"
                    >
                        <td class="max-w-md px-4 py-4">
                            <div class="font-medium">
                                {{ program.name }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            {{ program.code ?? 'Not set' }}
                        </td>
                        <td class="px-4 py-4">
                            {{ program.campus ?? 'Not set' }}
                        </td>
                        <td class="px-4 py-4">
                            {{ program.college ?? 'Not set' }}
                        </td>
                        <td class="px-4 py-4">
                            {{ program.degreeLabel }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a
                                    v-if="program.loaUrl"
                                    :href="program.loaUrl"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex items-center gap-1 font-medium underline underline-offset-4"
                                >
                                    <FileText class="size-4" />
                                    LOA
                                </a>
                                <a
                                    v-if="program.prospectusUrl"
                                    :href="program.prospectusUrl"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex items-center gap-1 font-medium underline underline-offset-4"
                                >
                                    <FileText class="size-4" />
                                    Prospectus
                                </a>
                                <span
                                    v-if="
                                        !program.loaUrl &&
                                        !program.prospectusUrl
                                    "
                                    class="text-muted-foreground"
                                >
                                    None
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <Badge
                                :variant="
                                    program.isArchived
                                        ? 'secondary'
                                        : 'default'
                                "
                            >
                                {{ program.isArchived ? 'Archived' : 'Active' }}
                            </Badge>
                        </td>
                        <td class="px-4 py-4">
                            {{ program.updatedAt ?? 'Not updated' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <Button size="icon" variant="ghost" as-child>
                                    <Link
                                        :href="edit(program.id)"
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
                                    @click="deleteProgram(program)"
                                >
                                    <Trash2 class="size-4" />
                                    <span class="sr-only">Delete</span>
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="programs.data.length === 0">
                        <td
                            colspan="9"
                            class="px-4 py-10 text-center text-muted-foreground"
                        >
                            No programs found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            v-if="programs.total > 0"
            class="flex flex-wrap items-center justify-between gap-3 text-sm text-muted-foreground"
        >
            <div>
                Showing {{ programs.from }} to {{ programs.to }} of
                {{ programs.total }} programs
            </div>
            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in programs.links"
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
