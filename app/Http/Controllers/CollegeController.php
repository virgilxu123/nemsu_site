<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CollegeController extends Controller
{
    /**
     * @var array<string, array{
     *     title: string,
     *     photo: string,
     *     overview: string,
     *     campuses: array<int, array{name: string, courses: array<int, string>}>,
     *     programDetails?: array<string, array{description: string, prospectusUrl: string|null}>
     * }>
     */
    public const COLLEGES = [
        'college-of-accountancy' => [
            'title' => 'College of Accountancy',
            'photo' => '',
            'overview' => 'The College of Accountancy develops competent, ethical, and globally competitive accounting professionals equipped with technical expertise, analytical skills, and a strong commitment to integrity and public accountability. It prepares future accountants and financial professionals through quality instruction, research, and community engagement, fostering excellence in accounting practice and responsible stewardship of financial resources.',
            'campuses' => [
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Science in Accountancy',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Science in Accountancy' => [
                    'description' => 'The Bachelor of Science in Accountancy program prepares students to become competent accounting professionals equipped with knowledge and skills in financial accounting, auditing, taxation, management accounting, business law, and accounting information systems. It develops analytical thinking, ethical decision-making, and professional competence necessary for the preparation, analysis, and assurance of financial information. The program promotes integrity, accountability, lifelong learning, and excellence in the accounting profession, enabling graduates to contribute effectively to business, government, and public service.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1yaWc2kF5mo1DjmrNG3JbF4SgC7WIXv09/view?usp=sharing',
                ],
            ],
        ],
        'college-of-agriculture-and-forestry' => [
            'title' => 'College of Agriculture and Forestry',
            'photo' => '/images/academics/colleges/caf.png',
            'overview' => 'The College of Agriculture and Forestry promotes sustainable agriculture, forestry, environmental stewardship, and natural resource management through instruction, research, and extension services. It prepares graduates to contribute to food security, climate resilience, ecological sustainability, and rural development.',
            'campuses' => [
                [
                    'name' => 'Bislig Campus',
                    'courses' => [
                        'Bachelor of Science in Forestry',
                    ],
                ],
                [
                    'name' => 'San Miguel Campus',
                    'courses' => [
                        'Bachelor of Science in Forestry',
                        'Bachelor of Science in Agriculture – Agronomy',
                    ],
                ],
                [
                    'name' => 'Tagbina Campus',
                    'courses' => [
                        'Bachelor of Science in Agriculture',
                        'Bachelor of Agricultural Technology',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Science in Forestry' => [
                    'description' => 'The Bachelor of Science in Forestry program equips students with scientific knowledge, technical competencies, and practical skills in forest resource management, forest protection, watershed management, agroforestry, biodiversity conservation, and environmental sustainability. The program prepares future forestry professionals to address environmental challenges, promote sustainable utilization of forest resources, and contribute to climate change adaptation, ecological preservation, and rural development initiatives.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1S6Fs4Daxh_1-eCFcB6fsLjB0suuM1U42/view?usp=sharing',
                ],
                'Bachelor of Science in Agriculture – Agronomy' => [
                    'description' => 'The Bachelor of Science in Agriculture major in Agronomy program provides students with comprehensive knowledge and practical skills in crop production, soil science, plant breeding, pest management, sustainable farming systems, and agricultural resource management. It prepares graduates to enhance agricultural productivity, food security, and environmental sustainability through scientific, innovative, and climate-responsive agricultural practices.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1_D7buwdJxHbNWA6vjGfhAjOuyZFtnJRJ/view?usp=sharing',
                ],
                'Bachelor of Science in Agriculture' => [
                    'description' => 'The Bachelor of Science in Agriculture program equips students with comprehensive knowledge and practical competencies in crop production, animal science, soil management, agricultural economics, agribusiness, and sustainable farming systems. It prepares graduates to contribute to food security, agricultural innovation, environmental sustainability, and rural development through scientific and climate-responsive agricultural practices.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1v09hwev1KsIRZYFCZPgvONBdQrPTpl5n/view?usp=sharing',
                ],
                'Bachelor of Agricultural Technology' => [
                    'description' => 'The Bachelor of Agricultural Technology program provides students with technical knowledge and hands-on skills in agricultural production, farm operations, crop and livestock management, agricultural extension, and appropriate farming technologies. It prepares graduates to become skilled agricultural practitioners and technology-oriented professionals capable of supporting sustainable agricultural productivity and community-based agricultural development.',
                    'prospectusUrl' => null,
                ],
            ],
        ],
        'college-of-arts-and-sciences' => [
            'title' => 'College of Arts and Sciences',
            'photo' => '/images/academics/colleges/cas.png',
            'overview' => 'The College of Arts and Sciences provides interdisciplinary and foundational education in the humanities, social sciences, natural sciences, and mathematics. It develops critical thinking, communication skills, scientific inquiry, research competence, and social awareness essential for academic, professional, and community engagement.',
            'campuses' => [
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Science in Environmental Science',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Arts in Economics',
                        'Bachelor of Arts in English Language',
                        'Batsilyer ng Sining sa Filipino',
                        'Bachelor of Arts in Political Science',
                        'Bachelor of Science in Psychology',
                        'Bachelor of Science in Biology',
                        'Bachelor of Science in Environmental Science',
                        'Bachelor of Science in Mathematics',
                        'Bachelor of Science in Midwifery',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Science in Environmental Science' => [
                    'description' => 'The Bachelor of Science in Environmental Science program equips students with interdisciplinary knowledge and competencies in environmental management, ecology, pollution control, climate change adaptation, resource conservation, and sustainable development. It prepares graduates to address environmental challenges through scientific research, policy development, environmental planning, and community-based sustainability initiatives.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1lIzDz-7LT2jjxdGSVCmVoVZBpHJtBvv1/view?usp=sharing',
                ],
                'Bachelor of Arts in Economics' => [
                    'description' => 'The Bachelor of Arts in Economics program provides students with knowledge and analytical skills in economic theory, public policy, market systems, development planning, and socio-economic analysis. It prepares graduates to evaluate economic issues, formulate policy recommendations, and contribute to sustainable economic development, governance, and community advancement.',
                    'prospectusUrl' => null,
                ],
                'Bachelor of Arts in English Language' => [
                    'description' => 'The Bachelor of Arts in English Language program develops students’ competencies in language, linguistics, communication, literature, and critical discourse analysis. It prepares graduates for careers in education, communication, research, media, public service, and related fields by enhancing their proficiency in written and oral communication, critical thinking, and cultural understanding.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1RcQp50SutNAiNKvL7380Kh-qs68ck3W4/view?usp=sharing',
                ],
                'Batsilyer ng Sining sa Filipino' => [
                    'description' => 'Ang programang Batsilyer ng Sining sa Filipino ay naglalayong malinang ang kasanayan at kaalaman ng mga mag-aaral sa wikang Filipino, panitikan, kultura, komunikasyon, at malikhaing pagpapahayag. Inihahanda nito ang mga mag-aaral para sa mga larangan ng edukasyon, pananaliksik, midya, pampublikong serbisyo, at iba pang propesyong nangangailangan ng mataas na antas ng kasanayan sa wikang Filipino at pagpapahalagang pangkultura.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1SZDA5x7dFi7olIEVd9DRghVb5i_0731_/view?usp=sharing',
                ],
                'Bachelor of Arts in Political Science' => [
                    'description' => 'The Bachelor of Arts in Political Science program equips students with knowledge and critical understanding of political systems, governance, public administration, international relations, public policy, and political theories. It prepares graduates for careers in government service, law, public administration, diplomacy, research, and civic leadership while promoting democratic values, critical analysis, and social responsibility.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1fVK2RIKCZG_fW3XKdW554W8oiW6nUh5C/view?usp=sharing',
                ],
                'Bachelor of Science in Psychology' => [
                    'description' => 'The Bachelor of Science in Psychology program prepares students to become competent and ethical professionals equipped with a strong foundation in psychological theories, human behavior, mental processes, research methods, and psychological assessment. It develops critical thinking, scientific inquiry, interpersonal communication, and evidence-based problem-solving skills necessary for understanding individuals and communities across diverse settings. The program promotes mental health, psychological well-being, social responsibility, and lifelong learning, enabling graduates to contribute meaningfully to education, healthcare, industry, research, community development, and other fields of professional practice.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/13gIeDXtlqaqin6U11MqaNDwDZTmi52gb/view?usp=sharing',
                ],
                'Bachelor of Science in Biology' => [
                    'description' => 'The Bachelor of Science in Biology program provides students with comprehensive knowledge and scientific competencies in biological sciences, including genetics, ecology, microbiology, physiology, and biodiversity. It develops research-oriented and environmentally conscious graduates capable of contributing to scientific advancement, healthcare, environmental conservation, and sustainable development.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1cw2ztHTpYjX3Lqm9GXgKNg8LES6Spvg3/view?usp=sharing',
                ],
                'Bachelor of Science in Mathematics' => [
                    'description' => 'The Bachelor of Science in Mathematics program develops students’ analytical, logical, and problem-solving skills through advanced studies in pure and applied mathematics, statistics, mathematical modeling, and computational techniques. It prepares graduates for careers in education, research, data analysis, finance, technology, and other fields requiring strong quantitative and analytical competencies.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1zsTy83vK895r5b2Zv6JZiCHANPn9MNgG/view?usp=sharing',
                ],
                'Bachelor of Science in Midwifery' => [
                    'description' => 'The Bachelor of Science in Midwifery program prepares students to become competent, compassionate, and ethical healthcare professionals specializing in maternal and newborn care. It equips students with knowledge and clinical skills in prenatal, intrapartum, postpartum, and neonatal care while promoting safe motherhood, reproductive health, community healthcare, and evidence-based midwifery practice.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1GuoHitM44Zj13u1obR1_jVt8gLH0K-fM/view?usp=sharing',
                ],
            ],
        ],
        'college-of-business-and-management' => [
            'title' => 'College of Business and Management',
            'photo' => '/images/academics/colleges/cbm.png',
            'overview' => 'The College of Business and Management prepares students for careers in entrepreneurship, business administration, finance, marketing, operations, and organizational management. It promotes innovation, ethical leadership, strategic thinking, and sustainable economic development through quality business education and industry-responsive programs.',
            'campuses' => [
                [
                    'name' => 'Cagwait Campus',
                    'courses' => [
                        'Bachelor of Science in Hospitality Management',
                    ],
                ],
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Science in Business Administration major in Financial Management',
                        'Bachelor of Science in Business Administration major in Human Resource Management',
                        'Bachelor of Science in Hospitality Management',
                        'Bachelor of Science in Tourism Management (BSTM)',
                    ],
                ],
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Science in Business Administration major in Business Economics',
                        'Bachelor of Science in Business Administration major in Financial Management',
                        'Bachelor of Science in Hospitality Management',
                    ],
                ],
                [
                    'name' => 'Tagbina Campus',
                    'courses' => [
                        'Bachelor of Science in Business Administration major in Financial Management',
                        'Bachelor of Science in Business Administration major in Human Resource Management',
                        'Bachelor of Science in Hospitality Management major in Hotel and Restaurant Management',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Science in Business Administration major in Financial Management',
                        'Bachelor of Science in Business Administration major in Marketing Management',
                        'Bachelor of Science in Business Administration major in Human Resource Management',
                        'Bachelor of Science in Hospitality Management',
                        'Bachelor of Public Administration',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Science in Hospitality Management' => [
                    'description' => 'The Bachelor of Science in Hospitality Management program prepares students for professional careers in the hospitality and tourism industry through quality instruction, practical training, and industry immersion. It develops competencies in hotel and restaurant operations, tourism services, event management, customer relations, entrepreneurship, and hospitality leadership while promoting professionalism, cultural awareness, innovation, and excellence in service delivery.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1EV-UYg6qD4cj1vnCuXTHSLHp4IyfNqHl/view?usp=sharing',
                ],
                'Bachelor of Science in Tourism Management (BSTM)' => [
                    'description' => 'The Bachelor of Science in Tourism Management program equips students with knowledge and skills in tourism operations, travel services, destination management, tour planning, hospitality, and sustainable tourism development. It prepares graduates to become competent tourism professionals capable of promoting cultural appreciation, customer satisfaction, environmental responsibility, and excellence in tourism and travel services.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1wgOWuVZau1Gzsn1pOawvMkbUhAvwy4EV/view?usp=sharing',
                ],
                'Bachelor of Science in Business Administration major in Business Economics' => [
                    'description' => 'The Bachelor of Science in Business Administration major in Business Economics program equips students with knowledge and analytical skills in economics, business operations, market analysis, financial systems, and strategic decision-making. It prepares graduates to evaluate economic trends, develop business strategies, and contribute to organizational growth and sustainable economic development in both public and private sectors.',
                    'prospectusUrl' => null,
                ],
                'Bachelor of Science in Business Administration major in Financial Management' => [
                    'description' => 'The Bachelor of Science in Business Administration major in Financial Management program develops students’ competencies in financial planning, investment management, banking, risk management, and corporate finance. It equips future professionals with analytical, decision-making, and managerial skills necessary for effective financial operations and ethical financial practices in business, government, and entrepreneurial settings.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1sfbRgyn8ZJfMxXq_RAodHlHtGvgxDUva/view?usp=sharing',
                ],
                'Bachelor of Science in Business Administration major in Human Resource Management' => [
                    'description' => 'The Bachelor of Science in Business Administration major in Human Resource Management program prepares students for careers in human resource administration, organizational development, labor relations, recruitment, training, and performance management. It develops leadership, communication, and people-management skills necessary for creating productive, ethical, and people-centered organizational environments.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1ryMRdFBGruokiI-Em4VrOvpcgZ8u6HN5/view?usp=sharing',
                ],
                'Bachelor of Science in Hospitality Management major in Hotel and Restaurant Management' => [
                    'description' => 'The Bachelor of Science in Hospitality Management major in Hotel and Restaurant Management program prepares students for professional careers in the hospitality industry through quality instruction, practical training, and industry immersion. It develops competencies in hotel operations, restaurant management, food and beverage services, customer relations, event coordination, and hospitality leadership while promoting professionalism, innovation, cultural awareness, and excellence in service delivery.',
                    'prospectusUrl' => null,
                ],
                'Bachelor of Science in Business Administration major in Marketing Management' => [
                    'description' => 'The Bachelor of Science in Business Administration major in Marketing Management program equips students with knowledge and skills in marketing strategies, consumer behavior, brand management, digital marketing, sales management, and market research. It prepares graduates to become innovative and customer-oriented professionals capable of developing effective marketing solutions and contributing to organizational growth and competitiveness.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1cM98vEXHkLHlmwcNNxSyc5FUJ9QLsYv7/view?usp=sharing',
                ],
                'Bachelor of Public Administration' => [
                    'description' => 'The Bachelor of Public Administration program equips students with knowledge and competencies in public governance, policy development, organizational management, public service, and community development. It prepares graduates for leadership roles in government agencies, non-government organizations, and public institutions while promoting accountability, ethical leadership, public sector innovation, and responsive public service.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/10C6diU-ttD8MNevLuTlkIF36DoWK6qTU/view?usp=sharing',
                ],
            ],
        ],
        'college-of-criminal-justice-education' => [
            'title' => 'College of Criminal Justice Education',
            'photo' => '/images/academics/colleges/ccje.png',
            'overview' => 'The College of Criminal Justice Education prepares students for careers in criminology, law enforcement, correctional administration, forensic investigation, and public safety services. It promotes discipline, integrity, professionalism, and respect for human rights and justice systems.',
            'campuses' => [
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Science in Criminology',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Science in Criminology' => [
                    'description' => 'The Bachelor of Science in Criminology program provides students with comprehensive knowledge and competencies in criminal justice, law enforcement, crime prevention, forensic science, criminal investigation, correctional administration, and public safety. It prepares graduates to become competent, disciplined, and ethical professionals capable of promoting peace and order, upholding justice, protecting human rights, and serving in various fields of criminal justice and public safety service.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1r716IyYLu3Q81Y7xjC6WHRKfUqkni1R7/view?usp=sharing',
                ],
            ],
        ],
        'college-of-engineering-and-technology' => [
            'title' => 'College of Engineering and Technology',
            'photo' => '/images/academics/colleges/cet.png',
            'overview' => 'The College of Engineering and Technology provides quality education and training in engineering, industrial, and technological fields through instruction, research, innovation, and extension services. It equips students with technical expertise, problem-solving abilities, practical skills, and ethical values necessary for professional practice, technological advancement, sustainable development, and industry responsiveness in local and global settings.',
            'campuses' => [
                [
                    'name' => 'Bislig Campus',
                    'courses' => [
                        'Bachelor of Science in Electrical Engineering',
                        'Bachelor of Science in Civil Engineering',
                        'Bachelor of Science in Mechanical Engineering',
                    ],
                ],
                [
                    'name' => 'Cagwait Campus',
                    'courses' => [
                        'Bachelor of Science in Industrial Technology major in Automotive Technology',
                        'Bachelor of Science in Industrial Technology major in Electrical Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Culinary Technology',
                        'Bachelor of Science in Industrial Technology major in Computer Technology',
                    ],
                ],
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Industrial Technology (BIndTech) major in Architectural Drafting Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Automotive Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Computer Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Electrical Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Electronics Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Culinary Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Fashion and Apparel Technology',
                        'Bachelor of Industrial Technology (BIndTech) major in Mechanical Technology',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Science in Civil Engineering',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Science in Electrical Engineering' => [
                    'description' => 'The Bachelor of Science in Electrical Engineering program prepares students in the design, operation, maintenance, and management of electrical systems, power generation, transmission, instrumentation, and control systems. It develops analytical, technical, and problem-solving skills necessary for the safe, efficient, and sustainable application of electrical technologies in industrial, commercial, and community settings.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/16NdKtdyW0gdQ7MjmQNeEUQgYcIK-sDU_/view?usp=sharing',
                ],
                'Bachelor of Science in Civil Engineering' => [
                    'description' => 'The Bachelor of Science in Civil Engineering program equips students with competencies in the planning, design, construction, and maintenance of infrastructure projects such as buildings, roads, bridges, water systems, and transportation facilities. The program emphasizes sustainable engineering practices, structural integrity, environmental responsibility, and innovative solutions to societal infrastructure needs.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1x46tsZoshrc9a6MDtMZ4qn5SQtpaxzUw/view?usp=sharing',
                ],
                'Bachelor of Science in Mechanical Engineering' => [
                    'description' => 'The Bachelor of Science in Mechanical Engineering program provides students with knowledge and technical skills in machine design, manufacturing processes, thermal systems, energy conversion, materials engineering, and mechanical operations. It develops competent and innovative mechanical engineers capable of designing, operating, and improving mechanical systems and technologies for industrial and community development.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1A16Ceu_En9KzwfBCoy8vTBvH6lQHEyk8/view?usp=sharing',
                ],
                'Bachelor of Science in Industrial Technology major in Automotive Technology' => [
                    'description' => 'The Bachelor of Science in Industrial Technology major in Automotive Technology program provides students with technical knowledge and practical skills in automotive servicing, vehicle diagnostics, maintenance, repair, and operation of automotive systems. It prepares graduates for careers in the automotive industry by developing competencies in modern automotive technologies, troubleshooting, workplace safety, and technical problem-solving.',
                    'prospectusUrl' => null,
                ],
                'Bachelor of Science in Industrial Technology major in Electrical Technology' => [
                    'description' => 'The Bachelor of Science in Industrial Technology major in Electrical Technology program equips students with competencies in electrical installation, maintenance, troubleshooting, and operation of electrical systems and equipment. The program develops skilled and industry-ready graduates capable of applying electrical principles, technical standards, and safety practices in industrial, commercial, and community settings.',
                    'prospectusUrl' => null,
                ],
                // 'Bachelor of Science in Industrial Technology major in Culinary Technology' => [
                //     'description' => 'The Bachelor of Science in Industrial Technology major in Culinary Technology program develops students’ knowledge and practical skills in food preparation, culinary arts, kitchen operations, food safety, nutrition, and hospitality services. It prepares graduates for careers in the culinary and food service industries by promoting creativity, professionalism, technical expertise, and entrepreneurship in culinary practices.',
                //     'prospectusUrl' => null,
                // ],
                'Bachelor of Science in Industrial Technology major in Computer Technology' => [
                    'description' => 'The Bachelor of Science in Industrial Technology major in Computer Technology program provides students with technical competencies in computer systems servicing, networking, hardware and software installation, computer programming, and information technology support services. The program prepares graduates to become skilled technology practitioners capable of addressing technological and digital challenges in various industrial and organizational environments.',
                    'prospectusUrl' => null,
                ],
                'Bachelor of Industrial Technology (BIndTech) major in Architectural Drafting Technology' => [
                    'description' => 'The Bachelor of Industrial Technology major in Architectural Drafting Technology program equips students with technical competencies in architectural drafting, computer-aided design (CAD), building plans preparation, construction detailing, and drafting standards. It develops skilled professionals capable of producing accurate technical drawings and design layouts for architectural and construction projects while promoting creativity, precision, and technical proficiency.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1HZjj9j2I0XKcdrTSvfC41tLQCzaJ8YdI/view?usp=sharing',
                ],
                'Bachelor of Industrial Technology (BIndTech) major in Automotive Technology' => [
                    'description' => 'The Bachelor of Industrial Technology major in Automotive Technology program provides students with practical and technical skills in automotive servicing, diagnostics, repair, maintenance, and operation of vehicle systems. It prepares graduates for careers in the automotive industry by developing competencies in modern automotive technologies, workplace safety, troubleshooting, and technical problem-solving.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1R5_BruijmvXbTzs5h3eTz0nMRE-PhZcK/view?usp=sharing',
                ],
                'Bachelor of Industrial Technology (BIndTech) major in Computer Technology' => [
                    'description' => 'The Bachelor of Industrial Technology major in Computer Technology program develops students’ competencies in computer systems servicing, networking, hardware and software installation, programming fundamentals, and information technology support services. It prepares graduates to become skilled technology practitioners capable of supporting digital and technological operations in various industries and institutions.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1MtwE6c1a-3S5cLGDfPC1fJC-16BIvvdh/view?usp=sharing',
                ],
                'Bachelor of Industrial Technology (BIndTech) major in Electrical Technology' => [
                    'description' => 'The Bachelor of Industrial Technology major in Electrical Technology program equips students with knowledge and technical skills in electrical installation, maintenance, troubleshooting, and operation of electrical systems and equipment. It prepares graduates to apply electrical principles and safety standards in industrial, commercial, and community-based environments.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1xTCet-KSuKINnREO3z4acJNrKbikM3xp/view?usp=sharing',
                ],
                'Bachelor of Industrial Technology (BIndTech) major in Electronics Technology' => [
                    'description' => 'The Bachelor of Industrial Technology major in Electronics Technology program provides students with competencies in electronics systems, circuit analysis, instrumentation, troubleshooting, repair, and maintenance of electronic equipment and devices. It develops technically proficient graduates capable of responding to the demands of the electronics and communications industries.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1bzRuJMLbdIkFu83hY_8fg3gykIGw0LTv/view?usp=sharing',
                ],
                'Bachelor of Industrial Technology (BIndTech) major in Culinary Technology' => [
                    'description' => 'The Bachelor of Industrial Technology major in Culinary Technology program develops students’ expertise in culinary arts, food preparation, kitchen operations, food safety, nutrition, and hospitality services. It prepares graduates for careers in the culinary and food service industries through practical training, creativity, technical competence, and entrepreneurial development.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1mnRP1mriTPec4OJGEAJY1aUGamBR5Pte/view?usp=sharing',
                ],
                'Bachelor of Industrial Technology (BIndTech) major in Fashion and Apparel Technology' => [
                    'description' => 'The Bachelor of Industrial Technology major in Fashion and Apparel Technology program equips students with knowledge and practical skills in garment construction, fashion illustration, textile selection, apparel production, pattern making, and fashion entrepreneurship. It prepares graduates to become competent professionals in the fashion and apparel industry while promoting creativity, innovation, and design excellence.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1YxIINqusrHrr0k12BP2Et2XFVIEz8Dwp/view?usp=sharing',
                ],
                'Bachelor of Industrial Technology (BIndTech) major in Mechanical Technology' => [
                    'description' => 'The Bachelor of Industrial Technology major in Mechanical Technology program provides students with technical competencies in machine operation, fabrication, welding, manufacturing processes, industrial maintenance, and mechanical systems. It prepares graduates to become skilled practitioners capable of operating, maintaining, and improving mechanical and industrial technologies in various sectors.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1wdbf8PSRYQ6oYes8Uptnwxa-pkZ1C6Rb/view?usp=sharing',
                ],
            ],
        ],
        'college-of-fisheries-and-aquatic-sciences' => [
            'title' => 'College of Fisheries and Aquatic Sciences',
            'photo' => '/images/academics/colleges/cfas.png',
            'overview' => 'The College of Fisheries and Aquatic Sciences advances education, research, and innovation in fisheries, aquaculture, marine biodiversity, and aquatic resource management. It supports the sustainable utilization, conservation, and protection of aquatic ecosystems and coastal communities.',
            'campuses' => [
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Science in Marine Biology',
                        'Bachelor of Science in Fisheries',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Science in Marine Biology' => [
                    'description' => 'The Bachelor of Science in Marine Biology program provides students with comprehensive knowledge and scientific skills in marine ecosystems, marine organisms, biodiversity conservation, oceanography, and coastal resource management. It prepares graduates to conduct research, promote marine conservation, and contribute to the sustainable management and protection of aquatic and coastal environments.',
                    'prospectusUrl' => null,
                ],
                'Bachelor of Science in Fisheries' => [
                    'description' => 'The Bachelor of Science in Fisheries program develops students’ competencies in fisheries management, aquaculture, fish processing, aquatic ecology, and sustainable utilization of aquatic resources. It prepares graduates to contribute to food security, marine resource conservation, fisheries production, and the sustainable development of fisheries and aquatic industries.',
                    'prospectusUrl' => null,
                ],
            ],
        ],
        'college-of-information-technology-education' => [
            'title' => 'College of Information Technology Education',
            'photo' => '/images/academics/colleges/cite.png',
            'overview' => 'The College of Information Technology Education provides quality instruction in computing, information systems, software development, networking, multimedia, and emerging digital technologies. It equips students with technical competencies, problem-solving skills, and innovation capabilities necessary in the rapidly evolving digital and technological environment.',
            'campuses' => [
                [
                    'name' => 'Cagwait Campus',
                    'courses' => [
                        'Bachelor of Science in Information Technology',
                    ],
                ],
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Science in Computer Engineering (BSCpE)',
                        'Bachelor of Science in Computer Science',
                        'Bachelor of Science in Information Technology',
                    ],
                ],
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Science in Computer Science',
                    ],
                ],
                [
                    'name' => 'Tagbina Campus',
                    'courses' => [
                        'Bachelor of Science in Computer Science',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Science in Computer Science',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Science in Information Technology' => [
                    'description' => 'The Bachelor of Science in Information Technology program equips students with knowledge and technical competencies in software development, database management, networking, systems administration, cybersecurity, and information systems. It develops innovative, analytical, and problem-solving skills necessary for designing, implementing, and managing technology-driven solutions that support organizational operations, digital transformation, and sustainable development in various industries and institutions.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/17EZpmg5MQRP6J8Ur5j5DzA7CXZdFGUak/view?usp=sharing',
                ],
                'Bachelor of Science in Computer Engineering (BSCpE)' => [
                    'description' => 'The Bachelor of Science in Computer Engineering program integrates principles of computer science and electrical engineering to prepare students in the design, development, implementation, and maintenance of computer systems, hardware, software, and embedded technologies. It equips students with analytical, technical, and problem-solving skills necessary for innovation, automation, networking, and the advancement of modern computing technologies.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/14dYueVGHIG9lK5JmwshPdTLltMs12-Hv/view?usp=sharing',
                ],
                'Bachelor of Science in Computer Science' => [
                    'description' => 'The Bachelor of Science in Computer Science program provides students with strong foundations in algorithms, programming, software development, artificial intelligence, data structures, database systems, and computational theory. It develops innovative, analytical, and research-oriented professionals capable of designing efficient computing solutions, developing advanced software systems, and contributing to technological innovation across various industries and disciplines.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1m4HVwVJCCvJ9ZkayVEutMhI3r6KCSX6e/view?usp=sharing',
                ],
            ],
        ],
        'college-of-teacher-education' => [
            'title' => 'College of Teacher Education',
            'photo' => '/images/academics/colleges/cte.png',
            'overview' => 'The College of Teacher Education develops competent, innovative, research-oriented, and values-driven educators equipped with pedagogical expertise and professional ethics. It prepares future teachers and education leaders committed to transformative, inclusive, and quality education.',
            'campuses' => [
                [
                    'name' => 'Bislig Campus',
                    'courses' => [
                        'Bachelor of Secondary Education major in English',
                        'Bachelor of Technical-Vocational Teacher Education major in Automotive Technology',
                        'Bachelor of Technical-Vocational Teacher Education major in Electrical Technology',
                    ],
                ],
                [
                    'name' => 'Cantilan Campus',
                    'courses' => [
                        'Bachelor of Secondary Education major in Science',
                        'Bachelor of Secondary Education major in Mathematics',
                        'Bachelor of Secondary Education major in Filipino',
                        'Bachelor of Secondary Education major in English',
                        'Bachelor of Technology and Livelihood Education major in Home Economics',
                        'Bachelor of Technical-Vocational Teacher Education major in Automotive Technology',
                        'Bachelor of Technical-Vocational Teacher Education major in Electrical Technology',
                        'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Electronics Technology',
                        'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Food & Services Management',
                        'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Garments, Fashion and Design',
                    ],
                ],
                [
                    'name' => 'Lianga Campus',
                    'courses' => [
                        'Bachelor of Elementary Education',
                        'Bachelor of Secondary Education major in Science',
                    ],
                ],
                [
                    'name' => 'San Miguel Campus',
                    'courses' => [
                        'Bachelor of Technology and Livelihood Education major in Home Economics',
                    ],
                ],
                [
                    'name' => 'Tagbina Campus',
                    'courses' => [
                        'Bachelor of Secondary Education major in Science',
                        'Bachelor of Elementary Education major in General Education',
                    ],
                ],
                [
                    'name' => 'Tandag Campus',
                    'courses' => [
                        'Bachelor of Early Childhood Education',
                        'Bachelor of Elementary Education',
                        'Bachelor of Secondary Education major in English',
                        'Bachelor of Secondary Education major in Filipino',
                        'Bachelor of Secondary Education major in Mathematics',
                        'Bachelor of Secondary Education major in Science',
                        'Bachelor of Physical Education',
                        'Bachelor of Secondary Education Major in Social Studies',
                    ],
                ],
            ],
            'programDetails' => [
                'Bachelor of Secondary Education major in English' => [
                    'description' => 'The Bachelor of Secondary Education major in English program prepares students to become competent and effective English educators in the secondary level. It develops proficiency in language, literature, communication, pedagogy, curriculum development, and research while equipping future teachers with innovative instructional strategies, critical thinking skills, and professional ethics necessary for quality and learner-centered education.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1jclYwTnZjOcNP-m_lQu_GsznyP165732/view?usp=sharing',
                ],
                'Bachelor of Technical-Vocational Teacher Education major in Automotive Technology' => [
                    'description' => 'The Bachelor of Technical-Vocational Teacher Education major in Automotive Technology program equips students with technical competencies in automotive servicing, diagnostics, maintenance, and repair, integrated with professional education and teaching methodologies. It prepares future technical-vocational educators and skilled practitioners capable of delivering competency-based instruction and promoting technical expertise in the automotive industry.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1eYLKG2ZVd0FeeBOmYElZNi1y1ckGcog0/view?usp=sharing',
                ],
                'Bachelor of Technical-Vocational Teacher Education major in Electrical Technology' => [
                    'description' => 'The Bachelor of Technical-Vocational Teacher Education major in Electrical Technology program develops students’ knowledge and skills in electrical installation, maintenance, troubleshooting, and operation of electrical systems combined with pedagogical training and instructional competencies. The program prepares graduates to become qualified technical-vocational educators and industry practitioners in the field of electrical technology.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/11u6Z_zehbXxZlvSNjpa3bv4yek0UQV5n/view?usp=sharing',
                ],
                'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Electronics Technology' => [
                    'description' => 'The Bachelor of Technical-Vocational Teacher Education major in Electronics Technology program equips students with competencies in electronics servicing, circuit analysis, instrumentation, troubleshooting, and maintenance of electronic systems combined with technical-vocational teaching skills. It prepares graduates for careers as technical educators and electronics technology practitioners.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/13srSJYPBal3jpZvFgs4X1B1_K2IZsytB/view?usp=sharing',
                ],
                'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Food & Services Management' => [
                    'description' => 'The Bachelor of Technical-Vocational Teacher Education major in Food & Services Management program develops students’ knowledge and practical skills in food preparation, hospitality services, catering operations, customer relations, and entrepreneurship integrated with professional teaching competencies. It prepares future educators and professionals in the food service and hospitality industry.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1PYqESQvxreNgR5mSlrnwULLeBpXQv8K7/view?usp=sharing',
                ],
                'Bachelor of Technical-Vocational Teacher Education (BTVTEd) major in Garments, Fashion and Design' => [
                    'description' => 'The Bachelor of Technical-Vocational Teacher Education major in Garments, Fashion and Design program equips students with competencies in clothing construction, fashion illustration, garment production, textile selection, apparel design, and entrepreneurship combined with technical-vocational teaching methodologies. It prepares graduates to become skilled educators and practitioners in the garments and fashion industry.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1MjRhXqbiP9XJ-o5V5gsyhAE0m3DgTBXR/view?usp=sharing',
                ],
                'Bachelor of Secondary Education major in Science' => [
                    'description' => 'The Bachelor of Secondary Education major in Science program prepares future science educators with strong foundations in biological, physical, and environmental sciences integrated with effective teaching methodologies and research skills. It develops competent and innovative teachers capable of promoting scientific literacy, critical thinking, inquiry-based learning, and environmental awareness among secondary learners.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1eKvwfzmZ23XCeV71manrkPWFlAUHbiPk/view?usp=sharing',
                ],
                'Bachelor of Technology and Livelihood Education major in Home Economics' => [
                    'description' => 'The Bachelor of Technology and Livelihood Education major in Home Economics program equips students with knowledge, practical skills, and teaching competencies in home management, food preparation, entrepreneurship, clothing and textiles, family resource management, and livelihood education. It prepares future educators to deliver relevant, skills-based, and learner-centered instruction that promotes productivity, sustainability, entrepreneurship, and community development.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/18nrpsCnS1342l1QBxnxrM7bYnDHuR472/view?usp=sharing',
                ],
                'Bachelor of Elementary Education major in General Education' => [
                    'description' => 'The Bachelor of Elementary Education major in General Education program prepares students to become competent and learner-centered elementary school teachers equipped with foundational knowledge in child development, pedagogy, curriculum implementation, classroom management, and assessment. It develops future educators capable of delivering inclusive, holistic, and transformative instruction across the different learning areas in elementary education while promoting values formation, lifelong learning, and community engagement.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1c622TJNlLex_qkCVSZjFqrbGWM0YTJGu/view?usp=sharing',
                ],
                'Bachelor of Early Childhood Education' => [
                    'description' => 'The Bachelor of Early Childhood Education program prepares students to become competent and nurturing educators for young learners in early childhood settings. It equips future teachers with knowledge and skills in child growth and development, early childhood pedagogy, classroom management, curriculum design, and learner-centered instructional approaches that support holistic child development and foundational learning.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1ouNjik-lgGb-vac1ftRGGLnZP1QDvXw0/view?usp=sharing',
                ],
                'Bachelor of Elementary Education' => [
                    'description' => 'The Bachelor of Elementary Education program prepares students to become competent, innovative, and values-oriented elementary school teachers equipped with foundational knowledge in child development, pedagogy, curriculum implementation, classroom management, and assessment. It develops future educators capable of delivering inclusive, learner-centered, and transformative instruction that promotes holistic development and lifelong learning among elementary learners.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1c622TJNlLex_qkCVSZjFqrbGWM0YTJGu/view?usp=sharing',
                ],
                'Bachelor of Secondary Education major in Filipino' => [
                    'description' => 'The Bachelor of Secondary Education major in Filipino program develops competent educators proficient in the Filipino language, literature, communication, and culture. It prepares future teachers to effectively teach Filipino in the secondary level while promoting national identity, cultural appreciation, critical thinking, and language proficiency.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1eMe1mjRIEyaHRLjVS8okV0OoedCJex7n/view?usp=sharing',
                ],
                'Bachelor of Secondary Education major in Mathematics' => [
                    'description' => 'The Bachelor of Secondary Education major in Mathematics program equips students with comprehensive knowledge in mathematical concepts, problem-solving, analytical reasoning, and instructional strategies for mathematics education. It prepares future mathematics teachers who can effectively foster numeracy, logical thinking, and quantitative skills among secondary school learners.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1ixDOdloKW0ugDJNX2lvIGl2qsM1DxiPX/view?usp=sharing',
                ],
                'Bachelor of Physical Education' => [
                    'description' => 'The Bachelor of Physical Education program prepares students to become competent educators and fitness professionals equipped with knowledge and skills in physical fitness, sports, recreation, wellness, movement education, and physical activity instruction. It promotes holistic development, healthy lifestyles, leadership, sportsmanship, and excellence in physical education and community wellness programs.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1vCcM9frgZosEylkKpB80VgtBQDzU4m1m/view?usp=sharing',
                ],
                'Bachelor of Secondary Education Major in Social Studies' => [
                    'description' => 'The Bachelor of Secondary Education Major in Social Studies program prepares students to become competent, ethical, and socially responsive educators equipped with comprehensive knowledge and pedagogical skills in history, geography, political science, economics, sociology, anthropology, and other social sciences. It develops critical thinking, civic consciousness, cultural appreciation, and research competencies necessary for effective Social Studies instruction. The program promotes lifelong learning, democratic values, global awareness, and active citizenship, enabling graduates to contribute meaningfully to quality education, community development, and nation-building.',
                    'prospectusUrl' => 'https://drive.google.com/file/d/1l_dgmri9Ksk61o5d0GrY5cl0OmAO4MkQ/view?usp=sharing',
                ],
            ],
        ],
    ];

    /**
     * @return array<int, array{slug: string, title: string}>
     */
    public static function summaries(): array
    {
        return collect(self::COLLEGES)
            ->map(fn (array $college, string $slug): array => [
                'slug' => $slug,
                'title' => $college['title'],
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<string, string>
     */
    public static function prospectusUrlsForCampus(string $campusName): array
    {
        return collect(self::COLLEGES)
            ->flatMap(function (array $college) use ($campusName): array {
                $programDetails = $college['programDetails'] ?? [];

                return collect($college['campuses'])
                    ->where('name', $campusName)
                    ->flatMap(fn (array $campus): array => collect($campus['courses'])
                        ->mapWithKeys(function (string $course) use ($programDetails): array {
                            $prospectusUrl = $programDetails[$course]['prospectusUrl'] ?? null;

                            return $prospectusUrl === null
                                ? []
                                : [$course => $prospectusUrl];
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
     * }  $college
     * @return array<int, array{id: string, title: string, campuses: array<int, string>, description: string|null, prospectusUrl: string|null}>
     */
    private static function programsFor(array $college): array
    {
        $programDetails = $college['programDetails'] ?? [];

        return collect($college['campuses'])
            ->flatMap(fn (array $campus): array => collect($campus['courses'])
                ->map(fn (string $course): array => [
                    'title' => $course,
                    'campus' => $campus['name'],
                ])
                ->all())
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

    public function show(string $college): Response
    {
        abort_unless(array_key_exists($college, self::COLLEGES), 404);

        return Inertia::render('academics/College', [
            'college' => [
                'slug' => $college,
                ...self::COLLEGES[$college],
                'programs' => self::programsFor(self::COLLEGES[$college]),
            ],
            'colleges' => self::summaries(),
        ]);
    }
}
