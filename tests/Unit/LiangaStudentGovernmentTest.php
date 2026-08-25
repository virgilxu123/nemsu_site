<?php

test('the Lianga student government uses the supplied activities and photos', function () {
    $lianga = require dirname(__DIR__, 2).'/config/campuses/lianga.php';
    $activities = $lianga['studentGovernmentActivities'];

    expect($lianga['studentGovernmentAdviser'])->toBe('Ailyn Grace P. Buquid, PhD')
        ->and($activities)->toHaveCount(3)
        ->and(array_column($activities, 'title'))->toBe([
            'Lianga Youth Unite for Sustainable Development Goals Summit 2025',
            'National Volunteer Month 2025: Clean-Up Drive',
            'Clean-Up Drive Before Second Semester 2026',
        ])
        ->and(array_column($activities, 'date'))->toBe([
            'August 29, 2025',
            'December 12, 2025',
            'January 23, 2026',
        ]);

    $images = collect($activities)->flatMap(
        fn (array $activity): array => $activity['images'],
    );

    expect($images)
        ->toHaveCount(3)
        ->and($images->pluck('image')->unique())->toHaveCount(3);

    foreach ($activities as $activity) {
        expect($activity)
            ->toHaveKeys(['title', 'date', 'description', 'images'])
            ->and($activity['description'])->not->toBeEmpty()
            ->and($activity['images'])->toHaveCount(1);
    }

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];
        $dimensions = getimagesize($publicPath);

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/lianga/student-government/')
            ->and($image['image'])->toEndWith('.jpg')
            ->and($image['alt'])->not->toBeEmpty()
            ->and($publicPath)->toBeFile()
            ->and($dimensions)->not->toBeFalse()
            ->and($dimensions['mime'])->toBe('image/jpeg')
            ->and($dimensions[0])->toBeLessThanOrEqual(1800)
            ->and($dimensions[1])->toBeLessThanOrEqual(1800);
    }

    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $studentGovernment = $campusProfiles['lianga']['studentGovernment'];

    expect($studentGovernment['name'])->toBe('University Student Government - Lianga Campus')
        ->and($studentGovernment['adviser'])->toBe('Ailyn Grace P. Buquid, PhD')
        ->and($studentGovernment['activities'])->toBe($activities)
        ->and($studentGovernment)->not->toHaveKey('officers');
});
