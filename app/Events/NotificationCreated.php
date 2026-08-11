<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Dùng ShouldBroadcastNow để bắn trực tiếp không qua Queue
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Notification $notification
    ) {}

    /**
     * Kênh (Channel) nhận broadcast.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->notification->user_id)
        ];
    }

    /**
     * Tên Event gửi về Frontend Echo client.
     */
    public function broadcastAs(): string
    {
        return 'notification.created';
    }

    /**
     * Dữ liệu truyền kèm Event.
     */
    public function broadcastWith(): array
    {
        return [
            'notification' => [
                'id' => $this->notification->id,
                'user_id' => $this->notification->user_id,
                'job_id'     => $this->notification->job_id,
                'job_title'  => $this->notification->job?->title,
                'title' => $this->notification->title,
                'content' => $this->notification->content,
                'is_read' => $this->notification->is_read,
                'created_at' => $this->notification->created_at,
            ]
        ];
    }
}