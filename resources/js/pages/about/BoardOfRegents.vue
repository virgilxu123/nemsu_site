<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import PageHero from '@/components/PageHero.vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';

type BoardMember = {
    id: string;
    name: string;
    designation: string;
    boardRole: string;
    photoUrl?: string | null;
};

type BoardLevel = {
    title: string;
    members: BoardMember[];
    layoutClass: string;
    cardClass: string;
    portraitClass: string;
};

const failedImages = ref<Set<string>>(new Set());

const markImageAsFailed = (memberId: string): void => {
    failedImages.value = new Set([...failedImages.value, memberId]);
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
        id: 'chairperson',
        name: 'HON. RICMAR P. AQUINO, PhD',
        designation: 'Commissioner, CHED',
        boardRole: 'Chairperson, NEMSU Board of Regents',
        photoUrl: boardMemberPhoto('Pasted image.png'),
    },
    {
        id: 'vice-chairperson',
        name: 'HON. NEMESIO G. LOAYON, PhD',
        designation: 'SUC President III, NEMSU',
        boardRole: 'Vice Chairperson, NEMSU Board of Regents',
        photoUrl: boardMemberPhoto('loayon.png'),
    },
    {
        id: 'senate-representative',
        name: 'HON. SENATOR LOREN B. LEGARDA',
        designation:
            'Chairman of Senate Committee on Higher, Technical, and Vocational Education',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('50ef8465-2893-4ac8-b377-820b5d8fcacb.png'),
    },
    {
        id: 'house-representative',
        name: 'HON. JUDE A. ACIDRE',
        designation: 'Chairman, House Committee on Higher Technical Education',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('acidre.png'),
    },
    {
        id: 'economy-and-planning-representative',
        name: 'HON. GEMIMA A. OLAM, EnP, CESO IV',
        designation:
            'Regional Director, Department of Economy, Planning, and Development XIII',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('olam.png'),
    },
    {
        id: 'dost-representative',
        name: 'HON. NOEL M. AJOC',
        designation: 'DOST Regional Director',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('ajoc.png'),
    },
    {
        id: 'private-sector-representative-one',
        name: 'Vacant',
        designation: 'Private Sector Representative',
        boardRole: 'Member',
        photoUrl: null,
    },
    {
        id: 'private-sector-representative-two',
        name: 'Vacant',
        designation: 'Private Sector Representative',
        boardRole: 'Member',
        photoUrl: null,
    },
    {
        id: 'alumni-representative',
        name: 'HON. JOHN FLOR B. RAMAS',
        designation: 'President, Alumni Associations',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('ramas.png'),
    },
    {
        id: 'faculty-representative',
        name: 'HON. RUDYARD RYAN T. VERANO',
        designation: 'President, Federation of Faculty Club Associations',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('verano.png'),
    },
    {
        id: 'student-representative',
        name: 'HON. CLARENCE UBUAN',
        designation: 'President, Federation of Supreme Student Government',
        boardRole: 'Member',
        photoUrl: boardMemberPhoto('Image_p54kaap54kaap54k.jpeg'),
    },
    {
        id: 'board-secretary',
        name: 'CATHERINE F. SALOMON, PhD(C)',
        designation: 'Board Secretary V',
        boardRole: 'Board Secretary',
        photoUrl: boardMemberPhoto('Pasted image (2).png'),
    },
];

