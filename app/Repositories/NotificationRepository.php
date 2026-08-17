<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Models\User;
use App\Interfaces\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function findByIdAndUser(int $id, User $user): ?Notification
    {
        return Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
    }

    public function markAsRead(Notification $notification): Notification
    {
        $notification->update([
            'is_read' => true,
        ]);

        return $notification->refresh();
    }
}