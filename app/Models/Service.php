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
    'short_description_en',
    'short_description_ar',
    'long_description_en',
    'long_description_ar',
    'feature_description_ar',
    'feature_description_en',
    'published',
    'meta_title_ar',
    'meta_title_en',
    'meta_description_ar',
    'meta_description_en',
])]
class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected function casts()
    {
        return [
            'published' => 'boolean',
        ];
    }
    public function faqs()
    {
        return $this->morphMany(Faq::class, 'faqable');
    }
    public function features()
    {
        return $this->hasMany(ServiceFeature::class);
    }
    public function scopePublished($query, $value = true)
    {
        return $query->where('published', $value);
    }
    public function requests()
    {
        return $this->hasMany(RequestService::class);
    }
    public function countries()
    {
        return $this->belongsToMany(Country::class)->withTimestamps();
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->whereAny([
            'title_ar',
            'title_en',
        ], 'LIKE', $term);
    }
    public function scopeFilterByCountry($query, $country_id)
    {
        return $query->whereHas('countries', function ($query) use ($country_id) {
            $query->where('country_id', $country_id);
        });
    }
}
