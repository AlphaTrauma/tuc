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
Route::get('/dashboard/users/{id}', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'show'])->name('user.show');
Route::get('/dashboard/users/{id}/edit', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'edit'])->name('user.edit');
Route::post('/dashboard/users/{id}/update', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'update'])->name('user.update');

Route::get('/dashboard/pages', [\App\Http\Controllers\PageController::class, 'index'])->name('pages');
Route::get('/dashboard/pages/create', [\App\Http\Controllers\PageController::class, 'create'])->name('pages.create');
Route::get('/dashboard/pages/{id}/edit', [\App\Http\Controllers\PageController::class, 'edit'])->name('pages.edit');
Route::post('/dashboard/pages/{id}/append', [\App\Http\Controllers\PageController::class, 'addImage']);
Route::post('/dashboard/pages/{id}/remove', [\App\Http\Controllers\PageController::class, 'removeImage']);
Route::post('/dashboard/pages/store', [\App\Http\Controllers\PageController::class, 'store'])->name('pages.store');
Route::post('/dashboard/pages/{id}/update', [\App\Http\Controllers\PageController::class, 'update'])->name('pages.update');
Route::get('/dashboard/pages/{id}/delete', [\App\Http\Controllers\PageController::class, 'destroy'])->name('pages.delete');

Route::resource('/dashboard/news', \App\Http\Controllers\NewsController::class);
Route::get('/dashboard/news/{news}/delete', [\App\Http\Controllers\NewsController::class, 'delete'])->name('news.delete');

Route::get('/news', [\App\Http\Controllers\NewsController::class, 'main'])->name('news.main');
Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.item');


Route::resource('/dashboard/directions', \App\Http\Controllers\DirectionController::class);

Route::get('/dashboard/directions/{id}/delete', [\App\Http\Controllers\DirectionController::class, 'destroy'])->name('directions.delete');
Route::get('/dashboard/courses/{id}/data', [\App\Http\Controllers\CourseController::class, 'getSelectData']);

Route::resource('/dashboard/courses', \App\Http\Controllers\CourseController::class);
Route::get('/dashboard/courses/{id}/delete', [\App\Http\Controllers\CourseController::class, 'destroy'])->name('courses.delete');
Route::get('/dashboard/directions/{id}/create', [\App\Http\Controllers\CourseController::class, 'create'])->name('course.create');


Route::get('/dashboard/documents', [\App\Http\Controllers\DocumentController::class, 'index'])->name('documents.index');
Route::post('/dashboard/documents', [\App\Http\Controllers\DocumentController::class, 'store'])->name('documents.store');

Route::get('/dashboard/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::post('/dashboard/settings', [\App\Http\Controllers\SettingsController::class, 'store'])->name('settings.save');

Route::get('/dashboard/files/images', [\App\Http\Controllers\ImageController::class, 'index'])->name('images.index');

require __DIR__.'/auth.php';

Route::get('/send', [\App\Http\Controllers\LeadController::class, 'create'])->name('lead.create');
Route::post('/send', [\App\Http\Controllers\LeadController::class, 'store'])->name('lead.store');
Route::get('dashboard/leads', [\App\Http\Controllers\LeadController::class, 'index'])->name('leads');
Route::get('dashboard/leads/{lead}/read', [\App\Http\Controllers\LeadController::class, 'read'])->name('lead.read');

Route::get('directions/{slug}', [\App\Http\Controllers\DirectionController::class, 'show'])->name('direction.show');
# default route
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->where('slug', '([a-z-_])+')->name('page');

