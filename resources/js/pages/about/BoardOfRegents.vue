<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import type { BreadcrumbItem } from '@/types';

type BoardMember = {
    name: string;
    designation: string;
    boardRole: string;
    photoUrl?: string | null;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Home', href: '/' },
    { title: 'Administration', href: '/administration' },
    { title: 'Board of Regents', href: '/about/board-of-regents' },
];

const failedImages = ref<Set<string>>(new Set());

const markImageAsFailed = (name: string): void => {
    failedImages.value = new Set([...failedImages.value, name]);
};

const boardMemberPhoto = (fileName: string): string =>
    `/storage/images/governance/board-of-regents/${encodeURIComponent(fileName)}`;

const initialsOf = (name: string): string => {
    if (name.toLowerCase() === 'vacant') {
        return '—';
    }

    return name
        .replace(/^HON\.\s*/i, '')
        .replace(/,.*$/g, '')
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part.charAt(0))
        .join('')
        .toUpperCase();
};

const boardMembers: BoardMember[] = [
    {
        name: 'HON. RICMAR P. AQUINO, PhD',
        designation: 'Commissioner, CHED',
        boardRole: 'Chairperson, NEMSU Board of Regents',
        photoUrl: boardMemberPhoto('Pasted image.png'),
    },
    {
        name: 'HON. NEMESIO G. LOAYON, PhD',
        designation: 'SUC President III, NEMSU',
        boardRole: 'Vice Chairperson, NEMSU Board of Regents',
        photoUrl: boardMemberPhoto('loayon.jpg'),
    },
    {
        name: 'HON. SENATOR LOREN B. LEGARDA',
        designation:
            'Chairman of Senate Committee on Higher, Technical, and Vocational Education',
        boardRole: 'Member',
        photoUrl: null,
    },
    {
        name: 'HON. JUDE A. ACIDRE',
        designation: 'Chairman, House Committee on Higher Technical Education',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('acidre.png'),
    },
    {
        name: 'HON. GEMIMA A. OLAM, EnP, CESO IV',
        designation:
            'Regional Director, Department of Economy, Planning, and Development XIII',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('olam.png'),
    },
    {
        name: 'HON. NOEL M. AJOC',
        designation: 'DOST Regional Director',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('ajoc.png'),
    },
    {
        name: 'Vacant',
        designation: 'Private Sector Representative',
        boardRole: 'Member',
        photoUrl: null,
    },
    {
        name: 'Vacant',
        designation: 'Private Sector Representative',
        boardRole: 'Member',
        photoUrl: null,
    },
    {
        name: 'HON. JOHN FLOR B. RAMAS',
        designation: 'President, Alumni Associations',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('ramas.png'),
    },
    {
        name: 'HON. RUDYARD RYAN T. VERANO',
        designation: 'President, Federation of Faculty Club Associations',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('verano.png'),
    },
    {
        name: 'HON. NEO P. VILLASON',
        designation: 'President, Federation of Supreme Student Government',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('villason.png'),
    },
    {
        name: 'CATHERINE F. SALOMON, PhD(C)',
        designation: 'Board Secretary V',
        boardRole: 'Board Secretary',
        photoUrl: boardMemberPhoto('Pasted image (2).png'),
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="Board of Regents" />

        <main
            class="bg-white font-sans text-slate-900 dark:bg-slate-950 dark:text-white"
        >
            <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>

            <section class="pb-14 pt-8 sm:pb-16 sm:pt-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-5xl">
                        <header
                            class="border-b border-slate-200 pb-4 dark:border-white/10"
                        >
                            <h1
                                class="text-[28px] font-normal leading-tight tracking-tight text-slate-900 sm:text-[32px] dark:text-white"
                            >
                                Board of Regents
                            </h1>
                        </header>

                        <div class="max-w-3xl py-7">
                            <p
                                class="text-[15px] leading-7 text-slate-700 dark:text-slate-300"
                            >
                                The highest governing body of North Eastern
                                Mindanao State University is the Board of
                                Regents. Its members are drawn from the
                                University, government agencies, and the private
                                and public sectors.
                            </p>

                            <p
                                class="mt-4 text-[15px] leading-7 text-slate-700 dark:text-slate-300"
                            >
                                The current Board of Regents is composed of:
                            </p>
                        </div>

                        <div
                            class="divide-y divide-slate-200 border-t border-slate-200 dark:divide-white/10 dark:border-white/10"
                        >
                            <article
                                v-for="member in boardMembers"
                                :key="`${member.name}-${member.designation}`"
                                class="grid gap-4 py-5 sm:grid-cols-[4.75rem_1fr] sm:items-center"
                            >
                                <div class="flex sm:justify-center">
                                    <img
                                        v-if="
                                            member.photoUrl &&
                                            !failedImages.has(member.name)
                                        "
                                        :src="member.photoUrl"
                                        :alt="member.name"
                                        class="size-14 rounded-full object-cover ring-1 ring-slate-200 dark:ring-white/10"
                                        loading="lazy"
                                        @error="markImageAsFailed(member.name)"
                                    />

                                    <div
                                        v-else
                                        class="flex size-14 items-center justify-center rounded-full bg-slate-100 text-[11px] font-medium text-slate-500 ring-1 ring-slate-200 dark:bg-white/10 dark:text-slate-300 dark:ring-white/10"
                                        aria-hidden="true"
                                    >
                                        {{ initialsOf(member.name) }}
                                    </div>
                                </div>

                                <div class="min-w-0">
                                    <p
                                        class="text-[15px] font-medium leading-6 tracking-normal text-slate-900 dark:text-white"
                                    >
                                        {{ member.name }}
                                    </p>

                                    <p
                                        class="mt-0.5 text-sm leading-6 text-slate-700 dark:text-slate-300"
                                    >
                                        {{ member.designation }}
                                    </p>

                                    <p
                                        class="mt-1 text-sm leading-6 text-slate-600 dark:text-slate-400"
                                    >
                                        {{ member.boardRole }}
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>
