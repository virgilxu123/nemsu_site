export type BannerFormData = {
    id?: number;
    photo: string;
    link: string | null;
    title: string | null;
    content: string | null;
    office_id: number | null;
    is_published: boolean;
};

export type OfficeOption = {
    id: number;
    name: string;
};
