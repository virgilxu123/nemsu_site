<?php

test('the Cantilan campus profile uses the official campus details', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $cantilan = $campusProfiles['cantilan'];

    expect($cantilan)
        ->location->toBe('Pag-antayan, Cantilan, Surigao del Sur, 8317')
        ->and($cantilan['profile']['overview'])
        ->toContain('designated College of Technological Education')
        ->toContain('Licensure Examination for Teachers (LET)')
        ->toContain('Registered Master Electrician Licensure Examination')
        ->and($cantilan['director'])
        ->toMatchArray([
            'name' => 'Juancho A. Intano, PhD',
            'role' => 'Professor V / Campus Director',
            'email' => 'nemsucantilan.cdoffice@gmail.com',
            'phone' => '0907 867 0913',
            'photo' => '/images/campuses/cantilan/campus-director.jpg',
        ])
        ->and($cantilan['contact'])
        ->toMatchArray([
            'address' => 'Pag-antayan, Cantilan, Surigao del Sur, 8317',
            'email' => 'cantilan@nemsu.edu.ph',
        ]);
});

test('the Cantilan campus director uses the supplied portrait', function () {
    $publicPath = dirname(__DIR__, 2).'/public/images/campuses/cantilan/campus-director.jpg';

    expect(file_exists($publicPath))->toBeTrue();

    $dimensions = getimagesize($publicPath);

    expect($dimensions)
        ->not->toBeFalse()
        ->and($dimensions['mime'])->toBe('image/jpeg')
        ->and($dimensions[0])->toBe(1295)
        ->and($dimensions[1])->toBe(1066);
});

test('the Cantilan campus profile lists its official program offerings', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $programs = $campusProfiles['cantilan']['programs'];

    expect(array_column($programs, 'college'))
        ->toBe([
            'Graduate School',
            'College of Teacher Education',
            'College of Criminal Justice Education',
            'College of Business and Management',
            'College of Information Technology Education',
            'College of Engineering and Technology',
        ])
        ->and(array_map(
            static fn (array $program): int => count($program['offerings']),
            $programs,
        ))
        ->toBe([6, 9, 1, 4, 3, 8]);

    $offerings = collect($programs)->flatMap(
        static fn (array $program): array => $program['offerings'],
    );

    expect($offerings)
        ->toHaveCount(31)
        ->toContain('Master in Teaching Technology Education (MTTE) major in Civil Technology')
        ->toContain('Bachelor of Secondary Education (BSEd) major in Science')
        ->toContain('Bachelor of Science in Criminology (BSCrim.)')
        ->toContain('Bachelor of Science in Tourism Management (BSTM)')
        ->toContain('Bachelor of Science in Computer Engineering (BSCpE)')
        ->toContain('Bachelor of Industrial Technology (BIndTech) major in Apparel and Fashion Technology');
});
