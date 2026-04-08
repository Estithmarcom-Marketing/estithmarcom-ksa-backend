<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'title_ar',
    'title_en',
    'slug_ar',
    'slug_en',
    'content_ar',
    'content_en',
    'active',
])]
class FreeZone extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected function casts()
    {
        return [
            'active' => 'boolean',
        ];
    }
    public function scopeActive($query, $value = true)
    {
        return $query->where('active', $value);
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('title_ar', 'like', $term)
                ->orWhere('title_en', 'like', $term);
        });
    }
}
