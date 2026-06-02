<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable(['title_ar', 'title_en', 'description_ar', 'description_en', 'published', 'service_id'])]
class ServiceFeature extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected function casts()
    {
        return [
            'published' => 'boolean',
        ];
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function scopePublished($query, $value = true)
    {
        return $query->where('published', $value);
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('service_feature')->singleFile();
    }
}
