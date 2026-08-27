export type PersonnelRecord = {
    name: string;
    position: string;
    designation: string;
};

export type OfficeContent = {
    acronym: string;
    title: string;
    director: string;
    role: string;
    email: string;
    overview: string;
    units: string[];
    personnel: PersonnelRecord[];
};

export type ResearchCenter = {
    name: string;
    acronym: string;
    campus: string;
    established: string;
    summary: string;
    sdgs: number[];
};

export type SourceRepository = {
    title: string;
    description: string;
    href: string;
};

export const ovprieAddress =
    'North Eastern Mindanao State University, Rosario, Tandag City, 8300, Surigao del Sur, Philippines';

export const ovprieOverview =
    'The Office of the Vice President for Research, Innovation, and Extension (OVPRIE) is responsible for steering the University’s research, innovation, and extension agenda in alignment with national development priorities and the thrusts of key agencies such as CHED, DOST, DA, NEDA, DBM, and other relevant institutions. It formulates and implements strategic policies, oversees research, innovation and extension programs, facilitates collaborations, manages grants and funding, and ensures compliance with regulatory requirements. Through its leadership, OVPRIE fosters a dynamic research and innovation ecosystem that advances knowledge generation, technology transfer, and meaningful community engagement.';

export const offices: OfficeContent[] = [
    {
        acronym: 'RIDO',
        title: 'University Research and Innovation Office',
        director: 'Arturo G. Gracia, Jr., MSci',
        role: 'Director, Research and Innovation / University Researcher V',
        email: 'research@nemsu.edu.ph',
        overview:
            'The University Research and Innovation Office supports University researchers by overseeing research programs, projects, and activities, recommending policies, and implementing strategic initiatives. RIDO leads project proposal development, fosters inter-campus collaboration, facilitates the publication and application of research outputs, monitors ongoing work, and coordinates ethical compliance with the University Research Ethics Committee.',
        units: [
            'Research Centers',
            'Research Operation Office',
            'Creative Works Management Office',
            'Publication and Printing Office',
        ],
        personnel: [
            {
                name: 'Melani Joy S. Gallardo',
                position: 'University Researcher II',
                designation: 'Head, Research Operation – Tandag Campus',
            },
            {
                name: 'Ronel Jhon L. Guarte',
                position: 'University Researcher II',
                designation: 'Head, Research Operation – Cantilan Campus',
            },
            {
                name: 'Romnick Guillermo',
                position: 'University Researcher II',
                designation: 'Head, Research Operation – San Miguel Campus',
            },
            {
                name: 'Almar E. Dela Cerna',
                position: 'University Researcher II',
                designation: 'Head, Research Operation – Cagwait Campus',
            },
            {
                name: 'Melizande Uriarte',
                position: 'University Researcher II',
                designation: 'Head, Research Operation – Lianga Campus',
            },
            {
                name: 'Marr Erick Barol',
                position: 'University Researcher II',
                designation: 'Head, Research Operation – Tagbina Campus',
            },
            {
                name: 'Louella Jane B. Gabato',
                position: 'University Researcher II',
                designation: 'Head, Research Operation – Bislig Campus',
            },
        ],
    },
    {
        acronym: 'KTTO',
        title: 'Knowledge and Technology Transfer Office',
        director: 'Engr. Luzminda S. Bacquial, PhD',
        role: 'Director, KTTO / ITSO Manager',
        email: 'itso@nemsu.edu.ph',
        overview:
            'The Knowledge and Technology Transfer Office identifies, protects, and manages intellectual property so that research outputs can become viable technologies and market-ready solutions. It builds industry and government partnerships for licensing, technology transfer, commercialization, entrepreneurship, and interdisciplinary innovation.',
        units: [
            'Innovation and Technology Support Office',
            'Intellectual Property and Technology Business Management Office',
            'Technology Business Incubation Office',
        ],
        personnel: [
            {
                name: 'Engr. Alberto E. Lastimado',
                position: 'University Researcher II',
                designation:
                    'Focal Person, Intellectual Property and Technology Business Management',
            },
            {
                name: 'Engr. Angelie Erandio',
                position: 'University Research Associate II',
                designation:
                    'Focal Person, Innovation and Technology Support Office',
            },
            {
                name: 'Mr. Khen Temporoso',
                position: 'University Research Associate I',
                designation: 'Focal Person, Technology Business Incubation',
            },
        ],
    },
    {
        acronym: 'ESLO',
        title: 'Extension Services and Linkages Office',
        director: 'Abundio C. Miralles, EdD',
        role: 'Director, Extension Services and Linkages / University Extension Specialist V',
        email: 'extension@nemsu.edu.ph',
        overview:
            'The Extension Services and Linkages Office bridges the University and the broader community by delivering education, training, and technical assistance that address community needs. Through partnerships and knowledge exchange, ESLO applies research-based solutions to livelihoods, capacity building, inclusive development, and community empowerment.',
        units: [
            'Extension Planning and Implementation Office',
            'Monitoring and Impact Assessment Office',
        ],
        personnel: [
            {
                name: 'Roel T. Lim, JD, MPA',
                position: 'University Extension Specialist IV',
                designation: 'Extension Planning and Implementation',
            },
            {
                name: 'Mr. Floyd M. Mendez',
                position: 'University Extension Specialist III',
                designation:
                    'Cluster Head, Extension Services and Linkages – Tandag and Cagwait Campuses',
            },
            {
                name: 'Dr. Roel Sayson',
                position: 'University Extension Specialist III',
                designation:
                    'Cluster Head, Extension Services and Linkages – Cantilan and San Miguel Campuses',
            },
            {
                name: 'Ms. Nestle Amuray',
                position: 'University Extension Specialist III',
                designation:
                    'Cluster Head, Extension Services and Linkages – Lianga, Tagbina and Bislig Campuses',
            },
            {
                name: 'Ms. Ranerose Cotares',
                position: 'University Extension Specialist II',
                designation: 'Head, Monitoring and Impact Assessment',
            },
            {
                name: 'Mr. Arjay Penaroyo',
                position: 'University Extension Specialist I',
                designation:
                    'Head, Extension Planning and Operation – Cantilan Campus',
            },
            {
                name: 'Ms. Mary Catherine P. Egpan',
                position: 'University Extension Specialist II',
                designation:
                    'Head, Extension Planning and Operation – Tandag Campus',
            },
            {
                name: 'Ms. Laren Grace Intano',
                position: 'Extension Specialist I',
                designation:
                    'Head, Extension Planning and Operation – Cagwait Campus',
            },
            {
                name: 'Dr. Jhun Victor R. Quebral',
                position: 'University Extension Specialist II',
                designation:
                    'Head, Extension Planning and Operation – San Miguel Campus',
            },
            {
                name: 'Mr. Markly Ladres',
                position: 'Extension Specialist I',
                designation:
                    'Head, Extension Planning and Operation – Lianga Campus',
            },
            {
                name: 'Mr. Ryan Oranza',
                position: 'University Extension Associate II',
                designation:
                    'Head, Extension Planning and Operation – Tagbina Campus',
            },
            {
                name: 'Ms. Ivy L. Archua',
                position: 'University Extension Specialist II',
                designation:
                    'Head, Extension Planning and Operation – Bislig Campus',
            },
        ],
    },
];

