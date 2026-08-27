<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class AcademicAffairsController extends Controller
{
    /**
     * Display the public academic affairs page.
     */
    public function __invoke(): Response
    {
        return Inertia::render('academics/AcademicAffairs', [
            'academicAffairs' => $this->academicAffairs(),
        ]);
    }

    /**
     * Dummy academic affairs data shaped for eventual office, college, program, and news queries.
     *
     * @return array{
     *     profile: array{title: string, subtitle: string, summary: string, description: array<int, string>, unitHead: string, role: string, biography: array<int, string>, email: string, phone: string, office: string, heroImage: string, image: string, priorities: array<int, string>},
     *     offices: array<int, array{slug: string, name: string, headTitle: string, head: string, email: ?string, contact: ?string, description: string}>,
     *     colleges: array<int, array{slug: string, title: string}>,
     *     graduateProfessionalStudies: array<int, array{slug: string, title: string}>,
     *     programGroups: array<int, array{slug: string, title: string, category: string, overview: string, colleges: array<int, array{name: string, prospectus: string, objectives: array<int, string>, learningOutcomes: array<int, string>, updates: array<int, array{date: string, title: string, summary: string}>}>}>,
     * }
     */
    private function academicAffairs(): array
    {
        $standardObjectives = [
            'Deliver outcomes-based instruction aligned with professional and community needs.',
            'Strengthen research, extension, and industry exposure within the curriculum.',
            'Prepare graduates for licensure, employment, entrepreneurship, and public service.',
        ];

        $standardOutcomes = [
            'Apply disciplinary knowledge with ethical judgment and professional accountability.',
            'Communicate, collaborate, and solve problems in local and global contexts.',
            'Use technology and evidence-based practices to support sustainable development.',
        ];

        $standardUpdates = [
            [
                'date' => 'June 2026',
                'title' => 'Program prospectus review scheduled',
                'summary' => 'Placeholder notice for curriculum review and prospectus validation.',
            ],
            [
                'date' => 'May 2026',
                'title' => 'College news feed preparation',
                'summary' => 'Dummy update reserved for official academic announcements.',
            ],
        ];

        return [
            'profile' => [
                'title' => 'Office of the Vice President for Academic Affairs',
                'subtitle' => 'Academic Affairs',
                'summary' => 'The OVPAA provides leadership and strategic direction for academic programs, instructional services, and academic support systems across the University.',
                'description' => [
                    'The Office of the Vice President for Academic Affairs (OVPAA) serves as the University\'s highest academic authority, exercising general supervision over all colleges and academic-related service offices of North Eastern Mindanao State University. It provides leadership and strategic direction in the implementation, coordination, supervision, and continuous improvement of academic programs, instructional services, and academic support systems to ensure quality and excellence in higher education. Guided by the University\'s vision of becoming a research university advancing technology and innovation for sustainable development, the OVPAA supervises and coordinates all academic units, colleges, and programs of the University, including curriculum development and enhancement, instructional quality, faculty development and assignments, accreditation initiatives, and student academic support services aligned with CHED standards and institutional goals.',
                    'The Office also recommends academic policies to the University President concerning curricula, faculty appointments and assignments, academic standards, and the opening and implementation of academic programs. In collaboration with educational institutions, government agencies, industry partners, and other stakeholders, the OVPAA promotes academic partnerships, inter-program complementation, and efficient resource maximization to strengthen academic linkages, research, innovation, and community engagement initiatives. Anchored on the University\'s mission of driving sustainable development through quality instruction, innovative research, community collaboration, and technological advancement, the OVPAA fosters a culture of academic excellence, accountability, responsiveness, compassion, and service in developing competent, innovative, globally competitive, and service-oriented graduates.',
                ],
                'unitHead' => 'Maria Lady Sol A. Suazo, Ph.D.',
                'role' => 'Vice President for Academic Affairs',
                'biography' => [
                    'Maria Lady Sol A. Suazo, Ph.D., serves as the Vice President for Academic Affairs (VPAA) of North Eastern Mindanao State University. She is an experienced academic administrator with an extensive background in teacher education, executive leadership, and academic affairs. With years of experience in higher education administration, she has demonstrated strong expertise in curriculum development, academic quality assurance, accreditation, strategic planning, and institutional management.',
                    'Dr. Suazo earned her Doctor of Philosophy in Applied Linguistics and has consistently contributed to the advancement of academic excellence through effective leadership, innovative educational practices, and collaborative academic initiatives. As a Professor V, she is committed to strengthening instructional quality, fostering research and professional development, and promoting global academic collaboration to support institutional growth and student success. Her leadership reflects the University\'s commitment to transformative education, sustainable development, and globally competitive academic standards.',
                ],
                'email' => 'ovpaa@nemsu.edu.ph',
                'phone' => '(086) 214-0005',
                'office' => 'OVPAA Office, NEMSU Tandag Campus',
                'heroImage' => '/images/administration/ovpaf/6I3A7029(1).jpg',
                'image' => '/images/administration/ovpaa/VPAA.webp',
                'priorities' => [
                    'Curriculum development and academic quality assurance',
                    'Faculty instruction support and program monitoring',
                    'Academic policy coordination across campuses',
                    'Student learning outcomes and program accreditation readiness',
                ],
            ],
            'offices' => OvpaaOfficeController::summaries(),
            'colleges' => CollegeController::summaries(),
            'graduateProfessionalStudies' => GraduateProfessionalStudyController::summaries(),
            'programGroups' => [
                [
                    'slug' => 'undergraduate-programs',
                    'title' => 'Undergraduate Programs',
                    'category' => 'Program Offerings',
                    'overview' => 'Dummy undergraduate program information grouped by college for future campus and college records.',
                    'colleges' => [
                        $this->collegeProgram(
                            name: 'College of Teacher Education',
                            prospectus: 'Sample prospectus covering general education, professional education, specialization courses, field study, and teaching internship.',
                            objectives: $standardObjectives,
                            learningOutcomes: $standardOutcomes,
                            updates: $standardUpdates,
                        ),
                        $this->collegeProgram(
                            name: 'College of Engineering and Technology',
                            prospectus: 'Sample prospectus covering mathematics, engineering sciences, design courses, laboratory work, practicum, and capstone projects.',
                            objectives: $standardObjectives,
                            learningOutcomes: $standardOutcomes,
                            updates: $standardUpdates,
                        ),
                        $this->collegeProgram(
                            name: 'College of Business and Management',
                            prospectus: 'Sample prospectus covering business core courses, accounting, management, entrepreneurship, practicum, and business research.',
                            objectives: $standardObjectives,
                            learningOutcomes: $standardOutcomes,
                            updates: $standardUpdates,
                        ),
                    ],
                ],
                [
                    'slug' => 'graduate-school-programs',
                    'title' => 'Graduate School Programs',
                    'category' => 'Advanced Studies',
                    'overview' => 'Dummy graduate school content for masteral and doctoral program pages.',
                    'colleges' => [
                        $this->collegeProgram(
                            name: 'Graduate School Programs',
                            prospectus: 'Sample prospectus for graduate coursework, research methods, specialization seminars, comprehensive examination, and thesis or dissertation writing.',
                            objectives: $standardObjectives,
                            learningOutcomes: $standardOutcomes,
                            updates: $standardUpdates,
                        ),
                    ],
                ],
                [
                    'slug' => 'college-of-law',
                    'title' => 'College of Law',
                    'category' => 'Professional Program',
                    'overview' => 'Dummy law program information ready for official prospectus, program outcomes, and college news.',
                    'colleges' => [
                        $this->collegeProgram(
                            name: 'College of Law',
                            prospectus: 'Sample prospectus for legal foundations, procedural law, clinical legal education, legal ethics, and bar preparation courses.',
                            objectives: [
                                'Develop competent legal professionals committed to justice, ethics, and public service.',
                                'Strengthen analytical writing, oral advocacy, legal research, and case preparation.',
                                'Prepare students for the bar examinations and responsive legal practice.',
                            ],
                            learningOutcomes: [
                                'Analyze legal problems using statutes, jurisprudence, and procedural rules.',
                                'Prepare legal documents and arguments with professional responsibility.',
                                'Serve communities through ethical, rights-based, and accessible legal support.',
                            ],
                            updates: $standardUpdates,
                        ),
                    ],
                ],
                [
                    'slug' => 'college-of-medicine',
                    'title' => 'College of Medicine',
                    'category' => 'Professional Program',
                    'overview' => 'Dummy medicine program information for future college-approved academic content.',
                    'colleges' => [
                        $this->collegeProgram(
                            name: 'College of Medicine',
                            prospectus: 'Sample prospectus for basic medical sciences, clinical rotations, community medicine, research, and internship preparation.',
                            objectives: [
                                'Train future physicians for community-responsive, ethical, and evidence-based practice.',
                                'Develop clinical competence, research literacy, and patient-centered communication.',
                                'Support regional health needs through instruction, service, and extension.',
                            ],
                            learningOutcomes: [
                                'Apply biomedical and clinical knowledge in patient assessment and care planning.',
                                'Communicate with patients, families, and health teams with compassion and clarity.',
                                'Use research and public health principles to address community health priorities.',
                            ],
                            updates: $standardUpdates,
                        ),
                    ],
                ],
            ],
        ];
    }

    /**
     * @param  array<int, string>  $objectives
     * @param  array<int, string>  $learningOutcomes
     * @param  array<int, array{date: string, title: string, summary: string}>  $updates
     * @return array{name: string, prospectus: string, objectives: array<int, string>, learningOutcomes: array<int, string>, updates: array<int, array{date: string, title: string, summary: string}>}
     */
    private function collegeProgram(
        string $name,
        string $prospectus,
        array $objectives,
        array $learningOutcomes,
        array $updates,
    ): array {
        return [
            'name' => $name,
            'prospectus' => $prospectus,
            'objectives' => $objectives,
            'learningOutcomes' => $learningOutcomes,
            'updates' => $updates,
        ];
    }
}
