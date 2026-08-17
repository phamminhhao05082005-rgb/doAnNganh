<?php

namespace App\Interfaces;

use App\Models\Notification;
use App\Models\User;

interface NotificationRepositoryInterface
{
    public function findByIdAndUser(int $id, User $user): ?Notification;

    public function markAsRead(Notification $notification): Notification;
}