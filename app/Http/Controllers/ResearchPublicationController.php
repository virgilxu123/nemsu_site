<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\Finder\SplFileInfo;

class ResearchPublicationController extends Controller
{
    private const string POSTER_BASE_PATH = 'images/administration/ovprie/research/scopus';

    /**
     * @var array<int, array{slug: string, title: string, description: string}>
     */
    private const array COLLECTIONS = [
        [
            'slug' => '2026',
            'title' => '2026 Scopus Publications',
            'description' => 'The latest publication posters submitted for the 2026 Scopus collection.',
        ],
        [
            'slug' => 'new-template',
            'title' => 'Featured Scopus Publications',
            'description' => 'Featured journal and conference publications in the current landscape format.',
        ],
        [
            'slug' => 'research-posters',
            'title' => 'Research Publication Posters',
            'description' => 'The University collection of Scopus-indexed publication recognition posters.',
        ],
    ];

    /**
     * Study URLs decoded from the poster QR codes.
     *
     * @var array<string, array<string, string>>
     */
    private const array POSTER_URLS = [
        '2026' => [
            '1' => 'https://doi.org/10.32479/irmm.23351',
            '2' => 'https://doi.org/10.32479/irmm.23351',
            '3' => 'https://doi.org/10.32479/irmm.23351',
            '4' => 'https://neptjournal.com/upload-images/(8)D-1828.pdf',
            '5' => 'https://neptjournal.com/upload-images/(8)D-1828.pdf',
            '6' => 'https://neptjournal.com/upload-images/(8)D-1828.pdf',
            '7' => 'https://neptjournal.com/upload-images/(8)D-1828.pdf',
            '8' => 'https://doi.org/10.47857/irjms.2026.v07i02.010069',
            '9' => 'https://doi.org/10.47857/irjms.2026.v07i02.010069',
            '10' => 'https://doi.org/10.47857/irjms.2026.v07i02.09209',
            '11' => 'https://doi.org/10.47857/irjms.2026.v07i02.09209',
            '12' => 'https://econjournals.com/index.php/irmm/article/view/23377',
            '13' => 'https://econjournals.com/index.php/irmm/article/view/23377',
            '14' => 'https://doi.org/10.17979/sportis.2026.12.2.12425',
            '15' => 'https://doi.org/10.1016/j.rsma.2026.105019',
            '16' => 'https://doi.org/10.1088/2053-1591/ae546f',
            '17' => 'https://ijlter.org/index.php/ijlter/article/view/15893',
            '18' => 'https://ijlter.org/index.php/ijlter/article/view/15893',
            '19' => 'https://ijlter.org/index.php/ijlter/article/view/15893',
            '20' => 'https://ijlter.org/index.php/ijlter/article/view/15893',
            '21' => 'https://doi.org/10.32479/irmm.23589',
            '22' => 'https://doi.org/10.32479/irmm.23379',
            '23' => 'https://malque.pub/ojs/index.php/msj/article/view/15145',
            '24' => 'https://ieeexplore.ieee.org/document/11467965',
            '25' => 'https://www.researchgate.net/publication/403900109_Decision_Support_QR-Code_Based_Visitor_Log_System_with_Data_Analytics',
            '26' => 'https://www.researchgate.net/publication/403900109_Decision_Support_QR-Code_Based_Visitor_Log_System_with_Data_Analytics',
            '27' => 'https://www.researchgate.net/publication/403900109_Decision_Support_QR-Code_Based_Visitor_Log_System_with_Data_Analytics',
        ],
        'new-template' => [
            '3' => 'https://ieeexplore.ieee.org/document/11483666',
            '4' => 'https://ieeexplore.ieee.org/document/11483815',
            '5' => 'https://ieeexplore.ieee.org/document/11484005',
            '6' => 'https://ieeexplore.ieee.org/document/11483819',
            '7' => 'https://ieeexplore.ieee.org/document/11483664',
            '8' => 'https://api.fspublishers.org/viewPaper/Paper-7944156293-2025-07-01.pdf',
            '9' => 'https://ieeexplore.ieee.org/document/11411143',
            '10' => 'https://ieeexplore.ieee.org/document/11483654',
            '11' => 'https://link.springer.com/chapter/10.1007/978-981-95-6075-2_1',
            '12' => 'https://www.frontiersin.org/journals/sustainable-tourism/articles/10.3389/frsut.2026.1752569/full',
            '13' => 'https://ieeexplore.ieee.org/document/11483952',
            '14' => 'https://www.tandfonline.com/doi/full/10.1080/17451000.2025.2512450#',
            '15' => 'https://www.ijiet.org/show-240-3257-1.html',
        ],
        'research-posters' => [
            '1' => 'https://qrfy.io/0XzTHzDOjB',
            '2' => 'https://qrfy.io/_AFjwMB9qB',
            '3' => 'https://qrfy.io/m7rpffEdfi',
            '4' => 'https://qrfy.io/oMtg-v2l4O',
            '5' => 'https://qrfy.io/JGPCFsfP4y',
            '6' => 'https://qrfy.io/JGPCFsfP4y',
            '7' => 'https://qrfy.io/1_HWWPjcN7',
            '8' => 'https://qrfy.io/6O19iQIPMz',
            '9' => 'https://qrfy.io/2c4Omu1VvW',
            '10' => 'https://qrfy.io/ASozCeQTey',
            '11' => 'https://qrfy.io/ASozCeQTey',
            '12' => 'https://qrfy.io/CCk2pWjEAe',
            '13' => 'https://qrfy.io/woB1Ozr8-m',
            '14' => 'https://qrfy.io/rcbHjQT_ST',
            '15' => 'https://qrfy.io/tYLhb2oqLW',
            '16' => 'https://qrfy.io/SdeEkPdVC-',
            '17' => 'https://qrfy.io/JU34l9n_Ox',
            '18' => 'https://qrfy.io/Ch7NOWklnV',
            '19' => 'https://qrfy.io/5l9bahcooq',
            '20' => 'https://qrfy.io/5l9bahcooq',
            '21' => 'https://qrfy.io/5l9bahcooq',
            '22' => 'https://qrfy.io/5l9bahcooq',
            '23' => 'https://qrfy.io/Ds9Whg2qAu',
            '24' => 'https://scan.page/yQ0UlZ',
            '25' => 'https://scan.page/yi0DKv',
            '26' => 'https://scan.page/nu9FO5',
            '27' => 'https://scan.page/ZYIea4',
            '28' => 'https://scan.page/vY12hT',
            '29' => 'https://scan.page/vY12hT',
            '30' => 'https://scan.page/vY12hT',
            '31' => 'https://scan.page/vY12hT',
            '32' => 'https://scan.page/vY12hT',
            '33' => 'https://scan.page/vE51xM',
            '34' => 'https://scan.page/9mB7cd',
            '35' => 'https://scan.page/QWqw8V',
            '36' => 'https://scan.page/T7x3BD',
            '37' => 'https://scan.page/T7x3BD',
            '38' => 'https://scan.page/zMuWe6',
            '39' => 'https://scan.page/ahNVN0',
            '40' => 'https://scan.page/dX7KQz',
            '41' => 'https://www.internationaljournalssrg.org/IJME/paper-details?Id=641',
            '42' => 'https://esp.as-pub.com/index.php/esp/article/view/4181',
            '43' => 'https://esp.as-pub.com/index.php/esp/article/view/4181',
            '44' => 'https://esp.as-pub.com/index.php/esp/article/view/4181',
            '45' => 'https://esp.as-pub.com/index.php/esp/article/view/4181',
            '46' => 'https://esp.as-pub.com/index.php/esp/article/view/3919',
            '47' => 'https://esp.as-pub.com/index.php/esp/article/view/3919',
            '48' => 'https://esp.as-pub.com/index.php/esp/article/view/3919',
            '49' => 'https://edulearn.intelektual.org/index.php/EduLearn/article/view/23185',
            '50' => 'https://esp.as-pub.com/index.php/esp/article/view/4299',
            '51' => 'https://www.proquest.com/docview/3293435581?pq-origsite=gscholar&fromopenview=true&sourcetype=Scholarly%20Journals',
            '52' => 'https://www.proquest.com/docview/3293435581?pq-origsite=gscholar&fromopenview=true&sourcetype=Scholarly%20Journals',
            '53' => 'https://www.proquest.com/docview/3293435581?pq-origsite=gscholar&fromopenview=true&sourcetype=Scholarly%20Journals',
            '54' => 'https://www.igi-global.com/article/analyzing-the-use-of-artificial-intelligence-for-conceive-design-implement-operate-implementation/397633',
            '55' => 'https://www.igi-global.com/article/analyzing-the-use-of-artificial-intelligence-for-conceive-design-implement-operate-implementation/397633',
            '56' => 'https://www.igi-global.com/article/analyzing-the-use-of-artificial-intelligence-for-conceive-design-implement-operate-implementation/397633',
            '57' => 'https://scan.page/ZYIea4',
        ],
    ];

