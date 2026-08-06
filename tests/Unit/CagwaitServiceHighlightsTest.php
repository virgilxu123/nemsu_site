<?php

test('the Cagwait service highlights use the supplied content and photos', function () {
    $cagwait = require dirname(__DIR__, 2).'/config/campuses/cagwait.php';
    $services = $cagwait['serviceHighlights'];

    expect($cagwait['services'])->toBe([
        'Guidance and Counseling Services',
        'School Clinic',
    ])
        ->and($services)->toHaveCount(2)
        ->and(array_column($services, 'title'))->toBe($cagwait['services']);

    $images = collect($services)->flatMap(
        fn (array $service): array => $service['images'],
    );

    expect($images)
        ->toHaveCount(13)
        ->and($images->pluck('image')->unique())->toHaveCount(13);

    foreach ($services as $service) {
        expect($service)
            ->toHaveKeys(['title', 'description', 'images'])
            ->and($service['description'])->not->toBeEmpty()
            ->and($service['images'])->not->toBeEmpty();
    }

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/cagwait/services/')
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

    expect($campusProfiles['cagwait']['services'])->toBe($cagwait['services'])
        ->and($campusProfiles['cagwait']['serviceHighlights'])->toBe($services);
});
