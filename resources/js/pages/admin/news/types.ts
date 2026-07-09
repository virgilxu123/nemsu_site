export type NewsFormData = {
    id?: string;
    title: string;
    slug: string;
    short_description: string | null;
    content: string | null;
    photo: string | null;
    photo_url: string | null;
    author: string | null;
    office_id: number | null;
    type: 'news' | 'announcement';
    is_published: boolean;
    featured: boolean;
    date: string | null;
};

export type OfficeOption = {
    id: number;
    name: string;
};
