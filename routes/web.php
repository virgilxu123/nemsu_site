<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::inertia('/about/university', 'about/University')->name('about.university');
Route::inertia('/about/board-of-regents', 'about/BoardOfRegents')->name('about.board-of-regents');
Route::inertia('/about/office-of-the-president', 'about/OfficeOfThePresident')->name('about.office-of-the-president');
Route::inertia('/administration/transparency-seal', 'administration/TransparencySeal')->name('administration.transparency-seal');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
