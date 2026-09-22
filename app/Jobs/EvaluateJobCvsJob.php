<?php

namespace App\Jobs;

use App\Events\AiEvaluationCompleted;
use App\Interfaces\ApplicationServiceInterface;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class EvaluateJobCvsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300; 
    public $tries = 2;

    protected $user;
    protected $jobId;
    protected $force;

    public function __construct(User $user, int $jobId, bool $force)
    {
        $this->user = $user;
        $this->jobId = $jobId;
        $this->force = $force;
    }

    public function handle(ApplicationServiceInterface $applicationService): void
    {
        try {
            
            $applicationService->evaluateApplicationsByJob($this->user, $this->jobId, $this->force);

            event(new AiEvaluationCompleted($this->jobId));

            Log::info("Hoàn thành AI Evaluate CV cho Job ID: {$this->jobId}");

        } catch (Throwable $e) {
            Log::error("Lỗi khi chạy AI Evaluate Job CVs: " . $e->getMessage());
            
            throw $e;
        }
    }
}