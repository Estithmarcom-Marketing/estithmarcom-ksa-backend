<?php

namespace App\Models;

use App\Enum\NotificationTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'body',
        'type',
        'is_read',
        'notifiable_id',
        'notifiable_type',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'type' => NotificationTypeEnum::class,
    ];
    public function notifiable()
    {
        return $this->morphTo();
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
