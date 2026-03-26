<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'email',
    'phone',
    'message',
    'contacted',
])]
class ContactUs extends Model
{
    protected function casts(): array
    {
        return [
            'contacted' => 'boolean',
        ];
    }

    public function scopeContacted($query, $value = true)
    {
        return $query->where('contacted', $value);
    }
}
