<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name_ar',
    'name_en',
    'phone',
    'email',
    'facebook',
    'x',
    'instagram',
    'linkedin',
    'whatsapp',
    'snapchat',
    'tiktok',
])]
class Setting extends Model
{
    use HasFactory;

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
