<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowUpRight,
    BadgeCheck,
    Building2,
    CalendarRange,
    FileText,
    ShieldCheck,
} from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import type { Component } from 'vue';
import PublicSiteLayout from '@/layouts/PublicSiteLayout.vue';
import { goodGovernance } from '@/routes/administration';
import { home } from '@/routes';

type RevealDirection = 'down' | 'left' | 'right' | 'up';

type DocumentLink = {
    label: string;
    href: string;
};

type SectionItem = {
    label: string;
    href?: string;
};

type TransparencySection = {
    code: string;
    title: string;
    description: string;
    items: SectionItem[];
};

type QuarterArchive = {
    label: string;
    documents: DocumentLink[];
};

type TransparencyYear = {
    year: string;
    summary: string;
    quarters: QuarterArchive[];
};

type PillarCard = {
    title: string;
    description: string;
    icon: Component;
};

const heroLeftImage =
    '/images/administration/ovpaf/6I3A7029(1).jpg';
const heroRightImage =
    '/images/campuses/tandag/facilities/gallery/administrative-building.jpg';
const revealOffset: Record<RevealDirection, string> = {
    down: '-translate-y-8',
    left: 'translate-x-8',
    right: '-translate-x-8',
    up: 'translate-y-8',
};

const visibleSections = ref<Set<string>>(new Set());
let revealObserver: IntersectionObserver | null = null;

const doc = (label: string, href: string): DocumentLink => ({
    label,
    href,
});

const quarter = (
    label: string,
    documents: DocumentLink[] = [],
): QuarterArchive => ({
    label,
    documents,
});

const transparencyPillars: PillarCard[] = [
    {
        title: 'Agency mandate and official directory',
        description:
            'The seal makes the University’s public mandate, leadership, and service contact points easier to find for students, partners, and citizens.',
        icon: ShieldCheck,
    },
    {
        title: 'Annual financial reports',
        description:
            'Budget accountability reports and FAR documents are grouped by year and quarter so the current archive is easy to scan.',
        icon: FileText,
    },
    {
        title: 'Public accountability at a glance',
        description:
            'The design keeps the seal, summary notes, and report links in a single readable flow that works on desktop and mobile.',
        icon: BadgeCheck,
    },
];

