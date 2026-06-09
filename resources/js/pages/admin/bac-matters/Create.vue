<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminBacMatterController from '@/actions/App/Http/Controllers/Admin/BacMatterController';
import Heading from '@/components/Heading.vue';
import { create, index } from '@/routes/admin/bac-matters';
import BacMatterForm from './BacMatterForm.vue';

defineProps<{
    types: string[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'BAC Matters', href: index() },
            { title: 'Create', href: create() },
        ],
    },
});
</script>

<template>
    <Head title="Create BAC matter" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Create BAC matter"
            description="Add a procurement document or external BAC link."
        />

        <BacMatterForm
            :form-action="AdminBacMatterController.store.form()"
            :types="types"
            submit-label="Create BAC matter"
        />
    </div>
</template>
