<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
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
            'photo' => '/images/academics/colleges/gs.png',
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
            'programDetails' => [
                'Master in Teaching Technology Education (MTTE) major in Drafting Technology' => [
                    'description' => 'The Master in Teaching Technology Education major in Drafting Technology program enhances advanced knowledge, pedagogical competence, and technical expertise in architectural and engineering drafting, computer-aided design (CAD), technical drawing, and instructional methodologies. It prepares educators and professionals to deliver quality technology education, develop innovative instructional practices, and promote excellence in drafting and design education.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1IUB78rDX4q4DGZb1s3WJtSTM0_bedtuA/view?usp=sharing',
                ],
                'Master in Teaching Technology Education (MTTE) major in Automotive Technology' => [
                    'description' => 'The Master in Teaching Technology Education major in Automotive Technology program provides advanced competencies in automotive systems, diagnostics, maintenance, repair technologies, and technical-vocational pedagogy. It prepares educators, trainers, and industry practitioners to lead in automotive technology instruction, curriculum development, research, and technical skills advancement.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1Q-2XnFyspf7ZBVwEF8vV8JEACRMSFwJM/view?usp=sharing',
                ],
                'Master in Teaching Technology Education (MTTE) major in Electrical Technology' => [
                    'description' => 'The Master in Teaching Technology Education major in Electrical Technology program develops advanced knowledge and instructional competencies in electrical systems, installation, maintenance, troubleshooting, and electrical technology education. It prepares graduates to become effective educators, trainers, and leaders in technical-vocational and technology-based education programs.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1jUKlX1tO602TS0uXOOS296WbKZYH5m_F/view?usp=sharing',
                ],
                'Master in Teaching Technology Education (MTTE) major in Food Technology' => [
                    'description' => 'The Master in Teaching Technology Education major in Food Technology program equips students with advanced competencies in food processing, food safety, product development, nutrition, quality assurance, and technology education. It prepares educators and professionals to contribute to food technology instruction, research, innovation, and sustainable food production practices.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1FW9k27gXaAI2Lv86VtCrrusb-aYpm4IV/view?usp=sharing',
                ],
                'Master in Teaching Technology Education (MTTE) major in Garments Technology' => [
                    'description' => 'The Master in Teaching Technology Education major in Garments Technology program provides advanced knowledge and technical expertise in garment production, fashion design, textiles, apparel technology, and instructional methodologies. It prepares graduates to become competent educators, researchers, and industry practitioners capable of promoting innovation, creativity, and excellence in garments and fashion technology education.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1BPIzIdjts5J9yh7yA39Hg5lMhQMxbmfD/view?usp=sharing',
                ],
                'Doctor of Education in Educational Management' => [
                    'description' => 'The Doctor of Education in Educational Management program develops advanced competencies in educational leadership, policy development, organizational management, strategic planning, and academic administration. It prepares educational leaders, administrators, and policymakers to effectively manage educational institutions, implement reforms, and promote excellence, innovation, and quality assurance in education',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1nwiWk_llUwR037UnQ2qL5T0uwXNB6vwo/view?usp=sharing',
                ],
                'Doctor of Education in English Language Teaching' => [
                    'description' => 'The Doctor of Education in English Language Teaching program provides advanced studies in language education, linguistics, curriculum development, research, and innovative teaching methodologies in English instruction. It prepares graduates to become experts, researchers, and leaders in English language education committed to advancing language teaching and learning in diverse educational settings.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1pUlbcd71HB7V-5bdXDCXjjULJKzuu2iT/view?usp=sharing',
                ],
                'Doctor of Philosophy in Science Education' => [
                    'description' => 'The Doctor of Philosophy in Science Education program develops advanced research capabilities, scientific literacy, curriculum expertise, and innovative pedagogical approaches in science teaching and learning. It prepares graduates to become scholars, researchers, educational leaders, and curriculum specialists in science education who contribute to the advancement of scientific knowledge and transformative science instruction.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1S6GehITzkq4nS95ga9s1mZYIwgdEZ08R/view?usp=sharing',
                ],
                'Doctor of Philosophy in Mathematics Education' => [
                    'description' => 'The Doctor of Philosophy in Mathematics Education program equips students with advanced knowledge and research competencies in mathematics teaching, curriculum development, assessment, educational innovation, and quantitative inquiry. It prepares graduates to become leaders, researchers, and specialists in mathematics education committed to improving mathematics instruction and learner achievement.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1e4BZpjfop_-c9FDjkf009NZPhaGlQUS4/view?usp=sharing',
                ],
                'Master of Arts in Education major in Educational Management' => [
                    'description' => 'The Master of Arts in Education major in Educational Management program enhances professional competencies in school leadership, educational planning, supervision, curriculum management, and organizational administration. It prepares educators and academic leaders to effectively manage educational institutions and promote quality, efficiency, and innovation in education.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/116qsB1eElSOgPYiLCXAKIEJPmKQjhyQD/view?usp=sharing',
                ],
                'Master of Arts in English Language Teaching' => [
                    'description' => 'The Master of Arts in English Language Teaching program develops advanced competencies in English language instruction, applied linguistics, curriculum design, language assessment, and research. It prepares educators to become effective language teaching professionals, researchers, and instructional leaders in English education.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1gmzWNrfcR2UU-BfnBRLH772ujj4Y7oLD/view?usp=sharing',
                ],
                'Master of Arts in Filipino Language Teaching' => [
                    'description' => 'The Master of Arts in Filipino Language Teaching program provides advanced studies in Filipino language education, literature, pedagogy, curriculum development, and research. It prepares educators and scholars to strengthen Filipino language instruction, cultural appreciation, and language-based research and development.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/19OAxEIZLoFUZHRnjYS7ovHhszbHzFm-h/view?usp=sharing',
                ],
                'Master of Arts in Home Economics Teaching' => [
                    'description' => 'The Master of Arts in Home Economics Teaching program develops advanced knowledge and instructional competencies in home economics, family resource management, entrepreneurship, food and nutrition, clothing and textiles, and livelihood education. It prepares educators to deliver innovative and relevant instruction in home economics and related disciplines.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1bY3u654WLUX74pTCRpKK5jPcvSIk3NvE/view?usp=sharing',
                ],
                'Master of Arts in Social Sciences Teaching' => [
                    'description' => 'The Master of Arts in Social Sciences Teaching program enhances professional and research competencies in social sciences education, including history, political science, sociology, economics, and culture. It prepares educators to become effective social science teachers, curriculum developers, and researchers committed to promoting critical thinking, civic responsibility, and social awareness.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1U0BSjtEWAaUCtCKJ8A3vkijN9o4QAt5f/view?usp=sharing',
                ],
                'Master of Science in Teaching Mathematics' => [
                    'description' => 'The Master of Science in Teaching Mathematics program provides advanced knowledge and pedagogical expertise in mathematics instruction, curriculum design, assessment, educational research, and quantitative analysis. It prepares educators to deliver innovative and effective mathematics instruction and contribute to the advancement of mathematics education.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1W8-erRTU7nNvtKncZDSMvuaijrBEykrt/view?usp=sharing',
                ],
                'Master of Science in Teaching Science' => [
                    'description' => 'The Master of Science in Teaching Science program develops advanced competencies in science instruction, curriculum innovation, scientific inquiry, educational research, and laboratory-based teaching methodologies. It prepares educators to become effective science teachers, researchers, and instructional leaders in science education.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1gzhFM3GEgdlTuOPMj1IRPt_-icTzzzZu/view?usp=sharing',
                ],
                'Master of Science in Computer Science' => [
                    'description' => 'The Master of Science in Computer Science program provides advanced studies in software development, artificial intelligence, data science, computational theory, systems analysis, and emerging computing technologies. It prepares graduates for leadership, research, innovation, and advanced professional practice in computing and information technology fields.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1AxiZEqcvafhSjmv_QeW4u5BlWRQPVGVw/view?usp=sharing',
                ],
                'Master in Business Administration' => [
                    'description' => 'The Master in Business Administration program develops advanced competencies in business management, leadership, strategic planning, entrepreneurship, financial management, marketing, and organizational development. It prepares professionals and executives to effectively manage organizations, lead business innovation, and address complex managerial challenges in dynamic business environments.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1adW5w52fQ6xTDTMDsn_SjieAr3K4iwJX/view?usp=sharing',
                ],
                'Master in Public Administration' => [
                    'description' => 'The Master in Public Administration program equips students with advanced knowledge and skills in public governance, policy analysis, organizational leadership, public finance, and public sector management. It prepares graduates for leadership roles in government agencies, non-government organizations, and public institutions while promoting ethical governance, accountability, and responsive public service.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/159Fo4Nn5uWOka9xIgVDKQhbe7aZl9p-3/view?usp=sharing',
                ],
            ],
        ],
        'college-of-law' => [
            'title' => 'College of Law',
            'photo' => '/images/academics/colleges/col.png',
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
            'programDetails' => [
                'Juris Doctor (4 Years)' => [
                    'description' => 'The Juris Doctor (4 Years) program provides comprehensive legal education and professional training in constitutional law, civil law, criminal law, political law, labor law, commercial law, remedial law, legal ethics, and legal research. It prepares students to become competent, ethical, and socially responsible legal practitioners equipped with analytical, advocacy, and critical thinking skills necessary for the practice of law, public service, and the promotion of justice and the rule of law.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/14P8OpSLu2KGFzw2C7qpc_FD5TXKNZp2l/view?usp=sharing',
                ],
                'Juris Doctor (5 Years)' => [
                    'description' => 'The Juris Doctor (5 Years) program offers an extended and flexible pathway to legal education designed to accommodate working professionals and students requiring a longer academic duration. It provides comprehensive training in legal principles, jurisprudence, advocacy, legal writing, and ethical legal practice while developing graduates capable of contributing to the administration of justice, public service, and legal scholarship.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1mZC_5aJ7qTZOJ3NBEbIcpn95yC730SLU/view?usp=sharing',
                ],
                'Ladderized Master of Legal Studies - Juris Doctor Degree' => [
                    'description' => 'The Ladderized Master of Legal Studies – Juris Doctor Degree program combines foundational legal studies with advanced professional legal education through a ladderized academic structure. It equips students with competencies in legal research, policy analysis, governance, advocacy, and legal practice while preparing them for careers in law, public administration, academia, and related fields. The program promotes flexibility in legal education while fostering ethical leadership, critical analysis, and commitment to justice and public service.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1sSYxnxSZ_Ypj_I9vKUjycMSPCgprjydi/view?usp=sharing',
                ],
            ],
        ],
        'college-of-medicine' => [
            'title' => 'College of Medicine',
            'photo' => '',
            'overview' => 'The College of Medicine provides quality medical education and clinical training that develop competent, compassionate, and ethical healthcare professionals committed to addressing the healthcare needs of local communities and producing homegrown doctors who will serve the province of Surigao del Sur and the region.',
            'campuses' => [
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Doctor of Medicine (MD)',
                    ],
                ],
            ],
            'programDetails' => [
                'Doctor of Medicine (MD)' => [
                    'description' => 'The Doctor of Medicine (MD) program provides comprehensive education in medical sciences and clinical practice, preparing students to become competent, ethical, and socially responsible physicians equipped to serve their communities and contribute to improving local healthcare.',
                    'prospectusUrl' => '',
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

    /**
     * @return array<string, string>
     */
    public static function prospectusUrlsForCampus(string $campusName): array
    {
        return collect(self::STUDIES)
            ->flatMap(function (array $study) use ($campusName): array {
                $programDetails = $study['programDetails'] ?? [];

                return collect($study['campuses'])
                    ->where('name', $campusName)
                    ->flatMap(fn (array $campus): array => collect($campus['courses'])
                        ->mapWithKeys(function (string $course) use ($programDetails): array {
                            $prospectusUrl = $programDetails[$course]['prospectusUrl'] ?? null;

                            return filled($prospectusUrl)
                                ? [$course => $prospectusUrl]
                                : [];
                        })
                        ->all())
                    ->all();
            })
            ->all();
    }

    /**
     * @param  array{
     *     title: string,
     *     photo: string,
     *     overview: string,
     *     campuses: array<int, array{name: string, courses: array<int, string>}>,
     *     programDetails?: array<string, array{description: string, prospectusUrl: string|null}>
     * }  $study
     * @return array<int, array{id: string, title: string, campuses: array<int, string>, description: string|null, prospectusUrl: string|null}>
     */
    private static function programsFor(array $study): array
    {
        $programDetails = $study['programDetails'] ?? [];

        return collect($study['campuses'])
            ->flatMap(fn (array $campus): array => collect($campus['courses'])
                ->map(fn (string $course): array => [
                    'id' => str($course)->slug(),
                    'title' => $course,
                    'campus' => $campus['name'],
                ])
                ->all()
            )
            ->groupBy('title')
            ->map(fn ($offerings, string $title): array => [
                'id' => 'program-'.Str::slug($title),
                'title' => $title,
                'campuses' => $offerings->pluck('campus')->unique()->values()->all(),
                'description' => $programDetails[$title]['description'] ?? null,
                'prospectusUrl' => $programDetails[$title]['prospectusUrl'] ?? null,
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
                'programs' => self::programsFor(self::STUDIES[$study]),
            ],
            'studies' => self::summaries(),
        ]);
    }
}
