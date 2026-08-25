<?php

use Tests\TestCase;

uses(TestCase::class);

test('rie page contains the supplied ovprie directory and assets', function () {
    $page = file_get_contents(resource_path('js/pages/research/Rie.vue'));
    $app = file_get_contents(resource_path('js/app.ts'));
    $navigation = file_get_contents(
        resource_path('js/components/public-site/public-site-navigation.ts'),
    );

    expect(substr_count($page, "image: '/images/administration/ovprie/"))->toBe(5);
    expect(substr_count($page, "established: '"))->toBe(12);

    expect($app)->toContain("case name.startsWith('research/'):");
    expect($page)
        ->not->toContain('absolute inset-0 -z-20 h-full w-full object-cover')
        ->not->toContain('absolute inset-x-0 bottom-0 -z-10 h-24')
        ->toContain('Office of the Vice President for Research,')
        ->toContain('const visibleSections = ref<Set<string>>')
        ->toContain('const revealClasses = (')
        ->toContain('data-scroll-section="rie-hero"')
        ->toContain('data-scroll-section="ovprie-profile-panel"')
        ->toContain('officeShow.url(group.slug)');

    expect($page)
        ->toContain('Rolly G. Salvaleon, PhD')
        ->toContain('Arturo G. Gracia, Jr., MSci')
        ->toContain('Engr. Luzminda S. Bacquial, PhD')
        ->toContain('Abundio C. Miralles, EdD')
        ->toContain('Hussein M. Alawi')
        ->toContain('vpre@nemsu.edu.ph')
        ->toContain('research@nemsu.edu.ph')
        ->toContain('hmalawi@nemsu.edu.ph')
        ->toContain('itso@nemsu.edu.ph')
        ->toContain('extension@nemsu.edu.ph')
        ->toContain("slug: 'university-research-and-innovation-office'")
        ->toContain("slug: 'knowledge-and-technology-transfer-office'")
        ->toContain("slug: 'extension-services-and-linkages-office'")
        ->toContain("acronym: 'RIDO'")
        ->toContain("acronym: 'KTTO'")
        ->toContain("acronym: 'ESLO'")
        ->toContain('Research Operation Office')
        ->toContain('Creative Works Management Office')
        ->toContain('Publication and Printing Office')
        ->toContain('Innovation and Technology Support Office')
        ->toContain('Technology Business Incubation Office')
        ->toContain('Extension Planning and Implementation Office')
        ->toContain('Monitoring and Impact Assessment Office')
        ->not->toContain("slug: 'research-centers'")
        ->not->toContain("slug: 'technology-business-incubation-office'")
        ->not->toContain("slug: 'monitoring-and-impact-assessment-office'")
        ->toContain('Service overview')
        ->not->toContain('View office')
        ->not->toContain('Office overview')
        ->toContain('id="rie-news"');

    expect($page)
        ->toContain('Research Center for Continuing Education and Professional Development')
        ->toContain('Center for Local Leadership and Governance')
        ->toContain('Center for Aquasilviculture and Seaweed Advancement')
        ->toContain('Agro-Forestry Industrial Research Center')
        ->toContain('1N_PgfkGK7-k68JBKqrNCW4BuOzhmHsXv')
        ->toContain('1fJRlzFi2CkeiezyFPHAASUPs8c3R4Phz')
        ->toContain('1ZZlCGjtZiM44-SO8C9u91X2KxuPqDvaI')
        ->toContain('Research That Reaches the Field')
        ->toContain('NEMSU surpasses its 2026 Scopus publication target');

    expect($navigation)
        ->toContain("label: 'Research, Innovation, and Extension (RIE)'")
        ->toContain("label: 'Research Centers'")
        ->toContain('href: `${rie().url}#research-centers`')
        ->toContain("label: 'Published Articles'")
        ->toContain('href: publicationIndex().url')
        ->toContain("label: 'Patents'")
        ->toContain('href: `${rie().url}#patents`')
        ->not->toContain('href: `${rie().url}#intellectual-property`');

    expect($page)
        ->toContain('id="research-centers"')
        ->toContain('id="publication"')
        ->toContain("id: 'scopus-publication-records'")
        ->toContain("id: 'patents'")
        ->toContain(':id="resource.id"')
        ->toContain(':id="document.id"');

    expect($page)
        ->toContain('/files/administration/ovprie/research/scopus-indexed-publications.xlsx')
        ->toContain('/files/administration/ovprie/research/completed-research-projects.xlsx');

    expect($page)
        ->toContain('Innovation Portfolio')
        ->toContain('Featured technologies')
        ->toContain('creative works')
        ->toContain('IP Registry')
        ->toContain('/files/administration/ovprie/innovation/patents.xlsx')
        ->toContain('/files/administration/ovprie/innovation/utility-models.xlsx')
        ->toContain('/files/administration/ovprie/innovation/copyrights.xlsx')
        ->toContain('/files/administration/ovprie/innovation/industrial-designs.xlsx')
        ->toContain('/files/administration/ovprie/innovation/trademarks.xlsx')
        ->toContain('/images/administration/ovprie/innovation/aerial-seed-planting-device.png')
        ->toContain('Aerial Seed Planting Device')
        ->toContain('Dried Fish Danggit Ice Cream')
        ->toContain('Download registry');

    expect(file_exists(public_path('files/administration/ovprie/innovation/patents.xlsx')))->toBeTrue();
    expect(file_exists(public_path('files/administration/ovprie/innovation/lato-biofertilizer.pdf')))->toBeTrue();
    expect(file_exists(public_path('images/administration/ovprie/innovation/danggit-flyer.png')))->toBeTrue();
});
