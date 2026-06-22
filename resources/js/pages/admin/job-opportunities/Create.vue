<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminJobOpportunityController from '@/actions/App/Http/Controllers/Admin/JobOpportunityController';
import Heading from '@/components/Heading.vue';
import { create, index } from '@/routes/admin/job-opportunities';
import JobOpportunityForm from './JobOpportunityForm.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Job Opportunities', href: index() },
            { title: 'Create', href: create() },
        ],
    },
});
</script>

<template>
    <Head title="Create job opportunity" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Create job opportunity"
            description="Publish a position, hiring notice, and its requirements."
        />

        <JobOpportunityForm
            :form-action="AdminJobOpportunityController.store.form()"
            submit-label="Create job opportunity"
        />
    </div>
</template>
