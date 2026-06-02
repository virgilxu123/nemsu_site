<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminNavigationItemController from '@/actions/App/Http/Controllers/Admin/NavigationItemController';
import Heading from '@/components/Heading.vue';
import { create, index } from '@/routes/admin/navigation';
import NavigationItemForm from './NavigationItemForm.vue';
import type { ContentPageOption, ParentNavigationOption } from './types';

defineProps<{
    parentOptions: ParentNavigationOption[];
    contentPages: ContentPageOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Navigation', href: index() },
            { title: 'Create', href: create() },
        ],
    },
});
</script>

<template>
    <Head title="Create navigation item" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Create navigation item"
            description="Add a link to the main or footer navigation."
        />

        <NavigationItemForm
            :form-action="AdminNavigationItemController.store.form()"
            :parent-options="parentOptions"
            :content-pages="contentPages"
            submit-label="Create item"
        />
    </div>
</template>
