<?php

use Inertia\Testing\AssertableInertia as Assert;

test('directory page can be viewed', function () {
    $this->withoutVite();

    $this->get(route('directory'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('directory/Index')
            ->has('directorySections', 2)
            ->where('directorySections.0.heading', 'Key Officials of the University')
            ->has('directorySections.0.entries', 55)
            ->where('directorySections.0.entries.0.name', 'Dr. Nemesio G. Loayon')
            ->where('directorySections.0.entries.0.designation', 'SUC President III')
            ->where('directorySections.0.entries.0.contact', '(086) 214-4221')
            ->where('directorySections.0.entries.0.email', 'op@nemsu.edu.ph')
            ->where('directorySections.0.entries.1.name', 'Atty. Michiko N. Donaire-Maglinte')
            ->where('directorySections.0.entries.1.designation', 'OIC Vice President for Administration and Finance/Legal Officer IV')
            ->where('directorySections.0.entries.9.name', 'Dr. Ivy M. Orcullo')
            ->where('directorySections.0.entries.12.name', 'Dr. Alex S. Ladaga')
            ->where('directorySections.0.entries.12.email', 'asladaga@nemsu.edu.ph')
            ->where('directorySections.0.entries.33.name', 'Engr. Luzminda S. Bacquial')
            ->where('directorySections.0.entries.33.designation', 'Director, Knowledge and Technology Transfer/ITSO Manager')
            ->where('directorySections.0.entries.54.name', 'Mr. Anthony B. Yanto')
            ->where('directorySections.0.entries.54.designation', 'Information Technology Officer I')
            ->where('directorySections.1.heading', 'Other University-wide Designations')
            ->has('directorySections.1.entries', 3)
            ->where('directorySections.1.entries.0.name', 'Ms. Coravil Avila')
            ->where('directorySections.1.entries.0.email', 'cjcavila@nemsu.edu.ph')
            ->where('directorySections.1.entries.2.name', 'Ms. Marlina B. Sagetarios')
            ->where('directorySections.1.entries.2.designation', 'GAD Focal Person')
        );
});

test('directory page uses the shared page hero', function () {
    $page = file_get_contents(resource_path('js/pages/directory/Index.vue'));

    expect($page)
        ->toContain("import PageHero from '@/components/PageHero.vue'")
        ->toContain('<PageHero')
        ->toContain('title="University Directory"')
        ->toContain('The University Directory provides official contact information')
        ->toContain("{ title: 'Home', href: home().url }")
        ->toContain("{ title: 'Directory' }")
        ->not->toContain("import Breadcrumbs from '@/components/Breadcrumbs.vue'")
        ->not->toContain('<Breadcrumbs');
});
