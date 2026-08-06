<?php

test('the Cagwait campus uses the supplied updates and document photos', function () {
    $cagwait = require dirname(__DIR__, 2).'/config/campuses/cagwait.php';
    $updates = $cagwait['updates'];

    expect($updates)
        ->toHaveCount(7)
        ->and(array_column($updates, 'date'))->toBe([
            'Ongoing in 2026',
            '2026 Campus Project',
            'May 18, 2026',
            '2026 TESDA Assessment',
            'May 6, 2026',
            'April 28, 2026',
            '2026 Campus Visit',
        ])
        ->and(array_column($updates, 'title'))->toBe([
            'Completion of Campus Gymnasium',
            'School Entry Archway Strengthens Campus Identity',
            'Techno Management Week 2026 Opens with Energy and Teamwork',
            'Electrical Training for TESDA NC II Concludes Assessment',
            'NEMSU-Cagwait BIndTech Wins Big in TechnoFair 2026 Debut',
            'NEMSU Cagwait Celebrates Success in RME Licensure Examination',
            'CHED Officials Commend NEMSU Cagwait for Academic Excellence and COPC Compliance',
        ]);

    $images = collect($updates)->flatMap(
        fn (array $update): array => $update['images'],
    );

    expect($images)
        ->toHaveCount(19)
        ->and($images->pluck('image')->unique())->toHaveCount(19);

    foreach ($updates as $update) {
        expect($update)
            ->toHaveKeys(['date', 'title', 'summary', 'images'])
            ->and($update['summary'])->not->toBeEmpty()
            ->and($update['images'])->not->toBeEmpty();
    }

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/cagwait/updates/')
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

    expect($campusProfiles['cagwait']['updates'])->toBe($updates);
});
