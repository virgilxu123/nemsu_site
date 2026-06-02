export type ContentPageFormData = {
    id?: string;
    title: string;
    slug: string;
    section: string | null;
    body: string | null;
    excerpt: string | null;
    status: 'draft' | 'published';
    is_published: boolean;
    published_at: string | null;
    office_id: number | null;
    campus_id: string | null;
    sort_order: number;
};

export type OfficeOption = {
    id: number;
    name: string;
};

export type CampusOption = {
    id: string;
    name: string;
};
