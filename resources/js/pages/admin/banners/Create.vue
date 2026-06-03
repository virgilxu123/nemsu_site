<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminBannerController from '@/actions/App/Http/Controllers/Admin/BannerController';
import Heading from '@/components/Heading.vue';
import { create, index } from '@/routes/admin/banners';
import BannerForm from './BannerForm.vue';
import type { OfficeOption } from './types';

defineProps<{
    offices: OfficeOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Banners', href: index() },
            { title: 'Create', href: create() },
        ],
    },
});
</script>

<template>
    <Head title="Create banner" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Create banner"
            description="Add a homepage carousel banner."
        />

        <BannerForm
            :form-action="AdminBannerController.store.form()"
            :offices="offices"
            submit-label="Create banner"
        />
    </div>
</template>
