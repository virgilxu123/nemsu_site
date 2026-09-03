<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

type StructuredData = Record<string, unknown>;

type SeoMetadata = {
    title: string;
    fullTitle: string;
    description: string;
    keywords: string;
    canonical: string;
    image: string;
    type: string;
    robots: string;
    locale: string;
    siteName: string;
    googleSiteVerification?: string | null;
    schema: StructuredData[];
};

const page = usePage<{ seo: SeoMetadata }>();
const seo = computed(() => page.props.seo);
const structuredData = computed(() =>
    seo.value.schema.map((schema) =>
        JSON.stringify(schema).replace(/</g, '\\u003c'),
    ),
);
</script>

<template>
    <Head :title="seo.title">
        <meta
            head-key="description"
            name="description"
            :content="seo.description"
        />
        <meta head-key="keywords" name="keywords" :content="seo.keywords" />
        <meta head-key="robots" name="robots" :content="seo.robots" />
        <link head-key="canonical" rel="canonical" :href="seo.canonical" />

        <meta
            head-key="og:title"
            property="og:title"
            :content="seo.fullTitle"
        />
        <meta
            head-key="og:description"
            property="og:description"
            :content="seo.description"
        />
        <meta head-key="og:type" property="og:type" :content="seo.type" />
        <meta head-key="og:url" property="og:url" :content="seo.canonical" />
        <meta head-key="og:image" property="og:image" :content="seo.image" />
        <meta head-key="og:locale" property="og:locale" :content="seo.locale" />
        <meta
            head-key="og:site_name"
            property="og:site_name"
            :content="seo.siteName"
        />

        <meta
            head-key="twitter:card"
            name="twitter:card"
            content="summary_large_image"
        />
        <meta
            head-key="twitter:title"
            name="twitter:title"
            :content="seo.fullTitle"
        />
        <meta
            head-key="twitter:description"
            name="twitter:description"
            :content="seo.description"
        />
        <meta
            head-key="twitter:image"
            name="twitter:image"
            :content="seo.image"
        />
        <meta
            v-if="seo.googleSiteVerification"
            head-key="google-site-verification"
            name="google-site-verification"
            :content="seo.googleSiteVerification"
        />

        <component
            v-for="(schema, index) in structuredData"
            :key="index"
            :is="'script'"
            :head-key="`schema-${index}`"
            type="application/ld+json"
            >{{ schema }}</component
        >
    </Head>
</template>
