<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Edit,
    GripVertical,
    Plus,
    RotateCcw,
    Search,
    Trash2,
} from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import {
    destroy,
    reorder as reorderBanners,
} from '@/actions/App/Http/Controllers/Admin/BannerController';
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
    photoUrl?: string | null;
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
    bannerOrder: number[];
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
        filters.sort_by !== 'sequence' ||
        filters.sort_direction !== 'asc',
);

const clearFilters = (): void => {
    resetFilter({
        status: 'all',
        sort_by: 'sequence',
        sort_direction: 'asc',
    });
};

const displayedBanners = ref<BannerItem[]>([...props.banners.data]);
const draggedBannerId = ref<number | null>(null);
const dropTargetBannerId = ref<number | null>(null);
const dropPosition = ref<'before' | 'after'>('before');
const isReordering = ref(false);
const canReorder = computed(
    () =>
        !isReordering.value &&
        displayedBanners.value.length > 1 &&
        filters.search === '' &&
        filters.status === 'all' &&
        filters.sort_by === 'sequence' &&
        filters.sort_direction === 'asc',
);

watch(
    () => props.banners.data,
    (banners) => {
        displayedBanners.value = [...banners];
    },
);

const resetDragState = (): void => {
    draggedBannerId.value = null;
    dropTargetBannerId.value = null;
    dropPosition.value = 'before';
};

const startDragging = (event: DragEvent, bannerId: number): void => {
    if (!canReorder.value) {
        event.preventDefault();

        return;
    }

    draggedBannerId.value = bannerId;

    if (event.dataTransfer) {
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/plain', bannerId.toString());
    }
};

const dragOverBanner = (event: DragEvent, bannerId: number): void => {
    if (
        !canReorder.value ||
        draggedBannerId.value === null ||
        draggedBannerId.value === bannerId
    ) {
        return;
    }

    event.preventDefault();

    if (event.dataTransfer) {
        event.dataTransfer.dropEffect = 'move';
    }

    const target = event.currentTarget as HTMLElement;
    const bounds = target.getBoundingClientRect();
    dropTargetBannerId.value = bannerId;
    dropPosition.value =
        event.clientY < bounds.top + bounds.height / 2 ? 'before' : 'after';
};

const moveBannerId = (
    bannerIds: number[],
    sourceBannerId: number,
    targetBannerId: number,
    position: 'before' | 'after',
): number[] => {
    const reorderedBannerIds = [...bannerIds];
    const sourceIndex = reorderedBannerIds.indexOf(sourceBannerId);

    if (sourceIndex === -1) {
        return bannerIds;
    }

    reorderedBannerIds.splice(sourceIndex, 1);
    const targetIndex = reorderedBannerIds.indexOf(targetBannerId);

    if (targetIndex === -1) {
        return bannerIds;
    }

    const insertionIndex = targetIndex + (position === 'after' ? 1 : 0);
    reorderedBannerIds.splice(insertionIndex, 0, sourceBannerId);

    return reorderedBannerIds;
};

const dropBanner = (event: DragEvent, targetBannerId: number): void => {
    event.preventDefault();

    const sourceBannerId = draggedBannerId.value;

    if (
        !canReorder.value ||
        sourceBannerId === null ||
        sourceBannerId === targetBannerId
    ) {
        resetDragState();

        return;
    }

    const reorderedVisibleBannerIds = moveBannerId(
        displayedBanners.value.map((banner) => banner.id),
        sourceBannerId,
        targetBannerId,
        dropPosition.value,
    );
    const reorderedBannerIds = moveBannerId(
        props.bannerOrder,
        sourceBannerId,
        targetBannerId,
        dropPosition.value,
    );
    const bannersById = new Map(
        displayedBanners.value.map((banner) => [banner.id, banner]),
    );
    const reorderedVisibleBanners = reorderedVisibleBannerIds
        .map((bannerId) => bannersById.get(bannerId))
        .filter((banner): banner is BannerItem => banner !== undefined);

    if (
        reorderedVisibleBanners.length !== displayedBanners.value.length ||
        reorderedBannerIds.every(
            (bannerId, index) => bannerId === props.bannerOrder[index],
        )
    ) {
        resetDragState();

        return;
    }

    displayedBanners.value = reorderedVisibleBanners;
    isReordering.value = true;
    resetDragState();

    router.patch(
        reorderBanners.url(),
        {
            banner_ids: reorderedBannerIds,
        },
        {
            preserveScroll: true,
            preserveState: true,
            only: ['filters', 'banners', 'bannerOrder'],
            onError: () => {
                displayedBanners.value = [...props.banners.data];
            },
            onFinish: () => {
                isReordering.value = false;
            },
        },
    );
};

const bannerPhotoUrl = (photo: string): string => {
    if (
        photo.startsWith('http://') ||
        photo.startsWith('https://') ||
        photo.startsWith('/')
    ) {
        return photo;
    }

    if (photo.startsWith('banners/')) {
        return `/storage/${photo}`;
    }

    return `/storage/images/banners/home/${encodeURIComponent(photo)}`;
};

const deleteBanner = (banner: BannerItem): void => {
    if (!window.confirm(`Delete "${banner.title || banner.photo}"?`)) {
        return;
    }

    router.delete(destroy.url(banner.id), {
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

        <p class="text-sm text-muted-foreground" aria-live="polite">
            {{
                isReordering
                    ? 'Saving banner order…'
                    : canReorder
                      ? 'Drag rows by the order handle. Draft banners keep their position when published.'
                      : 'Clear filters and restore the default ordering to enable reordering.'
            }}
        </p>

        <div
            class="overflow-hidden rounded-md border border-sidebar-border/70 dark:border-sidebar-border"
        >
            <table class="w-full min-w-[58rem] text-sm">
                <thead class="bg-muted/50 text-left">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Order</th>
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
                        v-for="(banner, position) in displayedBanners"
                        :key="banner.id"
                        class="border-t border-sidebar-border/70 transition-[opacity,background-color]"
                        :class="{
                            'opacity-50': draggedBannerId === banner.id,
                            'bg-muted/50': dropTargetBannerId === banner.id,
                        }"
                        @dragover="dragOverBanner($event, banner.id)"
                        @drop="dropBanner($event, banner.id)"
                    >
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    :draggable="canReorder"
                                    :disabled="!canReorder"
                                    class="inline-flex size-9 shrink-0 cursor-grab items-center justify-center rounded-md text-muted-foreground hover:bg-muted hover:text-foreground active:cursor-grabbing disabled:cursor-not-allowed disabled:opacity-50"
                                    :title="
                                        canReorder
                                            ? 'Drag to reorder'
                                            : 'Clear filters and restore the default ordering to reorder'
                                    "
                                    :aria-label="`Drag ${banner.title || 'untitled banner'} to reorder`"
                                    @dragstart="
                                        startDragging($event, banner.id)
                                    "
                                    @dragend="resetDragState"
                                >
                                    <GripVertical class="size-5" />
                                </button>
                                <span
                                    class="min-w-6 text-center font-medium tabular-nums"
                                >
                                    {{ (banners.from ?? 1) + position }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <img
                                :src="
                                    banner.photoUrl ||
                                    bannerPhotoUrl(banner.photo)
                                "
                                :alt="banner.title || 'Banner preview'"
                                draggable="false"
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
                    <tr v-if="displayedBanners.length === 0">
                        <td
                            colspan="8"
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
