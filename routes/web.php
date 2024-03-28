<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;


Route::get('/', [\App\Http\Controllers\CommonController::class, 'index'])->name('main');

require __DIR__.'/auth.php';

#Route::get('/estimate_editor', [\App\Http\Controllers\EstimateBookController::class, 'index'])->name('estimate_editor');
#Route::post('/estimate_editor', [\App\Http\Controllers\EstimateBookController::class, 'store'])->name('new_book');

//Route::get('/vehicles/{id}/locations', [\App\Http\Controllers\VehicleController::class, 'exportLocationHistory']);
//Route::get('/vehicles/{id}/using', [\App\Http\Controllers\VehicleController::class, 'exportUsingHistory']);
//Route::get('/vehicles/export', [\App\Http\Controllers\VehicleController::class, 'export'])->name('vehicles.export');
//Route::get('/vehicles', [\App\Http\Controllers\VehicleController::class, 'index'])->name('vehicles');
//Route::get('/get/vehicles', [\App\Http\Controllers\VehicleController::class, 'load']);

//Route::post('/vehicles/add/{class}', [\App\Http\Controllers\VehicleController::class, 'storeItem']);
//Route::post('/vehicles/update/{class}', [\App\Http\Controllers\VehicleController::class, 'updateItem']);
//Route::post('/vehicles/remove/{class}', [\App\Http\Controllers\VehicleController::class, 'removeItem']);
//Route::post('/vehicles/addList/TransportTools', [\App\Http\Controllers\VehicleController::class, 'addToolsList']);
//Route::post('/vehicles/addReceipt/{tool_id}', [\App\Http\Controllers\VehicleController::class, 'addReceipt']);
//Route::get('/vehicles/removeReceipt/{receipt_id}', [\App\Http\Controllers\VehicleController::class, 'removeReceipt']);

//Route::post('/vehicles/create', [\App\Http\Controllers\VehicleController::class, 'store']);
//Route::post('/vehicles/update', [\App\Http\Controllers\VehicleController::class, 'update']);
//Route::delete('/vehicles/{id}', [\App\Http\Controllers\VehicleController::class, 'remove']);

Route::get('/height', [\App\Http\Controllers\NewsController::class, 'height'])->name('height');
Route::get('/news', [\App\Http\Controllers\NewsController::class, 'main'])->name('news.main');
Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.item');

Route::get('/send', [\App\Http\Controllers\LeadController::class, 'create'])->name('lead.create');
Route::post('/send', [\App\Http\Controllers\LeadController::class, 'store'])->name('lead.store');

Route::get('directions/{slug}', [\App\Http\Controllers\DirectionController::class, 'show'])->name('direction.show');

