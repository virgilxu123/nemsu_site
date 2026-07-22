<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import PageHero from '@/components/PageHero.vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';

type BoardMember = {
    name: string;
    designation: string;
    boardRole: string;
    photoUrl?: string | null;
};

const failedImages = ref<Set<string>>(new Set());
const heroBackgroundImage = '/storage/images/hero/6I3A5797.JPG';

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
            <PageHero
                title="Board of Regents"
                description="The highest governing body of North Eastern Mindanao State University is the Board of Regents. Its members are drawn from the University, government agencies, and the private and public sectors."
                :breadcrumbs="[
                    { title: 'Home', href: home().url },
                    { title: 'About NEMSU' },
                    { title: 'Board of Regents' }
                ]"
                :backgroundImage="heroBackgroundImage"
            />

            <section class="py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div>
                        <div
                            class="mx-auto grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 dark:border-white/10"
                        >
                            <article
                                v-for="member in boardMembers"
                                :key="`${member.name}-${member.designation}`"
                                class="flex min-h-[19rem] flex-col rounded-lg border border-slate-200 bg-white p-4 text-center shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5"
                            >
                                <div class="flex justify-center">
                                    <img
                                        v-if="
                                            member.photoUrl &&
                                            !failedImages.has(member.name)
                                        "
                                        :src="member.photoUrl"
                                        :alt="member.name"
                                        class="size-24 rounded-full object-cover ring-1 ring-slate-200 dark:ring-white/10"
                                        loading="lazy"
                                        @error="markImageAsFailed(member.name)"
                                    />

                                    <div
                                        v-else
                                        class="flex size-24 items-center justify-center rounded-full bg-slate-100 text-base font-semibold text-slate-500 ring-1 ring-slate-200 dark:bg-white/10 dark:text-slate-300 dark:ring-white/10"
                                        aria-hidden="true"
                                    >
                                        {{ initialsOf(member.name) }}
                                    </div>
                                </div>

                                <div class="mt-4 flex grow flex-col">
                                    <p
                                        class="text-sm leading-5 font-semibold break-words text-slate-900 dark:text-white"
                                    >
                                        {{ member.name }}
                                    </p>

                                    <p
                                        class="mt-3 text-xs leading-5 break-words text-slate-700 dark:text-slate-300"
                                    >
                                        {{ member.designation }}
                                    </p>

                                    <p
                                        class="mt-auto pt-4 text-xs leading-5 font-medium text-[#0b3d91] dark:text-sky-200"
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
