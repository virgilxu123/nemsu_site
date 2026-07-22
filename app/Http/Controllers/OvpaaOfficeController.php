<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class OvpaaOfficeController extends Controller
{
    /**
     * @var array<string, array{title: string, acronym: string|null, description: string, headTitle: string, head: string, email: string|null, phone: string|null, headImage: string|null}>
     */
    public const OFFICES = [
        'curriculum-development-office' => [
            'title' => 'Curriculum Development Office',
            'acronym' => 'CDO',
            'description' => 'The Curriculum Development Office leads the development, enhancement, review, and evaluation of academic curricula in compliance with CHED policies, institutional standards, and emerging academic trends. It ensures that quality curricular programs, activities, projects, and services are consistently pursued across the seven campuses of the University through curriculum mapping, syllabus alignment, curriculum implementation monitoring, and academic quality assurance initiatives. The Office plans, coordinates, and facilitates curriculum review, realignment, updating, and enrichment; monitors the implementation of recommendations from accreditation surveys; serves as the link between the University and accrediting bodies; and coordinates with the Budget Office regarding the financial requirements of priority academic programs, activities, and projects.',
            'headTitle' => 'Director',
            'head' => 'Dr. Karla Jeane P. Roz-Estrada',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'university-library-office' => [
            'title' => 'University Library Office',
            'acronym' => 'ULO',
            'description' => 'The University Library Office supervises library operations, learning resources, and academic research support services across the University Library System. It oversees both the Main Campus Library and the External Campus Libraries, ensuring compliance with minimum CHED Library Standards through licensed librarians and qualified support staff. The Main Campus Library includes specialized unit libraries such as the Undergraduate Library, Graduate School Library, Law Library, and Medical Library, each supported by Technical Library Services and Readers Services. The Office assists in disseminating the University Vision, Mission, Goals, and Objectives through educational activities and coordinates with librarians across campuses to strengthen library programs. It also establishes linkages, networking, and cooperative activities with institutions and funding agencies to enhance library facilities, resources, and services.',
            'headTitle' => 'Director',
            'head' => 'Vacant',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'national-service-training-program-office' => [
            'title' => 'National Service Training Program (NSTP) Office',
            'acronym' => 'NSTP',
            'description' => 'The NSTP Office supervises the implementation of the National Service Training Program and promotes civic engagement, volunteerism, patriotism, and student participation in community-oriented programs. It plans, coordinates, organizes, implements, supervises, and evaluates NSTP component activities assigned by the University while coordinating with government agencies and partner organizations for program support, assistance, and collaborative initiatives.',
            'headTitle' => 'Director',
            'head' => 'Dr. Laurence P. Bazan',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'culture-arts-and-sports-office' => [
            'title' => 'Culture, Arts, and Sports Office',
            'acronym' => 'CASO',
            'description' => 'The Culture, Arts, and Sports Office supervises and coordinates cultural, artistic, athletic, and recreational programs and activities of the University. It recommends policies and guidelines on socio-cultural and sports activities; plans and implements programs that promote holistic student development, creativity, discipline, sportsmanship, and cultural appreciation; and coordinates activities across all campuses. The Office prepares socio-cultural activities for internal and external engagements, conducts research on arts and industry trends, and represents the University in conferences and showcases related to arts and culture. In sports development, it coordinates athletics and physical education programs, implements athletic rules and standards, oversees training for coaches and instructors, promotes student participation in competitions, and engages in strategic planning for athletic funding, competition strategies, and evaluation systems for athletes and coaches.',
            'headTitle' => 'Director',
            'head' => 'Dr. Shyla O. Moreno',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'student-welfare-and-development-office' => [
            'title' => 'Student Welfare and Development Office',
            'acronym' => 'SWDO',
            'description' => 'The Student Welfare and Development Office oversees student welfare programs, discipline management, leadership development initiatives, student organizations, and support services of the University. It directs the planning, implementation, and evaluation of student affairs services and coordinates with Campus OSWD Heads and other university units to ensure efficient delivery of student programs and services. The Office supervises organized student activities, implements rules and regulations governing student organizations, accredits and monitors student organizations, and promotes student leadership, empowerment, accountability, and social responsibility. It also prepares the annual calendar of activities, oversees OSWD trust funds, enforces disciplinary measures, and represents the University in seminars, workshops, and related activities.',
            'headTitle' => 'Director',
            'head' => 'Dr. Evelyn T. Bagood',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'university-registrar-office' => [
            'title' => 'University Registrar Office',
            'acronym' => 'URO',
            'description' => 'The University Registrar Office manages enrollment processes, academic records, graduation requirements, and the issuance of official academic documents. It evaluates student records and Transcript of Records, interprets enrollment policies and conditions, prepares diplomas and semestral enrollment reports, and maintains accurate student records. The Office participates in the formulation of academic policies concerning admission, enrollment, and graduation; evaluates and confirms academic records for graduation and employment purposes; and issues official documents such as Transcript of Records, Honorable Dismissal, and certifications. It also serves as the University principal liaison with the Commission on Higher Education (CHED) concerning student records and academic documentation.',
            'headTitle' => 'Registrar III',
            'head' => 'Ms. Lynnet A. Sarvida',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'medical-and-dental-office' => [
            'title' => 'Medical and Dental Office',
            'acronym' => null,
            'description' => 'The Medical and Dental University Clinic serves as the primary health service unit of North Eastern Mindanao State University, providing accessible, responsive, and preventive healthcare services to students, faculty, staff, and authorized stakeholders. Headed by the University Physician and supported by the University Dentist, Nurses, Dental Aides, and Administrative Staff, the Clinic oversees medical consultations, treatment, first aid, dental care, health screenings, wellness campaigns, and preventive health programs. It maintains confidential health records, coordinates with hospitals and government health agencies for referrals and emergency response, and provides medical assistance during university activities and emergencies. The Clinic also promotes health education, sanitation, safety, and environmental health awareness within the University community.',
            'headTitle' => 'Unit Head',
            'head' => 'To be announced',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'instructional-materials-development-office' => [
            'title' => 'Instructional Materials Development Office',
            'acronym' => 'IMDO',
            'description' => 'The Instructional Materials Development Office promotes and sustains the development of high-quality, research-based instructional materials for use in all academic programs of the University. It ensures that instructional materials developed by faculty members undergo proper review, assessment, and evaluation prior to institutional adoption. The Office revises and updates instructional materials to align with current academic trends, coordinates with subject matter experts to ensure accuracy and relevance, and provides technical assistance and leadership in the development of innovative and technology-based learning resources. It also designs and implements capability-building and training activities related to instructional materials development to optimize student learning and instructional effectiveness.',
            'headTitle' => 'Unit Head',
            'head' => 'To be announced',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'international-affairs-office' => [
            'title' => 'International Affairs Office',
            'acronym' => 'OIA',
            'description' => 'The International Affairs Office oversees internationalization initiatives, global partnerships, academic linkages, and foreign engagements of the University in accordance with CMO No. 55, series of 2016 on the Internationalization of Philippine Higher Education. The Office recommends policies and guidelines on internationalization, plans and implements international activities and partnerships, prepares procurement and project support plans, and coordinates with national government agencies and the Department of Foreign Affairs to ensure sound international collaborations. It also provides technical support, data analysis, project documentation, and policy recommendations related to internationalization efforts and global academic engagement.',
            'headTitle' => 'Director',
            'head' => 'Dr. Ermie Lux L. Matildo',
            'email' => 'oia@nemsu.edu.ph',
            'phone' => null,
            'headImage' => null,
        ],
        'guidance-and-counselling-office' => [
            'title' => 'Guidance and Counselling Office',
            'acronym' => 'GCO',
            'description' => 'The Guidance and Counselling Office assists the University in promoting the holistic development and well-being of students through comprehensive guidance and counseling services. It provides individual, group, academic, and career counseling services; information and orientation programs; testing and appraisal services; individual inventory services; career guidance and placement programs; follow-up services; evaluation and research activities; and consultation and referral services. The Office supports students in self-understanding, decision-making, academic adjustment, career planning, and personal development through developmental, preventive, and remedial interventions. It also supervises guidance counselors and coordinators across campuses to ensure the effective implementation of guidance programs and services.',
            'headTitle' => 'Guidance Counselor III',
            'head' => 'Ms. Jenevieve P. Babao',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
    ];

    /**
     * @return array<int, array{slug: string, name: string, headTitle: string, head: string, email: ?string, contact: ?string, description: string}>
     */
    public static function summaries(): array
    {
        return collect(self::OFFICES)
            ->map(fn (array $office, string $slug): array => [
                'slug' => $slug,
                'name' => $office['title'],
                'headTitle' => $office['headTitle'],
                'head' => $office['head'],
                'email' => $office['email'],
                'contact' => $office['phone'],
                'description' => $office['description'],
            ])
            ->values()
            ->all();
    }

    public function show(string $office): Response
    {
        abort_unless(array_key_exists($office, self::OFFICES), 404);

        return Inertia::render('academics/OvpaaOffice', [
            'office' => [
                'slug' => $office,
                ...self::OFFICES[$office],
            ],
            'offices' => collect(self::OFFICES)
                ->map(fn (array $office, string $slug): array => [
                    'slug' => $slug,
                    'title' => $office['title'],
                ])
                ->values(),
        ]);
    }
}
