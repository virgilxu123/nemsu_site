<?php

test('the Tagbina campus profile uses the official campus details', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $tagbina = $campusProfiles['tagbina'];

    expect($tagbina)
        ->location->toBe('Poblacion, Tagbina, Surigao del Sur, 8308, Philippines')
        ->and($tagbina['profile']['headline'])
        ->toBe('A vital educational hub serving the southern municipalities of Surigao del Sur.')
        ->and($tagbina['profile']['overview'])
        ->toContain('accessible, high-quality public higher education')
        ->toContain('5th spot nationally in the Licensure Examination for Teachers')
        ->toContain('95.06% passing rate')
        ->toContain('Bachelor of Agricultural Technology')
        ->toContain('AACCUP-accredited programs in Business Administration')
        ->toContain('renewable energy, poverty alleviation, and entrepreneurship')
        ->and($tagbina['profile']['highlights'])
        ->toBe([
            'Top-performing teacher education',
            'Agriculture and technology excellence',
            'Community-based research and extension',
        ])
        ->and($tagbina['director'])
        ->toMatchArray([
            'name' => 'Ariston O. Ronquillo, DM',
            'role' => 'Campus Director',
            'email' => 'aoronquillo@nemsu.edu.ph',
            'phone' => '086-628-0714',
            'photo' => '/images/campuses/tagbina/campus-director.jpg',
        ])
        ->and($tagbina['contact'])
        ->toMatchArray([
            'address' => 'Poblacion, Tagbina, Surigao del Sur, 8308, Philippines',
            'email' => 'aoronquillo@nemsu.edu.ph',
            'phone' => '086-628-0714',
            'officeHours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
        ]);
});

test('the Tagbina campus director portrait from the source document is available', function () {
    expect(dirname(__DIR__, 2).'/public/images/campuses/tagbina/campus-director.jpg')
        ->toBeFile();
});

test('the Tagbina campus lists its official programs under the corresponding colleges', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['tagbina']['programs'])->toBe([
        [
            'college' => 'College of Teacher Education',
            'offerings' => [
                'Bachelor of Secondary Education major in Science',
                'Bachelor of Elementary Education',
            ],
        ],
        [
            'college' => 'College of Agriculture and Forestry',
            'offerings' => [
                'Bachelor of Agricultural Technology',
                'Bachelor of Science in Agriculture',
            ],
        ],
        [
            'college' => 'College of Business and Management',
            'offerings' => [
                'Bachelor of Science in Business Administration major in Financial Management',
                'Bachelor of Science in Business Administration major in Human Resource Management',
                'Bachelor of Science in Hospitality Management major in Hotel and Restaurant Management',
            ],
        ],
        [
            'college' => 'College of Information Technology Education',
            'offerings' => [
                'Bachelor of Science in Computer Science',
            ],
        ],
    ])->and($campusProfiles['tagbina']['stats'][2])->toMatchArray([
        'label' => 'Program Offerings',
        'value' => '8',
    ]);
});
