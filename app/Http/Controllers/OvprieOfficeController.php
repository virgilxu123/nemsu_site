<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class OvprieOfficeController extends Controller
{
    /**
     * @var array<string, array{
     *     title: string,
     *     acronym: string,
     *     parent: string,
     *     description: string,
     *     head: string,
     *     email: string|null,
     *     phone: string|null,
     *     headImage: string|null,
     *     suboffices: list<array{title: string, acronym: string|null, description: string}>
     * }>
     */
    private const OFFICES = [
        'university-research-and-innovation-office' => [
            'title' => 'University Research and Innovation Office',
            'acronym' => 'RIDO',
            'parent' => 'Office of the Vice President for Research, Innovation, and Extension',
            'description' => 'The University Research and Innovation Office, led by the Director and in coordination with the Office of the Vice President for Research, Innovation, and Extension (OVPRIE), supports university researchers by overseeing research programs, projects, and activities, recommending policies, and implementing strategic initiatives. The RIDO leads the development of project proposals for funding, fosters inter-campus collaboration, and facilitates the publication, dissemination, and application of research outputs. It also monitors ongoing research, ensures ethical compliance in 4 coordination with the University Research Ethics Committee (UREC), prepares reports, and handles other research-related tasks assigned by the VPRIE.',
            'head' => 'Arturo G. Gracia, Jr., MSci',
            'email' => 'research@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-research.png',
            'suboffices' => [
                [
                    'title' => 'Research Centers',
                    'acronym' => null,
                    'description' => 'Research Centers are integral to advancing the University’s research goals by managing activities, resources, and personnel in alignment with institutional priorities. They foster interdisciplinary collaboration, support grant proposals, and ensure research compliance with ethical and regulatory standards. The centers provide professional development for researchers, track research performance, and advocate for resources and recognition, strengthening their impact within the academic community and beyond.',
                ],
                [
                    'title' => 'Research Operation Office',
                    'acronym' => null,
                    'description' => 'The Research Operation Office serves as the central unit responsible for managing, coordinating, and monitoring the university’s research activities and initiatives. It facilitates the development of quality research programs by providing technical assistance, policy implementation, research monitoring, and administrative support to faculty members, staff, and students. The office also promotes a culture of innovation and scholarly productivity by ensuring that research endeavors align with the university’s goals, community needs, and national development priorities.',
                ],
                [
                    'title' => 'Creative Works Management Office',
                    'acronym' => null,
                    'description' => 'The Creative Works Management Office plays a vital role in overseeing the administration and promotion of creative works produced by the University’s students, faculty, and staff. It develops and implements strategic plans for managing and promoting creative endeavors, fosters collaboration between departments, and allocates resources for production, exhibition, and dissemination. The office also provides guidance on intellectual property rights, organizes exhibitions and performances, and develops marketing strategies to raise awareness. It collaborates with external partners to create opportunities for showcasing and monetizing creative works, while offering support services to enhance the creators\' practice and career prospects.',
                ],
                [
                    'title' => 'Publication and Printing Office',
                    'acronym' => null,
                    'description' => 'The Publication Management Office oversees the entire process of managing the University\'s research journals, ensuring efficient planning, scheduling, and coordination from manuscript submission to final publication. It handles editorial workflows, including peer review, revisions, and editing, while maintaining high standards of quality, ethics, and compliance with publication policies. The office supports authors throughout the publication process, manages content development, and oversees production, including copy-editing and design. It also maintains the journal’s online platform, coordinates indexing, builds partnerships with academic institutions, and manages the journal’s finances and budget.',
                ],
            ],
        ],
        'knowledge-and-technology-transfer-office' => [
            'title' => 'Knowledge and Technology Transfer Office',
            'acronym' => 'KTTO',
            'parent' => 'Office of the Vice President for Research, Innovation, and Extension',
            'description' => 'The Knowledge and Technology Transfer Office identifies, protects, and manages intellectual property, transforms research outputs into viable technologies and market-ready solutions, and builds partnerships with industry, government, and other institutions to support licensing, technology transfer, commercialization, and entrepreneurship.',
            'head' => 'Engr. Luzminda S. Bacquial, PhD',
            'email' => 'itso@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-ktto.jpg',
            'suboffices' => [
                [
                    'title' => 'Innovation and Technology Support Office',
                    'acronym' => 'ITSO',
                    'description' => 'ITSO manages intellectual property assets, IP audits, filings for patents, trademarks, and copyrights, IP databases, policies, awareness activities, inquiries, and dispute support.',
                ],
                [
                    'title' => 'Intellectual Property and Technology Business Management Office',
                    'acronym' => null,
                    'description' => 'This office assesses University technologies for investment readiness, develops technology transfer strategies, negotiates licensing agreements, markets technologies, and supports licensees and spin-off companies.',
                ],
                [
                    'title' => 'Technology Business Incubation Office',
                    'acronym' => 'TBI',
                    'description' => 'The Technology Business Incubation Office supports startups through incubatee selection, mentorship, business planning, market validation, minimum viable product development, investor connections, and incubator operations.',
                ],
            ],
        ],
        'extension-services-and-linkages-office' => [
            'title' => 'Extension Services and Linkages Office',
            'acronym' => 'ESLO',
            'parent' => 'Office of the Vice President for Research, Innovation, and Extension',
            'description' => 'The Extension Services and Linkages Office serves as the bridge between the University and the broader community through education, training, technical assistance, sustainable development partnerships, research-based solutions, community empowerment, and inclusive capacity building.',
            'head' => 'Abundio C. Miralles, EdD',
            'email' => 'extension@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-extension_.jpg',
            'suboffices' => [
                [
                    'title' => 'Extension Planning and Implementation Office',
                    'acronym' => 'EPIO',
                    'description' => 'EPIO designs and implements community-based programs, conducts needs assessments, develops training materials, evaluates effectiveness, supports logistics, and builds partnerships with agencies, industries, NGOs, and communities.',
                ],
                [
                    'title' => 'Monitoring and Impact Assessment Office',
                    'acronym' => null,
                    'description' => 'The Monitoring and Impact Assessment Office conducts field visits, reviews, stakeholder consultations, and third-party impact assessments to strengthen accountability and guide future extension improvements.',
                ],
            ],
        ],
    ];

    public function show(string $office): Response
    {
        abort_unless(array_key_exists($office, self::OFFICES), 404);

        return Inertia::render('research/OvprieOffice', [
            'office' => [
                'slug' => $office,
                ...self::OFFICES[$office],
            ],
            'offices' => collect(self::OFFICES)
                ->map(fn (array $office, string $slug): array => [
                    'slug' => $slug,
                    'title' => $office['title'],
                    'acronym' => $office['acronym'],
                ])
                ->values(),
        ]);
    }
}
