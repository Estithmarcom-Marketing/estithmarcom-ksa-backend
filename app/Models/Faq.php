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
        return $query->where(function ($query) use ($term) {
            $query->where('question_ar', 'like', '%' . $term . '%')
                ->orWhere('question_en', 'like', '%' . $term . '%')
                ->orWhere('answer_ar', 'like', '%' . $term . '%')
                ->orWhere('answer_en', 'like', '%' . $term . '%');
        });
    }
}
