<?php

test('the Tandag student government activities use the supplied local content', function () {
    $tandag = require dirname(__DIR__, 2).'/config/campuses/tandag.php';
    $activities = $tandag['studentGovernmentActivities'];

    expect($activities)
        ->toHaveCount(5)
        ->and(array_column($activities, 'title'))->toBe([
            'Donation Drive',
            'International Linggo ng Kabataan 2025',
            '51st Nutrition Month Celebration',
            'PRIDEAYON 2025',
            'World Earth Month Tree Planting',
        ]);

    $images = collect($activities)->flatMap(fn (array $activity): array => $activity['images']);

    expect($images)->toHaveCount(17);

    foreach ($activities as $activity) {
        expect($activity)
            ->toHaveKeys(['title', 'date', 'description', 'images'])
            ->and($activity['title'])->not->toBeEmpty()
            ->and($activity['date'])->not->toBeEmpty()
            ->and($activity['description'])->not->toBeEmpty();
    }

    foreach ($images as $image) {
        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/tandag/student-government/')
            ->and($image['alt'])->not->toBeEmpty()
            ->and(file_exists(dirname(__DIR__, 2).'/public'.$image['image']))->toBeTrue();
    }

    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['tandag']['studentGovernment']['activities'])->toHaveCount(5);
});
