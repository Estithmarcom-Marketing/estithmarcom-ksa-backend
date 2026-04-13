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
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhere('phone', 'like', $term);
        });
    }
}
