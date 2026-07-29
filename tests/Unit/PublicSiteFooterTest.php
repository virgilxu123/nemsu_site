<?php

test('public site footer matches the high fidelity composition', function () {
    $footer = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/PublicSiteFooter.vue',
    );
    $footerData = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/public-site-footer.ts',
    );
    $footerSource = $footer.$footerData;

    expect($footerSource)
        ->toContain('id="footer-university"')
        ->toContain('North Eastern Mindanao State University')
        ->toContain('Rosario, Tandag City, 8300 Surigao del Sur, Philippines')
        ->toContain('id="footer-contact-information"')
        ->toContain('Contact Information')
        ->toContain('publicSiteFooterOfficeContactColumns')
        ->toContain('mx-auto grid w-full max-w-7xl')
        ->toContain('mx-auto flex w-full max-w-7xl')
        ->toContain('class="size-18 shrink-0 object-contain"')
        ->toContain('font-academic text-xl')
        ->toContain('max-w-sm text-sm leading-6')
        ->toContain('group flex items-center gap-2.5 rounded-sm text-sm')
        ->toContain('text-xs leading-4 text-white/90')
        ->toContain('Office of the President')
        ->toContain('Information Unit')
        ->toContain("Registrar's Office")
        ->toContain('Admission Office')
        ->toContain('Guidance Office')
        ->not->toContain('text-[0.68rem]')
        ->not->toContain('text-[0.65rem]')
        ->not->toContain('text-[0.6rem]');
});

test('public site footer keeps compliance assets and social presentation', function () {
    $footer = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/PublicSiteFooter.vue',
    );
    $footerData = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/public-site-footer.ts',
    );
    $footerSource = $footer.$footerData;

    expect($footerSource)
        ->toContain('/storage/images/compliance/iso/iso.png')
        ->toContain('/storage/images/compliance/transparency-seal/the_transparency_seal2_0-150x150.png')
        ->toContain('/storage/images/compliance/freedom-of-information/FOI-Logo_0-150x150.png')
        ->toContain('data-footer-wave')
        ->toContain('fill="#1711d4"')
        ->toContain("label: 'NEMSU on Facebook'")
        ->toContain("label: 'NEMSU on YouTube'")
        ->toContain("label: 'NEMSU on TikTok'")
        ->toContain('aria-label="Official social media"');
});
