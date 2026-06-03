<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\ContentPageController as AdminContentPageController;
use App\Http\Controllers\Admin\NavigationItemController as AdminNavigationItemController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ContentPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::inertia('/about/university', 'about/University')->name('about.university');
Route::inertia('/about/board-of-regents', 'about/BoardOfRegents')->name('about.board-of-regents');
Route::inertia('/about/office-of-the-president', 'about/OfficeOfThePresident')->name('about.office-of-the-president');
Route::inertia('/administration/transparency-seal', 'administration/TransparencySeal')->name('administration.transparency-seal');
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

    Route::resource('admin/banners', AdminBannerController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('admin.banners')
        ->middleware('can:manage-cms');

    Route::resource('admin/navigation', AdminNavigationItemController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['navigation' => 'navigationItem'])
        ->names('admin.navigation')
        ->middleware('can:manage-cms');
});

require __DIR__.'/settings.php';
