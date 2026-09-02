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
            ->has('studies', 3)
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
            ->has('studies', 3)
        );
});

test('unknown graduate professional study page is hidden', function () {
    $this->get(route('academics.academic-affairs.graduate-professional-studies.show', 'unknown-study'))
        ->assertNotFound();
});

test('graduate professional study page renders overview and program accordion', function () {
    $page = file_get_contents(resource_path('js/pages/academics/GraduateProfessionalStudy.vue'));

    expect($page)
        ->toContain('props.study.overview')
        ->toContain('props.study.programs')
        ->toContain('Graduate and Professional Studies')
        ->toContain('studyShow.url')
        ->toContain(':id="program.id"')
        ->toContain('openLinkedProgram')
        ->toContain("window.addEventListener('hashchange', openLinkedProgram)")
        ->toContain('programElement.open = true')
        ->toContain('scroll-mt-28')
        ->not->toContain('BookOpenText')
        ->not->toContain('MapPin')
        ->not->toContain('>Campus<')
        ->not->toContain('>Courses<');
});

test('graduate professional study hero displays its breadcrumb above the title', function () {
    $page = file_get_contents(resource_path('js/pages/academics/GraduateProfessionalStudy.vue'));
    $breadcrumbPosition = strpos($page, 'aria-label="Breadcrumb"');
    $heroHeadingPosition = strpos($page, '<h1');

    expect($breadcrumbPosition)->not->toBeFalse();
    expect($heroHeadingPosition)->not->toBeFalse();
    expect($breadcrumbPosition)->toBeLessThan($heroHeadingPosition);
    expect(substr_count($page, 'aria-label="Breadcrumb"'))->toBe(1);
});