const transparencyYears: TransparencyYear[] = [
    {
        year: '2026',
        summary: 'Latest posted annual financial reports and quarterly updates.',
        quarters: [
            quarter('First Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1Z55R6cDLGIGpBp8ai4CpdmM35lsSeyWW/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1TwLSWQn4Z6JCNqHxDt0uNNJnFyoJsLB5/view?usp=sharing'),
                doc('FAR NO 1 Continuing', 'https://drive.google.com/file/d/1SYWHSGeEihFd0Evzx8byN6RnMiazgFkN/view?usp=sharing'),
                doc('FAR NO 1-A Continuing', 'https://drive.google.com/file/d/1ZUkM7uihfydvCVzgge4hhgrCAhPE1KT4/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1gZev80bcL_Fd-oV9SSh_zR3IJZVddkuL/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1dyK4EIAOSu8hTFj8mOz8de-r9guDycR1/view?usp=sharing'),
                doc('FAR NO 4 - January', 'https://drive.google.com/file/d/1rOsP7K5Z2MzgwkOryeJ_zFu2NzPy7JtX/view?usp=sharing'),
                doc('FAR NO 4 - February', 'https://drive.google.com/file/d/1q9nhoxIkA2gP1QveEGWiRw5FiW73UipH/view?usp=sharing'),
                doc('FAR NO 4 - March', 'https://drive.google.com/file/d/19C0Irmra-xVinxWJ6iZoSfkPOgfJoPJr/view?usp=sharing'),
                doc('FAR NO 5 - Internally Generated Funds', 'https://drive.google.com/file/d/12Mhs7EeQIc06QrFFyyn2irI3OhJxmbjo/view?usp=sharing'),
                doc('FAR NO 5 - Business Related Funds', 'https://drive.google.com/file/d/1Ij9pXAfZrOs2jWpAoaLHfySM23UJVmEN/view?usp=sharing'),
                doc('FAR NO 5 - Trust Receipts', 'https://drive.google.com/file/d/1bZE5TsldYmQeS0YQRCXbHhc7GJB1GXoJ/view?usp=sharing'),
            ]),
            quarter('Second Quarter'),
            quarter('Third Quarter'),
            quarter('Fourth Quarter'),
        ],
    },
    {
        year: '2025',
        summary: 'Expanded fiscal archive covering each quarter of the year.',
        quarters: [
            quarter('First Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1zBZOdDMvGFJ4gLDufZxUdmqY2EH0k8ac/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1J8XfXOZLPi4dVXmRr29aeECwx5WoeI4a/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1kCYZKj6Jy047p66W9vYUtW0imLLOhGzz/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/18UL-M0iXGMGgGzJpup2ufOjtidyC0yXq/view?usp=sharing'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1EeIcCCfCBD1vVRCWGAvh3C6tozpfXD1z/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1jX8BWWLymnnSZKJKTqoNPRVrVA1ZOYaq/view?usp=sharing'),
            ]),
            quarter('Second Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/15Na86ksHcgMZ9Hc1nqSSJ2fr1ynq-CtJ/view?usp=sharing'),
                doc('FAR NO 1 Continuing', 'https://drive.google.com/file/d/1yqnZ2vQrFfxbGKSLJpk1kryzDSqntRY2/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1Iicz_ulVzW-f2-i0poP4kHDozYPGyJkz/view?usp=sharing'),
                doc('FAR NO 1-A Continuing', 'https://drive.google.com/file/d/1Bhd4jXOkgmyuvZoPLkaeYgC0DeGaTTd7/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1vYYRn_FMyA3S4z27qRy2GuDlzO653W84/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1Hs1liPDa8YaWS8AHc8jExJUqy8M_u8Vi/view?usp=sharing'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1hlHSCG233GM99RIFNa5NA45NRiE5KRGX/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1a84lk-ilSyJCimHkWj-Mrqg_EGFFDofH/view?usp=sharing'),
            ]),
            quarter('Third Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1igiyy-hWlJu0VyJ9UCD1Rd7rj84_oU-v/view?usp=sharing'),
                doc('FAR NO 1 Continuing', 'https://drive.google.com/file/d/18ju8m5NlMlkymgekMJGehRHUkEBnW4QI/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1qpjKjQ9HCEdKx_M7ZUTvfasN6-bSKFWq/view?usp=sharing'),
                doc('FAR NO 1-A Continuing', 'https://drive.google.com/file/d/1n6ABHhUXJErqU7EE8B67jp0yNu2KeiPq/view?usp=sharing'),
                doc('FAR NO 1-B', 'https://drive.google.com/file/d/1OZdc0s0OGuXh9SP0JGuLC9n_eNQDSQDP/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1yc_1ePWCaDQqkAt2jDLJ0hWm0EPZeHMH/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1eu0zZINEw72lwjkLlJp_EfncDsm87j2Q/view?usp=sharing'),
            ]),
            quarter('Fourth Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1zqPqeFyDANRHCBLbm-MIcwot-mAUgh3g/view?usp=sharing'),
                doc('FAR NO 1 Continuing', 'https://drive.google.com/file/d/1Wma9X5O7SqPfsXLTnlb2qhcGZ-JadlBT/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1ErD1dqhwK3Y0iLj-Ct9mRN0fE2yOHQn7/view?usp=sharing'),
                doc('FAR NO 1-A Continuing', 'https://drive.google.com/file/d/1MHMyAlQzHPiTirpFOcRCEvWLqW0oBF1Q/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1Vo3V6IMAmUSM7u0d4E7vFFrZXJ_gu-AR/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1yfyn3fUiMGtgn2_kR7LnQJf8xP6Na57U/view?usp=sharing'),
                doc('FAR NO 3', 'https://drive.google.com/file/d/1jD_wzyS41Zp8xVBWEyVQ6ojMrDyZ8z3i/view?usp=sharing'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1yY_D5xcF7E8girJjiaVPwPaSf2y80Dua/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1aAYz_6ZQwSdwp8a25hk-SZSdf_wfDpxM/view?usp=sharing'),
            ]),
        ],
    },
    {
        year: '2024',
        summary: 'Quarterly reports arranged from first through fourth quarter.',
        quarters: [
            quarter('First Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/18tNzAsBNKOvab0d7hgZ67Gvd5sfU_HnC/preview'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1S_cHN0EpK_ATlZl5uoCQ7AqXG1xuGJri/preview'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1_6-rjvEno9XdlIFAxS77eQCoIAn99oie/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1d2HsdNZqZBzuPeU70RHDN9iuY0KV19A-/view?usp=sharing'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1CwIp3_IwziObTar3-chwkX7E1LDuMBhU/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1E2jyUpPv1T4GmHQgavPqsy45EQ7McY82/view?usp=sharing'),
            ]),
            quarter('Second Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1t70MDNz8VcUTJSDLUKug4H5qEDUQfmSk/preview'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1cgdZlY4UunWZsJITzG6Nwkp5KPBzaqJg/preview'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1E-d0xT0t3mRd_pcmp18gpOuS_q4nrSBZ/preview'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1r_zGvmVGbw_XIs1itALKATDDIuoXankv/preview'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1wAHx-kLGLlhmavVtEbBQ9xpOxBnnihI1/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1CGO2tg-cx6wgF0iMHK1KWIfXvRvaJN7Q/preview'),
            ]),
            quarter('Third Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/140SWseSVtDAcIyS0Y6wKlaMmxgmsRVwa/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/196DaGB8_q27rnpzLmvghTXNJTtDFC6zV/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1l2c9UH90cNwScgC5RGru5xfCvaIDhdTs/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/13wyYc_C-ZklOnFyu4thMzigMLtMeDAjH/view?usp=sharing'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1Y9zuu2gkKoZS2hPYI6qMj3-WGDFNmaG4/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/186JiqKicw-A7K-kppvLFJJr_GwDwzR8Q/view?usp=sharing'),
            ]),
            quarter('Fourth Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1j6xbVBifeisEl0Esf1fMIoKrzvQS-D6Z/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1Up0LbVWuKNPxO1FT0u71LXw_sFEUewy2/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1K5Nf-HGQWxjUhfGp0UuHIqb97tp-BKMI/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1QV5LKCaFRsXV4FPtP8vD2S01kqh8t91F/view?usp=sharing'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1RjDxqKz3IrTTi65HpXc-kNqaXAqT0Txw/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1APjzDVJuRjx6S7WaaIVYrVEpFxkdA8HE/view?usp=sharing'),
            ]),
        ],
    },
    {
        year: '2023',
        summary: 'Archived quarter-by-quarter reports from the previous year.',
        quarters: [
            quarter('First Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1sRuEcp7PCSZZiAQ3QlSyISS3VGNye3oW/view?usp=sharing'),
                doc('FAR NO 1', 'https://drive.google.com/file/d/11bj76K3cnZlaXVZPf6epKNIHHYZb03mg/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1xMPqIgEaSiGC2ojaljkTbDTfqeJQyOwi/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1Cei9COEgmpvaPcuRt_AUVEBMSZgSekA0/view?usp=sharing'),
            ]),
            quarter('Second Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1QUYYuUOEJdcZ2b8oBcClZVOGey_FaaJN/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1YcIQaK4rHQDlwlOA4y4iSSOdBs4u3I4h/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1zmf3Q2XflxGFCF7CK4xNQ7cigkBuWr4C/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1zmf3Q2XflxGFCF7CK4xNQ7cigkBuWr4C/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1mRd2B37h5cjTVDXw_tYSLfiODuhVhF0z/view?usp=sharing'),
            ]),
            quarter('Third Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1vaFjT_5cbXJbm5ewYibNeSzOyDhX71s0/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1kG38fn9E-CDnAJm-ay4MCZxZaYdIVD5w/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1gGpqAlSy2rCN7ac0AHNiMQcb5oqsQEKw/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1K8kKxtIeJKVUfQFcendmrCn_MtlfxaWs/view?usp=sharing'),
            ]),
            quarter('Fourth Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1u5xgKFVj9bJRFSIsSgSalJw7vaeqfftk/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1C_5put3QUzfGxx0N1jOa1vdqPeupe43T/view?usp=sharing'),
                doc('FAR NO 3', 'https://drive.google.com/file/d/1QDt_ry1iLXESvF2GAmluyJ284IdRsPen/view?usp=sharing'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1QDt_ry1iLXESvF2GAmluyJ284IdRsPen/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1RtjEi5FGh8HJEeqsEpJ3IRJGkmdWRqKO/view?usp=sharing'),
            ]),
        ],
    },
    {
        year: '2022',
        summary: 'Older financial accountability reports retained for public reference.',
        quarters: [
            quarter('First Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1Kd7fKDPqXR3gfOORqLPQUoDli8jHJoFW/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1IZDSTTkmWECsUg90hvgoLNrJ0y_5dpFp/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1eKmDsxPYL1qhTqFeVSozgCB-xkV87YQp/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/1lGJbJcFHwBKQgt7apysWY7WvbAdIFuY4/view?usp=sharing'),
                doc('FAR NO 4', 'https://drive.google.com/file/d/1MWGTv0Ob32uLqV2mip37hIgpiNb9gcrV/view?usp=sharing'),
                doc('FAR NO 5', 'https://drive.google.com/file/d/1RvHnsS_edSPYHOn8NOTPeJC6nAL0CPtf/view?usp=sharing'),
            ]),
            quarter('Second Quarter', [
                doc('FAR 1', 'https://drive.google.com/file/d/1SLAGXfoFDiyXXKYi9wYDUk3mrYT-prZp/view?usp=sharing'),
                doc('FAR 1-A', 'https://drive.google.com/file/d/17lb4Pgd3YBo-bexW_5W346-FisBD7eId/view?usp=sharing'),
                doc('FAR NO.2', 'https://drive.google.com/file/d/1raGKRMOUIDIK0U2hN0jOw4ZvFX-5Hvb_/view?usp=sharing'),
                doc('FAR NO.2-A', 'https://drive.google.com/file/d/1KxzUCHAe-maCX0969_bK8oJUDJRJBTep/view?usp=sharing'),
                doc('FAR NO.4', 'https://drive.google.com/file/d/1GA_cwprq258cKjszsCgytO_1WCT3hgFH/view?usp=sharing'),
                doc('FAR NO.5', 'https://drive.google.com/file/d/1NSt98W15RliA2Fl-pKL9REdxFDLmNKw8/view?usp=sharing'),
            ]),
            quarter('Third Quarter', [
                doc('FAR 1', 'https://drive.google.com/file/d/1dD5PDul1u-PoEuqoSJkVICgHKF51cdvH/view?usp=share_link'),
                doc('FAR 1-A', 'https://drive.google.com/file/d/17mq_ajMpixHFjdMrkOy331sp0YUU84D9/view?usp=share_link'),
                doc('FAR NO.2', 'https://drive.google.com/file/d/10Nc1-CVwG3C7kdT36G67dVig7W7GiR2Q/view?usp=share_link'),
                doc('FAR NO.2-A', 'https://drive.google.com/file/d/10fxojncFu4qAaJpGOaoBGD-sxMJZl2GZ/view?usp=share_link'),
                doc('FAR NO.4', 'https://drive.google.com/file/d/1dTIHDALmd7WgNisNg6ACAaFjDAC0bZqU/view?usp=share_link'),
                doc('FAR NO.5', 'https://drive.google.com/file/d/1K-WBH58ff7SSeyj9hcuqfIn1Cazyind3/view?usp=share_link'),
            ]),
            quarter('Fourth Quarter', [
                doc('FAR 1', 'https://drive.google.com/file/d/1Thfck41NqRbg0UKdxKgkaLNr53lIqT98/view?usp=sharing'),
                doc('FAR 1-A', 'https://drive.google.com/file/d/1C7fIJgLtez3NJoE7EFNRYywNsmmem1NF/view?usp=sharing'),
                doc('FAR NO.3', 'https://drive.google.com/file/d/11xiVDoO5Dcxz7qkybt3gkP9j6yInMThg/view?usp=sharing'),
                doc('FAR NO.5', 'https://drive.google.com/file/d/1x88HFOQRdFA549NTJHLXVS8Qo3lyWBqv/view?usp=sharing'),
            ]),
        ],
    },
    {
        year: '2021',
        summary: 'A complete set of quarterly accountability records for the year.',
        quarters: [
            quarter('First Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1EnkP9Wb1TuQNv45E41vR5-fQt1zpOvqs/view?usp=sharing'),
                doc('FAR NO 1-A', 'https://drive.google.com/file/d/1oSdNgVOHXSMtZx1dMysCdp97ftR-XCxi/view?usp=sharing'),
                doc('FAR NO 2', 'https://drive.google.com/file/d/1VYjHOW9wHuu-iWRwVM2pU7dZ2AC80Xzn/view?usp=sharing'),
                doc('FAR NO 2-A', 'https://drive.google.com/file/d/19d2LeOadvstINtRaIczcbAS_iOj0D1yO/view?usp=sharing'),
                doc('FAR NO.4', 'https://drive.google.com/file/d/1DPgKKbR5PKCQ68Ljp_mxu8oNOGx5A-pG/view?usp=sharing'),
                doc('FAR NO.4-A', 'https://drive.google.com/file/d/1oX6E3mUffr0TdAahm_1aCpK42EVnRSxw/view?usp=sharing'),
                doc('FAR NO.5', 'https://drive.google.com/file/d/1RIM0x_bQvUXDcypRukrac0BQYskBqo-8/view?usp=sharing'),
            ]),
            quarter('Second Quarter', [
                doc('FAR NO 1', 'https://drive.google.com/file/d/1K5TnqIom29XyEVz-P9xu5dAOE76hEAQI/view?usp=sharing'),
                doc('FAR 1-A', 'https://drive.google.com/file/d/1LGYgbTEFYSIXkuVR442fEk6TfXQUEMF6/view?usp=sharing'),
                doc('FAR NO.2', 'https://drive.google.com/file/d/1-4NGVQasDDEFWxqXeLm-1zmlKw5gUpVb/view?usp=sharing'),
                doc('FAR NO.2-A', 'https://drive.google.com/file/d/1LwkSMreWJtz0v_2OWE4WPdNUbHAgHUfS/view?usp=sharing'),
                doc('FAR NO.3', 'https://drive.google.com/file/d/1ESeJdRpEzPiGZS12tWKQoQVCscs5BqUC/view?usp=sharing'),
                doc('FAR NO.4', 'https://drive.google.com/file/d/1ESeJdRpEzPiGZS12tWKQoQVCscs5BqUC/view?usp=sharing'),
                doc('FAR NO.5', 'https://drive.google.com/file/d/1r8BW8v8W4oNvejSrkeMBJJPln372Abib/view?usp=sharing'),
            ]),
            quarter('Third Quarter', [
                doc('FAR 1', 'https://drive.google.com/file/d/1HYPSkBpPKLx2DNqLb4eL9WPCmkaVmlwu/view?usp=sharing'),
                doc('FAR 1-A', 'https://drive.google.com/file/d/1HGbcBWfbZv6qCYgc0uq-zowZB6jX0Ys2/view?usp=sharing'),
                doc('FAR NO.2', 'https://drive.google.com/file/d/1-HRdyxFrDX8SlCrmr1LlVK_6zmvVopm5/view?usp=sharing'),
                doc('FAR NO.2-A', 'https://drive.google.com/file/d/1yHNUhg8wK1BI4AqOHyJWn1SiSWsxLe-U/view?usp=sharing'),
                doc('FAR NO.3', 'https://drive.google.com/file/d/1H4MVDBY_Z39PpGINAj_Heieno69Y39ov/view?usp=sharing'),
                doc('FAR NO.4', 'https://drive.google.com/file/d/1H4MVDBY_Z39PpGINAj_Heieno69Y39ov/view?usp=sharing'),
                doc('FAR NO.5', 'https://drive.google.com/file/d/1yHNUhg8wK1BI4AqOHyJWn1SiSWsxLe-U/view?usp=sharing'),
            ]),
            quarter('Fourth Quarter', [
                doc('FAR 1', 'https://drive.google.com/file/d/1MSegU-eTKs3ZpFEN4zEAA10M2uQNuIaV/view?usp=sharing'),
                doc('FAR 1-A', 'https://drive.google.com/file/d/1-9bJztQC0TISmHHg1RmMiCQVsedbdL1d/view?usp=sharing'),
                doc('FAR NO.2', 'https://drive.google.com/file/d/1xG12dEIsMBarjgqY-ose5AYHTSQR6qI8/view?usp=sharing'),
                doc('FAR NO.3', 'https://drive.google.com/file/d/1KvUBAn6EZldRrMlGH56sM03WTNgZ04Jo/view?usp=sharing'),
                doc('FAR NO.4', 'https://drive.google.com/file/d/1bwg-ziDcfwHUg8LmtkGqyyaUayT1ikLO/view?usp=sharing'),
                doc('FAR NO.5', 'https://drive.google.com/file/d/1g7pLQiH0WzGAX_Waex6JnpRiqdRTN6jt/view?usp=sharing'),
            ]),
        ],
    },
    {
        year: '2020',
        summary: 'Legacy downloadable records kept for continuity and transparency.',
        quarters: [
            quarter('First Quarter', [
                doc('FAR 1', '/public_files/files/Far%20no.%201.pdf'),
                doc('FAR 1-A', '/public_files/files/Far%20no.%201a.pdf'),
                doc('FAR NO.2', '/public_files/files/Far%20no%202.pdf'),
                doc('FAR NO.2-A', '/public_files/files/Far%20no%202a%281%29.pdf'),
                doc('FAR NO.4', '/public_files/files/Far%20no.%204.pdf'),
                doc('FAR NO.5', '/public_files/files/Far%20no.%205.pdf'),
            ]),
            quarter('Second Quarter', [
                doc('FAR 1', '/public_files/files/FAR%201%20transparency%202nd%20quarter.pdf'),
                doc('FAR 1-A', '/public_files/files/FAR%201A%20transparency%202nd%20quarter.pdf'),
                doc('FAR NO.2', '/public_files/files/FAR%20NO.%202%20transparency%202nd%20quarter.pdf'),
                doc('FAR NO.2-A', '/public_files/files/FAR%202A%20transparency%202nd%20quarter.pdf'),
                doc('FAR NO.4', '/public_files/files/Far%20no%204%20transparency%202nd%20quarter.pdf'),
                doc('FAR NO.5', '/public_files/files/FAR%20NO.%205%20transparency%202nd%20quarter.pdf'),
            ]),
            quarter('Third Quarter', [
                doc('FAR 1', 'https://drive.google.com/file/d/1C5S-u1R74ZVcEb5cFLu1K64lEmTWt0n5/view?usp=sharing'),
                doc('FAR 1-A', 'https://drive.google.com/file/d/1ct9jIsKgiEn6dsevNbLpYYLCpi1OHfUM/view?usp=sharing'),
                doc('FAR NO.2', 'https://drive.google.com/file/d/1wxIw8RDvkLwc84LZBMbIjbsnYPKG8Xq0/view?usp=sharing'),
                doc('FAR NO.2-A', 'https://drive.google.com/file/d/1pPMXwrH5yGnEyRKi4eiaoA57wYZ8jvzA/view?usp=sharing'),
                doc('FAR NO.5', 'https://drive.google.com/file/d/1sVOp0vmtCCYfhl7pXhRt0f3qFYUD_KzR/view?usp=sharing'),
            ]),
            quarter('Fourth Quarter', [
                doc('FAR 1', 'https://drive.google.com/file/d/1lskL-oeVjM7SzY-Kc-Z1OYxsXCH9NcBy/view?usp=sharing'),
                doc('FAR 1-A', 'https://drive.google.com/file/d/1SPFR7Nypi7VdHStsT403phKewBzAwsbe/view?usp=sharing'),
                doc('FAR NO.2', 'https://drive.google.com/file/d/1LV56_2Tu7Y5SAtwE7QuGZ_5gw5fz-uw_/view?usp=sharing'),
                doc('FAR NO.3', 'https://drive.google.com/file/d/13Y3gpxAaiKzOvRjEPPp16UMDV_itk9g8/view?usp=sharing'),
            ]),
        ],
    },
];

