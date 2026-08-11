<?php

namespace App\Listeners\Sms;

use App\Events\ChatbotMessageSubmitted;
use App\Events\ContactMessageSubmitted;
use App\Events\ResidencyRequested;
use App\Events\ServiceRequested;
use App\Models\User;
use App\Services\V1\SMS\TqnyatSmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendSmsToAdmins implements ShouldQueue
{
    public function __construct(protected TqnyatSmsService $sms) {}

    public function handle(
        ChatbotMessageSubmitted|ContactMessageSubmitted|ResidencyRequested|ServiceRequested $event
    ): void {
        try {
            $admins = User::query()
                ->whereNotNull('phone')
                ->where('phone', '!=', '')
                ->pluck('phone')
                ->all();

            if ($admins === []) {
                return;
            }

            $this->sms->send($admins, $this->messageFor($event));
        } catch (\Throwable $th) {
            Log::error('Failed to send SMS to admins', [
                'error' => $th->getMessage(),
                'event' => $event::class,
                'method' => __METHOD__,
            ]);
        }
    }

    private function messageFor(
        ChatbotMessageSubmitted|ContactMessageSubmitted|ResidencyRequested|ServiceRequested $event
    ): string {
        return match (true) {
            $event instanceof ChatbotMessageSubmitted => 'رسالة جديدة من البوت - ' . $event->message->name,
            $event instanceof ContactMessageSubmitted => 'رسالة تواصل جديدة من ' . $event->contactUs->name,
            $event instanceof ResidencyRequested => 'طلب إقامة جديد من ' . $event->requestResidency->name,
            $event instanceof ServiceRequested => 'طلب خدمة جديد من ' . $event->requestService->name,
        };
    }
}
