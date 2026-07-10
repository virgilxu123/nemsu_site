<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';

const services = [
    {
        name: 'Student Information System (SIS)',
        description: 'Access student records, grades, and enrollment details.',
        url: 'http://sis.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=SIS',
    },
    {
        name: 'Digital Library',
        description: 'Browse online academic resources and e-books.',
        url: 'https://nemsu.odilo.us/',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=Library',
    },
    {
        name: 'Learning Management System (LMS)',
        description: 'Online classes, assignments, and course materials.',
        url: 'http://lms.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=LMS',
    },
    {
        name: 'Employee Record Management System (ERMS)',
        description: 'Manage faculty and staff profiles and records.',
        url: 'http://erms.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=ERMS',
    },
    {
        name: 'Daily Time Record (DTR)',
        description: 'Monitor daily attendance and time logs.',
        url: 'http://dtr.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=DTR',
    },
    {
        name: 'Leave Management System',
        description: 'Apply and track employee leave requests.',
        url: 'http://leave.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=Leave+System',
    },
    {
        name: 'Payroll System',
        description: 'View payslips and compensation details.',
        url: 'http://payroll.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=Payroll',
    },
    {
        name: 'Customer Satisfaction Measurement System (CSMS)',
        description: 'Provide feedback and rate university services.',
        url: 'http://csms.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=CSMS',
    },
    {
        name: 'Itinero',
        description: 'Travel order and vehicle dispatch management.',
        url: 'http://itinero.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=Itinero',
    },
    {
        name: 'Electronic Pass Slip Epass',
        description: 'Request and track employee pass slips.',
        url: 'http://epass.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=Epass',
    },
    {
        name: 'Document Tracking System (DTS)',
        description: 'Track routing and status of official documents.',
        url: 'http://dts.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=DTS',
    },
    {
        name: 'Financial Management System',
        description: 'Budgeting and financial transaction processing.',
        url: 'http://fmis.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=FMIS',
    },
    {
        name: 'Memo',
        description: 'Internal memorandums and university circulars.',
        url: 'http://memo.nemsu.edu.ph',
        image: 'https://placehold.co/600x400/1711d4/ffffff?text=Memo',
    },
];
</script>

<template>
    <PublicSiteLayout>
        <Head title="Online Services - NEMSU" />
        
        <div class="bg-[#1711d4] py-16 text-center text-white sm:py-24">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                    Online Services
                </h1>
                <p class="mt-4 text-lg text-indigo-100">
                    Access North Eastern Mindanao State University's digital platforms for students, faculty, and staff.
                </p>
            </div>
        </div>

        <div class="py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="space-y-16 lg:space-y-32">
                    <div
                        v-for="(service, index) in services"
                        :key="service.name"
                    >
                        <!-- Separator Line -->
                        <div v-if="index !== 0" class="mb-16 flex justify-center lg:mb-32">
                            <hr class="w-full border-t border-[#1711d4]/20 dark:border-white/10" />
                        </div>
                        
                        <div 
                            class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16"
                        >
                            <!-- Text Content -->
                            <div :class="index % 2 === 1 ? 'lg:order-2' : 'lg:order-1'">
                                <div class="flex items-center gap-4">
                                    <h2 class="text-2xl font-bold tracking-tight text-[#1711d4] sm:text-3xl dark:text-sky-300">
                                        {{ service.name }}
                                    </h2>
                                </div>
                                <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300">
                                    {{ service.description }}
                                </p>
                                <div class="mt-8">
                                    <a
                                        :href="service.url"
                                        target="_blank"
                                        class="inline-flex items-center justify-center rounded-md bg-[#f2b705] px-8 py-3.5 text-sm font-semibold text-slate-900 shadow-sm transition-colors hover:bg-[#d9a404] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f2b705]"
                                    >
                                        Visit Website
                                        <svg class="ml-2 size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Illustration / Visual -->
                            <div 
                                :class="index % 2 === 1 ? 'lg:order-1' : 'lg:order-2'"
                                class="flex justify-center"
                            >
                                <img
                                    :src="service.image"
                                    :alt="`${service.name} illustration`"
                                    class="w-full max-w-lg rounded-2xl object-cover shadow-sm border border-slate-100 dark:border-white/5"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicSiteLayout>
</template>
