<?php

use App\Http\Controllers\CollegeController;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('college page can be viewed', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('academics.academic-affairs.colleges.show', 'college-of-teacher-education'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('academics/College')
            ->where('college.title', 'College of Teacher Education')
            ->where('college.photo', '/images/academics/colleges/cte.png')
            ->where('college.campuses.0.name', 'Bislig Campus')
            ->where('college.campuses.0.courses.0', 'Bachelor of Secondary Education major in English')
            ->where('college.campuses.5.name', 'Tandag Campus')
            ->has('colleges', 9)
        );
});

test('college of accountancy page can be viewed', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('academics.academic-affairs.colleges.show', 'college-of-accountancy'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('academics/College')
            ->where('college.title', 'College of Accountancy')
            ->where('college.campuses.0.name', 'Tandag Campus')
            ->where('college.campuses.0.courses.0', 'Bachelor of Science in Accountancy')
        );
});

test('college programs are listed once with every campus offering', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('academics.academic-affairs.colleges.show', 'college-of-agriculture-and-forestry'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('academics/College')
            ->has('college.programs', 4)
            ->where('college.programs.0.id', 'program-bachelor-of-science-in-forestry')
            ->where('college.programs.0.title', 'Bachelor of Science in Forestry')
            ->where('college.programs.0.campuses', ['Bislig Campus', 'San Miguel Campus'])
            ->where('college.programs.0.description', 'The Bachelor of Science in Forestry program equips students with scientific knowledge, technical competencies, and practical skills in forest resource management, forest protection, watershed management, agroforestry, biodiversity conservation, and environmental sustainability. The program prepares future forestry professionals to address environmental challenges, promote sustainable utilization of forest resources, and contribute to climate change adaptation, ecological preservation, and rural development initiatives.')
            ->where('college.programs.0.prospectusUrl', 'https://drive.google.com/file/d/1S6Fs4Daxh_1-eCFcB6fsLjB0suuM1U42/view?usp=sharing')
        );
});

test('program aliases are consolidated under one expanded title', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('academics.academic-affairs.colleges.show', 'college-of-business-and-management'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('college.programs', 8)
            ->where('college.programs.1.title', 'Bachelor of Science in Business Administration major in Financial Management')
            ->where('college.programs.1.campuses', ['Cantilan Campus', 'Lianga Campus', 'Tagbina Campus', 'Tandag Campus'])
            ->where('college.programs.1.prospectusUrl', 'https://drive.google.com/file/d/1sfbRgyn8ZJfMxXq_RAodHlHtGvgxDUva/view?usp=sharing')
        );

    $this->get(route('academics.academic-affairs.colleges.show', 'college-of-information-technology-education'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('college.programs', 2)
            ->where('college.programs.1.title', 'Bachelor of Science in Computer Science')
            ->where('college.programs.1.campuses', ['Cantilan Campus', 'Lianga Campus', 'Tagbina Campus', 'Tandag Campus'])
        );

    $this->get(route('academics.academic-affairs.colleges.show', 'college-of-teacher-education'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('college.programs', 15)
            ->where('college.programs.0.title', 'Bachelor of Secondary Education major in English')
            ->where('college.programs.0.campuses', ['Bislig Campus', 'Cantilan Campus', 'Tandag Campus'])
        );
});

test('every current college program has a supplied description', function () {
    foreach (CollegeController::COLLEGES as $college) {
        $programTitles = collect($college['campuses'])
            ->flatMap(fn (array $campus): array => $campus['courses'])
            ->unique();
        $programDetails = collect($college['programDetails'] ?? []);
        $normalizedProgramTitles = $programTitles->map(fn (string $programTitle): string => Str::of($programTitle)
            ->replaceMatches('/\s*\([^)]*\)\s*/', ' ')
            ->squish()
            ->lower()
            ->toString());

        expect($programTitles->diff($programDetails->keys()))->toBeEmpty();
        expect($programDetails->keys()->diff($programTitles))->toBeEmpty();
        expect($normalizedProgramTitles->duplicates())->toBeEmpty();

        foreach ($programTitles as $programTitle) {
            expect($programDetails[$programTitle]['description'])
                ->toBeString()
                ->not->toBeEmpty();
        }
    }
});

test('every college has a valid featured photo path', function () {
    foreach (CollegeController::COLLEGES as $college) {
        expect($college['photo'])
            ->toBeString()
            ->toStartWith('/images/academics/colleges/');

        expect(public_path(ltrim($college['photo'], '/')))->toBeFile();
    }
});

test('every college program has a stable unique anchor id', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    foreach (array_keys(CollegeController::COLLEGES) as $collegeSlug) {
        $programs = $this
            ->get(route('academics.academic-affairs.colleges.show', $collegeSlug))
            ->assertOk()
            ->inertiaProps('college.programs');
        $programIds = collect($programs)->pluck('id');

        expect($programIds->duplicates())->toBeEmpty();

        foreach ($programIds as $programId) {
            expect($programId)
                ->toBeString()
                ->toMatch('/^program-[a-z0-9]+(?:-[a-z0-9]+)*$/');
        }
    }
});

test('unknown college page is hidden', function () {
    $this->get(route('academics.academic-affairs.colleges.show', 'unknown-college'))
        ->assertNotFound();
});

test('college page renders an editorial program accordion', function () {
    $page = file_get_contents(resource_path('js/pages/academics/College.vue'));

    expect($page)
        ->toContain('props.college.overview')
        ->toContain('props.college.programs')
        ->toContain('name="college-programs"')
        ->toContain('program.description')
        ->toContain('program.prospectusUrl')
        ->not->toContain('A detailed program description will be published soon.')
        ->toContain('Programs Offered')
        ->toContain('Undergraduate Colleges')
        ->toContain('featured photo')
        ->toContain('props.college.photo')
        ->toContain(':src="props.college.photo"')
        ->toContain('class="h-full w-full object-contain"')
        ->toContain('aspect-4/3')
        ->toContain('lg:grid-cols-[minmax(0,3fr)_minmax(16rem,2fr)]')
        ->toContain(':id="program.id"')
        ->toContain('openLinkedProgram')
        ->toContain("window.addEventListener('hashchange', openLinkedProgram)")
        ->toContain('programElement.open = true')
        ->toContain('scroll-mt-28')
        ->toContain('collegeShow.url')
        ->toContain('text-[#1711d4]')
        ->not->toContain('#0b6680')
        ->not->toContain('#9b1c31')
        ->not->toContain('text-rose-')
        ->not->toContain('BookOpenText')
        ->not->toContain('MapPin')
        ->not->toContain('>Campus<')
        ->not->toContain('>Courses<')
        ->not->toContain('Back to Undergraduate Programs');
});

test('college hero displays its breadcrumb above the title', function () {
    $page = file_get_contents(resource_path('js/pages/academics/College.vue'));
    $breadcrumbPosition = strpos($page, 'aria-label="Breadcrumb"');
    $heroHeadingPosition = strpos($page, '<h1');

    expect($breadcrumbPosition)->not->toBeFalse();
    expect($heroHeadingPosition)->not->toBeFalse();
    expect($breadcrumbPosition)->toBeLessThan($heroHeadingPosition);
    expect(substr_count($page, 'aria-label="Breadcrumb"'))->toBe(1);
});
