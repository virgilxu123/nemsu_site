<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, Plus, RotateCcw, Search, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';
import AdminAnnouncementController from '@/actions/App/Http/Controllers/Admin/AnnouncementController';
import AdminNewsController from '@/actions/App/Http/Controllers/Admin/NewsController';
import Heading from '@/components/Heading.vue';
import SortableTableHeader from '@/components/SortableTableHeader.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useTableQuery } from '@/composables/useTableQuery';
import {
    create as createAnnouncement,
    edit as editAnnouncement,
    index as adminAnnouncementsIndex,
} from '@/routes/admin/announcements';
import {
    create as createNews,
    edit as editNews,
    index as adminNewsIndex,
} from '@/routes/admin/news';
import type { SortDirection, TableQueryFilters } from '@/types';

type NewsItem = {
    id: string;
    title: string;
    slug: string;
    excerpt: string | null;
    author: string | null;
    office: string | null;
    type: 'news' | 'announcement';
    isPublished: boolean;
    featured: boolean;
    date: string | null;
    updatedAt: string | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedNews = {
    data: NewsItem[];
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
};

type NewsFilters = TableQueryFilters & {
    search: string;
    status: 'all' | 'published' | 'draft';
    type: 'all' | 'news' | 'announcement';
    featured: 'all' | 'featured' | 'standard';
    sort_by?: string;
    sort_direction?: SortDirection;
};

const props = withDefaults(
    defineProps<{
        contentKind?: 'news' | 'announcement';
        filters: NewsFilters;
        news: PaginatedNews;
    }>(),
    {
        contentKind: 'news',
    },
);

const isAnnouncementMode = computed(() => props.contentKind === 'announcement');
const pageTitle = computed(() =>
    isAnnouncementMode.value ? 'Announcements' : 'News',
);
const pageDescription = computed(() =>
    isAnnouncementMode.value
        ? 'Manage public announcements and student advisories.'
        : 'Manage news stories and public announcements.',
);
const createLabel = computed(() =>
    isAnnouncementMode.value ? 'New announcement' : 'New item',
);
const emptyLabel = computed(() =>
    isAnnouncementMode.value
        ? 'No announcements found.'
        : 'No news items found.',
);
const listUrl =
    props.contentKind === 'announcement'
        ? adminAnnouncementsIndex.url()
        : adminNewsIndex.url();
const createHref = computed(() =>
    isAnnouncementMode.value ? createAnnouncement() : createNews(),
);
const editHref = (id: string) =>
    isAnnouncementMode.value ? editAnnouncement(id) : editNews(id);

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'News', href: adminNewsIndex() }],
    },
});

const { filters, handleFilter, handlePageLink, handleSort, resetFilter } =
    useTableQuery<NewsFilters>({
        url: listUrl,
        initialFilters: props.filters,
        only: ['filters', 'news'],
        debounce: 250,
    });

const clearFilters = (): void => {
    resetFilter({
        status: 'all',
        type: isAnnouncementMode.value ? 'announcement' : 'all',
        featured: 'all',
    });
};

const hasActiveFilters = computed(
    () =>
        filters.search !== '' ||
        filters.status !== 'all' ||
        (!isAnnouncementMode.value && filters.type !== 'all') ||
        filters.featured !== 'all' ||
        filters.sort_by !== undefined ||
        filters.sort_direction !== undefined,
);

const deleteNews = (item: NewsItem): void => {
    if (!window.confirm(`Delete "${item.title}"?`)) {
        return;
    }

    const destroyUrl = isAnnouncementMode.value
        ? AdminAnnouncementController.destroy.url(item.id)
        : AdminNewsController.destroy.url(item.id);

    router.delete(destroyUrl, {
        preserveScroll: true,
    });
};

const paginationLabel = (label: string): string =>
    label
        .replace('&laquo; Previous', 'Previous')
        .replace('Next &raquo;', 'Next');
</script>

<template>
    <Head :title="pageTitle" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <Heading :title="pageTitle" :description="pageDescription" />

            <Button as-child>
                <Link :href="createHref">
                    <Plus class="size-4" />
                    {{ createLabel }}
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
                    placeholder="Search title, slug, excerpt, or author"
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
                v-if="!isAnnouncementMode"
                v-model="filters.type"
                @change="handleFilter({ type: filters.type })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All types</option>
                <option value="news">News</option>
                <option value="announcement">Announcement</option>
            </select>

            <select
                v-model="filters.featured"
                @change="handleFilter({ featured: filters.featured })"
                class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            >
                <option value="all">All feature states</option>
                <option value="featured">Featured</option>
                <option value="standard">Standard</option>
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
                            column="title"
                            label="Item"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <SortableTableHeader
                            v-if="!isAnnouncementMode"
                            column="type"
                            label="Type"
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
                            column="featured"
                            label="Featured"
                            :sort-by="filters.sort_by"
                            :sort-direction="filters.sort_direction"
                            @sort="handleSort"
                        />
                        <th class="px-4 py-3 text-left font-medium">Office</th>
                        <SortableTableHeader
                            column="date"
                            label="Date"
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
                        v-for="item in news.data"
                        :key="item.id"
                        class="border-t border-sidebar-border/70"
                    >
                        <td class="max-w-xl px-4 py-4">
                            <div class="font-medium">{{ item.title }}</div>
                            <div class="mt-1 truncate text-muted-foreground">
                                {{ item.excerpt || item.slug }}
                            </div>
                        </td>
                        <td
                            v-if="!isAnnouncementMode"
                            class="px-4 py-4 capitalize"
                        >
                            {{ item.type }}
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
                        <td class="px-4 py-4">
                            <Badge
                                :variant="
                                    item.featured ? 'default' : 'secondary'
                                "
                            >
                                {{ item.featured ? 'Featured' : 'Standard' }}
                            </Badge>
                        </td>
                        <td class="px-4 py-4">
                            {{ item.office ?? item.author ?? 'Not set' }}
                        </td>
                        <td class="px-4 py-4">{{ item.date }}</td>
                        <td class="px-4 py-4">
                            {{ item.updatedAt ?? 'Not updated' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <Button size="icon" variant="ghost" as-child>
                                    <Link
                                        :href="editHref(item.id)"
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
                                    @click="deleteNews(item)"
                                >
                                    <Trash2 class="size-4" />
                                    <span class="sr-only">Delete</span>
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="news.data.length === 0">
                        <td
                            :colspan="isAnnouncementMode ? 7 : 8"
                            class="px-4 py-10 text-center text-muted-foreground"
                        >
                            {{ emptyLabel }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-muted-foreground">
                Showing {{ news.from ?? 0 }} to {{ news.to ?? 0 }} of
                {{ news.total }} items
            </p>

            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in news.links"
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
