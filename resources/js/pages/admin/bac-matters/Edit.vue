<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminBacMatterController from '@/actions/App/Http/Controllers/Admin/BacMatterController';
import Heading from '@/components/Heading.vue';
import { index } from '@/routes/admin/bac-matters';
import BacMatterForm from './BacMatterForm.vue';
import type { BacMatterFormData } from './types';

const props = defineProps<{
    matter: BacMatterFormData & { id: number };
    types: string[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'BAC Matters', href: index() },
            { title: 'Edit', href: index() },
        ],
    },
});
</script>

<template>
    <Head :title="`Edit ${props.matter.name}`" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Edit BAC matter"
            description="Update procurement document details and publication settings."
        />

        <BacMatterForm
            :form-action="AdminBacMatterController.update.form(props.matter.id)"
            :matter="props.matter"
            :types="types"
            submit-label="Save changes"
        />
    </div>
</template>
