<?php

namespace App\Listeners\ContactUs;

use App\Enum\NotificationTypeEnum;
use App\Events\ContactMessageSubmitted;
use App\Events\NewNotification;
use App\Models\ContactUs;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class StoreContactUsNotification
{
    public function handle(ContactMessageSubmitted $event): void
    {
        $contactUs = $event->contactUs;
        try {
            $notification = Notification::create([
                'notifiable_id' => $contactUs->id,
                'notifiable_type' => ContactUs::class,
                'type' => NotificationTypeEnum::CONTACT_US,
                'is_read' => false,
                'title' => 'رسالة تواصل جديدة',
                'body' => 'رسالة تواصل جديدة من '.$contactUs->name,
            ]);

            NewNotification::dispatch($notification);
        } catch (\Throwable $th) {
            Log::error('Failed to store contact us notification', [
                'error' => $th->getMessage(),
                'contact_us_id' => $contactUs->id,
                'method' => __METHOD__,
            ]);
        }
    }
}
