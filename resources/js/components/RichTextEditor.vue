<script setup lang="ts">
import {
    Bold,
    Heading2,
    Italic,
    Link,
    List,
    ListOrdered,
    Quote,
    Redo2,
    Underline,
    Undo2,
} from 'lucide-vue-next';
import { nextTick, onMounted, ref, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';

const props = defineProps<{
    id: string;
    label: string;
    modelValue: string;
}>();

const emit = defineEmits<{
    'update:modelValue': [value: string];
}>();

const editor = ref<HTMLElement | null>(null);
const isUpdatingFromModel = ref(false);

const commands = [
    { command: 'undo', label: 'Undo', icon: Undo2 },
    { command: 'redo', label: 'Redo', icon: Redo2 },
    { command: 'bold', label: 'Bold', icon: Bold },
    { command: 'italic', label: 'Italic', icon: Italic },
    { command: 'underline', label: 'Underline', icon: Underline },
    { command: 'formatBlock', value: 'h2', label: 'Heading', icon: Heading2 },
    { command: 'insertUnorderedList', label: 'Bulleted list', icon: List },
    { command: 'insertOrderedList', label: 'Numbered list', icon: ListOrdered },
    {
        command: 'formatBlock',
        value: 'blockquote',
        label: 'Quote',
        icon: Quote,
    },
];

const syncEditorHtml = (value: string): void => {
    if (!editor.value || editor.value.innerHTML === value) {
        return;
    }

    isUpdatingFromModel.value = true;
    editor.value.innerHTML = value;
    void nextTick(() => {
        isUpdatingFromModel.value = false;
    });
};

const updateValue = (): void => {
    if (!editor.value || isUpdatingFromModel.value) {
        return;
    }

    emit('update:modelValue', editor.value.innerHTML);
};

const runCommand = (command: string, value?: string): void => {
    editor.value?.focus();
    document.execCommand(command, false, value);
    updateValue();
};

const createLink = (): void => {
    const url = window.prompt('Link URL');

    if (!url) {
        return;
    }

    runCommand('createLink', url);
};

onMounted(() => syncEditorHtml(props.modelValue));

watch(
    () => props.modelValue,
    (value) => syncEditorHtml(value),
);
</script>

<template>
    <div class="grid gap-2">
        <Label :for="id">{{ label }}</Label>

        <div class="rounded-md border border-input bg-background shadow-xs">
            <div class="flex flex-wrap gap-1 border-b border-input p-2">
                <Button
                    v-for="item in commands"
                    :key="`${item.command}-${item.value ?? ''}`"
                    type="button"
                    variant="ghost"
                    size="icon"
                    :title="item.label"
                    class="size-8"
                    @click="runCommand(item.command, item.value)"
                >
                    <component :is="item.icon" class="size-4" />
                    <span class="sr-only">{{ item.label }}</span>
                </Button>
                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    title="Link"
                    class="size-8"
                    @click="createLink"
                >
                    <Link class="size-4" />
                    <span class="sr-only">Link</span>
                </Button>
            </div>

            <div
                :id="id"
                ref="editor"
                contenteditable="true"
                class="min-h-72 w-full overflow-y-auto px-3 py-2 text-sm leading-7 outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 [&_blockquote]:border-l-4 [&_blockquote]:pl-4 [&_h2]:text-xl [&_h2]:font-semibold [&_ol]:list-decimal [&_ol]:pl-6 [&_ul]:list-disc [&_ul]:pl-6"
                role="textbox"
                aria-multiline="true"
                @input="updateValue"
                @blur="updateValue"
            ></div>
        </div>
    </div>
</template>
