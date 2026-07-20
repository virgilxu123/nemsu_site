<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class OvpafOfficeController extends Controller
{
    /**
     * @var array<string, array{title: string, acronym: string|null, description: string, head: string, email: string|null, phone: string|null, headImage: string|null}>
     */
    private const OFFICES = [
        'chief-administrative-office-finance-division' => [
            'title' => 'Chief Administrative Office - Finance Division',
            'acronym' => 'CAO-Finance',
            'description' => 'The CAO-Finance supervises the Financial Services Unit of the university and ensures the effective implementation of financial operations and services. The office reviews reports required by regulatory agencies such as the DBM, CHED, and CSC, and prepares memoranda, communications, terminal reports, training designs, proposals, and related documents. It also reviews supporting documents for vouchers and Budget Utilization Requests/Obligation Requests, conducts consultations and information services on financial operations, and oversees periodic monitoring and evaluation of the performance of financial units. In addition, the CAO-Finance facilitates workshops, seminars, and training programs, conducts orientations on financial matters across campuses, submits accomplishment reports on supervisory plan implementation, and performs other related functions as directed by the immediate supervisor.',
            'head' => 'Dr. Camilo Malong',
            'email' => 'chiefAO_FinanceDivision@nemsu.edu.ph',
            'phone' => '09125813688',
            'headImage' => null,
        ],
        'chief-administrative-office-admin-division' => [
            'title' => 'Chief Administrative Office - Admin Division',
            'acronym' => 'CAO-Admin',
            'description' => 'The office supervises the non-teaching personnel of the university and ensures compliance with the requirements of regulatory agencies such as the DBM, CHED, and CSC through the preparation of necessary reports and documents. It is also responsible for drafting memoranda, communications, terminal reports, training proposals, and activity designs, as well as reviewing reports on the university administrative and financial operations. In addition, the office reviews supporting documents for vouchers, Budget Utilization Requests, Obligation Requests, the consolidated Annual Procurement Plan, and semestral contracts of service for faculty and employees. It also conducts orientations on administrative and financial matters across campuses and performs other related functions as assigned by the University President.',
            'head' => 'Dr. Florife O. Urbiztondo',
            'email' => 'caoad@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '\images\administration\ovpaf\URBIZTONDO, FLORIFE, O SFFB NEMSU_4532 copy.jpg',
        ],
        'supervising-administrative-office-finance-division' => [
            'title' => 'Supervising Administrative Office - Finance Division',
            'acronym' => 'SAO-Finance',
            'description' => 'The SAO-Finance oversees the Accounting Unit, Budget Unit, and other financial offices of the university. The office assists the Chief Administrative Officer for Finance in ensuring the smooth and efficient operation of all units under the Finance Division and aligns work processes and outputs with institutional priorities, internal policies, and external regulatory requirements. It supervises the preparation of budget and financial management functions and activities, while also reviewing, developing, and recommending internal work processes, standards, guidelines, and procedures in compliance with the Quality Management System and other oversight agencies. In addition, the SAO-Finance evaluates and submits periodic and special reports, monitors the performance of subordinates against established standards, prepares the Work and Financial Plan and Project Procurement Management Plan of the office, assumes the duties of the Chief Administrative Officer in their absence, and performs other regular or special functions as may be assigned from time to time.',
            'head' => 'Mrs. Leorilie Kim Estrada',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'supervising-administrative-office-administration-division' => [
            'title' => 'Supervising Administrative Office - Administration Division',
            'acronym' => 'SAO-Admin',
            'description' => 'The Supervising Administrative Officer for Administration oversees the Human Resource Management, Supply, Cashier, and other allied sections or units that may be established by the University President in accordance with the university organizational structure. The office assists the Chief Administrative Officer for Administration in managing the daily operations of administrative units and ensures the quality delivery of services in areas such as Property and Supply, Records, HR, Cashier, Project Management Unit, and General Services. It also aligns office processes and outputs with institutional priorities and applicable policies, prepares the Project Procurement Management Plan, evaluates and submits periodic and special reports, and monitors the performance standards of units under its supervision. In addition, the SAO-Admin ensures the conduct of Complete Staff Work on matters requiring the Chief attention, assumes the functions of the Chief Administrative Officer in their absence, submits accomplishment reports on supervisory plan implementation, and performs other duties as may be assigned from time to time.',
            'head' => 'Engr. Christopher Badayos',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'accounting-office' => [
            'title' => 'Accounting Office',
            'acronym' => null,
            'description' => 'The Accounting Unit is responsible for ensuring the accuracy, validity, and completeness of the university financial records and transactions. It checks the appropriateness of supporting documents and validates claims attached to Disbursement Vouchers, reviews journal entries and signs Journal Entry Vouchers for all funds, and examines liquidation reports submitted by accountable officers to certify the completeness of supporting documents. The office also prepares consolidated financial statements, monitors general and subsidiary ledgers, and prepares the office Project Procurement Management Plan and activity proposals. In addition, it prepares and certifies the correctness of financial reports such as FARs, BEDs, and payroll-related documents, oversees the overall operations of the Accounting Unit including report submissions to regulatory agencies, reviews the accuracy of computations and remittances of mandatory deductions, and performs other related tasks as assigned by immediate supervisors.',
            'head' => 'Mr. Calvin R. Sillar',
            'email' => 'accounting@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '\images\administration\ovpaf\SILLAR, CALVIN, R SFFB NEMSU_6032 copy.jpg',
        ],
        'budget-office' => [
            'title' => 'Budget Office',
            'acronym' => null,
            'description' => 'The Budget Unit is responsible for overseeing and managing the university budgetary planning, allocation, monitoring, and reporting processes. It reviews and signs budgetary documents such as ORS/BURS, PRs, proposals, and PPMPs to ensure the availability of appropriations, allotments, and budgets. The office also monitors, records, and files SAROs and NCAs, prepares budget registries for all funds, and consolidates budgetary reports including FARs, BEDs, BP Forms, and Budget Utilization Reports. In addition, it encodes and submits the Agency Budget Proposal through the Online Submission of Budget Proposals, finalizes budget proposals for submission to the DBM, and prepares reports required by Congress and other oversight agencies. The unit also organizes budget-related activities such as Budget Calls, Budget Forums, and Budget Presentations, monitors the implementation of proposed PAPs, reviews budgetary reports for STF and IGP, attends meetings and activities initiated by DBM, COA, NEDA, and other agencies, prepares the PPMP and activity proposals of the office, and performs other related tasks assigned by immediate supervisors.',
            'head' => 'Mrs. Sandra Jessa S. Trajano',
            'email' => 'budget@nemsu.edu.ph',
            'phone' => null,
            'headImage' => null,
        ],
        'human-resource-management-office' => [
            'title' => 'Human Resource Management Office',
            'acronym' => 'HRMO',
            'description' => 'The Human Resource Management Office is responsible for overseeing recruitment, selection, and placement; performance management; rewards and recognition; learning and development; maintenance of personnel records; and the formulation of policies, rules, standards, and guidelines related to personnel management. Headed by the Human Resource Management Officer III, the office ensures the efficient administration of human resource functions within the university. The HRMO III is tasked with listing candidates aspiring for vacant positions, conducting preliminary evaluations of applicants qualifications, preparing and posting notices of vacant positions in compliance with CSC rules and regulations, notifying applicants of evaluation results, and submitting the selection lineup to the Personnel Selection Board for deliberation.',
            'head' => 'Ms. Eunice Prado',
            'email' => 'hrmo.tandag@nemsu.edu.ph',
            'phone' => null,
            'headImage' => '/images/administration/ovpaf/PRADO, EUNICE, P SFFR NEMSU_3902 copy.jpg',
        ],
        'supply-office' => [
            'title' => 'Supply Office',
            'acronym' => null,
            'description' => 'The Supply Office is responsible for the management, accountability, and proper distribution of the university supplies, materials, equipment, and other assets. It oversees the checking, acceptance, and receipt of deliveries intended for distribution and ensures equitable allocation based on the approved procurement program. The office also maintains records of books, supplies, materials, equipment, buildings, and other properties, including their accession and inventory. In addition, it prepares bills of lading, requisitions, and supporting documents for vouchers, conducts periodic physical and written inventories, processes insurance and licenses of school properties, and manages the maintenance, repair, storage, and warehousing of assets. The office likewise handles the disposal process of unserviceable properties, prepares supply management reports, and performs other related tasks as may be assigned by higher authorities.',
            'head' => 'Mrs. Jovelyn Clarit',
            'email' => 'supplyofficemain@gmail.com',
            'phone' => null,
            'headImage' => '/images/administration/ovpaf/CLARIT, JOVELYN, B SFFB NEMSU_0690 copy.jpg',
        ],
        'cashier-office' => [
            'title' => 'Cashier Office',
            'acronym' => null,
            'description' => 'The Cashier Office is responsible for the proper handling, disbursement, collection, and monitoring of the university financial transactions and funds. It manages the signing and processing of issued checks, LDDAP, ADA, ACIC, and related financial documents as approved by authorized officials, as well as the deposit of collections, income, and refunds to authorized banks. The office also handles cash withdrawals and disbursements for cash advances, honoraria, TES, and other compensation benefits, while maintaining accurate records of checks, deposits, and disbursement transactions. In addition, it advises management on fund collection and disbursement, processes payments to dealers and agencies, prepares liquidation and petty cash replenishment reports, and reviews, monitors, and submits financial reports to management and government agencies. The office is likewise responsible for issuing official receipts, supervising cashiering personnel, participating in finance committees during university activities, coordinating with the accountant and budget officer regarding fund availability, and performing other related administrative and financial functions.',
            'head' => 'Mrs. Glesilda L. Canda',
            'email' => null,
            'phone' => null,
            'headImage' => '\images\administration\ovpaf\CANDA, GLESILDA, L SFFB NEMSU_4705 copy.jpg',
        ],
        'income-generating-project-and-auxiliary-services-office' => [
            'title' => 'Income-Generating Project and Auxiliary Services Office',
            'acronym' => 'IGP and Auxiliary Services',
            'description' => 'The Income-Generating Projects and Auxiliary Services Office is responsible for developing, managing, and strengthening the university income-generating initiatives and auxiliary services to support institutional sustainability and resource generation. The office formulates and reviews proposals, guidelines, and feasibility studies for various production and commercial projects across colleges and campuses, ensuring that these initiatives maximize available resources and contribute to the university development goals. It also oversees and evaluates production operations, auxiliary services, and prototype projects, while coordinating with campus units and stakeholders to improve efficiency, expand services, and promote the commercialization of university products and services. Additionally, the office consolidates production data and reports, facilitates coordination among personnel involved in production activities, and supports capability-building initiatives related to project and production management.',
            'head' => 'Mr. Roel T. Lim',
            'email' => null,
            'phone' => null,
            'headImage' => '\images\administration\ovpaf\LIM, ROEL, T SFFB NEMSU_2787 copy.jpg',
        ],
        'disaster-risk-management-office' => [
            'title' => 'Disaster Risk Management Office',
            'acronym' => 'DRRM',
            'description' => 'The Disaster Risk Reduction and Management Office is responsible for ensuring the safety, preparedness, and resilience of the university community and its infrastructure through a comprehensive disaster risk management approach. The office serves as the primary coordinating body for disaster prevention and mitigation, preparedness, response, rehabilitation, and recovery across all university campuses. It develops and implements safety policies, conducts hazard assessments and structural evaluations, and promotes campus readiness through trainings, drills, and emergency planning activities. During emergencies and disasters, the office manages response operations, evacuation procedures, and resource coordination to protect lives and properties. It also oversees post-disaster recovery efforts, including damage assessment, restoration of essential services, psychosocial support, and coordination with local government units and disaster management agencies to ensure the continuity of university operations and the welfare of the academic community.',
            'head' => 'Mr. Robert R. Wariza',
            'email' => null,
            'phone' => null,
            'headImage' => null,
        ],
        'energy-efficiency-and-conservation-office' => [
            'title' => 'Energy Efficiency and Conservation Office',
            'acronym' => 'EECO',
            'description' => 'The Energy Efficiency and Conservation Office is responsible for promoting and implementing sustainable energy management practices within the university in support of government energy conservation programs and institutional sustainability goals. The office prepares, formulates, and submits the university Energy Efficiency and Conservation Plan consistent with the Government Energy Management Program, and ensures the timely submission of monthly energy performance reports and annual energy efficiency and conservation programs to the Department of Energy. It also oversees the implementation, monitoring, and continuous improvement of energy efficiency measures across university offices, buildings, and facilities to promote responsible energy use and operational efficiency. Additionally, the office performs other related tasks as may be assigned by the immediate head.',
            'head' => 'Engr. Kennie Montenegro',
            'email' => null,
            'phone' => null,
            'headImage' => '\images\administration\ovpaf\MONTENEGRO, KENNIE, F SFFB NEMSU_2950 copy.jpg',
        ],
    ];

    public function show(string $office): Response
    {
        abort_unless(array_key_exists($office, self::OFFICES), 404);

        return Inertia::render('administration/OvpafOffice', [
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
