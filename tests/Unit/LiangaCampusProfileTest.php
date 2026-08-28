<?php

test('the Lianga campus profile uses the supplied official history and institutional focus', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $lianga = $campusProfiles['lianga'];

    expect($lianga)
        ->location->toBe('Poblacion, Lianga, Surigao del Sur 8307')
        ->and($lianga['profile']['headline'])
        ->toBe('A Beacon of Academic Distinction and Sustainable Development in Southern Surigao del Sur.')
        ->and($lianga['profile']['overview'])
        ->toContain('established as Lianga Junior High School')
        ->toContain('Republic Act No. 3528')
        ->toContain('Batas Pambansa Blg. 627')
        ->toContain('Republic Act No. 7377')
        ->toContain('Republic Act No. 9998')
        ->toContain('Republic Act No. 11584')
        ->toContain('National University/College of Fisheries (NUCAF) for the Caraga Region')
        ->toContain('Compassion, Accountability, Responsiveness, Excellence, and Service')
        ->and($lianga['profile']['highlights'])
        ->toBe([
            'Center for Fisheries and Marine Sciences',
            'Sustainable coastal development',
            'Community-based research and extension',
        ])
        ->and($lianga['director'])
        ->toMatchArray([
            'name' => 'Ivy M. Orcullo, PhD',
            'role' => 'OIC-Campus Director',
            'email' => 'nemsulianga@nemsu.edu.ph',
            'phone' => '0956-831-0202',
            'photo' => '/images/campuses/lianga/campus-director.jpg',
        ])
        ->and($lianga['contact'])
        ->toMatchArray([
            'address' => 'Poblacion, Lianga, Surigao del Sur 8307',
            'email' => 'nemsulianga@nemsu.edu.ph',
            'phone' => '0956-831-0202',
            'officeHours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
        ]);
});

test('the supplied Lianga campus director portrait is available', function () {
    $portraitPath = dirname(__DIR__, 2).'/public/images/campuses/lianga/campus-director.jpg';
    $portraitDetails = getimagesize($portraitPath);

    expect($portraitPath)
        ->toBeFile()
        ->and($portraitDetails)->not->toBeFalse()
        ->and($portraitDetails[0])->toBe(1080)
        ->and($portraitDetails[1])->toBe(1135)
        ->and($portraitDetails['mime'])->toBe('image/jpeg');
});

test('the Lianga campus lists its official programs under the corresponding colleges', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['lianga']['programs'])->toBe([
        [
            'college' => 'College of Fisheries and Aquatic Sciences',
            'offerings' => [
                'Bachelor of Science in Fisheries',
                'Bachelor of Science in Marine Biology',
            ],
        ],
        [
            'college' => 'College of Arts and Sciences',
            'offerings' => [
                'Bachelor of Science in Environmental Science',
            ],
        ],
        [
            'college' => 'College of Teacher Education',
            'offerings' => [
                'Bachelor of Elementary Education',
                'Bachelor of Secondary Education major in Science',
            ],
        ],
        [
            'college' => 'College of Business and Management',
            'offerings' => [
                'Bachelor of Science in Business Administration major in Financial Management',
                'Bachelor of Science in Business Administration major in Business Economics',
                'Bachelor of Science in Hospitality Management',
            ],
        ],
        [
            'college' => 'College of Information Technology Education',
            'offerings' => [
                'Bachelor of Science in Computer Science',
            ],
        ],
    ])->and($campusProfiles['lianga']['stats'][3])->toMatchArray([
        'label' => 'Program Offerings',
        'value' => '9',
    ]);
});

test('the Lianga campus reuses available Google Drive prospectuses from academics', function () {
    $lianga = require dirname(__DIR__, 2).'/config/campuses/lianga.php';

    expect($lianga['prospectuses'])->toBe([
        'Bachelor of Science in Environmental Science' => 'https://drive.google.com/file/d/1lIzDz-7LT2jjxdGSVCmVoVZBpHJtBvv1/view?usp=sharing',
        'Bachelor of Elementary Education' => 'https://drive.google.com/file/d/1c622TJNlLex_qkCVSZjFqrbGWM0YTJGu/view?usp=sharing',
        'Bachelor of Secondary Education major in Science' => 'https://drive.google.com/file/d/1eKvwfzmZ23XCeV71manrkPWFlAUHbiPk/view?usp=sharing',
        'Bachelor of Science in Business Administration major in Financial Management' => 'https://drive.google.com/file/d/1sfbRgyn8ZJfMxXq_RAodHlHtGvgxDUva/view?usp=sharing',
        'Bachelor of Science in Hospitality Management' => 'https://drive.google.com/file/d/1EV-UYg6qD4cj1vnCuXTHSLHp4IyfNqHl/view?usp=sharing',
        'Bachelor of Science in Computer Science' => 'https://drive.google.com/file/d/1m4HVwVJCCvJ9ZkayVEutMhI3r6KCSX6e/view?usp=sharing',
    ]);
});
