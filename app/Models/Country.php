<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'name_ar',
    'name_en',
    'title_ar',
    'title_en',
    'description_ar',
    'description_en',
    'active',
])]
class Country extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected function casts(): array
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
            $query->where('name_ar', 'like', $term)
                ->orWhere('name_en', 'like', $term);
        });
    }
    public function requests()
    {
        return $this->hasMany(RequestService::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class)->withTimestamps();
    }
}
