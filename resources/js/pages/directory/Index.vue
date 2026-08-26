<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Mail, Search } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import PageHero from '@/components/PageHero.vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';

type DirectoryEntry = {
    name: string;
    designation: string;
    contact: string;
    email: string;
};

type DirectorySection = {
    heading: string;
    entries: DirectoryEntry[];
};

const props = defineProps<{
    directorySections: DirectorySection[];
}>();

const searchTerm = ref('');

const totalEntries = computed(() =>
    props.directorySections.reduce(
        (total, section) => total + section.entries.length,
        0,
    ),
);

const filteredSections = computed(() => {
    const query = searchTerm.value.trim().toLowerCase();

    if (query === '') {
        return props.directorySections;
    }

    return props.directorySections
        .map((section) => ({
            ...section,
            entries: section.entries.filter((entry) =>
                [entry.name, entry.designation, entry.contact, entry.email]
                    .join(' ')
                    .toLowerCase()
                    .includes(query),
            ),
        }))
        .filter((section) => section.entries.length > 0);
});

const filteredTotal = computed(() =>
    filteredSections.value.reduce(
        (total, section) => total + section.entries.length,
        0,
    ),
);

const displayValue = (value: string): string => {
    const normalized = value.trim();

    return normalized === '' ? '-' : normalized;
};

const hasEmail = (email: string): boolean => {
    const normalized = email.trim();

    return normalized !== '' && normalized !== '-';
};

const mailHref = (email: string): string => `mailto:${email.trim()}`;
</script>

