import type { Component } from 'vue';

export type PublicSiteLinkItem = {
    label: string;
    href?: string;
    external?: boolean;
    links?: PublicSiteLinkItem[];
};

export type PublicSiteNavigationColumn = {
    heading?: string;
    links: PublicSiteLinkItem[];
};

export type PublicSiteNavigationGroup = {
    label: string;
    shortLabel?: string;
    href?: string;
    external?: boolean;
    columns: PublicSiteNavigationColumn[];
};

export type PublicSiteFooterContactItem = {
    label: string;
    value: string;
    href?: string;
};

export type PublicSiteFooterOfficeContact = {
    office: string;
    value: string;
    href: string;
    icon: Component;
};

export type PublicSiteFooterSocialLink = {
    label: string;
    href?: string;
    icon: Component;
};

export type PublicSiteFooterImageLink = {
    label: string;
    href: string;
    image: string;
    imageAlt: string;
    external?: boolean;
};

export type PublicNewsTickerItem = {
    id: string;
    type: 'Announcement' | 'Press Release';
    title: string;
    slug: string;
    date: string | null;
};
