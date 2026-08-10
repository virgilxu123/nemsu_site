<?php

test('the Tandag service highlights use the extracted local photos', function () {
    $tandag = require dirname(__DIR__, 2).'/config/campuses/tandag.php';
    $services = $tandag['serviceHighlights'];

    expect($services)
        ->toHaveCount(4)
        ->and(array_column($services, 'title'))->toBe([
            'IGP Printing',
            'NEMSU Chowzone',
            'Health Services',
            'Enrollment',
        ]);

    $images = collect($services)->flatMap(fn (array $service): array => $service['images']);

    expect($images)->toHaveCount(9);

    foreach ($services as $service) {
        expect($service)
            ->toHaveKeys(['title', 'description', 'images'])
            ->and($service['description'])->not->toBeEmpty()
            ->and($service['images'])->not->toBeEmpty();
    }

    foreach ($images as $image) {
        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/tandag/services/')
            ->and($image['alt'])->not->toBeEmpty()
            ->and(file_exists(dirname(__DIR__, 2).'/public'.$image['image']))->toBeTrue();
    }

    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['tandag']['serviceHighlights'])->toHaveCount(4);
});
