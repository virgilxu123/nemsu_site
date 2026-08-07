<?php

test('the Cantilan student government uses the supplied activities and photos', function () {
    $cantilan = require dirname(__DIR__, 2).'/config/campuses/cantilan.php';
    $activities = $cantilan['studentGovernmentActivities'];

    expect($cantilan['focus'])
        ->toBe('Student leadership, emergency response, and community extension')
        ->and($activities)->toHaveCount(2)
        ->and(array_column($activities, 'title'))->toBe([
            'USG Spreads Care',
            'Donation Drive 2026: Compassion in Action',
        ])
        ->and(array_column($activities, 'date'))->toBe([
            'October 10, 2025',
            'February 17, 2026',
        ])
        ->and(array_map(
            static fn (array $activity): int => count($activity['images']),
            $activities,
        ))->toBe([4, 7]);

    $images = collect($activities)->flatMap(
        static fn (array $activity): array => $activity['images'],
    );

    expect($images)
        ->toHaveCount(11)
        ->and($images->pluck('image')->unique())->toHaveCount(11);

    foreach ($activities as $activity) {
        expect($activity)
            ->toHaveKeys(['title', 'date', 'description', 'images'])
            ->and($activity['date'])->not->toBeEmpty()
            ->and($activity['description'])->not->toBeEmpty()
            ->and($activity['images'])->not->toBeEmpty();
    }

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])
            ->toStartWith('/images/campuses/cantilan/student-government/')
            ->toEndWith('.webp')
            ->and($image['alt'])->not->toBeEmpty()
            ->and(file_exists($publicPath))->toBeTrue();

        $dimensions = getimagesize($publicPath);

        expect($dimensions)
            ->not->toBeFalse()
            ->and($dimensions['mime'])->toBe('image/webp')
            ->and($dimensions[0])->toBeLessThanOrEqual(1800)
            ->and($dimensions[1])->toBeLessThanOrEqual(1800);
    }
});

test('the campus profile maps the Cantilan student government details', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $studentGovernment = $campusProfiles['cantilan']['studentGovernment'];

    expect($studentGovernment['adviser'])->toBe('Student Affairs and Services Office')
        ->and($studentGovernment['focus'])
        ->toBe('Student leadership, emergency response, and community extension')
        ->and($studentGovernment['activities'])->toHaveCount(2)
        ->and($studentGovernment)->not->toHaveKey('officers');
});
