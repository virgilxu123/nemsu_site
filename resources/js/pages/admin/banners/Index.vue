<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, Plus, RotateCcw, Search, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';
import AdminBannerController from '@/actions/App/Http/Controllers/Admin/BannerController';
import Heading from '@/components/Heading.vue';
import SortableTableHeader from '@/components/SortableTableHeader.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useTableQuery } from '@/composables/useTableQuery';
import { create, edit, index } from '@/routes/admin/banners';
import type { SortDirection, TableQueryFilters } from '@/types';

type BannerItem = {
    id: number;
    title: string | null;
    photo: string;
    link: string | null;
    office: string | null;
    isPublished: boolean;
    createdAt: string | null;
    updatedAt: string | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedBanners = {
    data: BannerItem[];
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
};

type BannerFilters = TableQueryFilters & {
    search: string;
    status: 'all' | 'published' | 'draft';
    sort_by?: string;
    sort_direction?: SortDirection;
};

const props = defineProps<{
    filters: BannerFilters;
    banners: PaginatedBanners;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Banners', href: index() }],
    },
});

const { filters, handleFilter, handlePageLink, handleSort, resetFilter } =
    useTableQuery<BannerFilters>({
        url: index.url(),
        initialFilters: props.filters,
        only: ['filters', 'banners'],
        debounce: 250,
    });

const hasActiveFilters = computed(
    () =>
        filters.search !== '' ||
        filters.status !== 'all' ||
        filters.sort_by !== undefined ||
        filters.sort_direction !== undefined,
);

const clearFilters = (): void => {
    resetFilter({
        status: 'all',
    });
};

const bannerPhotoUrl = (photo: string): string => {
    if (
        photo.startsWith('http://') ||
        photo.startsWith('https://') ||
        photo.startsWith('/')
    ) {
        return photo;
    }

    return `https://nemsu.edu.ph/files/Banner/${encodeURIComponent(photo)}`;
};

const deleteBanner = (banner: BannerItem): void => {
    if (!window.confirm(`Delete "${banner.title || banner.photo}"?`)) {
        return;
    }

    router.delete(AdminBannerController.destroy.url(banner.id), {
        preserveScroll: true,
    });
};

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');
</script>

<template>
    <Head title="Banners" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <Heading
                title="Banners"
                description="Manage homepage carousel banners."
            />

            <Button as-child>
                <Link :href="create()">
                    <Plus class="size-4" />
                    New banner
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
                    placeholder="Search title, photo, link, or summary"
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
                        <th class="px-4 py-3 text-left font-medium">Preview</th>
                        <SortableTableHeader
                            column="title"
                            label="Banner"
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
                        <th class="px-4 py-3 text-left font-medium">Office</th>
                        <SortableTableHeader
                            column="created_at"
                            label="Created"
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
                        v-for="banner in banners.data"
                        :key="banner.id"
                        class="border-t border-sidebar-border/70"
                    >
                        <td class="px-4 py-4">
                            <img
                                :src="bannerPhotoUrl(banner.photo)"
                                :alt="banner.title || 'Banner preview'"
                                class="aspect-video w-32 rounded-md object-cover"
                            />
                        </td>
                        <td class="max-w-xl px-4 py-4">
                            <div class="font-medium">
                                {{ banner.title || 'Untitled banner' }}
                            </div>
                            <div class="mt-1 truncate text-muted-foreground">
                                {{ banner.link || banner.photo }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <Badge
                                :variant="
                                    banner.isPublished ? 'default' : 'secondary'
                                "
                            >
                                {{ banner.isPublished ? 'Published' : 'Draft' }}
                            </Badge>
                        </td>
                        <td class="px-4 py-4">
                            {{ banner.office ?? 'Not set' }}
                        </td>
                        <td class="px-4 py-4">{{ banner.createdAt }}</td>
                        <td class="px-4 py-4">
                            {{ banner.updatedAt ?? 'Not updated' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <Button size="icon" variant="ghost" as-child>
                                    <Link :href="edit(banner.id)" title="Edit">
                                        <Edit class="size-4" />
                                        <span class="sr-only">Edit</span>
                                    </Link>
                                </Button>
                                <Button
                                    size="icon"
                                    variant="ghost"
                                    type="button"
                                    title="Delete"
                                    @click="deleteBanner(banner)"
                                >
                                    <Trash2 class="size-4" />
                                    <span class="sr-only">Delete</span>
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="banners.data.length === 0">
                        <td
                            colspan="7"
                            class="px-4 py-10 text-center text-muted-foreground"
                        >
                            No banners found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-muted-foreground">
                Showing {{ banners.from ?? 0 }} to {{ banners.to ?? 0 }} of
                {{ banners.total }} banners
            </p>

            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in banners.links"
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
