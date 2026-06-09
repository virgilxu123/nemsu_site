<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { Save } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index as adminProgramsIndex } from '@/routes/admin/programs';
import type { RouteFormDefinition } from '@/wayfinder';
import type { ProgramFormData, SelectOption } from './types';

const props = defineProps<{
    formAction: RouteFormDefinition<'post'>;
    program?: ProgramFormData;
    degreePrograms: string[];
    campuses: SelectOption[];
    colleges: SelectOption[];
    submitLabel: string;
}>();

type EditableProgramFormData = {
    code: string;
    name: string;
    loa: string;
    prospectus: string;
    description: string;
    college_id: string;
    campus_id: string;
    degree_program: string;
    remove_loa: boolean;
    remove_prospectus: boolean;
    is_archived: boolean;
};

const blankProgram: EditableProgramFormData = {
    code: '',
    name: '',
    loa: '',
    prospectus: '',
    description: '',
    college_id: '',
    campus_id: '',
    degree_program: 'baccalaureate',
    remove_loa: false,
    remove_prospectus: false,
    is_archived: false,
};

const formData = ref<EditableProgramFormData>({
    code: props.program?.code ?? blankProgram.code,
    name: props.program?.name ?? blankProgram.name,
    loa: props.program?.loa ?? blankProgram.loa,
    prospectus: props.program?.prospectus ?? blankProgram.prospectus,
    description: props.program?.description ?? blankProgram.description,
    college_id: props.program?.college_id ?? blankProgram.college_id,
    campus_id: props.program?.campus_id ?? blankProgram.campus_id,
    degree_program: props.program?.degree_program ?? blankProgram.degree_program,
    remove_loa: blankProgram.remove_loa,
    remove_prospectus: blankProgram.remove_prospectus,
    is_archived: props.program?.is_archived ?? blankProgram.is_archived,
});

const selectedLoaName = ref<string | null>(null);
const selectedProspectusName = ref<string | null>(null);

const currentLoaVisible = computed(
    () => Boolean(props.program?.loaUrl) && selectedLoaName.value === null,
);

const currentProspectusVisible = computed(
    () =>
        Boolean(props.program?.prospectusUrl) &&
        selectedProspectusName.value === null,
);

const handleLoaChange = (event: Event): void => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0] ?? null;

    selectedLoaName.value = file?.name ?? null;

    if (file !== null) {
        formData.value.remove_loa = false;
    }
};

const handleProspectusChange = (event: Event): void => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0] ?? null;

    selectedProspectusName.value = file?.name ?? null;

    if (file !== null) {
        formData.value.remove_prospectus = false;
    }
};

const degreeLabel = (degree: string): string =>
    degree.replace(/\b\w/g, (character) => character.toUpperCase());

watch(
    () => formData.value.remove_loa,
    (removeLoa) => {
        if (removeLoa) {
            selectedLoaName.value = null;
            formData.value.loa = '';
        }
    },
);

watch(
    () => formData.value.remove_prospectus,
    (removeProspectus) => {
        if (removeProspectus) {
            selectedProspectusName.value = null;
            formData.value.prospectus = '';
        }
    },
);
</script>

