<?php

use App\Http\Controllers\CollegeController;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class);

test('campus programs reuse matching Academic Affairs prospectus links', function (
    string $campus,
    string $campusName,
    string $campusOffering,
    string $academicOffering,
) {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $academicProspectus = CollegeController::prospectusUrlsForCampus($campusName)[
        $academicOffering
    ];
    $campusProspectuses = $this->get(route('campuses.show', $campus))
        ->assertOk()
        ->inertiaProps('campus.prospectuses');

    expect($campusProspectuses[$campusOffering])->toBe($academicProspectus);
})->with([
    'Bislig accreditation suffix' => [
        'bislig',
        'Bislig Campus',
        'Bachelor of Secondary Education Major in English – Level III Accredited',
        'Bachelor of Secondary Education major in English',
    ],
    'Cagwait exact title' => [
        'cagwait',
        'Cagwait Campus',
        'Bachelor of Science in Hospitality Management',
        'Bachelor of Science in Hospitality Management',
    ],
    'Cantilan abbreviated title' => [
        'cantilan',
        'Cantilan Campus',
        'Bachelor of Science in Business Administration (BSBA) major in Financial Management',
        'Bachelor of Science in Business Administration major in Financial Management',
    ],
    'Cantilan reordered specialization title' => [
        'cantilan',
        'Cantilan Campus',
        'Bachelor of Industrial Technology (BIndTech) major in Apparel and Fashion Technology',
        'Bachelor of Industrial Technology (BIndTech) major in Fashion and Apparel Technology',
    ],
    'Lianga configured title' => [
        'lianga',
        'Lianga Campus',
        'Bachelor of Science in Computer Science',
        'Bachelor of Science in Computer Science',
    ],
    'San Miguel abbreviated title' => [
        'san-miguel',
        'San Miguel Campus',
        'Bachelor of Technology and Livelihood Education (BTLEd) – Major in Home Economics',
        'Bachelor of Technology and Livelihood Education major in Home Economics',
    ],
    'Tagbina exact title' => [
        'tagbina',
        'Tagbina Campus',
        'Bachelor of Secondary Education major in Science',
        'Bachelor of Secondary Education major in Science',
    ],
]);

test('Academic Affairs prospectuses override campus-specific links', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $academicProspectus = CollegeController::prospectusUrlsForCampus('Tandag Campus')[
        'Bachelor of Science in Civil Engineering'
    ];
    $campusProspectus = $this->get(route('campuses.show', 'tandag'))
        ->assertOk()
        ->inertiaProps('campus.prospectuses.Bachelor of Science in Civil Engineering');

    expect($campusProspectus)
        ->toBe($academicProspectus)
        ->not->toBe(Storage::disk('public')->url('programs/BSCE.pdf'));
});

test('ambiguous or unavailable program prospectuses remain unlinked', function (
    string $campus,
    string $offering,
) {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $campusProspectuses = $this->get(route('campuses.show', $campus))
        ->assertOk()
        ->inertiaProps('campus.prospectuses');

    expect($campusProspectuses)->not->toHaveKey($offering);
})->with([
    'San Miguel Crop Science is not Agronomy' => [
        'san-miguel',
        'Bachelor of Science in Agriculture (BSA) – Major in Crop Science',
    ],
    'Tagbina Hotel and Restaurant Management is not generic Hospitality Management' => [
        'tagbina',
        'Bachelor of Science in Hospitality Management major in Hotel and Restaurant Management',
    ],
    'Tagbina Agricultural Technology has no Academic Affairs prospectus' => [
        'tagbina',
        'Bachelor of Agricultural Technology',
    ],
]);
