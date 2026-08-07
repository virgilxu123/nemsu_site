<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

uses(TestCase::class);

test('ovprie parent office pages include their suboffices', function (
    string $slug,
    string $title,
    string $acronym,
    int $subofficeCount,
    string $firstSuboffice,
) {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('research.rie.offices.show', $slug))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('research/OvprieOffice')
            ->where('office.title', $title)
            ->where('office.acronym', $acronym)
            ->where('office.parent', 'Office of the Vice President for Research, Innovation, and Extension')
            ->where('office.suboffices.0.title', $firstSuboffice)
            ->has('office.suboffices', $subofficeCount)
            ->has('offices', 3)
        );
})->with([
    'RIDO' => [
        'university-research-and-innovation-office',
        'University Research and Innovation Office',
        'RIDO',
        4,
        'Research Centers',
    ],
    'KTTO' => [
        'knowledge-and-technology-transfer-office',
        'Knowledge and Technology Transfer Office',
        'KTTO',
        3,
        'Innovation and Technology Support Office',
    ],
    'ESLO' => [
        'extension-services-and-linkages-office',
        'Extension Services and Linkages Office',
        'ESLO',
        2,
        'Extension Planning and Implementation Office',
    ],
]);

test('unknown ovprie office page is hidden', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->get(route('research.rie.offices.show', 'unknown-office'))
        ->assertNotFound();
});

test('former suboffice routes are hidden', function (string $slug) {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->get(route('research.rie.offices.show', $slug))->assertNotFound();
})->with([
    'research-centers',
    'research-operation-office',
    'creative-works-management-office',
    'publication-and-printing-office',
    'innovation-and-technology-support-office',
    'intellectual-property-and-technology-business-management-office',
    'technology-business-incubation-office',
    'extension-planning-and-implementation-office',
    'monitoring-and-impact-assessment-office',
]);

test('rie page links ovprie offices to office detail routes', function () {
    $page = file_get_contents(resource_path('js/pages/research/Rie.vue'));

    expect($page)
        ->toContain('OvprieOfficeController')
        ->toContain('const officeLinks = officeGroups;')
        ->toContain('aria-label="Offices under OVPRIE"')
        ->toContain('class="mt-10 grid gap-x-12 gap-y-7 text-left sm:grid-cols-2 lg:grid-cols-3"')
        ->toContain('items-center justify-start gap-2 text-left')
        ->toContain('officeShow.url(office.slug)')
        ->toContain('University Research and Innovation Office')
        ->toContain('Knowledge and Technology Transfer Office')
        ->toContain('Extension Services and Linkages Office')
        ->not->toContain('View office')
        ->not->toContain('Office overview');
});

test('ovprie office page uses the reusable office layout', function () {
    $page = file_get_contents(resource_path('js/pages/research/OvprieOffice.vue'));

    expect($page)
        ->toContain('data-scroll-section="office-hero"')
        ->toContain('data-scroll-section="office-navigation"')
        ->toContain('data-scroll-section="office-overview"')
        ->toContain('data-scroll-section="office-profile"')
        ->toContain('md:grid-cols-[10rem_minmax(0,1fr)_18rem]')
        ->toContain('xl:grid-cols-[12rem_minmax(0,1fr)_24rem]')
        ->toContain('OVPRIE Offices')
        ->toContain('font-semibold text-[#9b1c31] dark:text-rose-200')
        ->toContain('headImage')
        ->toContain('officeShow.url')
        ->toContain('Offices and units under')
        ->toContain('props.office.suboffices')
        ->toContain('Back to OVPRIE offices');
});
