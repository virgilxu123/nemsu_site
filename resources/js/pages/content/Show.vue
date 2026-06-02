<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLogo from '@/components/AppLogo.vue';
import { home } from '@/routes';
import type { SharedNavigation } from '@/types';

type ContentPage = {
    id: string;
    title: string;
    slug: string;
    section: string | null;
    excerpt: string | null;
    body: string | null;
    publishedAt: string | null;
};

const props = defineProps<{
    page: ContentPage;
}>();

const pageProps = usePage<{
    navigation: SharedNavigation;
}>();

const isExternalUrl = (url: string): boolean => /^https?:\/\//.test(url);
</script>

<template>
    <Head :title="props.page.title" />

    <div
        class="min-h-screen bg-white text-slate-950 dark:bg-slate-950 dark:text-white"
    >
        <header class="border-b border-slate-200 dark:border-white/10">
            <div
                class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4"
            >
                <Link :href="home()" class="flex items-center gap-3">
                    <AppLogo />
                </Link>

                <nav
                    v-if="pageProps.props.navigation.main.length > 0"
                    class="flex flex-wrap items-center gap-3 text-sm font-medium"
                >
                    <template
                        v-for="item in pageProps.props.navigation.main"
                        :key="item.id"
                    >
                        <a
                            v-if="isExternalUrl(item.url)"
                            :href="item.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-slate-700 hover:text-slate-950 dark:text-slate-300 dark:hover:text-white"
                        >
                            {{ item.label }}
                        </a>
                        <Link
                            v-else
                            :href="item.url"
                            class="text-slate-700 hover:text-slate-950 dark:text-slate-300 dark:hover:text-white"
                        >
                            {{ item.label }}
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-3xl px-4 py-12 sm:py-16">
            <div class="mb-8 grid gap-3">
                <p
                    v-if="props.page.section"
                    class="text-sm font-medium tracking-wide text-slate-500 uppercase dark:text-slate-400"
                >
                    {{ props.page.section }}
                </p>
                <h1 class="text-4xl font-semibold tracking-normal sm:text-5xl">
                    {{ props.page.title }}
                </h1>
                <p
                    v-if="props.page.excerpt"
                    class="text-lg leading-8 text-slate-600 dark:text-slate-300"
                >
                    {{ props.page.excerpt }}
                </p>
                <p
                    v-if="props.page.publishedAt"
                    class="text-sm text-slate-500 dark:text-slate-400"
                >
                    Published {{ props.page.publishedAt }}
                </p>
            </div>

            <article
                class="max-w-none text-base leading-8 text-slate-700 dark:text-slate-200 [&_a]:font-medium [&_a]:text-emerald-700 [&_a]:underline [&_a]:underline-offset-4 dark:[&_a]:text-emerald-300 [&_blockquote]:border-l-4 [&_blockquote]:border-emerald-600 [&_blockquote]:pl-5 [&_h2]:mt-10 [&_h2]:text-2xl [&_h2]:font-semibold [&_h3]:mt-8 [&_h3]:text-xl [&_h3]:font-semibold [&_li]:my-1 [&_ol]:my-5 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:my-5 [&_ul]:my-5 [&_ul]:list-disc [&_ul]:pl-6"
                v-html="props.page.body"
            ></article>
        </main>

        <footer
            v-if="pageProps.props.navigation.footer.length > 0"
            class="border-t border-slate-200 dark:border-white/10"
        >
            <nav
                class="mx-auto flex max-w-6xl flex-wrap items-center gap-4 px-4 py-6 text-sm text-slate-600 dark:text-slate-300"
            >
                <template
                    v-for="item in pageProps.props.navigation.footer"
                    :key="item.id"
                >
                    <a
                        v-if="isExternalUrl(item.url)"
                        :href="item.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:text-slate-950 dark:hover:text-white"
                    >
                        {{ item.label }}
                    </a>
                    <Link
                        v-else
                        :href="item.url"
                        class="hover:text-slate-950 dark:hover:text-white"
                    >
                        {{ item.label }}
                    </Link>
                </template>
            </nav>
        </footer>
    </div>
</template>
