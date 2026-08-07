<?php

test('the Cantilan service highlights use the supplied clinic and guidance photos', function () {
    $cantilan = require dirname(__DIR__, 2).'/config/campuses/cantilan.php';
    $services = $cantilan['serviceHighlights'];

    expect($cantilan['services'])->toBe([
        'Guidance and Counseling Services',
        'School Clinic',
    ])
        ->and($services)->toHaveCount(2)
        ->and(array_column($services, 'title'))->toBe($cantilan['services'])
        ->and(array_map(
            static fn (array $service): int => count($service['images']),
            $services,
        ))->toBe([17, 16]);

    $images = collect($services)->flatMap(
        static fn (array $service): array => $service['images'],
    );

    expect($images)
        ->toHaveCount(33)
        ->and($images->pluck('image')->unique())->toHaveCount(33);

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
            ->and($image['image'])->toStartWith('/images/campuses/cantilan/services/')
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

    expect($campusProfiles['cantilan']['services'])->toBe($cantilan['services'])
        ->and($campusProfiles['cantilan']['serviceHighlights'])->toBe($services);
});
