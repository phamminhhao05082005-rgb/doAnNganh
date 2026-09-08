<?php

namespace App\Jobs;

use App\Models\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendApplicationStatusEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Application $application
    ) {}

    public function handle(): void
    {
        $this->application->loadMissing(['cv.user', 'job.company']);

        $candidateEmail = $this->application->cv->user->email ?? null;

        if (!$candidateEmail) {
            Log::warning("Không tìm thấy Email của ứng viên cho Application ID: {$this->application->id}");
            return;
        }

        $jobTitle = $this->application->job->title ?? 'Công việc';
        $subject = "Thông báo cập nhật trạng thái ứng tuyển: {$jobTitle}";

        $htmlContent = view('emails.application_status', [
            'application' => $this->application,
        ])->render();

        $apiKey = config('services.brevo.key') ?? env('BREVO_API_KEY');

        $response = Http::withHeaders([
            'accept'       => 'application/json',
            'api-key'      => $apiKey,
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name'  => config('services.brevo.name', 'Job Portal'),
                'email' => config('services.brevo.address'),
            ],
            'to' => [
                [
                    'email' => $candidateEmail,
                ],
            ],
            'subject'     => $subject,
            'htmlContent' => $htmlContent,
        ]);

        if ($response->failed()) {
            Log::error('Gửi mail Brevo thất bại: ' . $response->body());
            $response->throw();
        }
    }
}