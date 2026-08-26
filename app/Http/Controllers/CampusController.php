<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CampusController extends Controller
{
    /** @var array<string, string> */
    private const array HERO_IMAGE_PATHS = [
        'tandag' => 'images/campuses/tandag/6I3A5798.JPG',
        'cantilan' => 'images/campuses/cantilan/Cantilan.jpg',
        'san-miguel' => 'images/campuses/san-miguel/San Miguel.jpg',
        'lianga' => 'images/campuses/lianga/Lianga.jpg',
        'cagwait' => 'images/campuses/cagwait/Cagwait.jpg',
        'tagbina' => 'images/campuses/tagbina/Tagbina.jpg',
        'bislig' => 'images/campuses/bislig/Bislig.jpg',
    ];

    /**
     * Display a public campus profile.
     */
    public function show(string $campus): Response
    {
        $campuses = Config::array('campus_profiles');
        $campusProfile = $campuses[$campus] ?? null;

        abort_if($campusProfile === null, 404);

        $campusProfile['heroImage'] = $this->heroImageUrl($campus);
        $campusProfile['prospectuses'] = $this->prospectusesFor($campusProfile);

        return Inertia::render('campuses/Show', [
            'campus' => $campusProfile,
            'campuses' => array_values($campuses),
        ]);
    }

    private function heroImageUrl(string $campus): string
    {
        return '/storage/'.self::HERO_IMAGE_PATHS[$campus];
    }

    private function prospectusUrl(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * @param  array{
     *     name: string,
     *     programs: array<int, array{college: string, offerings: array<int, string>}>,
     *     prospectuses: array<string, string>
     * }  $campusProfile
     * @return array<string, string>
     */
    private function prospectusesFor(array $campusProfile): array
    {
        $academicProspectuses = collect(
            CollegeController::prospectusUrlsForCampus($campusProfile['name']),
        )->mapWithKeys(fn (string $url, string $program): array => [
            $this->normalizedProgramTitle($program) => $url,
        ]);

        $reusedProspectuses = collect($campusProfile['programs'])
            ->flatMap(fn (array $group): array => $group['offerings'])
            ->mapWithKeys(function (string $offering) use ($academicProspectuses): array {
                $prospectusUrl = $academicProspectuses->get(
                    $this->normalizedProgramTitle($offering),
                );

                return $prospectusUrl === null
                    ? []
                    : [$offering => $prospectusUrl];
            });

        $configuredProspectuses = collect($campusProfile['prospectuses'])
            ->map(fn (string $path): string => $this->prospectusUrl($path));

        return $configuredProspectuses
            ->merge($reusedProspectuses)
            ->all();
    }

    private function normalizedProgramTitle(string $program): string
    {
        return Str::of($program)
            ->lower()
            ->replaceMatches('/\s*[–—-]\s*level\s+[ivx]+\s+accredited$/u', '')
            ->replaceMatches('/\((?:bsed|btled|btvted|bscrim\.?|bsba|bshm|bstm|bscpe|bscs|bs\s+info\.?\s+tech\.?|bindtech|bsf|bsa)\)/iu', '')
            ->replace('(electrical technology)', 'major in electrical technology')
            ->replace('major in general education', '')
            ->replace('apparel and fashion technology', 'fashion and apparel technology')
            ->replace('&', 'and')
            ->replaceMatches('/[^a-z0-9]+/', ' ')
            ->squish()
            ->toString();
    }
}
