<?php

test('the San Miguel student government omits the officer roster', function () {
    $sanMiguel = require dirname(__DIR__, 2).'/config/campuses/san-miguel.php';

    expect($sanMiguel)
        ->toHaveKeys([
            'studentGovernmentAdviser',
            'studentGovernmentActivities',
        ])
        ->and($sanMiguel['studentGovernmentAdviser'])->toBe('Ed B. Bautista, MAEd')
        ->and($sanMiguel)->not->toHaveKey('studentGovernmentOfficers');
});

test('the San Miguel student government activities use optimized local photos', function () {
    $sanMiguel = require dirname(__DIR__, 2).'/config/campuses/san-miguel.php';
    $activities = $sanMiguel['studentGovernmentActivities'];

    expect($activities)
        ->toHaveCount(6)
        ->and(array_column($activities, 'title'))->toBe([
            'PagbaBAGo: A Million Trees Campaign',
            'PagbaBAGO: A Million Learners & Trees Campaign',
            'Earth Day and Environmental Awareness Activity',
            'Goat Deworming Outreach',
            'Rug-Making Activity',
            'Bed-Making Demonstration During Presidential Visit',
        ]);

    $images = collect($activities)->flatMap(
        fn (array $activity): array => $activity['images'],
    );

    expect($images)
        ->toHaveCount(22)
        ->and($images->pluck('image')->unique())->toHaveCount(22);

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
            ->and($image['image'])->toStartWith('/images/campuses/san-miguel/student-government/')
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
});

test('the campus profile maps the San Miguel student government details', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $studentGovernment = $campusProfiles['san-miguel']['studentGovernment'];

    expect($studentGovernment['adviser'])->toBe('Ed B. Bautista, MAEd')
        ->and($studentGovernment['activities'])->toHaveCount(6)
        ->and($studentGovernment)->not->toHaveKey('officers');
});

test('the campus page keeps the student government layout uniform without an officer roster', function () {
    $component = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($component)
        ->toContain('campus.studentGovernment.adviser')
        ->not->toContain('campus.studentGovernment.officers')
        ->not->toContain('Official roster')
        ->not->toContain('USG Officers');
});
