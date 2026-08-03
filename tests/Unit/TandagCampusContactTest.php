<?php

test('the Tandag campus contact details are configured', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['tandag'])
        ->location->toBe('Rosario, Tandag City, 8300, Surigao del Sur, Philippines')
        ->and($campusProfiles['tandag']['contact'])
        ->toMatchArray([
            'address' => 'Rosario, Tandag City, 8300, Surigao del Sur, Philippines',
            'email' => 'cd.tandag@nemsu.edu.ph',
            'phone' => '(086) 214-0000',
            'officeHours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
        ]);
});
