<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class VppsiOfficeController extends Controller
{
    /**
     * @var array<string, array{title: string, acronym: string|null, description: string, head: string, email: string|null, phone: string|null, headImage: string|null}>
     */
    private const OFFICES = [
        'procurement-management-system-office' => [
            'title' => 'Procurement Management System Office',
            'acronym' => 'PMSO',
            'description' => 'The Procurement Management System Office is tasked with ensuring the efficient, transparent, and compliant acquisition of goods, services, and infrastructure required by the University. It facilitates procurement planning, bidding and awarding processes, contract management, and coordination with suppliers in strict adherence to government procurement laws, auditing rules, and institutional guidelines. The office safeguards accountability, promotes fair competition, and ensures value for money in all procurement activities while addressing the operational needs of the University. It also strengthens procurement systems and internal controls to improve efficiency, responsiveness, and service delivery. Through ethical and well-managed procurement processes, the office supports the University operational effectiveness, financial integrity, and overall institutional development.',
            'head' => 'Mrs. Ma. Reina S. Acevedo',
            'email' => 'mrsacevedo@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovppsi/acevedo.png',
        ],
        'alumni-affairs-office' => [
            'title' => 'Alumni Affairs Office',
            'acronym' => null,
            'description' => 'The Alumni Affairs Office serves as the University link in fostering lasting relationships and active engagement with its alumni community. It manages programs and initiatives that strengthen alumni participation in institutional activities, professional networking, community involvement, and University development efforts. The office also maintains alumni records and facilitates communication and partnerships that encourage graduates to remain connected and supportive of the University mission and goals. It promotes alumni pride, collaboration, and opportunities for mentorship and career development. Through sustained engagement and partnership initiatives, the office contributes to institutional advancement and the cultivation of a strong and connected alumni network.',
            'head' => 'Mrs. Hasmenia Lasque',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'records-management-office' => [
            'title' => 'Records Management Office',
            'acronym' => 'RMO',
            'description' => 'The Records Management Office is responsible for the systematic organization, safekeeping, and proper disposition of the University official records and documents. It ensures that records are accurately maintained, securely stored, and readily accessible in accordance with established government archival standards, data privacy regulations, and institutional policies. The office supports administrative efficiency by facilitating the timely retrieval and proper management of records needed for decision-making, legal compliance, and institutional reference. It also promotes standardized documentation practices across all offices to ensure consistency, accuracy, and accountability. Through effective records management, the office contributes to transparency, operational order, and the preservation of institutional memory.',
            'head' => 'Mr. Joseph B. Cabadonga, Office In-charge',
            'email' => 'records@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovppsi/cabadonga.png',
        ],
        'gad-and-values-restoration-office' => [
            'title' => 'GAD and Values Restoration Office',
            'acronym' => 'GAD',
            'description' => 'The GAD and Values Restoration Office is responsible for promoting gender equality, inclusivity, and the integration of ethical and moral values across the University programs and operations. It ensures the implementation of gender-responsive policies, capacity-building activities, and advocacy programs aligned with national GAD mandates and institutional development goals. The office also leads initiatives that strengthen character formation, ethical behavior, and the restoration of core values among students and personnel. It plays a vital role in fostering a safe, respectful, and inclusive academic environment that upholds human dignity and social responsibility. Through its programs and advocacies, the office contributes to a more equitable, values-driven, and socially responsive University community.',
            'head' => 'Ms. Roxanne T. Sarmiento | Mrs. Marlina Respecia',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'information-and-public-affairs-office' => [
            'title' => 'Information and Public Affairs Office',
            'acronym' => 'IPAO',
            'description' => 'The Information and Public Affairs Office manages the University official communications, public relations, and information dissemination strategies. It ensures the accurate, timely, and transparent sharing of institutional updates, programs, and achievements through various media platforms and communication channels. The office strengthens the University public image by coordinating media relations, producing official content, and supporting information campaigns aligned with institutional goals. It also serves as the central hub for internal and external communication, ensuring consistency and credibility in all official messaging. Through strategic communication and public engagement, the office contributes to institutional transparency, stakeholder awareness, and community trust.',
            'head' => 'Mr. Joseph B. Cabadonga',
            'email' => 'information@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovppsi/cabadonga.png',
        ],
        'quality-assurance-office' => [
            'title' => 'Quality Assurance Office',
            'acronym' => 'QAO',
            'description' => 'The Quality Assurance Office ensures that the University consistently upholds high standards in both academic and administrative operations in line with regulatory requirements and institutional objectives. It manages the implementation and continuous improvement of quality assurance systems, including performance evaluation mechanisms, accreditation activities, and compliance monitoring across all units. The office fosters a culture of excellence by identifying gaps, recommending improvements, and supporting data-driven decision-making. It also ensures adherence to national and global quality standards to enhance institutional credibility and competitiveness. Through sustained monitoring and evaluation, the office strengthens the University commitment to quality, accountability, and continuous institutional advancement.',
            'head' => 'Engr. Leah G. Guirimbao',
            'email' => 'qa@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovppsi/guirimbao.png',
        ],
        'planning-office' => [
            'title' => 'Planning Office',
            'acronym' => null,
            'description' => 'The Planning Office is responsible for leading the development, coordination, and monitoring of the University strategic and operational plans to ensure alignment with its vision, mission, and institutional goals. It facilitates evidence-based planning processes, including the formulation of development plans, program proposals, and policy frameworks that guide institutional growth and resource allocation. The office functions in consolidating data and performance indicators to support informed decision-making and effective governance. It also ensures that all plans are aligned with national development priorities and higher education standards. Through strategic foresight and systematic planning, the office contributes to the University sustainable development, efficiency, and long-term institutional success.',
            'head' => 'Engr. Kennie F. Montenegro',
            'email' => 'planning@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovpaf/MONTENEGRO, KENNIE, F SFFB NEMSU_2950 copy.jpg',
        ],
        'general-services-office' => [
            'title' => 'General Services Office',
            'acronym' => 'GSO',
            'description' => 'The General Services Unit is responsible for ensuring the efficient delivery of essential support services that maintain the functionality, safety, and order of the University physical facilities and operations. It oversees maintenance and repair of buildings and equipment, campus cleanliness, security support coordination, utilities management, and other logistical services necessary for daily institutional operations. The unit sustains a safe, well-maintained, and conducive learning and working environment for students, faculty, and staff. It also ensures that support services are implemented in accordance with institutional policies and government standards. Through reliable and responsive service delivery, the unit contributes to the University operational efficiency and overall institutional effectiveness.',
            'head' => 'Engr. McDonald Amparo',
            'email' => 'gsu@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovppsi/amparo.png',
        ],
    ];

    public function show(string $office): Response
    {
        abort_unless(array_key_exists($office, self::OFFICES), 404);

        return Inertia::render('administration/VppsiOffice', [
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
