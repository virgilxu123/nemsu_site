<?php

test('the Cagwait campus lists its confirmed program offerings', function () {
    $cagwait = require dirname(__DIR__, 2).'/config/campuses/cagwait.php';

    expect($cagwait['programs'])->toBe([
        [
            'college' => 'College of Business and Management',
            'offerings' => [
                'Bachelor of Science in Hospitality Management',
            ],
        ],
        [
            'college' => 'College of Information Technology Education',
            'offerings' => [
                'Bachelor of Science in Information Technology',
            ],
        ],
        [
            'college' => 'College of Engineering and Technology',
            'offerings' => [
                'Bachelor in Industrial Technology major in Automotive Technology',
                'Bachelor in Industrial Technology major in Electrical Technology',
                'Bachelor in Industrial Technology major in Computer Technology',
                'Bachelor in Industrial Technology major in Culinary Technology',
            ],
        ],
    ]);

    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';

    expect($campusProfiles['cagwait']['programs'])->toBe($cagwait['programs']);
});
