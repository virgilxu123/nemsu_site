<script setup lang="ts">
import PublicSiteFooter from '@/components/public-site/PublicSiteFooter.vue';
import PublicSiteHeader from '@/components/public-site/PublicSiteHeader.vue';
import SeoHead from '@/components/public-site/SeoHead.vue';
</script>

<template>
    <SeoHead />

    <div
        class="public-site min-h-screen bg-[#f7f8f5] text-slate-950 dark:bg-slate-950 dark:text-white"
    >
        <PublicSiteHeader />

        <main>
            <slot />
        </main>

        <PublicSiteFooter />
    </div>
</template>
