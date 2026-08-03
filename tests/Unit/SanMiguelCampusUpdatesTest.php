<?php

test('the San Miguel campus updates use the supplied dated notices', function () {
    $sanMiguel = require dirname(__DIR__, 2).'/config/campuses/san-miguel.php';
    $updates = $sanMiguel['updates'];

    expect($updates)
        ->toHaveCount(7)
        ->and(array_column($updates, 'date'))->toBe([
            'July 30, 2026',
            'July 17, 2026',
            'July 16, 2026',
            'June 18, 2026',
            'June 17, 2026',
            'June 15, 2026',
            'June 12, 2026',
        ])
        ->and(array_column($updates, 'title'))->toBe([
            'Innovation in Action, Service in Heart: NEMSU Celebrates 5th Founding Anniversary',
            'Inter-Agency IEC Campaign Empowers NEMSU–San Miguel Students',
            'NEMSU–San Miguel Joins Araw ng Carromata and Nutrition Month Celebration',
            'NEMSU–San Miguel Class of 2026 Embarks on New Horizons',
            'Class of 2026 Reflects Through Baccalaureate Services',
            'DSWD Cash-for-Work Program Culminates with Payout and Recognition',
            'San Miguel Marks 128th Independence Day',
        ]);

    $images = collect($updates)->flatMap(
        fn (array $update): array => $update['images'],
    );

    expect($images)
        ->toHaveCount(34)
        ->and($images->pluck('image')->unique())->toHaveCount(34);

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
            ->and($image['image'])->toStartWith('/images/campuses/san-miguel/updates/')
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

    expect($campusProfiles['san-miguel']['updates'])->toBe($updates);
});

test('the campus updates support optional document photos', function () {
    $component = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($component)
        ->toContain('images?: {')
        ->toContain('v-if="update.images?.length"')
        ->toContain('v-for="image in update.images"')
        ->toContain('snap-mandatory')
        ->toContain('loading="lazy"')
        ->toContain('{{ update.images.length }}');
});
