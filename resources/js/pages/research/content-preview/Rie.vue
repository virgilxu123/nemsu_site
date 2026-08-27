<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowUpRight,
    Building2,
    FileText,
    Mail,
    MapPin,
    Newspaper,
    Users,
} from 'lucide-vue-next';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { home } from '@/routes';
import { rie } from '@/routes/research';
import {
    newsUrls,
    offices,
    ovprieAddress,
    ovprieOverview,
    sourceRepositories,
} from './content';
import ContentPreviewNav from './ContentPreviewNav.vue';

const heroBackgroundImage =
    '/images/administration/ovprie/research/research-centers-hero.jpg';
</script>

<template>
    <PublicSiteLayout>
        <Head title="RIE Content Preview | NEMSU" />

        <main class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section
                class="relative isolate overflow-hidden bg-slate-950 py-16 text-white sm:py-20"
            >
                <img
                    :src="heroBackgroundImage"
                    alt=""
                    class="absolute inset-0 size-full object-cover object-[52%_18%] opacity-50"
                    aria-hidden="true"
                />
                <div
                    class="absolute inset-0 bg-linear-to-r from-[#1711d4]/90 via-[#1711d4]/75 to-slate-950/80"
                    aria-hidden="true"
                ></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <nav aria-label="Breadcrumb" class="text-sm font-semibold">
                        <ol class="flex flex-wrap items-center gap-2">
                            <li>
                                <Link
                                    :href="home().url"
                                    class="text-white/80 hover:text-[#f2b705]"
                                >
                                    Home
                                </Link>
                            </li>
                            <li class="text-white/40" aria-hidden="true">/</li>
                            <li>
                                <Link
                                    :href="rie().url"
                                    class="text-white/80 hover:text-[#f2b705]"
                                >
                                    RIE
                                </Link>
                            </li>
                            <li class="text-white/40" aria-hidden="true">/</li>
                            <li class="text-[#f2b705]" aria-current="page">
                                Content preview
                            </li>
                        </ol>
                    </nav>
                    <div class="mt-8 max-w-4xl">
                        <p
                            class="text-sm font-semibold tracking-widest text-[#f2b705] uppercase"
                        >
                            Research, Innovation, and Extension
                        </p>
                        <h1
                            class="mt-3 text-4xl font-semibold tracking-tight sm:text-5xl lg:text-6xl"
                        >
                            Office of the Vice President for RIE
                        </h1>
                        <p
                            class="mt-5 max-w-3xl text-base leading-8 text-sky-50 sm:text-lg"
                        >
                            A source-aligned presentation of OVPRIE leadership,
                            offices, personnel, repositories, and updates.
                        </p>
                    </div>
                </div>
            </section>

            <ContentPreviewNav active="overview" />

            <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_22rem]">
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            OVPRIE profile
                        </p>
                        <h2
                            class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl"
                        >
                            University-wide RIE leadership
                        </h2>
                        <p
                            class="mt-5 max-w-4xl text-justify text-base leading-8 text-slate-600 dark:text-slate-300"
                        >
                            {{ ovprieOverview }}
                        </p>
                    </div>

                    <aside
                        class="rounded-xl border border-slate-200 bg-[#f7f8f5] p-6 dark:border-white/10 dark:bg-white/[0.04]"
                    >
                        <p
                            class="text-xs font-semibold tracking-widest text-[#0b6680] uppercase dark:text-sky-300"
                        >
                            Vice President
                        </p>
                        <h3 class="mt-3 text-xl font-semibold">
                            Rolly G. Salvaleon, PhD
                        </h3>
                        <p
                            class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            Vice President for Research, Innovation, and
                            Extension
                        </p>
                        <a
                            href="mailto:vpre@nemsu.edu.ph"
                            class="mt-5 flex items-start gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-300"
                        >
                            <Mail
                                class="mt-0.5 size-4 shrink-0"
                                aria-hidden="true"
                            />
                            vpre@nemsu.edu.ph
                        </a>
                        <p
                            class="mt-3 flex items-start gap-2 text-sm leading-6 text-slate-600 dark:text-slate-300"
                        >
                            <MapPin
                                class="mt-1 size-4 shrink-0"
                                aria-hidden="true"
                            />
                            {{ ovprieAddress }}
                        </p>
                        <p
                            class="mt-5 border-t border-slate-200 pt-4 text-xs text-slate-500 dark:border-white/10 dark:text-slate-400"
                        >
                            RIE Administration contact: Lady Lieca A. Awa
                        </p>
                    </aside>
                </div>
            </section>

            <section
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 dark:border-white/10 dark:bg-white/[0.03]"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <FileText
                            class="size-6 text-[#1711d4] dark:text-sky-300"
                            aria-hidden="true"
                        />
                        <h2 class="text-2xl font-semibold">
                            Official source repositories
                        </h2>
                    </div>
                    <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <a
                            v-for="repository in sourceRepositories"
                            :key="repository.href"
                            :href="repository.href"
                            target="_blank"
                            rel="noreferrer"
                            class="group rounded-lg border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-[#1711d4]/35 hover:shadow-md dark:border-white/10 dark:bg-slate-900"
                        >
                            <span
                                class="flex items-start justify-between gap-3"
                            >
                                <span class="font-semibold">{{
                                    repository.title
                                }}</span>
                                <ArrowUpRight
                                    class="size-4 shrink-0 text-[#1711d4] dark:text-sky-300"
                                    aria-hidden="true"
                                />
                            </span>
                            <span
                                class="mt-2 block text-sm leading-6 text-slate-600 dark:text-slate-300"
                            >
                                {{ repository.description }}
                            </span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <Building2
                        class="size-7 text-[#1711d4] dark:text-sky-300"
                        aria-hidden="true"
                    />
                    <div>
                        <p
                            class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300"
                        >
                            Offices under OVPRIE
                        </p>
                        <h2 class="mt-1 text-3xl font-semibold tracking-tight">
                            Leadership and personnel
                        </h2>
                    </div>
                </div>

                <div class="mt-9 space-y-8">
                    <article
                        v-for="office in offices"
                        :key="office.acronym"
                        class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10"
                    >
                        <header class="bg-[#1711d4] p-6 text-white sm:p-8">
                            <p class="text-sm font-semibold text-[#f2b705]">
                                {{ office.acronym }}
                            </p>
                            <h3 class="mt-1 text-2xl font-semibold">
                                {{ office.title }}
                            </h3>
                        </header>
                        <div
                            class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[20rem_minmax(0,1fr)]"
                        >
                            <div>
                                <p
                                    class="text-xs font-semibold tracking-wide text-[#0b6680] uppercase dark:text-sky-300"
                                >
                                    Office director
                                </p>
                                <h4 class="mt-2 text-lg font-semibold">
                                    {{ office.director }}
                                </h4>
                                <p
                                    class="mt-1 text-sm leading-6 text-slate-600 dark:text-slate-300"
                                >
                                    {{ office.role }}
                                </p>
                                <a
                                    :href="`mailto:${office.email}`"
                                    class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#1711d4] dark:text-sky-300"
                                >
                                    <Mail class="size-4" aria-hidden="true" />
                                    {{ office.email }}
                                </a>
                                <div class="mt-5 flex flex-wrap gap-2">
                                    <span
                                        v-for="unit in office.units"
                                        :key="unit"
                                        class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:bg-white/10 dark:text-slate-200"
                                    >
                                        {{ unit }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <p
                                    class="text-sm leading-7 text-slate-600 dark:text-slate-300"
                                >
                                    {{ office.overview }}
                                </p>
                                <div
                                    class="mt-6 overflow-x-auto rounded-lg border border-slate-200 dark:border-white/10"
                                >
                                    <table
                                        class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-white/10"
                                    >
                                        <thead
                                            class="bg-[#f7f8f5] text-xs tracking-wide text-slate-600 uppercase dark:bg-white/[0.04] dark:text-slate-300"
                                        >
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="px-4 py-3 font-semibold"
                                                >
                                                    Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-4 py-3 font-semibold"
                                                >
                                                    Position
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-4 py-3 font-semibold"
                                                >
                                                    Designation
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-slate-200 dark:divide-white/10"
                                        >
                                            <tr
                                                v-for="person in office.personnel"
                                                :key="person.name"
                                            >
                                                <td
                                                    class="px-4 py-3 font-semibold whitespace-nowrap"
                                                >
                                                    {{ person.name }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-slate-600 dark:text-slate-300"
                                                >
                                                    {{ person.position }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-slate-600 dark:text-slate-300"
                                                >
                                                    {{ person.designation }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <section
                class="border-t border-slate-200 bg-[#f7f8f5] py-14 dark:border-white/10 dark:bg-white/[0.03]"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <Newspaper
                            class="size-6 text-[#1711d4] dark:text-sky-300"
                            aria-hidden="true"
                        />
                        <div>
                            <h2 class="text-2xl font-semibold">
                                OVPRIE news and updates
                            </h2>
                            <p
                                class="mt-1 text-sm text-slate-600 dark:text-slate-300"
                            >
                                All {{ newsUrls.length }} links supplied in the
                                source content.
                            </p>
                        </div>
                    </div>
                    <div class="mt-7 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        <a
                            v-for="(href, index) in newsUrls"
                            :key="href"
                            :href="href"
                            target="_blank"
                            rel="noreferrer"
                            class="flex items-center justify-between gap-3 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-semibold transition hover:border-[#1711d4]/35 hover:text-[#1711d4] dark:border-white/10 dark:bg-slate-900 dark:hover:text-sky-300"
                        >
                            <span
                                >OVPRIE update
                                {{ String(index + 1).padStart(2, '0') }}</span
                            >
                            <ArrowUpRight
                                class="size-4 shrink-0"
                                aria-hidden="true"
                            />
                        </a>
                    </div>
                </div>
            </section>
        </main>
    </PublicSiteLayout>
</template>
