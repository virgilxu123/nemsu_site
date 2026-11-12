<script setup lang="ts">
import {
    Bold,
    Heading2,
    Italic,
    LayoutGrid,
    Link,
    List,
    ListOrdered,
    Loader2,
    Quote,
    Redo2,
    Trash2,
    Underline,
    Undo2,
} from 'lucide-vue-next';
import { nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';

const props = withDefaults(
    defineProps<{
        id: string;
        label: string;
        modelValue: string;
        enableImages?: boolean;
        imageUploadUrl?: string;
    }>(),
    {
        enableImages: false,
        imageUploadUrl: '/admin/news/images',
    },
);

const emit = defineEmits<{
    'update:modelValue': [value: string];
    'attachments-change': [attachments: Record<string, File>];
}>();

const editor = ref<HTMLElement | null>(null);
const editorContainer = ref<HTMLElement | null>(null);
const imageInput = ref<HTMLInputElement | null>(null);
const isUpdatingFromModel = ref(false);
const isUploading = ref(false);
const uploadStatus = ref('');
const uploadError = ref<string | null>(null);
const targetUploadMode = ref<'image' | 'grid'>('image');

const activeImage = ref<HTMLImageElement | null>(null);
const deleteBtnPos = ref<{ top: number; left: number } | null>(null);
const isOverDeleteBtn = ref(false);
let savedSelection: Range | null = null;

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

const saveCurrentSelection = (): void => {
    const selection = window.getSelection();

    if (selection?.rangeCount && editor.value?.contains(selection.anchorNode)) {
        savedSelection = selection.getRangeAt(0).cloneRange();
    } else {
        savedSelection = null;
    }
};

const chooseImages = (mode: 'image' | 'grid' = 'image'): void => {
    saveCurrentSelection();
    targetUploadMode.value = mode;
    uploadError.value = null;
    imageInput.value?.click();
};

const getCsrfToken = (): string => {
    const meta = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');
    if (meta) {
        return meta;
    }

    const match = document.cookie.match(/(?:^|; )XSRF-TOKEN=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : '';
};

const insertHtmlAtSelection = (html: string): void => {
    if (!editor.value) {
        return;
    }

    editor.value.focus();
    const selection = window.getSelection();

    if (
        savedSelection &&
        editor.value.contains(savedSelection.commonAncestorContainer)
    ) {
        selection?.removeAllRanges();
        selection?.addRange(savedSelection);
        savedSelection.deleteContents();

        const template = document.createElement('template');
        template.innerHTML = html;
        const fragment = template.content;
        const lastNode = fragment.lastChild;

        savedSelection.insertNode(fragment);
        if (lastNode) {
            savedSelection.setStartAfter(lastNode);
            savedSelection.collapse(true);
            selection?.removeAllRanges();
            selection?.addRange(savedSelection);
        }
    } else {
        editor.value.insertAdjacentHTML('beforeend', html);
    }

    savedSelection = null;
    updateValue();
};

const handleImagesSelected = async (event: Event): Promise<void> => {
    const input = event.target as HTMLInputElement;
    const files = Array.from(input.files ?? []);

    if (files.length === 0 || !editor.value) {
        return;
    }

    isUploading.value = true;
    uploadError.value = null;

    const uploadedResults: Array<{ url: string; alt: string }> = [];

    try {
        const csrfToken = getCsrfToken();

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            uploadStatus.value = `Uploading image ${i + 1} of ${files.length}...`;

            const formData = new FormData();
            formData.append('image', file);

            const response = await fetch(props.imageUploadUrl, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-XSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            if (!response.ok) {
                let errorMessage = `Failed to upload "${file.name}"`;
                try {
                    const data = await response.json();
                    if (data.message) {
                        errorMessage = data.message;
                    } else if (data.errors?.image?.[0]) {
                        errorMessage = data.errors.image[0];
                    }
                } catch {
                    if (response.status === 413) {
                        errorMessage = `File "${file.name}" is too large for the server.`;
                    }
                }
                throw new Error(errorMessage);
            }

            const data = (await response.json()) as {
                url: string;
                alt?: string;
            };
            uploadedResults.push({
                url: data.url,
                alt: data.alt || file.name,
            });
        }

        if (uploadedResults.length > 0) {
            const columns =
                uploadedResults.length === 1
                    ? 1
                    : uploadedResults.length === 2
                      ? 2
                      : 3;
            const imagesHtml = uploadedResults
                .map(
                    (img) =>
                        `<figure><img src="${img.url}" alt="${img.alt}" /></figure>`,
                )
                .join('');
            const gridHtml = `<div class="photo-grid" data-columns="${columns}">${imagesHtml}</div><p><br></p>`;
            insertHtmlAtSelection(gridHtml);
        }
    } catch (error) {
        uploadError.value =
            error instanceof Error
                ? error.message
                : 'Failed to upload image. Please try again.';
    } finally {
        isUploading.value = false;
        uploadStatus.value = '';
        input.value = '';
    }
};

const updateDeleteButtonPosition = (): void => {
    if (!activeImage.value || !editorContainer.value || !editor.value) {
        deleteBtnPos.value = null;
        return;
    }

    const containerRect = editorContainer.value.getBoundingClientRect();
    const imgRect = activeImage.value.getBoundingClientRect();

    if (imgRect.bottom < containerRect.top || imgRect.top > containerRect.bottom) {
        deleteBtnPos.value = null;
        return;
    }

    deleteBtnPos.value = {
        top: Math.max(8, imgRect.top - containerRect.top + 8),
        left: Math.max(8, imgRect.right - containerRect.left - 76),
    };
};

const handleEditorMouseMove = (event: MouseEvent): void => {
    if (isOverDeleteBtn.value) {
        return;
    }

    const target = event.target as HTMLElement | null;
    const img = target?.closest('img');

    if (img && editor.value?.contains(img)) {
        if (activeImage.value !== img) {
            activeImage.value = img as HTMLImageElement;
            updateDeleteButtonPosition();
        }
    } else if (!isOverDeleteBtn.value) {
        activeImage.value = null;
        deleteBtnPos.value = null;
    }
};

const handleEditorMouseLeave = (): void => {
    if (!isOverDeleteBtn.value) {
        activeImage.value = null;
        deleteBtnPos.value = null;
    }
};

const handleEditorClick = (event: MouseEvent): void => {
    const target = event.target as HTMLElement | null;
    const img = target?.closest('img');

    if (img && editor.value?.contains(img)) {
        activeImage.value = img as HTMLImageElement;
        updateDeleteButtonPosition();
    }
};

const deleteSelectedImage = (): void => {
    if (!activeImage.value) {
        return;
    }

    const img = activeImage.value;
    const figure = img.closest('figure');
    const grid = img.closest('.photo-grid');
    const parentP = img.closest('p');

    if (figure) {
        figure.remove();
    } else {
        img.remove();
    }

    if (grid) {
        const remainingImages = grid.querySelectorAll('img');
        if (remainingImages.length === 0) {
            grid.remove();
        } else if (remainingImages.length === 1) {
            grid.setAttribute('data-columns', '1');
        } else if (remainingImages.length === 2) {
            grid.setAttribute('data-columns', '2');
        }
    } else if (parentP && parentP.innerHTML.trim() === '') {
        parentP.remove();
    }

    activeImage.value = null;
    deleteBtnPos.value = null;
    isOverDeleteBtn.value = false;
    updateValue();
};

const handleEditorKeyDown = (event: KeyboardEvent): void => {
    if ((event.key === 'Backspace' || event.key === 'Delete') && activeImage.value) {
        event.preventDefault();
        deleteSelectedImage();
    }
};

onMounted(() => {
    syncEditorHtml(props.modelValue);
    window.addEventListener('resize', updateDeleteButtonPosition);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', updateDeleteButtonPosition);
});

watch(
    () => props.modelValue,
    (value) => syncEditorHtml(value),
);
</script>

<template>
    <div class="grid gap-2">
        <div class="flex items-center justify-between">
            <Label :for="id">{{ label }}</Label>
            <div
                v-if="isUploading"
                class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400"
            >
                <Loader2 class="size-3.5 animate-spin text-[#9b1c31]" />
                <span>{{ uploadStatus }}</span>
            </div>
        </div>

        <div
            ref="editorContainer"
            class="relative rounded-md border border-input bg-background shadow-xs"
            @mouseleave="handleEditorMouseLeave"
        >
            <div
                class="flex flex-wrap items-center gap-1 border-b border-input p-2"
            >
                <Button
                    v-for="item in commands"
                    :key="`${item.command}-${item.value ?? ''}`"
                    type="button"
                    variant="ghost"
                    size="icon"
                    :disabled="isUploading"
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
                    :disabled="isUploading"
                    class="size-8"
                    @click="createLink"
                >
                    <Link class="size-4" />
                    <span class="sr-only">Link</span>
                </Button>

                <template v-if="enableImages">
                    <div class="mx-1 h-5 w-px bg-border" aria-hidden="true" />

                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        title="Photo grid"
                        :disabled="isUploading"
                        class="size-8"
                        @click="chooseImages('grid')"
                    >
                        <LayoutGrid class="size-4" />
                        <span class="sr-only">Photo grid</span>
                    </Button>

                    <input
                        ref="imageInput"
                        type="file"
                        accept="image/jpeg,image/png,image/webp,image/jpg"
                        multiple
                        class="hidden"
                        @change="handleImagesSelected"
                    />
                </template>
            </div>

            <div
                v-if="uploadError"
                class="border-b border-rose-200 bg-rose-50 px-3 py-2 text-xs font-medium text-rose-700 dark:border-rose-900/40 dark:bg-rose-950/20 dark:text-rose-300"
            >
                {{ uploadError }}
            </div>

            <!-- Floating Delete Option for Active/Hovered Photo -->
            <button
                v-if="activeImage && deleteBtnPos"
                type="button"
                class="absolute z-30 inline-flex items-center gap-1.5 rounded-md bg-rose-600 px-2.5 py-1 text-xs font-semibold text-white shadow-lg transition-all hover:bg-rose-700 hover:scale-105 active:scale-95 focus:outline-none"
                :style="{
                    top: `${deleteBtnPos.top}px`,
                    left: `${deleteBtnPos.left}px`,
                }"
                title="Delete this photo"
                @mouseenter="isOverDeleteBtn = true"
                @mouseleave="isOverDeleteBtn = false"
                @click="deleteSelectedImage"
            >
                <Trash2 class="size-3.5" />
                <span>Delete</span>
            </button>

            <div
                :id="id"
                ref="editor"
                contenteditable="true"
                class="min-h-72 w-full overflow-y-auto px-3 py-2 text-sm leading-7 outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 [&_blockquote]:border-l-4 [&_blockquote]:pl-4 [&_h2]:text-xl [&_h2]:font-semibold [&_img]:my-4 [&_img]:max-h-[32rem] [&_img]:max-w-full [&_img]:rounded-md [&_img]:object-contain [&_ol]:list-decimal [&_ol]:pl-6 [&_ul]:list-disc [&_ul]:pl-6"
                role="textbox"
                aria-multiline="true"
                @input="updateValue"
                @blur="updateValue"
                @mousemove="handleEditorMouseMove"
                @click="handleEditorClick"
                @keydown="handleEditorKeyDown"
                @scroll="updateDeleteButtonPosition"
            ></div>
        </div>
    </div>
</template>
