<?php

namespace App\Listeners\ChatbotMessage;

use App\Enum\NotificationTypeEnum;
use App\Events\ChatbotMessageSubmitted;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class StoreChatbotMessageNotification
{

    public function handle(ChatbotMessageSubmitted $event): void
    {
        $message = $event->message;
        try {
            Notification::create([
                'notifiable_id' => $message->id,
                'notifiable_type' => Message::class,
                'type' => NotificationTypeEnum::CHATBOT_MESSAGE,
                'is_read' => false,
                'title' => 'رسالة جديدة من البوت',
                'body' => 'رسالة جديدة من' . $message->name,

            ]);
        } catch (\Throwable $th) {
            Log::error('Failed to store chatbot message notification', [
                'error' => $th->getMessage(),
                'message_id' => $message->id,
                'method' => __METHOD__
            ]);
        }
    }
}
