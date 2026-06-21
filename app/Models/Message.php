<?php

namespace App\Models;

use App\Enum\MessageStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'phone',
    'details',
    'status',
    'service'
])]
class Message extends Model
{
    protected function casts(): array
    {
        return [
            'service' => 'array',
            'status' => MessageStatusEnum::class
        ];
    }
    public function scopeSearch($query, $term)
    {
        return $query->whereAny([
            'name',
            'phone'
        ], 'LIKE', "%$term%");
    }
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
