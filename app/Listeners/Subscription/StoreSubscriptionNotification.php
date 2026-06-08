<?php

namespace App\Listeners\Subscription;

use App\Enum\NotificationTypeEnum;
use App\Events\UserSubscribed;
use App\Models\Notification;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class StoreSubscriptionNotification
{

    public function handle(UserSubscribed $event): void
    {
        $subscription = $event->subscription;
        try {
            Notification::create([
                'notifiable_id' => $subscription->id,
                'notifiable_type' => Subscription::class,
                'type' => NotificationTypeEnum::SUBSCRIPTION,
                'is_read' => false,
                'title' => 'اشتراك جديد',
                'body' => 'اشتراك جديد من ' . $subscription->email,
            ]);
        } catch (\Throwable $th) {
            Log::error('Failed to store subscription notification', [
                'error' => $th->getMessage(),
                'subscription_id' => $subscription->id,
                'method' => __METHOD__
            ]);
        }
    }
}
