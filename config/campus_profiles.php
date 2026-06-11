<?php

$definitions = [
    require __DIR__.'/campuses/tandag.php',
    require __DIR__.'/campuses/cantilan.php',
    require __DIR__.'/campuses/san-miguel.php',
    require __DIR__.'/campuses/lianga.php',
    require __DIR__.'/campuses/cagwait.php',
    require __DIR__.'/campuses/tagbina.php',
    require __DIR__.'/campuses/bislig.php',
];

$sharedCampusLife = [
    'Student organizations and leadership activities',
    'Culture, arts, and sports engagement',
    'Community extension and volunteer programs',
    'Wellness, guidance, and peer support initiatives',
];

$sharedServices = [
    'Admission and enrollment assistance',
    'Registrar records and certification',
    'Guidance, counseling, and student wellness',
    'Scholarship and financial aid coordination',
    'Library and digital learning support',
];

$campuses = [];

foreach ($definitions as $definition) {
    $slug = $definition['slug'];
    $name = $definition['name'];
    $programCount = array_sum(array_map(
        static fn (array $program): int => count($program['offerings']),
        $definition['programs'],
    ));

    $campuses[$slug] = [
        'slug' => $slug,
        'name' => $name,
        'label' => $definition['label'],
        'location' => $definition['location'],
        'heroImage' => $definition['heroImage'] ?? 'https://nemsu.edu.ph/files/News/cm-00.jpg',
        'secondaryImage' => $definition['secondaryImage'] ?? 'https://www.nemsu.edu.ph/files/News/reaffirmation-commitment-to-innovation-and-sustainable-development-01.jpg',
        'profile' => [
            'headline' => $definition['headline'],
            'overview' => $definition['overview'],
            'highlights' => $definition['highlights'],
        ],
        'director' => [
            'name' => $definition['director'],
            'role' => 'Campus Director',
            'office' => 'Office of the Campus Director',
            'email' => $definition['directorEmail'] ?? $slug.'@nemsu.edu.ph',
            'phone' => $definition['phone'] ?? '(086) 214-0000',
            'photo' => $definition['directorPhoto'] ?? 'https://nemsu.edu.ph/assets/images/NEMSU.png',
        ],
        'contact' => [
            'address' => $definition['location'],
            'email' => $definition['email'] ?? $slug.'@nemsu.edu.ph',
            'phone' => $definition['phone'] ?? '(086) 214-0000',
            'officeHours' => $definition['officeHours'] ?? 'Monday to Friday, 8:00 AM - 5:00 PM',
        ],
        'stats' => $definition['stats'] ?? [
            ['label' => 'Student Population', 'value' => '4,280', 'note' => 'Sample enrollment'],
            ['label' => 'Faculty and Staff', 'value' => '126', 'note' => 'Sample personnel count'],
            ['label' => 'Program Offerings', 'value' => (string) $programCount, 'note' => 'Dummy academic count'],
            ['label' => 'Campus Updates', 'value' => '3', 'note' => 'Recent placeholder posts'],
        ],
        'facilities' => $definition['facilities'],
        'facilityGallery' => $definition['facilityGallery'] ?? [],
        'programs' => $definition['programs'],
        'prospectuses' => $definition['prospectuses'] ?? [],
        'campusLife' => $definition['campusLife'] ?? $sharedCampusLife,
        'services' => $definition['services'] ?? $sharedServices,
        'serviceHighlights' => $definition['serviceHighlights'] ?? [],
        'studentGovernment' => [
            'name' => 'University Student Government - '.$name,
            'adviser' => 'Student Affairs and Services Office',
            'focus' => $definition['focus'],
            'initiatives' => $definition['initiatives'] ?? [
                'Student consultation and representation',
                'Campus events and leadership formation',
                'Service desks for student concerns',
            ],
            'activities' => $definition['studentGovernmentActivities'] ?? [],
        ],
        'updates' => $definition['updates'] ?? [
            [
                'date' => 'June 2026',
                'title' => $name.' prepares updated campus profile content',
                'summary' => 'Placeholder update reserved for the official campus news feed.',
            ],
            [
                'date' => 'May 2026',
                'title' => 'Student services directory refresh',
                'summary' => 'Dummy entry for registrar, guidance, admission, and scholarship service notices.',
            ],
            [
                'date' => 'April 2026',
                'title' => 'Program offering review underway',
                'summary' => 'Sample announcement for upcoming curriculum and program page updates.',
            ],
        ],
    ];
}

return $campuses;
