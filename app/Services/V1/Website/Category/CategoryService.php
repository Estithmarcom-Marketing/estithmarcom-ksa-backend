<?php

namespace App\Services\V1\Website\Category;

use App\Models\Category;

class CategoryService
{
    public function listWithoutPagination()
    {
        $locale = app()->getLocale();
        return Category::select([
            'id',
            "name_$locale as name"
        ])
            ->latest()
            ->get();
    }
}
