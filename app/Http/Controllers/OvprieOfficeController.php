<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class OvprieOfficeController extends Controller
{
    /**
     * @var array<string, array{title: string, acronym: string|null, cluster: string, description: string, head: string, email: string|null, phone: string|null, headImage: string|null}>
     */
    private const OFFICES = [
        'research-centers' => [
            'title' => 'Research Centers',
            'acronym' => null,
            'cluster' => 'University Research and Innovation Office',
            'description' => 'Research Centers manage activities, resources, and personnel in alignment with institutional priorities while fostering interdisciplinary collaboration, grant proposals, ethical compliance, and research performance tracking.',
            'head' => 'Erwin B. Berry, EdD',
            'email' => 'research@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-research.jpg',
        ],
        'research-operation-office' => [
            'title' => 'Research Operation Office',
            'acronym' => null,
            'cluster' => 'University Research and Innovation Office',
            'description' => 'The Research Operation Office coordinates and monitors research initiatives, provides technical and administrative support, and ensures research programs align with University goals, community needs, and national priorities.',
            'head' => 'Erwin B. Berry, EdD',
            'email' => 'research@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-research.jpg',
        ],
        'creative-works-management-office' => [
            'title' => 'Creative Works Management Office',
            'acronym' => null,
            'cluster' => 'University Research and Innovation Office',
            'description' => 'The Creative Works Management Office oversees creative outputs from students, faculty, and staff through production support, exhibitions, intellectual property guidance, marketing, and external partnership opportunities.',
            'head' => 'Erwin B. Berry, EdD',
            'email' => 'research@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-research.jpg',
        ],
        'publication-and-printing-office' => [
            'title' => 'Publication and Printing Office',
            'acronym' => null,
            'cluster' => 'University Research and Innovation Office',
            'description' => 'The Publication and Printing Office manages University research journals from manuscript submission to publication, including editorial workflows, peer review, copy-editing, design, online platforms, indexing, and partnerships.',
            'head' => 'Erwin B. Berry, EdD',
            'email' => 'research@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-research.jpg',
        ],
        'innovation-and-technology-support-office' => [
            'title' => 'Innovation and Technology Support Office',
            'acronym' => 'ITSO',
            'cluster' => 'Knowledge and Technology Transfer Office',
            'description' => 'ITSO manages intellectual property assets, IP audits, filings for patents, trademarks, and copyrights, IP databases, policies, awareness activities, inquiries, and dispute support.',
            'head' => 'Engr. Luzminda S. Bacquial',
            'email' => 'itso@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-ktto.jpg',
        ],
        'intellectual-property-and-technology-business-management-office' => [
            'title' => 'Intellectual Property and Technology Business Management Office',
            'acronym' => null,
            'cluster' => 'Knowledge and Technology Transfer Office',
            'description' => 'This office assesses University technologies for investment readiness, develops technology transfer strategies, negotiates licensing agreements, markets technologies, and supports licensees and spin-off companies.',
            'head' => 'Engr. Luzminda S. Bacquial',
            'email' => 'itso@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-ktto.jpg',
        ],
        'technology-business-incubation-office' => [
            'title' => 'Technology Business Incubation Office',
            'acronym' => 'TBI',
            'cluster' => 'Knowledge and Technology Transfer Office',
            'description' => 'The Technology Business Incubation Office supports startups through incubatee selection, mentorship, business planning, market validation, minimum viable product development, investor connections, and incubator operations.',
            'head' => 'Engr. Luzminda S. Bacquial',
            'email' => 'itso@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-ktto.jpg',
        ],
        'extension-planning-and-implementation-office' => [
            'title' => 'Extension Planning and Implementation Office',
            'acronym' => 'EPIO',
            'cluster' => 'Extension Services and Linkages Office',
            'description' => 'EPIO designs and implements community-based programs, conducts needs assessments, develops training materials, evaluates effectiveness, supports logistics, and builds partnerships with agencies, industries, NGOs, and communities.',
            'head' => 'Ma. Cristina S. Dela Cerna, PhD',
            'email' => 'extension@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-extension.jpg',
        ],
        'monitoring-and-impact-assessment-office' => [
            'title' => 'Monitoring and Impact Assessment Office',
            'acronym' => null,
            'cluster' => 'Extension Services and Linkages Office',
            'description' => 'The Monitoring and Impact Assessment Office conducts field visits, reviews, stakeholder consultations, and third-party impact assessments to strengthen accountability and guide future extension improvements.',
            'head' => 'Ma. Cristina S. Dela Cerna, PhD',
            'email' => 'extension@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovprie/director-extension.jpg',
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
                    'cluster' => $office['cluster'],
                ])
                ->values(),
        ]);
    }
}
