<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WordContentController;
use App\Http\Controllers\WordManagerController;
use App\Http\Controllers\WordSearchController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/sitemap.xml', SitemapController::class);

Route::get('/', [WordSearchController::class, 'show'])->name('home');
Route::post('/', [WordSearchController::class, 'search'])->name('home.search');

Route::get('/words/{word}', WordContentController::class)->name('word');



Route::group(['prefix' => 'admin'], function () {
    Route::name('admin')->resource('words', WordManagerController::class);
    Route::permanentRedirect('admin', 'admin/words');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
})->middleware('auth');

require __DIR__ . '/auth.php';
