<?php

namespace App\Enum;

enum NotificationTypeEnum: string
{
    case CONTACT_US = 'contact_us';
    case SUBSCRIPTION = 'subscription';
    case REQUEST_SERVICE = 'request_service';
    case REQUEST_RESIDENCY = 'request_residency';

    public function all(): array
    {
        return [
            self::CONTACT_US->value,
            self::SUBSCRIPTION->value,
            self::REQUEST_SERVICE->value,
            self::REQUEST_RESIDENCY->value
        ];
    }
}