Route::middleware([\App\Http\Middleware\IsStudent::class])->group(function(){
    Route::get('/personal', [\App\Http\Controllers\PersonalController::class, 'index'])->name('personal');
    Route::get('/personal/active', [\App\Http\Controllers\PersonalController::class, 'active'])->name('personal.active');
    Route::get('/personal/closed', [\App\Http\Controllers\PersonalController::class, 'closed'])->name('personal.closed');
    Route::get('/personal/courses/{id}/show', [\App\Http\Controllers\PersonalController::class, 'show'])->name('personal.course');
    Route::get('/personal/tests/{id}/{block_id}', [\App\Http\Controllers\PersonalController::class, 'test'])->name('personal.test');
    Route::post('/personal/tests/{id}/{block_id}', [\App\Http\Controllers\PersonalController::class, 'checkTest'])->name('test.check');

    Route::get('/personal/material/{id}', [\App\Http\Controllers\MaterialController::class, 'show'])->name('material.show');
});

Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/slider', [\App\Http\Controllers\SliderItemController::class, 'index'])->name('slider');
    Route::post('/dashboard/slider', [\App\Http\Controllers\SliderItemController::class, 'store']);
    Route::post('/dashboard/slider/{id}', [\App\Http\Controllers\SliderItemController::class, 'update']);
    Route::post('/dashboard/slider/image', [\App\Http\Controllers\SliderItemController::class, 'updateImage']);
    Route::delete('/dashboard/slider/{id}', [\App\Http\Controllers\SliderItemController::class, 'delete']);

    Route::get('/dashboard/users', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'index'])->name('users');
    Route::get('/dashboard/students', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'students'])->name('students');
    Route::get('/dashboard/users/{id}', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'show'])->name('user.show');
    Route::get('/dashboard/users/{id}/edit', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'edit'])->name('user.edit');
    Route::post('/dashboard/users/{id}/update', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'update'])->name('user.update');
    Route::post('/dashboard/users/add', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'add'])->name('users.add');
    Route::get('/dashboard/tests/{user_course}', [\App\Http\Controllers\PersonalController::class, 'results'])->name("user.results");

    Route::get('/dashboard/contractors', [\App\Http\Controllers\ContractorsController::class, 'index'])->name('contractors');
    Route::post('/dashboard/contractors/create', [\App\Http\Controllers\ContractorsController::class, 'store'])->name('contractors.create');
    Route::get('/dashboard/contractors/{id}/remove', [\App\Http\Controllers\ContractorsController::class, 'destroy'])->name('contractors.remove');
    Route::get('/dashboard/contractors/{item}', [\App\Http\Controllers\ContractorsController::class, 'show'])->name('contractor');
    Route::post('/contractors/{id}/upload/{group_id?}', [\App\Http\Controllers\ContractorsController::class, 'upload']);
    Route::post('/dashboard/groups/{group}/update', [\App\Http\Controllers\ContractorsController::class, 'update'])->name('group.update');
    Route::get('/dashboard/groups/{group}/download/{type}', [\App\Http\Controllers\ContractorsController::class, 'downloadDocument'])->name('group.document');
    Route::post('/dashboard/contractors/addUserToGroup', [\App\Http\Controllers\ContractorsController::class, 'addUser'])->name('groups.addUser');
    Route::get('/dashboard/groups/{group_id}/remove/{user_id}', [\App\Http\Controllers\ContractorsController::class, 'removeUser'])->name('groups.removeUser');
    Route::get('/dashboard/groups/{group_id}/copy', [\App\Http\Controllers\ContractorsController::class, 'copy'])->name('group.copy');
    Route::get('/dashboard/groups/{group_id}/delete', [\App\Http\Controllers\ContractorsController::class, 'deleteGroup'])->name('group.delete');

    Route::get('/dashboard/pages', [\App\Http\Controllers\PageController::class, 'index'])->name('pages');
    Route::get('/dashboard/pages/create', [\App\Http\Controllers\PageController::class, 'create'])->name('pages.create');
    Route::get('/dashboard/pages/{id}/edit', [\App\Http\Controllers\PageController::class, 'edit'])->name('pages.edit');
    Route::post('/dashboard/pages/{id}/append', [\App\Http\Controllers\PageController::class, 'addImage']);
    Route::post('/dashboard/pages/{id}/remove', [\App\Http\Controllers\PageController::class, 'removeImage']);
    Route::post('/dashboard/pages/store', [\App\Http\Controllers\PageController::class, 'store'])->name('pages.store');
    Route::post('/dashboard/pages/{id}/update', [\App\Http\Controllers\PageController::class, 'update'])->name('pages.update');
    Route::get('/dashboard/pages/{id}/delete', [\App\Http\Controllers\PageController::class, 'destroy'])->name('pages.delete');

    Route::resource('/dashboard/directions', \App\Http\Controllers\DirectionController::class);
    Route::get('/dashboard/{id}/directions', [\App\Http\Controllers\DirectionController::class, 'typed_index'])->name('directions.by_type');
    Route::get('/dashboard/{id}/directions/create', [\App\Http\Controllers\DirectionController::class ,'create'])->name('direction.create');

    Route::get('/dashboard/directions/{id}/delete', [\App\Http\Controllers\DirectionController::class, 'destroy'])->name('directions.delete');
    Route::get('/dashboard/courses/{id}/data', [\App\Http\Controllers\CourseController::class, 'getSelectData']);

    Route::resource('/dashboard/types', \App\Http\Controllers\TypeController::class);
    Route::get('/dashboard/types/{id}/delete', [\App\Http\Controllers\TypeController::class, 'destroy'])->name('types.delete');

    Route::resource('/dashboard/courses', \App\Http\Controllers\CourseController::class);
    Route::get('/dashboard/courses/{id}/delete', [\App\Http\Controllers\CourseController::class, 'destroy'])->name('courses.delete');
    Route::get('/dashboard/directions/{id}/create', [\App\Http\Controllers\CourseController::class, 'create'])->name('course.create');
    Route::post('/dashboard/courses/addToUser', [\App\Http\Controllers\CourseController::class, 'add'])->name('courses.add');
    Route::post('/dashboard/courses/addToGroup', [\App\Http\Controllers\CourseController::class, 'addGroup'])->name('courses.addGroup');

    Route::get('/dashboard/courses/{id}/deleteFromUser', [\App\Http\Controllers\CourseController::class, 'remove'])->name('courses.remove');
    Route::get('/dashboard/courses/{id}/refresh', [\App\Http\Controllers\CourseController::class, 'refresh'])->name('courses.refresh');

    Route::get('/dashboard/courses/{id}/blocks/create', [\App\Http\Controllers\BlockController::class, 'create'])->name('blocks.create');
    Route::get('/dashboard/courses//blocks/{id}/edit', [\App\Http\Controllers\BlockController::class, 'edit'])->name('blocks.edit');
    Route::post('/dashboard/courses/blocks/store', [\App\Http\Controllers\BlockController::class, 'store'])->name('blocks.store');
    Route::post('/dashboard/courses/blocks/{id}/update', [\App\Http\Controllers\BlockController::class, 'update'])->name('blocks.update');
    Route::get('/dashboard/courses/blocks/{id}/delete', [\App\Http\Controllers\BlockController::class, 'destroy'])->name('blocks.delete');


    Route::get('/dashboard/blocks/{id}/material/{type}/create', [\App\Http\Controllers\MaterialController::class, 'create'])->name('materials.create');
    Route::post('/dashboard/materials/store', [\App\Http\Controllers\MaterialController::class, 'store'])->name('materials.store');
    Route::post('/dashboard/materials/{id}/update', [\App\Http\Controllers\MaterialController::class, 'update'])->name('materials.update');
    Route::get('/dashboard/materials/{id}/delete', [\App\Http\Controllers\MaterialController::class, 'destroy'])->name('materials.delete');

    Route::get('/dashboard/blocks/{id}/test', [\App\Http\Controllers\TestController::class, 'edit'])->name('test.constructor');
    Route::post('/dashboard/test/{id}/update', [\App\Http\Controllers\TestController::class, 'update']);
    Route::get('/dashboard/test/{id}/delete', [\App\Http\Controllers\TestController::class, 'delete'])->name('test.delete');
    Route::get('/dashboard/test/{id}/add', [\App\Http\Controllers\TestController::class, 'addQuestion']);
    Route::get('/dashboard/question/{id}/add', [\App\Http\Controllers\TestController::class, 'addVariant']);
    Route::post('/dashboard/question/{id}/update', [\App\Http\Controllers\TestController::class, 'updateQuestion']);
    Route::get('/dashboard/question/{id}/delete', [\App\Http\Controllers\TestController::class, 'deleteQuestion']);
    Route::post('/dashboard/variant/{id}/update', [\App\Http\Controllers\TestController::class, 'updateVariant']);
    Route::get('/dashboard/variant/{id}/delete', [\App\Http\Controllers\TestController::class, 'deleteVariant']);
    Route::post('/dashboard/question/{id}/set_correct', [\App\Http\Controllers\TestController::class, 'setCorrect']);


    Route::get('/dashboard/documents', [\App\Http\Controllers\DocumentController::class, 'index'])->name('documents.index');
    Route::post('/dashboard/documents', [\App\Http\Controllers\DocumentController::class, 'store'])->name('documents.store');

    Route::get('/dashboard/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::post('/dashboard/settings', [\App\Http\Controllers\SettingsController::class, 'store'])->name('settings.save');
    Route::post('/dashboard/add_person', [\App\Http\Controllers\SettingsController::class, 'add_person'])->name('person.add');
    Route::get('/dashboard/remove_person/{person}', [\App\Http\Controllers\SettingsController::class, 'remove_person'])->name('person.remove');
    Route::post('/dashboard/add_position', [\App\Http\Controllers\SettingsController::class, 'add_position'])->name('position.add');
    Route::get('/dashboard/remove_position/{position}', [\App\Http\Controllers\SettingsController::class, 'remove_position'])->name('position.remove');



    Route::get('/dashboard/files/images', [\App\Http\Controllers\ImageController::class, 'index'])->name('images.index');

    Route::resource('/dashboard/news', \App\Http\Controllers\NewsController::class);
    Route::get('/dashboard/news/{news}/delete', [\App\Http\Controllers\NewsController::class, 'delete'])->name('news.delete');

    Route::get('dashboard/leads', [\App\Http\Controllers\LeadController::class, 'index'])->name('leads');
    Route::get('dashboard/leads/{lead}/read', [\App\Http\Controllers\LeadController::class, 'read'])->name('lead.read');
    Route::get('dashboard/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs');
    Route::get('dashboard/test', [\App\Http\Controllers\DashboardController::class, 'test']);
});

Route::get('/settings/impaired', [\App\Http\Controllers\CommonController::class, 'switchMode'])->name('mode');
# default route
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->where('slug', '([a-z-_])+')->name('page');

