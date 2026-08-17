<?php

test('campus profiles publish the official campuswide statistics', function (
    string $campus,
    array $expectedStatistics,
) {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles[$campus]['stats'])->toBe($expectedStatistics);
})->with([
    'Bislig' => [
        'bislig',
        [
            ['label' => 'Student Population (1st Semester)', 'value' => '1,787', 'note' => 'AY 2025–2026'],
            ['label' => 'Student Population (2nd Semester)', 'value' => '1,630', 'note' => 'AY 2025–2026'],
            ['label' => 'Faculty and Staff', 'value' => '106', 'note' => 'As of December 31, 2025'],
            ['label' => 'Program Offerings', 'value' => '7', 'note' => 'Academic programs'],
        ],
    ],
    'Cagwait' => [
        'cagwait',
        [
            ['label' => 'Student Population (1st Semester)', 'value' => '1,107', 'note' => 'AY 2025–2026'],
            ['label' => 'Student Population (2nd Semester)', 'value' => '1,028', 'note' => 'AY 2025–2026'],
            ['label' => 'Faculty and Staff', 'value' => '79', 'note' => 'As of December 31, 2025'],
            ['label' => 'Program Offerings', 'value' => '6', 'note' => 'Academic programs'],
        ],
    ],
    'Cantilan' => [
        'cantilan',
        [
            ['label' => 'Student Population (1st Semester)', 'value' => '8,723', 'note' => 'AY 2025–2026'],
            ['label' => 'Student Population (2nd Semester)', 'value' => '8,658', 'note' => 'AY 2025–2026'],
            ['label' => 'Faculty and Staff', 'value' => '358', 'note' => 'As of December 31, 2025'],
            ['label' => 'Program Offerings', 'value' => '31', 'note' => '26 undergraduate · 5 postgraduate'],
        ],
    ],
    'Lianga' => [
        'lianga',
        [
            ['label' => 'Student Population (1st Semester)', 'value' => '6,996', 'note' => 'AY 2025–2026'],
            ['label' => 'Student Population (2nd Semester)', 'value' => '6,740', 'note' => 'AY 2025–2026'],
            ['label' => 'Faculty and Staff', 'value' => '208', 'note' => 'As of December 31, 2025'],
            ['label' => 'Program Offerings', 'value' => '9', 'note' => 'Academic programs'],
        ],
    ],
    'San Miguel' => [
        'san-miguel',
        [
            ['label' => 'Student Population (1st Semester)', 'value' => '815', 'note' => 'AY 2025–2026'],
            ['label' => 'Student Population (2nd Semester)', 'value' => '728', 'note' => 'AY 2025–2026'],
            ['label' => 'Faculty and Staff', 'value' => '108', 'note' => 'As of December 31, 2025'],
            ['label' => 'Program Offerings', 'value' => '3', 'note' => 'Academic programs'],
        ],
    ],
    'Tagbina' => [
        'tagbina',
        [
            ['label' => 'Student Population (1st Semester)', 'value' => '3,469', 'note' => 'AY 2025–2026'],
            ['label' => 'Student Population (2nd Semester)', 'value' => '3,243', 'note' => 'AY 2025–2026'],
            ['label' => 'Faculty and Staff', 'value' => '142', 'note' => 'As of December 31, 2025'],
            ['label' => 'Program Offerings', 'value' => '8', 'note' => 'Academic programs'],
        ],
    ],
    'Tandag' => [
        'tandag',
        [
            ['label' => 'Student Population (1st Semester)', 'value' => '11,732', 'note' => 'AY 2025–2026'],
            ['label' => 'Student Population (2nd Semester)', 'value' => '10,741', 'note' => 'AY 2025–2026'],
            ['label' => 'Faculty and Staff', 'value' => '562', 'note' => 'As of December 31, 2025'],
            ['label' => 'Program Offerings', 'value' => '43', 'note' => '25 undergraduate · 14 postgraduate · 1 College of Medicine · 3 College of Law'],
        ],
    ],
]);
