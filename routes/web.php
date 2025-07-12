<?php

use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\ProjectController as FrontendProjectController;
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



Route::middleware('auth')->prefix('admin')->group(function () {
    // DASHBOARD
    Route::controller(DashboardController::class)->group(function () {
        // Route::prefix('admin')->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard.admin');
        Route::get('/dashboard/projects-per-year', 'getProjectsPerYear')->name('dashboard.projectsPerYear');
        Route::get('/dashboard/projects-per-category', 'getProjectsPerCategory')->name('dashboard.projectsPerCategory');
        Route::get('/dashboard/recent-projects', 'recentProjects')->name('dashboard.recentProjects');
        Route::get('/dashboard/projects-trend', 'projectsTrend')->name('dashboard.projectsTrend');
        // });
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

// FRONTEND
Route::name('frontend.')->group(function () {
    Route::controller(HomePageController::class)->group(function () {
        Route::get('/', 'homepage')->name('homepage');
        Route::get('/homepage/project-category/{departmentID}', 'projectCategory')->name('project.category');
    });

    Route::controller(FrontendProjectController::class)->group(function () {
        Route::get('/projects/{category_uuid}', 'index')->name('project.index');
        Route::get('/projects/filter/load-more', 'loadMore')->name('project.loadmore');
        Route::get('/projects/filter/search', 'search')->name('project.search');

        Route::get('/projects/department/{department}/{uuid}', 'departmentProject')->name('project.department');
        Route::get('/projects/study-program/filter/total/{id}', 'totalProjectByStudyProgram')->name('project.total');

        // DETAIL
        Route::get('/detail/{slug}/{uuid}', 'detail')->name('project.detail');
    });
});
