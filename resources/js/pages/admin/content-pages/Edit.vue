<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminContentPageController from '@/actions/App/Http/Controllers/Admin/ContentPageController';
import Heading from '@/components/Heading.vue';
import { index } from '@/routes/admin/content-pages';
import ContentPageForm from './ContentPageForm.vue';
import type { CampusOption, ContentPageFormData, OfficeOption } from './types';

const props = defineProps<{
    page: ContentPageFormData & { id: string };
    offices: OfficeOption[];
    campuses: CampusOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Content Pages', href: index() },
            { title: 'Edit', href: index() },
        ],
    },
});
</script>

<template>
    <Head :title="`Edit ${props.page.title}`" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Edit content page"
            description="Update the static page content and publication settings."
        />

        <ContentPageForm
            :form-action="AdminContentPageController.update.form(props.page.id)"
            :page="props.page"
            :offices="offices"
            :campuses="campuses"
            submit-label="Save changes"
        />
    </div>
</template>
