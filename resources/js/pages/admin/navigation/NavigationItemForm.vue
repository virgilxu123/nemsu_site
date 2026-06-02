<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { Save } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index as adminNavigationIndex } from '@/routes/admin/navigation';
import type { RouteFormDefinition } from '@/wayfinder';
import type {
    ContentPageOption,
    NavigationItemFormData,
    ParentNavigationOption,
} from './types';

const props = defineProps<{
    formAction: RouteFormDefinition<'post'>;
    item?: NavigationItemFormData;
    parentOptions: ParentNavigationOption[];
    contentPages: ContentPageOption[];
    submitLabel: string;
}>();

type EditableNavigationItemFormData = {
    parent_id: string | null;
    location: 'main' | 'footer';
    label: string;
    url: string;
    route_name: string;
    target_type: 'content_page' | '';
    target_id: string;
    sort_order: number;
    is_active: boolean;
};

const blankItem: EditableNavigationItemFormData = {
    parent_id: null,
    location: 'main',
    label: '',
    url: '',
    route_name: '',
    target_type: '',
    target_id: '',
    sort_order: 0,
    is_active: true,
};

const formData = ref<EditableNavigationItemFormData>({
    parent_id: props.item?.parent_id ?? blankItem.parent_id,
    location: props.item?.location ?? blankItem.location,
    label: props.item?.label ?? blankItem.label,
    url: props.item?.url ?? blankItem.url,
    route_name: props.item?.route_name ?? blankItem.route_name,
    target_type: props.item?.target_type ?? blankItem.target_type,
    target_id: props.item?.target_id ?? blankItem.target_id,
    sort_order: props.item?.sort_order ?? blankItem.sort_order,
    is_active: props.item?.is_active ?? blankItem.is_active,
});

const availableParentOptions = computed(() =>
    props.parentOptions.filter(
        (option) =>
            option.location === formData.value.location &&
            option.id !== props.item?.id,
    ),
);

watch(
    () => formData.value.location,
    () => {
        formData.value.parent_id = null;
    },
);

watch(
    () => formData.value.target_type,
    (targetType) => {
        if (targetType === '') {
            formData.value.target_id = '';
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
                    <Label for="label">Label</Label>
                    <Input
                        id="label"
                        v-model="formData.label"
                        name="label"
                        required
                        autocomplete="off"
                    />
                    <InputError :message="errors.label" />
                </div>

                <div class="grid gap-2">
                    <Label for="url">URL</Label>
                    <Input
                        id="url"
                        v-model="formData.url"
                        name="url"
                        placeholder="/admissions"
                    />
                    <InputError :message="errors.url" />
                </div>

                <div class="grid gap-2">
                    <Label for="route_name">Route name</Label>
                    <Input
                        id="route_name"
                        v-model="formData.route_name"
                        name="route_name"
                        placeholder="home"
                    />
                    <InputError :message="errors.route_name" />
                </div>

                <div class="grid gap-2">
                    <Label for="target_type">CMS target</Label>
                    <select
                        id="target_type"
                        v-model="formData.target_type"
                        name="target_type"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option value="">No CMS target</option>
                        <option value="content_page">Content page</option>
                    </select>
                    <InputError :message="errors.target_type" />
                </div>

                <div
                    v-if="formData.target_type === 'content_page'"
                    class="grid gap-2"
                >
                    <Label for="target_id">Content page</Label>
                    <select
                        id="target_id"
                        v-model="formData.target_id"
                        name="target_id"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option value="">Select a content page</option>
                        <option
                            v-for="page in contentPages"
                            :key="page.id"
                            :value="page.id"
                        >
                            {{ page.title }} (/pages/{{ page.slug }})
                        </option>
                    </select>
                    <InputError :message="errors.target_id" />
                </div>
            </section>

            <aside class="grid h-fit gap-5">
                <div class="grid gap-2">
                    <Label for="location">Location</Label>
                    <select
                        id="location"
                        v-model="formData.location"
                        name="location"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option value="main">Main</option>
                        <option value="footer">Footer</option>
                    </select>
                    <InputError :message="errors.location" />
                </div>

                <div class="grid gap-2">
                    <Label for="parent_id">Parent</Label>
                    <select
                        id="parent_id"
                        v-model="formData.parent_id"
                        name="parent_id"
                        class="h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    >
                        <option :value="null">No parent</option>
                        <option
                            v-for="option in availableParentOptions"
                            :key="option.id"
                            :value="option.id"
                        >
                            {{ option.label }}
                        </option>
                    </select>
                    <InputError :message="errors.parent_id" />
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

                <label class="flex items-center gap-3 text-sm">
                    <input
                        v-model="formData.is_active"
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="size-4 rounded border-input"
                    />
                    Active
                </label>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <Button type="submit" :disabled="processing">
                        <Save class="size-4" />
                        {{ submitLabel }}
                    </Button>
                    <Button variant="outline" as-child>
                        <Link :href="adminNavigationIndex()">Cancel</Link>
                    </Button>
                </div>
            </aside>
        </div>
    </Form>
</template>
