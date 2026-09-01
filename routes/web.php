<?php

use App\Http\Controllers\AcademicAffairsController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\BacMatterController as AdminBacMatterController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\ContentPageController as AdminContentPageController;
use App\Http\Controllers\Admin\JobOpportunityController as AdminJobOpportunityController;
use App\Http\Controllers\Admin\NavigationItemController as AdminNavigationItemController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\ContentPageController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\GraduateProfessionalStudyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OfficeOfThePresidentController;
use App\Http\Controllers\OvpaaOfficeController;
use App\Http\Controllers\OvpafOfficeController;
use App\Http\Controllers\OvprieOfficeController;
use App\Http\Controllers\ResearchPublicationController;
use App\Http\Controllers\VppsiController;
use App\Http\Controllers\VppsiOfficeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/academics/academic-affairs', AcademicAffairsController::class)->name('academics.academic-affairs');
Route::get('/academics/academic-affairs/colleges/{college}', [CollegeController::class, 'show'])->name('academics.academic-affairs.colleges.show');
Route::get('/academics/academic-affairs/graduate-professional-studies/{study}', [GraduateProfessionalStudyController::class, 'show'])->name('academics.academic-affairs.graduate-professional-studies.show');
Route::get('/academics/academic-affairs/offices/{office}', [OvpaaOfficeController::class, 'show'])->name('academics.academic-affairs.offices.show');
Route::get('/campuses/{campus}', [CampusController::class, 'show'])->name('campuses.show');
Route::inertia('/about/university', 'about/University')->name('about.university');
Route::inertia('/about/board-of-regents', 'about/BoardOfRegents')->name('about.board-of-regents');
Route::get('/about/office-of-the-president', OfficeOfThePresidentController::class)->name('about.office-of-the-president');
Route::permanentRedirect('/about/innovate-agenda', '/about/office-of-the-president#strategic-directional-agenda');
Route::inertia('/administration/vpaf', 'administration/Vpaf')->name('administration.vpaf');
Route::get('/administration/vpaf/offices/{office}', [OvpafOfficeController::class, 'show'])->name('administration.vpaf.offices.show');
Route::inertia('/administration/good-governance', 'administration/GoodGovernance')->name('administration.good-governance');
Route::get('/administration/vppsi', VppsiController::class)->name('administration.vppsi');
Route::get('/administration/vppsi/offices/{office}', [VppsiOfficeController::class, 'show'])->name('administration.vppsi.offices.show');
Route::inertia('/administration/citizens-charter', 'administration/CitizensCharter')->name('administration.citizens-charter');
Route::inertia('/administration/transparency-seal', 'administration/TransparencySeal')->name('administration.transparency-seal');
Route::inertia('/research-innovation-extension', 'research/Rie')->name('research.rie');
Route::inertia('/research-innovation-extension/research-centers', 'research/Centers')->name('research.rie.centers');
Route::get('/research-innovation-extension/publications', [ResearchPublicationController::class, 'index'])->name('research.rie.publications.index');
Route::inertia('/research-innovation-extension/content-preview', 'research/content-preview/Rie')->name('research.rie.content_preview');
Route::inertia('/research-innovation-extension/content-preview/research-centers', 'research/content-preview/Centers')->name('research.rie.centers.content_preview');
Route::get('/research-innovation-extension/content-preview/publications', [ResearchPublicationController::class, 'contentPreview'])->name('research.rie.publications.content_preview');
Route::get('/research-innovation-extension/offices/{office}', [OvprieOfficeController::class, 'show'])->name('research.rie.offices.show');
Route::inertia('/services', 'services/Index')->name('services.index');
Route::get('/directory', DirectoryController::class)->name('directory');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/pages/{contentPage:slug}', [ContentPageController::class, 'show'])->name('content-pages.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::resource('admin/content-pages', AdminContentPageController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('admin.content-pages')
        ->middleware('can:manage-cms');

    Route::resource('admin/news', AdminNewsController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('admin.news')
        ->middleware('can:manage-cms');

    Route::resource('admin/announcements', AdminAnnouncementController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['announcements' => 'announcement'])
        ->names('admin.announcements')
        ->middleware('can:manage-cms');

    Route::resource('admin/bac-matters', AdminBacMatterController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('admin.bac-matters')
        ->middleware('can:manage-cms');

    Route::patch('admin/banners/reorder', [AdminBannerController::class, 'reorder'])
        ->name('admin.banners.reorder')
        ->middleware('can:manage-cms');

    Route::resource('admin/banners', AdminBannerController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('admin.banners')
        ->middleware('can:manage-cms');

    Route::resource('admin/job-opportunities', AdminJobOpportunityController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('admin.job-opportunities')
        ->middleware('can:manage-cms');

    Route::resource('admin/programs', AdminProgramController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('admin.programs')
        ->middleware('can:manage-cms');

    Route::resource('admin/navigation', AdminNavigationItemController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['navigation' => 'navigationItem'])
        ->names('admin.navigation')
        ->middleware('can:manage-cms');
});

require __DIR__.'/settings.php';
