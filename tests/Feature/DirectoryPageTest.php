<?php

use Inertia\Testing\AssertableInertia as Assert;

test('directory page can be viewed', function () {
    $this->withoutVite();

    $this->get(route('directory'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('directory/Index')
            ->has('directorySections', 2)
            ->where('directorySections.0.heading', 'University Officials and Offices')
            ->has('directorySections.0.entries', 50)
            ->where('directorySections.0.entries.0.name', 'Nemesio G. Loayon, Ph.D.')
            ->where('directorySections.0.entries.0.designation', 'University President')
            ->where('directorySections.0.entries.0.contact', '(086) 214-4221')
            ->where('directorySections.0.entries.0.email', 'op@nemsu.edu.ph')
            ->where('directorySections.0.entries.38.name', 'Prof. Alex S. Ladaga')
            ->where('directorySections.0.entries.38.email', 'asladaga@nemsu.edu.ph')
            ->where('directorySections.1.heading', 'Other Designations of University-wide Functions')
            ->has('directorySections.1.entries', 4)
            ->where('directorySections.1.entries.0.name', 'Engr. Luzminda S. Bacquial')
            ->where('directorySections.1.entries.0.email', 'lsbacquial@nemsu.edu.ph')
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
