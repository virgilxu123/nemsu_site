<?php

test('the Cagwait campus life uses the supplied organizations and photos', function () {
    $cagwait = require dirname(__DIR__, 2).'/config/campuses/cagwait.php';
    $highlights = $cagwait['campusLifeHighlights'];

    expect($cagwait['campusLife'])
        ->toBe([
            'The Coastal Chronicles',
            'Malaya Dance Troupe',
            'Campus Ministry',
        ])
        ->and($cagwait['campusLifeOverview'])->not->toBeEmpty()
        ->and($highlights)->toHaveCount(3)
        ->and(array_column($highlights, 'title'))->toBe($cagwait['campusLife']);

    $images = collect($highlights)->flatMap(
        fn (array $highlight): array => $highlight['images'],
    );

    expect($images)
        ->toHaveCount(8)
        ->and($images->pluck('image')->unique())->toHaveCount(8);

    foreach ($highlights as $highlight) {
        expect($highlight)
            ->toHaveKeys(['title', 'description', 'images'])
            ->and($highlight['description'])->not->toBeEmpty()
            ->and($highlight['images'])->not->toBeEmpty();
    }

    foreach ($images as $image) {
        $publicPath = dirname(__DIR__, 2).'/public'.$image['image'];

        expect($image)
            ->toHaveKeys(['image', 'alt'])
            ->and($image['image'])->toStartWith('/images/campuses/cagwait/campus-life/')
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

    expect($campusProfiles['cagwait']['campusLifeOverview'])
        ->toBe($cagwait['campusLifeOverview'])
        ->and($campusProfiles['cagwait']['campusLifeHighlights'])->toBe($highlights)
        ->and($campusProfiles['tandag']['campusLifeHighlights'])->toBe([]);
});

test('the campus page presents photo-backed campus life without cards or icons', function () {
    $component = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($component)
        ->toContain('v-if="campus.campusLifeHighlights.length"')
        ->toContain('data-campus-life-photo-slider')
        ->toContain('activeCampusLifePhoto')
        ->toContain('v-for="image in highlight.images"')
        ->not->toContain('<HeartHandshake')
        ->not->toContain('<BadgeCheck');
});
