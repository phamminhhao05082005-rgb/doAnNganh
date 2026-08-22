<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Student\CVController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CVEducationController;
use App\Http\Controllers\CVExperienceController;
use App\Http\Controllers\CVTemplateController;
use App\Http\Controllers\Employer\EmployerCompanyController;
use App\Http\Controllers\Employer\EmployerJobController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\StudentEducationController;
use App\Http\Controllers\Student\StudentExperienceController;
use App\Http\Controllers\Student\StudentBookmarkController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Student\ReviewController;
use Illuminate\Support\Facades\Http;

Route::get('/test-gemini', function () {
    $apiKey = env('GEMINI_API_KEY');

    // 1. Lấy danh sách các model từ Google API
    $listUrl = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";
    $listResponse = Http::get($listUrl);

    if ($listResponse->failed()) {
        return response()->json([
            'status' => 'error_fetching_models',
            'message' => 'Lỗi kết nối API Key.',
            'detail' => $listResponse->json()
        ], $listResponse->status());
    }

    $models = $listResponse->json('models', []);
    
    // 2. Ưu tiên các model mới nhất và loại bỏ model deprecated/special
    $selectedModel = null;
    $preferredModels = [
        'models/gemini-3.6-flash',
        'models/gemini-3-flash',
        'models/gemini-1.5-flash',
        'models/gemini-1.5-pro'
    ];

    foreach ($preferredModels as $pref) {
        foreach ($models as $m) {
            if (($m['name'] ?? '') === $pref && in_array('generateContent', $m['supportedGenerationMethods'] ?? [])) {
                $selectedModel = $m['name'];
                break 2;
            }
        }
    }

    // Dự phòng: Lấy model Gemini bất kỳ có hỗ trợ generateContent
    if (!$selectedModel) {
        foreach ($models as $m) {
            $name = $m['name'] ?? '';
            $methods = $m['supportedGenerationMethods'] ?? [];
            if (str_contains($name, 'gemini') && !str_contains($name, 'deep-research') && in_array('generateContent', $methods)) {
                $selectedModel = $name;
                break;
            }
        }
    }

    if (!$selectedModel) {
        return response()->json([
            'status' => 'no_valid_model_found',
            'available_models' => array_column($models, 'name')
        ], 404);
    }

    // 3. Gọi API generateContent
    $generateUrl = "https://generativelanguage.googleapis.com/v1beta/{$selectedModel}:generateContent?key={$apiKey}";

    $response = Http::post($generateUrl, [
        'contents' => [
            [
                'parts' => [
                    ['text' => 'Xin chào, hãy trả lời ngắn gọn: Bạn là ai?']
                ]
            ]
        ]
    ]);

    if ($response->successful()) {
        return response()->json([
            'status' => 'success',
            'model_used' => $selectedModel,
            'reply' => $response->json('candidates.0.content.parts.0.text')
        ]);
    }

    return response()->json([
        'status' => 'error',
        'model_used' => $selectedModel,
        'detail' => $response->json()
    ], $response->status());
});


Broadcast::routes([
    'middleware' => ['auth:sanctum']
]);

Broadcast::channel('user.{userId}', function ($user, $userId) {

    return (int) $user->id === (int) $userId;
});

Route::get('companies/{companyId}/reviews', [ReviewController::class, 'index']);

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/google-login', [AuthController::class, 'googleLogin']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/skills', [SkillController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/companies/{id}', [EmployerCompanyController::class, 'showById']);
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

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

            Route::get(
                '/jobs/{jobId}/applications',
                [ApplicationController::class, 'jobApplications']
            );

            Route::put(
                '/applications/{id}/status',
                [ApplicationController::class, 'updateStatus']
            );

            Route::get(
                '/applications/{applicationId}/cv',
                [ApplicationController::class, 'getCVDetail']
            );

            Route::post('/jobs/{jobId}/evaluate-cvs', [ApplicationController::class, 'evaluateJobCvs']);
        });

        Route::middleware('role:STUDENT')
            ->prefix('student')
            ->group(function () {

                Route::get('/profile', [StudentProfileController::class, 'show']);
                Route::put('/profile', [StudentProfileController::class, 'update']);
                Route::get('/educations', [StudentEducationController::class, 'index']);
                Route::post('/educations', [StudentEducationController::class, 'store']);
                Route::put('/educations/{education}', [StudentEducationController::class, 'update']);
                Route::delete('/educations/{education}', [StudentEducationController::class, 'destroy']);
                Route::get('/experiences', [StudentExperienceController::class, 'index']);
                Route::post('/experiences', [StudentExperienceController::class, 'store']);
                Route::put('/experiences/{experience}', [StudentExperienceController::class, 'update']);
                Route::delete('/experiences/{experience}', [StudentExperienceController::class, 'destroy']);
                Route::get('/bookmarks', [StudentBookmarkController::class, 'index']);
                Route::post('/bookmarks/{job}', [StudentBookmarkController::class, 'store']);
                Route::delete('/bookmarks/{job}', [StudentBookmarkController::class, 'destroy']);
                Route::get('/cv-templates', [CVTemplateController::class, 'index']);
                Route::get('/cv-templates/{id}', [CVTemplateController::class, 'show']);
                Route::get('/cvs', [CVController::class, 'index']);
                Route::get('/cvs/{id}', [CVController::class, 'show']);
                Route::post('/cvs', [CVController::class, 'store']);
                Route::put('/cvs/{id}', [CVController::class, 'update']);
                Route::delete('/cvs/{id}', [CVController::class, 'destroy']);
                Route::get("/cvs/{cv}/educations", [CVEducationController::class, "index"]);
                Route::post("/cvs/{cv}/educations", [CVEducationController::class, "store"]);
                Route::put("/cvs/{cv}/educations/{education}", [CVEducationController::class, "update"]);
                Route::delete("/cvs/{cv}/educations/{education}", [CVEducationController::class, "destroy"]);
                Route::get("/cvs/{cv}/experiences", [CVExperienceController::class, "index"]);
                Route::post("/cvs/{cv}/experiences", [CVExperienceController::class, "store"]);
                Route::put("/cvs/{cv}/experiences/{experience}", [CVExperienceController::class, "update"]);
                Route::delete("/cvs/{cv}/experiences/{experience}", [CVExperienceController::class, "destroy"]);
                Route::post('/applications', [ApplicationController::class, 'apply']);
                Route::get('/applications', [ApplicationController::class, 'myApplications']);
                Route::delete("/applications/{id}", [ApplicationController::class, "destroy"]);
                Route::post('reviews', [ReviewController::class, 'store']);
                Route::put('reviews/{id}', [ReviewController::class, 'update']);
                Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);
            });
    });
});
