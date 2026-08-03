<?php

test('the Tandag facility gallery uses the extracted local photos', function () {
    $tandag = require dirname(__DIR__, 2).'/config/campuses/tandag.php';
    $gallery = $tandag['facilityGallery'];

    expect($gallery)->toHaveCount(19);

    foreach ($gallery as $facility) {
        expect($facility)
            ->toHaveKeys(['image', 'alt', 'title', 'category'])
            ->and($facility['image'])->toStartWith('/images/campuses/tandag/facilities/gallery/')
            ->toEndWith('.webp')
            ->not->toContain('images.unsplash.com')
            ->and($facility['alt'])->not->toBeEmpty()
            ->and($facility['title'])->not->toBeEmpty();

        $imagePath = dirname(__DIR__, 2).'/public'.$facility['image'];
        $imageSize = getimagesize($imagePath);

        expect($imagePath)->toBeFile()
            ->and($imageSize)->not->toBeFalse()
            ->and($imageSize['mime'])->toBe('image/webp');
    }
});
