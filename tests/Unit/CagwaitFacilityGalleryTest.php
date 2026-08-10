<?php

test('the Cagwait facility gallery uses the photos extracted from the supplied document', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $cagwait = $campusProfiles['cagwait'];
    $gallery = $cagwait['facilityGallery'];

    expect($cagwait['facilities'])
        ->toBe(['School Clinic', 'Library'])
        ->and($gallery)->toHaveCount(15)
        ->and(array_unique(array_column($gallery, 'image')))->toHaveCount(15)
        ->and(array_count_values(array_column($gallery, 'title')))->toBe([
            'School Clinic' => 7,
            'Library' => 8,
        ]);

    foreach ($gallery as $facility) {
        expect($facility)
            ->toHaveKeys(['image', 'alt', 'title', 'category'])
            ->and($facility['image'])
            ->toStartWith('/images/campuses/cagwait/facilities/gallery/')
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
