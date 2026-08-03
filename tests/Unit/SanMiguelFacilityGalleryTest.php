<?php

test('the San Miguel facility gallery uses the extracted enhanced photos', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $sanMiguel = $campusProfiles['san-miguel'];
    $gallery = $sanMiguel['facilityGallery'];

    expect($sanMiguel['facilities'])
        ->toHaveCount(15)
        ->toContain('TESDA Dormitory (Ongoing Construction)')
        ->toContain('San Miguel Cultural Center (Not Functional)')
        ->and($gallery)->toHaveCount(21)
        ->and(array_unique(array_column($gallery, 'image')))->toHaveCount(21);

    foreach ($gallery as $facility) {
        expect($facility)
            ->toHaveKeys(['image', 'alt', 'title', 'category'])
            ->and($facility['image'])
            ->toStartWith('/images/campuses/san-miguel/facilities/gallery/')
            ->toEndWith('.webp')
            ->and($facility['alt'])->not->toBeEmpty()
            ->and($facility['title'])->not->toBeEmpty()
            ->and($facility['category'])->not->toBeEmpty();

        $imagePath = dirname(__DIR__, 2).'/public'.$facility['image'];
        $imageSize = getimagesize($imagePath);

        expect($imagePath)->toBeFile()
            ->and($imageSize)->not->toBeFalse()
            ->and($imageSize['mime'])->toBe('image/webp')
            ->and($imageSize[0])->toBeLessThanOrEqual(1800)
            ->and($imageSize[1])->toBeLessThanOrEqual(1800);
    }
});

test('the San Miguel gallery identifies unavailable facilities', function () {
    $sanMiguel = require dirname(__DIR__, 2).'/config/campuses/san-miguel.php';
    $gallery = $sanMiguel['facilityGallery'];

    $tesdaDormitoryPhotos = array_values(array_filter(
        $gallery,
        static fn (array $facility): bool => $facility['title'] === 'TESDA Dormitory',
    ));
    $culturalCenter = collect($gallery)->firstWhere(
        'title',
        'San Miguel Cultural Center',
    );

    expect($tesdaDormitoryPhotos)
        ->toHaveCount(3)
        ->and(array_column($tesdaDormitoryPhotos, 'status'))
        ->toBe([
            'Under construction',
            'Under construction',
            'Under construction',
        ])
        ->and($culturalCenter['status'])->toBe('Not functional');
});

test('the facilities section shows facility and photo totals with status badges', function () {
    $campusPage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($campusPage)
        ->toContain('{{ campus.facilities.length }} facilities')
        ->toContain('{{ campus.facilityGallery.length }} photos')
        ->toContain('v-if="facility.status"')
        ->toContain("facility.status === 'Not functional'")
        ->toContain('motion-reduce:transform-none');
});
