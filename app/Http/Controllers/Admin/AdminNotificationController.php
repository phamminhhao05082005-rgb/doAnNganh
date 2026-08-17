<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function create()
    {
        return view('admin.notifications.create');
    }

    /**
     * Xử lý gửi thông báo hàng loạt
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'role'    => 'nullable|in:STUDENT,EMPLOYER',
        ], [
            'title.required'   => 'Vui lòng nhập tiêu đề thông báo.',
            'content.required' => 'Vui lòng nhập nội dung thông báo.',
        ]);

        $totalSent = $this->notificationService->sendNotificationToAll(
            $request->title,
            $request->content,
            $request->role
        );

        return redirect()->back()->with('success', "Đã gửi thông báo thành công đến {$totalSent} người dùng!");
    }
}
