<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { Save } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index as adminBacMattersIndex } from '@/routes/admin/bac-matters';
import type { RouteFormDefinition } from '@/wayfinder';
import type { BacMatterFormData } from './types';

const props = defineProps<{
    formAction: RouteFormDefinition<'post'>;
    matter?: BacMatterFormData;
    types: string[];
    submitLabel: string;
}>();

type EditableBacMatterFormData = {
    name: string;
    link: string;
    type: string;
    date: string;
    remove_file: boolean;
    is_published: boolean;
};

const blankMatter: EditableBacMatterFormData = {
    name: '',
    link: '',
    type: '',
    date: '',
    remove_file: false,
    is_published: false,
};

const formData = ref<EditableBacMatterFormData>({
    name: props.matter?.name ?? blankMatter.name,
    link: props.matter?.link ?? blankMatter.link,
    type: props.matter?.type ?? blankMatter.type,
    date: props.matter?.date ?? blankMatter.date,
    remove_file: blankMatter.remove_file,
    is_published: props.matter?.is_published ?? blankMatter.is_published,
});

const selectedFileName = ref<string | null>(null);

const currentFileVisible = computed(
    () =>
        Boolean(props.matter?.fileUrl) &&
        selectedFileName.value === null,
);

const handleFileChange = (event: Event): void => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0] ?? null;

    selectedFileName.value = file?.name ?? null;

    if (file !== null) {
        formData.value.remove_file = false;
    }
};

watch(
    () => formData.value.remove_file,
    (removeFile) => {
        if (removeFile) {
            selectedFileName.value = null;
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

                <div class="grid gap-2">
                    <Label for="link">Link</Label>
                    <Input
                        id="link"
                        v-model="formData.link"
                        name="link"
                        placeholder="https://example.com/bac-document.pdf"
                    />
                    <InputError :message="errors.link" />
                </div>

                <div class="grid gap-2">
                    <Label for="file_upload">File</Label>
                    <Input
                        id="file_upload"
                        name="file_upload"
                        type="file"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv"
                        @change="handleFileChange"
                    />
                    <p
                        v-if="selectedFileName"
                        class="text-sm text-muted-foreground"
                    >
                        Selected: {{ selectedFileName }}
                    </p>
                    <InputError :message="errors.file_upload" />
                </div>

                <div
                    v-if="currentFileVisible"
                    class="rounded-md border border-sidebar-border/70 p-3 text-sm"
                >
                    <a
                        :href="props.matter?.fileUrl ?? '#'"
                        target="_blank"
                        rel="noopener"
                        class="font-medium underline underline-offset-4"
                    >
                        Current file
                    </a>
                    <label class="mt-3 flex items-center gap-3">
                        <input
                            v-model="formData.remove_file"
                            type="checkbox"
                            name="remove_file"
                            value="1"
                            class="size-4 rounded border-input"
                        />
                        Remove current file
                    </label>
                    <InputError :message="errors.remove_file" />
                </div>
            </section>

            <aside class="grid h-fit gap-5">
                <div class="grid gap-2">
                    <Label for="type">Type</Label>
                    <select
                        id="type"
                        v-model="formData.type"
                        name="type"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option value="">No type</option>
                        <option
                            v-for="type in types"
                            :key="type"
                            :value="type"
                        >
                            {{ type }}
                        </option>
                    </select>
                    <InputError :message="errors.type" />
                </div>

                <div class="grid gap-2">
                    <Label for="date">Date</Label>
                    <Input
                        id="date"
                        v-model="formData.date"
                        name="date"
                        type="datetime-local"
                    />
                    <InputError :message="errors.date" />
                </div>

                <label class="flex items-center gap-3 text-sm">
                    <input
                        v-model="formData.is_published"
                        type="checkbox"
                        name="is_published"
                        value="1"
                        class="size-4 rounded border-input"
                    />
                    Published
                </label>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <Button type="submit" :disabled="processing">
                        <Save class="size-4" />
                        {{ submitLabel }}
                    </Button>
                    <Button variant="outline" as-child>
                        <Link :href="adminBacMattersIndex()">Cancel</Link>
                    </Button>
                </div>
            </aside>
        </div>
    </Form>
</template>
