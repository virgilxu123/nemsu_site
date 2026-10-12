<?php

use App\Http\Middleware\HandleInertiaRequests;
use Inertia\Testing\AssertableInertia as Assert;
use Symfony\Component\Process\Process;
use Tests\TestCase;

uses(TestCase::class);

test('transparency seal page can be viewed', function () {
    /** @var Illuminate\Foundation\Testing\TestCase $this */
    $this->withoutMiddleware(HandleInertiaRequests::class);

    $this->get(route('administration.transparency-seal'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('administration/TransparencySeal')
        );
});

test('transparency seal preserves the supplied BAR reports by year and quarter', function () {
    $page = file_get_contents(resource_path('js/pages/administration/TransparencySeal.vue'));

    expect(preg_match('/const budgetAccountabilityYears: ReportYear\[\] = \[(.*?)\n\];/s', $page, $archive))->toBe(1);

    preg_match_all("/year: '([0-9]{4})',\s*quarters: \[(.*?)\n        \],/s", $archive[1], $years, PREG_SET_ORDER);

    $reports = [];

    foreach ($years as $year) {
        preg_match_all("/quarter\('([^']+)'(?:,\s*\[\s*doc\('BAR NO\.1', '([^']+)'\),\s*\])?\)/", $year[2], $quarters, PREG_SET_ORDER);

        expect(array_column($quarters, 1))->toBe([
            'First Quarter',
            'Second Quarter',
            'Third Quarter',
            'Fourth Quarter',
        ]);

        $reports[$year[1]] = array_map(fn (array $quarter): ?string => $quarter[2] ?? null, $quarters);
    }

    expect($reports)->toBe([
        2026 => [
            'https://drive.google.com/file/d/1OZ4TMkeETanc9dsqQHqcPh3yfb-VS4lF/view?usp=sharing',
            'https://drive.google.com/file/d/1HmwN4qMOzYMLirIy6whrENwG5uIGSqCv/view?usp=sharing',
            null,
            null,
        ],
        2025 => [
            'https://drive.google.com/file/d/1hRUm2AMYuGcORa4uEk8ZS_cSkVBaDC-0/view?usp=sharing',
            'https://drive.google.com/file/d/1ZSyfOOnxDS4SF93pFDuKwAwWspmMqFFY/view?usp=sharing',
            'https://drive.google.com/file/d/1un8BBRCzz4jCVJt3scxwGJvseIlNkH4N/view?usp=sharing',
            'https://drive.google.com/file/d/1HvNvxtptM1adyQpGBKkWAV4vFeHrm0xo/view?usp=sharing',
        ],
        2024 => [
            'https://drive.google.com/file/d/13MVdp2vHxAkX9xQX1WuyC7Ocmbfo8t4h/view?usp=sharing',
            'https://drive.google.com/file/d/17Zz-UtSNSi22iMVFen-SrrSljRRfTrJr/view?usp=sharing',
            'https://drive.google.com/file/d/1GFqH5O8ge9LRepVT1VpIAKJWri412zFC/view?usp=sharing',
            'https://drive.google.com/file/d/1FXNZXPekfWN3shxMHQZA_qOondqlBG9p/view?usp=sharing',
        ],
        2023 => [
            'https://drive.google.com/file/d/1J2p2ovNIy_BNNHRjQ_K9nJebhvgS3UMN/view?usp=sharing',
            'https://drive.google.com/file/d/1bsr4eUyIMRcxyYrTx-dsAGx9y8dr41Gi/view?usp=sharing',
            'https://drive.google.com/file/d/1_HB0BqMg5kYIvwQRc_gagXe1tUcANIBH/view?usp=sharing',
            'https://drive.google.com/file/d/14tDqcd6z8-eC-KT5z9JeO596oLq4Oxlc/view?usp=sharing',
        ],
        2022 => [
            'https://drive.google.com/file/d/1XSecA6Nqs5Di3QLMDxxB6JPr3IfQ_hCJ/view?usp=sharing',
            'https://drive.google.com/file/d/1DjG4RgLUHQ1WSI1zABIDsS5VSPnlAa2k/view?usp=sharing',
            'https://drive.google.com/file/d/1U6tnxg5jBmRovPs5S9tCx5a5yFbuXTc0/view?usp=share_link',
            'https://drive.google.com/file/d/1r3XDXu7WCvOvSlvydudMCSQuOk8Hi8FG/view?usp=sharing',
        ],
        2021 => [
            'https://drive.google.com/file/d/1a3AZCk6wGDXlLJVl88vE3G4gJx1d-W5r/view?usp=sharing',
            'https://drive.google.com/file/d/1iMI02QSDxRzm0mWdddgXLVAKut3UT0zK/view?usp=sharing',
            'https://drive.google.com/file/d/1CxPL-TupSyq3w_gVIG8sUznvO8KXnZ-E/view?usp=sharing',
            'https://drive.google.com/file/d/1n0HuaIXKXi7G2OWtVlpCEh4Y9FD8-blW/view?usp=sharing',
        ],
        2020 => [
            'https://nemsu.edu.ph/public_files/files/Bar%20no.%201.pdf',
            'https://nemsu.edu.ph/public_files/files/BAR%20NO.%201%20transparency%202nd%20quarter.pdf',
            'https://drive.google.com/file/d/118nzuTbPehG6euUrs0gTu4GBPsgkOJVn/view?usp=sharing',
            null,
        ],
    ]);
});

test('transparency seal displays a BAR table after the FAR archive', function () {
    $page = file_get_contents(resource_path('js/pages/administration/TransparencySeal.vue'));
    $template = substr($page, strpos($page, '<template>'));

    expect($template)
        ->toContain('A.1 Financial Accountability Reports (FAR)')
        ->toContain('A.2 Budget Accountability Reports (BAR)')
        ->toContain('id="budget-accountability-reports"')
        ->toContain('v-for="year in budgetAccountabilityYears"')
        ->toContain('overflow-x-auto')
        ->toContain('scope="col"')
        ->toContain('scope="row"')
        ->toContain('No file posted yet.');

    expect(strpos($template, 'v-for="year in transparencyYears"'))
        ->toBeLessThan(strpos($template, 'id="budget-accountability-reports"'));
});

test('transparency seal follows the numbered disclosure hierarchy', function () {
    $page = file_get_contents(resource_path('js/pages/administration/TransparencySeal.vue'));
    $template = substr($page, strpos($page, '<template>'));

    preg_match_all('/<h([2-6])\b[^>]*>\s*((?:[IVX]+\.|[AB]\.(?:\d+)?)\s+[^<{]*)/s', $template, $headings, PREG_SET_ORDER);

    expect(array_map(fn (array $heading): array => [(int) $heading[1], trim($heading[2])], $headings))->toBe([
        [2, 'I. Institutional Mandate and Officials'],
        [2, 'II. Annual Financial Reports'],
        [3, 'A. Budget Accountability Reports'],
        [4, 'A.1 Financial Accountability Reports (FAR)'],
        [4, 'A.2 Budget Accountability Reports (BAR)'],
        [3, 'B. MARC and Scorecards'],
    ]);

    expect($template)
        ->toContain(':href="university()"')
        ->toContain(':href="directory()"')
        ->toContain('Transparency Disclosures')
        ->toContain('View University Profile')
        ->toContain('View Official Directory')
        ->toContain('University Officials and Contact Directory')
        ->toContain(':id="`transparency-section-${section.code}`"')
        ->toContain('<h2 :id="`transparency-heading-${section.code}`"')
        ->toContain('<details')
        ->toContain(':open="year.year === transparencyYears[0].year"')
        ->not->toContain('Sections III to X are now laid out here.')
        ->not->toContain('quarter blocks');
});

test('transparency seal groups documents by year without dropping records', function () {
    $script = <<<'JS'
import { readFileSync } from 'node:fs';
import { createRequire } from 'node:module';
import { runInNewContext } from 'node:vm';
import { compileTemplate, parse } from '@vue/compiler-sfc';
import ts from 'typescript';

const source = readFileSync(process.argv[1], 'utf8');
const { descriptor, errors } = parse(source);
const compiled = ts.transpileModule(descriptor.scriptSetup.content, {
    compilerOptions: { module: ts.ModuleKind.CommonJS },
}).outputText;
const template = compileTemplate({ source: descriptor.template.content, filename: process.argv[1], id: 'transparency-seal' });
const require = createRequire(import.meta.url);
const context = {
    exports: {},
    require: (specifier) => specifier === 'vue'
        ? { ref: (value) => ({ value }), onMounted: () => {}, onBeforeUnmount: () => {} }
        : require(specifier),
};

runInNewContext(compiled + `
globalThis.results = {
    navigation: sectionNavigation,
    groups: groupDocumentsByYear([
        { label: 'FY2024 Budget', href: '/budget-2024.pdf' },
        { label: 'FOI Manual', href: '/foi-manual.pdf' },
        { label: 'FY-2026 Plan', href: '/plan-2026.pdf' },
        { label: 'FY 2024 Targets', href: '/targets-2024.pdf' },
        { label: 'FY 2019 Report' },
    ]),
    preserved: groupedTransparencySections.every((section) => {
        const sorted = (items) => JSON.stringify([...items].sort((left, right) => left.label.localeCompare(right.label)));
        return sorted(section.groups.flatMap((group) => group.items)) === sorted(section.items);
    }),
    procurementYears: groupedTransparencySections.find((section) => section.code === 'V').groups.map((group) => group.year),
    foiYears: groupedTransparencySections.find((section) => section.code === 'X').groups.map((group) => group.year),
    marcReports,
};`, context);

process.stdout.write(JSON.stringify({ ...context.results, errors: [...errors, ...template.errors] }));
JS;

    $process = new Process(['node', '--input-type=module', '-e', $script, resource_path('js/pages/administration/TransparencySeal.vue')], base_path());
    $process->mustRun();
    $results = json_decode($process->getOutput(), true, flags: JSON_THROW_ON_ERROR);

    expect($results['errors'])->toBe([]);
    expect($results['preserved'])->toBeTrue();
    expect(array_column($results['navigation'], 'code'))->toBe(['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X']);
    expect(array_column($results['navigation'], 'title'))->toBe([
        'Institutional Mandate and Officials',
        'Annual Financial Reports',
        'GAA Budget and Performance Targets',
        'Programs, Projects, and Activities',
        'Annual Procurement Plans',
        'Procurement Monitoring Reports',
        'Quality Management Certification',
        'Delivery Unit Performance Evaluation',
        'SALN Review and Compliance',
        'Freedom of Information',
    ]);
    expect(array_column($results['navigation'], 'href'))->toBe([
        '#agency-information', '#annual-reports', '#transparency-section-III', '#transparency-section-IV',
        '#transparency-section-V', '#transparency-section-VI', '#transparency-section-VII',
        '#transparency-section-VIII', '#transparency-section-IX', '#transparency-section-X',
    ]);
    expect($results['groups'])->toBe([
        ['year' => null, 'items' => [['label' => 'FOI Manual', 'href' => '/foi-manual.pdf']]],
        ['year' => 2026, 'items' => [['label' => 'FY-2026 Plan', 'href' => '/plan-2026.pdf']]],
        ['year' => 2024, 'items' => [
            ['label' => 'FY2024 Budget', 'href' => '/budget-2024.pdf'],
            ['label' => 'FY 2024 Targets', 'href' => '/targets-2024.pdf'],
        ]],
        ['year' => 2019, 'items' => [['label' => 'FY 2019 Report']]],
    ]);
    expect($results['procurementYears'])->toBe([2026, 2025, 2024, 2023, 2022, 2021, 2020, 2019]);
    expect($results['foiYears'])->toBe([null, 2025, 2024, 2023, 2022, 2021]);
    expect(array_column($results['marcReports'], 'label'))->toBe(['2023 Scorecard', '2022 Scorecard', '2021 Scorecard', '2020 MARC I', '2019 MARC I']);
    expect(array_column($results['marcReports'], 'href'))->toBe([
        'https://drive.google.com/file/d/10WrHcpyg-LUlUIFT_fOIddiujYtmARDg/view?usp=sharing',
        'https://drive.google.com/file/d/1OeUB0nzckF7eAIUTH-4HCufgE5nzHkF9/view?usp=sharing',
        'https://drive.google.com/file/d/1e3W59W8gWjzcmXCfIJNeQq0Hr69UAe2x/view?usp=sharing',
        'https://drive.google.com/file/d/1WN2l2iS7oPwFqjuQTI9wvuFt8B_jYtpt/view?usp=sharing',
        'https://drive.google.com/file/d/1hHBT7x9-QY7RSnJ5jv7rJR865g2Y6MCC/view?usp=sharing',
    ]);
});
