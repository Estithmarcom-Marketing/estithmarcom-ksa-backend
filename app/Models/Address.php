<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'setting_id',
    'address_ar',
    'address_en',
])]
class Address extends Model
{
    use HasFactory;

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }
}
