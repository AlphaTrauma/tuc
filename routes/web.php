<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
})->name('main');


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/dashboard/users', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'index'])->name('users');
Route::get('/dashboard/pages', [\App\Http\Controllers\PageController::class, 'index'])->name('pages');
Route::get('/dashboard/pages/create', [\App\Http\Controllers\PageController::class, 'create'])->name('pages.create');
Route::get('/dashboard/pages/{slug}/edit', [\App\Http\Controllers\PageController::class, 'edit'])->name('pages.edit');
Route::post('/dashboard/pages/store', [\App\Http\Controllers\PageController::class, 'store'])->name('pages.store');
Route::post('/dashboard/pages/{id}/update', [\App\Http\Controllers\PageController::class, 'update'])->name('pages.update');

require __DIR__.'/auth.php';

# default route
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->where('slug', '([a-z-_])+')->name('page');

