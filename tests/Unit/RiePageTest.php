<?php

use Tests\TestCase;

uses(TestCase::class);

test('rie page contains the supplied ovprie directory and assets', function () {
    $page = file_get_contents(resource_path('js/pages/research/Rie.vue'));
    $app = file_get_contents(resource_path('js/app.ts'));

    expect(substr_count($page, "image: '/images/administration/ovprie/"))->toBe(7);

    expect($app)->toContain("case name.startsWith('research/'):");
    expect($page)
        ->not->toContain('absolute inset-0 -z-20 h-full w-full object-cover')
        ->not->toContain('absolute inset-x-0 bottom-0 -z-10 h-24')
        ->toContain('Office of the Vice President for Research,')
        ->toContain('const visibleSections = ref<Set<string>>')
        ->toContain('const revealClasses = (')
        ->toContain('data-scroll-section="rie-hero"')
        ->toContain('data-scroll-section="ovprie-profile-panel"')
        ->toContain('officeShow.url(office.slug)');

    expect($page)
        ->toContain('Rolly G. Salvaleon, PhD')
        ->toContain('Erwin B. Berry, EdD')
        ->toContain('Engr. Luzminda S. Bacquial')
        ->toContain('Ma. Cristina S. Dela Cerna, PhD')
        ->toContain('vpre@nemsu.edu.ph')
        ->toContain('research@nemsu.edu.ph')
        ->toContain('itso@nemsu.edu.ph')
        ->toContain('extension@nemsu.edu.ph')
        ->toContain('Research Centers')
        ->toContain('Technology Business Incubation Office')
        ->toContain('Monitoring and Impact Assessment Office')
        ->toContain('Service overview')
        ->not->toContain('View office')
        ->not->toContain('Office overview')
        ->toContain('id="rie-news"');

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
