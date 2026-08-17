<?php

namespace App\Providers;

use App\Interfaces\ApplicationRepositoryInterface;
use App\Interfaces\ApplicationServiceInterface;
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
use App\Interfaces\CVEducationRepositoryInterface;
use App\Interfaces\CVEducationServiceInterface;
use App\Interfaces\CVExperienceRepositoryInterface;
use App\Interfaces\CVExperienceServiceInterface;
use App\Interfaces\CVRepositoryInterface;
use App\Interfaces\CVServiceInterface;
use App\Interfaces\JobRepositoryInterface;
use App\Interfaces\JobServiceInterface;
use App\Interfaces\SkillRepositoryInterface;
use App\Interfaces\SkillServiceInterface;
use App\Interfaces\StudentBookmarkRepositoryInterface;
use App\Interfaces\StudentBookmarkServiceInterface;
use App\Interfaces\StudentEducationServiceInterface;
use App\Interfaces\StudentProfileRepositoryInterface;
use App\Interfaces\StudentProfileServiceInterface;
use App\Repositories\CategoryRepository;
use App\Interfaces\StudentEducationRepositoryInterface;
use App\Interfaces\StudentExperienceRepositoryInterface;
use App\Interfaces\StudentExperienceServiceInterface;
use App\Repositories\JobRepository;
use App\Repositories\SkillRepository;
use App\Repositories\StudentBookmarkRepository;
use App\Repositories\StudentEducationRepository;
use App\Repositories\StudentExperienceRepository;
use App\Repositories\StudentProfileRepository;
use App\Services\CategoryService;
use App\Services\JobService;
use App\Services\SkillService;
use App\Services\StudentBookmarkService;
use App\Services\StudentEducationService;
use App\Services\StudentExperienceService;
use App\Services\StudentProfileService;
use App\Interfaces\CVTemplateRepositoryInterface;
use App\Repositories\CVTemplateRepository;
use App\Interfaces\CVTemplateServiceInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\ReviewRepositoryInterface;
use App\Interfaces\ReviewServiceInterface;
use App\Repositories\ApplicationRepository;
use App\Repositories\CVEducationRepository;
use App\Repositories\CVExperienceRepository;
use App\Repositories\CVRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ReviewRepository;
use App\Services\ApplicationService;
use App\Services\CVEducationService;
use App\Services\CVExperienceService;
use App\Services\CVService;
use App\Services\CVTemplateService;
use App\Services\ReviewService;

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
        $this->app->bind(StudentProfileRepositoryInterface::class, StudentProfileRepository::class);
        $this->app->bind(StudentProfileServiceInterface::class, StudentProfileService::class);
        $this->app->bind(StudentEducationRepositoryInterface::class, StudentEducationRepository::class);
        $this->app->bind(StudentEducationServiceInterface::class, StudentEducationService::class);
        $this->app->bind(StudentExperienceRepositoryInterface::class, StudentExperienceRepository::class);
        $this->app->bind(StudentExperienceServiceInterface::class, StudentExperienceService::class);
        $this->app->bind(StudentBookmarkRepositoryInterface::class, StudentBookmarkRepository::class);
        $this->app->bind(StudentBookmarkServiceInterface::class, StudentBookmarkService::class);
        $this->app->bind(CVTemplateRepositoryInterface::class, CVTemplateRepository::class);
        $this->app->bind(CVTemplateServiceInterface::class, CVTemplateService::class);
        $this->app->bind(CVRepositoryInterface::class, CVRepository::class);
        $this->app->bind(CVServiceInterface::class, CVService::class);
        $this->app->bind(CVEducationRepositoryInterface::class,CVEducationRepository::class);
        $this->app->bind(CVEducationServiceInterface::class, CVEducationService::class);
        $this->app->bind(CVExperienceRepositoryInterface::class, CVExperienceRepository::class);
        $this->app->bind(CVExperienceServiceInterface::class, CVExperienceService::class);
        $this->app->bind(ApplicationRepositoryInterface::class, ApplicationRepository::class);
        $this->app->bind(ApplicationServiceInterface::class, ApplicationService::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(ReviewServiceInterface::class, ReviewService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