const boardLevels: BoardLevel[] = [
    {
        title: 'Chairperson',
        members: boardMembers.slice(0, 1),
        layoutClass: 'mx-auto max-w-lg grid-cols-1',
        cardClass:
            'border-[#0b3d91]/25 bg-[#0b3d91] text-white shadow-lg shadow-[#0b3d91]/15 dark:border-sky-300/20 dark:bg-[#0b3d91]',
        portraitClass:
            'size-28 ring-4 ring-white/20 dark:ring-white/20 sm:size-32',
    },
    {
        title: 'Vice Chairperson',
        members: boardMembers.slice(1, 2),
        layoutClass: 'mx-auto max-w-lg grid-cols-1',
        cardClass:
            'border-amber-300/70 bg-amber-50 shadow-md shadow-amber-950/5 dark:border-amber-300/20 dark:bg-amber-300/10',
        portraitClass:
            'size-28 ring-4 ring-amber-100 dark:ring-amber-300/20 sm:size-32',
    },
    {
        title: 'Members of the Board',
        members: boardMembers.slice(2, 11),
        layoutClass: 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        cardClass:
            'border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5',
        portraitClass:
            'size-24 ring-1 ring-slate-200 dark:ring-white/10 sm:size-28',
    },
    {
        title: 'Board Secretariat',
        members: boardMembers.slice(11, 12),
        layoutClass: 'mx-auto max-w-lg grid-cols-1',
        cardClass:
            'border-slate-300 bg-slate-50 shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/5',
        portraitClass:
            'size-24 ring-1 ring-slate-300 dark:ring-white/10 sm:size-28',
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
                    { title: 'About Us' },
                    { title: 'Board of Regents' },
                ]"
            />

            <section class="py-14 sm:py-16 lg:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <ol>
                        <li
                            v-for="(level, levelIndex) in boardLevels"
                            :key="level.title"
                            class="relative"
                        >
                            <div
                                v-if="levelIndex > 0"
                                class="mx-auto h-12 w-px bg-gradient-to-b from-[#0b3d91] to-amber-400 sm:h-16 dark:from-sky-300 dark:to-amber-300"
                                aria-hidden="true"
                            ></div>

                            <div class="mb-5 text-center">
                                <h3
                                    class="text-lg font-bold text-slate-950 sm:text-xl dark:text-white"
                                >
                                    {{ level.title }}
                                </h3>
                            </div>

                            <div
                                class="grid gap-5 sm:gap-6"
                                :class="level.layoutClass"
                            >
                                <article
                                    v-for="member in level.members"
                                    :key="member.id"
                                    class="flex min-h-[18rem] flex-col rounded-xl border p-5 text-center transition-transform duration-300 hover:-translate-y-1 motion-reduce:transform-none motion-reduce:transition-none sm:p-6"
                                    :class="level.cardClass"
                                >
                                    <div class="flex justify-center">
                                        <img
                                            v-if="
                                                member.photoUrl &&
                                                !failedImages.has(member.id)
                                            "
                                            :src="member.photoUrl"
                                            :alt="member.name"
                                            class="rounded-full object-cover"
                                            :class="level.portraitClass"
                                            loading="lazy"
                                            @error="
                                                markImageAsFailed(member.id)
                                            "
                                        />

                                        <div
                                            v-else
                                            class="flex items-center justify-center rounded-full bg-slate-100 text-base font-semibold text-slate-500 dark:bg-white/10 dark:text-slate-300"
                                            :class="level.portraitClass"
                                            aria-hidden="true"
                                        >
                                            {{ initialsOf(member.name) }}
                                        </div>
                                    </div>

                                    <div class="mt-5 flex grow flex-col">
                                        <p
                                            class="text-sm leading-5 font-bold break-words"
                                            :class="
                                                levelIndex === 0
                                                    ? 'text-white'
                                                    : 'text-slate-950 dark:text-white'
                                            "
                                        >
                                            {{ member.name }}
                                        </p>

                                        <p
                                            class="mt-3 text-xs leading-5 break-words"
                                            :class="
                                                levelIndex === 0
                                                    ? 'text-blue-100'
                                                    : 'text-slate-600 dark:text-slate-300'
                                            "
                                        >
                                            {{ member.designation }}
                                        </p>

                                        <p
                                            class="mt-auto pt-5 text-xs leading-5 font-semibold tracking-wide uppercase"
                                            :class="
                                                levelIndex === 0
                                                    ? 'text-amber-300'
                                                    : 'text-[#0b3d91] dark:text-sky-200'
                                            "
                                        >
                                            {{ member.boardRole }}
                                        </p>
                                    </div>
                                </article>
                            </div>
                        </li>
                    </ol>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>
