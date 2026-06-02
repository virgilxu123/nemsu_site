<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminNavigationItemController from '@/actions/App/Http/Controllers/Admin/NavigationItemController';
import Heading from '@/components/Heading.vue';
import { index } from '@/routes/admin/navigation';
import NavigationItemForm from './NavigationItemForm.vue';
import type {
    ContentPageOption,
    NavigationItemFormData,
    ParentNavigationOption,
} from './types';

const props = defineProps<{
    item: NavigationItemFormData & { id: string };
    parentOptions: ParentNavigationOption[];
    contentPages: ContentPageOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Navigation', href: index() },
            { title: 'Edit', href: index() },
        ],
    },
});
</script>

<template>
    <Head :title="`Edit ${props.item.label}`" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Edit navigation item"
            description="Update menu placement, destination, and publication state."
        />

        <NavigationItemForm
            :form-action="
                AdminNavigationItemController.update.form(props.item.id)
            "
            :item="props.item"
            :parent-options="parentOptions"
            :content-pages="contentPages"
            submit-label="Save changes"
        />
    </div>
</template>
