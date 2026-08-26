import { dashboard, directory, home } from '@/routes';
import {
    boardOfRegents,
    officeOfThePresident,
    university,
} from '@/routes/about';
import { academicAffairs } from '@/routes/academics';
import { show as collegeShow } from '@/routes/academics/academic-affairs/colleges';
import { show as graduateProfessionalStudyShow } from '@/routes/academics/academic-affairs/graduate-professional-studies';
import { goodGovernance, vpaf, vppsi } from '@/routes/administration';
import { show as campusShow } from '@/routes/campuses';
import { rie } from '@/routes/research';
import { index as publicationIndex } from '@/routes/research/rie/publications';
import { index as servicesIndex } from '@/routes/services';
import type {
    PublicSiteLinkItem,
    PublicSiteNavigationGroup,
} from '@/types/public-site';

export const publicSiteHome = home;
export const publicSiteDashboard = dashboard;

const undergraduateCollegeLinks: PublicSiteLinkItem[] = [
    {
        label: 'College of Accountancy',
        href: collegeShow.url('college-of-accountancy'),
    },
    {
        label: 'College of Agriculture and Forestry',
        href: collegeShow.url('college-of-agriculture-and-forestry'),
    },
    {
        label: 'College of Arts and Sciences',
        href: collegeShow.url('college-of-arts-and-sciences'),
    },
    {
        label: 'College of Business and Management',
        href: collegeShow.url('college-of-business-and-management'),
    },
    {
        label: 'College of Criminal Justice Education',
        href: collegeShow.url('college-of-criminal-justice-education'),
    },
    {
        label: 'College of Engineering and Technology',
        href: collegeShow.url('college-of-engineering-and-technology'),
    },
    {
        label: 'College of Fisheries and Aquatic Sciences',
        href: collegeShow.url('college-of-fisheries-and-aquatic-sciences'),
    },
    {
        label: 'College of Information Technology Education',
        href: collegeShow.url('college-of-information-technology-education'),
    },
    {
        label: 'College of Teacher Education',
        href: collegeShow.url('college-of-teacher-education'),
    },
];

const professionalStudyLinks: PublicSiteLinkItem[] = [
    {
        label: 'College of Law',
        href: graduateProfessionalStudyShow.url('college-of-law'),
    },
    {
        label: 'College of Medicine',
        href: graduateProfessionalStudyShow.url('college-of-medicine'),
    },
    {
        label: 'Graduate School',
        href: graduateProfessionalStudyShow.url('graduate-school'),
    },
];

export const publicSiteNavigationGroups: PublicSiteNavigationGroup[] = [
    {
        label: 'About Us',
        columns: [
            {
                links: [
                    { label: 'The University', href: university().url },
                    { label: 'Board of Regents', href: boardOfRegents().url },
                    {
                        label: 'Office of the President',
                        href: officeOfThePresident().url,
                    },
                ],
            },
        ],
    },
    {
        label: 'Administration',
        columns: [
            {
                links: [
                    {
                        label: 'Administration and Finance',
                        href: vpaf().url,
                    },
                    {
                        label: 'Good Governance',
                        href: goodGovernance().url,
                    },
                ],
            },
        ],
    },
    {
        label: 'Planning and Strategic Initiatives',
        shortLabel: 'Planning',
        columns: [
            {
                links: [
                    {
                        label: 'Planning and Strategic Initiatives',
                        href: vppsi().url,
                    },
                    {
                        label: 'BAC Matters',
                        href: `${vppsi().url}#ovppsi-offices`,
                    },
                ],
            },
        ],
    },
    {
        label: 'Academics',
        columns: [
            {
                links: [
                    {
                        label: 'Academic Affairs',
                        href: academicAffairs().url,
                    },
                    {
                        label: 'Undergraduate',
                        links: undergraduateCollegeLinks,
                    },
                    {
                        label: 'Professional',
                        links: professionalStudyLinks,
                    },
                ],
            },
        ],
    },
    {
        label: 'Research, Innovation, and Extension (RIE)',
        shortLabel: 'RIE',
        columns: [
            {
                links: [
                    {
                        label: 'Research, Innovation, and Extension (RIE)',
                        href: rie().url,
                    },
                    {
                        label: 'Research Centers',
                        href: `${rie().url}#research-centers`,
                    },
                    {
                        label: 'Published Articles',
                        href: publicationIndex().url,
                    },
                    {
                        label: 'Patents',
                        href: `${rie().url}#patents`,
                    },
                ],
            },
        ],
    },
    {
        label: 'Campuses',
        columns: [
            {
                heading: 'NEMSU System',
                links: [
                    { label: 'Tandag Campus', href: campusShow('tandag').url },
                    {
                        label: 'Cantilan Campus',
                        href: campusShow('cantilan').url,
                    },
                    {
                        label: 'San Miguel Campus',
                        href: campusShow('san-miguel').url,
                    },
                    {
                        label: 'Cagwait Campus',
                        href: campusShow('cagwait').url,
                    },
                    { label: 'Lianga Campus', href: campusShow('lianga').url },
                    {
                        label: 'Tagbina Campus',
                        href: campusShow('tagbina').url,
                    },
                    { label: 'Bislig Campus', href: campusShow('bislig').url },
                ],
            },
        ],
    },
];

export const publicSiteUtilityLinks: PublicSiteLinkItem[] = [
    {
        label: 'Sustainability',
        href: 'https://sdg.nemsu.edu.ph/',
        external: true,
    },
    { label: 'Online Services', href: servicesIndex().url },
    { label: 'Directory', href: directory().url },
];
