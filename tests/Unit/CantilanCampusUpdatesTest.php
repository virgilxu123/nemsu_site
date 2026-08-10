<?php

test('the Cantilan campus uses the supplied January to May 2026 updates', function () {
    $cantilan = require dirname(__DIR__, 2).'/config/campuses/cantilan.php';
    $updates = $cantilan['updates'];

    expect($updates)
        ->toHaveCount(10)
        ->and(array_column($updates, 'date'))->toBe([
            'February 2026',
            'January–May 2026',
            'January–May 2026',
            'January–May 2026',
            'January–May 2026',
            'January–May 2026',
            'January–May 2026',
            'March 2026',
            'January–May 2026',
            'January–May 2026',
        ])
        ->and(array_column($updates, 'title'))->toBe([
            'Cantilan Produces Two Criminologist Licensure Examination Topnotchers',
            'Campus Continues to Uphold Institutional Excellence',
            'ROTC Unit Earns Outstanding RAATI 2026 Rating',
            'Cantilan Successfully Hosts Techno Fair 2026',
            'Russiana Mae Ouano Wins Regional Tawag ng Tanghalan',
            'Rex Brian E. Pude Ranks Top 4 in Master Electrician Licensure Examination',
            'John Michael Pradas Places Second Runner-Up in Battle of the Brains Season 4',
            'Cantilan Receives Best Campus Award at PRAISE 2026',
            'Dr. Juancho A. Intano Marks 12 Years as Campus Director',
            'Cantilan Extends Relief to Tropical Storm Basyang Survivors',
        ])
        ->and(collect($updates)->pluck('title')->unique())->toHaveCount(10);

    foreach ($updates as $update) {
        expect($update)
            ->toHaveKeys(['date', 'title', 'summary'])
            ->and($update['date'])->not->toBeEmpty()
            ->and($update['title'])->not->toBeEmpty()
            ->and($update['summary'])->not->toBeEmpty();
    }

    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['cantilan']['updates'])->toBe($updates);
});
