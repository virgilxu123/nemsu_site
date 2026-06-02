<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminAnnouncementController from '@/actions/App/Http/Controllers/Admin/AnnouncementController';
import AdminNewsController from '@/actions/App/Http/Controllers/Admin/NewsController';
import Heading from '@/components/Heading.vue';
import { index as adminNewsIndex } from '@/routes/admin/news';
import NewsForm from './NewsForm.vue';
import type { NewsFormData, OfficeOption } from './types';

const props = withDefaults(
    defineProps<{
        contentKind?: 'news' | 'announcement';
        newsItem: NewsFormData & { id: string };
        offices: OfficeOption[];
    }>(),
    {
        contentKind: 'news',
    },
);

const isAnnouncementMode = computed(() => props.contentKind === 'announcement');
const pageTitle = computed(() =>
    isAnnouncementMode.value ? 'Edit announcement' : 'Edit news item',
);
const pageDescription = computed(() =>
    isAnnouncementMode.value
        ? 'Update announcement content and publication settings.'
        : 'Update newsroom content and publication settings.',
);
const formAction = computed(() =>
    isAnnouncementMode.value
        ? AdminAnnouncementController.update.form(props.newsItem.id)
        : AdminNewsController.update.form(props.newsItem.id),
);

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'News', href: adminNewsIndex() },
            { title: 'Edit', href: adminNewsIndex() },
        ],
    },
});
</script>

<template>
    <Head :title="`Edit ${props.newsItem.title}`" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading :title="pageTitle" :description="pageDescription" />

        <NewsForm
            :form-action="formAction"
            :content-kind="contentKind"
            :news-item="props.newsItem"
            :offices="offices"
            submit-label="Save changes"
        />
    </div>
</template>
