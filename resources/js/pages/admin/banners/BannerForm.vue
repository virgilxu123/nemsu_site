<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { Save } from 'lucide-vue-next';
import { computed, ref } from 'vue';
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
    photo: string;
    link: string;
    title: string;
    content: string;
    office_id: number | null;
    is_published: boolean;
};

const blankBanner: EditableBannerFormData = {
    photo: '',
    link: '',
    title: '',
    content: '',
    office_id: null,
    is_published: false,
};

const formData = ref<EditableBannerFormData>({
    photo: props.banner?.photo ?? blankBanner.photo,
    link: props.banner?.link ?? blankBanner.link,
    title: props.banner?.title ?? blankBanner.title,
    content: props.banner?.content ?? blankBanner.content,
    office_id: props.banner?.office_id ?? blankBanner.office_id,
    is_published: props.banner?.is_published ?? blankBanner.is_published,
});

const officeValue = computed(() => formData.value.office_id?.toString() ?? '');

const previewUrl = computed(() => {
    const photo = formData.value.photo.trim();

    if (photo === '') {
        return null;
    }

    if (
        photo.startsWith('http://') ||
        photo.startsWith('https://') ||
        photo.startsWith('/')
    ) {
        return photo;
    }

    return `https://nemsu.edu.ph/files/Banner/${encodeURIComponent(photo)}`;
});
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
                        autocomplete="off"
                    />
                    <InputError :message="errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="photo">Photo</Label>
                    <Input
                        id="photo"
                        v-model="formData.photo"
                        name="photo"
                        required
                        placeholder="banner.jpg or https://example.com/banner.jpg"
                    />
                    <InputError :message="errors.photo" />
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
                    <div v-if="previewUrl" class="aspect-video bg-muted">
                        <img
                            :src="previewUrl"
                            alt=""
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
