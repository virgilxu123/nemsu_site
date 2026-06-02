export type SortDirection = 'asc' | 'desc' | undefined;

export type TableQueryFilters = {
    search?: string;
    page?: number;
    per_page?: number;
    sort_by?: string;
    sort_direction?: SortDirection;
    [key: string]: unknown;
};
