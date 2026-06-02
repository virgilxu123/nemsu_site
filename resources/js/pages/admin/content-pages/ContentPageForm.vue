<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { Save } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import RichTextEditor from '@/components/RichTextEditor.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index as adminContentPagesIndex } from '@/routes/admin/content-pages';
import type { RouteFormDefinition } from '@/wayfinder';
import type { CampusOption, ContentPageFormData, OfficeOption } from './types';

const props = defineProps<{
    formAction: RouteFormDefinition<'post'>;
    page?: ContentPageFormData;
    offices: OfficeOption[];
    campuses: CampusOption[];
    submitLabel: string;
}>();

type EditableContentPageFormData = {
    title: string;
    slug: string;
    section: string;
    body: string;
    excerpt: string;
    status: 'draft' | 'published';
    is_published: boolean;
    published_at: string;
    office_id: number | null;
    campus_id: string | null;
    sort_order: number;
};

const blankPage: EditableContentPageFormData = {
    title: '',
    slug: '',
    section: '',
    body: '',
    excerpt: '',
    status: 'draft',
    is_published: false,
    published_at: '',
    office_id: null,
    campus_id: null,
    sort_order: 0,
};

const formData = ref<EditableContentPageFormData>({
    title: props.page?.title ?? blankPage.title,
    slug: props.page?.slug ?? blankPage.slug,
    section: props.page?.section ?? blankPage.section,
    body: props.page?.body ?? blankPage.body,
    excerpt: props.page?.excerpt ?? blankPage.excerpt,
    status: props.page?.status ?? blankPage.status,
    is_published: props.page?.is_published ?? blankPage.is_published,
    published_at: props.page?.published_at ?? blankPage.published_at,
    office_id: props.page?.office_id ?? blankPage.office_id,
    campus_id: props.page?.campus_id ?? blankPage.campus_id,
    sort_order: props.page?.sort_order ?? blankPage.sort_order,
});

const slugWasEdited = ref(Boolean(props.page?.slug));
const officeValue = computed(() => formData.value.office_id?.toString() ?? '');
const campusValue = computed(() => formData.value.campus_id ?? '');

const slugify = (value: string): string =>
    value
        .toLowerCase()
        .trim()
        .replace(/['"]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

watch(
    () => formData.value.title,
    (title) => {
        if (!slugWasEdited.value) {
            formData.value.slug = slugify(title);
        }
    },
);

watch(
    () => formData.value.is_published,
    (isPublished) => {
        formData.value.status = isPublished ? 'published' : 'draft';
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
                    <Label for="title">Title</Label>
                    <Input
                        id="title"
                        v-model="formData.title"
                        name="title"
                        required
                        autocomplete="off"
                    />
                    <InputError :message="errors.title" />
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

                <div class="grid gap-2">
                    <Label for="excerpt">Excerpt</Label>
                    <textarea
                        id="excerpt"
                        v-model="formData.excerpt"
                        name="excerpt"
                        rows="4"
                        class="min-h-24 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    ></textarea>
                    <InputError :message="errors.excerpt" />
                </div>

                <RichTextEditor
                    id="body"
                    v-model="formData.body"
                    label="Body"
                />
                <input type="hidden" name="body" :value="formData.body" />
                <InputError :message="errors.body" />
            </section>

            <aside class="grid h-fit gap-5">
                <div class="grid gap-2">
                    <Label for="section">Section</Label>
                    <Input
                        id="section"
                        v-model="formData.section"
                        name="section"
                        placeholder="about"
                    />
                    <InputError :message="errors.section" />
                </div>

                <div class="grid gap-2">
                    <Label for="published_at">Published at</Label>
                    <Input
                        id="published_at"
                        v-model="formData.published_at"
                        name="published_at"
                        type="datetime-local"
                    />
                    <InputError :message="errors.published_at" />
                </div>

                <div class="grid gap-2">
                    <Label for="sort_order">Sort order</Label>
                    <Input
                        id="sort_order"
                        v-model="formData.sort_order"
                        name="sort_order"
                        type="number"
                        min="0"
                    />
                    <InputError :message="errors.sort_order" />
                </div>

                <div class="grid gap-2">
                    <Label for="office_id">Office</Label>
                    <select
                        id="office_id"
                        name="office_id"
                        :value="officeValue"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                        @change="
                            formData.office_id =
                                ($event.target as HTMLSelectElement).value ===
                                ''
                                    ? null
                                    : Number(
                                          ($event.target as HTMLSelectElement)
                                              .value,
                                      )
                        "
                    >
                        <option value="">No office</option>
                        <option
                            v-for="office in offices"
                            :key="office.id"
                            :value="office.id"
                        >
                            {{ office.name }}
                        </option>
                    </select>
                    <InputError :message="errors.office_id" />
                </div>

                <div class="grid gap-2">
                    <Label for="campus_id">Campus</Label>
                    <select
                        id="campus_id"
                        name="campus_id"
                        :value="campusValue"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                        @change="
                            formData.campus_id =
                                ($event.target as HTMLSelectElement).value ||
                                null
                        "
                    >
                        <option value="">No campus</option>
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

                <input type="hidden" name="status" :value="formData.status" />

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
                        <Link :href="adminContentPagesIndex()">Cancel</Link>
                    </Button>
                </div>
            </aside>
        </div>
    </Form>
</template>
