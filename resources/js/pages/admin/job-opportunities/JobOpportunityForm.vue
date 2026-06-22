<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { Save } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import RichTextEditor from '@/components/RichTextEditor.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index as adminJobOpportunitiesIndex } from '@/routes/admin/job-opportunities';
import type { RouteFormDefinition } from '@/wayfinder';
import type { JobOpportunityFormData } from './types';

const props = defineProps<{
    formAction: RouteFormDefinition<'post'>;
    opportunity?: JobOpportunityFormData;
    submitLabel: string;
}>();

const formData = ref<JobOpportunityFormData>({
    name: props.opportunity?.name ?? '',
    slug: props.opportunity?.slug ?? '',
    content: props.opportunity?.content ?? '',
    date: props.opportunity?.date ?? '',
    is_hiring: props.opportunity?.is_hiring ?? false,
    is_published: props.opportunity?.is_published ?? false,
});

const slugWasEdited = ref(Boolean(props.opportunity?.slug));

const slugify = (value: string): string =>
    value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

watch(
    () => formData.value.name,
    (name) => {
        if (!slugWasEdited.value) {
            formData.value.slug = slugify(name);
        }
    },
);
</script>

<template>
    <Form
        v-bind="formAction"
        class="grid gap-6"
        v-slot="{ errors, processing }"
    >
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_20rem]">
            <section class="grid gap-5">
                <div class="grid gap-2">
                    <Label for="name">Position or opportunity name</Label>
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
                    <Label for="slug">Slug</Label>
                    <Input
                        id="slug"
                        v-model="formData.slug"
                        name="slug"
                        required
                        autocomplete="off"
                        @input="slugWasEdited = true"
                    />
                    <InputError :message="errors.slug" />
                </div>

                <RichTextEditor
                    id="content"
                    v-model="formData.content"
                    label="Job description and requirements"
                />
                <input type="hidden" name="content" :value="formData.content" />
                <InputError :message="errors.content" />
            </section>

            <aside class="grid h-fit gap-5">
                <div class="grid gap-2">
                    <Label for="date">Date</Label>
                    <Input
                        id="date"
                        v-model="formData.date"
                        name="date"
                        type="datetime-local"
                        required
                    />
                    <InputError :message="errors.date" />
                </div>

                <label class="flex items-center gap-3 text-sm">
                    <input
                        v-model="formData.is_hiring"
                        type="checkbox"
                        name="is_hiring"
                        value="1"
                        class="size-4 rounded border-input"
                    />
                    Currently hiring
                </label>

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
                        <Link :href="adminJobOpportunitiesIndex()">Cancel</Link>
                    </Button>
                </div>
            </aside>
        </div>
    </Form>
</template>
