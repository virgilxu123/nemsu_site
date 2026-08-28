<?php

use Tests\TestCase;

uses(TestCase::class);

test('publication gallery combines and sorts all scopus posters by filename descending', function () {
    $page = file_get_contents(resource_path('js/pages/research/Publications.vue'));

    expect($page)
        ->toContain("slug: 'scopus-publications'")
        ->toContain('.flatMap((collection) => collection.posters)')
        ->toContain('getPosterFileNumber(secondPoster)')
        ->toContain('getPosterFileNumber(firstPoster)')
        ->toContain('const visibleCollections = computed(() => [combinedCollection.value]);')
        ->toContain('return selectedPoster.value ? combinedCollection.value.posters : [];')
        ->not->toContain("const activeCollection = ref('all')")
        ->not->toContain('Filter publication collections');
});
