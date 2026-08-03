<?php

test('the Cantilan facility gallery uses the extracted enhanced photos', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $cantilan = $campusProfiles['cantilan'];
    $gallery = $cantilan['facilityGallery'];

    expect($cantilan['facilities'])
        ->toHaveCount(37)
        ->toContain('Technology and Economic Building (unusable)')
        ->toContain('Conference Hall Building (unusable)')
        ->and($gallery)->toHaveCount(39)
        ->and(array_column($gallery, 'image'))->toHaveCount(39);

    foreach ($gallery as $facility) {
        expect($facility)
            ->toHaveKeys(['image', 'alt', 'title', 'category'])
            ->and($facility['image'])
            ->toStartWith('/images/campuses/cantilan/facilities/gallery/')
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
