export type SelectOption = {
    id: string;
    name: string;
    code?: string;
    label?: string;
};

export type ProgramFormData = {
    id?: number;
    code: string | null;
    name: string;
    loa: string | null;
    loaUrl: string | null;
    prospectus: string | null;
    prospectusUrl: string | null;
    description: string | null;
    college_id: string | null;
    campus_id: string | null;
    degree_program: string;
    is_archived: boolean;
};

export type ProgramItem = {
    id: number;
    code: string | null;
    name: string;
    campus: string | null;
    college: string | null;
    degreeProgram: string;
    degreeLabel: string;
    loaUrl: string | null;
    prospectusUrl: string | null;
    isArchived: boolean;
    updatedAt: string | null;
};
