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
            'description' => 'RIDO supports University researchers through research programs, policy recommendations, funded project development, inter-campus collaboration, dissemination, and ethical compliance coordination.',
            'head' => 'Erwin B. Berry, EdD',
            'email' => 'research@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-research.jpg',
            'suboffices' => [
                [
                    'title' => 'Research Centers',
                    'acronym' => null,
                    'description' => 'Research Centers manage activities, resources, and personnel in alignment with institutional priorities while fostering interdisciplinary collaboration, grant proposals, ethical compliance, and research performance tracking.',
                ],
                [
                    'title' => 'Research Operation Office',
                    'acronym' => null,
                    'description' => 'The Research Operation Office coordinates and monitors research initiatives, provides technical and administrative support, and ensures research programs align with University goals, community needs, and national priorities.',
                ],
                [
                    'title' => 'Creative Works Management Office',
                    'acronym' => null,
                    'description' => 'The Creative Works Management Office oversees creative outputs from students, faculty, and staff through production support, exhibitions, intellectual property guidance, marketing, and external partnership opportunities.',
                ],
                [
                    'title' => 'Publication and Printing Office',
                    'acronym' => null,
                    'description' => 'The Publication and Printing Office manages University research journals from manuscript submission to publication, including editorial workflows, peer review, copy-editing, design, online platforms, indexing, and partnerships.',
                ],
            ],
        ],
        'knowledge-and-technology-transfer-office' => [
            'title' => 'Knowledge and Technology Transfer Office',
            'acronym' => 'KTTO',
            'parent' => 'Office of the Vice President for Research, Innovation, and Extension',
            'description' => 'KTTO identifies, protects, manages, and commercializes intellectual property so research outputs can become viable technologies and market-ready solutions.',
            'head' => 'Engr. Luzminda S. Bacquial',
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
            'description' => 'ESLO bridges the University and broader community through education, training, technical assistance, sustainable development partnerships, and community empowerment.',
            'head' => 'Ma. Cristina S. Dela Cerna, PhD',
            'email' => 'extension@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-extension.jpg',
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
