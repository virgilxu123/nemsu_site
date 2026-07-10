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
use App\Http\Controllers\ContentPageController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OfficeOfThePresidentController;
use App\Http\Controllers\VppsiController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/academics/academic-affairs', AcademicAffairsController::class)->name('academics.academic-affairs');
Route::get('/campuses/{campus}', [CampusController::class, 'show'])->name('campuses.show');
Route::inertia('/about/university', 'about/University')->name('about.university');
Route::inertia('/about/board-of-regents', 'about/BoardOfRegents')->name('about.board-of-regents');
Route::get('/about/office-of-the-president', OfficeOfThePresidentController::class)->name('about.office-of-the-president');
Route::inertia('/about/innovate-agenda', 'about/InnovateAgenda')->name('about.innovate-agenda');
Route::inertia('/administration/vpaf', 'administration/Vpaf')->name('administration.vpaf');
Route::inertia('/administration/good-governance', 'administration/GoodGovernance')->name('administration.good-governance');
Route::get('/administration/vppsi', VppsiController::class)->name('administration.vppsi');
Route::inertia('/administration/citizens-charter', 'administration/CitizensCharter')->name('administration.citizens-charter');
Route::inertia('/administration/transparency-seal', 'administration/TransparencySeal')->name('administration.transparency-seal');
Route::inertia('/research-innovation-extension', 'research/Rie')->name('research.rie');
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
