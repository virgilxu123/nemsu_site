import type { CSSProperties } from 'vue';

import { academicAffairs } from '@/routes/academics';
import { index as servicesIndex } from '@/routes/services';
import type {
    BannerItem,
    Campus,
    GlanceStat,
    MapHighlight,
    Metric,
    QuickAction,
    SdgArticle,
} from '@/types';

export const fallbackHeroSlide: BannerItem = {
    id: 'nemsu-hero',
    title: 'North Eastern Mindanao State University',
    summary:
        'We drive sustainable development through quality instruction, innovative research, community collaboration, and technological advancement.',
    imageUrl: '/storage/images/banners/home/default.MP4',
};

export const quickActions: QuickAction[] = [
    {
        title: 'Apply Now',
        description: 'Admission requirements and application procedures.',
        href: academicAffairs.url(),
    },
    {
        title: 'Enrollment',
        description: 'Enrollment schedules, requirements, and student guides.',
        href: servicesIndex.url(),
    },
    {
        title: 'Student Services',
        description: 'Access academic and student support services.',
        href: servicesIndex.url(),
    },
];

export const sdgDescription =
    'NEMSU supports the United Nations Sustainable Development Goals through instruction, research, extension, innovation, and institutional partnerships.';

export const sdgLearnMoreUrl = 'https://sdg.nemsu.edu.ph/';

export const fallbackSdgArticles: SdgArticle[] = [
    {
        id: 'sdg-tree-planting',
        title: 'Earth Month tree-planting activities support campus environmental programs',
        date: 'Environmental initiative',
        photoUrl:
            '/images/campuses/tandag/student-government/earth-month-tree-planting-1.jpeg',
        href: sdgLearnMoreUrl,
    },
    {
        id: 'sdg-quality-education',
        title: 'NEMSU strengthens SDG integration in instruction and extension',
        date: 'Instruction and extension',
        photoUrl:
            '/images/campuses/tandag/facilities/gallery/college-of-teacher-education.jpg',
        href: sdgLearnMoreUrl,
    },
    {
        id: 'sdg-partnerships',
        title: 'University research supports regional sustainability priorities',
        date: 'Research initiative',
        photoUrl:
            '/images/campuses/tandag/facilities/gallery/research-and-development-office.jpg',
        href: sdgLearnMoreUrl,
    },
];

export const fallbackAtAGlanceStats: GlanceStat[] = [
    {
        key: 'student-population',
        label: 'Current Enrollment',
        value: '33,338',
        scope: 'AY 2025–2026',
    },
    {
        key: 'faculty-staff-profile',
        label: 'Faculty and Staff',
        value: '1,563',
        scope: 'As of Dec. 31, 2025',
    },
    {
        key: 'academic-programs',
        label: 'Academic Programs',
        value: '99',
        scope: 'As of Apr. 30, 2026',
    },
    {
        key: 'campuses',
        label: 'Campuses',
        value: '7',
    },
];

export const fallbackAtAGlanceMapHighlights: MapHighlight[] = [
    {
        label: 'Cantilan',
        description: 'Campus',
        top: '9%',
        left: '41%',
        labelPosition: 'right',
    },
    {
        label: 'Tandag',
        description: 'Main campus',
        top: '28%',
        left: '55%',
        labelPosition: 'right',
    },
    {
        label: 'San Miguel',
        description: 'Campus',
        top: '34%',
        left: '41%',
        labelPosition: 'left',
    },
    {
        label: 'Cagwait',
        description: 'Campus',
        top: '40%',
        left: '59%',
        labelPosition: 'right',
    },
    {
        label: 'Lianga',
        description: 'Campus',
        top: '55%',
        left: '45%',
        labelPosition: 'left',
    },
    {
        label: 'Tagbina',
        description: 'Campus',
        top: '68%',
        left: '55%',
        labelPosition: 'right',
    },
    {
        label: 'Bislig',
        description: 'Campus',
        top: '83%',
        left: '59%',
        labelPosition: 'right',
    },
];

export const campuses: Campus[] = [
    {
        slug: 'tandag',
        name: 'Tandag',
        focus: 'Main Campus',
        detail: 'Home to the University Administration and major undergraduate and graduate programs.',
        location: 'Tandag City',
        studentsCount: '12,000+',
        programsCount: '35+',
        establishedYear: '1982',
    },
    {
        slug: 'cantilan',
        name: 'Cantilan',
        focus: 'Technology Education',
        detail: 'Offers programs in technology, teacher education, and allied disciplines.',
        location: 'Cantilan',
        studentsCount: '4,500+',
        programsCount: '14',
        establishedYear: '1992',
    },
    {
        slug: 'san-miguel',
        name: 'San Miguel',
        focus: 'Agriculture and Forestry',
        detail: 'Offers programs in agriculture, forestry, environmental resource management, and teacher education.',
        location: 'San Miguel',
        studentsCount: '2,200+',
        programsCount: '8',
        establishedYear: '1998',
    },
    {
        slug: 'lianga',
        name: 'Lianga',
        focus: 'Fisheries and Marine Sciences',
        detail: 'Offers programs in fisheries, aquaculture, information technology, and business administration.',
        location: 'Lianga',
        studentsCount: '2,800+',
        programsCount: '10',
        establishedYear: '1994',
    },
    {
        slug: 'cagwait',
        name: 'Cagwait',
        focus: 'Industrial Technology',
        detail: 'Offers programs in teacher education, information technology, business administration, and industrial technology.',
        location: 'Cagwait',
        studentsCount: '1,900+',
        programsCount: '6',
        establishedYear: '2001',
    },
    {
        slug: 'tagbina',
        name: 'Tagbina',
        focus: 'Community-Based Education',
        detail: 'Offers programs in teacher education, information technology, business administration, and industrial technology.',
        location: 'Tagbina',
        studentsCount: '4,100+',
        programsCount: '12',
        establishedYear: '1989',
    },
    {
        slug: 'bislig',
        name: 'Bislig',
        focus: 'Agroforestry and Industry',
        detail: 'Offers programs in industrial technology, information technology, business technology, and teacher education.',
        location: 'Bislig City',
        studentsCount: '5,800+',
        programsCount: '14',
        establishedYear: '2000',
    },
];

export const metrics: Metric[] = [
    { label: 'Campuses', value: '7', note: 'System-wide presence' },
    {
        label: 'Core Functions',
        value: '4',
        note: 'Instruction, research, extension, production',
    },
    {
        label: 'Public Services',
        value: '24+',
        note: 'Offices and online services',
    },
    {
        label: 'Priority Agenda',
        value: 'INNOVATE',
        note: 'Strategic university direction',
    },
];

export const campusBackgroundStyle: CSSProperties = {
    backgroundImage:
        'linear-gradient(100deg, rgba(6,43,73,.96), rgba(6,43,73,.82) 58%, rgba(6,43,73,.58)), url("https://nemsu.edu.ph/files/News/REA-00.jpg")',
};
