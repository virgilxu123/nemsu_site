export type BacMatterFormData = {
    id?: number;
    name: string;
    file: string | null;
    fileUrl: string | null;
    link: string | null;
    type: string | null;
    date: string | null;
    is_published: boolean;
};

export type BacMatterItem = {
    id: number;
    name: string;
    type: string | null;
    destinationUrl: string | null;
    destinationLabel: string;
    isPublished: boolean;
    date: string | null;
    updatedAt: string | null;
};
