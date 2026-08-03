<?php

test('the San Miguel service highlights use the extracted local photos', function () {
    $sanMiguel = require dirname(__DIR__, 2).'/config/campuses/san-miguel.php';
    $services = $sanMiguel['serviceHighlights'];

    expect($sanMiguel['services'])->toBe([
        'Enrollment',
        'Trainings and Seminars',
        'Printing Services (IGP)',
        'Project FARM and Project SARAI',
        'Production',
    ])
        ->and($services)->toHaveCount(5)
        ->and(array_column($services, 'title'))->toBe($sanMiguel['services']);

    $images = collect($services)->flatMap(fn (array $service): array => $service['images']);

    expect($images)->toHaveCount(14);

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
            ->and($image['image'])->toStartWith('/images/campuses/san-miguel/services/')
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

    expect($campusProfiles['san-miguel']['serviceHighlights'])->toHaveCount(5);
});

test('the service gallery gives single-photo highlights the full image area', function () {
    $component = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($component)
        ->toContain('service.images.length === 1')
        ->toContain('v-if="service.images.length > 1"');
});
