<?php

namespace App\Listeners\ResidencyRequest;

use App\Enum\NotificationTypeEnum;
use App\Events\NewNotification;
use App\Events\ResidencyRequested;
use App\Models\Notification;
use App\Models\RequestResidency;
use Illuminate\Support\Facades\Log;

class StoreResidencyRequestNotification
{
    public function handle(ResidencyRequested $event): void
    {
        $requestResidency = $event->requestResidency;
        try {
            $notification = Notification::create([
                'notifiable_id' => $requestResidency->id,
                'notifiable_type' => RequestResidency::class,
                'type' => NotificationTypeEnum::REQUEST_RESIDENCY,
                'is_read' => false,
                'title' => 'طلب اقامة  جديد',
                'body' => 'طلب اقامة جديد من '.$requestResidency->name,
            ]);

            NewNotification::dispatch($notification);
        } catch (\Throwable $th) {
            Log::error('Failed to store residency request notification', [
                'error' => $th->getMessage(),
                'request_residency_id' => $requestResidency->id,
                'method' => __METHOD__,
            ]);
        }
    }
}
