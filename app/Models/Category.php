<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name_en', 'name_ar'])]
class Category extends Model
{
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->whereAny(['name_en', 'name_ar'], 'LIKE', $term);
    }
}
