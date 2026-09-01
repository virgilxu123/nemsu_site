<?php

use App\Http\Controllers\CollegeController;
use App\Http\Controllers\GraduateProfessionalStudyController;
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

test('campus programs reuse matching graduate school prospectus links', function (
    string $campus,
    string $campusName,
    array $programMatches,
) {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $academicProspectuses = GraduateProfessionalStudyController::prospectusUrlsForCampus(
        $campusName,
    );
    $campusProspectuses = $this->get(route('campuses.show', $campus))
        ->assertOk()
        ->inertiaProps('campus.prospectuses');

    foreach ($programMatches as $campusOffering => $academicOffering) {
        expect($campusProspectuses[$campusOffering])->toBe(
            $academicProspectuses[$academicOffering],
        );
    }
})->with([
    'Tandag graduate programs' => [
        'tandag',
        'Tandag Campus',
        [
            'Doctor of Education major in Educational Management' => 'Doctor of Education in Educational Management',
            'Doctor of Education major in English Language Teaching' => 'Doctor of Education in English Language Teaching',
            'Doctor of Philosophy in Science Education' => 'Doctor of Philosophy in Science Education',
            'Doctor of Philosophy in Mathematics Education' => 'Doctor of Philosophy in Mathematics Education',
            'Master of Arts in Education major in Educational Management' => 'Master of Arts in Education major in Educational Management',
            'Master of Arts in English Language Teaching' => 'Master of Arts in English Language Teaching',
            'Master of Arts in Filipino Language Teaching' => 'Master of Arts in Filipino Language Teaching',
            'Master of Arts in Home Economics Teaching' => 'Master of Arts in Home Economics Teaching',
            'Master of Arts in Social Sciences Teaching' => 'Master of Arts in Social Sciences Teaching',
            'Master of Science in Teaching Mathematics' => 'Master of Science in Teaching Mathematics',
            'Master of Science in Teaching Science' => 'Master of Science in Teaching Science',
            'Master of Science in Computer Science' => 'Master of Science in Computer Science',
            'Master in Business Administration' => 'Master in Business Administration',
            'Master in Public Administration' => 'Master in Public Administration',
        ],
    ],
    'Cantilan graduate programs' => [
        'cantilan',
        'Cantilan Campus',
        [
            'Master in Teaching Technology Education (MTTE) major in Architectural Drafting Technology' => 'Master in Teaching Technology Education (MTTE) major in Drafting Technology',
            'Master in Teaching Technology Education (MTTE) major in Automotive Technology' => 'Master in Teaching Technology Education (MTTE) major in Automotive Technology',
            'Master in Teaching Technology Education (MTTE) major in Electrical Technology' => 'Master in Teaching Technology Education (MTTE) major in Electrical Technology',
            'Master in Teaching Technology Education (MTTE) major in Food Technology' => 'Master in Teaching Technology Education (MTTE) major in Food Technology',
            'Master in Teaching Technology Education (MTTE) major in Garments Technology' => 'Master in Teaching Technology Education (MTTE) major in Garments Technology',
        ],
    ],
    'Tandag College of Law programs' => [
        'tandag',
        'Tandag Campus',
        [
            'Juris Doctor (4 Years)' => 'Juris Doctor (4 Years)',
            'Juris Doctor (5 Years)' => 'Juris Doctor (5 Years)',
            'Ladderized Master of Legal Studies - Juris Doctor Degree' => 'Ladderized Master of Legal Studies - Juris Doctor Degree',
        ],
    ],
]);

test('Tandag campus lists all three College of Law programs', function () {
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $programGroups = $this->get(route('campuses.show', 'tandag'))
        ->assertOk()
        ->inertiaProps('campus.programs');
    $lawPrograms = collect($programGroups)->firstWhere('college', 'College of Law');

    expect($lawPrograms['offerings'])->toBe([
        'Juris Doctor (4 Years)',
        'Juris Doctor (5 Years)',
        'Ladderized Master of Legal Studies - Juris Doctor Degree',
    ]);
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
