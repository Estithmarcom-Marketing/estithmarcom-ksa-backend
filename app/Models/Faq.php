<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'question_ar',
    'question_en',
    'answer_ar',
    'answer_en',
    'published',
])]
class Faq extends Model
{
    public function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function scopePublished($query, $value = true)
    {
        return $query->where('published', $value);
    }
    public function scopeSearch($query, $term)
    {
        return $query->whereAny([
            'question_ar',
            'question_en',
            'answer_ar',
            'answer_en',
        ], 'LIKE', "%$term%");
    }
}
