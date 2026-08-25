<?php

test('the Lianga campus services use the supplied content and images', function () {
    $lianga = require dirname(__DIR__, 2).'/config/campuses/lianga.php';
    $services = $lianga['serviceHighlights'];

    expect($lianga['services'])->toBe([
        'Gender and Development Office',
        'Quality Assurance Office',
        'Research and Innovation Unit',
        'Library Services',
        'Guidance Services',
        'Medical and Dental Services',
        'Extension Services',
    ])
        ->and($services)->toHaveCount(7)
        ->and(array_column($services, 'title'))->toBe($lianga['services']);

    foreach ($services as $service) {
        expect($service)
            ->toHaveKeys(['title', 'description', 'images'])
            ->and($service['description'])->not->toBeEmpty()
            ->and($service['images'])->not->toBeEmpty();
    }

    $images = collect($services)->flatMap(
        fn (array $service): array => $service['images'],
    );

    expect($images)
        ->toHaveCount(34)
        ->and($images->pluck('image')->unique())->toHaveCount(34)
        ->and($services[0]['images'])->toHaveCount(12)
        ->and(array_column($services[0]['images'], 'image'))->not->toContain(
            '/images/campuses/lianga/services/gad-services-overview.jpg',
        );

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];
        $dimensions = getimagesize($publicPath);

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/lianga/services/')
            ->and($image['image'])->toEndWith('.jpg')
            ->and($image['alt'])->not->toBeEmpty()
            ->and($publicPath)->toBeFile()
            ->and($dimensions)->not->toBeFalse()
            ->and($dimensions['mime'])->toBe('image/jpeg')
            ->and($dimensions[0])->toBeLessThanOrEqual(1800)
            ->and($dimensions[1])->toBeLessThanOrEqual(1800);
    }

    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['lianga']['services'])->toBe($lianga['services'])
        ->and($campusProfiles['lianga']['serviceHighlights'])->toBe($services);
});
