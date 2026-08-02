<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Notification $notification) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('admin.notifications')];
    }

    public function broadcastAs(): string
    {
        return 'notification.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'title' => $this->notification->title,
            'body' => $this->notification->body,
            'type' => $this->notification->type,
            'is_read' => $this->notification->is_read,
            'notifiable_id' => $this->notification->notifiable_id,
            'notifiable_type' => $this->notification->notifiable_type,
            'created_at' => $this->notification->created_at,
            'updated_at' => $this->notification->updated_at,
        ];
    }
}
