<script setup lang="ts">
import {
    publicSiteCertificationLinks,
    publicSiteFooterContactItems,
    publicSiteFooterOfficeContactColumns,
    publicSiteFooterSocialLinks,
    publicSiteGovernanceSealLinks,
} from '@/components/public-site/public-site-footer';
import PublicSiteLink from '@/components/public-site/PublicSiteLink.vue';

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer
        id="footer"
        class="border-t border-[#1711d4] bg-white text-slate-950 dark:bg-slate-950 dark:text-white"
    >
        <div
            class="mx-auto grid w-full max-w-7xl gap-12 px-4 pt-10 pb-5 sm:px-6 md:grid-cols-[minmax(0,0.95fr)_minmax(0,1.15fr)] md:items-start md:gap-16 lg:px-8"
        >
            <section
                class="grid content-start justify-items-start gap-2"
                aria-labelledby="footer-university"
            >
                <img
                    src="/storage/images/branding/logos/nemsu-logo.png"
                    alt="NEMSU seal"
                    class="size-24 shrink-0 object-contain"
                />
                <h3
                    id="footer-university"
                    class="max-w-md mt-2 font-academic leading-[1.15] font-extrabold tracking-wide text-[#08045f] dark:text-white"
                >
                    North Eastern Mindanao <br />
                    State University
                </h3>
                <div class="grid gap-1">
                    <component
                        :is="item.href ? 'a' : 'p'"
                        v-for="item in publicSiteFooterContactItems"
                        :key="item.label"
                        :href="item.href"
                        class="max-w-sm text-sm leading-6 text-slate-600 not-italic transition hover:text-[#1711d4] dark:text-slate-300 dark:hover:text-sky-200"
                    >
                        {{ item.value }}
                    </component>
                </div>
                <div
                    class="h-px mt-2 mb-3 w-full max-w-sm bg-slate-200 dark:bg-white/15"
                    aria-hidden="true"
                ></div>
                <div
                    class="flex flex-wrap items-center gap-3"
                    aria-label="University certifications and governance"
                >
                    <PublicSiteLink
                        v-for="certification in publicSiteCertificationLinks"
                        :key="certification.label"
                        :href="certification.href"
                        :external="certification.external"
                        :target="certification.external ? '_blank' : undefined"
                        :rel="certification.external ? 'noopener' : undefined"
                        class="rounded-sm transition hover:opacity-80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1711d4]"
                        :aria-label="certification.label"
                    >
                        <img
                            :src="certification.image"
                            :alt="certification.imageAlt"
                            class="h-14 w-auto object-contain sm:h-14"
                        />
                    </PublicSiteLink>
                    <PublicSiteLink
                        v-for="seal in publicSiteGovernanceSealLinks"
                        :key="seal.label"
                        :href="seal.href"
                        :external="seal.external"
                        :target="seal.external ? '_blank' : undefined"
                        :rel="seal.external ? 'noopener' : undefined"
                        class="rounded-full transition hover:opacity-80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1711d4]"
                        :aria-label="seal.label"
                    >
                        <img
                            :src="seal.image"
                            :alt="seal.imageAlt"
                            class="size-14 object-contain sm:size-14"
                        />
                    </PublicSiteLink>
                </div>
            </section>

            <section aria-labelledby="footer-contact-information">
                <h3
                    id="footer-contact-information"
                    class="font-academic font-semibold tracking-wide text-[#08045f] dark:text-white"
                >
                    Contact Information
                </h3>
                <div class="mt-8 grid gap-4 lg:grid-cols-2 lg:gap-x-10">
                    <div
                        v-for="(
                            contactColumn, columnIndex
                        ) in publicSiteFooterOfficeContactColumns"
                        :key="columnIndex"
                        class="grid content-start gap-4"
                    >
                        <a
                            v-for="contact in contactColumn"
                            :key="contact.office"
                            :href="contact.href"
                            class="group flex items-start gap-2.5 rounded-sm text-sm text-slate-600 transition hover:text-[#1711d4] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1711d4] dark:text-slate-300 dark:hover:text-sky-200"
                        >
                            <span
                                class="inline-flex size-10 shrink-0 items-center justify-center rounded-full bg-[#efefff] text-[#1711d4] transition group-hover:bg-[#1711d4] group-hover:text-white dark:bg-white/10 dark:text-sky-200"
                            >
                                <component
                                    :is="contact.icon"
                                    class="size-3.5"
                                    aria-hidden="true"
                                />
                            </span>
                            <span class="min-w-0">
                                <span
                                    class="block font-semibold tracking-wide text-[#08045f] dark:text-white"
                                >
                                    {{ contact.office }}
                                </span>
                                <span
                                    class="mt-1 block leading-6 text-slate-500 dark:text-slate-400"
                                >
                                    {{ contact.value }}
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </section>
        </div>

        <div
            class="relative h-7 overflow-hidden sm:h-9"
            aria-hidden="true"
            data-footer-wave
        >
            <svg
                class="absolute inset-0 size-full"
                viewBox="0 0 1440 40"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill="#08045f"
                    d="M0 8C220 37 440 27 650 16C906 2 1130 0 1440 22V40H0Z"
                />
            </svg>
        </div>
        <div class="bg-brand-navy text-white">
            <div
                class="mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-4 px-4 pt-1 pb-5 text-center sm:flex-row sm:px-6 sm:text-left lg:px-8"
            >
                <p class="text-xs leading-4 text-white/90">
                    © {{ currentYear }} North Eastern Mindanao State University.
                    All rights reserved.
                </p>
                <div
                    class="flex items-center gap-5"
                    aria-label="Official social media"
                >
                    <template
                        v-for="social in publicSiteFooterSocialLinks"
                        :key="social.label"
                    >
                        <a
                            v-if="social.href"
                            :href="social.href"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex size-5 items-center justify-center text-white transition hover:text-white/70 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white"
                            :aria-label="social.label"
                        >
                            <component
                                :is="social.icon"
                                class="size-4"
                                aria-hidden="true"
                            />
                        </a>
                        <span
                            v-else
                            class="inline-flex size-5 items-center justify-center text-white"
                            aria-hidden="true"
                        >
                            <component :is="social.icon" class="size-4" />
                        </span>
                    </template>
                </div>
            </div>
        </div>
    </footer>
</template>
