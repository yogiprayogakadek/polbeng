<?php

use App\Http\Controllers\Main\AuthController;
use App\Http\Controllers\Main\DashboardController;
use App\Http\Controllers\Main\DepartmentController;
use App\Http\Controllers\Main\ProjectCategoryController;
use App\Http\Controllers\Main\ProjectController;
use App\Http\Controllers\Main\StudyProgramController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->middleware('guest');
    Route::post('/login', 'login')->name('login');

    Route::get('/logout', 'logout')->name('logout');
});



Route::middleware('auth')->group(function () {
    // DASHBOARD
    Route::controller(DashboardController::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard.admin');
        });
    });

    // DEPARTMENT
    Route::prefix('department')
        ->controller(DepartmentController::class)
        ->name('department.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::put('/toggle-status/{id}', 'toggleStatus')->name('toggleStatus');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/restore', 'showRestore')->name('showRestore');
            Route::post('/{id}/restore', 'restore')->name('restore');
        });

    // STUDY PROGRAM
    Route::prefix('study-program')
        ->controller(StudyProgramController::class)
        ->name('studyProgram.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::put('/toggle-status/{id}', 'toggleStatus')->name('toggleStatus');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/restore', 'showRestore')->name('showRestore');
            Route::post('/{id}/restore', 'restore')->name('restore');
        });

    // PROJECT CATEGORY
    Route::prefix('project-category')
        ->controller(ProjectCategoryController::class)
        ->name('projectCategory.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::put('/toggle-status/{id}', 'toggleStatus')->name('toggleStatus');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/restore', 'showRestore')->name('showRestore');
            Route::post('/{id}/restore', 'restore')->name('restore');
        });

    // PROJECT
    Route::prefix('project')
        ->controller(ProjectController::class)
        ->name('project.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::put('/toggle-status/{id}', 'toggleStatus')->name('toggleStatus');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/restore', 'showRestore')->name('showRestore');
            Route::post('/{id}/restore', 'restore')->name('restore');

            // detail
            Route::get('/detail/{id}', 'detail')->name('detail');

            // PROJECT GALLERIES
            Route::prefix('galleries')->group(function () {
                Route::get('/{id}', 'galleries')->name('galleries');
                Route::get('/modal/{projectDetailID}', 'showGalleriesModal')->name('galleries.modal');
                Route::delete('/delete/{id}', 'galleriesDelete')->name('galleriesDelete');

                // add photo to gallery modal
                Route::get('/photo/add', 'addPhoto')->name('galleries.add.photo');
                Route::post('/store', 'storeGalleryPhotos')->name('galleries.store');
            });
        });
});
