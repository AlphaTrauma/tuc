<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;


Route::get('/', [\App\Http\Controllers\CommonController::class, 'index'])->name('main');


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard/slider', [\App\Http\Controllers\SliderItemController::class, 'index'])->name('slider');
Route::post('/dashboard/slider', [\App\Http\Controllers\SliderItemController::class, 'store']);
Route::post('/dashboard/slider/{id}', [\App\Http\Controllers\SliderItemController::class, 'update']);
Route::post('/dashboard/slider/image', [\App\Http\Controllers\SliderItemController::class, 'updateImage']);
Route::delete('/dashboard/slider/{id}', [\App\Http\Controllers\SliderItemController::class, 'delete']);

Route::get('/dashboard/users', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'index'])->name('users');
Route::get('/dashboard/pages', [\App\Http\Controllers\PageController::class, 'index'])->name('pages');
Route::get('/dashboard/pages/create', [\App\Http\Controllers\PageController::class, 'create'])->name('pages.create');
Route::get('/dashboard/pages/{slug}/edit', [\App\Http\Controllers\PageController::class, 'edit'])->name('pages.edit');
Route::post('/dashboard/pages/store', [\App\Http\Controllers\PageController::class, 'store'])->name('pages.store');
Route::post('/dashboard/pages/{id}/update', [\App\Http\Controllers\PageController::class, 'update'])->name('pages.update');

Route::resource('/dashboard/courses', \App\Http\Controllers\CourseController::class);
Route::resource('/dashboard/directions', \App\Http\Controllers\DirectionController::class);
Route::get('directions/{slug}', [\App\Http\Controllers\DirectionController::class, 'show'])->name('direction.show');

require __DIR__.'/auth.php';


# default route
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->where('slug', '([a-z-_])+')->name('page');

