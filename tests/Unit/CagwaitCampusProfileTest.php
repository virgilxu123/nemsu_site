<?php

test('the Cagwait campus profile uses the supplied official details', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $cagwait = $campusProfiles['cagwait'];

    expect($cagwait)
        ->location->toBe('Purok 3, Poblacion, Cagwait, Surigao del Sur, 8304')
        ->and($cagwait['profile']['headline'])
        ->toBe('Campus Profile of North Eastern Mindanao State University – Cagwait Campus')
        ->and($cagwait['profile']['overview'])
        ->toContain('As the only tertiary institution in the municipality')
        ->toContain('near the famous Cagwait White Beach')
        ->toContain('community-centered service, continuous institutional development')
        ->toContain('competent, skilled, innovative, and values-oriented graduates')
        ->and($cagwait['profile']['highlights'])
        ->toBe([
            'Accessible and free education',
            'Community-centered service',
            'Industry-relevant programs',
        ])
        ->and($cagwait['director'])
        ->toMatchArray([
            'name' => 'Rozette E. Mercado, PhD',
            'role' => 'Professor III / OIC-Campus Director',
            'email' => 'remercado@nemsu.edu.ph',
            'phone' => '09457390082',
            'photo' => '/images/campuses/cagwait/campus-director.jpg',
        ])
        ->and($cagwait['contact'])
        ->toMatchArray([
            'address' => 'Purok 3, Poblacion, Cagwait, Surigao del Sur, 8304',
            'email' => 'cagwait@nemsu.edu.ph',
            'phone' => null,
            'officeHours' => null,
        ]);
});

test('the supplied Cagwait campus director portrait is available', function () {
    $portraitPath = dirname(__DIR__, 2).'/public/images/campuses/cagwait/campus-director.jpg';
    $portraitDetails = getimagesize($portraitPath);

    expect($portraitPath)
        ->toBeFile()
        ->and($portraitDetails)->not->toBeFalse()
        ->and($portraitDetails['mime'])->toBe('image/jpeg');
});
