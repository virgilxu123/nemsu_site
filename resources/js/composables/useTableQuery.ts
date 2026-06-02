import { router } from '@inertiajs/vue3';
import { refDebounced } from '@vueuse/core';
import { reactive, toRef, watch } from 'vue';

import type { SortDirection, TableQueryFilters } from '@/types';
import type { QueryParams } from '@/wayfinder';

type UseTableQueryOptions<T extends TableQueryFilters> = {
    url: string;
    initialFilters?: T;
    only?: string[];
    debounce?: number;
};

export function useTableQuery<T extends TableQueryFilters>({
    url,
    initialFilters = {} as T,
    only = [],
    debounce = 300,
}: UseTableQueryOptions<T>) {
    const filters = reactive<T>({
        search: initialFilters.search || '',
        page: initialFilters.page || 1,
        per_page: initialFilters.per_page,
        sort_by: initialFilters.sort_by,
        sort_direction: initialFilters.sort_direction,
        ...initialFilters,
    }) as T;

    const debouncedSearch = refDebounced(toRef(filters, 'search'), debounce);

    watch(debouncedSearch, () => {
        filters.page = 1;
        updateQuery();
    });

    function updateQuery(): void {
        const newFilters: QueryParams = {};

        for (const key in filters) {
            const value = filters[key];

            if (value !== '' && value !== null && value !== undefined) {
                newFilters[key] = value as QueryParams[string];
            }
        }

        router.get(url, newFilters, {
            preserveScroll: true,
            preserveState: true,
            only,
        });
    }

    function handleSort(column: string, direction: SortDirection): void {
        if (direction === undefined) {
            filters.sort_by = undefined;
            filters.sort_direction = undefined;
        } else {
            filters.sort_by = column;
            filters.sort_direction = direction;
        }

        filters.page = 1;
        updateQuery();
    }

    function handlePage(newPage: number): void {
        filters.page = newPage;
        updateQuery();
    }

    function handlePageLink(pageLink: string): void {
        const urlObj = new URL(pageLink, window.location.origin);

        filters.page = parseInt(urlObj.searchParams.get('page') || '1');
        updateQuery();
    }

    function handleFilter(newFilters: Record<string, unknown>): void {
        Object.assign(filters, newFilters);
        filters.page = 1;
        updateQuery();
    }

    function resetFilter(defaultFilters: Partial<T> = {}): void {
        filters.search = '';
        filters.page = 1;
        filters.per_page = undefined;
        filters.sort_by = undefined;
        filters.sort_direction = undefined;

        for (const key in filters) {
            if (
                ![
                    'search',
                    'page',
                    'per_page',
                    'sort_by',
                    'sort_direction',
                ].includes(key)
            ) {
                delete filters[key];
            }
        }

        Object.assign(filters, defaultFilters);
        updateQuery();
    }

    return {
        filters,
        updateQuery,
        handleSort,
        handlePage,
        handlePageLink,
        handleFilter,
        resetFilter,
    };
}
