<?php

test('the Tagbina student government uses the supplied activities and photos', function () {
    $tagbina = require dirname(__DIR__, 2).'/config/campuses/tagbina.php';
    $activities = $tagbina['studentGovernmentActivities'];

    expect($tagbina['focus'])
        ->toBe('Leadership development, student engagement, cultural celebration, and community service')
        ->and($tagbina['initiatives'])->toBe([
            'Student orientation and campus engagement',
            'Leadership formation and responsible governance',
            'Cultural celebration and student development',
            'Environmental stewardship and community service',
        ])
        ->and($activities)->toHaveCount(9)
        ->and(array_column($activities, 'title'))->toBe([
            '(Re) Orientation of New and Returning Students for First Semester Academic Year 2025–2026',
            'ASEAN 2025 Celebration',
            'Acquaintance Party, Turnover, and Oath-Taking Ceremony',
            'Two-Day Leadership Training',
            'Anti-Hazing Symposium',
            'Tree Planting Activity',
            'Year-End Party',
            '17th University Day',
            'Hagbangay 2026',
        ])
        ->and(array_map(
            static fn (array $activity): int => count($activity['images']),
            $activities,
        ))->toBe([2, 2, 2, 2, 2, 4, 5, 4, 4]);

    $images = collect($activities)->flatMap(
        fn (array $activity): array => $activity['images'],
    );

    expect($images)
        ->toHaveCount(27)
        ->and($images->pluck('image')->unique())->toHaveCount(27);

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
            ->toStartWith('/images/campuses/tagbina/student-government/')
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

test('the campus profile maps the Tagbina student government details', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $studentGovernment = $campusProfiles['tagbina']['studentGovernment'];

    expect($studentGovernment['adviser'])->toBe('Student Affairs and Services Office')
        ->and($studentGovernment['focus'])
        ->toBe('Leadership development, student engagement, cultural celebration, and community service')
        ->and($studentGovernment['activities'])->toHaveCount(9)
        ->and($studentGovernment)->not->toHaveKey('officers');
});
