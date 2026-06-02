export type NavigationItemFormData = {
    id?: string;
    parent_id: string | null;
    location: 'main' | 'footer';
    label: string;
    url: string | null;
    route_name: string | null;
    target_type: 'content_page' | null;
    target_id: string | null;
    sort_order: number;
    is_active: boolean;
};

export type ParentNavigationOption = {
    id: string;
    label: string;
    location: 'main' | 'footer';
};

export type ContentPageOption = {
    id: string;
    title: string;
    slug: string;
};
