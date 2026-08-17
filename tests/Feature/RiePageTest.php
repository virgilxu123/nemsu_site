<?php

use Illuminate\Support\Facades\File;
use Inertia\Testing\AssertableInertia as Assert;

test('research innovation and extension page can be viewed', function () {
    $this->get(route('research.rie'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('research/Rie')
        );
});

test('published articles page exposes the curated research poster collections', function () {
    $this->get(route('research.rie.publications.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('research/Publications')
            ->where('totalPosters', 97)
            ->has('collections', 3)
            ->where('collections.0.slug', '2026')
            ->where('collections.0.count', 27)
            ->has('collections.0.posters', 27)
            ->where('collections.0.posters.0.image', '/images/administration/ovprie/research/scopus/2026/1.png')
            ->where('collections.1.slug', 'new-template')
            ->where('collections.1.count', 13)
            ->where('collections.2.slug', 'research-posters')
            ->where('collections.2.count', 57)
            ->has('downloads', 2)
            ->where('downloads.0.href', '/files/administration/ovprie/research/scopus-indexed-publications.xlsx')
            ->where('downloads.1.href', '/files/administration/ovprie/research/completed-research-projects.xlsx')
        );
});

test('published article posters and research workbooks exist in the public directory', function () {
    $posterCollections = [
        'images/administration/ovprie/research/scopus/2026' => 27,
        'images/administration/ovprie/research/scopus/new-template' => 13,
        'images/administration/ovprie/research/scopus/research-posters' => 57,
    ];

    foreach ($posterCollections as $directory => $expectedCount) {
        $posters = File::files(public_path($directory));

        expect($posters)->toHaveCount($expectedCount);

        foreach ($posters as $poster) {
            expect($poster->isFile())->toBeTrue();
        }
    }

    expect(File::exists(public_path('files/administration/ovprie/research/scopus-indexed-publications.xlsx')))->toBeTrue()
        ->and(File::exists(public_path('files/administration/ovprie/research/completed-research-projects.xlsx')))->toBeTrue();
});
