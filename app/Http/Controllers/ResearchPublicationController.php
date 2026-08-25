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
     *     posters: array<int, array{id: string, title: string, image: string}>
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
                            ];
                        })
                        ->all()
                    : [];

                return [...$collection, 'count' => count($posters), 'posters' => $posters];
            })
            ->all();
    }
}
