<?php

namespace App\Services\V1\Admin\Notification;

use App\Models\Notification;
use Mockery\Matcher\Not;

class NotificationService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 6;
        return Notification::query()
            ->latest()
            ->paginate($per_page);
    }

    public function markAllAsRead()
    {
        return  Notification::query()
            ->unread()
            ->update(['is_read' => true]);
    }
    public function markAsRead(Notification $notification)
    {
        $notification->is_read = true;
        $notification->save();

        return $notification;
    }
}
