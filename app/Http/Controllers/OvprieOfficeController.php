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
            'description' => 'The Knowledge and Technology Transfer Office (KTTO), led by the Director and in coordination with the Office of the Vice President for Research, Innovation, and Extension (OVPRIE), serves as a key driver of innovation and commercialization within the university. It identifies, protects, and manages intellectual property, ensuring that research outputs are transformed into viable technologies and market-ready solutions. By fostering partnerships with industry, government agencies, and other institutions, KTTO facilitates the commercialization of research through licensing agreements, technology transfer, and entrepreneurial initiatives. Beyond commercialization, it promotes a culture of innovation, knowledge sharing, and interdisciplinary collaboration. Ultimately, KTTO translates research discoveries into tangible societal benefits, contributing to economic growth, technological advancement, and the university’s broader mission of knowledge generation and impact.',
            'head' => 'Engr. Luzminda S. Bacquial, PhD',
            'email' => 'itso@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-ktto-1.jpg',
            'suboffices' => [
                [
                    'title' => 'Innovation and Technology Support Office',
                    'acronym' => 'ITSO',
                    'description' => 'The Innovation and Technology Support Office is responsible for managing the universitys intellectual property (IP) assets, conducting IP audits, and facilitating the filing of patents, trademarks, and copyrights. The office maintains a comprehensive database of IP assets and 6 develops the universitys IP policies, ensuring compliance with national and international laws. It provides guidance on IP rights, offers education and training on IP topics, and promotes IP awareness through various outreach activities. Additionally, the ITSO serves as the primary contact for IP inquiries, handles IP disputes, and supports the University community in navigating IP-related matters.',
                ],
                [
                    'title' => 'Intellectual Property and Technology Business Management Office',
                    'acronym' => null,
                    'description' => 'The Intellectual Property and Technology Business Management Office focus on the commercialization of university technologies by assessing their readiness for investment and market value. It develops technology transfer strategies, negotiates licensing agreements, and markets technologies to potential partners and licensees. The office fosters relationships with industry stakeholders, organizes showcases and networking events, and manages technology transfer agreements to ensure compliance. Additionally, it provides support to licensees and spin-off companies, oversees income-generating projects, and works to maximize the University’s impact through technology commercialization.',
                ],
                [
                    'title' => 'Technology Business Incubation Office',
                    'acronym' => 'TBI',
                    'description' => 'The Technology Business Incubation Office supports the growth of startups by managing the application, selection, and on-boarding of qualified incubatees. It provides access to resources, facilities, and mentorship, guiding them through business planning, market analysis, and financial management. The office helps refine business models, conducts market validation studies, and facilitates the production of minimum viable products for market testing. It also evaluates the technical feasibility of IP-based technologies, fosters connections with investors and partners, and oversees the day-to-day operations of the incubator, including budget management and performance monitoring.',
                ],
            ],
        ],
        'extension-services-and-linkages-office' => [
            'title' => 'Extension Services and Linkages Office',
            'acronym' => 'ESLO',
            'parent' => 'Office of the Vice President for Research, Innovation, and Extension',
            'description' => 'The Extension Services and Linkages Office (ESLO), led by the Director and in coordination with the Office of the Vice President for Research, Innovation, and Extension (OVPRIE), serves as the bridge between the University and the broader community, ensuring that academic expertise translates into meaningful societal impact. It delivers education, training, and technical assistance tailored to address pressing community needs while fostering sustainable development. By establishing strong linkages with the community, the office facilitates the application of research-based solutions that enhance livelihoods and drive social progress. Through active collaboration and knowledge exchange, UESLO advances the university’s commitment to community empowerment, capacity building, and inclusive development.',
            'head' => 'Abundio C. Miralles, EdD',
            'email' => 'extension@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/Director Extension 2.png',
            'suboffices' => [
                [
                    'title' => 'Extension Planning and Implementation Office',
                    'acronym' => 'EPIO',
                    'description' => 'The Extension Planning and Implementation Office (EPIO) is the university\'s primary driver for community engagement, designing and implementing community-based programs and projects that address local needs through outreach, training, and collaboration. It conducts needs assessments, develops training materials, and evaluates program effectiveness. The office supports faculty and project teams by managing logistics, coordinating resources, and ensuring smooth operations. It actively builds partnerships with government agencies, NGOs, industries, and community organizations, coordinating joint activities, facilitating funding access, and leading resource mobilization efforts to ensure relevance, inclusivity, and sustainability.',
                ],
                [
                    'title' => 'Monitoring and Impact Assessment Office',
                    'acronym' => null,
                    'description' => 'The Monitoring and Impact Assessment Office is responsible for monitoring and evaluating the university\'s extension programs and projects. It conducts field visits, reviews, and stakeholder consultations to ensure programs are on track and delivering desired results. The office also facilitates impact assessments through third-party evaluators to measure long-term outcomes and community benefits. These efforts strengthen institutional accountability, guide future improvements, and ensure every project creates positive change in the lives of its beneficiaries.',
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
