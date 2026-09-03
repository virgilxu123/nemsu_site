<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ArrowRight,
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    Images,
    Megaphone,
    X,
} from 'lucide-vue-next';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { index as newsIndex, show as newsShow } from '@/routes/news';

type GalleryImage = {
    url: string;
    alt: string;
};

type NewsArticle = {
    id: string;
    type: string;
    title: string;
    slug: string;
    excerpt?: string | null;
    contentHtml: string;
    galleryImages: GalleryImage[];
    date: string | null;
    office: string;
    photoUrl?: string | null;
};

type NewsItem = Omit<NewsArticle, 'contentHtml'>;

const props = defineProps<{
    article: NewsArticle;
    latestNews: NewsItem[];
}>();

/* eslint-disable @stylistic/padding-line-between-statements */
const goBack = () => {
    const target = `${home().url}#news`;

    try {
        const sameOriginReferrer =
            typeof document !== 'undefined' &&
            !!document.referrer &&
            document.referrer.startsWith(window.location.origin);

        if (
            sameOriginReferrer ||
            (typeof window !== 'undefined' && window.history.length > 1)
        ) {
            window.history.back();
            return;
        }
    } catch {
        // fallback to router visit below
    }

    router.visit(target, {
        onSuccess: () => {
            const el = document.getElementById('news');

            if (!el) {
                return;
            }

            el.setAttribute('tabindex', '-1');
            el.focus();

            try {
                el.scrollIntoView({ behavior: 'smooth' });
            } catch {
                // ignore
            }
        },
    });
};
/* eslint-enable @stylistic/padding-line-between-statements */

const selectedGalleryImageIndex = ref<number | null>(null);

const selectedGalleryImage = computed(() =>
    selectedGalleryImageIndex.value === null
        ? null
        : props.article.galleryImages[selectedGalleryImageIndex.value],
);

const openGalleryImage = (index: number): void => {
    selectedGalleryImageIndex.value = index;
};

const closeGallery = (): void => {
    selectedGalleryImageIndex.value = null;
};

const showPreviousGalleryImage = (): void => {
    if (props.article.galleryImages.length === 0) {
        return;
    }

    selectedGalleryImageIndex.value =
        ((selectedGalleryImageIndex.value ?? 0) -
            1 +
            props.article.galleryImages.length) %
        props.article.galleryImages.length;
};

const showNextGalleryImage = (): void => {
    if (props.article.galleryImages.length === 0) {
        return;
    }

    selectedGalleryImageIndex.value =
        ((selectedGalleryImageIndex.value ?? 0) + 1) %
        props.article.galleryImages.length;
};

const handleGalleryKeydown = (event: KeyboardEvent): void => {
    if (selectedGalleryImageIndex.value === null) {
        return;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        closeGallery();

        return;
    }

    if (event.key === 'ArrowLeft') {
        event.preventDefault();
        showPreviousGalleryImage();

        return;
    }

    if (event.key === 'ArrowRight') {
        event.preventDefault();
        showNextGalleryImage();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleGalleryKeydown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleGalleryKeydown);
});
</script>

