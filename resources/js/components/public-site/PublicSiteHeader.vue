<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { Menu, Search, UserRound, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import {
    publicSiteDashboard,
    publicSiteHome,
    publicSiteNavigationGroups,
    publicSiteUtilityLinks,
} from '@/components/public-site/public-site-navigation';
import PublicNewsTicker from '@/components/public-site/PublicNewsTicker.vue';
import PublicSiteDesktopNavigation from '@/components/public-site/PublicSiteDesktopNavigation.vue';
import PublicSiteLink from '@/components/public-site/PublicSiteLink.vue';
import PublicSiteMobileNavigation from '@/components/public-site/PublicSiteMobileNavigation.vue';

const page = usePage();
const mobileOpen = ref(false);

const publicNewsTicker = computed(() => page.props.publicNewsTicker ?? []);

const closeMobileMenu = (): void => {
    mobileOpen.value = false;
};
</script>

<template>
    <header
        class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur dark:border-white/10 dark:bg-slate-950/95"
    >
        <div
            class="border-b border-slate-200/70 bg-[#1711d4] text-white dark:border-white/10"
        >
            <div
                class="mx-auto flex h-10 max-w-7xl items-center justify-between gap-4 px-4 text-xs sm:px-6 lg:px-8"
            >
                <PublicNewsTicker :items="publicNewsTicker" />
                <nav
                    class="flex min-w-0 flex-1 items-center justify-end gap-1 sm:flex-none"
                >
                    <PublicSiteLink
                        v-for="link in publicSiteUtilityLinks"
                        :key="link.label"
                        :href="link.href"
                        :external="link.external"
                        class="rounded px-2.5 py-1 text-white/85 transition hover:bg-white/10 hover:text-white"
                    >
                        {{ link.label }}
                    </PublicSiteLink>
                </nav>
            </div>
        </div>

        <div
            class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
        >
            <PublicSiteLink
                :href="publicSiteHome.url()"
                class="flex min-w-0 items-center gap-3"
            >
                <img
                    src="/storage/images/branding/logos/nemsu-logo.png"
                    alt="NEMSU seal"
                    class="h-12 w-12 shrink-0 rounded-full bg-white object-contain ring-1 ring-slate-200"
                />
                <span class="min-w-0">
                    <span
                        class="block text-2xl leading-none font-bold tracking-wide text-[#1711d4] uppercase dark:text-sky-200"
                    >
                        NEMSU
                    </span>
                    <span
                        class="block truncate text-xs text-slate-600 dark:text-slate-300 font-bold"
                    >
                        Walk a journey of Excellence and Success
                    </span>
                </span>
            </PublicSiteLink>

            <PublicSiteDesktopNavigation :groups="publicSiteNavigationGroups" />

            <div class="hidden items-center gap-2 xl:flex">
                <button
                    type="button"
                    class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-700 transition hover:bg-slate-100 dark:border-white/10 dark:text-slate-200 dark:hover:bg-white/10"
                    aria-label="Search"
                >
                    <Search class="size-4" aria-hidden="true" />
                </button>
                <PublicSiteLink
                    v-if="page.props.auth.user"
                    :href="publicSiteDashboard.url()"
                    class="inline-flex h-10 items-center gap-2 rounded-md bg-[#1711d4] px-4 text-sm font-semibold text-white transition hover:bg-[#0f0ab8]"
                >
                    <UserRound class="size-4" aria-hidden="true" />
                    Dashboard
                </PublicSiteLink>
                <!-- Login removed per request -->
            </div>

            <button
                type="button"
                class="inline-flex size-10 items-center justify-center rounded-md border border-slate-200 text-slate-800 xl:hidden dark:border-white/10 dark:text-white"
                aria-label="Toggle menu"
                :aria-expanded="mobileOpen"
                @click="mobileOpen = !mobileOpen"
            >
                <X v-if="mobileOpen" class="size-5" aria-hidden="true" />
                <Menu v-else class="size-5" aria-hidden="true" />
            </button>
        </div>

        <PublicSiteMobileNavigation
            v-if="mobileOpen"
            :groups="publicSiteNavigationGroups"
            @navigate="closeMobileMenu"
        />
    </header>
</template>
