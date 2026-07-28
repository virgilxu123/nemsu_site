import type { Component, CSSProperties } from 'vue';

export type BannerItem = {
    id: number | string;
    title?: string | null;
    summary?: string | null;
    imageUrl: string;
    link?: string | null;
};

export type NewsItem = {
    id: string;
    type: string;
    title: string;
    slug: string;
    excerpt?: string | null;
    date: string | null;
    office: string;
    photoUrl?: string | null;
};

export type SdgArticle = {
    id: string;
    title: string;
    date: string | null;
    category?: string | null;
    photoUrl?: string | null;
    slug?: string;
    href?: string;
};

export type JobOpportunity = {
    id: string;
    position: string;
    details?: string | null;
    postedAt: string | null;
    isHiring: boolean;
    campus?: string | null;
    deadline?: string | null;
    salaryGrade?: string | null;
    monthlySalary?: string | null;
    employmentType?: string | null;
    experience?: string | null;
};

export type BacDocument = {
    id: number;
    title: string;
    type: string;
    postedAt: string | null;
    destinationUrl: string | null;
};

export type QuickAction = {
    icon?: Component;
    title: string;
    description: string;
    href: string;
};

export type Campus = {
    slug: string;
    name: string;
    focus: string;
    detail: string;
    location: string;
    studentsCount?: string;
    programsCount?: string;
    establishedYear?: string;
    primaryPhoto?: string;
    secondaryPhoto?: string;
};

export type GlanceStat = {
    key: string;
    label: string;
    value: string;
    scope?: string;
};

export type MapHighlight = {
    label: string;
    description: string;
    top: string;
    left: string;
    labelPosition: 'left' | 'right';
};

export type Metric = {
    label: string;
    value: string;
    note: string;
};

export type RevealDirection = 'down' | 'left' | 'right' | 'up';

export type RevealClasses = (
    section: string,
    direction?: RevealDirection,
) => string;

export type StaggerDelay = (section: string, index: number) => CSSProperties;

export type WelcomePageProps = {
    banners?: BannerItem[];
    featuredNews?: NewsItem | null;
    pressReleases?: NewsItem[];
    announcements?: NewsItem[];
    sdgArticles?: SdgArticle[];
    sdgDescription?: string;
    sdgLearnMoreUrl?: string;
    jobOpportunities?: JobOpportunity[];
    bacDocuments?: BacDocument[];
    atAGlanceStats?: GlanceStat[];
    atAGlanceMapHighlights?: MapHighlight[];
};
