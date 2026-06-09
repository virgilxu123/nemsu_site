<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, CalendarDays } from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';

type BannerArticle = {
    id: number;
    title: string;
    contentHtml: string;
    imageUrl: string;
    publishedAt: string | null;
};

const props = defineProps<{
    banner: BannerArticle;
}>();
</script>

<template>
    <PublicSiteLayout>
        <Head :title="props.banner.title" />

        <article class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <header class="relative isolate overflow-hidden bg-slate-950 text-white">
                <img
                    :src="props.banner.imageUrl"
                    :alt="props.banner.title"
                    class="absolute inset-0 h-full w-full object-cover opacity-60"
                />
                <div
                    class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/80 to-slate-950/20"
                ></div>

                <div
                    class="relative mx-auto flex min-h-[64svh] max-w-6xl flex-col justify-between px-4 py-8 sm:px-6 lg:px-8"
                >
                    <Link
                        :href="home()"
                        class="inline-flex w-fit items-center gap-2 rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm font-semibold text-white/90 backdrop-blur transition hover:bg-white/15 hover:text-white"
                    >
                        <ArrowLeft class="size-4" aria-hidden="true" />
                        Back
                    </Link>

                    <div class="max-w-4xl py-12">
                        <div class="mb-6 h-1 w-16 bg-[#f2b705]"></div>
                        <p
                            v-if="props.banner.publishedAt"
                            class="inline-flex items-center gap-2 text-sm font-medium text-white/80"
                        >
                            <CalendarDays class="size-4" aria-hidden="true" />
                            {{ props.banner.publishedAt }}
                        </p>
                        <h1
                            class="mt-5 text-4xl leading-tight font-semibold tracking-normal text-balance sm:text-5xl lg:text-6xl"
                        >
                            {{ props.banner.title }}
                        </h1>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-3xl px-4 py-12 sm:py-16">
                <div
                    class="max-w-none text-base leading-8 text-slate-700 dark:text-slate-200 [&_a]:font-medium [&_a]:text-emerald-700 [&_a]:underline [&_a]:underline-offset-4 dark:[&_a]:text-emerald-300 [&_blockquote]:border-l-4 [&_blockquote]:border-emerald-600 [&_blockquote]:pl-5 [&_h2]:mt-10 [&_h2]:text-2xl [&_h2]:font-semibold [&_h3]:mt-8 [&_h3]:text-xl [&_h3]:font-semibold [&_h4]:mt-6 [&_h4]:text-lg [&_h4]:font-semibold [&_li]:my-1 [&_ol]:my-5 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:my-5 [&_ul]:my-5 [&_ul]:list-disc [&_ul]:pl-6"
                    v-html="props.banner.contentHtml"
                ></div>
            </main>
        </article>
    </PublicSiteLayout>
</template>
