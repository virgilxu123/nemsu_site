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
        $campusProfile['prospectuses'] = collect($campusProfile['prospectuses'])
            ->map(fn (string $path): string => $this->prospectusUrl($path))
            ->all();

        return Inertia::render('campuses/Show', [
            'campus' => $campusProfile,
            'campuses' => array_values($campuses),
        ]);
    }

    private function heroImageUrl(string $campus): string
    {
        return Storage::disk('public')->url(self::HERO_IMAGE_PATHS[$campus]);
    }

    private function prospectusUrl(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
