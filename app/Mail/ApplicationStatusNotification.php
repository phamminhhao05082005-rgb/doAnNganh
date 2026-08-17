<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Application $application
    ) {}

    public function envelope(): Envelope
    {
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
            ]
        );
    }
}