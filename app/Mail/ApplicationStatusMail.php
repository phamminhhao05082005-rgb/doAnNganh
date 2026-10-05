<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Application $application
    ) {
        $this->afterCommit();
    }

    public function envelope(): Envelope
    {
        $this->application->loadMissing(['cv.user', 'job.company']);

        $jobTitle = $this->application->job->title ?? 'Công việc';

        return new Envelope(
            subject: "Thông báo cập nhật trạng thái ứng tuyển: {$jobTitle}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.application_status',
            with: [
                'application' => $this->application,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
