<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class CampusController extends Controller
{
    /**
     * Display a public campus profile.
     */
    public function show(string $campus): Response
    {
        $campuses = $this->campuses();
        $campusProfile = $campuses[$campus] ?? null;

        abort_if($campusProfile === null, 404);

        return Inertia::render('campuses/Show', [
            'campus' => $campusProfile,
            'campuses' => array_values($campuses),
        ]);
    }

    /**
     * Dummy campus data shaped for an eventual Campus + CampusProfile query.
     *
     * @return array<string, array{
     *     slug: string,
     *     name: string,
     *     label: string,
     *     location: string,
     *     heroImage: string,
     *     secondaryImage: string,
     *     profile: array{headline: string, overview: string, highlights: array<int, string>},
     *     director: array{name: string, role: string, office: string, email: string, phone: string, photo: string},
     *     contact: array{address: string, email: string, phone: string, officeHours: string},
     *     stats: array<int, array{label: string, value: string, note: string}>,
     *     facilities: array<int, string>,
     *     programs: array<int, array{college: string, offerings: array<int, string>}>,
     *     campusLife: array<int, string>,
     *     services: array<int, string>,
     *     studentGovernment: array{name: string, adviser: string, focus: string, initiatives: array<int, string>},
     *     updates: array<int, array{date: string, title: string, summary: string}>
     * }>
     */
    private function campuses(): array
    {
        $sharedFacilities = [
            'Learning resource center',
            'Computer and innovation laboratories',
            'Student activity and wellness spaces',
            'Registrar and admission service counters',
        ];

        $sharedPrograms = [
            [
                'college' => 'College of Teacher Education',
                'offerings' => [
                    'Bachelor of Elementary Education',
                    'Bachelor of Secondary Education',
                    'Professional education units',
                ],
            ],
            [
                'college' => 'College of Business and Technology',
                'offerings' => [
                    'Bachelor of Science in Information Technology',
                    'Bachelor of Science in Business Administration',
                    'Industrial technology ladderized programs',
                ],
            ],
        ];

        $sharedServices = [
            'Admission and enrollment assistance',
            'Registrar records and certification',
            'Guidance, counseling, and student wellness',
            'Scholarship and financial aid coordination',
            'Library and digital learning support',
        ];

        return [
            'tandag' => $this->campusProfile(
                slug: 'tandag',
                name: 'Tandag Campus',
                label: 'Main Campus',
                location: 'Tandag City, Surigao del Sur',
                headline: 'The system hub for academic leadership, research, and university-wide services.',
                overview: 'NEMSU Tandag serves as the main campus and administrative center, connecting instruction, research, extension, and public service across the university system.',
                highlights: ['Central administration', 'Graduate studies', 'Medicine and allied programs'],
                director: 'Dr. Milborne B. Sample',
                focus: 'Student services modernization',
                facilities: [...$sharedFacilities, 'University auditorium', 'Research and extension center'],
                programs: [
                    [
                        'college' => 'College of Engineering and Technology',
                        'offerings' => ['Civil Engineering', 'Computer Engineering', 'Information Technology'],
                    ],
                    [
                        'college' => 'Graduate and Professional Studies',
                        'offerings' => ['Graduate education programs', 'College of Law', 'College of Medicine'],
                    ],
                ],
                services: $sharedServices,
            ),
            'cantilan' => $this->campusProfile(
                slug: 'cantilan',
                name: 'Cantilan Campus',
                label: 'Technology Education',
                location: 'Cantilan, Surigao del Sur',
                headline: 'A northern campus focused on technology skills, teacher preparation, and community extension.',
                overview: 'NEMSU Cantilan supports learners from northern Surigao del Sur through practical education, student support, and responsive academic programs.',
                highlights: ['Industrial technology', 'Teacher education', 'Community extension'],
                director: 'Dr. Andrea M. Placeholder',
                focus: 'Skills-based instruction',
                facilities: $sharedFacilities,
                programs: $sharedPrograms,
                services: $sharedServices,
            ),
            'san-miguel' => $this->campusProfile(
                slug: 'san-miguel',
                name: 'San Miguel Campus',
                label: 'Agriculture and Forestry',
                location: 'San Miguel, Surigao del Sur',
                headline: 'Field-centered learning for agriculture, forestry, and rural development.',
                overview: 'NEMSU San Miguel provides a learning environment close to agricultural communities, field laboratories, and extension partners.',
                highlights: ['Agro-forestry', 'Field laboratories', 'Rural development'],
                director: 'Dr. Renato L. Placeholder',
                focus: 'Agri-innovation and extension',
                facilities: [...$sharedFacilities, 'Agriculture demonstration farm', 'Forestry field laboratory'],
                programs: [
                    [
                        'college' => 'College of Agriculture and Forestry',
                        'offerings' => ['Agriculture', 'Forestry', 'Environmental resource management'],
                    ],
                    $sharedPrograms[0],
                ],
                services: $sharedServices,
            ),
            'lianga' => $this->campusProfile(
                slug: 'lianga',
                name: 'Lianga Campus',
                label: 'Fisheries and Marine Sciences',
                location: 'Lianga, Surigao del Sur',
                headline: 'A coastal campus advancing marine, fisheries, and community-based education.',
                overview: 'NEMSU Lianga is positioned for marine resource education, coastal community partnerships, and student-centered campus life.',
                highlights: ['Marine sciences', 'Aquaculture', 'Coastal extension'],
                director: 'Dr. Celeste R. Placeholder',
                focus: 'Coastal resource learning',
                facilities: [...$sharedFacilities, 'Marine science laboratory', 'Aquaculture training area'],
                programs: [
                    [
                        'college' => 'College of Fisheries and Marine Sciences',
                        'offerings' => ['Fisheries', 'Marine biology support programs', 'Aquaculture technology'],
                    ],
                    $sharedPrograms[1],
                ],
                services: $sharedServices,
            ),
            'cagwait' => $this->campusProfile(
                slug: 'cagwait',
                name: 'Cagwait Campus',
                label: 'Industrial Technology',
                location: 'Cagwait, Surigao del Sur',
                headline: 'A coastal campus for technical programs, student formation, and local service.',
                overview: 'NEMSU Cagwait combines technical instruction with accessible campus services for learners in coastal communities.',
                highlights: ['Technology programs', 'Coastal access', 'Student formation'],
                director: 'Dr. Marlon P. Placeholder',
                focus: 'Technical education access',
                facilities: $sharedFacilities,
                programs: $sharedPrograms,
                services: $sharedServices,
            ),
            'tagbina' => $this->campusProfile(
                slug: 'tagbina',
                name: 'Tagbina Campus',
                label: 'Community-Based Education',
                location: 'Tagbina, Surigao del Sur',
                headline: 'Southern Surigao del Sur access point for academic programs and public service.',
                overview: 'NEMSU Tagbina expands access to quality education through community-based instruction and student support services.',
                highlights: ['Accessible programs', 'Community partnerships', 'Southern cluster services'],
                director: 'Dr. Liza T. Placeholder',
                focus: 'Community learning pathways',
                facilities: $sharedFacilities,
                programs: $sharedPrograms,
                services: $sharedServices,
            ),
            'bislig' => $this->campusProfile(
                slug: 'bislig',
                name: 'Bislig Campus',
                label: 'Agroforestry and Industry',
                location: 'Bislig City, Surigao del Sur',
                headline: 'A southern campus connecting agroforestry, industry, and professional education.',
                overview: 'NEMSU Bislig supports regional development through industry-aligned programs, extension work, and student services.',
                highlights: ['Agroforestry', 'Industry alignment', 'Professional education'],
                director: 'Dr. Victor S. Placeholder',
                focus: 'Regional workforce development',
                facilities: [...$sharedFacilities, 'Technical workshop spaces', 'Extension project rooms'],
                programs: [
                    [
                        'college' => 'College of Industrial Technology',
                        'offerings' => ['Industrial technology', 'Information technology', 'Business technology'],
                    ],
                    $sharedPrograms[0],
                ],
                services: $sharedServices,
            ),
        ];
    }

    /**
     * @param  array<int, string>  $highlights
     * @param  array<int, string>  $facilities
     * @param  array<int, array{college: string, offerings: array<int, string>}>  $programs
     * @param  array<int, string>  $services
     * @return array<string, mixed>
     */
    private function campusProfile(
        string $slug,
        string $name,
        string $label,
        string $location,
        string $headline,
        string $overview,
        array $highlights,
        string $director,
        string $focus,
        array $facilities,
        array $programs,
        array $services,
    ): array {
        return [
            'slug' => $slug,
            'name' => $name,
            'label' => $label,
            'location' => $location,
            'heroImage' => 'https://nemsu.edu.ph/files/News/cm-00.jpg',
            'secondaryImage' => 'https://www.nemsu.edu.ph/files/News/reaffirmation-commitment-to-innovation-and-sustainable-development-01.jpg',
            'profile' => [
                'headline' => $headline,
                'overview' => $overview,
                'highlights' => $highlights,
            ],
            'director' => [
                'name' => $director,
                'role' => 'Campus Director',
                'office' => 'Office of the Campus Director',
                'email' => $slug.'@nemsu.edu.ph',
                'phone' => '(086) 214-0000',
                'photo' => 'https://nemsu.edu.ph/assets/images/NEMSU.png',
            ],
            'contact' => [
                'address' => $location,
                'email' => $slug.'@nemsu.edu.ph',
                'phone' => '(086) 214-0000',
                'officeHours' => 'Monday to Friday, 8:00 AM - 5:00 PM',
            ],
            'stats' => [
                ['label' => 'Student Population', 'value' => '4,280', 'note' => 'Sample enrollment'],
                ['label' => 'Faculty and Staff', 'value' => '126', 'note' => 'Sample personnel count'],
                ['label' => 'Program Offerings', 'value' => (string) collect($programs)->sum(fn (array $program): int => count($program['offerings'])), 'note' => 'Dummy academic count'],
                ['label' => 'Campus Updates', 'value' => '3', 'note' => 'Recent placeholder posts'],
            ],
            'facilities' => $facilities,
            'programs' => $programs,
            'campusLife' => [
                'Student organizations and leadership activities',
                'Culture, arts, and sports engagement',
                'Community extension and volunteer programs',
                'Wellness, guidance, and peer support initiatives',
            ],
            'services' => $services,
            'studentGovernment' => [
                'name' => 'University Student Government - '.$name,
                'adviser' => 'Student Affairs and Services Office',
                'focus' => $focus,
                'initiatives' => [
                    'Student consultation and representation',
                    'Campus events and leadership formation',
                    'Service desks for student concerns',
                ],
            ],
            'updates' => [
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
}
