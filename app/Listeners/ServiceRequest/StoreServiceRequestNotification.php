<?php

namespace App\Listeners\ServiceRequest;

use App\Enum\NotificationTypeEnum;
use App\Events\NewNotification;
use App\Events\ServiceRequested;
use App\Models\Notification;
use App\Models\RequestService;
use Illuminate\Support\Facades\Log;

class StoreServiceRequestNotification
{
    public function handle(ServiceRequested $event): void
    {
        $requestService = $event->requestService;
        try {
            $notification = Notification::create([
                'notifiable_id' => $requestService->id,
                'notifiable_type' => RequestService::class,
                'type' => NotificationTypeEnum::REQUEST_SERVICE,
                'is_read' => false,
                'title' => 'طلب خدمة جديد',
                'body' => 'طلب خدمة جديد من '.$requestService->name,
            ]);

            NewNotification::dispatch($notification);
        } catch (\Throwable $th) {
            Log::error('Failed to store service request notification', [
                'error' => $th->getMessage(),
                'request_service_id' => $requestService->id,
                'method' => __METHOD__,
            ]);
        }
    }
}
