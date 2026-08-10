<?php

test('the Tagbina service highlights use the supplied content and photos', function () {
    $tagbina = require dirname(__DIR__, 2).'/config/campuses/tagbina.php';
    $services = $tagbina['serviceHighlights'];

    expect($tagbina['services'])->toBe([
        'Vending Machine',
        'Test Booklets',
        'Toga',
    ])
        ->and($services)->toHaveCount(3)
        ->and(array_column($services, 'title'))->toBe($tagbina['services']);

    $images = collect($services)->flatMap(
        fn (array $service): array => $service['images'],
    );

    expect($images)
        ->toHaveCount(3)
        ->and($images->pluck('image')->unique())->toHaveCount(3);

    foreach ($services as $service) {
        expect($service)
            ->toHaveKeys(['title', 'description', 'images'])
            ->and($service['description'])->not->toBeEmpty()
            ->and($service['images'])->toHaveCount(1);
    }

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/tagbina/services/')
            ->and($image['image'])->toEndWith('.webp')
            ->and($image['alt'])->not->toBeEmpty()
            ->and(file_exists($publicPath))->toBeTrue();

        $dimensions = getimagesize($publicPath);

        expect($dimensions)
            ->not->toBeFalse()
            ->and($dimensions['mime'])->toBe('image/webp')
            ->and($dimensions[0])->toBeLessThanOrEqual(1800)
            ->and($dimensions[1])->toBeLessThanOrEqual(1800);
    }

    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['tagbina']['services'])->toBe($tagbina['services'])
        ->and($campusProfiles['tagbina']['serviceHighlights'])->toBe($services);
});
