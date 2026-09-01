<script setup lang="ts">
import type { FormDataConvertible } from '@inertiajs/core';
import { Form, Link } from '@inertiajs/vue3';
import { ImageOff, Save } from 'lucide-vue-next';
import { computed, onBeforeUnmount, ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index as adminBannersIndex } from '@/routes/admin/banners';
import type { RouteFormDefinition } from '@/wayfinder';
import type { BannerFormData, OfficeOption } from './types';

const props = defineProps<{
    formAction: RouteFormDefinition<'post'>;
    banner?: BannerFormData;
    offices: OfficeOption[];
    submitLabel: string;
}>();

type EditableBannerFormData = {
    link: string;
    title: string;
    content: string;
    office_id: number | null;
    is_published: boolean;
};

const blankBanner: EditableBannerFormData = {
    link: '',
    title: '',
    content: '',
    office_id: null,
    is_published: false,
};

const formData = ref<EditableBannerFormData>({
    link: props.banner?.link ?? blankBanner.link,
    title: props.banner?.title ?? blankBanner.title,
    content: props.banner?.content ?? blankBanner.content,
    office_id: props.banner?.office_id ?? blankBanner.office_id,
    is_published: props.banner?.is_published ?? blankBanner.is_published,
});

const officeValue = computed(() => formData.value.office_id?.toString() ?? '');

const photoInput = ref<HTMLInputElement | null>(null);
const photoFile = ref<File | null>(null);
const removePhoto = ref(false);
const photoPreviewUrl = ref<string | null>(props.banner?.photoUrl ?? null);
let localPhotoPreviewUrl: string | null = null;

const transformForm = (
    data: Record<string, FormDataConvertible>,
): Record<string, FormDataConvertible> => ({
    ...data,
    photo_upload: photoFile.value,
    remove_photo: removePhoto.value,
});

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
        localPhotoPreviewUrl ?? props.banner?.photoUrl ?? null;
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
    removePhoto.value = Boolean(props.banner?.photo);
};

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
                        autocomplete="off"
                    />
                    <InputError :message="errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="photo">Photo</Label>
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
                    <InputError :message="errors.photo_upload || errors.photo" />
                </div>

                <div class="grid gap-2">
                    <Label for="link">Link</Label>
                    <Input
                        id="link"
                        v-model="formData.link"
                        name="link"
                        placeholder="https://nemsu.edu.ph"
                    />
                    <InputError :message="errors.link" />
                </div>

                <div class="grid gap-2">
                    <Label for="content">Summary</Label>
                    <textarea
                        id="content"
                        v-model="formData.content"
                        name="content"
                        rows="6"
                        class="min-h-32 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    ></textarea>
                    <InputError :message="errors.content" />
                </div>
            </section>

            <aside class="grid h-fit gap-5">
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

                <div
                    class="overflow-hidden rounded-md border border-sidebar-border/70"
                >
                    <div v-if="photoPreviewUrl" class="aspect-video bg-muted">
                        <img
                            :src="photoPreviewUrl"
                            alt="Banner preview"
                            class="h-full w-full object-cover"
                        />
                    </div>
                    <div
                        v-else
                        class="grid aspect-video place-items-center bg-muted text-sm text-muted-foreground"
                    >
                        Banner preview
                    </div>
                </div>

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

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <Button type="submit" :disabled="processing">
                        <Save class="size-4" />
                        {{ submitLabel }}
                    </Button>
                    <Button variant="outline" as-child>
                        <Link :href="adminBannersIndex()">Cancel</Link>
                    </Button>
                </div>
            </aside>
        </div>
    </Form>
</template>