<template>
    <PublicSiteLayout>
        <Head title="Directory" />

        <main
            class="bg-white font-sans text-slate-900 dark:bg-slate-950 dark:text-white"
        >
            <PageHero
                title="University Directory"
                description="The University Directory provides official contact information for North Eastern Mindanao State University offices, academic units, administrative divisions, and designated university personnel. Use this directory to locate offices and personnel by name, designation, contact number, or email address."
                :breadcrumbs="[
                    { title: 'Home', href: home().url },
                    { title: 'Directory' },
                ]"
            />

            <!-- Search and Directory Listings -->
            <section class="py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-5xl">
                        <div
                            class="flex flex-col gap-4 border-y border-slate-200 py-5 md:flex-row md:items-center md:justify-between dark:border-white/10"
                        >
                            <div>
                                <h2
                                    class="text-lg font-medium text-slate-900 dark:text-white"
                                >
                                    Directory Listings
                                </h2>

                                <p
                                    class="mt-1 text-sm leading-6 text-slate-600 dark:text-slate-400"
                                >
                                    Showing {{ filteredTotal }} of
                                    {{ totalEntries }} contacts.
                                </p>
                            </div>

                            <label class="relative block w-full md:max-w-sm">
                                <span class="sr-only">Search directory</span>
                                <Search
                                    class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"
                                    aria-hidden="true"
                                />

                                <input
                                    v-model="searchTerm"
                                    type="search"
                                    class="h-10 w-full rounded border border-slate-300 bg-white pr-3 pl-9 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:border-[#1711d4] focus:ring-1 focus:ring-[#1711d4] dark:border-white/10 dark:bg-white/5 dark:text-white"
                                    placeholder="Search directory"
                                />
                            </label>
                        </div>

                        <div
                            v-if="filteredSections.length === 0"
                            class="border-b border-slate-200 py-12 text-center text-sm text-slate-600 dark:border-white/10 dark:text-slate-300"
                        >
                            No directory entries match your search.
                        </div>

                        <section
                            v-for="section in filteredSections"
                            :key="section.heading"
                            class="py-8"
                        >
                            <div
                                class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between"
                            >
                                <h3
                                    class="text-[18px] font-medium tracking-tight text-slate-900 dark:text-white"
                                >
                                    {{ section.heading }}
                                </h3>

                                <p
                                    class="text-sm text-slate-500 dark:text-slate-400"
                                >
                                    {{ section.entries.length }}
                                    {{
                                        section.entries.length === 1
                                            ? 'entry'
                                            : 'entries'
                                    }}
                                </p>
                            </div>

                            <!-- Desktop Table -->
                            <div class="hidden overflow-x-auto md:block">
                                <table
                                    class="min-w-full border-y border-slate-200 dark:border-white/10"
                                >
                                    <thead>
                                        <tr
                                            class="border-b border-slate-200 dark:border-white/10"
                                        >
                                            <th
                                                scope="col"
                                                class="w-[24%] px-0 py-3 pr-4 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase dark:text-slate-400"
                                            >
                                                Name
                                            </th>
                                            <th
                                                scope="col"
                                                class="w-[34%] px-4 py-3 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase dark:text-slate-400"
                                            >
                                                Office / Designation
                                            </th>
                                            <th
                                                scope="col"
                                                class="w-[18%] px-4 py-3 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase dark:text-slate-400"
                                            >
                                                Contact Number
                                            </th>
                                            <th
                                                scope="col"
                                                class="w-[24%] px-4 py-3 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase dark:text-slate-400"
                                            >
                                                Email Address
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody
                                        class="divide-y divide-slate-200 dark:divide-white/10"
                                    >
                                        <tr
                                            v-for="entry in section.entries"
                                            :key="`${section.heading}-${entry.name}-${entry.designation}`"
                                        >
                                            <td
                                                class="px-0 py-4 pr-4 align-top text-sm font-medium text-slate-900 dark:text-white"
                                            >
                                                {{ displayValue(entry.name) }}
                                            </td>

                                            <td
                                                class="px-4 py-4 align-top text-sm leading-6 text-slate-700 dark:text-slate-300"
                                            >
                                                {{
                                                    displayValue(
                                                        entry.designation,
                                                    )
                                                }}
                                            </td>

                                            <td
                                                class="px-4 py-4 align-top text-sm leading-6 text-slate-700 dark:text-slate-300"
                                            >
                                                {{
                                                    displayValue(entry.contact)
                                                }}
                                            </td>

                                            <td
                                                class="px-4 py-4 align-top text-sm leading-6"
                                            >
                                                <a
                                                    v-if="hasEmail(entry.email)"
                                                    :href="
                                                        mailHref(entry.email)
                                                    "
                                                    class="inline-flex items-start gap-2 font-medium break-all text-[#1711d4] hover:underline dark:text-sky-300"
                                                >
                                                    <Mail
                                                        class="mt-0.5 size-4 shrink-0"
                                                        aria-hidden="true"
                                                    />
                                                    {{ entry.email }}
                                                </a>

                                                <span
                                                    v-else
                                                    class="text-slate-500 dark:text-slate-400"
                                                >
                                                    {{
                                                        displayValue(
                                                            entry.email,
                                                        )
                                                    }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile List -->
                            <div
                                class="divide-y divide-slate-200 border-y border-slate-200 md:hidden dark:divide-white/10 dark:border-white/10"
                            >
                                <article
                                    v-for="entry in section.entries"
                                    :key="`${section.heading}-${entry.name}-${entry.designation}-mobile`"
                                    class="py-5"
                                >
                                    <p
                                        class="text-[15px] leading-6 font-medium text-slate-900 dark:text-white"
                                    >
                                        {{ displayValue(entry.name) }}
                                    </p>

                                    <p
                                        class="mt-1 text-sm leading-6 text-slate-700 dark:text-slate-300"
                                    >
                                        {{ displayValue(entry.designation) }}
                                    </p>

                                    <dl class="mt-3 space-y-2 text-sm">
                                        <div>
                                            <dt
                                                class="font-medium text-slate-500 dark:text-slate-400"
                                            >
                                                Contact Number
                                            </dt>
                                            <dd
                                                class="mt-0.5 text-slate-700 dark:text-slate-300"
                                            >
                                                {{
                                                    displayValue(entry.contact)
                                                }}
                                            </dd>
                                        </div>

                                        <div>
                                            <dt
                                                class="font-medium text-slate-500 dark:text-slate-400"
                                            >
                                                Email Address
                                            </dt>
                                            <dd class="mt-0.5">
                                                <a
                                                    v-if="hasEmail(entry.email)"
                                                    :href="
                                                        mailHref(entry.email)
                                                    "
                                                    class="inline-flex items-start gap-2 font-medium break-all text-[#1711d4] dark:text-sky-300"
                                                >
                                                    <Mail
                                                        class="mt-0.5 size-4 shrink-0"
                                                        aria-hidden="true"
                                                    />
                                                    {{ entry.email }}
                                                </a>

                                                <span
                                                    v-else
                                                    class="text-slate-700 dark:text-slate-300"
                                                >
                                                    {{
                                                        displayValue(
                                                            entry.email,
                                                        )
                                                    }}
                                                </span>
                                            </dd>
                                        </div>
                                    </dl>
                                </article>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>
