import { Facebook, Mail, Music2, Phone, Youtube } from 'lucide-vue-next';
import { goodGovernance, transparencySeal, vpaf } from '@/routes/administration';
import type {
    PublicSiteFooterContactItem,
    PublicSiteFooterImageLink,
    PublicSiteFooterOfficeContact,
    PublicSiteFooterSocialLink,
} from '@/types/public-site';

export const publicSiteFooterContactItems: PublicSiteFooterContactItem[] = [
    {
        label: '',
        value: 'Rosario, Tandag City, 8300 Surigao del Sur, Philippines',
    },
];


// Bislig - 086-645-6452
// Cagwait - 09457390082 
// Cantilan - 086-212-5484 (shared landline with Registrar) 
// Lianga - 09568310202 (based sa campuses na page)
// San Miguel - 086-212-5132
// Tagbina - no landline, but nag provide sila nan email : aoronquillo@nemsu.edu.ph
// Tandag - 086-214-6381
// Compose


const publicSiteFooterOfficeContacts: PublicSiteFooterOfficeContact[] = [
    {
        office: 'Office of the President',
        value: '(086) 214-4221',
        href: '#',
        icon: Phone,
    },
    {
        office: 'Information Unit',
        value: 'info@nemsu.edu.ph',
        href: 'mailto:info@nemsu.edu.ph',
        icon: Mail,
    }, 
    {
        office: 'Bislig Campus',
        value: '(086) 645-6452',
        href: '#',
        icon: Phone,
    },
    {
        office: 'Cagwait Campus',
        value: '(086) 645-6452',
        href: '#',
        icon: Phone,
    },
    {
        office: 'Cantilan Campus',
        value: '(086) 212-5484',
        href: '#',
        icon: Phone,
    },
    {
        office: 'Lianga Campus',
        value: '0956-831-0202',
        href: '#',
        icon: Phone,
    },
    {
        office: 'San Miguel Campus',
        value: '(086) 212-5132',
        href: '#',
        icon: Phone,
    },
    {
        office: 'Tagbina Campus',
        value: 'aoronquillo@nemsu.edu.ph',
        href: 'mailto:aoronquillo@nemsu.edu.ph',
        icon: Mail,
    },
    {
        office: 'Tandag Campus',
        value: '086-214-6381',
        href: '#',
        icon: Phone,
    },
    // {
    //     office: "Registrar's Office",
    //     value: '(086) 214-0002',
    //     href: 'tel:+63862140002',
    //     icon: Phone,
    // },
    // {
    //     office: 'Admission Office',
    //     value: '(086) 214-0003',
    //     href: 'tel:+63862140003',
    //     icon: Phone,
    // },
    // {
    //     office: 'Guidance Office',
    //     value: '(086) 214-0004',
    //     href: 'tel:+63862140004',
    //     icon: Phone,
    // },
];

export const publicSiteFooterOfficeContactColumns = [
    publicSiteFooterOfficeContacts.slice(0, 5),
    publicSiteFooterOfficeContacts.slice(5),
];

export const publicSiteFooterSocialLinks: PublicSiteFooterSocialLink[] = [
    {
        label: 'NEMSU on Facebook',
        href: 'https://www.facebook.com/nemsuofficialph',
        icon: Facebook,
    },
    {
        label: 'NEMSU on YouTube',
        icon: Youtube,
        href: 'https://www.youtube.com/@nemsuofficialph',
    },
    {
        label: 'NEMSU on TikTok',
        icon: Music2,
        href: 'https://www.tiktok.com/@north.eastern.mind',
    },
];

export const publicSiteCertificationLinks: PublicSiteFooterImageLink[] = [
    {
        label: 'ISO Certification',
        href: 'https://drive.google.com/file/d/1LI4qP_Ge4NfFhDhZ5mlXR5dY5YP3laX4/view',
        image: '/storage/images/compliance/iso/iso.png',
        imageAlt: 'ISO certification logos',
        external: true,
    },
];

export const publicSiteGovernanceSealLinks: PublicSiteFooterImageLink[] = [
    {
        label: 'Transparency Seal',
        href: transparencySeal().url,
        image: '/storage/images/compliance/transparency-seal/the_transparency_seal2_0-150x150.png',
        imageAlt: 'Transparency Seal',
    },
    {
        label: 'Freedom of Information',
        href: `${goodGovernance().url}#freedom-of-information`,
        image: '/storage/images/compliance/freedom-of-information/FOI-Logo_0-150x150.png',
        imageAlt: 'Freedom of Information seal',
    },
];
