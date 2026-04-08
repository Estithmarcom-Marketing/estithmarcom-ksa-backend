<?php

namespace App\Enum;

enum RequestServiceStatusEnum: string
{
    case PENDING = 'pending';
    case CONTACTED = 'contacted';
    case PROCESSING = 'processing';
    case CANCELED = 'canceled';
    case FORWARDED = 'forwarded';

    public static function values(): array
    {
        return [
            self::PENDING->value,
            self::CONTACTED->value,
            self::PROCESSING->value,
            self::CANCELED->value,
            self::FORWARDED->value,
        ];
    }
}
