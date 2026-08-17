<?php

namespace App\Services;

use App\Events\NotificationCreated;
use App\Interfaces\NotificationRepositoryInterface;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    protected $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function markAsRead(User $user, int $notificationId): Notification
    {
        $notification = $this->repository->findByIdAndUser($notificationId, $user);

        if (!$notification) {
            abort(404, 'Thông báo không tồn tại hoặc không thuộc về bạn.');
        }

        return $this->repository->markAsRead($notification);
    }

    public function sendNotificationToAll(string $title, string $content, ?string $role = null): int
    {
        // 1. Lấy danh sách ID người nhận (Loại trừ tài khoản ADMIN)
        $query = User::whereHas('role', function ($q) {
            $q->where('name', '!=', 'ADMIN');
        });

        // 2. Lọc theo vai trò cụ thể (STUDENT hoặc EMPLOYER) nếu có
        if ($role) {
            $query->whereHas('role', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $users = $query->get(['id']);

        if ($users->isEmpty()) {
            return 0;
        }

        $count = 0;

        DB::transaction(function () use ($users, $title, $content, &$count) {
            foreach ($users as $user) {
                $notification = Notification::create([
                    'user_id' => $user->id,
                    'title'   => $title,
                    'content' => $content,
                    'is_read' => false,
                ]);

                event(new NotificationCreated($notification));

                $count++;
            }
        });

        return $count;
    }
}
