<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminProgramController from '@/actions/App/Http/Controllers/Admin/ProgramController';
import Heading from '@/components/Heading.vue';
import { index } from '@/routes/admin/programs';
import ProgramForm from './ProgramForm.vue';
import type { ProgramFormData, SelectOption } from './types';

const props = defineProps<{
    program: ProgramFormData & { id: number };
    degreePrograms: string[];
    campuses: SelectOption[];
    colleges: SelectOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Programs', href: index() },
            { title: 'Edit', href: index() },
        ],
    },
});
</script>

<template>
    <Head :title="`Edit ${props.program.name}`" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4">
        <Heading
            title="Edit program"
            description="Update program details, documents, and archive status."
        />

        <ProgramForm
            :form-action="AdminProgramController.update.form(props.program.id)"
            :program="props.program"
            :degree-programs="degreePrograms"
            :campuses="campuses"
            :colleges="colleges"
            submit-label="Save changes"
        />
    </div>
</template>
