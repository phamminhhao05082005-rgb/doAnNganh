<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminSkillController;
use App\Http\Controllers\Admin\AnalyticsController;
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

            Route::resource('categories', AdminCategoryController::class)->except(['create', 'edit', 'show']);
            Route::resource('skills', AdminSkillController::class)->except(['create', 'edit', 'show']);

            Route::get('jobs', [AdminJobController::class, 'index'])->name('jobs.index');
            Route::get('jobs/{id}', [AdminJobController::class, 'show'])->name('jobs.show');
            Route::patch('jobs/{id}/toggle-status', [AdminJobController::class, 'toggleStatus'])->name('jobs.toggle-status');

            Route::get('notifications/create', [AdminNotificationController::class, 'create'])->name('notifications.create');

            Route::post('notifications', [AdminNotificationController::class, 'store'])->name('notifications.store');

            Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

            Route::get('/analytics/chart-data', [AnalyticsController::class, 'chartData'])->name('analytics.chart-data');

            Route::get('/analytics/applications-over-time', [AnalyticsController::class, 'applicationsOverTime'])->name('analytics.applications-over-time');
            Route::get('/analytics/cv-templates-usage', [AnalyticsController::class, 'cvTemplatesUsage'])->name('analytics.cv-templates-usage');
            Route::get('/analytics/company-jobs', [AnalyticsController::class, 'companyJobs'])->name('analytics.company-jobs');
        });
    });
