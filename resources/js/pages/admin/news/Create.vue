<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminAnnouncementController from '@/actions/App/Http/Controllers/Admin/AnnouncementController';
import AdminNewsController from '@/actions/App/Http/Controllers/Admin/NewsController';
import Heading from '@/components/Heading.vue';
import {
    create as createNews,
    index as adminNewsIndex,
} from '@/routes/admin/news';
import NewsForm from './NewsForm.vue';
import type { OfficeOption } from './types';

const props = withDefaults(
    defineProps<{
        contentKind?: 'news' | 'announcement';
        offices: OfficeOption[];
    }>(),
    {
        contentKind: 'news',
    },
);

const isAnnouncementMode = computed(() => props.contentKind === 'announcement');
const pageTitle = computed(() =>
    isAnnouncementMode.value ? 'Create announcement' : 'Create news item',
);
const pageDescription = computed(() =>
    isAnnouncementMode.value
        ? 'Publish a public advisory or campus announcement.'
        : 'Publish newsroom stories and announcements.',
);
const submitLabel = computed(() =>
    isAnnouncementMode.value ? 'Create announcement' : 'Create item',
);
const formAction = computed(() =>
    isAnnouncementMode.value
        ? AdminAnnouncementController.store.form()
        : AdminNewsController.store.form(),
);

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'News', href: adminNewsIndex() },
            { title: 'Create', href: createNews() },
        ],
    },
});
</script>

<template>
    <Head :title="pageTitle" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading :title="pageTitle" :description="pageDescription" />

        <NewsForm
            :form-action="formAction"
            :content-kind="contentKind"
            :offices="offices"
            :submit-label="submitLabel"
        />
    </div>
</template>
