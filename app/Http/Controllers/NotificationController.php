<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;

class NotificationController extends Controller
{
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