<template>
    <Form
        v-bind="formAction"
        enctype="multipart/form-data"
        class="grid gap-6"
        v-slot="{ errors, processing }"
    >
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_20rem]">
            <section class="grid gap-5">
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="code">Code</Label>
                        <Input
                            id="code"
                            v-model="formData.code"
                            name="code"
                            autocomplete="off"
                        />
                        <InputError :message="errors.code" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            v-model="formData.name"
                            name="name"
                            required
                            autocomplete="off"
                        />
                        <InputError :message="errors.name" />
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="description">Description</Label>
                    <textarea
                        id="description"
                        v-model="formData.description"
                        name="description"
                        rows="8"
                        class="min-h-40 rounded-md border border-input bg-background px-3 py-2 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    />
                    <InputError :message="errors.description" />
                </div>

                <div class="grid gap-5 lg:grid-cols-2">
                    <div class="grid gap-3">
                        <div class="grid gap-2">
                            <Label for="loa">LOA link or legacy path</Label>
                            <Input
                                id="loa"
                                v-model="formData.loa"
                                name="loa"
                                placeholder="https://example.com/loa.pdf"
                                :disabled="formData.remove_loa"
                            />
                            <InputError :message="errors.loa" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="loa_upload">LOA upload</Label>
                            <Input
                                id="loa_upload"
                                name="loa_upload"
                                type="file"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv"
                                @change="handleLoaChange"
                            />
                            <p
                                v-if="selectedLoaName"
                                class="text-sm text-muted-foreground"
                            >
                                Selected: {{ selectedLoaName }}
                            </p>
                            <InputError :message="errors.loa_upload" />
                        </div>

                        <div
                            v-if="currentLoaVisible"
                            class="rounded-md border border-sidebar-border/70 p-3 text-sm"
                        >
                            <a
                                :href="props.program?.loaUrl ?? '#'"
                                target="_blank"
                                rel="noopener"
                                class="font-medium underline underline-offset-4"
                            >
                                Current LOA
                            </a>
                            <label class="mt-3 flex items-center gap-3">
                                <input
                                    v-model="formData.remove_loa"
                                    type="checkbox"
                                    name="remove_loa"
                                    value="1"
                                    class="size-4 rounded border-input"
                                />
                                Remove current LOA
                            </label>
                            <InputError :message="errors.remove_loa" />
                        </div>
                    </div>

                    <div class="grid gap-3">
                        <div class="grid gap-2">
                            <Label for="prospectus">
                                Prospectus link or legacy path
                            </Label>
                            <Input
                                id="prospectus"
                                v-model="formData.prospectus"
                                name="prospectus"
                                placeholder="https://example.com/prospectus.pdf"
                                :disabled="formData.remove_prospectus"
                            />
                            <InputError :message="errors.prospectus" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="prospectus_upload">
                                Prospectus upload
                            </Label>
                            <Input
                                id="prospectus_upload"
                                name="prospectus_upload"
                                type="file"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv"
                                @change="handleProspectusChange"
                            />
                            <p
                                v-if="selectedProspectusName"
                                class="text-sm text-muted-foreground"
                            >
                                Selected: {{ selectedProspectusName }}
                            </p>
                            <InputError :message="errors.prospectus_upload" />
                        </div>

                        <div
                            v-if="currentProspectusVisible"
                            class="rounded-md border border-sidebar-border/70 p-3 text-sm"
                        >
                            <a
                                :href="props.program?.prospectusUrl ?? '#'"
                                target="_blank"
                                rel="noopener"
                                class="font-medium underline underline-offset-4"
                            >
                                Current prospectus
                            </a>
                            <label class="mt-3 flex items-center gap-3">
                                <input
                                    v-model="formData.remove_prospectus"
                                    type="checkbox"
                                    name="remove_prospectus"
                                    value="1"
                                    class="size-4 rounded border-input"
                                />
                                Remove current prospectus
                            </label>
                            <InputError :message="errors.remove_prospectus" />
                        </div>
                    </div>
                </div>
            </section>

            <aside class="grid h-fit gap-5">
                <div class="grid gap-2">
                    <Label for="campus_id">Campus</Label>
                    <select
                        id="campus_id"
                        v-model="formData.campus_id"
                        name="campus_id"
                        required
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option value="">Select campus</option>
                        <option
                            v-for="campus in campuses"
                            :key="campus.id"
                            :value="campus.id"
                        >
                            {{ campus.name }}
                        </option>
                    </select>
                    <InputError :message="errors.campus_id" />
                </div>

                <div class="grid gap-2">
                    <Label for="college_id">College</Label>
                    <select
                        id="college_id"
                        v-model="formData.college_id"
                        name="college_id"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option value="">No college</option>
                        <option
                            v-for="college in colleges"
                            :key="college.id"
                            :value="college.id"
                        >
                            {{ college.label ?? college.name }}
                        </option>
                    </select>
                    <InputError :message="errors.college_id" />
                </div>

                <div class="grid gap-2">
                    <Label for="degree_program">Degree type</Label>
                    <select
                        id="degree_program"
                        v-model="formData.degree_program"
                        name="degree_program"
                        required
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option
                            v-for="degree in degreePrograms"
                            :key="degree"
                            :value="degree"
                        >
                            {{ degreeLabel(degree) }}
                        </option>
                    </select>
                    <InputError :message="errors.degree_program" />
                </div>

                <label class="flex items-center gap-3 text-sm">
                    <input
                        v-model="formData.is_archived"
                        type="checkbox"
                        name="is_archived"
                        value="1"
                        class="size-4 rounded border-input"
                    />
                    Archived
                </label>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <Button type="submit" :disabled="processing">
                        <Save class="size-4" />
                        {{ submitLabel }}
                    </Button>
                    <Button variant="outline" as-child>
                        <Link :href="adminProgramsIndex()">Cancel</Link>
                    </Button>
                </div>
            </aside>
        </div>
    </Form>
</template>
