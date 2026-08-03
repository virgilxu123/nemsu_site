<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class CollegeController extends Controller
{
    /**
     * @var array<string, array{title: string, overview: string, campuses: array<int, array{name: string, courses: array<int, string>}>}>
     */
    public const COLLEGES = [
        'college-of-accountancy' => [
            'title' => 'College of Accountancy',
            'overview' => 'The College of Accountancy prepares students for professional practice in accounting, auditing, taxation, financial reporting, and related fields. It develops technically competent, ethical, and service-oriented graduates equipped to meet professional standards and contribute to responsible financial management.',
            'campuses' => [
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Science in Accountancy',
                    ],
                ],
            ],
        ],
        'college-of-agriculture-and-forestry' => [
            'title' => 'College of Agriculture and Forestry',
            'overview' => 'The College of Agriculture and Forestry promotes sustainable agriculture, forestry, environmental stewardship, and natural resource management through instruction, research, and extension services. It prepares graduates to contribute to food security, climate resilience, ecological sustainability, and rural development.',
            'campuses' => [
                [
                    'name' => 'Bislig Campus',
                    'courses' => [
                        'Bachelor of Science in Forestry',
                    ],
                ],
                [
                    'name' => 'San Miguel Campus',
                    'courses' => [
                        'Bachelor of Science in Forestry',
                        'Bachelor of Science in Agriculture- Agronomy',
                    ],
                ],
                [
                    'name' => 'Tagbina Campus',
                    'courses' => [
                        'Bachelor of Science in Agriculture',
                        'Bachelor of Agricultural Technology',
                    ],
                ],
            ],
        ],
        'college-of-arts-and-sciences' => [
            'title' => 'College of Arts and Sciences',
            'overview' => 'The College of Arts and Sciences provides interdisciplinary and foundational education in the humanities, social sciences, natural sciences, and mathematics. It develops critical thinking, communication skills, scientific inquiry, research competence, and social awareness essential for academic, professional, and community engagement.',
            'campuses' => [
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Science in Environmental Science',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Arts in Economics',
                        'Bachelor of Arts in English Language',
                        'Batsilyer ng Sining sa Filipino',
                        'Bachelor of Arts in Political Science',
                        'Bachelor of Science in Biology',
                        'Bachelor of Science in Environmental Science',
                        'Bachelor of Science in Mathematics',
                        'Bachelor of Science in Midwifery',
                    ],
                ],
            ],
        ],
        'college-of-business-and-management' => [
            'title' => 'College of Business and Management',
            'overview' => 'The College of Business and Management prepares students for careers in entrepreneurship, business administration, finance, marketing, operations, and organizational management. It promotes innovation, ethical leadership, strategic thinking, and sustainable economic development through quality business education and industry-responsive programs.',
            'campuses' => [
                [
                    'name' => 'Cagwait Campus',
                    'courses' => [
                        'Bachelor of Science in Hospitality Management',
                    ],
                ],
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Science in Business Administration (BSBA) major in Financial Management',
                        'Bachelor of Science in Business Administration (BSBA) major in Human Resource Management',
                        'Bachelor of Science in Hospitality Management (BSHM)',
                        'Bachelor of Science in Tourism Management (BSTM)',
                    ],
                ],
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Science in Business Administration major in Business Economics',
                        'Bachelor of Science in Business Administration major in Financial Management',
                        'Bachelor of Science in Hospitality Management',
                    ],
                ],
                [
                    'name' => 'Tagbina Campus',
                    'courses' => [
                        'Bachelor of Science in Business Administration major in Financial Management',
                        'Bachelor of Science in Business Administration major in Human Resource Management',
                        'Bachelor of Science in Hospitality Management major in Hotel and Restaurant Management',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Science in Business Administration major in Financial Management',
                        'Bachelor of Science in Business Administration major in Marketing Management',
                        'Bachelor of Science in Business Administration major in Human Resource Management',
                        'Bachelor of Science in Hospitality Management',
                        'Bachelor of Public Administration',
                    ],
                ],
            ],
        ],
        'college-of-criminal-justice-education' => [
            'title' => 'College of Criminal Justice Education',
            'overview' => 'The College of Criminal Justice Education prepares students for careers in criminology, law enforcement, correctional administration, forensic investigation, and public safety services. It promotes discipline, integrity, professionalism, and respect for human rights and justice systems.',
            'campuses' => [
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Science in Criminology',
                    ],
                ],
            ],
        ],
        'college-of-engineering-and-technology' => [
            'title' => 'College of Engineering and Technology',
            'overview' => 'The College of Engineering and Technology provides quality education and training in engineering, industrial, and technological fields through instruction, research, innovation, and extension services. It equips students with technical expertise, problem-solving abilities, practical skills, and ethical values necessary for professional practice, technological advancement, sustainable development, and industry responsiveness in local and global settings.',
            'campuses' => [
                [
                    'name' => 'Bislig Campus',
                    'courses' => [
                        'Bachelor of Science in Electrical Engineering',
                        'Bachelor of Science in Civil Engineering',
                        'Bachelor of Science in Mechanical Engineering',
                    ],
                ],
                [
                    'name' => 'Cagwait Campus',
                    'courses' => [
                        'Bachelor of Science in Industrial Technology major in Automotive Technology',
                        'Bachelor of Science in Industrial Technology major in Electrical Technology',
                        'Bachelor of Science in Industrial Technology major in Culinary Technology',
                        'Bachelor of Science in Industrial Technology major in Computer Technology',
                    ],
                ],
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Industrial Technology (BIndTech) major in Architectural Drafting Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Automotive Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Computer Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Electrical Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Electronics Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Culinary Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Fashion and Apparel Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Mechanical Technology',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Science in Civil Engineering',
                    ],
                ],
            ],
        ],
        'college-of-fisheries-and-aquatic-sciences' => [
            'title' => 'College of Fisheries and Aquatic Sciences',
            'overview' => 'The College of Fisheries and Aquatic Sciences advances education, research, and innovation in fisheries, aquaculture, marine biodiversity, and aquatic resource management. It supports the sustainable utilization, conservation, and protection of aquatic ecosystems and coastal communities.',
            'campuses' => [
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Science in Marine Biology',
                        'Bachelor of Science in Fisheries',
                    ],
                ],
            ],
        ],
        'college-of-information-technology-education' => [
            'title' => 'College of Information Technology Education',
            'overview' => 'The College of Information Technology Education provides quality instruction in computing, information systems, software development, networking, multimedia, and emerging digital technologies. It equips students with technical competencies, problem-solving skills, and innovation capabilities necessary in the rapidly evolving digital and technological environment.',
            'campuses' => [
                [
                    'name' => 'Cagwait Campus',
                    'courses' => [
                        'Bachelor of Science in Information Technology',
                    ],
                ],
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Science in Computer Engineering (BSCpE)',
                        'Bachelor of Science in Computer Science (BSCS)',
                        'Bachelor of Science in Information Technology (BS Info. Tech.)',
                    ],
                ],
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Science in Computer Science',
                    ],
                ],
                [
                    'name' => 'Tagbina Campus',
                    'courses' => [
                        'Bachelor of Science in Computer Science',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Science in Computer Science',
                    ],
                ],
            ],
        ],
        'college-of-teacher-education' => [
            'title' => 'College of Teacher Education',
            'overview' => 'The College of Teacher Education develops competent, innovative, research-oriented, and values-driven educators equipped with pedagogical expertise and professional ethics. It prepares future teachers and education leaders committed to transformative, inclusive, and quality education.',
            'campuses' => [
                [
                    'name' => 'Bislig Campus',
                    'courses' => [
                        'Bachelor of Secondary Education major in English',
                        'Bachelor of Technical-Vocational Teacher Education major in Automotive Technology',
                        'Bachelor of Technical-Vocational Teacher Education major in Electrical Technology',
                    ],
                ],
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Secondary Education (BSEd) major in Science',
                        'Bachelor of Secondary Education (BSEd) major in Mathematics',
                        'Bachelor of Secondary Education (BSEd) major in Filipino',
                        'Bachelor of Secondary Education (BSEd) major in English',
                        'Bachelor of Technology and Livelihood Education (BTLEd) major in Home Economics',
                        'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Automotive Technology',
                        'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Electrical Technology',
                        'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Electronics Technology',
                        'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Food & Services Management',
                        'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Garments, Fashion and Design',
                    ],
                ],
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Elementary Education (BEEd)',
                        'Bachelor of Secondary Education major in Science',
                    ],
                ],
                [
                    'name' => 'San Miguel Campus',
                    'courses' => [
                        'Bachelor of Technology and Livelihood Education major in Home Economics',
                    ],
                ],
                [
                    'name' => 'Tagbina Campus',
                    'courses' => [
                        'Bachelor of Secondary Education major in Science',
                        'Bachelor of Elementary Education major in General Education',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Early Childhood Education',
                        'Bachelor of Elementary Education',
                        'Bachelor of Secondary Education major in English',
                        'Bachelor of Secondary Education major in Filipino',
                        'Bachelor of Secondary Education major in Mathematics',
                        'Bachelor of Secondary Education major in Science',
                        'Bachelor of Physical Education',
                        'Bachelor of Secondary Education Major in Social Studies',
                    ],
                ],
            ],
        ],
    ];

    /**
     * @return array<int, array{slug: string, title: string}>
     */
    public static function summaries(): array
    {
        return collect(self::COLLEGES)
            ->map(fn (array $college, string $slug): array => [
                'slug' => $slug,
                'title' => $college['title'],
            ])
            ->values()
            ->all();
    }

    public function show(string $college): Response
    {
        abort_unless(array_key_exists($college, self::COLLEGES), 404);

        return Inertia::render('academics/College', [
            'college' => [
                'slug' => $college,
                ...self::COLLEGES[$college],
            ],
            'colleges' => self::summaries(),
        ]);
    }
}
