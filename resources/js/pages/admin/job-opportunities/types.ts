export type JobOpportunityFormData = {
    id?: string;
    name: string;
    slug: string;
    content: string;
    date: string;
    is_hiring: boolean;
    is_published: boolean;
};

export type JobOpportunityItem = {
    id: string;
    name: string;
    slug: string;
    date: string;
    isHiring: boolean;
    isPublished: boolean;
    updatedAt: string | null;
};