const transparencySections: TransparencySection[] = [
    {
        code: 'III',
        title: 'Current GAA Budget and Target',
        description: 'Annual GAA budget and physical target references by fiscal year.',
        items: [
            { label: 'GAA FY2024 NEMSU Budget', href: 'https://drive.google.com/file/d/1hC4kcD4wdQh6Xp5MkuCzWntgFogJdHij/view?usp=sharing' },
            { label: 'GAA FY2024 NEMSU Physical Targets', href: 'https://drive.google.com/file/d/1H0DHIocwVFAHCqTJSgPLaf91qUJSjLUQ/view?usp=sharing' },
            { label: 'GAA FY2023 NEMSU Budget', href: 'https://drive.google.com/file/d/1mEqkAXUJOisWTERNTTWanb-2ILyNY4aL/view?usp=sharing' },
            { label: 'GAA FY2023 NEMSU Physical Targets', href: 'https://drive.google.com/file/d/12iKnLBCGB8GREbBxKh9RvVOHWW1PtfCP/view?usp=sharing' },
            { label: 'Budget for FY 2022', href: 'https://drive.google.com/file/d/1aMaFhMpNtJGP2b2_7sNyjfDKtMjCf07h/view?usp=sharing' },
            { label: 'Performance targets for FY 2022', href: 'https://drive.google.com/file/d/1nYvXdOlYAB_4zyb0ACtlvFV4-FxvNcal/view?usp=sharing' },
            { label: 'Budget for FY 2021', href: 'https://drive.google.com/file/d/1FxQA9Bf-oiyx75uBisI9UThrVL0G_0lp/view?usp=sharing' },
            { label: 'Performance targets for FY 2021', href: 'https://drive.google.com/file/d/1PW9dpyVoSU4tmWyYA4iib95PnKrj5Yis/view?usp=sharing' },
            { label: 'Budget for FY 2020', href: '/public_files/files/SDSSU%20Budget%20for%20FY%202020.pdf' },
            { label: 'Performance targets for FY 2020', href: '/public_files/files/SDSSU%20Perfomance%20Targets%20FY%202020.pdf' },
            { label: 'Budget for FY 2019', href: '/public_files/files/Budget%20for%20FY%202019_compressed.pdf' },
            { label: 'Performance targets for FY 2019', href: '/public_files/files/SDSSU%20Performance%20Targets%20for%20FY2019%5B2525%5D.pdf' },
        ],
    },
    {
        code: 'IV',
        title: 'Projects, Programs and Activities, Beneficiaries, and Status of Implementation for FY 2023',
        description: 'The source file marks this section as not applicable.',
        items: [{ label: 'Not Applicable' }],
    },
    {
        code: 'V',
        title: 'Annual Procurement Plan',
        description: 'Annual procurement plan documents, CSE forms, and semester changes.',
        items: [
            { label: 'Revised Annual Procurement Plan FY 2025-GOP', href: 'https://drive.google.com/file/d/1I0oCRSg9eDrPUkYE6KD4JYlyJc7_pLCS/view?usp=drive_link' },
            { label: 'Revised Annual Procurement Plan FY 2025-Income', href: 'https://drive.google.com/file/d/1IVrLLtIJsMvSx46nDuxWnClusNS76sHF/view?usp=drive_link' },
            { label: 'Annual Prcurement Plan GAA FY 2026', href: 'https://drive.google.com/file/d/1ThVnNr6McIBRxtTMfcLKj5pq_OZ41vY8/view?usp=drive_link' },
            { label: 'Annual Prcurement Plan STF FY 2026', href: 'https://drive.google.com/file/d/1RzEC5KGWuZ3xNlhdR7wWGBwkKPuS-S8z/view?usp=drive_link' },
            { label: 'Indicative Annual Prcurement Plan FY 2026', href: 'https://drive.google.com/file/d/1CZnLWYM84PF0rN-BWipagGnNMociD6pY/view?usp=sharing' },
            { label: 'Annual Procurement Plan-Common-Use Supplies and Equipment (APP-CSE) 2026 Form', href: 'https://drive.google.com/file/d/1GCxz5E00KA-JEVbX75Tsnf5epZdj_uJi/view?usp=sharing' },
            { label: 'Annual Procuremen Plan FY 2025-GOP -Changes from Fisrt Semester', href: 'https://drive.google.com/file/d/1k-cwNWj3eFcbEtoZ5-hGBHzJs9JdwOfp/view?usp=sharing' },
            { label: 'Annual Procuremen Plan FY 2025-Income-Changes from First Semester', href: 'https://drive.google.com/file/d/1693jJrkllRlfYPmBXVpNUxdLo4X3UqXJ/view?usp=sharing' },
            { label: 'Annual Procurement Plan FY 2025-GOP', href: 'https://drive.google.com/file/d/150aNA5foE6oHLW5oTTlDAq6GEfOMFS7Q/view?usp=sharing' },
            { label: 'Annual Procuremnt Plan FY 2025-Income', href: 'https://drive.google.com/file/d/15rbny-m3M67TpdWSXs2Z6ATOVBMOMuYV/view?usp=sharing' },
            { label: 'Indicative Annual Procurement Plan FY 2025 (GAA)', href: 'https://drive.google.com/file/d/1olP2nxqg1WIaOT-lt0v5u1vcLckwP0mq/view?usp=share_link' },
            { label: 'Indicative Annual Procurement Plan FY 2025 (STF)', href: 'https://drive.google.com/file/d/1jcnPmd3oXd0IoSh1tBVzdeGR0gYZ2o1t/view?usp=share_link' },
            { label: 'Annual Procurement Plan FY 2025 CSE', href: 'https://drive.google.com/file/d/1TWuZEABGMXXqMJlUPswrkCOG-l7yALjv/view?usp=sharing' },
            { label: 'Annual Procuremen Plan FY 2024-GOP -Changes from Fisrt Semester', href: 'https://drive.google.com/file/d/1PeYJxoA9pQ9WEMW-GmGhq8KUpZaU9s4X/view?usp=sharing' },
            { label: 'Annual Procuremen Plan FY 2024-Income-Changes from First Semester', href: 'https://drive.google.com/file/d/1XsssH3OVDzEwip7I17oyt4HcPCW1FrcH/view?usp=sharing' },
            { label: 'Annual Procurement Plan FY 2024-GOP', href: 'https://drive.google.com/file/d/1n8Oh6Pkxees9tF0vP5T_4DksdeUlSl5A/view?usp=sharing' },
            { label: 'Annual Procuremnt Plan FY 2024-Income', href: 'https://drive.google.com/file/d/1fSlK3YgBWMjOtLfbocn0lZ5RDQXb_zNc/view?usp=sharing' },
            { label: 'Indicative Annual Procurement Plan FY-2024 - GOP', href: 'https://drive.google.com/file/d/1p2jBR_jH9UjIB_brHbLscna5O6KquTRT/view?usp=sharing' },
            { label: 'Annual Procurement Plan FY-2024 - Income', href: 'https://drive.google.com/file/d/1QwHwhsJuYHZChfMmTknWdi0wlVapo-aB/view?usp=sharing' },
            { label: 'Annual Procuremnt Plan Common Use Supplies and Equipment (APP-CSE) 2024 Form', href: 'https://drive.google.com/file/d/1f1GdBceXApZ3_RHKcf3MK88-EgINcMzT/view?usp=sharing' },
            { label: 'Annual Procurement Plan FY-2023-GOP', href: 'https://drive.google.com/file/d/1IF3N8R21-SHJNXGmggjxxFWzd_iydCfS/view?usp=sharing' },
            { label: 'Annual Procurement Plan FY-2023-Income', href: 'https://drive.google.com/file/d/1FFWsSVA1K1GUeTjfr_zS_3XU1AooUkEM/view?usp=sharing' },
            { label: 'Annual Procurement Plan FY-2022 GOP Changes from Second Semester', href: 'https://drive.google.com/file/d/1BLN_2IYE2Vc1pxh5RflxXzqpcDlxxP7S/view?usp=sharing' },
            { label: 'Annual Procurement Plan FY-2022 Income Changes from SecondSemester', href: 'https://drive.google.com/file/d/1gWeWgXDiYjP2DBVQJDYEpOfBR0qtoNZG/view?usp=sharing' },
            { label: 'Indicative Annual Procurement Plan FY-2023 (Non-CSE) GOP', href: 'https://drive.google.com/file/d/1gotGtDI3fHfbZNIniigjRUFW3CaOvCTq/view?usp=share_link' },
            { label: 'Indicative Annual Procurement Plan FY-2023 (Non-CSE) Income', href: 'https://drive.google.com/file/d/13kzx5mNPl1aSkRsLXa0UKamORB98b3Pd/view?usp=share_link' },
            { label: 'Annual Procurement Plan FY-2022 (Non-CSE) GOP', href: 'https://drive.google.com/file/d/1nx_fJs2t69WHAZfMS1pD-0pc3j_fJNCh/view?usp=sharing' },
            { label: 'Annual Procurement Plan FY-2022 (Non-CSE) Income', href: 'https://drive.google.com/file/d/1lmlpR0f1oZzIxnCkj3x5QSGQ0_0G-Ul5/view?usp=sharing' },
            { label: 'Indicative Annual Procurement Plan ( APP) GOP FY 2022', href: 'https://drive.google.com/file/d/1y_a0i589gj-NNBWJa02g3YYmUDa3w4Ii/view?usp=sharing' },
            { label: 'Indicative Annual Procurement Plan (APP) Income FY 2022', href: 'https://drive.google.com/file/d/1PJaEYM0rlapJMjz09Ua7Mcv6ntGvVws-/view?usp=sharing' },
            { label: 'FY 2022 APP CSE', href: 'https://drive.google.com/file/d/1l247j3D43gICOrJg08N5Ols1l1UoTSm8/view?usp=sharing' },
            { label: 'FY 2021 APP non-CSE' },
            { label: 'FY 2021 APP CSE', href: 'https://drive.google.com/file/d/1mzucrda4jTr_keTT_1HLegSvW4tYEjGq/view?usp=sharing' },
            { label: 'Indicative Annual Procurement Plan FY 2021 (non-CSE)', href: '/public_files/files/Indicative-Annual-Procurement-Plan-FY-2021-APP-Non-CSE.pdf' },
            { label: 'APP for 2021 (GOP)', href: 'https://drive.google.com/file/d/1aBZtDx3sns9DSMK7pDZSt3ZDgrjEWoT3/view?usp=sharing' },
            { label: 'APP for 2021 (Income)', href: 'https://drive.google.com/file/d/1Ji-siEqNva-nJnPCAsOeE6QtUdNAioQM/view?usp=sharing' },
            { label: 'FY 2020 APP non-CSE', href: '/public_files/files/APP-for-2020-GOP-of-Surigao-del-Sur-Satet-University.pdf' },
            { label: 'FY 2020 APP CSE', href: 'https://drive.google.com/open?id=0B4i4tn-pS4iPcDFjN2pTM0c4TjlOaDd2cXhsdkpKTHVRV2Qw' },
            { label: 'Revised Annual Procurement Plan (APP) FY 2020 Income', href: 'https://drive.google.com/file/d/1BSZDRC3ru1jtij6B9mMV4EhwL0gZxaSc/view?usp=sharing' },
            { label: 'Indicative Annual Procurement Plan FY 2020 (non-CSE)', href: '/public_files/files/IndicativeAnnualProcurementPlan2020.pdf' },
            { label: 'APP for 2019 (GOP)', href: '/public_files/files/APP%20for%202019%20%28GOP%29%20of%20Surigao%20del%20Sur%20State%20University-Caraga%20Rrgion.pdf' },
            { label: 'APP for 2019 (Income)', href: '/public_files/files/APP%20for%202019%20%28Income%29%20of%20Surigao%20del%20Sur%20Satet%20University-Caraga%20Region.pdf' },
            { label: 'Indicative Annual Procurement Plan FY 2019 (non-CSE)', href: '/public_files/files/APP%202019.pdf' },
            { label: 'FY 2019 APP for Common-Supplies and Equipment (FY 2019 APP CSE)', href: '/public_files/files/APP-CSE%202019.pdf' },
        ],
    },
    {
        code: 'VI',
        title: 'Procurement Monitoring Report (PMR)',
        description: 'Quarterly PMR entries grouped by fiscal year.',
        items: [
            { label: 'FY 2025 Procurement Monitoring Report (PMR) - July - December 2025', href: 'https://drive.google.com/file/d/1MU-w8sHhu5lbhM2sEvP8HHIAHl-1CZau/view?usp=sharing' },
            { label: 'FY 2025 Procurement Monitoring Report (PMR) - January - June 2025', href: 'https://drive.google.com/file/d/1Stt6KaQkXezVaw_RX_tn2wJx25razKHS/view?usp=sharing' },
            { label: 'FY 2024 Procurement Monitoring Report (PMR) - July - December 2024', href: 'https://drive.google.com/file/d/1keC-56MMXVqTUZFDrooG_8yVtm4rsF4r/view?usp=sharing' },
            { label: 'FY 2024 Procurement Monitoring Report (PMR) - January - June 2024', href: 'https://drive.google.com/file/d/1e0WROyYg74nOj5X26oA8TO-LkmR9XJAc/preview' },
            { label: 'FY 2023 Procurement Monitoring Report (PMR) - January - June 2023', href: 'https://drive.google.com/file/d/1VHRlUAc9A4W9As0yTc7ZYkQu4WAjdjqP/view?usp=sharing' },
            { label: 'FY 2023 Procurement Monitoring Report (PMR) - July - December 2023', href: 'https://drive.google.com/file/d/1waNPO4iN17xKr5fhoqlYOByFj40Lb9AW/view?usp=sharing' },
            { label: 'FY 2022 Procurement Monitoring Report (PMR) - January - June 2022', href: 'https://drive.google.com/file/d/1Hsqwayj6tRE5YZxwSOeXpAP_WGk1K6bF/view?usp=sharing' },
            { label: 'FY 2022 Procurement Monitoring Report (PMR) - July - December 2022', href: 'https://drive.google.com/file/d/12qaHgsfD13-UahIVxV1pFVbkMzsi5MW-/view?usp=share_link' },
            { label: 'FY 2021 Procurement Monitoring Report (PMR) - January - June 2021', href: 'https://drive.google.com/file/d/1j71b3Cs8GkS7Ehstr0LLaP9g6O4WYeUE/preview' },
            { label: 'FY 2021 Procurement Monitoring Report (PMR) - July - December 2021', href: 'https://drive.google.com/file/d/1HwAA02UWPEOodkPorPE6A3jC0RDzM7bY/preview' },
            { label: 'FY 2020 Procurement Monitoring Report (PMR) - January - June 2020', href: '/public_files/files/Surigao%20del%20Sur%20State%20University%20%28SDSSU%29%20Procurement%20Monitoring%20Report%20%28PMR%29%20Jan.-June%202020-compressed.pdf' },
            { label: 'FY 2020 Procurement Monitoring Report (PMR) - July - December 2020', href: '/public_files/files/Procurement%20Monitoring%20Report%20%20%28PMR%29%20as%20of%20%20July-December%202020%20of%20Surigao%20del%20Sur%20State%20University.pdf' },
            { label: 'FY 2019 Procurement Monitoring Report (PMR) - January - June 2019', href: '/public_files/files/Surigao%20del%20Sur%20State%20University%20%28SDSSU%29%20Procurement%20Monitoring%20Report%20as%20of%20Jan.-June%202019%281%29.pdf' },
            { label: 'FY 2019 Procurement Monitoring Report (PMR) - July - December 2019', href: '/public_files/files/Surigao%20del%20Sur%20State%20University%20%28SDSSU%29%20%20Procurement%20Monitoring%20Report%20as%20of%20July-December%202019-min.pdf' },
            { label: 'FY 2018 Procurement Monitoring Report (PMR) - January - June 2018', href: '/public_files/files/Surigao%20del%20Sur%20State%20University%20Procurement%20Monitoring%20Report%20as%20of%20January-June%202018.pdf' },
            { label: 'FY 2018 Procurement Monitoring Report (PMR) - July - December 2018', href: '/public_files/files/Surigao%20del%20Sur%20State%20University%20SDSSU%20Procurement%20Monitoring%20Report%20as%20of%20July-December%202018.pdf' },
        ],
    },
    {
        code: 'VII',
        title: 'QMS ISO Certification',
        description: 'Quality management system certification references.',
        items: [{ label: 'ISO certification document', href: 'https://drive.google.com/file/d/1XnsOcYKg5saDhKxyoh0HNpbWsovWVlvu/view?usp=sharing' }],
    },
    {
        code: 'VIII',
        title: 'System of Evaluating the Performance of Delivery Units',
        description: 'Performance evaluation system reference for delivery units.',
        items: [{ label: 'Performance evaluation system document', href: 'https://drive.google.com/file/d/17idGOPVtmkdg4Td15XnPb0QRokGnj3Cn/view?usp=sharing' }],
    },
    {
        code: 'IX',
        title: 'The Agency Review and Compliance Procedure of Statements and Financial Disclosures',
        description: 'Review and compliance records for statements and financial disclosures.',
        items: [
            { label: 'A. SALN Review Certification FY2022', href: 'https://drive.google.com/file/d/1rDoUXGOj8cK8pg_dkBGTSphq71EaEJjv/view?usp=sharing' },
            { label: 'B. SALN Review Certification FY2021', href: 'https://drive.google.com/file/d/13sikIP46mcmdFbSDIAYoK4X4feAXm_y0/view?usp=sharing' },
        ],
    },
    {
        code: 'X',
        title: 'People’s Freedom to Information',
        description: 'FOI manual, request tools, survey form, and annual FOI reports.',
        items: [
            { label: 'NEMSU People\'s FOI Manual', href: 'https://drive.google.com/file/d/1S2QPmPW-sx98hcPxa6VTxzQ7X8ZpuBBf/view?usp=sharing' },
            { label: 'NEMSU-One-page-FOI-Manual', href: 'https://drive.google.com/file/d/1T4_eUD8SAtTlDvvQGjNPNBjOeCNAACQO/view?usp=sharing' },
            { label: 'NEMSU-FOI-Request-Feedbak-Survey-Form', href: 'https://drive.google.com/file/d/1l1oAYuVyRquzj0e03E2_jcS-d0cmLPAm/view?usp=sharing' },
            { label: '2024 FOI Reports', href: 'https://docs.google.com/spreadsheets/d/1Vi7eTrjR2FrY-7CwmHUXOYxlPNhHoKBy/edit?usp=drive_link&ouid=118069644834388500470&rtpof=true&sd=true' },
            { label: '2023 FOI Reports', href: 'https://docs.google.com/spreadsheets/d/13RwB_ZvmJwUnoWJbXiPhDhM6olvSdS2D/edit?usp=sharing' },
            { label: '2022 FOI Reports', href: 'https://docs.google.com/spreadsheets/d/1-peJiXcwBVjAdspKYb-QfTas4nO5cytZ/edit?usp=sharing' },
            { label: '2021 FOI Reports', href: 'https://docs.google.com/spreadsheets/d/1HQUNHkxSsrr5YRp2idNBvh3Sse3VauU3/edit?usp=sharing' },
        ],
    },
];

