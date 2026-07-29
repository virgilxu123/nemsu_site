<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps<{
    href?: string;
    external?: boolean;
}>();

const resolvedHref = computed(() => props.href ?? '#');
</script>

<template>
    <component :is="external ? 'a' : Link" :href="resolvedHref" v-bind="$attrs">
        <slot />
    </component>
</template>