    public function index(): Response
    {
        $collections = $this->publicationCollections();

        return Inertia::render('research/Publications', [
            'collections' => $collections,
            'totalPosters' => array_sum(array_column($collections, 'count')),
            'downloads' => [
                [
                    'title' => 'Scopus Indexed Publications',
                    'description' => 'Download the complete publication workbook supplied by the Research Office.',
                    'href' => '/files/administration/ovprie/research/scopus-indexed-publications.xlsx',
                ],
                [
                    'title' => 'Completed Research Projects',
                    'description' => 'Download the University directory of completed research projects.',
                    'href' => '/files/administration/ovprie/research/completed-research-projects.xlsx',
                ],
            ],
        ]);
    }

    /**
     * @return array<int, array{
     *     slug: string,
     *     title: string,
     *     description: string,
     *     count: int,
     *     posters: array<int, array{id: string, title: string, image: string, url: ?string}>
     * }>
     */
    private function publicationCollections(): array
    {
        return collect(self::COLLECTIONS)
            ->map(function (array $collection): array {
                $directory = public_path(self::POSTER_BASE_PATH.'/'.$collection['slug']);

                $posters = File::isDirectory($directory)
                    ? collect(File::files($directory))
                        ->filter(fn (SplFileInfo $file): bool => in_array(
                            Str::lower($file->getExtension()),
                            ['jpeg', 'jpg', 'png', 'webp'],
                            true,
                        ))
                        ->sortBy(
                            fn (SplFileInfo $file): string => $file->getFilename(),
                            SORT_NATURAL | SORT_FLAG_CASE,
                        )
                        ->values()
                        ->map(function (SplFileInfo $file) use ($collection): array {
                            $posterNumber = $file->getFilenameWithoutExtension();

                            return [
                                'id' => $collection['slug'].'-'.$posterNumber,
                                'title' => $collection['title'].' - Poster '.$posterNumber,
                                'image' => '/'.self::POSTER_BASE_PATH.'/'.$collection['slug'].'/'.$file->getFilename(),
                                'url' => self::POSTER_URLS[$collection['slug']][$posterNumber] ?? null,
                            ];
                        })
                        ->all()
                    : [];

                return [...$collection, 'count' => count($posters), 'posters' => $posters];
            })
            ->all();
    }
}