<template>
    <PublicSiteLayout>
        <Head :title="props.article.title" />

        <article class="bg-[#f7f8f5] dark:bg-slate-950">
            <header
                class="relative isolate overflow-hidden bg-[#06131f] text-white"
            >
                <img
                    v-if="props.article.photoUrl"
                    :src="props.article.photoUrl"
                    :alt="props.article.title"
                    width="1600"
                    height="900"
                    decoding="async"
                    fetchpriority="high"
                    class="absolute inset-0 h-full w-full object-cover opacity-60"
                />
                <div
                    v-else
                    class="absolute inset-0 grid place-items-center bg-[#1711d4]"
                >
                    <Megaphone
                        class="size-20 text-white/30"
                        aria-hidden="true"
                    />
                </div>
                <div
                    class="absolute inset-0 bg-linear-to-t from-[#06131f] via-[#06131f]/80 to-[#06131f]/20"
                ></div>

                <div
                    class="relative mx-auto flex min-h-[72svh] max-w-7xl flex-col justify-between px-4 py-8 sm:px-6 lg:px-8"
                >
                    <div
                        class="flex flex-wrap items-center justify-between gap-4"
                    >
                        <button
                            type="button"
                            @click="goBack"
                            aria-label="Return to previous page or News section"
                            class="inline-flex w-fit items-center gap-2 rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm font-semibold text-white/90 backdrop-blur transition hover:bg-white/15 hover:text-white"
                        >
                            <ArrowLeft class="size-4" aria-hidden="true" />
                            Back
                        </button>

                        <nav
                            aria-label="Breadcrumb"
                            class="flex min-w-0 items-center gap-2 text-sm text-white/70"
                        >
                            <Link
                                :href="home()"
                                class="transition hover:text-white"
                            >
                                Home
                            </Link>
                            <span aria-hidden="true">/</span>
                            <Link
                                :href="newsIndex()"
                                class="transition hover:text-white"
                            >
                                Newsroom
                            </Link>
                            <span aria-hidden="true">/</span>
                            <span
                                class="max-w-48 truncate text-white sm:max-w-80"
                                aria-current="page"
                            >
                                {{ props.article.title }}
                            </span>
                        </nav>
                    </div>

                    <div class="grid gap-8 py-12 lg:grid-cols-[1fr_18rem]">
                        <div class="max-w-5xl">
                            <div class="mb-6 h-1 w-16 bg-[#f2b705]"></div>
                            <div
                                class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs font-medium text-white/80"
                            >
                                <span
                                    class="rounded bg-[#9b1c31] px-2.5 py-1 text-white shadow-sm"
                                >
                                    {{ props.article.type }}
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <CalendarDays
                                        class="size-3.5"
                                        aria-hidden="true"
                                    />
                                    {{ props.article.date }}
                                </span>
                                <span>{{ props.article.office }}</span>
                            </div>

                            <h1
                                class="mt-5 max-w-5xl font-academic text-[1.875rem] leading-[1.2] font-semibold tracking-[-0.025em] text-balance md:text-uni-h1"
                            >
                                {{ props.article.title }}
                            </h1>

                            <p
                                v-if="props.article.excerpt"
                                class="mt-6 max-w-3xl text-base leading-8 text-white/80 sm:text-lg"
                            >
                                {{ props.article.excerpt }}
                            </p>
                        </div>

                        <aside
                            class="hidden self-end border-t border-white/20 pt-5 text-uni-micro text-white/70 lg:block"
                        >
                            <p class="font-semibold text-white">
                                {{ props.article.office }}
                            </p>
                            <p class="mt-2">
                                Published
                                <span class="text-white">{{
                                    props.article.date
                                }}</span>
                            </p>
                        </aside>
                    </div>
                </div>
            </header>

            <div
                class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[minmax(0,1fr)_21rem] lg:px-8"
            >
                <main class="min-w-0">
                    <div
                        class="mx-auto mb-8 flex max-w-[70ch] flex-wrap items-center gap-x-4 gap-y-2 border-b border-slate-200 pb-6 text-uni-micro text-slate-500 dark:border-white/10 dark:text-slate-400"
                    >
                        <span
                            class="font-semibold text-slate-950 dark:text-white"
                        >
                            {{ props.article.office }}
                        </span>
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                        <span>{{ props.article.date }}</span>
                    </div>

                    <section
                        v-if="props.article.galleryImages.length > 0"
                        class="mx-auto mb-8 max-w-3xl rounded-md border border-slate-200 bg-white p-4 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                        aria-label="Article photos"
                    >
                        <div
                            class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center"
                        >
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex size-10 items-center justify-center rounded-md bg-[#f8e7eb] text-[#9b1c31] dark:bg-rose-400/10 dark:text-rose-200"
                                >
                                    <Images class="size-5" aria-hidden="true" />
                                </span>
                                <div>
                                    <h2
                                        class="font-sans text-uni-micro font-semibold text-slate-950 dark:text-white"
                                    >
                                        Article photos
                                    </h2>
                                    <p
                                        class="mt-0.5 text-xs text-slate-500 dark:text-slate-400"
                                    >
                                        {{ props.article.galleryImages.length }}
                                        image{{
                                            props.article.galleryImages
                                                .length === 1
                                                ? ''
                                                : 's'
                                        }}
                                        available
                                    </p>
                                </div>
                            </div>
                            <button
                                type="button"
                                class="inline-flex h-10 items-center justify-center rounded-md border border-slate-200 px-3 text-sm font-semibold text-[#1711d4] transition hover:border-[#0b6680] hover:text-[#0b6680] dark:border-white/10 dark:text-sky-100 dark:hover:border-sky-300"
                                @click="openGalleryImage(0)"
                            >
                                View all
                            </button>
                        </div>

                        <div class="mt-4 overflow-x-auto">
                            <div class="flex gap-3 pb-1">
                                <button
                                    v-for="(image, index) in props.article
                                        .galleryImages"
                                    :key="image.url"
                                    type="button"
                                    class="group relative h-24 w-36 shrink-0 overflow-hidden rounded-md border border-slate-200 bg-slate-100 text-left transition hover:border-[#9b1c31]/50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0b6680] dark:border-white/10 dark:bg-white/10"
                                    @click="openGalleryImage(index)"
                                >
                                    <img
                                        :src="image.url"
                                        :alt="image.alt"
                                        width="288"
                                        height="192"
                                        loading="lazy"
                                        decoding="async"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                    />
                                    <span
                                        v-if="index === 0"
                                        class="absolute bottom-2 left-2 rounded bg-slate-950/75 px-2 py-1 text-[11px] font-semibold text-white"
                                    >
                                        Open gallery
                                    </span>
                                </button>
                            </div>
                        </div>
                    </section>

                    <div
                        class="mx-auto max-w-[70ch] text-uni-body text-slate-700 dark:text-slate-200 [&_a]:font-semibold [&_a]:text-[#0b6680] hover:[&_a]:text-[#9b1c31] dark:[&_a]:text-sky-200 [&_blockquote]:my-9 [&_blockquote]:border-l-4 [&_blockquote]:border-[#9b1c31] [&_blockquote]:bg-white [&_blockquote]:py-4 [&_blockquote]:pr-5 [&_blockquote]:pl-5 [&_blockquote]:text-uni-body [&_blockquote]:font-medium [&_blockquote]:text-slate-700 dark:[&_blockquote]:bg-white/5 dark:[&_blockquote]:text-slate-200 [&_br]:my-2 [&_h2]:mt-12 [&_h2]:font-academic [&_h2]:text-[1.5rem] [&_h2]:leading-[1.3] [&_h2]:font-semibold [&_h2]:tracking-[-0.02em] [&_h2]:text-slate-950 md:[&_h2]:text-uni-h2 dark:[&_h2]:text-white [&_h3]:mt-9 [&_h3]:font-academic [&_h3]:text-[1.125rem] [&_h3]:leading-[1.4] [&_h3]:font-semibold [&_h3]:tracking-[-0.01em] [&_h3]:text-slate-950 md:[&_h3]:text-uni-h3 dark:[&_h3]:text-white [&_img]:my-8 [&_img]:max-h-[44rem] [&_img]:w-full [&_img]:rounded-xl [&_img]:object-contain [&_li]:my-2 [&_ol]:my-6 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:my-6 [&_strong]:font-semibold [&_ul]:my-6 [&_ul]:list-disc [&_ul]:pl-6"
                        v-html="props.article.contentHtml"
                    ></div>
                </main>

                <aside
                    class="grid content-start gap-5 border-t border-slate-200 pt-6 lg:sticky lg:top-28 lg:border-t-0 lg:pt-0 dark:border-white/10"
                >
                    <div
                        class="border-b border-slate-200 pb-4 dark:border-white/10"
                    >
                        <p
                            class="text-uni-micro font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Latest News
                        </p>
                        <h2
                            class="mt-2 font-sans text-xl leading-tight font-semibold text-slate-950 dark:text-white"
                        >
                            More from NEMSU
                        </h2>
                    </div>

                    <Link
                        v-for="item in props.latestNews"
                        :key="item.id"
                        :href="newsShow(item.slug)"
                        class="group grid grid-cols-[5.5rem_1fr] gap-3 border-b border-slate-200 pb-4 transition last:border-b-0 hover:border-[#9b1c31]/45 dark:border-white/10"
                    >
                        <div
                            class="overflow-hidden rounded-md bg-slate-100 dark:bg-white/10"
                        >
                            <img
                                v-if="item.photoUrl"
                                :src="item.photoUrl"
                                :alt="item.title"
                                width="640"
                                height="480"
                                loading="lazy"
                                decoding="async"
                                class="aspect-[4/3] h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                            />
                            <div
                                v-else
                                class="grid aspect-[4/3] place-items-center text-[#9b1c31] dark:text-rose-200"
                            >
                                <Megaphone class="size-5" aria-hidden="true" />
                            </div>
                        </div>
                        <div class="min-w-0">
                            <p
                                class="text-uni-micro font-medium text-slate-500 dark:text-slate-400"
                            >
                                {{ item.date }}
                            </p>
                            <h3
                                class="mt-1 line-clamp-2 font-sans text-uni-micro font-semibold text-slate-950 transition group-hover:text-[#1711d4] dark:text-white dark:group-hover:text-sky-100"
                            >
                                {{ item.title }}
                            </h3>
                        </div>
                    </Link>

                    <Link
                        :href="newsIndex()"
                        class="group inline-flex min-h-12 items-center justify-between gap-3 rounded-md border border-[#9b1c31]/25 bg-white px-4 py-3 text-sm font-semibold text-[#1711d4] shadow-sm shadow-slate-900/5 transition hover:border-[#9b1c31]/50 hover:bg-[#fff8f9] dark:border-rose-300/25 dark:bg-white/5 dark:text-sky-100 dark:hover:border-rose-200/50 dark:hover:bg-white/[0.08]"
                    >
                        <span class="min-w-0">
                            <span class="block">See more news</span>
                            <span
                                class="mt-0.5 block text-xs font-medium text-slate-500 dark:text-slate-400"
                            >
                                Browse the full NEMSU newsroom
                            </span>
                        </span>
                        <span
                            class="inline-flex size-9 shrink-0 items-center justify-center rounded-md bg-[#1711d4] text-white transition group-hover:bg-[#9b1c31]"
                        >
                            <ArrowRight
                                class="size-4 transition group-hover:translate-x-1"
                                aria-hidden="true"
                            />
                        </span>
                    </Link>
                </aside>
            </div>

            <div
                v-if="selectedGalleryImage"
                class="fixed inset-0 z-50 grid bg-slate-950/95 p-4 text-white sm:p-6"
                role="dialog"
                aria-modal="true"
                aria-label="Article photo viewer"
                @click.self="closeGallery"
            >
                <div class="flex items-center justify-between gap-4">
                    <p class="text-sm font-medium text-white/70">
                        Photo
                        {{ (selectedGalleryImageIndex ?? 0) + 1 }} of
                        {{ props.article.galleryImages.length }}
                    </p>
                    <button
                        type="button"
                        class="inline-flex size-10 items-center justify-center rounded-md border border-white/15 text-white/80 transition hover:bg-white/10 hover:text-white"
                        aria-label="Close photo viewer"
                        @click.stop="closeGallery"
                    >
                        <X class="size-5" aria-hidden="true" />
                    </button>
                </div>

                <div
                    class="relative grid min-h-0 place-items-center py-4 sm:py-6"
                >
                    <button
                        v-if="props.article.galleryImages.length > 1"
                        type="button"
                        class="absolute left-0 z-10 inline-flex size-11 items-center justify-center rounded-md border border-white/15 bg-slate-950/60 text-white/80 transition hover:bg-white/10 hover:text-white"
                        aria-label="Previous photo"
                        @click.stop="showPreviousGalleryImage"
                    >
                        <ChevronLeft class="size-5" aria-hidden="true" />
                    </button>

                    <img
                        :src="selectedGalleryImage.url"
                        :alt="selectedGalleryImage.alt"
                        decoding="async"
                        class="max-h-[72svh] max-w-full rounded-md object-contain shadow-2xl shadow-black/40"
                    />

                    <button
                        v-if="props.article.galleryImages.length > 1"
                        type="button"
                        class="absolute right-0 z-10 inline-flex size-11 items-center justify-center rounded-md border border-white/15 bg-slate-950/60 text-white/80 transition hover:bg-white/10 hover:text-white"
                        aria-label="Next photo"
                        @click.stop="showNextGalleryImage"
                    >
                        <ChevronRight class="size-5" aria-hidden="true" />
                    </button>
                </div>

                <div class="mx-auto flex max-w-4xl gap-2 overflow-x-auto pb-1">
                    <button
                        v-for="(image, index) in props.article.galleryImages"
                        :key="image.url"
                        type="button"
                        class="h-16 w-24 shrink-0 overflow-hidden rounded-md border bg-white/5 transition"
                        :class="
                            selectedGalleryImageIndex === index
                                ? 'border-[#f2b705]'
                                : 'border-white/15 hover:border-white/50'
                        "
                        @click.stop="openGalleryImage(index)"
                    >
                        <img
                            :src="image.url"
                            :alt="image.alt"
                            width="192"
                            height="128"
                            loading="lazy"
                            decoding="async"
                            class="h-full w-full object-cover"
                        />
                    </button>
                </div>
            </div>
        </article>
    </PublicSiteLayout>
</template>
