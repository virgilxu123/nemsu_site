<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Models\News;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $staticRoutes = [
            'home',
            'about.university',
            'about.board-of-regents',
            'about.office-of-the-president',
            'academics.academic-affairs',
            'administration.vpaf',
            'administration.good-governance',
            'administration.vppsi',
            'administration.citizens-charter',
            'administration.transparency-seal',
            'research.rie',
            'research.rie.centers',
            'research.rie.publications.index',
            'services.index',
            'directory',
            'announcements.index',
            'news.index',
        ];
        $urls = collect($staticRoutes)
            ->map(fn (string $routeName): array => ['location' => route($routeName), 'lastModified' => null]);

        $urls->push(...collect(array_keys(config('campus_profiles')))
            ->map(fn (string $campus): array => [
                'location' => route('campuses.show', $campus),
                'lastModified' => null,
            ]));

        $urls->push(...collect(array_keys(CollegeController::COLLEGES))
            ->map(fn (string $college): array => [
                'location' => route('academics.academic-affairs.colleges.show', $college),
                'lastModified' => null,
            ]));

        $urls->push(...collect(array_keys(GraduateProfessionalStudyController::STUDIES))
            ->map(fn (string $study): array => [
                'location' => route('academics.academic-affairs.graduate-professional-studies.show', $study),
                'lastModified' => null,
            ]));

        $urls->push(...collect(array_keys(OvpaaOfficeController::OFFICES))
            ->map(fn (string $office): array => [
                'location' => route('academics.academic-affairs.offices.show', $office),
                'lastModified' => null,
            ]));

        $urls->push(...News::query()
            ->select(['id', 'slug', 'updated_at'])
            ->where('is_published', true)
            ->latest('date')
            ->get()
            ->map(fn (News $news): array => [
                'location' => route('news.show', $news),
                'lastModified' => $news->updated_at?->toAtomString(),
            ]));

        $urls->push(...ContentPage::query()
            ->select(['id', 'slug', 'updated_at'])
            ->published()
            ->latest('updated_at')
            ->get()
            ->map(fn (ContentPage $contentPage): array => [
                'location' => route('content-pages.show', $contentPage),
                'lastModified' => $contentPage->updated_at?->toAtomString(),
            ]));

        return response()
            ->view('sitemap', [
                'urls' => $urls->unique('location')->sortBy('location')->values(),
            ])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
