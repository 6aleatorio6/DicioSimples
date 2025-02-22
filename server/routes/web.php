<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordContentController;
use App\Http\Controllers\WordSearchController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [WordSearchController::class, 'show'])->name('home');
Route::post('/', [WordSearchController::class, 'search'])->name('home.search');

Route::get('/words/{word}', WordContentController::class)->name('word');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
