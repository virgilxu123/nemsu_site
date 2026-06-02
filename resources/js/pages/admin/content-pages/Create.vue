<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminContentPageController from '@/actions/App/Http/Controllers/Admin/ContentPageController';
import Heading from '@/components/Heading.vue';
import { create, index } from '@/routes/admin/content-pages';
import ContentPageForm from './ContentPageForm.vue';
import type { CampusOption, OfficeOption } from './types';

defineProps<{
    offices: OfficeOption[];
    campuses: CampusOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Content Pages', href: index() },
            { title: 'Create', href: create() },
        ],
    },
});
</script>

<template>
    <Head title="Create content page" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Create content page"
            description="Publish a static or semi-static CMS page."
        />

        <ContentPageForm
            :form-action="AdminContentPageController.store.form()"
            :offices="offices"
            :campuses="campuses"
            submit-label="Create page"
        />
    </div>
</template>
