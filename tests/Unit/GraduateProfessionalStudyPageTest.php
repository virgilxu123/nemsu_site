<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('graduate school page can be viewed', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('academics.academic-affairs.graduate-professional-studies.show', 'graduate-school'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('academics/GraduateProfessionalStudy')
            ->where('study.title', 'Graduate School')
            ->where('study.campuses.0.name', 'Cantilan Campus')
            ->where('study.campuses.0.courses.0', 'Master in Teaching Technology Education (MTTE) major in Drafting Technology')
            ->where('study.campuses.1.name', 'Tandag Campus')
            ->where('study.campuses.1.courses.13', 'Master in Public Administration')
            ->has('studies', 2)
        );
});

test('college of law page can be viewed', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('academics.academic-affairs.graduate-professional-studies.show', 'college-of-law'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('academics/GraduateProfessionalStudy')
            ->where('study.title', 'College of Law')
            ->where('study.campuses.0.name', 'Tandag Campus')
            ->where('study.campuses.0.courses.0', 'Juris Doctor (4 Years)')
            ->where('study.campuses.0.courses.2', 'Ladderized Master of Legal Studies - Juris Doctor Degree')
            ->has('studies', 2)
        );
});

test('unknown graduate professional study page is hidden', function () {
    $this->get(route('academics.academic-affairs.graduate-professional-studies.show', 'unknown-study'))
        ->assertNotFound();
});

test('graduate professional study page renders overview campuses and courses', function () {
    $page = file_get_contents(resource_path('js/pages/academics/GraduateProfessionalStudy.vue'));

    expect($page)
        ->toContain('props.study.overview')
        ->toContain('props.study.campuses')
        ->toContain('campus.courses')
        ->toContain('Graduate and Professional Studies')
        ->toContain('studyShow.url');
});
