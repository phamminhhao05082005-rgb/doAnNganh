<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{

    protected $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    public function markAsRead(int $id): JsonResponse
    {
        $notification = $this->service->markAsRead(auth()->user(), $id);

        return response()->json([
            'message' => 'Đã đánh dấu thông báo là đã đọc.',
            'data' => $notification
        ]);
    }

    public function index()
    {
        $notifications = Notification::where(
            'user_id',
            auth()->id()
        )
            ->with('job')
            ->latest()
            ->get();

        return NotificationResource::collection(
            $notifications
        );
    }
}