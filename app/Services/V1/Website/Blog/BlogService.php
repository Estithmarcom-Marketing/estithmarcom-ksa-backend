<?php

namespace App\Services\V1\Website\Blog;

use App\Models\Blog;

class BlogService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;
        $locale = app()->getLocale();
        $search = $data['search'] ?? null;

        return Blog::select('id', "title_$locale as title", "slug_$locale as slug", "short_content_$locale as short_content")
            ->with('media')
            ->published(true)
            ->when($search, fn($q, $v) => $q->search($v))
            ->latest()
            ->paginate($per_page);
    }
    public function show($identifier)
    {
        $locale = app()->getLocale();
        return Blog::select(
            'id',
            "title_$locale as title",
            "subtitle_$locale as subtitle",
            "slug_$locale as slug",
            "short_content_$locale as short_content",
            "content_$locale as content",
            "meta_title_$locale as meta_title",
            "meta_description_$locale as meta_description"
        )
            ->with('media')
            ->published(true)
            ->where(function ($query) use ($identifier) {
                $query->where('slug_en', $identifier)
                    ->orWhere('slug_ar', $identifier)
                    ->orWhere('id', $identifier);
            })
            ->first();
    }
}
