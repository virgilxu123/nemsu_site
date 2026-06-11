<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CampusController extends Controller
{
    /**
     * Display a public campus profile.
     */
    public function show(string $campus): Response
    {
        $campuses = Config::array('campus_profiles');
        $campusProfile = $campuses[$campus] ?? null;

        abort_if($campusProfile === null, 404);

        $campusProfile['prospectuses'] = collect($campusProfile['prospectuses'])
            ->map(fn (string $path): string => Storage::disk('public')->url($path))
            ->all();

        return Inertia::render('campuses/Show', [
            'campus' => $campusProfile,
            'campuses' => array_values($campuses),
        ]);
    }
}
