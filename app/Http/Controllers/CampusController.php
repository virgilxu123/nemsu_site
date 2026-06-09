<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
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

        return Inertia::render('campuses/Show', [
            'campus' => $campusProfile,
            'campuses' => array_values($campuses),
        ]);
    }
}
