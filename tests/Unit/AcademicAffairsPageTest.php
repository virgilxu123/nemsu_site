<?php

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('academic affairs page can be viewed', function () {
    $this->get(route('academics.academic-affairs'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('academics/AcademicAffairs')
            ->has('academicAffairs.profile', fn (Assert $page) => $page
                ->where('title', 'Office of the Vice President for Academic Affairs')
                ->where('unitHead', 'Biencent Biol')
                ->where('email', 'ovpaa@nemsu.edu.ph')
                ->has('priorities', 4)
                ->etc()
            )
            ->has('academicAffairs.offices', 3)
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
