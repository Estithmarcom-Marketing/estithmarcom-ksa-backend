<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'title_en',
    'title_ar',
    'description_en',
    'description_ar',
    'slug_en',
    'slug_ar',
    'published',
    'meta_title_en',
    'meta_title_ar',
    'meta_description_en',
    'meta_description_ar',
    'country_id'
])]
class Residency extends Model implements HasMedia
{
    use InteractsWithMedia;
    public function casts()
    {
        return [
            'published' => 'boolean',
        ];
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function scopePublished($query, $value = true)
    {
        return $query->where('published', $value);
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return  $query->whereAny([
            'title_ar',
            'title_en',
            'slug_ar',
            'slug_en'
        ], 'LIKE', $term);
    }
    public function scopeFilterByCountry($query, $country_id)
    {
        return $query->where('country_id', $country_id);
    }
}