const setSectionVisibility = (section: string, isVisible: boolean): void => {
    const nextVisibleSections = new Set(visibleSections.value);

    if (isVisible) {
        nextVisibleSections.add(section);
    } else {
        nextVisibleSections.delete(section);
    }

    visibleSections.value = nextVisibleSections;
};

const isSectionVisible = (section: string): boolean =>
    visibleSections.value.has(section);

const revealClasses = (
    section: string,
    direction: RevealDirection = 'up',
): string =>
    [
        'transition-all duration-700 ease-out will-change-transform motion-reduce:translate-x-0 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:blur-0 motion-reduce:transition-none',
        isSectionVisible(section)
            ? 'translate-x-0 translate-y-0 opacity-100 blur-0'
            : `${revealOffset[direction]} opacity-0 blur-[2px]`,
    ].join(' ');

onMounted(() => {
    const animatedSections = document.querySelectorAll<HTMLElement>(
        '[data-scroll-section]',
    );
    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;

    if (prefersReducedMotion) {
        visibleSections.value = new Set(
            Array.from(animatedSections)
                .map((section) => section.dataset.scrollSection)
                .filter(Boolean) as string[],
        );

        return;
    }

    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const section = entry.target.getAttribute(
                    'data-scroll-section',
                );

                if (section) {
                    setSectionVisibility(section, entry.isIntersecting);
                }
            });
        },
        {
            rootMargin: '0px',
            threshold: 0.1,
        },
    );

    animatedSections.forEach((section) => {
        revealObserver?.observe(section);
    });
});

