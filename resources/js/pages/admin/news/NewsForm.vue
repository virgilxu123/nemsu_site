<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { Save } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import RichTextEditor from '@/components/RichTextEditor.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index as adminNewsIndex } from '@/routes/admin/news';
import type { RouteFormDefinition } from '@/wayfinder';
import type { NewsFormData, OfficeOption } from './types';

const props = defineProps<{
    formAction: RouteFormDefinition<'post'>;
    newsItem?: NewsFormData;
    offices: OfficeOption[];
    submitLabel: string;
    contentKind?: 'news' | 'announcement';
}>();

type EditableNewsFormData = {
    title: string;
    slug: string;
    short_description: string;
    content: string;
    photo: string;
    author: string;
    office_id: number | null;
    type: 'news' | 'announcement';
    is_published: boolean;
    featured: boolean;
    date: string;
};

const localDateTimeValue = (date: Date): string => {
    const offsetDate = new Date(
        date.getTime() - date.getTimezoneOffset() * 60_000,
    );

    return offsetDate.toISOString().slice(0, 16);
};

const defaultType = computed(() => props.contentKind ?? 'news');

const blankNewsItem: EditableNewsFormData = {
    title: '',
    slug: '',
    short_description: '',
    content: '',
    photo: '',
    author: '',
    office_id: null,
    type: defaultType.value,
    is_published: false,
    featured: false,
    date: localDateTimeValue(new Date()),
};

const formData = ref<EditableNewsFormData>({
    title: props.newsItem?.title ?? blankNewsItem.title,
    slug: props.newsItem?.slug ?? blankNewsItem.slug,
    short_description:
        props.newsItem?.short_description ?? blankNewsItem.short_description,
    content: props.newsItem?.content ?? blankNewsItem.content,
    photo: props.newsItem?.photo ?? blankNewsItem.photo,
    author: props.newsItem?.author ?? blankNewsItem.author,
    office_id: props.newsItem?.office_id ?? blankNewsItem.office_id,
    type: props.newsItem?.type ?? defaultType.value,
    is_published: props.newsItem?.is_published ?? blankNewsItem.is_published,
    featured: props.newsItem?.featured ?? blankNewsItem.featured,
    date: props.newsItem?.date ?? blankNewsItem.date,
});

const slugWasEdited = ref(Boolean(props.newsItem?.slug));
const officeValue = computed(() => formData.value.office_id?.toString() ?? '');

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
                    <Label for="short_description">Excerpt</Label>
                    <textarea
                        id="short_description"
                        v-model="formData.short_description"
                        name="short_description"
                        rows="4"
                        class="min-h-24 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    ></textarea>
                    <InputError :message="errors.short_description" />
                </div>

                <RichTextEditor
                    id="content"
                    v-model="formData.content"
                    label="Body"
                />
                <input type="hidden" name="content" :value="formData.content" />
                <InputError :message="errors.content" />
            </section>

            <aside class="grid h-fit gap-5">
                <div class="grid gap-2">
                    <Label for="type">Type</Label>
                    <select
                        v-if="props.contentKind !== 'announcement'"
                        id="type"
                        v-model="formData.type"
                        name="type"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option value="news">News</option>
                        <option value="announcement">Announcement</option>
                    </select>
                    <input
                        v-else
                        type="hidden"
                        name="type"
                        value="announcement"
                    />
                    <Input
                        v-if="props.contentKind === 'announcement'"
                        id="type"
                        value="Announcement"
                        disabled
                    />
                    <InputError :message="errors.type" />
                </div>

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

                <div class="grid gap-2">
                    <Label for="photo">Photo</Label>
                    <Input
                        id="photo"
                        v-model="formData.photo"
                        name="photo"
                        placeholder="https://example.com/photo.jpg"
                    />
                    <InputError :message="errors.photo" />
                </div>

                <div class="grid gap-2">
                    <Label for="author">Author</Label>
                    <Input
                        id="author"
                        v-model="formData.author"
                        name="author"
                    />
                    <InputError :message="errors.author" />
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

                <label class="flex items-center gap-3 text-sm">
                    <input
                        v-model="formData.featured"
                        type="checkbox"
                        name="featured"
                        value="1"
                        class="size-4 rounded border-input"
                    />
                    Featured
                </label>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <Button type="submit" :disabled="processing">
                        <Save class="size-4" />
                        {{ submitLabel }}
                    </Button>
                    <Button variant="outline" as-child>
                        <Link :href="adminNewsIndex()">Cancel</Link>
                    </Button>
                </div>
            </aside>
        </div>
    </Form>
</template>
