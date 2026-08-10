<?php

test('the Tagbina campus uses the supplied updates and publication posters', function () {
    $tagbina = require dirname(__DIR__, 2).'/config/campuses/tagbina.php';
    $updates = $tagbina['updates'];

    expect($updates)
        ->toHaveCount(5)
        ->and(array_column($updates, 'date'))->toBe([
            'June 11–12, 2026',
            'Date not specified in source',
            'December 2025 CFMS Examination',
            'September 2025 LET',
            'November 2025 LEA',
        ])
        ->and(array_column($updates, 'title'))->toBe([
            'A Triumphant Sweep: Tagbina’s Future Educators Shine on the International Stage',
            'From Freshman to Regional Champion: NEMSU-Tagbina’s Junenyl Pada Heads to the Nationals',
            'Financial Excellence: NEMSU-Tagbina Surpasses National Average in CFMS Exam, Produces Top 8 Placer',
            'A Three-Peat of Excellence: NEMSU-Tagbina Cements Status as Top-Performing School in the LET',
            'Cultivating Success: NEMSU-Tagbina Produces 62 New Agriculturists, Dominates Regional and National Averages',
        ]);

    $images = collect($updates)->flatMap(
        fn (array $update): array => $update['images'],
    );

    expect($images)
        ->toHaveCount(5)
        ->and($images->pluck('image')->unique())->toHaveCount(5);

    foreach ($updates as $update) {
        expect($update)
            ->toHaveKeys(['date', 'title', 'summary', 'images'])
            ->and($update['summary'])->not->toBeEmpty()
            ->and($update['images'])->toHaveCount(1);
    }

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/tagbina/updates/')
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

    expect($campusProfiles['tagbina']['updates'])->toBe($updates);
});
