<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminJobOpportunityController from '@/actions/App/Http/Controllers/Admin/JobOpportunityController';
import Heading from '@/components/Heading.vue';
import { index } from '@/routes/admin/job-opportunities';
import JobOpportunityForm from './JobOpportunityForm.vue';
import type { JobOpportunityFormData } from './types';

const props = defineProps<{
    opportunity: JobOpportunityFormData & { id: string };
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Job Opportunities', href: index() },
            { title: 'Edit', href: index() },
        ],
    },
});
</script>

<template>
    <Head :title="`Edit ${props.opportunity.name}`" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Edit job opportunity"
            description="Update the position details and hiring status."
        />

        <JobOpportunityForm
            :form-action="
                AdminJobOpportunityController.update.form(props.opportunity.id)
            "
            :opportunity="props.opportunity"
            submit-label="Save changes"
        />
    </div>
</template>
