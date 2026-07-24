<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Employer\EmployerCompanyController;
use App\Http\Controllers\Employer\EmployerJobController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\JobController;

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/google-login', [AuthController::class, 'googleLogin']);

    Route::get(
        '/categories',
        [CategoryController::class, 'index']
    );

    Route::get(
        '/skills',
        [SkillController::class, 'index']
    );

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', [AuthController::class, 'me']);

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::middleware(['role:ADMIN'])->group(function () {

            Route::get('/users', [AuthController::class, 'index']);

            Route::apiResource('companies', AdminCompanyController::class);
        });

        Route::get('/jobs', [JobController::class, 'index']);

        Route::get('/jobs/{job}', [JobController::class, 'show']);

        Route::middleware('role:EMPLOYER')->prefix('employer')->group(function () {

            Route::get('/company', [EmployerCompanyController::class, 'show']);

            Route::put('/company', [EmployerCompanyController::class, 'update']);

            Route::apiResource('jobs', EmployerJobController::class);

            Route::get('/myJobs', [EmployerJobController::class, 'getJobsOfCompany']);
        });
    });
});
