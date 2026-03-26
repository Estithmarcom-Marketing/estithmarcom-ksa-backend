<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'title_ar',
    'title_en',
    'subtitle_ar',
    'subtitle_en',
    'slug_ar',
    'slug_en',
    'short_content_ar',
    'short_content_en',
    'content_ar',
    'content_en',
    'published',
    'meta_title_ar',
    'meta_title_en',
    'meta_description_ar',
    'meta_description_en',
])]
class Blog extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function scopePublished($query, $value = true)
    {
        return $query->where('published', $value);
    }
}
