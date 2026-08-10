<?php

test('the Tagbina campus lists the facilities identified in the supplied document', function () {
    $tagbina = require dirname(__DIR__, 2).'/config/campuses/tagbina.php';

    expect($tagbina['facilities'])->toBe([
        'Mini Hostel',
        'Food and Beverage Laboratory',
        'Bagong Lipunan – CBM',
        'Bagong Lipunan – Agriculture',
        'Two-Storey Agriculture Building',
        'Two-Storey Library',
        'Gymnasium',
        'Office of the Registrar',
        'Clinic',
        'New Three-Storey Academic Building',
        'Guidance Center',
        'Agricultural Technology Laboratory',
        'Science Laboratory',
        'Biological Science Laboratory',
        'Two-Storey Organic Training Center',
        'New Three-Storey Administration Building',
        'Computer Laboratory',
        'Canteen',
        'Old Administration Building',
        'Guard House',
        'Bagong Lipunan – CTE',
    ]);
});

test('the Tagbina facility gallery uses the supplied optimized photos', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $gallery = $campusProfiles['tagbina']['facilityGallery'];

    expect($gallery)
        ->toHaveCount(17)
        ->and(array_unique(array_column($gallery, 'image')))->toHaveCount(17);

    foreach ($gallery as $facility) {
        expect($facility)
            ->toHaveKeys(['image', 'alt', 'title', 'category'])
            ->and($facility['image'])
            ->toStartWith('/images/campuses/tagbina/facilities/gallery/')
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
