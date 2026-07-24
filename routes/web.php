<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/login', [AdminAuthController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [AdminAuthController::class, 'login']);

        Route::middleware('auth')->group(function () {

            Route::get('/', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('companies', AdminCompanyController::class);

            Route::put(
                'companies/{id}/restore',
                [AdminCompanyController::class, 'restore']
            )->name('companies.restore');

            Route::post('/logout', [AdminAuthController::class, 'logout'])
                ->name('logout');
        });

    });