onBeforeUnmount(() => {
    revealObserver?.disconnect();
});
</script>

<template>
    <PublicSiteLayout>
        <Head title="Transparency Seal" />

        <div class="bg-white text-slate-950 dark:bg-slate-950 dark:text-white">
            <section class="relative isolate overflow-hidden bg-[#07113f] py-4 text-slate-950 sm:py-6 lg:py-8 dark:bg-slate-950 dark:text-white">
                <div class="pointer-events-none absolute inset-0 z-0 bg-gradient-to-r from-[#1711d4]/70 via-[#1711d4]/45 to-slate-950/80" aria-hidden="true"></div>

                <div class="relative z-10 w-full">
                    <div class="relative flex w-full flex-col items-center py-4 lg:h-[18rem] lg:py-0">
                        <div
                            class="pointer-events-none absolute top-1/2 left-1/2 z-0 hidden h-[18rem] w-[49rem] -translate-x-1/2 -translate-y-1/2 lg:block"
                            aria-hidden="true"
                        >
                            <div class="absolute top-0 -left-16 size-16 bg-[#4661ff] [clip-path:polygon(100%_0,100%_100%,0_100%)]"></div>
                            <div class="absolute top-0 -right-16 size-16 bg-[#4661ff] [clip-path:polygon(0_0,100%_100%,0_100%)]"></div>
                            <div class="absolute bottom-0 -left-16 size-16 bg-[#4661ff] [clip-path:polygon(0_0,100%_0,100%_100%)]"></div>
                            <div class="absolute bottom-0 -right-16 size-16 bg-[#4661ff] [clip-path:polygon(0_0,100%_0,0_100%)]"></div>
                        </div>

                        <div class="relative z-10 w-full overflow-hidden bg-slate-200 lg:absolute lg:top-1/2 lg:left-0 lg:h-[15rem] lg:w-[48%] lg:-translate-y-1/2 dark:bg-slate-800">
                            <img
                                :src="heroLeftImage"
                                alt="NEMSU administration building facade"
                                class="h-40 w-full object-cover object-center sm:h-48 lg:h-full"
                            />
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-[#1711d4]/70 via-[#1711d4]/55 to-slate-950/65 mix-blend-multiply" aria-hidden="true"></div>
                        </div>

                        <div class="relative z-20 -my-5 min-h-44 w-[90%] max-w-4xl text-center text-white sm:min-h-48 lg:absolute lg:top-1/2 lg:left-1/2 lg:m-0 lg:h-[18rem] lg:w-[49rem] lg:-translate-x-1/2 lg:-translate-y-1/2">
                            <div class="relative z-10 flex min-h-44 w-full flex-col items-center justify-center overflow-hidden bg-[#073b73] px-8 py-6 text-center sm:min-h-48 sm:px-12 lg:h-full lg:px-16">
                                <img
                                    src="/images/administration/ovpaf/pattern.png"
                                    alt=""
                                    class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-screen"
                                    aria-hidden="true"
                                />
                                <h3 class="relative z-10 text-4xl font-semibold whitespace-nowrap tracking-normal text-[#7dd3fc] sm:text-5xl lg:text-[3.35rem]">
                                    TRANSPARENCY SEAL
                                </h3>
                                <nav
                                    class="relative z-10 mt-5 text-sm  text-white/80"
                                    aria-label="Breadcrumb"
                                >
                                    <ol class="flex flex-wrap items-center justify-center gap-2">
                                        <li>
                                            <Link
                                                :href="home()"
                                                class="transition hover:text-[#f2b705]"
                                            >
                                                Home
                                            </Link>
                                        </li>
                                        <li class="text-white/80" aria-hidden="true">
                                            /
                                        </li>
                                        <li>
                                            <Link
                                                :href="goodGovernance()"
                                                class="transition hover:text-[#f2b705]"
                                            >
                                                Good Governance
                                            </Link>
                                        </li>
                                        <li class="text-white/80" aria-hidden="true">
                                            /
                                        </li>
                                        <li class="text-[#f2b705]" aria-current="page">
                                            Transparency Seal
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                        <div class="relative z-10 w-full overflow-hidden bg-slate-200 lg:absolute lg:top-1/2 lg:right-0 lg:h-[15rem] lg:w-[48%] lg:-translate-y-1/2 dark:bg-slate-800">
                            <img
                                :src="heroRightImage"
                                alt="NEMSU campus administrative building"
                                class="h-40 w-full object-cover object-center sm:h-48 lg:h-full"
                            />
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-[#1711d4]/70 via-[#1711d4]/55 to-slate-950/65 mix-blend-multiply" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            </section>
            <section
                id="annual-reports"
                class="border-y border-slate-200 bg-[#f7f8f5] py-14 dark:border-white/10 dark:bg-slate-900"
            >
                <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[20rem_1fr] lg:px-8">
                    <aside
                        data-scroll-section="annual-reports-heading"
                        class="lg:sticky lg:top-32 lg:self-start"
                        :class="revealClasses('annual-reports-heading', 'right')"
                    >
                        <p class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300">
                            Annual Financial Reports
                        </p>
                        <h4 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
                            Year-by-year archive
                        </h4>
                        <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            The attached data is organized from the latest posted year down to 2020 so each quarter remains easy to scan.
                        </p>
                    </aside>

                    <div class="grid gap-5">
                        <article
                            v-for="year in transparencyYears"
                            :key="year.year"
                            :data-scroll-section="`annual-report-${year.year}`"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                            :class="revealClasses(`annual-report-${year.year}`)"
                        >
                            <div class="border-b border-[#0f0ab8] bg-[#1711d4] p-5 text-white dark:border-white/10">
                                <p class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase">
                                    {{ year.year }}
                                </p>
                                <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                    <div>
                                        <h4 class="text-2xl font-semibold tracking-normal">
                                            {{ year.summary }}
                                        </h4>
                                    </div>
                                    <p class="text-sm text-white/85">
                                        {{ year.quarters.length }} quarter blocks
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-0 xl:grid-cols-4">
                                <section v-for="quarterArchive in year.quarters" :key="`${year.year}-${quarterArchive.label}`" class="border-t border-slate-200 p-5 first:border-t-0 xl:border-t-0 xl:border-l dark:border-white/10">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex size-10 shrink-0 items-center justify-center rounded-md bg-[#e7f3fb] text-[#0b3d91] dark:bg-sky-400/10 dark:text-sky-200">
                                            <CalendarRange class="size-5" aria-hidden="true" />
                                        </span>
                                        <div>
                                            <h5 class="text-sm font-semibold tracking-wide text-slate-950 uppercase dark:text-white">
                                                {{ quarterArchive.label }}
                                            </h5>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ quarterArchive.documents.length ? `${quarterArchive.documents.length} files` : 'No file posted yet' }}
                                            </p>
                                        </div>
                                    </div>

                                    <ul class="mt-4 space-y-2">
                                        <li v-if="!quarterArchive.documents.length" class="rounded-md bg-slate-50 px-3 py-2 text-sm text-slate-500 dark:bg-white/5 dark:text-slate-400">
                                            Pending publication.
                                        </li>
                                        <li v-for="document in quarterArchive.documents" :key="`${year.year}-${quarterArchive.label}-${document.label}`">
                                            <a :href="document.href" target="_blank" rel="noreferrer" class="group flex items-center justify-between gap-3 rounded-md bg-slate-50 px-3 py-2 text-sm text-slate-700 transition hover:bg-[#e7f3fb] hover:text-[#0b3d91] dark:bg-white/5 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white">
                                                <span class="leading-6">{{ document.label }}</span>
                                                <ArrowUpRight class="size-4 shrink-0 text-slate-400 transition group-hover:text-[#1711d4] dark:text-slate-500 dark:group-hover:text-sky-200" aria-hidden="true" />
                                            </a>
                                        </li>
                                    </ul>
                                </section>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="py-14 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="public-access"
                        class="grid gap-5 rounded-4xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/5 sm:p-8 lg:grid-cols-[1fr_auto] dark:border-white/10 dark:bg-white/4"
                        :class="revealClasses('public-access', 'up')"
                    >
                        <div>
                            <p class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300">
                                Public access
                            </p>
                            <h4 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
                                Keep the seal visible and the records easy to verify.
                            </h4>
                            <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                                This page keeps the seal image, the accountability summary, and the financial archive aligned with the public site styling used across NEMSU.
                            </p>
                        </div>

                        <div class="flex items-center">
                            <Link :href="home()" class="inline-flex items-center justify-center rounded-md bg-[#1711d4] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0f0ab8]">
                                Visit Home
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            <section class="border-t border-slate-200 bg-white py-14 sm:py-16 dark:border-white/10 dark:bg-slate-950">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        data-scroll-section="transparency-sections-heading"
                        class="max-w-3xl"
                        :class="revealClasses('transparency-sections-heading', 'right')"
                    >
                        <p class="text-sm font-semibold tracking-wide text-[#9b1c31] uppercase dark:text-rose-300">
                            Transparency seal sections
                        </p>
                        <h4 class="mt-3 text-3xl font-semibold tracking-normal text-slate-950 dark:text-white">
                            Sections III to X are now laid out here.
                        </h4>
                        <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            Each block below matches the requested transparency seal grouping. Items without uploaded files are shown as labels so the section structure stays visible.
                        </p>
                    </div>

                    <div class="mt-8 grid gap-5">
                        <article
                            v-for="section in transparencySections"
                            :key="section.code"
                            :data-scroll-section="`transparency-section-${section.code}`"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-[#f8fafc] shadow-sm shadow-slate-900/5 dark:border-white/10 dark:bg-white/4"
                            :class="revealClasses(`transparency-section-${section.code}`)"
                        >
                            <div class="border-b border-[#0f0ab8] bg-[#1711d4] p-5 text-white dark:border-white/10">
                                <p class="text-sm font-semibold tracking-wide text-[#f2b705] uppercase">
                                    {{ section.code }}
                                </p>
                                <h4 class="mt-2 text-2xl font-semibold tracking-normal text-white">
                                    {{ section.title }}
                                </h4>
                                <p class="mt-2 text-sm leading-6 text-white/80">
                                    {{ section.description }}
                                </p>
                            </div>

                            <div class="p-5">
                                <ul class="grid gap-2 sm:grid-cols-2 xl:grid-cols-3">
                                    <li v-for="item in section.items" :key="`${section.code}-${item.label}`" class="">
                                        <a v-if="item.href" :href="item.href" target="_blank" rel="noreferrer" class="group flex items-center justify-between gap-3 rounded-md bg-slate-50 px-3 py-2 text-sm text-slate-700 transition hover:bg-[#e7f3fb] hover:text-[#0b3d91] dark:bg-white/5 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white">
                                            <span class="leading-6">{{ item.label }}</span>
                                            <ArrowUpRight class="size-4 shrink-0 text-slate-400 transition group-hover:text-[#1711d4] dark:text-slate-500 dark:group-hover:text-sky-200" aria-hidden="true" />
                                        </a>
                                        <span v-else class="rounded-md bg-white px-3 py-2 text-sm text-slate-700 ring-1 ring-slate-200 dark:bg-slate-900 dark:text-slate-200 dark:ring-white/10">{{ item.label }}</span>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </div>
    </PublicSiteLayout>
</template>
