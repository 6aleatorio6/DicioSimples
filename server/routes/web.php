<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchWords;
use App\Http\Controllers\UploadWords;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchWords::class, 'show'])->name('words.search');




Route::middleware('auth')->group(function () {
    Route::post('/words/import', UploadWords::class)->name('words.import');
});


Route::group(['middleware' => "auth", "prefix" => "admin"], function () {
    Route::get('/', [Dashboard::class, 'show'])->name('dashboard');

    // 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
