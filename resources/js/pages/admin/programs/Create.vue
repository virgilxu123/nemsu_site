<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminProgramController from '@/actions/App/Http/Controllers/Admin/ProgramController';
import Heading from '@/components/Heading.vue';
import { create, index } from '@/routes/admin/programs';
import ProgramForm from './ProgramForm.vue';
import type { SelectOption } from './types';

defineProps<{
    degreePrograms: string[];
    campuses: SelectOption[];
    colleges: SelectOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Programs', href: index() },
            { title: 'Create', href: create() },
        ],
    },
});
</script>

<template>
    <Head title="Create program" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Create program"
            description="Add an academic program and its LOA or prospectus documents."
        />

        <ProgramForm
            :form-action="AdminProgramController.store.form()"
            :degree-programs="degreePrograms"
            :campuses="campuses"
            :colleges="colleges"
            submit-label="Create program"
        />
    </div>
</template>
