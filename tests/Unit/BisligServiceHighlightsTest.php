<?php

test('the Bislig campus library service uses the supplied content and photos', function () {
    $bislig = require dirname(__DIR__, 2).'/config/campuses/bislig.php';
    $services = $bislig['serviceHighlights'];

    expect($bislig['services'])->toBe([
        'Circulation Services',
        'Reference and Information Services',
        'Filipiniana and Local Studies Services',
        'Periodicals Services',
        'Online Public Access Catalog (OPAC)',
        'Research Assistance',
        'Library User Education',
        'Electronic Resources Services',
        'Document Delivery Services',
        'Internet and Wi-Fi Services',
        'Book Search and Reservation Services',
    ])
        ->and($services)->toHaveCount(11)
        ->and(array_column($services, 'title'))->toBe($bislig['services']);

    foreach ($services as $service) {
        expect($service)
            ->toHaveKeys(['title', 'description', 'images'])
            ->and($service['description'])->not->toBeEmpty()
            ->and($service['images'])->toHaveCount(1);
    }

    $images = collect($services)->flatMap(
        fn (array $service): array => $service['images'],
    );

    expect($images)
        ->toHaveCount(11)
        ->and($images->pluck('image')->unique())->toHaveCount(11);

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/bislig/services/')
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

    expect($campusProfiles['bislig']['services'])->toBe($bislig['services'])
        ->and($campusProfiles['bislig']['serviceHighlights'])->toBe($services);
});
