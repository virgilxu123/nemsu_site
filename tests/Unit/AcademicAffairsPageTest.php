<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('academic affairs page can be viewed', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('academics.academic-affairs'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('academics/AcademicAffairs')
            ->has('academicAffairs.profile', fn (Assert $page) => $page
                ->where('title', 'Office of the Vice President for Academic Affairs')
                ->where('unitHead', 'Maria Lady Sol A. Suazo, Ph.D.')
                ->where('role', 'Vice President for Academic Affairs')
                ->where('email', 'ovpaa@nemsu.edu.ph')
                ->where('image', '/images/administration/ovpaa/SUAZO,%20MARIA%20LADY%20SOL,%20A%20SFFB%20NEMSU_4187%20copy.jpg')
                ->has('description', 2)
                ->has('biography', 2)
                ->has('priorities', 4)
                ->etc()
            )
            ->has('academicAffairs.offices', 10)
            ->has('academicAffairs.offices.0', fn (Assert $page) => $page
                ->where('name', 'Curriculum Development Office')
                ->where('headTitle', 'Director')
                ->where('head', 'Dr. Karla Jeane P. Roz-Estrada')
                ->where('email', null)
                ->has('description')
                ->etc()
            )
            ->where('academicAffairs.offices.8.name', 'International Affairs Office')
            ->where('academicAffairs.offices.8.email', 'oia@nemsu.edu.ph')
            ->where('academicAffairs.offices.9.name', 'Guidance and Counselling Office')
            ->has('academicAffairs.colleges', 8)
            ->where('academicAffairs.colleges.0.title', 'College of Agriculture and Forestry')
            ->where('academicAffairs.colleges.7.title', 'College of Teacher Education')
            ->has('academicAffairs.graduateProfessionalStudies', 2)
            ->where('academicAffairs.graduateProfessionalStudies.0.title', 'Graduate School')
            ->where('academicAffairs.graduateProfessionalStudies.1.title', 'College of Law')
            ->has('academicAffairs.programGroups', 4)
            ->has('academicAffairs.programGroups.0.colleges.0', fn (Assert $page) => $page
                ->where('name', 'College of Teacher Education')
                ->has('prospectus')
                ->has('objectives')
                ->has('learningOutcomes')
                ->has('updates')
            )
        );
});

test('academic affairs page renders academic program categories', function () {
    $page = file_get_contents(resource_path('js/pages/academics/AcademicAffairs.vue'));

    expect($page)
        ->toContain('academicProgramSections')
        ->toContain("'undergraduate-programs'")
        ->toContain("'graduate-and-professional-studies'")
        ->toContain('academicAffairs.colleges')
        ->toContain('collegeShow.url(college.slug)')
        ->toContain('academicAffairs.graduateProfessionalStudies')
        ->toContain('studyShow.url(study.slug)')
        ->toContain('college.title')
        ->toContain('study.title')
        ->not->toContain('college.prospectus')
        ->not->toContain('college.objectives')
        ->not->toContain('college.learningOutcomes')
        ->not->toContain('college.updates')
        ->not->toContain("'college-of-medicine'");

    expect(preg_match("/slug:\\s*'graduate-school-programs'/", $page))->toBe(0);
    expect(preg_match("/slug:\\s*'college-of-law'/", $page))->toBe(0);
});
