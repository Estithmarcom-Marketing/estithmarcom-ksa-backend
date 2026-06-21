<?php

namespace App\Enum;

enum MessageStatusEnum: string
{
    case PENDING = 'pending';
    case CONTACTED = 'contacted';
    case PROCESSING = 'processing';
    case CANCELED = 'canceled';

    public static function values(): array
    {
        return [
            self::PENDING->value,
            self::CONTACTED->value,
            self::PROCESSING->value,
            self::CANCELED->value
        ];
    }
}
