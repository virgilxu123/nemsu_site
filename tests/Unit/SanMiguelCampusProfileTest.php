<?php

test('the San Miguel campus profile uses the official campus details', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $sanMiguel = $campusProfiles['san-miguel'];

    expect($sanMiguel)
        ->location->toBe('Purok 5, Carromata, San Miguel, Philippines')
        ->and($sanMiguel['profile']['headline'])
        ->toBe('A premier institution for agriculture and forestry education in Surigao del Sur.')
        ->and($sanMiguel['profile']['overview'])
        ->toContain('Established in 1953 as the Surigao National Agricultural School')
        ->toContain('Republic Act No. 11584')
        ->toContain('Its 789-hectare site—the largest among the NEMSU campuses')
        ->toContain('cultivating unity within the indigenous communities it serves')
        ->toContain('Bachelor of Science in Agriculture major in Crop Science')
        ->not->toContain('Bachelor of Science in Agriculture major in Agronomy')
        ->and($sanMiguel['director'])
        ->toMatchArray([
            'name' => 'Marvie V. Gonzaga, EdD',
            'role' => 'OIC – Campus Director',
            'email' => null,
            'photo' => '/images/campuses/san-miguel/campus-director.jpg',
        ])
        ->and($sanMiguel['contact'])
        ->toMatchArray([
            'address' => 'Purok 5, Carromata, San Miguel, Philippines',
            'email' => 'campusinfo_nemsusm@nemsu.edu.ph',
            'phone' => null,
            'officeHours' => null,
        ]);
});

test('the San Miguel campus director portrait from the source document is available', function () {
    expect(dirname(__DIR__, 2).'/public/images/campuses/san-miguel/campus-director.jpg')
        ->toBeFile();
});

test('the San Miguel campus lists its official undergraduate degree programs', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['san-miguel']['programs'])->toBe([
        [
            'college' => 'College of Teacher Education',
            'offerings' => [
                'Bachelor of Technology and Livelihood Education (BTLEd) – Major in Home Economics',
            ],
        ],
        [
            'college' => 'College of Agriculture and Forestry',
            'offerings' => [
                'Bachelor of Science in Forestry (BSF)',
                'Bachelor of Science in Agriculture (BSA) – Major in Crop Science',
            ],
        ],
    ]);
});

test('the San Miguel campus life reflects the supplied student experience narrative', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['san-miguel']['campusLife'])->toBe([
        'Hands-on laboratory work, agricultural production, forestry field activities, nursery management, and agroforestry demonstrations',
        'Tree planting, environmental conservation, biodiversity protection, climate resilience, and sustainable agriculture',
        'Student leadership through the University Student Government, departmental organizations, academic clubs, cultural groups, sports organizations, and environmental associations',
        'FarmBuilders student publication documenting campus events, student achievements, campus developments, and community stories',
        'Local, regional, and national competitions, academic conferences, leadership summits, sports events, cultural presentations, research competitions, and skills demonstrations',
        'Sports festivals, cultural celebrations, environmental campaigns, leadership camps, extension projects, and institutional events',
        'Field exposure, internships, research, extension activities, and community-based learning with local government units, farmers’ organizations, cooperatives, Indigenous communities, and national agencies',
        'A welcoming, inclusive community supported by faculty mentorship and friendships across municipalities and cultural backgrounds',
    ]);
});

test('the San Miguel director and visit sections follow the Tandag content structure', function () {
    $campusPage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/campuses/Show.vue',
    );

    expect($campusPage)
        ->toContain('{{ campus.director.office }}')
        ->toContain('{{ campus.contact.address }}')
        ->toContain('{{ campus.contact.email }}')
        ->toContain('{{ campus.contact.phone }}')
        ->toContain('{{ campus.contact.officeHours }}')
        ->toContain('v-if="campus.contact.phone"')
        ->toContain('v-if="campus.contact.officeHours"')
        ->not->toContain('v-if="campus.director.email"')
        ->not->toContain('campus.contact.facebookUrl');
});
