<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name_ar',
    'name_en',
    'phone',
    'email',
    'address',
    'facebook',
    'x',
    'instagram',
    'linkedin',
    'whatsapp',
    'snapchat',
    'tiktok',
])]
class Setting extends Model {}
