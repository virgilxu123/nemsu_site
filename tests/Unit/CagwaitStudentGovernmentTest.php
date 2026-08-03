<?php

test('the Cagwait student government uses the supplied activities and photos', function () {
    $cagwait = require dirname(__DIR__, 2).'/config/campuses/cagwait.php';
    $activities = $cagwait['studentGovernmentActivities'];

    expect($activities)
        ->toHaveCount(3)
        ->and(array_column($activities, 'title'))->toBe([
            'NEMSU Cagwait Joins Coastal Clean-Up for Month of the Ocean 2026',
            'Fire Safety Education Session at NEMSU Cagwait',
            'HIV/AIDS Awareness Symposium at NEMSU Cagwait',
        ])
        ->and(array_column($activities, 'date'))->toBe([
            'May 12, 2026',
            'Date not stated',
            'November 5, 2025',
        ]);

    $images = collect($activities)->flatMap(
        fn (array $activity): array => $activity['images'],
    );

    expect($images)
        ->toHaveCount(6)
        ->and($images->pluck('image')->unique())->toHaveCount(6);

    foreach ($activities as $activity) {
        expect($activity)
            ->toHaveKeys(['title', 'date', 'description', 'images'])
            ->and($activity['description'])->not->toBeEmpty()
            ->and($activity['images'])->toHaveCount(2);
    }

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/cagwait/student-government/')
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
    $studentGovernment = $campusProfiles['cagwait']['studentGovernment'];

    expect($studentGovernment['activities'])->toBe($activities)
        ->and($studentGovernment['adviser'])->toBe('Student Affairs and Services Office')
        ->and($studentGovernment)->not->toHaveKey('officers');
});
