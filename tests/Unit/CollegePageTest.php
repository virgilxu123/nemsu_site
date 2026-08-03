<?php

use App\Http\Middleware\HandleInertiaRequests;
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

test('unknown college page is hidden', function () {
    $this->get(route('academics.academic-affairs.colleges.show', 'unknown-college'))
        ->assertNotFound();
});

test('college page renders overview campuses and courses', function () {
    $page = file_get_contents(resource_path('js/pages/academics/College.vue'));

    expect($page)
        ->toContain('props.college.overview')
        ->toContain('props.college.campuses')
        ->toContain('campus.courses')
        ->toContain('Undergraduate Colleges')
        ->toContain('collegeShow.url')
        ->not->toContain('BookOpenText')
        ->not->toContain('MapPin')
        ->not->toContain('>Campus<')
        ->not->toContain('>Courses<')
        ->not->toContain('Back to Undergraduate Programs');
});
