<?php

namespace App\Services\V1\Website\StaticPage;

use App\Models\StaticPage;

class StaticPageService
{
    public function list()
    {
        $locale = app()->getLocale() ?? 'ar';
        return StaticPage::select([
            'id',
            "slug_{$locale} as slug",
            "title_{$locale} as title"

        ])
            ->get();
    }
    public function show($identifier)
    {
        $locale = app()->getLocale() ?? 'ar';
        return StaticPage::select([
            'id',
            "title_{$locale} as title",
            "slug_{$locale} as slug",
            "content_{$locale} as content",
            "meta_title_{$locale} as meta_title",
            "meta_description_{$locale} as meta_description",
        ])
            ->where(function ($query) use ($identifier) {
                $query->where('slug_ar', $identifier)
                    ->orWhere('slug_en', $identifier)
                    ->orWhere('id', $identifier);
            })
            ->firstOrFail();
    }
}