export const researchCenters: ResearchCenter[] = [
    {
        name: 'Research Center for Continuing Education and Professional Development',
        acronym: 'RCCEPD',
        campus: 'Tandag Campus',
        established: 'December 19, 2023',
        summary:
            'RCCEPD serves as NEMSU’s hub for lifelong learning, professional development, and applied research that strengthens workforce competencies and responds to the evolving needs of the region. It develops research-based training programs, specialized courses, and capacity-building initiatives for priority sectors through government, industry, and community partnerships.',
        sdgs: [4, 8, 9, 11, 17],
    },
    {
        name: 'Center for Local Leadership and Governance',
        acronym: 'CLLG',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'CLLG promotes evidence-based governance through policy research, leadership development, technical assistance, digital innovation, and capacity-building for local government units, civil society organizations, and community leaders.',
        sdgs: [4, 8, 9, 10, 11, 16, 17],
    },
    {
        name: 'Center for Instructional Innovation and Development',
        acronym: 'CIID',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'CIID supports instructional innovation, educational technology, and learning-resource development. It helps faculty create and evaluate instructional materials while providing educational technology training, creative learning spaces, and instructional media production.',
        sdgs: [3, 4, 8, 9, 10, 11, 17],
    },
    {
        name: 'Society, Human Interaction, Nature and Environment Research Center',
        acronym: 'SHINE',
        campus: 'Tandag Campus',
        established: 'October 14, 2025',
        summary:
            'SHINE advances interdisciplinary research on society, culture, biodiversity, environmental sustainability, and human-environment interactions to support conservation, climate resilience, inclusive development, and informed public policy in Caraga.',
        sdgs: [3, 4, 9, 10, 11, 13, 14, 15, 16, 17],
    },
    {
        name: 'Research Center for Industrial Technology and Renewable Energy',
        acronym: 'RCITRE',
        campus: 'Cantilan Campus',
        established: 'December 19, 2023',
        summary:
            'RCITRE develops practical solutions in industrial technology and renewable energy that support clean energy, green industries, technology transfer, livelihood generation, environmental sustainability, and regional competitiveness.',
        sdgs: [7, 8, 9, 11, 12, 13, 17],
    },
    {
        name: 'Food Innovation Center',
        acronym: 'FIC',
        campus: 'Cantilan Campus',
        established: 'October 14, 2025',
        summary:
            'FIC is a research and innovation hub for food-product development, processing technologies, quality assurance, entrepreneurship, value addition, technology transfer, commercialization, and business incubation.',
        sdgs: [1, 2, 4, 8, 9, 12, 14, 17],
    },
    {
        name: 'Research Center for Climate-Smart Agriculture',
        acronym: 'RCC-SA',
        campus: 'San Miguel Campus',
        established: 'December 19, 2023',
        summary:
            'RCC-SA conducts research, innovation, and extension programs that promote climate-smart agriculture, food security, climate adaptation, sustainable resource management, technology transfer, and farming-community capacity building.',
        sdgs: [1, 2, 6, 9, 12, 13, 15, 17],
    },
    {
        name: 'Tourism and SMEs Innovation Research Center',
        acronym: 'TSMEIRC',
        campus: 'Cagwait Campus',
        established: 'December 19, 2023',
        summary:
            'TSMEIRC strengthens sustainable tourism, hospitality services, local products, entrepreneurship, and small and medium enterprises through research, technology, training, and collaborative partnerships.',
        sdgs: [1, 4, 8, 9, 11, 12, 13, 17],
    },
    {
        name: 'Center of Research for Aquamarine Life Sustainability',
        acronym: 'CoRALS',
        campus: 'Lianga Campus',
        established: 'December 19, 2023',
        summary:
            'CoRALS conducts research on aquasilviculture, marine biodiversity, fish health, hatchery technologies, and integrated coastal-resource management to support sustainable fisheries, food security, climate resilience, and marine conservation.',
        sdgs: [2, 8, 9, 12, 13, 14, 15, 17],
    },
    {
        name: 'Center for Aquasilviculture and Seaweed Advancement',
        acronym: 'AQUASEA',
        campus: 'Lianga Campus',
        established: 'October 14, 2025',
        summary:
            'AQUASEA integrates aquasilviculture, seaweed development, mangrove restoration, coastal ecosystem management, extension, and policy support for biodiversity conservation, blue-economy initiatives, climate resilience, and sustainable coastal livelihoods.',
        sdgs: [1, 2, 4, 8, 9, 13, 14, 15, 17],
    },
    {
        name: 'Food and Farming Technology Research Center',
        acronym: 'FFTRC',
        campus: 'Tagbina Campus',
        established: 'December 19, 2023',
        summary:
            'FFTRC promotes agricultural productivity, food innovation, value addition, sustainable farming systems, digitalization, food security, climate resilience, and circular-economy practices that strengthen rural livelihoods.',
        sdgs: [1, 2, 4, 8, 9, 12, 13, 17],
    },
    {
        name: 'Agro-Forestry Industrial Research Center',
        acronym: 'AFIRC',
        campus: 'Bislig Campus',
        established: 'December 19, 2023',
        summary:
            'AFIRC advances agroforestry, sustainable natural-resource management, and agro-industrial innovation through technology development, industry collaboration, community engagement, environmental conservation, and green growth.',
        sdgs: [4, 7, 8, 9, 11, 12, 13, 15, 17],
    },
];

