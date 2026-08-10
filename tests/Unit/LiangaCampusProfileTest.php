<?php

test('the Lianga campus profile uses the supplied official history and institutional focus', function () {
    $campusProfiles = require dirname(__DIR__, 2).'/config/campus_profiles.php';
    $lianga = $campusProfiles['lianga'];

    expect($lianga['profile']['headline'])
        ->toBe('A beacon of academic distinction and sustainable development in Southern Surigao del Sur.')
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
        ]);
});
