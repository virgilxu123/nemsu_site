<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class GraduateProfessionalStudyController extends Controller
{
    /**
     * @var array<string, array{title: string, overview: string, campuses: array<int, array{name: string, courses: array<int, string>}>}>
     */
    public const STUDIES = [
        'graduate-school' => [
            'title' => 'Graduate School',
            'overview' => 'The Graduate School offers advanced master\'s and doctoral programs across education, technology education, computing, business, and public administration through graduate instruction, research, and professional development.',
            'campuses' => [
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Master in Teaching Technology Education (MTTE) major in Drafting Technology',
                        'Master in Teaching Technology Education (MTTE) major in Automotive Technology',
                        'Master in Teaching Technology Education (MTTE) major in Electrical Technology',
                        'Master in Teaching Technology Education (MTTE) major in Food Technology',
                        'Master in Teaching Technology Education (MTTE) major in Garments Technology',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Doctor of Education in Educational Management',
                        'Doctor of Education in English Language Teaching',
                        'Doctor of Philosophy in Science Education',
                        'Doctor of Philosophy in Mathematics Education',
                        'Master of Arts in Education major in Educational Management',
                        'Master of Arts in English Language Teaching',
                        'Master of Arts in Filipino Language Teaching',
                        'Master of Arts in Home Economics Teaching',
                        'Master of Arts in Social Sciences Teaching',
                        'Master of Science in Teaching Mathematics',
                        'Master of Science in Teaching Science',
                        'Master of Science in Computer Science',
                        'Master in Business Administration',
                        'Master in Public Administration',
                    ],
                ],
            ],
        ],
        'college-of-law' => [
            'title' => 'College of Law',
            'overview' => 'The College of Law provides professional legal education through Juris Doctor and ladderized legal studies pathways that develop legal knowledge, advocacy, ethical practice, and public service.',
            'campuses' => [
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Juris Doctor (4 Years)',
                        'Juris Doctor (5 Years)',
                        'Ladderized Master of Legal Studies - Juris Doctor Degree',
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
        return collect(self::STUDIES)
            ->map(fn (array $study, string $slug): array => [
                'slug' => $slug,
                'title' => $study['title'],
            ])
            ->values()
            ->all();
    }

    public function show(string $study): Response
    {
        abort_unless(array_key_exists($study, self::STUDIES), 404);

        return Inertia::render('academics/GraduateProfessionalStudy', [
            'study' => [
                'slug' => $study,
                ...self::STUDIES[$study],
            ],
            'studies' => self::summaries(),
        ]);
    }
}
