<?php

use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\ProjectController as FrontendProjectController;
use App\Http\Controllers\Main\AuthController;
use App\Http\Controllers\Main\DashboardController;
use App\Http\Controllers\Main\DepartmentController;
use App\Http\Controllers\Main\ProjectApprovalController;
use App\Http\Controllers\Main\ProjectCategoryController;
use App\Http\Controllers\Main\ProjectController;
use App\Http\Controllers\Main\StudyProgramController;
use App\Http\Controllers\Main\UserController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->middleware('guest');
    Route::post('/login', 'login')->name('login');

    Route::get('/logout', 'logout')->name('logout');
});



Route::middleware(['auth'])->group(function () {
    // DASHBOARD (Shared for all roles for now, as each role needs to see it)
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard.admin');
        Route::get('/dashboard/per-year', 'getProjectsPerYear')->name('dashboard.projectsPerYear');
        Route::get('/dashboard/per-category', 'getProjectsPerCategory')->name('dashboard.projectsPerCategory');
        Route::get('/dashboard/recent-projects', 'recentProjects')->name('dashboard.recentProjects');
        Route::get('/dashboard/projects-trend', 'projectsTrend')->name('dashboard.projectsTrend');
    });

    // ADMIN & PETUGAS ONLY
    Route::middleware('role:admin,petugas')->group(function () {
        // DEPARTMENT
        Route::resource('/department', DepartmentController::class);
        Route::get('/department-showRestore', [DepartmentController::class, 'showRestore'])->name('department.showRestore');
        Route::post('/department-restore/{id}', [DepartmentController::class, 'restore'])->name('department.restore');
        Route::put('/department-toggleStatus/{id}', [DepartmentController::class, 'toggleStatus'])->name('department.toggleStatus');

        // STUDY PROGRAM
        Route::resource('/studyProgram', StudyProgramController::class);
        Route::get('/studyProgram-showRestore', [StudyProgramController::class, 'showRestore'])->name('studyProgram.showRestore');
        Route::post('/studyProgram-restore/{id}', [StudyProgramController::class, 'restore'])->name('studyProgram.restore');
        Route::put('/studyProgram-toggleStatus/{id}', [StudyProgramController::class, 'toggleStatus'])->name('studyProgram.toggleStatus');

        // PROJECT CATEGORY
        Route::resource('/projectCategory', ProjectCategoryController::class);
        Route::get('/projectCategory-showRestore', [ProjectCategoryController::class, 'showRestore'])->name('projectCategory.showRestore');
        // Route::get('/projectCategory-restore/{id}', [ProjectCategoryController::class, 'restore'])->name('projectCategory.restore');
        Route::post('/projectCategory-restore/{id}', [ProjectCategoryController::class, 'restore'])->name('projectCategory.restore');
        Route::put('/projectCategory-toggleStatus/{id}', [ProjectCategoryController::class, 'toggleStatus'])->name('projectCategory.toggleStatus');

        // PROJECT
        Route::prefix('project')
            ->controller(ProjectController::class)
            ->name('project.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/data', 'projectData')->name('data');
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

        // USER MANAGEMENT (Admin Only)
        Route::middleware('role:admin')->prefix('user')
            ->controller(UserController::class)
            ->name('user.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/delete/{id}', 'destroy')->name('destroy');
                Route::get('/restore', 'showRestore')->name('showRestore');
                Route::post('/{id}/restore', 'restore')->name('restore');
            });
    });

    // DOSEN APPROVAL WORKFLOW
    Route::middleware('role:dosen_pembimbing')->prefix('dosen')
        ->controller(ProjectApprovalController::class)
        ->name('dosen.')
        ->group(function () {
            Route::get('/projects', 'dosenIndex')->name('index');
            Route::get('/projects/data', 'dosenData')->name('data');
            Route::post('/projects/{id}/verify', 'dosenVerify')->name('verify');
        });

    // KAPRODI APPROVAL WORKFLOW
    Route::middleware('role:kaprodi')->prefix('kaprodi')
        ->controller(ProjectApprovalController::class)
        ->name('kaprodi.')
        ->group(function () {
            Route::get('/projects', 'kaprodiIndex')->name('index');
            Route::get('/projects/data', 'kaprodiData')->name('data');
            Route::post('/projects/{id}/approve', 'kaprodiApprove')->name('approve');
        });
});

// FRONTEND
Route::name('frontend.')->group(function () {
    Route::controller(HomePageController::class)->group(function () {
        Route::get('/', 'homepage')->name('homepage');
        Route::get('/global-search', 'globalSearch')->name('global.search');
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
