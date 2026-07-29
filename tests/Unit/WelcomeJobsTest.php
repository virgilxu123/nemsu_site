<?php

test('the jobs section matches the high fidelity layout and retains live content', function () {
    $section = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeJobs.vue',
    );

    expect($section)
        ->toContain("import { index as servicesIndex } from '@/routes/services'")
        ->toContain('props.jobOpportunities.slice(0, 6)')
        ->toContain('id="job-opportunities"')
        ->toContain('bg-[#2115DB]')
        ->toContain('bg-[#2115DB] py-16 text-white lg:py-20')
        ->toContain(
            'class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8"',
        )
        ->toContain('Job Opportunities')
        ->toContain('Explore current employment opportunities from NEMSU.')
        ->toContain(
            'font-academic text-3xl leading-[1.08] font-bold tracking-tight',
        )
        ->toContain('max-w-2xl text-base leading-7')
        ->toContain('bg-[#F2B900]')
        ->toContain('class="mt-9 grid w-full gap-4 md:grid-cols-2 lg:gap-3"')
        ->not->toContain('max-w-[39.25rem]')
        ->toContain('md:grid-cols-2')
        ->toContain('bg-[#09005B]')
        ->toContain(
            'font-academic text-sm leading-snug font-bold text-white sm:text-base',
        )
        ->toContain('line-clamp-2 text-sm leading-6')
        ->toContain('text-xs leading-4 text-white/70')
        ->not->toContain('text-[0.625rem]')
        ->not->toContain('text-[0.5625rem]')
        ->toContain('{{ job.position }}')
        ->toContain('job.salaryGrade')
        ->toContain('job.monthlySalary')
        ->toContain('job.details')
        ->toContain('job.employmentType')
        ->toContain('job.experience')
        ->toContain('job.campus')
        ->toContain('<MapPin')
        ->toContain('View Job')
        ->toContain('View All')
        ->toContain(':href="servicesIndex()"')
        ->toContain('No published job opportunities are currently available.')
        ->toContain('v-for="dot in 12"')
        ->and(substr_count($section, 'grid-cols-4 gap-3'))
        ->toBe(2)
        ->and($section)
        ->toContain('showIcon: Boolean(job.employmentType)')
        ->toContain('showIcon: Boolean(job.experience)')
        ->toContain('v-if="metadata.showIcon"')
        ->and(substr_count($section, 'v-for="dot in 16"'))
        ->toBe(1);
});

test('BAC content matches the high fidelity card section', function () {
    $section = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/pages/welcome-sections/WelcomeBAC.vue',
    );

    expect($section)
        ->toContain("import { vppsi } from '@/routes/administration'")
        ->toContain('props.bacDocuments.slice(0, 5)')
        ->toContain('id="bac-matters"')
        ->toContain('border-y border-[#1C0ED7] bg-[#EEF3FF] py-16 lg:py-20')
        ->toContain(
            'class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8"',
        )
        ->toContain('font-serif text-3xl font-semibold')
        ->toContain(
            'class="mx-auto mt-3 block h-1 w-16 rounded-full bg-[#F2B900]"',
        )
        ->toContain('text-sm leading-7')
        ->toContain('sm:text-base')
        ->toContain('grid w-full gap-4 sm:grid-cols-2 lg:grid-cols-5')
        ->toContain("index % 2 === 1 ? 'lg:translate-y-8' : ''")
        ->toContain('flex h-80 min-w-0 flex-col overflow-hidden')
        ->toContain('line-clamp-3 font-serif text-sm leading-5')
        ->toContain(':title="document.title"')
        ->not->toContain('min-h-52')
        ->toContain('bg-[#09005B]')
        ->toContain('{{ document.postedAt')
        ->toContain('{{ document.type }}')
        ->toContain('{{ document.title }}')
        ->toContain(':href="`${vppsi.url()}#bac-matters`"')
        ->toContain('View All')
        ->toContain('v-for="dot in 12"')
        ->toContain('size-20 rounded-full bg-[#F8BC00]')
        ->toContain('target="_blank"')
        ->toContain('rel="noopener noreferrer"')
        ->toContain('No published BAC documents are currently available.')
        ->not->toContain('<table')
        ->not->toContain('max-w-5xl');
});
