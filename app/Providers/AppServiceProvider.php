<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

use App\Interfaces\AuthServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Services\AuthService;
use App\Services\CompanyService;
use App\Interfaces\CompanyServiceInterface;
use App\Interfaces\JobRepositoryInterface;
use App\Interfaces\JobServiceInterface;
use App\Interfaces\SkillRepositoryInterface;
use App\Interfaces\SkillServiceInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\JobRepository;
use App\Repositories\SkillRepository;
use App\Services\CategoryService;
use App\Services\JobService;
use App\Services\SkillService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(JobServiceInterface::class, JobService::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(SkillRepositoryInterface::class, SkillRepository::class);
        $this->app->bind(SkillServiceInterface::class, SkillService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