export const sourceRepositories: SourceRepository[] = [
    {
        title: 'RIE Manual',
        description:
            'Official policies and operating guidance for RIE programs.',
        href: 'https://drive.google.com/file/d/1N_PgfkGK7-k68JBKqrNCW4BuOzhmHsXv/view?usp=sharing',
    },
    {
        title: 'Scopus Indexed Publications',
        description: 'Source spreadsheet supplied by the Research Office.',
        href: 'https://docs.google.com/spreadsheets/d/1C1AZD2yeO90cAFzFH7EQt3Ew59THh0tW/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        title: 'Completed Research Projects',
        description:
            'Source spreadsheet of completed University research projects.',
        href: 'https://docs.google.com/spreadsheets/d/141ERKszSzaEtaPrv9xqqleAqWQ_GqocF/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        title: 'Copyright Records',
        description:
            'Knowledge and Technology Transfer Office copyright registry.',
        href: 'https://docs.google.com/spreadsheets/d/1cEtFWihUUZZ1R0rXDQgH0lrzhbNaKJAy/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        title: 'Trademark Records',
        description:
            'Knowledge and Technology Transfer Office trademark registry.',
        href: 'https://docs.google.com/spreadsheets/d/1TTBUy5HLYqStx_Sw5oGeg1g1zZynFHpJ/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        title: 'Utility Model Records',
        description:
            'Knowledge and Technology Transfer Office utility-model registry.',
        href: 'https://docs.google.com/spreadsheets/d/1HDB-CADHOvnAsmr9A_Y39PK7Df7e9kTz/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        title: 'Patent Records',
        description:
            'Knowledge and Technology Transfer Office patent registry.',
        href: 'https://docs.google.com/spreadsheets/d/14ioBj4Ti1YLEhMZu6uWEZE-z96JJU1_e/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        title: 'Industrial Design Records',
        description:
            'Knowledge and Technology Transfer Office industrial-design registry.',
        href: 'https://docs.google.com/spreadsheets/d/1SNGQBvYLj3oFErbqLMmJkWcrxVALUu6m/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        title: 'Extension Projects',
        description: 'Source spreadsheet of University extension projects.',
        href: 'https://docs.google.com/spreadsheets/d/1fJRlzFi2CkeiezyFPHAASUPs8c3R4Phz/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
    {
        title: 'Extension Activities',
        description:
            'Source document containing Extension Services activity links.',
        href: 'https://docs.google.com/document/d/1ZZlCGjtZiM44SO8C9u91X2KxuPqDvaI/edit?usp=drive_link&ouid=112351263826680098086&rtpof=true&sd=true',
    },
];

export const newsUrls = [
    'https://www.facebook.com/share/p/18D1f4b5xR/',
    'https://www.facebook.com/share/p/1BPM9L2QAf/',
    'https://www.facebook.com/share/p/18ynyZpEoZ/',
    'https://www.facebook.com/share/p/1BqrbDjUhm/',
    'https://www.facebook.com/share/p/1YVbRjKecJ/',
    'https://www.facebook.com/share/p/18xPV9tbzQ/',
    'https://www.facebook.com/share/p/1BVMawEsFF/',
    'https://www.facebook.com/share/p/191MoVcBjy/',
    'https://www.facebook.com/share/p/1DzBGS8Qw2/',
    'https://www.facebook.com/share/p/1HShG4zvND/',
    'https://www.facebook.com/share/p/1ahYbMJJp1/',
    'https://www.facebook.com/share/p/1E4bHUYfhb/',
    'https://www.facebook.com/share/p/1JZHRF19xi/',
    'https://www.facebook.com/reel/1644974993391176',
    'https://www.facebook.com/share/p/1DB8mBqxQh/',
    'https://www.facebook.com/share/p/1BMjB2CJPp/',
    'https://www.facebook.com/share/p/1ENcCwimJD/',
    'https://www.facebook.com/share/p/18YE9Lq2Vj/',
    'https://www.facebook.com/share/p/1bBhmcVPqu/',
    'https://www.facebook.com/share/p/19DfbRmK8W/',
    'https://www.facebook.com/share/p/1P5w1rWrbG/',
    'https://www.facebook.com/share/p/1GGzHXKzhx/',
    'https://www.facebook.com/share/p/1AfqRfiGQT/',
    'https://www.facebook.com/share/p/1DeZYTj16Y/',
    'https://www.facebook.com/share/p/18enp8Y8sZ/',
    'https://www.facebook.com/share/p/1DmBHvU5jY/',
    'https://www.facebook.com/share/p/1GGAXSkTrn/',
    'https://www.facebook.com/share/p/1AjxcEpYLy/',
    'https://www.facebook.com/share/p/1ExmTrRWci/',
    'https://www.facebook.com/share/p/1JYL6fvN6F/',
    'https://www.facebook.com/share/p/1EPLCG6YPV/',
    'https://www.facebook.com/share/p/1B6BpMrs5h/',
    'https://www.facebook.com/share/p/18jJCZcFdL/',
    'https://www.facebook.com/share/p/1CospswUaC/',
    'https://www.facebook.com/share/p/1BFHeJ86nC/',
    'https://www.facebook.com/share/p/1DrGkQ79By/',
    'https://www.facebook.com/share/p/1BHsTnfiaw/',
    'https://www.facebook.com/share/p/16yi97YS22/',
    'https://www.facebook.com/share/p/1CpNWg48zv/',
] as const;
