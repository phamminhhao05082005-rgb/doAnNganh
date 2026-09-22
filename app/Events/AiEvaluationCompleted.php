<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AiEvaluationCompleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jobId;
    public $message;

    public function __construct($jobId, $message = "Hoàn tất đánh giá")
    {
        $this->jobId = $jobId;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('job.' . $this->jobId); 
    }

    public function broadcastAs()
    {
        return 'ai.evaluated'; 
    }
}