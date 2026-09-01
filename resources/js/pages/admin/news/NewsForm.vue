<script setup lang="ts">
import type { FormDataConvertible } from '@inertiajs/core';
import { Form, Link } from '@inertiajs/vue3';
import { ImageOff, Save } from 'lucide-vue-next';
import { computed, onBeforeUnmount, ref, watch } from 'vue';
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
    author: props.newsItem?.author ?? blankNewsItem.author,
    office_id: props.newsItem?.office_id ?? blankNewsItem.office_id,
    type: props.newsItem?.type ?? defaultType.value,
    is_published: props.newsItem?.is_published ?? blankNewsItem.is_published,
    featured: props.newsItem?.featured ?? blankNewsItem.featured,
    date: props.newsItem?.date ?? blankNewsItem.date,
});

const slugWasEdited = ref(Boolean(props.newsItem?.slug));
const contentImages = ref<Record<string, File>>({});
const photoInput = ref<HTMLInputElement | null>(null);
const photoFile = ref<File | null>(null);
const removePhoto = ref(false);
const photoPreviewUrl = ref<string | null>(props.newsItem?.photo_url ?? null);
let localPhotoPreviewUrl: string | null = null;

watch(
    () => props.newsItem,
    (newItem) => {
        if (!newItem) {
            return;
        }

        formData.value = {
            title: newItem.title ?? blankNewsItem.title,
            slug: newItem.slug ?? blankNewsItem.slug,
            short_description:
                newItem.short_description ?? blankNewsItem.short_description,
            content: newItem.content ?? blankNewsItem.content,
            author: newItem.author ?? blankNewsItem.author,
            office_id: newItem.office_id ?? blankNewsItem.office_id,
            type: newItem.type ?? defaultType.value,
            is_published: newItem.is_published ?? blankNewsItem.is_published,
            featured: newItem.featured ?? blankNewsItem.featured,
            date: newItem.date ?? blankNewsItem.date,
        };
        slugWasEdited.value = Boolean(newItem.slug);
        photoPreviewUrl.value = newItem.photo_url ?? null;
        photoFile.value = null;
        removePhoto.value = false;

        if (photoInput.value) {
            photoInput.value.value = '';
        }
    },
    { deep: true },
);

const transformForm = (
    data: Record<string, FormDataConvertible>,
): Record<string, FormDataConvertible> => ({
    ...data,
    content_images: contentImages.value,
});

const updateContentImages = (images: Record<string, File>): void => {
    contentImages.value = images;
};

const selectPhoto = (event: Event): void => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0] ?? null;

    if (localPhotoPreviewUrl) {
        URL.revokeObjectURL(localPhotoPreviewUrl);
        localPhotoPreviewUrl = null;
    }

    photoFile.value = file;
    removePhoto.value = false;
    localPhotoPreviewUrl = file ? URL.createObjectURL(file) : null;
    photoPreviewUrl.value =
        localPhotoPreviewUrl ?? props.newsItem?.photo_url ?? null;
};

const clearPhoto = (): void => {
    if (localPhotoPreviewUrl) {
        URL.revokeObjectURL(localPhotoPreviewUrl);
        localPhotoPreviewUrl = null;
    }

    if (photoInput.value) {
        photoInput.value.value = '';
    }

    photoFile.value = null;
    photoPreviewUrl.value = null;
    removePhoto.value = Boolean(props.newsItem?.photo);
};

const contentImageError = (
    errors: Record<string, string>,
): string | undefined =>
    errors.content_images ??
    Object.entries(errors).find(([key]) =>
        key.startsWith('content_images.'),
    )?.[1];

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

onBeforeUnmount(() => {
    if (localPhotoPreviewUrl) {
        URL.revokeObjectURL(localPhotoPreviewUrl);
    }
});
</script>

<template>
    <Form
        v-bind="formAction"
        :transform="transformForm"
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
                    enable-images
                    @attachments-change="updateContentImages"
                />
                <input type="hidden" name="content" :value="formData.content" />
                <InputError :message="errors.content" />
                <InputError :message="contentImageError(errors)" />
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
                    <img
                        v-if="photoPreviewUrl"
                        :src="photoPreviewUrl"
                        alt="News photo preview"
                        class="aspect-video w-full rounded-md border border-input object-cover"
                    />
                    <input
                        id="photo"
                        ref="photoInput"
                        name="photo_upload"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        class="block w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-secondary file:px-3 file:py-2 file:text-sm file:font-medium"
                        @change="selectPhoto"
                    />
                    <input
                        type="hidden"
                        name="remove_photo"
                        :value="removePhoto ? '1' : '0'"
                    />
                    <p class="text-xs text-muted-foreground">
                        JPEG, PNG, or WebP. Maximum 5 MB.
                    </p>
                    <Button
                        v-if="photoPreviewUrl || photoFile"
                        type="button"
                        variant="outline"
                        size="sm"
                        class="w-fit"
                        @click="clearPhoto"
                    >
                        <ImageOff class="size-4" />
                        Remove photo
                    </Button>
                    <InputError :message="errors.photo_upload" />
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
                        v-model="formData.office_id"
                        name="office_id"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option :value="null">No office</option>
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
