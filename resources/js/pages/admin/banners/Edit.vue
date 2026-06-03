<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminBannerController from '@/actions/App/Http/Controllers/Admin/BannerController';
import Heading from '@/components/Heading.vue';
import { index } from '@/routes/admin/banners';
import BannerForm from './BannerForm.vue';
import type { BannerFormData, OfficeOption } from './types';

const props = defineProps<{
    banner: BannerFormData & { id: number };
    offices: OfficeOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Banners', href: index() },
            { title: 'Edit', href: index() },
        ],
    },
});
</script>

<template>
    <Head :title="`Edit ${props.banner.title || 'banner'}`" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Edit banner"
            description="Update carousel content and publication settings."
        />

        <BannerForm
            :form-action="AdminBannerController.update.form(props.banner.id)"
            :banner="props.banner"
            :offices="offices"
            submit-label="Save changes"
        />
    </div>
</template>
